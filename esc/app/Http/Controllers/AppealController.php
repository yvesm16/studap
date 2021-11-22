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
}
