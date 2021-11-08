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

      $allActiveAdmin = $user->getAllActiveUserByType(2);

      foreach($allActiveAdmin as $admin){
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
          'targetReceiver' => $admin->id,
          'triggeredBy' => Auth::id(),
          'status' => 0
        ];
        $audit->insertData($data);
      }

      return Redirect::to('student/crediting')
        ->with('success','Credit Request was successfully submitted!');

    }

    public function detailsPage($slug){
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

      return view('director.details',$data);
    }

    public function updateDetails(Request $request){
      $credit = new Credit;
      $user = new User;
      $files = new Files;
      $course = new Course;
      $subject = new SubjectCrediting;

      if($request->status == 1){
        $data = [
          'status' => $request->status,
          'admin_id' => Auth::id()
        ];
      }else{
        $data = [
          'status' => $request->status,
          'admin_id' => Auth::id(),
          'remarks' => $request->remarks
        ];
      }


      $subject->updateDataByID($request->subject_id,$data);

      return Response::json(array(
          'result' => true
      ));

    }

    public function getCreditRequestStatus(Request $request){
      $subject = new SubjectCrediting;
      $result = $subject->getAllDataBySlugAndByStatus($request->slug,0);
      if(count($result) > 0){
        return Response::json(array(
            'result' => true
        ));
      }else{
        return Response::json(array(
            'result' => false
        ));
      }

    }

    public function updateCreditStatus(Request $request){
      $credit = new Credit;
      $user = new User;
      $files = new Files;
      $course = new Course;
      $subject = new SubjectCrediting;
      $audit = new AuditTrail;

      $data = [
        'status' => 1
      ];

      $credit->updateDataByParamater('slug',$request->input('slug'),$data);

      $creditDatails = $credit->getDataByParameter('slug',$request->input('slug'));

      $data = [
        'slug' => md5($audit->getLastID()),
        'table_name' => 'credit_course',
        'row_id' => $creditDatails->id,
        'targetReceiver' => $creditDatails->student_id,
        'triggeredBy' => Auth::id(),
        'status' => 0
      ];

      $audit->insertData($data);

      $userDetails = $user->getData('id',$creditDatails->student_id);
      try {
        session()->put('slug', $creditDatails->slug);
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

}
