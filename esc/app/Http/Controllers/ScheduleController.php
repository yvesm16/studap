<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Schedule;
use App\Models\Concerns;
use App\Models\AuditTrail;
use Mailgun\Mailgun;
use Redirect;
use Hash;
use DB;
use Session;
use Response;
use Auth;

class ScheduleController extends Controller
{

    public function studentSchedule(Request $request){
      $user = new User;
      $concerns = new Concerns;
      $userDetails = $user->getData('id',Auth::id());

      $allProfessor = $user->getAllDataByParameter('type',1);

      $data = [
        'id' => Auth::id(),
        'fname' => $userDetails->fname,
        'lname' => $userDetails->lname,
        'allProfessor' => $allProfessor,
        'allActiveConcerns' => $concerns->getAllDataByStatus(1)
      ];

      return view('student.schedule',$data);
    }

    public function getProfessorSchedule(Request $request){
      $schedule = new Schedule;

      $scheduleList = $schedule->getAllApprovedScheduleByParameter('professor_id',$request->professorID);

      return Response::json(array(
          'result' => $scheduleList,
      ));

    }

    public function trackerConsultation(){
      $user = new User;
      $schedule = new Schedule;
      $userDetails = $user->getData('id',Auth::id());

      $data = [
        'id' => Auth::id(),
        'fname' => $userDetails->fname,
        'lname' => $userDetails->lname,
        'user_type' => $userDetails->type,
        'pending' => $schedule->getCountByStatus(0,'student_id'),
        'approved' => $schedule->getCountByStatus(1,'student_id'),
        'completed' => $schedule->getCountByStatus(4,'student_id'),
        'disapproved' => $schedule->getCountByStatus(2,'student_id')
      ];

      return view('student.tracker',$data);
    }

    public function postConsultation(Request $request){

      $schedule = new Schedule;
      $concerns = new Concerns;
      $audit = new AuditTrail;

      $appointment_start = date('H:i:s',strtotime($request->input('appointment_start')));
      $appointment_end = date('H:i:s',strtotime($request->input('appointment_end')));

      if($request->input('professor_id') == '' || $request->input('appointment_date') == '' || $request->input('appointment_start') == '' || $request->input('appointment_end') == '' || $request->input('concerns') == ''){
        return Response::json(array(
            'result' => false,
            'text' => 'All fields are required!'
        ));
      }else{
        if($appointment_start < $appointment_end){

          $start = $request->input('appointment_date') . ' ' . $appointment_start;
          $end = $request->input('appointment_date') . ' ' . $appointment_end;

          $slotExist = $schedule->checkSlotOverlap($start,'student_id',Auth::id());

          if($slotExist > 0){
            return Response::json(array(
                'result' => false,
                'text' => 'Slot schedule overlap!'
            ));
          }else{

            if($schedule->getLastID() == null){
              $lastID = $schedule->getLastID() + 1;
            }else{
              $lastID = 1;
            }

            $concernList = '';
            $concernText = '';

            $i = 0;
            $len = count($request->input('concerns'));

            if($len > 0){

              foreach($request->input('concerns') as $concern_id){
                if($i == $len - 1){
                  $concernList = $concernList . $concern_id;
                }else{
                  $concernList = $concernList . $concern_id . ';';
                }
                $concernDetails = $concerns->getDataByID($concern_id);
                if($concernDetails->text == 'Others'){
                  $concernText = $request->input('othersText');
                }
                $i++;
              }

              $data = [
                'slug' => md5($lastID),
                'professor_id' => intval($request->input('professor_id')),
                'student_id' => Auth::id(),
                'title' => 'Appointment',
                'start_time' => $start,
                'end_time' => $end,
                'concerns' => $concernList,
                'concerns_others' => $concernText,
                'status' => 0
              ];

              $schedule->insertData($data);

              $data = [
                'slug' => md5($schedule->getLastID()),
                'table_name' => 'professor_schedule',
                'row_id' => $schedule->getLastID(),
                'targetReceiver' => intval($request->input('professor_id')),
                'triggeredBy' => Auth::id(),
                'status' => 0
              ];

              $audit->insertData($data);

              return Response::json(array(
                  'result' => true
              ));

            }else{
              return Response::json(array(
                  'result' => false,
                  'text' => 'Check at least 1 concern.'
              ));
            }
          }
        }else{
          return Response::json(array(
              'result' => false,
              'text' => 'Invalid start and end time!'
          ));
        }
      }
    }

    public function getUserSchedule(Request $request){
      $user = new User;
      $userDetails = $user->getData('id',Auth::id());

      $data = [
        'id' => Auth::id(),
        'fname' => $userDetails->fname,
        'lname' => $userDetails->lname
      ];

      return view('professor.schedule',$data);
    }

    public function postSlot(Request $request){



      $schedule = new Schedule;
      $audit = new AuditTrail;

      if($request->input('slot_name') == '' || $request->input('slot_date') == '' || $request->input('slot_start') == '' || $request->input('slot_end') == ''){
        return Response::json(array(
            'result' => false,
            'text' => 'All fields are required!'
        ));
      }else{
        if($request->input('repeat_slot') == 1 && $request->input('slot_end_date') == null){
          return Response::json(array(
              'result' => false,
              'text' => 'Slot end date is missing!'
          ));
        }else{
          $schedule = new Schedule;
          $audit = new AuditTrail;

          $slot_start = date('H:i:s',strtotime($request->input('slot_start')));
          $slot_end = date('H:i:s',strtotime($request->input('slot_end')));

          if($slot_start < $slot_end){

            $start = $request->input('slot_date') . ' ' . $slot_start;
            $end = $request->input('slot_date') . ' ' . $slot_end;

            $slotExist = $schedule->checkSlotOverlap($start,'professor_id',Auth::id());

            if($slotExist > 0){
              return Response::json(array(
                  'result' => false,
                  'text' => 'Slot schedule overlap!'
              ));
            }else{

              if($schedule->getLastID() == null){
                $lastID = $schedule->getLastID() + 1;
              }else{
                $lastID = 1;
              }

              if($request->input('repeat_slot') == 1){
                $startDate = date('Y-m-d', strtotime($request->input('slot_date')));
                $endDate = date('Y-m-d', strtotime($request->input('slot_end_date')));

                while($startDate <= $endDate){

                  $data = [
                    'slug' => md5($lastID),
                    'professor_id' => Auth::id(),
                    'title' => $request->input('slot_name'),
                    'start_time' => $start,
                    'end_time' => $end,
                    'status' => 1
                  ];

                  $schedule->insertData($data);

                  $data = [
                    'slug' => md5($schedule->getLastID()),
                    'table_name' => 'professor_schedule',
                    'row_id' => $schedule->getLastID(),
                    'triggeredBy' => Auth::id(),
                    'status' => 0
                  ];

                  $audit->insertData($data);

                  $startDate = date('Y-m-d', strtotime($startDate . ' +7 day'));

                  $start = $startDate . ' ' . $slot_start;
                  $end = $startDate . ' ' . $slot_end;

                }
              }else{
                $data = [
                  'slug' => md5($lastID),
                  'professor_id' => Auth::id(),
                  'title' => $request->input('slot_name'),
                  'start_time' => $start,
                  'end_time' => $end,
                  'status' => 1
                ];

                $schedule->insertData($data);

                $data = [
                  'slug' => md5($schedule->getLastID()),
                  'table_name' => 'professor_schedule',
                  'row_id' => $schedule->getLastID(),
                  'triggeredBy' => Auth::id(),
                  'status' => 0
                ];

                $audit->insertData($data);
              }

              return Response::json(array(
                  'result' => true,
              ));

            }

          }else{
            return Response::json(array(
                'result' => false,
                'text' => 'Invalid start and end time!'
            ));
          }
        }
      }
    }

    public function updateSlotStatus(Request $request){
      $schedule = new Schedule;
      $audit = new AuditTrail;

      $scheduleDetails = $schedule->getDataByID($request->input('slot_id'));

      if($scheduleDetails->status == 1){
        $status = 2;
      }else{
        $status = 1;
      }

      $data = [
        'status' => $status
      ];

      $schedule->updateDataByID($data,$request->input('slot_id'));

      return Response::json(array(
          'result' => true
      ));

    }

    public function updateAppointmentStatus(Request $request){
      $schedule = new Schedule;
      $audit = new AuditTrail;
      $user = new User;

      if($request->input('status') == 2){
        $data = [
          'remarks' => $request->input('reasonDetails'),
          'status' => $request->input('status')
        ];

        Session::put('appointment_id', $request->input('appointment_id'));
        Session::put('remarks', $request->input('reasonDetails'));

        $scheduleDetails = $schedule->getDataByID($request->input('appointment_id'));
        $studentDetails = $user->getData('id',$scheduleDetails->student_id);

        try {
          // \Mail::to('joseph.fidelino@gmail.com')->send(new \App\Mail\RejectAppointment());
          \Mail::to($studentDetails->email)->send(new \App\Mail\RejectAppointment());
        } catch(Exception $e) {
          return Response::json(array(
              'success' => true
          ));
        }

      }else{
        $data = [
          'status' => $request->input('status')
        ];
      }

      $schedule->updateDataByID($data,$request->input('appointment_id'));

      $scheduleDetails = $schedule->getDataByID($request->input('appointment_id'));

      $data = [
        'slug' => md5($schedule->getLastID()),
        'table_name' => 'professor_schedule',
        'row_id' => $request->input('appointment_id'),
        'targetReceiver' => $scheduleDetails->student_id,
        'triggeredBy' => Auth::id(),
        'status' => 0
      ];

      $audit->insertData($data);

      return Response::json(array(
          'result' => true
      ));

    }

    public function getSlotDetails(Request $request){

      $schedule = new Schedule;

      $scheduleDetails = $schedule->getDataByID($request->input('slot_id'));

      return Response::json(array(
          'result' => true,
          'data' => $scheduleDetails
      ));

    }

    public function updateSlotDetails(Request $request){

      $schedule = new Schedule;
      $audit = new AuditTrail;

      $slot_start = date('H:i:s',strtotime($request->input('slot_start')));
      $slot_end = date('H:i:s',strtotime($request->input('slot_end')));
      $start = $request->input('slot_date') . ' ' . $slot_start;
      $end = $request->input('slot_date') . ' ' . $slot_end;

      $scheduleDetails = $schedule->getDataByID($request->input('slot_id'));

      $boolean_start_time = $scheduleDetails->start_time == $start;
      $boolean_end_time = $scheduleDetails->end_time == $end;
      $boolean_title = $scheduleDetails->title == $request->input('slot_title');

      if($boolean_title && $boolean_end_time && $boolean_start_time){
        return Response::json(array(
            'result' => true,
            'text' => 'No update made!'
        ));
      }else{

        if(($boolean_title == false) && ($boolean_end_time && $boolean_start_time)){

          $data = [
            'title' => $request->input('slot_title'),
            'start_time' => $start,
            'end_time' => $end
          ];

          $schedule->updateDataByID($data,$request->input('slot_id'));

          $data = [
            'slug' => md5($schedule->getLastID()),
            'table_name' => 'professor_schedule',
            'row_id' => $request->input('slot_id'),
            'triggeredBy' => Auth::id(),
            'status' => 1
          ];

          $audit->insertData($data);

          return Response::json(array(
              'result' => true,
              'text' => 'Slot was successfully updated!'
          ));

        }else{
          if($slot_start < $slot_end){

            $slotExist = $schedule->checkExistingSlotOverlap($start);

            if($slotExist > 0){
              return Response::json(array(
                  'result' => false,
                  'text' => 'Slot schedule overlap!'
              ));
            }else{

              if($schedule->getLastID() == null){
                $lastID = $schedule->getLastID() + 1;
              }else{
                $lastID = 1;
              }

              $data = [
                'title' => $request->input('slot_title'),
                'start_time' => $start,
                'end_time' => $end
              ];

              $schedule->updateDataByID($data,$request->input('slot_id'));

              $data = [
                'slug' => md5($schedule->getLastID()),
                'table_name' => 'professor_schedule',
                'row_id' => $request->input('slot_id'),
                'triggeredBy' => Auth::id(),
                'status' => 1
              ];

              $audit->insertData($data);

              return Response::json(array(
                  'result' => true,
                  'text' => 'Slot was successfully updated!'
              ));
            }
        }else{
          return Response::json(array(
              'result' => false,
              'text' => 'Invalid start and end time!'
          ));
        }
      }
    }
  }

  public function requestPage(Request $request, $status){
    $user = new User;
    $schedule = new Schedule;
    $userDetails = $user->getData('id',Auth::id());

    $data = [
      'id' => Auth::id(),
      'fname' => $userDetails->fname,
      'lname' => $userDetails->lname,
      'user_type' => $userDetails->type,
      'pending' => $schedule->getCountByStatus(0,'professor_id'),
      'approved' => $schedule->getCountByStatus(1,'professor_id'),
      'completed' => $schedule->getCountByStatus(4,'professor_id'),
      'disapproved' => $schedule->getCountByStatus(2,'professor_id'),
      'status' => $status
    ];

    return view('professor.request',$data);
  }

  public function getAppointmentDetails(Request $request){
    $user = new User;
    $schedule = new Schedule;
    $concerns = new Concerns;
    $audit = new AuditTrail;

    $appointmentDetails = $schedule->getDataByID($request->input('appointment_id'));

    $studentDetails = $user->getData('id',$appointmentDetails->student_id);

    $auditDetails = $audit->getAllDataByParameter('row_id',$request->input('appointment_id'), 'table_name', 'professor_schedule');

    return Response::json(array(
        'result' => true,
        'appointment_id' => $request->input('appointment_id'),
        'student_name' => $studentDetails->fname . ' ' . $studentDetails->lname,
        'student_email' => $studentDetails->email,
        'appointment_date' => explode(' ',$appointmentDetails->start_time)[0],
        'appointment_time' => date('h:i A', strtotime(explode(' ',$appointmentDetails->start_time)[1])) . ' - ' . date('h:i A', strtotime(explode(' ',$appointmentDetails->end_time)[1])),
        'appointment_status' => $appointmentDetails->status,
        'meeting_link' => $appointmentDetails->meeting_link,
        'remarks' => $appointmentDetails->remarks,
        'auditDetails' => $auditDetails,
        'status' => count($auditDetails)
    ));

  }

  public function updateMeeting(Request $request){
    $schedule = new Schedule;
    $user = new User;
    if($request->transaction == 0){ //0 = meeting link
      $data = [
        'meeting_link' => $request->data
      ];
      $schedule->updateDataByID($data,$request->appointment_id);

      Session::put('appointment_id', $request->appointment_id);

      $scheduleDetails = $schedule->getDataByID($request->appointment_id);

      $studentDetails = $user->getData('id',$scheduleDetails->student_id);

      try {
        // \Mail::to('joseph.fidelino@gmail.com')->send(new \App\Mail\AppointmentMeeting());
        \Mail::to($studentDetails->email)->send(new \App\Mail\AppointmentMeeting());
      } catch(Exception $e) {
        return Response::json(array(
            'success' => true
        ));
      }

      return Response::json(array(
          'result' => true,
      ));
    }
  }

}
