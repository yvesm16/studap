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
use App\Models\Course;

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

    private function isProfessorChairperson($id){
        $course = new Course;
        $course_details = $course->getChairperson($id);
  
        return $course_details ? true : false;
      }

    //   private function getIS($id){
    //     $course = new Course;
    //     $course_details = $course->getIS($id);
  
    //     return $course_details ? true : false;
    //   }

    //   private function getIT($id){
    //     $course = new Course;
    //     $course_details = $course->getIT($id);
  
    //     return $course_details ? true : false;
    //   }

    //   private function getCS($id){
    //     $course = new Course;
    //     $course_details = $course->getCS($id);
  
    //     return $course_details ? true : false;
    //   }


    public function itdash() {
        $user = new User;

        $userDetails = $user->getData('id',Auth::id());
        $data = [
            'id' => Auth::id(),
            'fname' => $userDetails->fname,
            'lname' => $userDetails->lname,
            'isProfessorChairperson' => $this->isProfessorChairperson(Auth::id()),
            // 'getIS' => $this->getIT(Auth::id())
        ];

        return view('professor/itdash', $data);
    }



    public function isdash() {
        $user = new User;

        $userDetails = $user->getData('id',Auth::id());
        $data = [
            'id' => Auth::id(),
            'fname' => $userDetails->fname,
            'lname' => $userDetails->lname,
            'isProfessorChairperson' => $this->isProfessorChairperson(Auth::id()),
            // 'getIS' => $this->getIS(Auth::id())
        ];

        return view('professor/isdash', $data);
    }

    public function csdash() {
        $user = new User;

        $userDetails = $user->getData('id',Auth::id());
        $data = [
            'id' => Auth::id(),
            'fname' => $userDetails->fname,
            'lname' => $userDetails->lname,
            'isProfessorChairperson' => $this->isProfessorChairperson(Auth::id()),
            // 'getCS' => $this->getCS(Auth::id())
        ];
        
        //accepted
        $ar = new Schedule;
        $total = $ar->getAllApprovedScheduleByParameter('title','Appointment')->where('department', 2)->count();
        $accepted = $total;

        //elapsed
        $pendingar = $ar
        ->where('status', 1)
        ->get();

        if(count($pendingar) >= 1) { 
            $etimear = $ar
            ->select(DB::raw("AVG(TIME_TO_SEC(TIMEDIFF(updated_at, created_at))) AS timediffar"))
            ->where([
                ['department',2],
                ['status', '<>', 4]
                
                ])
            ->get();
            $elapsed = round((int)$etimear[0]->timediffar/3600) ;
        }else {
            $elapsed = 0;
        }

        //declined
        $user = new User;

        $getID = $ar
        // ->select('professor_id')
        ->where('department', 2)
        ->pluck('professor_id')
        ->toArray();

        // dd($getID);

        $dar = $ar->where('status', 2)->get();
        $seno =0;
        $acula =0;
        $cabero=0;
        $cosme=0;
        $decamora=0;
        $estabillo=0;
        $ponay=0;
        $sideno=0;
        $torralba=0;
        
        if(in_array(10,$getID)){
            $seno = $dar->where('professor_id',10)->count();
        }if(in_array(16,$getID)){
            $acula = $dar->where('professor_id',16)->count();
        }if(in_array(17,$getID)){
            $cabero = $dar->where('professor_id',17)->count();

        }if(in_array(18,$getID)){
            $cosme = $dar->where('professor_id',18)->count();

        }if(in_array(19,$getID)){
            $decamora = $dar->where('professor_id',19)->count();

        }if(in_array(20,$getID)){
            $estabillo = $dar->where('professor_id',20)->count();

        }if(in_array(21,$getID)){
            $ponay = $dar->where('professor_id',21)->count();

        }if(in_array(22,$getID)){
            $sideno = $dar->where('professor_id',22)->count();

        }if(in_array(23,$getID)){
            $torralba = $dar->where('professor_id',23)->count();

        }

        //backlog
        $seno2 =0;
        $acula2 =0;
        $cabero2=0;
        $cosme2=0;
        $decamora2=0;
        $estabillo2=0;
        $ponay2=0;
        $sideno2=0;
        $torralba2=0;

        $getID2 = $ar
        // ->select('professor_id')
        ->where([
            ['department', 2],
            ['status', '<>', 4]
            ])
        ->pluck('professor_id')
        ->toArray();


        

        if(in_array(10,$getID2)){
                $seno2 =$ar
                ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
                ->where([
                    ['status', '<>', 4],
                    ['professor_id', 10]
                ])
                ->count();
        }if(in_array(16,$getID2)){
                $acula2 = $ar
                ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
                ->where([
                    ['status', '<>', 4],
                    ['professor_id', 16]
                ])
                ->count();
            
        }if(in_array(17,$getID2)){
                $cabero2 = $ar
                ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
                ->where([
                    ['status', '<>', 4],
                    ['professor_id', 17]
                ])
                ->count();
            
        }if(in_array(18,$getID2)){
                $cosme2 = $ar
                ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
                ->where([
                    ['status', '<>', 4],
                    ['professor_id', 18]
                ])
                ->count();
            
        }if(in_array(19,$getID2)){
                $decamora2 =$ar
                ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
                ->where([
                    ['status', '<>', 4],
                    ['professor_id', 19]
                ])
                ->count();
            
        }if(in_array(20,$getID2)){
                $estabillo2 = $ar
                ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
                ->where([
                    ['status', '<>', 4],
                    ['professor_id', 20]
                ])
                ->count();
           
        }if(in_array(21,$getID2)){
                $ponay2 = $ar
                ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
                ->where([
                    ['status', '<>', 4],
                    ['professor_id', 21]
                ])
                ->count();
           
        }if(in_array(22,$getID2)){
                $sideno2 = $ar
                ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
                ->where([
                    ['status', '<>', 4],
                    ['professor_id', 22]
                ])
                ->count();
            
        }if(in_array(23,$getID2)){
                $torralba2 = $ar
                ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
                ->where([
                    ['status', '<>', 4],
                    ['professor_id', 23]
                ])
                ->count();
           
        }

        return view('professor/csdash', $data, compact('accepted', 'elapsed','seno','acula','cabero','cosme','decamora', 'estabillo',
            'ponay', 'sideno', 'torralba','seno2','acula2','cabero2','cosme2','decamora2', 'estabillo2',
            'ponay2', 'sideno2', 'torralba2'));
    }
    

   
}
