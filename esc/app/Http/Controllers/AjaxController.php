<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SubjectCrediting;
use App\Models\Schedule;
use App\Models\Concerns;
use App\Models\Credit;
use App\Models\Appeal;
use Auth;

class AjaxController extends Controller
{
  public function ajax(Request $request){
        $user = new User;
        $subject_crediting = new SubjectCrediting;
        $schedule = new Schedule;
        $concerns = new Concerns;
        $credit = new Credit;
        $appeal = new Appeal;
        $type = $request->input('type');
        switch($type){
            case "studentConsultationList":
                $dtResult = Helpers::setDatatable($schedule->getDataTable(Auth::id()),array('fname','lname'));

                foreach($dtResult['objResult'] as $aRow) {

                    $button = "<button class='btn btn-default viewDetails' data-id='$aRow->id'>View Details</button>";

                    if($aRow->status == 0){
                      $status = "<span class='label label-default'>Pending</span>";
                    }elseif($aRow->status == 1){
                      $status = "<span class='label label-info'>Approved</span>";
                    }elseif($aRow->status == 2){
                      $status = "<span class='label label-danger'>Disapproved</span>";
                    }elseif($aRow->status == 3){
                      $status = "<span class='label label-warning'>Ongoing</span>";
                    }else{
                      $status = "<span class='label label-success'>Completed</span>";
                    }

                    $data = array(
                        $aRow->created_at,
                        $aRow->start_time,
                        $aRow->fname . ' ' . $aRow->lname,
                        $status,
                        $button
                    );
                    $dtResult['aaData'][] = $data;
                }
                unset($dtResult['objResult']);
                echo json_encode($dtResult);
                break;

            case "professorSlotList":
                $dtResult = Helpers::setDatatable($schedule->getSlotDataTable(Auth::id()),array('title','start_time','end_time'));

                foreach($dtResult['objResult'] as $aRow) {

                    if($aRow->status == 1){
                      $status = "<span class='label label-success'>Active</span>";
                      $button = "
                      <button class='btn btn-default updateSlot' data-id='$aRow->id'>Update</button>
                      <button class='btn btn-warning updateStatus' data-id='$aRow->id'>Deactivate</button>
                      ";
                    }else{
                      $status = "<span class='label label-danger'>Inactive</span>";
                      $button = "
                      <button class='btn btn-info updateStatus' data-id='$aRow->id'>Activate</button>
                      ";
                    }

                    $data = array(
                        $aRow->title,
                        $aRow->start_time,
                        $aRow->end_time,
                        $status,
                        $button
                    );
                    $dtResult['aaData'][] = $data;
                }
                unset($dtResult['objResult']);
                echo json_encode($dtResult);
                break;

            case "professorConsultationList":
                $dtResult = Helpers::setDatatable($schedule->getAppointmentRequest($request->input('status')),array('professor_schedule.id','users.fname','users.lname','users.email',explode(' ','professor_schedule.start_time')[0]));

                foreach($dtResult['objResult'] as $aRow) {

                    if($aRow->status == 0){ //pending
                      $status = "<span class='label label-default'>Pending</span>";
                      $button = "
                      <button class='btn btn-default viewDetails' data-id='$aRow->id'><span class='glyphicon glyphicon-search'></span></button>
                      <button class='btn btn-primary approvedAppointment' data-id='$aRow->id'><span class='glyphicon glyphicon-ok'></span></button>
                      <button class='btn btn-danger disapproveAppointment' data-id='$aRow->id'><span class='glyphicon glyphicon-remove'></button>
                      ";
                    }elseif($aRow->status == 1){ //approved
                      $status = "<span class='label label-info'>Approved</span>";
                      $button = "
                      <button class='btn btn-default viewDetails' data-id='$aRow->id'><span class='glyphicon glyphicon-search'></span></button>
                      <button class='btn btn-info startAppointment' data-id='$aRow->id'><span class='glyphicon glyphicon-ok-sign'></span></button>
                      ";
                    }elseif($aRow->status == 2){ //rejected
                      $status = "<span class='label label-danger'>Disapproved</span>";
                      $button = "
                      <button class='btn btn-default viewDetails' data-id='$aRow->id'><span class='glyphicon glyphicon-search'></span></button>
                      ";
                    }elseif($aRow->status == 3){ //ongoing
                      $status = "<span class='label label-warning'>Ongoing</span>";
                      $button = "
                      <button class='btn btn-default viewDetails' data-id='$aRow->id'><span class='glyphicon glyphicon-search'></span></button>
                      <button class='btn btn-success endAppointment' data-id='$aRow->id'><span class='glyphicon glyphicon-minus-sign'></span></button>
                      ";
                    }else{
                      $status = "<span class='label label-success'>Completed</span>";
                      $button = "
                      <button class='btn btn-default viewDetails' data-id='$aRow->id'><span class='glyphicon glyphicon-search'></span></button>
                      ";
                    }

                    $concernDetails = '';
                    $concernOthers = '';
                    if(count(explode(';',$aRow->concerns)) == 1){
                      if($concerns->getDataByID($aRow->concerns)->text == 'Others'){
                        $concernOthers = ': ' . $aRow->concerns_others;
                      }
                      $concernDetails = $concerns->getDataByID($aRow->concerns)->text . '' . $concernOthers;
                    }else{
                      $i = 1;
                      foreach(explode(';',$aRow->concerns) as $c){
                        if($i <> count(explode(';',$aRow->concerns))){
                          if($concerns->getDataByID($c)->text == 'Others'){
                            $concernOthers = ': ' . $aRow->concerns_others;
                          }
                          $concernDetails = $concernDetails . '' . $concerns->getDataByID($c)->text . '' . $concernOthers . '<br>';
                        }else{
                          if($concerns->getDataByID($c)->text == 'Others'){
                            $concernOthers = ': ' . $aRow->concerns_others;
                          }
                          $concernDetails = $concernDetails . '' . $concerns->getDataByID($c)->text . '' . $concernOthers;
                        }
                        $i++;
                      }
                    }

                    $date = explode(' ',$aRow->start_time)[0] . '<br>' . date('h:i a', strtotime(explode(' ',$aRow->start_time)[1])) . '-' . date('h:i a', strtotime(explode(' ',$aRow->end_time)[1]));

                    $data = array(
                        $aRow->id,
                        $aRow->fname . ' ' . $aRow->lname,
                        $aRow->email,
                        explode(' ',$aRow->start_time)[0] . ' ' ,
                        date('h:i a', strtotime(explode(' ',$aRow->start_time)[1])),
                        date('h:i a', strtotime(explode(' ',$aRow->end_time)[1])),
                        "<div style='text-align: left'>" . $concernDetails . "</div>",
                        $status,
                        $button
                    );
                    $dtResult['aaData'][] = $data;
                }
                unset($dtResult['objResult']);
                echo json_encode($dtResult);
                break;

              case "courseCreditList":
                  if ($request->input('status') == 'completed') {
                    $dtResult = Helpers::setDatatable($credit->getCompletedDataTable($request->input('minimum_status')),array('users.fname','users.lname','users.email'));
                  } else if ($request->input('status') == 'chairperson_completed') {
                    $dtResult = Helpers::setDatatable($credit->getChairpersonCompletedDataTable($request->input('minimum_status')),array('users.fname','users.lname','users.email'));
                  } else if ($request->input('status') == 0) {
                    $dtResult = Helpers::setDatatable($credit->getChairpersonDataTable($request->input('status')),array('users.fname','users.lname','users.email'));
                  } else {
                    $dtResult = Helpers::setDatatable($credit->getDataTable($request->input('status')),array('users.fname','users.lname','users.email'));
                  }

                  foreach($dtResult['objResult'] as $aRow) {
                    $subject_crediting_details = $subject_crediting->getAllDataByCreditID($aRow->id);
                    $course_abbr = '';
                    $course_title = '';

                    foreach($subject_crediting_details as $subject_crediting_detail) {
                      $course_abbr = $course_abbr . $subject_crediting_detail->course_abbr . '<br>';
                      $course_title = $course_title . $subject_crediting_detail->course_title . '<br>';
                    }

                    $button = "<button class='btn btn-default viewDetails' data-id='$aRow->slug'>View Details</button>";

                    $data = array(
                      $aRow->id,
                      $aRow->student_id,
                      $aRow->fname . ' ' . $aRow->lname,
                      $course_abbr,
                      $course_title,
                      $aRow->section,
                      $button
                    );
                    $dtResult['aaData'][] = $data;
                  }
                  unset($dtResult['objResult']);
                  echo json_encode($dtResult);
                  break;

              case "studentAppealList":
                  if ($request->input('status') == 'completed') {
                    $dtResult = Helpers::setDatatable($appeal->getCompletedDataTable(),array('users.fname','users.lname','users.email'));
                  } else if (($request->input('status') == 'pending')) {
                    $dtResult = Helpers::setDatatable($appeal->getDataTableByStatus(0),array('users.fname','users.lname','users.email'));
                  } else if (($request->input('status') == 'declined')) {
                    $dtResult = Helpers::setDatatable($appeal->getDataTableByStatus(3),array('users.fname','users.lname','users.email'));
                  } else {
                    $dtResult = Helpers::setDatatable($appeal->getDataTableByStatus(1),array('users.fname','users.lname','users.email'));
                  }

                  foreach($dtResult['objResult'] as $aRow) {
                      
                      if($aRow->status == 0){ //pending
                        $button = "
                        <button class='btn btn-default viewDetails' data-id='$aRow->slug'><span class='glyphicon glyphicon-search'></span></button>
                        <button class='btn btn-primary evaluate' data-id='$aRow->slug'><span class='glyphicon glyphicon-eye-open'></span></button>
                        ";
                      }elseif($aRow->status == 1){ //scheduled
                        $button = "
                        <button class='btn btn-default viewDetails' data-id='$aRow->slug'><span class='glyphicon glyphicon-search'></span></button>
                        <button class='btn btn-primary evaluate' data-id='$aRow->slug'><span class='glyphicon glyphicon-eye-open'></span></button>
                        <button class='btn btn-info evaluate2' data-id='$aRow->slug'><span class='glyphicon glyphicon-eye-open'></span></button>
                        <button class='btn btn-warning evaluate3' data-id='$aRow->slug'><span class='glyphicon glyphicon-eye-open'></span></button>
                        <button class='btn btn-success acceptAppeal' data-id='$aRow->slug'><span class='glyphicon glyphicon-ok-sign'></span></button>
                        <button class='btn remarks' data-id='$aRow->slug'><span class='glyphicon glyphicon-bookmark'></span></button>
                        ";
                      }else{
                        $button = "
                        <button class='btn btn-default viewDetails' data-id='$aRow->slug'><span class='glyphicon glyphicon-search'></span></button>
                        <button class='btn btn-primary evaluate' data-id='$aRow->slug'><span class='glyphicon glyphicon-eye-open'></span></button>
                        <button class='btn btn-info evaluate2' data-id='$aRow->slug'><span class='glyphicon glyphicon-eye-open'></span></button>
                        <button class='btn btn-warning evaluate3' data-id='$aRow->slug'><span class='glyphicon glyphicon-eye-open'></span></button>
                        ";
                      }

                      $data = array(
                          $aRow->id,
                          $aRow->student_id,
                          $aRow->fname . ' ' . $aRow->lname,
                          $aRow->email,
                          $aRow->section,
                          $aRow->program,
                          $aRow->prof_email ? $aRow->prof_email : '',
                          $aRow->concerns ? $aRow->concerns : '',
                          $button
                      );
                      $dtResult['aaData'][] = $data;
                  }
                  unset($dtResult['objResult']);
                  echo json_encode($dtResult);
                  break;

              case "studentAppealListTracker":
                  $dtResult = Helpers::setDatatable($appeal->getAllDataTableByStudentID(),array('appeal.concerns','appeal.section'));

                  foreach($dtResult['objResult'] as $aRow) {
                    $button = "<button class='btn btn-default viewDetails' data-id='$aRow->slug'>View Details</button>";
                    
                    if($aRow->status == 0){
                      $status = "<span class='label label-default'>Pending</span>";
                    }else if($aRow->status == 2){
                      $status = "<span class='label label-success'>Completed</span>";
                    }else if($aRow->status == 3){
                      $status = "<span class='label label-danger'>Declined</span>";
                    }else{
                      $status = "<span class='label label-primary'>Scheduled</span>";
                    }

                      $data = array(
                          $aRow->concerns,
                          $aRow->section,
                          $aRow->program,
                          $status,
                          $button
                      );
                      $dtResult['aaData'][] = $data;
                  }
                  unset($dtResult['objResult']);
                  echo json_encode($dtResult);
                  break;

              case "studentCreditList":
                  $dtResult = Helpers::setDatatable($credit->getStudentDataTable(Auth::id()),array('concerns','institute','credit_course.created_at','credit_course.status'));

<<<<<<< HEAD
                  foreach($dtResult['objResult'] as $aRow) {
=======
                  foreach($dtResult['objResult'] as $aRow) { 
                    $subject_crediting_details = $subject_crediting->getAllDataByCreditID($aRow->id);
                    $course_title = '';
                    $equivalent_course_title = '';
>>>>>>> 52ca5ad2f4d81452cf460da78548907ebff3fa76

                    foreach($subject_crediting_details as $subject_crediting_detail) {
                      $course_title = $course_title . $subject_crediting_detail->course_title . '<br>';
                      $equivalent_course_title = $equivalent_course_title . $subject_crediting_detail->equivalent_course_title . '<br>';
                    }

                    $button = "<button class='btn btn-default viewDetails' data-id='$aRow->id'>View Details</button>";

<<<<<<< HEAD
                      $data = array(
                          $aRow->id,
                          $aRow->concerns,
                          $aRow->institute,
                          $aRow->created_at,
                          $status,
                          $button
                      );
                      $dtResult['aaData'][] = $data;
=======
                    if($aRow->status == 0){
                      $status = "<span class='label label-default'>Pending</span>";
                    }else if($aRow->status > 2){
                      $status = "<span class='label label-success'>Completed</span>";
                    }else{
                      $status = "<span class='label label-primary'>Ongoing</span>";
                    }

                    $data = array(
                        $aRow->id,
                        $aRow->concerns,
                        $aRow->institute,
                        $course_title,
                        $equivalent_course_title,
                        $aRow->created_at,
                        $status,
                        $button
                    );
                    $dtResult['aaData'][] = $data;
>>>>>>> 52ca5ad2f4d81452cf460da78548907ebff3fa76
                  }
                  unset($dtResult['objResult']);
                  echo json_encode($dtResult);
                  break;


        }
    }
}
