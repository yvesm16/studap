<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Schedule;
use App\Models\Credit;
use App\Models\Appeal;
use App\Models\Concerns;
use App\Models\AuditTrail;
use Auth;
use Response;

class NotificationController extends Controller
{
    public function getNotification(Request $request){
      $user = new User;
      $audit = new AuditTrail;

      $unreadNotification = $audit->getAllLoginUserDataByStatus(0);

      return Response::json(array(
          'result' => true,
          'notification' => $unreadNotification
      ));
    }

    public function updateNotificationStatus(Request $request){
      $user = new User;
      $audit = new AuditTrail;

      $data = [
        'status' => 1
      ];

      $audit->updateLoginUserData($data);

      return Response::json(array(
          'result' => true
      ));

    }

    public function getNotificationDetails(Request $request){
      $audit = new AuditTrail;
      $schedule = new Schedule;
      $credit = new Credit;
      $appeal = new Appeal;
      $user = new User;

      $auditDetails = $audit->getDataByID($request->input('id'));

      if($auditDetails->table_name == 'appeal'){
        $appealDetails = $appeal->getDataByID($auditDetails->row_id);
        $type = 3;
        $status = $appealDetails->status;
      }else if($auditDetails->table_name == 'credit_course'){
        $creditDetails = $credit->getDataByParameter('id',$auditDetails->row_id);
        $type = 2;
        $status = $creditDetails->status;
      }else{
        $scheduleDetails = $schedule->getDataByID($auditDetails->row_id);
        $type = 1;
        $status = $scheduleDetails->status;
      }

      $userDetails = $user->getData('id',$auditDetails->triggeredBy);

      return Response::json(array(
          'result' => true,
          'type' => $type,
          'status' => $status,
          'fname' => $userDetails->fname,
          'lname' => $userDetails->lname
      ));

    }
}
