<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\Credit;
use App\Models\Files;
use App\Models\AuditTrail;
use App\Models\SubjectCrediting;
use Illuminate\Support\Facades\Input;
use Auth;
use Redirect;
use Response;
use App;
use PDF;

class CreditController extends Controller
{
    public function studentForm(Request $request){
      $user = new User;
      $course = new Course;

      $userDetails = $user->getData('id',Auth::id());
      $courseDetails = $course->getCourseByID($userDetails->course_id);
      $allCourse = $course->getAllActiveCourse();

      $data = [
        'id' => Auth::id(),
        'fname' => $userDetails->fname,
        'lname' => $userDetails->lname,
        'email' => $userDetails->email,
        'student_id' => $userDetails->student_id,
        'allCourse' => $allCourse,
        'course' => $courseDetails->text
      ];

      return view('student.credit',$data);
    }

    public function postCredit(Request $request){
      $user = new User;
      $credit = new Credit;
      $subject = new SubjectCrediting;
      $files = new Files;
      $audit = new AuditTrail;

      $lastID = $credit->getLastID();

      if($lastID == null){
        $lastID = 1;
      }else{
        $lastID += 1;
      }

      $data = [
        'slug' => md5($lastID),
        'student_id' => Auth::id(),
        'new_course_id' => $request->input('course_id'),
        'concerns' => $request->input('concerns'),
        'section' => $request->input('section'),
        'contact_number' => $request->input('contact_number'),
        'email' => $request->input('email'),
        'institute' => $request->input('institute'),
        'status' => 0
      ];

      $credit->insertData($data);

      for($i = 0; $i < count($request->input('course_abbr')); $i++){
        $subjectLastID = $subject->getLastID();
        $creditLastID = $credit->getLastID();

        if($subjectLastID == null){
          $subjectLastID = 1;
        }else{
          $subjectLastID += 1;
        }

        $data = [
          'slug' => md5($subjectLastID),
          'credit_course_id' => $creditLastID,
          'course_abbr' => $request->input('course_abbr')[$i],
          'course_title' => $request->input('course_title')[$i],
          'equivalent_course_abbr' => $request->input('equivalent_course_abbr')[$i],
          'equivalent_course_title' => $request->input('equivalent_course_title')[$i],
          'status' => 0
        ];

        $subject->insertData($data);
      }

      $path = $request->file('fileUpload')->store('public/documents');

      $filesLastID = $files->getLastID();
      $creditLastID = $credit->getLastID();

      if($filesLastID == null){
        $filesLastID = 1;
      }else{
        $filesLastID += 1;
      }

      $data = [
        'slug' => md5($filesLastID),
        'user_id' => Auth::id(),
        'credit_course_id' => $creditLastID,
        'path' => $path,
        'type' => 1,
        'status' => 1
      ];

      $files->insertData($data);

      $credit_details = $credit->getDataByParameter('id',$creditLastID);

      $auditLastID = $audit->getLastID();
      if($auditLastID == null){
        $auditLastID = 1;
      }else{
        $auditLastID += 1;
      }
      $data = [
        'slug' => md5($auditLastID),
        'table_name' => 'credit_course',
        'row_id' => $credit->getLastID(),
        'targetReceiver' => $this->getTargetReceiver($credit_details),
        'triggeredBy' => Auth::id(),
        'status' => 0
      ];
      $audit->insertData($data);

      return Redirect::to('student/crediting')
        ->with('success','Credit Request was successfully submitted!');

    }

    private function isProfessorChairperson($id){
      $course = new Course;
      $course_details = $course->getChairperson($id);

      return $course_details ? true : false;
    }

    private function detailsPage($slug){
      $credit = new Credit;
      $user = new User;
      $files = new Files;
      $course = new Course;
      $subject = new SubjectCrediting;
      $userDetails = $user->getData('id',Auth::id());
      $directorSignature = $files->getAllActiveFileByUserByParameter('type',0);
      $creditDetails = $credit->getDataByParameter('slug',$slug);
      $studentDetails = $user->getData('id',$creditDetails->student_id);

      // dd($_SERVER['REQUEST_URI']);

      $a = $_SERVER['REQUEST_URI'];

      if (strpos($a, 'pdf') !== false) {
        $allSubjects = $subject->getAllDataByCreditIDPDF($creditDetails->id);
      }else{
        $allSubjects = $subject->getAllDataByCreditID($creditDetails->id);
      }

      $data = [
        'id' => Auth::id(),
        'fname' => $userDetails->fname,
        'lname' => $userDetails->lname,
        'signature' => $directorSignature,
        'studentDetails' => $studentDetails,
        'newCourse' => $course->getCourseByID($creditDetails->new_course_id),
        'currentCourse' => $course->getCourseByID($studentDetails->course_id),
        'creditDetails' => $creditDetails,
        'allSubjects' => $allSubjects
      ];
      // dd($data);
      return $data;
    }
    
    public function chairpersonCreditDetailsPage($slug){
      $data = $this->detailsPage($slug);
      
      $data['isProfessorChairperson'] = $this->isProfessorChairperson(Auth::id());

      return view('professor.details',$data);
    }

    public function directorCreditDetailsPage($slug){
      $data = $this->detailsPage($slug);
      return view('director.details',$data);
    }

    public function updateDetails(Request $request){
      $credit = new Credit;
      $user = new User;
      $files = new Files;
      $course = new Course;
      $subject = new SubjectCrediting;

      $data = [
        'status' => $request->status,
        'admin_id' => Auth::id()
      ];

      if($request->status == 5){
        $data['remarks'] = $request->remarks;
      }

      $subject->updateDataByID($request->subject_id,$data);

      return Response::json(array(
          'result' => true
      ));
    }

    public function getSubjectCreditStatus(Request $request){
      $credit = new Credit;
      $subject = new SubjectCrediting;
      // $request->status = 0-Pending|1-EvaluatedByProfessor|2-EvaluatedByDirector|3-CheckedBySecretary|4-EvaluatedByRegistrar|5-Done
      $all_approved_subject = $subject->getAllDataByCreditSlugAndSubjectStatus($request->slug,$request->status);
      $credit_details = $credit->getDataByParameter('slug',$request->slug);

      if(count($all_approved_subject) == 0 && $credit_details->status < $request->status+1){
        return Response::json(array(
            'result' => false
        ));
      }else{
        return Response::json(array(
            'result' => true
        ));
      }
    }

    private function getTargetReceiver($credit_details){
      $user = new User;
      $course = new Course;

      $current_user = $user->getData('id',Auth::id());

      if ($current_user->type == 0) {
        $next_target = $course->getCourseByID($current_user->course_id);
        $next_target_id = $next_target->chairperson;
      } else if ($current_user->type == 1) {
        $next_target = $course->getChairperson(Auth::id());
        $next_target_id = $next_target->director;
      } else if ($current_user->type == 2) {
        $next_target = $course->getSecretary(Auth::id());
        $next_target_id = $next_target->secretary;
      } else if ($current_user->type == 3) {
        $next_target = $user->getData('type',4);
        $next_target_id = $next_target->id;
      } else {
        $next_target_id = $credit_details->student_id;
      }

      return $next_target_id;
    }

    private function updateCreditStatusInsertAudit($credit_details){
      $audit = new AuditTrail;
      $user = new User;
      $userDetails = $user->getData('id',Auth::id());

      $data = [
        'slug' => md5($audit->getLastID()),
        'table_name' => 'credit_course',
        'row_id' => $credit_details->id,
        'targetReceiver' => $this->getTargetReceiver($credit_details),
        'triggeredBy' => Auth::id(),
        'status' => 0
      ];

      $audit->insertData($data);
    }

    public function updateCreditStatus(Request $request){
      $credit = new Credit;
      $user = new User;
      $files = new Files;
      $subject = new SubjectCrediting;

      $data = [
        'status' => $request->status
      ];

      $credit->updateDataByParamater('slug',$request->slug,$data);

      $credit_details = $credit->getDataByParameter('slug',$request->slug);
      
      $this->updateCreditStatusInsertAudit($credit_details);
      $userDetails = $user->getData('id',$credit_details->student_id);

      try {
        session()->put('slug', $credit_details->slug);
        session()->put('fname', $userDetails->fname);
        session()->put('lname', $userDetails->lname);

        \Mail::to($userDetails->email)->send(new \App\Mail\CreditCourse());
        // \Mail::to('joseph.fidelino@gmail.com')->send(new \App\Mail\CreditCourse());
      } catch(Exception $e) {
        return Response::json(array(
            'success' => true
        ));
      }

      return Response::json(array(
          'result' => true
      ));
    }

    public function detailsPagePDF($slug){
      $credit = new Credit;
      $user = new User;
      $files = new Files;
      $course = new Course;
      $subject = new SubjectCrediting;
      $userDetails = $user->getData('id',Auth::id());
      $directorSignature = $files->getAllActiveFileByUserByParameter('type',0);
      $creditDetails = $credit->getDataByParameter('slug',$slug);
      $studentDetails = $user->getData('id',$creditDetails->student_id);
      $a = $_SERVER['REQUEST_URI'];
      if (strpos($a, 'pdf') !== false) {
        $allSubjects = $subject->getAllDataByCreditIDPDF($creditDetails->id);
      }else{
        $allSubjects = $subject->getAllDataByCreditID($creditDetails->id);
      }

      $data = [
        'id' => Auth::id(),
        'fname' => $userDetails->fname,
        'lname' => $userDetails->lname,
        'signature' => $directorSignature,
        'studentDetails' => $studentDetails,
        'newCourse' => $course->getCourseByID($creditDetails->new_course_id),
        'currentCourse' => $course->getCourseByID($studentDetails->course_id),
        'creditDetails' => $creditDetails,
        'allSubjects' => $allSubjects
      ];

      // dd($allSubjects);

      $pdf = PDF::loadView('director.pdf', $data);
      // return $pdf->stream();
      return $pdf->download($creditDetails->slug . '.pdf');
    }

    public function getTrackerCrediting() {
      $user = new User;
      $credit = new Credit;
      $userDetails = $user->getData('id',Auth::id());

      $data = [
        'id' => Auth::id(),
        'fname' => $userDetails->fname,
        'lname' => $userDetails->lname,
        'pending' => $credit->countByStatus(0),
        'completed' => $credit->countByStatus(1)
      ];

      return view('student.creditTracker',$data);
    }

    public function getStudentCreditDetails(Request $request) {
      $user = new User;
      $credit = new Credit;
      $course = new Course;
      $audit = new AuditTrail;

      $creditDetails = $credit->getDataByParameter('id', $request->input('credit_course_id'));

      $studentDetails = $user->getData('id',$creditDetails->student_id);
      $remarks = $this->getSubjectCreditingDisapprovedWithRemarks($request->input('credit_course_id'));

      $auditDetails = $audit->getAllDataByParameter('row_id',$request->input('credit_course_id'), 'table_name', 'credit_course');
      // dd($creditDetails);
      return Response::json(array(
          'result' => true,
          'credit_course_id' => $request->input('credit_course_id'),
          'student_name' => $studentDetails->fname . ' ' . $studentDetails->lname,
          'institute' => $creditDetails->institute,          
          'new_program' => $course->getCourseByID($creditDetails->new_course_id),
          'original_program' => $course->getCourseByID($studentDetails->course_id),
          'remarks' => $remarks,
          'auditDetails' => $auditDetails,
          'status' => $creditDetails->status
      ));
    }

    private function getSubjectCreditingDisapprovedWithRemarks($credit_course_id) {
      $subject = new SubjectCrediting;
      $subject_details = $subject->getAllDataCreditIDAndByStatus($credit_course_id,0);
      $remarks = [];

      foreach($subject_details as $key => $subject_detail) {
        $remarks[$key] = $subject_detail->course_abbr . ' - ' . $subject_detail->remarks;
      }
      
      if ($remarks) {
        array_unshift($remarks,"Denied:");
      }

      return $remarks = $remarks ? $remarks : '';
    }

    // public function trackerCreditingDetailsPage($slug) {
    //   $credit = new Credit;
    //   $user = new User;
    //   $files = new Files;
    //   $course = new Course;
    //   $subject = new SubjectCrediting;
    //   $userDetails = $user->getData('id',Auth::id());
    //   $directorSignature = $files->getAllActiveFileByUserByParameter('type',0);
    //   $creditDetails = $credit->getDataByParameter('slug',$slug);
    //   $studentDetails = $user->getData('id',$creditDetails->student_id);

    //   // dd($_SERVER['REQUEST_URI']);
    //   if ($creditDetails->status == 1) {
    //     $allSubjects = $subject->getAllDataBySlug($slug);
    //   }else{
    //     $allSubjects = $subject->getAllDataByCreditID($creditDetails->id);
    //   }
      

    //   $data = [
    //     'id' => Auth::id(),
    //     'fname' => $userDetails->fname,
    //     'lname' => $userDetails->lname,
    //     'signature' => $directorSignature,
    //     'studentDetails' => $studentDetails,
    //     'newCourse' => $course->getCourseByID($creditDetails->new_course_id),
    //     'currentCourse' => $course->getCourseByID($studentDetails->course_id),
    //     'creditDetails' => $creditDetails,
    //     'allSubjects' => $allSubjects
    //   ];

    //   // dd($allSubjects);
    //   return view('student.creditDetails',$data);
    // }

}
