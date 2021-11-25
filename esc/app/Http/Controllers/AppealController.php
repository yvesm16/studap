<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\Appeal;
use App\Models\Files;
use App\Models\AuditTrail;
use App\Models\SubjectCrediting;
use Illuminate\Support\Facades\Input;
use Auth;
use Redirect;
use Session;
use Response;
use App;
use PDF;

class AppealController extends Controller
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

      return view('student.appeal',$data);
    }

    public function postAppeal(Request $request){
      $user = new User;
      $appeal = new Appeal;
      $files = new Files;
      $audit = new AuditTrail;

      $lastID = $appeal->getLastID();

      if($lastID == null){
        $lastID = 1;
      }else{
        $lastID += 1;
      }

      $file_type_1 = $request->input('fileTypeUploaded1') ? $request->input('fileTypeUploaded1') : '';
      $file_type_2 = $request->input('fileTypeUploaded2') ? $request->input('fileTypeUploaded2') : '';
      $file_type_3 = $request->input('others') ? $request->input('others') : '';

      $data = [
        'slug' => md5($lastID),
        'student_id' => Auth::id(),
        'new_course_id' => $request->input('course_id'),
        'concerns' => $request->input('concerns'),
        'section' => $request->input('section'),
        'contact_number' => $request->input('contact_number'),
        'email' => $request->input('email'),
        'attached1' => $file_type_1,
        'attached2' => $file_type_2,
        'attached3' => $file_type_3,
        'status' => 0
      ];

      $appeal->insertData($data);

      $path = $request->file('fileUpload')->store('public/documents');

      $filesLastID = $files->getLastID();
      $appealLastID = $appeal->getLastID();

      if($filesLastID == null){
        $filesLastID = 1;
      }else{
        $filesLastID += 1;
      }

      $data = [
        'slug' => md5($filesLastID),
        'user_id' => Auth::id(),
        'appeal_id' => $appealLastID,
        'path' => $path,
        'type' => 1,
        'status' => 1
      ];

      $files->insertData($data);

      $appeal_details = $appeal->getDataByParameter('id',$appealLastID);

      $auditLastID = $audit->getLastID();
      if($auditLastID == null){
        $auditLastID = 1;
      }else{
        $auditLastID += 1;
      }

      $data = [
        'slug' => md5($auditLastID),
        'table_name' => 'appeal',
        'row_id' => $appeal->getLastID(),
        'targetReceiver' => $this->getTargetReceiver($appeal_details),
        'triggeredBy' => Auth::id(),
        'status' => 0
      ];
      $audit->insertData($data);

      try {
        Session::put('appeal_id', $appealLastID);
        $director_id = $this->getTargetReceiver($appeal_details);
        $directorDetails = $user->getData('id',$director_id);

        \Mail::to($directorDetails->email)->send(new \App\Mail\StudentAppealRequest());
      } catch(Exception $e) {
        return Response::json(array(
            'success' => true
        ));
      }

      return Redirect::to('student/appeal')
        ->with('success','Appeal Request was successfully submitted!');
    }

    private function getTargetReceiver($appeal_details){
      $user = new User;
      $course = new Course;

      $current_user = $user->getData('id',Auth::id());

      if ($current_user->type == 0) {
        $next_target = $course->getCourseByID($appeal_details->new_course_id);
        $next_target_id = $next_target->director;
      } else {
        $next_target_id = $appeal_details->student_id;
      }

      return $next_target_id;
    }

    public function getDirectorAppealDetails(Request $request){
      $user = new User;
      $files = new Files;
      $appeal = new Appeal;
      $audit = new AuditTrail;

      $appointmentDetails = $appeal->getDataBySlug($request->input('appeal_slug'));
      $studentDetails = $user->getData('id',$appointmentDetails->student_id);
      $file_path = $files->getActiveFilesByParameter('appeal_id',$appointmentDetails->id);
      $auditDetails = $audit->getAllDataByParameter('row_id',$appointmentDetails->id, 'table_name', 'appeal');
      
      $appointment_date = '';
      $appointment_time = '';
      // dd($appointmentDetails);
      if ($appointmentDetails->start_time) {
        $appointment_date = explode(' ',$appointmentDetails->start_time)[0];
        $appointment_time = date('h:i A', strtotime(explode(' ',$appointmentDetails->start_time)[1]));

        if ($appointmentDetails->end_time) {
          $appointment_time = $appointment_time . ' - ' . date('h:i A', strtotime(explode(' ',$appointmentDetails->end_time)[1]));
        }
      }
      
      $path = '';
      if ($file_path->path) {
        $path = url(str_replace('public','storage',$file_path->path));
      }

      return Response::json(array(
        'result' => true,
        'appeal_id' => $request->input('appeal_slug'),
        'student_id' => $studentDetails->student_id,
        'student_name' => $studentDetails->fname . ' ' . $studentDetails->lname,
        'transaction_number' => $appointmentDetails->id,
        'status' => $appointmentDetails->status,
        'specific_concern' => $appointmentDetails->concerns,
        'attached1' => $appointmentDetails->attached1,
        'attached2' => $appointmentDetails->attached2,
        'attached3' => $appointmentDetails->attached3,
        'prof_email' => $appointmentDetails->prof_email,
        'message' => $appointmentDetails->message,
        'remarks' => $appointmentDetails->remarks,
        'attached_file_path' => $path,
        'appointment_date' => $appointment_date,
        'appointment_time' => $appointment_time,
        'auditDetails' => $auditDetails,
      ));
    }

    public function postMeeting(Request $request){
      $appeal = new Appeal;
      $user = new User;
      $audit = new AuditTrail;

      $start = date('H:i:s',strtotime($request->start));
      $end = date('H:i:s',strtotime($request->end));

      // dd($request->input());

      if($start < $end){
        $start = $request->date . ' ' . $start;
        $end = $request->date . ' ' . $end;
        $prof_email = '';
        
        if ($request->level == '2' || $request->level == '3') {
          $prof_email = $request->prof_email;
        }

        $data = [
          'message' => $request->message,
          'prof_email' => $prof_email,
          'start_time' => $start,
          'end_time' => $end,
          'status' => 1
        ];
        $appeal->updateDataByID($data,$request->appeal_id);

        $appealDetails = $appeal->getDataByID($request->appeal_id);
        
        if ($request->level == '1') {
          $auditLastID = $audit->getLastID();
          if($auditLastID == null){
            $auditLastID = 1;
          }else{
            $auditLastID += 1;
          }

          $data = [
            'slug' => md5($auditLastID),
            'table_name' => 'appeal',
            'row_id' => $request->appeal_id,
            'targetReceiver' => $this->getTargetReceiver($appealDetails),
            'triggeredBy' => Auth::id(),
            'status' => 0
          ];
          $audit->insertData($data);
        }

        Session::put('appeal_id', $request->appeal_id);
  
        try {
          $appealDetails = $appeal->getDataByID($request->appeal_id);
          $studentDetails = $user->getData('id',$appealDetails->student_id);
          if ($request->level == '1') {
            \Mail::to($studentDetails->email)->send(new \App\Mail\StudentAppealMeeting());
          } else if ($request->level == '2') {
            \Mail::to($prof_email)->send(new \App\Mail\StudentAppealMeetingForProf());
          } else {
            \Mail::to($studentDetails->email)->send(new \App\Mail\StudentAppealMeeting());
            \Mail::to($prof_email)->send(new \App\Mail\StudentAppealMeetingForProf());
          }
        } catch(Exception $e) {
          return Response::json(array(
              'success' => true
          ));
        }
      }else{
        return back()->with('result',false)->with('text', 'Invalid start and end time!');
      }

      return back()->with('result',true);
    }

    public function updateAppealStatus(Request $request){
      $appeal = new Appeal;
      $audit = new AuditTrail;
      $user = new User;

      $appointmentDetails = $appeal->getDataBySlug($request->input('appeal_slug'));
      $studentDetails = $user->getData('id',$appointmentDetails->student_id);

      if($request->input('status') == 3){
        $data = [
          'remarks' => $request->input('reasonDetails'),
          'status' => $request->input('status')
        ];

        Session::put('appeal_id', $appointmentDetails->id);
        Session::put('remarks', $request->input('reasonDetails'));

        try {
          \Mail::to($studentDetails->email)->send(new \App\Mail\RejectStudentAppeal());
        } catch(Exception $e) {
          return Response::json(array(
              'success' => true
          ));
        }
      }else{
        $data = [
          'status' => $request->input('status')
        ];

        Session::put('appeal_id', $appointmentDetails->id);

        try {
          \Mail::to($studentDetails->email)->send(new \App\Mail\UpdateStudentAppeal());
        } catch(Exception $e) {
          return Response::json(array(
              'success' => true
          ));
        }
      }

      $appeal->updateDataByID($data,$appointmentDetails->id);

      $auditLastID = $audit->getLastID();
      if($auditLastID == null){
        $auditLastID = 1;
      }else{
        $auditLastID += 1;
      }

      $data = [
        'slug' => md5($auditLastID),
        'table_name' => 'appeal',
        'row_id' => $appointmentDetails->id,
        'targetReceiver' => $this->getTargetReceiver($appointmentDetails),
        'triggeredBy' => Auth::id(),
        'status' => 0
      ];
      $audit->insertData($data);

      return Response::json(array(
          'result' => true
      ));
    }

    public function getTrackerAppeal(){
      $user = new User;
      $appeal = new Appeal;
      $userDetails = $user->getData('id',Auth::id());

      $data = [
        'id' => Auth::id(),
        'fname' => $userDetails->fname,
        'lname' => $userDetails->lname,
        'user_type' => $userDetails->type,
        'pending' => $appeal->getAppealByStatusByStudentID(0),
        'scheduled' => $appeal->getAppealByStatusByStudentID(1),
        'completed' => $appeal->getAppealByStatusByStudentID(2),
        'declined' => $appeal->getAppealByStatusByStudentID(3)
      ];

      return view('student.appealTracker',$data);
    }

    public function completedStudentAppealListPDF(){
      $appeal = new Appeal;
      $user = new User;

      $userDetails = $user->getData('id',Auth::id());
      $appealDetails = $appeal->getDataTableForPDF(2);

      $data = [
        'fname' => $userDetails->fname,
        'lname' => $userDetails->lname,
        'generated_on' => $date = date("M d, Y"),
        'appealDetails' => $appealDetails
      ];

      // dd($appealDetails);

      $pdf = PDF::loadView('global.completedStudentAppealPDF', $data);
      // return $pdf->stream();
      return $pdf->download($userDetails->slug . '.pdf');
      // return view('global.completedStudentAppealPDF',$data);
    }
}
