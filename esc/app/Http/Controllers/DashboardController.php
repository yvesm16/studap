<?php

namespace App\Http\Controllers;
use App;
use Chartisan\PHP\Chartisan;
use App\Charts\SampleChart;
use Illuminate\Http\Request;
use App\Models\ratings;
use App\Models\Schedule;
use App\Models\User;
use App\Models\Files;
use App\Models\AuditTrail;
use App\Models\Credit;
//student appeal
use DB;

use Auth;

use Carbon\CarbonInterval;
use DateInterval;
use Carbon\Carbon;
use Monolog\Handler\FingersCrossed\ActivationStrategyInterface;

class DashboardController extends Controller
{
    public function rate() {


        // Student Satisfaction
        $one = ratings::where('rating', 1)->get();
        $two = ratings::where('rating', 2)->get();
        $three = ratings::where('rating', 3)->get();
        $four = ratings::where('rating', 4)->get();
        $five = ratings::where('rating', 5)->get();
        $oc = count($one);
        $tc = count($two);
        $thc = count($three);
        $fc = count($four);
        $fic = count($five);
        $getAve = ratings::avg('rating');
        $ave = round($getAve,2);
        
        //accepted consul
        $ar = new Schedule;
        $total = $ar->getAllApprovedScheduleByParameter('title','Appointment');
        $finalar = count($total);

        $cc = new Credit;
        $ccTotal = $cc
        ->where('status', 1)
        ->get();
        $finalcc = count($ccTotal);

        $sa = 0;
        $finalsa=0;
        $accptReq = round($finalar + $finalcc /3);

        //backlogs
        //cosnul

        $cb = $ar->where('status','!=', 4)->get();
        if(count($cb) > 0){
            $FCB = $ar->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
            ->where('status', '!=', 4)
            ->get();
        }else {
            $FCB = 0;
        }
        $finalar = count($FCB);
    
        //studap

        //cc
        $cc2 = $cc->where('status','!=', 3)->get();
        if(count($cb) > 0){
            $FCB = $ar->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
            ->where('status', '!=', 3)
            ->get();
        }else {
            $FCB = 0;
        }
        $finalcc = count($FCB);

        $backlog = round($finalar + $finalcc /3);

        //completed
        //consul
        $aveTime = $ar
        ->select(DB::raw("AVG(TIME_TO_SEC(TIMEDIFF(updated_at, created_at))) AS timediff"))
        ->where('status', 4)
        ->get();

        $req = $ar
        ->where('status',4)
        ->get();
        $numReqar = count($req);
        $timear = round((int)$aveTime[0]->timediff/3600) ; //final formula
        
        //studap
        $sa = 0;

        //cc
        $aveTimecc = $cc
        ->select(DB::raw("AVG(TIME_TO_SEC(TIMEDIFF(updated_at, created_at))) AS timediffcc"))
        ->where('status', 3)
        ->get();

        $reqcc = $ar
        ->where('status',3)
        ->get();
        $numReqcc = count($reqcc);
        $timecc = round((int)$aveTimecc[0]->timediffcc/3600) ;

        $numReq = round($numReqar + $numReqcc /3);
        $time = round($timear + $timecc /3);

        //Elapsed Time
        //consul
        $pendingar = $ar
        ->where('status', 1)
        ->get();

        if(count($pendingar) >= 1) { 
            $etimear = $ar->select(DB::raw("AVG(TIME_TO_SEC(TIMEDIFF(updated_at, created_at))) AS timediffar"))->get();
            $ETimear = round((int)$etimear[0]->timediffar/3600) ;
        }else {
            $ETimear = 0;
        }

        //sa

        //cc
        $pendingcc = $cc
        ->where('status', 1)
        ->get();

        if(count($pendingcc) >= 1) { 
            $etimecc = $cc->select(DB::raw("AVG(TIME_TO_SEC(TIMEDIFF(updated_at, created_at))) AS timediffcc"))->get();
            $ETimecc = round((int)$etimecc[0]->timediffcc/3600) ;
        }else {
            $ETimecc = 0;
        }

        $ETime = round($ETimear + $ETimecc / 3);

        //navbar
        $user = new User;
        $files = new Files;
  
        $userDetails = $user->getData('id',Auth::id());
        $directorSignature = $files->getAllActiveFileByUserByParameter('type',0);

        $fname = $userDetails->fname;
        $lname = $userDetails->lname;
        
    
        return view('director/dashboard', compact('oc', 'tc', 'thc', 'fc','fic', 'ave','accptReq', 'fname','lname', 'time', 'numReq',
        'backlog', 'ETime'));
    }

    // public function directorDash(){
    //     $user = new User;
    //     $files = new Files;
  
    //     $userDetails = $user->getData('id',Auth::id());
    //     $directorSignature = $files->getAllActiveFileByUserByParameter('type',0);
  
    //     $data = [
    //       'id' => Auth::id(),
    //       'fname' => $userDetails->fname,
    //       'lname' => $userDetails->lname,
    //       'signature' => $directorSignature
    //     ];
  
    //     return view('director.dashboard',$data);
    //   }

   
}
