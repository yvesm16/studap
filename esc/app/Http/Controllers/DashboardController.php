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
use App\Models\Appeal;

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
        $total = $ar->getAllApprovedScheduleByParameter('title','Appointment')->count();
        $finalar = $total;

        $cc = new Credit;
        $ap= new Appeal;
        
        
        $sa = 0;
        $finalsa=0;
        $accptReq = round($finalar);

        //backlogs
        //cosnul

        $cb = $ar->where('status','<>', 4)->get();
        if(count($cb) > 0){
            $FCB = $ar->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
            ->where('status', '<>', 4)
            ->count();
        }else {
            $FCB = 0;
        }
        $backlog1 = round($FCB);
        
        //studap
        $sa = $ap->where('status','<>', 2)->get();
        
        if(count($sa) > 0){
            $FSA = $ap
            ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
            ->where('status', '<>', 2)
            ->count();
        }else {
            $FSA = 0;
        }

        
        $backlog2 = round($FSA);
        //cc
        $cc2 = $cc->where('status', '<>' ,3)->get();
        
        if(count($cc2) > 0){
            $FCC = $cc
            ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
            ->where('status', '<>', 3)
            ->count();
        }else {
            $FCC = 0;
        }
        $backlog3 = round($FCC);

        $backlog = round($backlog1 + $backlog2 + $backlog3 /3);

        //completed
        //consul
        $aveTime = $ar
        ->select(DB::raw("AVG(TIME_TO_SEC(TIMEDIFF(updated_at, created_at))) AS timediff"))
        ->where('status', 4)
        ->get();

        $req = $ar
        ->where('status',4)
        ->count();
        $numReqar = $req;
        $timear = round((int)$aveTime[0]->timediff/3600) ; //final formula
        
        //studap
        $aveTimesa = $ap
        ->select(DB::raw("AVG(TIME_TO_SEC(TIMEDIFF(updated_at, created_at))) AS timediffsa"))
        ->where('status', 2)
        ->get();

        $reqsa = $ap
        ->where('status',2)
        ->count();
        $numReqsa = $reqsa;
        $timesa = round((int)$aveTimesa[0]->timediffsa/3600) ;
    

        //cc
        $aveTimecc = $cc
        ->select(DB::raw("AVG(TIME_TO_SEC(TIMEDIFF(updated_at, created_at))) AS timediffcc"))
        ->where('status', 3)
        ->get();
        
        $reqcc = $cc
        ->where('status',3)
        ->count();
        $numReqcc = $reqcc;
        $timecc = round((int)$aveTimecc[0]->timediffcc/3600) ;

        $numReq = round($numReqar + $numReqcc + $numReqsa /3);

        $time = round($timear + $timecc + $timesa /3);

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
        $pendingsa = $ap
        ->where('status', 1)
        ->get();

        if(count($pendingsa) >= 1) { 
            $etimesa = $ap->select(DB::raw("AVG(TIME_TO_SEC(TIMEDIFF(updated_at, created_at))) AS timediffsa"))->get();
            $ETimesa = round((int)$etimesa[0]->timediffsa/3600) ;
        }else {
            $ETimesa = 0;
        }

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

        $ETime = round($ETimear + $ETimecc + $ETimesa / 3);

        //declined 
        //consul
        $dar = $ar->where('status', 2)->count();

        //studap no need

        //cc
        $dcc = $cc->where('status', 5)->count();

        $decline = round($dar + $dcc / 2);

        
        //navbar
        $user = new User;
        $files = new Files;
  
        $userDetails = $user->getData('id',Auth::id());
        $directorSignature = $files->getAllActiveFileByUserByParameter('type',0);

        $fname = $userDetails->fname;
        $lname = $userDetails->lname;
        
    
        return view('director/dashboard', compact('oc', 'tc', 'thc', 'fc','fic', 'ave','accptReq', 'fname','lname', 'time','timecc' ,
        'timesa', 'timear','numReq','backlog','backlog1', 'backlog2', 'backlog3',  'ETime', 'ETimear', 'ETimesa', 'ETimecc', 'dcc', 'dar', 'decline'));
    }

    

   
}
