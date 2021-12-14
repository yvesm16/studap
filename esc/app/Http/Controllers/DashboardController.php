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
use PDF;

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

        $prefix = $userDetails->prefix;
        $suffix = $this->getSuffix();
        $fname = $userDetails->fname;
        $lname = $userDetails->lname;
        
        return view('director/dashboard', compact('oc', 'tc', 'thc', 'fc','fic', 'ave','accptReq', 'prefix','suffix', 'fname','lname', 'time','timecc' ,
        'timesa', 'timear','numReq','backlog','backlog1', 'backlog2', 'backlog3',  'ETime', 'ETimear', 'ETimesa', 'ETimecc', 'dcc', 'dar', 'decline'));
    }

    private function getSuffix() {
        $user = new User;
        $userDetails = $user->getData('id',Auth::id());
  
        $suffix = '';
        if ($userDetails->type == 1) {
          $suffix = '- Teaching Official';
  
          if ($this->isProfessorChairperson(Auth::id())) {
            $suffix = '- Academic Official';
          }
        } else if ($userDetails->type == 2 || $userDetails->type == 3) {
          $suffix = '- Admin Official';
        } else if ($userDetails->type == 4 || $userDetails->type == 5) {
          $suffix = '- Office Staff';
        }
  
        return $suffix;
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
            'prefix' => $userDetails->prefix,
            'suffix' => $this->getSuffix(),
            'fname' => $userDetails->fname,
            'lname' => $userDetails->lname,
            'department' => $userDetails->department,
            'isProfessorChairperson' => $this->isProfessorChairperson(Auth::id()),
            // 'getCS' => $this->getCS(Auth::id())
        ];
        
        //accepted
        $ar = new Schedule;
        $total = $ar->getAllApprovedScheduleByParameter('title','Appointment')->where('department', 0)->count();
        $accepted = $total;

        //elapsed
        $pendingar = $ar
        ->where('status', 1)
        ->get();

        if(count($pendingar) >= 1) { 
            $etimear = $ar
            ->select(DB::raw("AVG(TIME_TO_SEC(TIMEDIFF(updated_at, created_at))) AS timediffar"))
            ->where([
                ['department',0],
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
        ->where('department', 0)
        ->pluck('professor_id')
        ->toArray();

        // dd($getID);

        $dar = $ar->where('status', 2)->get();
        $padua =0;
        $lopez =0;
        $alberto=0;
        $balais=0;
        $domingo=0;
        $edang=0;
        $eleazar=0;
        $estrella=0;
        $lacsamana=0;
        $lintag=0;
        $ollanda=0;
        $perol=0;
        $tayuan=0;
        $victorio=0;
        $zhuo=0;
        $sanidad=0;
   
        
        if(in_array(2,$getID)){
            $padua = $dar->where('professor_id',2)->count();
        }if(in_array(10,$getID)){
            $lopez = $dar->where('professor_id',10)->count();
        }if(in_array(24,$getID)){
            $alberto = $dar->where('professor_id',24)->count();

        }if(in_array(25,$getID)){
            $balais = $dar->where('professor_id',25)->count();

        }if(in_array(26,$getID)){
            $domingo = $dar->where('professor_id',26)->count();

        }if(in_array(27,$getID)){
            $edang = $dar->where('professor_id',27)->count();

        }if(in_array(28,$getID)){
            $eleazar = $dar->where('professor_id',28)->count();

        }if(in_array(29,$getID)){
            $estrella = $dar->where('professor_id',29)->count();

        }if(in_array(30,$getID)){
            $lacsamana = $dar->where('professor_id',30)->count();

        }if(in_array(31,$getID)){
            $lintag = $dar->where('professor_id',31)->count();

        }if(in_array(32,$getID)){
            $ollanda = $dar->where('professor_id',32)->count();

        }if(in_array(33,$getID)){
            $perol = $dar->where('professor_id',33)->count();

        }if(in_array(34,$getID)){
            $tayuan = $dar->where('professor_id',34)->count();

        }if(in_array(35,$getID)){
            $victorio = $dar->where('professor_id',35)->count();

        }if(in_array(36,$getID)){
            $zhuo = $dar->where('professor_id',36)->count();

        }if(in_array(37,$getID)){
            $sanidad = $dar->where('professor_id',37)->count();

        }

        //backlog
        $padua2 =0;
        $lopez2 =0;
        $alberto2=0;
        $balais2=0;
        $domingo2=0;
        $edang2=0;
        $eleazar2=0;
        $estrella2=0;
        $lacsamana2=0;
        $lintag2=0;
        $ollanda2=0;
        $perol2=0;
        $tayuan2=0;
        $victorio2=0;
        $zhuo2=0;
        $sanidad2=0;

        $getID2 = $ar
        // ->select('professor_id')
        ->where([
            ['department', 0],
            ['status', '<>', 4]
            ])
        ->pluck('professor_id')
        ->toArray();


        

        if(in_array(2,$getID2)){
                $padua2 =$ar
                ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
                ->where([
                    ['status', '<>', 4],
                    ['professor_id', 2]
                ])
                ->count();
        }if(in_array(10,$getID2)){
                $lopez2 = $ar
                ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
                ->where([
                    ['status', '<>', 4],
                    ['professor_id', 10]
                ])
                ->count();
            
        }if(in_array(24,$getID2)){
                $alberto2 = $ar
                ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
                ->where([
                    ['status', '<>', 4],
                    ['professor_id',24]
                ])
                ->count();
            
        }if(in_array(25,$getID2)){
                $balais2 = $ar
                ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
                ->where([
                    ['status', '<>', 25],
                    ['professor_id', 7]
                ])
                ->count();
            
        }if(in_array(26,$getID2)){
                $domingo2 =$ar
                ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
                ->where([
                    ['status', '<>', 4],
                    ['professor_id', 26]
                ])
                ->count();
            
        }if(in_array(27,$getID2)){
                $edang2 = $ar
                ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
                ->where([
                    ['status', '<>', 4],
                    ['professor_id', 27]
                ])
                ->count();
           
        }if(in_array(28,$getID2)){
                $eleazar2 = $ar
                ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
                ->where([
                    ['status', '<>', 4],
                    ['professor_id', 28]
                ])
                ->count();
           
        }if(in_array(29,$getID2)){
                $estrella2 = $ar
                ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
                ->where([
                    ['status', '<>', 4],
                    ['professor_id', 29]
                ])
                ->count();
            
        }if(in_array(30,$getID2)){
                $lacsamana2 = $ar
                ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
                ->where([
                    ['status', '<>', 4],
                    ['professor_id', 30]
                ])
                ->count();
           
        }if(in_array(31,$getID2)){
            $lintag2 = $ar
            ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
            ->where([
                ['status', '<>', 4],
                ['professor_id',31]
            ])
            ->count();
        
    }if(in_array(32,$getID2)){
            $ollanda2 = $ar
            ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
            ->where([
                ['status', '<>', 25],
                ['professor_id', 32]
            ])
            ->count();
        
    }if(in_array(33,$getID2)){
            $perol2 =$ar
            ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
            ->where([
                ['status', '<>', 4],
                ['professor_id', 33]
            ])
            ->count();
        
    }if(in_array(34,$getID2)){
            $tayuan2 = $ar
            ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
            ->where([
                ['status', '<>', 4],
                ['professor_id', 34]
            ])
            ->count();
       
    }if(in_array(35,$getID2)){
            $victorio2 = $ar
            ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
            ->where([
                ['status', '<>', 4],
                ['professor_id', 35]
            ])
            ->count();
       
    }if(in_array(36,$getID2)){
            $zhuo2 = $ar
            ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
            ->where([
                ['status', '<>', 4],
                ['professor_id', 36]
            ])
            ->count();
        
    }if(in_array(37,$getID2)){
            $sanidad = $ar
            ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
            ->where([
                ['status', '<>', 4],
                ['professor_id', 37]
            ])
            ->count();
       
    }

        return view('professor/itdash', $data, compact(
            'padua', 'lopez','alberto', 'balais', 'domingo', 'edang','eleazar', 'estrella','lacsamana', 'lintag','ollanda', 'perol','tayuan', 'tayuan', 'victorio','zhuo','sanidad',
            'padua2', 'lopez2','alberto2', 'balais2', 'domingo2', 'edang2','eleazar2', 'estrella2','lacsamana2', 'lintag2','ollanda2', 'perol2','tayuan2', 'tayuan2', 'victorio2','zhuo2','sanidad2',
            'accepted', 'elapsed'
        ));
    }



    public function isdash() {
        $user = new User;

        $userDetails = $user->getData('id',Auth::id());
        $data = [
            'id' => Auth::id(),
            'prefix' => $userDetails->prefix,
            'suffix' => $this->getSuffix(),
            'fname' => $userDetails->fname,
            'lname' => $userDetails->lname,
            'department' => $userDetails->department,
            'isProfessorChairperson' => $this->isProfessorChairperson(Auth::id()),
            // 'getCS' => $this->getCS(Auth::id())
        ];
        
        //accepted
        $ar = new Schedule;
        $total = $ar->getAllApprovedScheduleByParameter('title','Appointment')->where('department', 1)->count();
        $accepted = $total;

        //elapsed
        $pendingar = $ar
        ->where('status', 1)
        ->get();

        if(count($pendingar) >= 1) { 
            $etimear = $ar
            ->select(DB::raw("AVG(TIME_TO_SEC(TIMEDIFF(updated_at, created_at))) AS timediffar"))
            ->where([
                ['department',1],
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
        ->where('department', 1)
        ->pluck('professor_id')
        ->toArray();

        // dd($getID);

        $dar = $ar->where('status', 2)->get();
        $duran =0;
        $mariano =0;
        $balmeo=0;
        $cortez=0;
        $barcelo=0;
        $ladao=0;
        $diaz=0;
        $marollano=0;
        $santos=0;
   
        
        if(in_array(1,$getID)){
            $duran = $dar->where('professor_id',1)->count();
        }if(in_array(4,$getID)){
            $mariano = $dar->where('professor_id',4)->count();
        }if(in_array(6,$getID)){
            $balmeo = $dar->where('professor_id',6)->count();

        }if(in_array(7,$getID)){
            $cortez = $dar->where('professor_id',7)->count();

        }if(in_array(8,$getID)){
            $bacelo = $dar->where('professor_id',8)->count();

        }if(in_array(11,$getID)){
            $ladao = $dar->where('professor_id',11)->count();

        }if(in_array(12,$getID)){
            $diaz = $dar->where('professor_id',12)->count();

        }if(in_array(13,$getID)){
            $marollano = $dar->where('professor_id',13)->count();

        }if(in_array(14,$getID)){
            $santos = $dar->where('professor_id',14)->count();

        }

        //backlog
        $duran2 =0;
        $mariano2 =0;
        $balmeo2=0;
        $cortez2=0;
        $barcelo2=0;
        $ladao2=0;
        $diaz2=0;
        $marollano2=0;
        $santos2=0;

        $getID2 = $ar
        // ->select('professor_id')
        ->where([
            ['department', 1],
            ['status', '<>', 4]
            ])
        ->pluck('professor_id')
        ->toArray();


        

        if(in_array(1,$getID2)){
                $duran2 =$ar
                ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
                ->where([
                    ['status', '<>', 4],
                    ['professor_id', 1]
                ])
                ->count();
        }if(in_array(4,$getID2)){
                $mariano2 = $ar
                ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
                ->where([
                    ['status', '<>', 4],
                    ['professor_id', 4]
                ])
                ->count();
            
        }if(in_array(6,$getID2)){
                $balmeo2 = $ar
                ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
                ->where([
                    ['status', '<>', 4],
                    ['professor_id', 6]
                ])
                ->count();
            
        }if(in_array(7,$getID2)){
                $cortez2 = $ar
                ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
                ->where([
                    ['status', '<>', 4],
                    ['professor_id', 7]
                ])
                ->count();
            
        }if(in_array(8,$getID2)){
                $barcelo2 =$ar
                ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
                ->where([
                    ['status', '<>', 4],
                    ['professor_id', 8]
                ])
                ->count();
            
        }if(in_array(11,$getID2)){
                $ladao2 = $ar
                ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
                ->where([
                    ['status', '<>', 4],
                    ['professor_id', 11]
                ])
                ->count();
           
        }if(in_array(12,$getID2)){
                $diaz2 = $ar
                ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
                ->where([
                    ['status', '<>', 4],
                    ['professor_id', 12]
                ])
                ->count();
           
        }if(in_array(13,$getID2)){
                $marollano2 = $ar
                ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
                ->where([
                    ['status', '<>', 4],
                    ['professor_id', 13]
                ])
                ->count();
            
        }if(in_array(14,$getID2)){
                $santos2 = $ar
                ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
                ->where([
                    ['status', '<>', 4],
                    ['professor_id', 14]
                ])
                ->count();
           
        }

        return view('professor/isdash', $data, compact('duran', 'mariano','balmeo', 'cortez','barcelo','ladao', 'diaz','marollano','santos', 
        'duran2', 'mariano2','balmeo2', 'cortez2','barcelo2','ladao2', 'diaz2','marollano2','santos2','accepted', 'elapsed'));
    }

    public function csdash() {
        $user = new User;

        $userDetails = $user->getData('id',Auth::id());
        $data = [
            'id' => Auth::id(),
            'prefix' => $userDetails->prefix,
            'suffix' => $this->getSuffix(),
            'fname' => $userDetails->fname,
            'lname' => $userDetails->lname,
            'department' => $userDetails->department,
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
    
    public function deandashReport() {
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

        $prefix = $userDetails->prefix;
        $suffix = $this->getSuffix();
        $fname = $userDetails->fname;
        $lname = $userDetails->lname;
        
        return view('global/deanDashboardReport', compact('oc', 'tc', 'thc', 'fc','fic', 'ave','accptReq', 'prefix','suffix', 'fname','lname', 'time','timecc' ,
        'timesa', 'timear','numReq','backlog','backlog1', 'backlog2', 'backlog3',  'ETime', 'ETimear', 'ETimesa', 'ETimecc', 'dcc', 'dar', 'decline'));
    }
   
    public function itdashReport() {
        $user = new User;

        $userDetails = $user->getData('id',Auth::id());
        $data = [
            'id' => Auth::id(),
            'prefix' => $userDetails->prefix,
            'suffix' => $this->getSuffix(),
            'fname' => $userDetails->fname,
            'lname' => $userDetails->lname,
            'department' => $userDetails->department,
            'isProfessorChairperson' => $this->isProfessorChairperson(Auth::id()),
            // 'getCS' => $this->getCS(Auth::id())
        ];
        
        //accepted
        $ar = new Schedule;
        $total = $ar->getAllApprovedScheduleByParameter('title','Appointment')->where('department', 0)->count();
        $accepted = $total;

        //elapsed
        $pendingar = $ar
        ->where('status', 1)
        ->get();

        if(count($pendingar) >= 1) { 
            $etimear = $ar
            ->select(DB::raw("AVG(TIME_TO_SEC(TIMEDIFF(updated_at, created_at))) AS timediffar"))
            ->where([
                ['department',0],
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
        ->where('department', 0)
        ->pluck('professor_id')
        ->toArray();

        // dd($getID);

        $dar = $ar->where('status', 2)->get();
        $padua =0;
        $lopez =0;
        $alberto=0;
        $balais=0;
        $domingo=0;
        $edang=0;
        $eleazar=0;
        $estrella=0;
        $lacsamana=0;
        $lintag=0;
        $ollanda=0;
        $perol=0;
        $tayuan=0;
        $victorio=0;
        $zhuo=0;
        $sanidad=0;
   
        
        if(in_array(2,$getID)){
            $padua = $dar->where('professor_id',2)->count();
        }if(in_array(10,$getID)){
            $lopez = $dar->where('professor_id',10)->count();
        }if(in_array(24,$getID)){
            $alberto = $dar->where('professor_id',24)->count();

        }if(in_array(25,$getID)){
            $balais = $dar->where('professor_id',25)->count();

        }if(in_array(26,$getID)){
            $domingo = $dar->where('professor_id',26)->count();

        }if(in_array(27,$getID)){
            $edang = $dar->where('professor_id',27)->count();

        }if(in_array(28,$getID)){
            $eleazar = $dar->where('professor_id',28)->count();

        }if(in_array(29,$getID)){
            $estrella = $dar->where('professor_id',29)->count();

        }if(in_array(30,$getID)){
            $lacsamana = $dar->where('professor_id',30)->count();

        }if(in_array(31,$getID)){
            $lintag = $dar->where('professor_id',31)->count();

        }if(in_array(32,$getID)){
            $ollanda = $dar->where('professor_id',32)->count();

        }if(in_array(33,$getID)){
            $perol = $dar->where('professor_id',33)->count();

        }if(in_array(34,$getID)){
            $tayuan = $dar->where('professor_id',34)->count();

        }if(in_array(35,$getID)){
            $victorio = $dar->where('professor_id',35)->count();

        }if(in_array(36,$getID)){
            $zhuo = $dar->where('professor_id',36)->count();

        }if(in_array(37,$getID)){
            $sanidad = $dar->where('professor_id',37)->count();

        }

        //backlog
        $padua2 =0;
        $lopez2 =0;
        $alberto2=0;
        $balais2=0;
        $domingo2=0;
        $edang2=0;
        $eleazar2=0;
        $estrella2=0;
        $lacsamana2=0;
        $lintag2=0;
        $ollanda2=0;
        $perol2=0;
        $tayuan2=0;
        $victorio2=0;
        $zhuo2=0;
        $sanidad2=0;

        $getID2 = $ar
        // ->select('professor_id')
        ->where([
            ['department', 0],
            ['status', '<>', 4]
            ])
        ->pluck('professor_id')
        ->toArray();


        

        if(in_array(2,$getID2)){
                $padua2 =$ar
                ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
                ->where([
                    ['status', '<>', 4],
                    ['professor_id', 2]
                ])
                ->count();
        }if(in_array(10,$getID2)){
                $lopez2 = $ar
                ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
                ->where([
                    ['status', '<>', 4],
                    ['professor_id', 10]
                ])
                ->count();
            
        }if(in_array(24,$getID2)){
                $alberto2 = $ar
                ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
                ->where([
                    ['status', '<>', 4],
                    ['professor_id',24]
                ])
                ->count();
            
        }if(in_array(25,$getID2)){
                $balais2 = $ar
                ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
                ->where([
                    ['status', '<>', 25],
                    ['professor_id', 7]
                ])
                ->count();
            
        }if(in_array(26,$getID2)){
                $domingo2 =$ar
                ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
                ->where([
                    ['status', '<>', 4],
                    ['professor_id', 26]
                ])
                ->count();
            
        }if(in_array(27,$getID2)){
                $edang2 = $ar
                ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
                ->where([
                    ['status', '<>', 4],
                    ['professor_id', 27]
                ])
                ->count();
           
        }if(in_array(28,$getID2)){
                $eleazar2 = $ar
                ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
                ->where([
                    ['status', '<>', 4],
                    ['professor_id', 28]
                ])
                ->count();
           
        }if(in_array(29,$getID2)){
                $estrella2 = $ar
                ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
                ->where([
                    ['status', '<>', 4],
                    ['professor_id', 29]
                ])
                ->count();
            
        }if(in_array(30,$getID2)){
                $lacsamana2 = $ar
                ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
                ->where([
                    ['status', '<>', 4],
                    ['professor_id', 30]
                ])
                ->count();
           
        }if(in_array(31,$getID2)){
            $lintag2 = $ar
            ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
            ->where([
                ['status', '<>', 4],
                ['professor_id',31]
            ])
            ->count();
        
        }if(in_array(32,$getID2)){
            $ollanda2 = $ar
            ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
            ->where([
                ['status', '<>', 25],
                ['professor_id', 32]
            ])
            ->count();
        
        }if(in_array(33,$getID2)){
            $perol2 =$ar
            ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
            ->where([
                ['status', '<>', 4],
                ['professor_id', 33]
            ])
            ->count();
        
        }if(in_array(34,$getID2)){
            $tayuan2 = $ar
            ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
            ->where([
                ['status', '<>', 4],
                ['professor_id', 34]
            ])
            ->count();
       
        }if(in_array(35,$getID2)){
            $victorio2 = $ar
            ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
            ->where([
                ['status', '<>', 4],
                ['professor_id', 35]
            ])
            ->count();
       
        }if(in_array(36,$getID2)){
            $zhuo2 = $ar
            ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
            ->where([
                ['status', '<>', 4],
                ['professor_id', 36]
            ])
            ->count();
        
        }if(in_array(37,$getID2)){
            $sanidad = $ar
            ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
            ->where([
                ['status', '<>', 4],
                ['professor_id', 37]
            ])
            ->count();
       
        }

        return view('global/itDashboardReport', $data, compact(
            'padua', 'lopez','alberto', 'balais', 'domingo', 'edang','eleazar', 'estrella','lacsamana', 'lintag','ollanda', 'perol','tayuan', 'tayuan', 'victorio','zhuo','sanidad',
            'padua2', 'lopez2','alberto2', 'balais2', 'domingo2', 'edang2','eleazar2', 'estrella2','lacsamana2', 'lintag2','ollanda2', 'perol2','tayuan2', 'tayuan2', 'victorio2','zhuo2','sanidad2',
            'accepted', 'elapsed'
        ));
        
        // $pdf = PDF::loadView('global.itDashboardReport', $data, compact('padua', 'lopez','alberto', 'balais', 'domingo', 'edang','eleazar', 'estrella','lacsamana', 'lintag','ollanda', 'perol','tayuan', 'tayuan', 'victorio','zhuo','sanidad',
        // 'padua2', 'lopez2','alberto2', 'balais2', 'domingo2', 'edang2','eleazar2', 'estrella2','lacsamana2', 'lintag2','ollanda2', 'perol2','tayuan2', 'tayuan2', 'victorio2','zhuo2','sanidad2',
        // 'accepted', 'elapsed'));
        // return $pdf->stream();
    }



    public function isdashReport() {
        $user = new User;

        $userDetails = $user->getData('id',Auth::id());
        $data = [
            'id' => Auth::id(),
            'prefix' => $userDetails->prefix,
            'suffix' => $this->getSuffix(),
            'fname' => $userDetails->fname,
            'lname' => $userDetails->lname,
            'department' => $userDetails->department,
            'isProfessorChairperson' => $this->isProfessorChairperson(Auth::id()),
            // 'getCS' => $this->getCS(Auth::id())
        ];
        
        //accepted
        $ar = new Schedule;
        $total = $ar->getAllApprovedScheduleByParameter('title','Appointment')->where('department', 1)->count();
        $accepted = $total;

        //elapsed
        $pendingar = $ar
        ->where('status', 1)
        ->get();

        if(count($pendingar) >= 1) { 
            $etimear = $ar
            ->select(DB::raw("AVG(TIME_TO_SEC(TIMEDIFF(updated_at, created_at))) AS timediffar"))
            ->where([
                ['department',1],
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
        ->where('department', 1)
        ->pluck('professor_id')
        ->toArray();

        // dd($getID);

        $dar = $ar->where('status', 2)->get();
        $duran =0;
        $mariano =0;
        $balmeo=0;
        $cortez=0;
        $barcelo=0;
        $ladao=0;
        $diaz=0;
        $marollano=0;
        $santos=0;
   
        
        if(in_array(1,$getID)){
            $duran = $dar->where('professor_id',1)->count();
        }if(in_array(4,$getID)){
            $mariano = $dar->where('professor_id',4)->count();
        }if(in_array(6,$getID)){
            $balmeo = $dar->where('professor_id',6)->count();

        }if(in_array(7,$getID)){
            $cortez = $dar->where('professor_id',7)->count();

        }if(in_array(8,$getID)){
            $bacelo = $dar->where('professor_id',8)->count();

        }if(in_array(11,$getID)){
            $ladao = $dar->where('professor_id',11)->count();

        }if(in_array(12,$getID)){
            $diaz = $dar->where('professor_id',12)->count();

        }if(in_array(13,$getID)){
            $marollano = $dar->where('professor_id',13)->count();

        }if(in_array(14,$getID)){
            $santos = $dar->where('professor_id',14)->count();

        }

        //backlog
        $duran2 =0;
        $mariano2 =0;
        $balmeo2=0;
        $cortez2=0;
        $barcelo2=0;
        $ladao2=0;
        $diaz2=0;
        $marollano2=0;
        $santos2=0;

        $getID2 = $ar
        // ->select('professor_id')
        ->where([
            ['department', 1],
            ['status', '<>', 4]
            ])
        ->pluck('professor_id')
        ->toArray();


        

        if(in_array(1,$getID2)){
                $duran2 =$ar
                ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
                ->where([
                    ['status', '<>', 4],
                    ['professor_id', 1]
                ])
                ->count();
        }if(in_array(4,$getID2)){
                $mariano2 = $ar
                ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
                ->where([
                    ['status', '<>', 4],
                    ['professor_id', 4]
                ])
                ->count();
            
        }if(in_array(6,$getID2)){
                $balmeo2 = $ar
                ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
                ->where([
                    ['status', '<>', 4],
                    ['professor_id', 6]
                ])
                ->count();
            
        }if(in_array(7,$getID2)){
                $cortez2 = $ar
                ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
                ->where([
                    ['status', '<>', 4],
                    ['professor_id', 7]
                ])
                ->count();
            
        }if(in_array(8,$getID2)){
                $barcelo2 =$ar
                ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
                ->where([
                    ['status', '<>', 4],
                    ['professor_id', 8]
                ])
                ->count();
            
        }if(in_array(11,$getID2)){
                $ladao2 = $ar
                ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
                ->where([
                    ['status', '<>', 4],
                    ['professor_id', 11]
                ])
                ->count();
           
        }if(in_array(12,$getID2)){
                $diaz2 = $ar
                ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
                ->where([
                    ['status', '<>', 4],
                    ['professor_id', 12]
                ])
                ->count();
           
        }if(in_array(13,$getID2)){
                $marollano2 = $ar
                ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
                ->where([
                    ['status', '<>', 4],
                    ['professor_id', 13]
                ])
                ->count();
            
        }if(in_array(14,$getID2)){
                $santos2 = $ar
                ->whereRaw("TIME_TO_SEC(TIMEDIFF(updated_at, created_at)) > 259200")
                ->where([
                    ['status', '<>', 4],
                    ['professor_id', 14]
                ])
                ->count();
           
        }

        return view('global/isDashboardReport', $data, compact('duran', 'mariano','balmeo', 'cortez','barcelo','ladao', 'diaz','marollano','santos', 
        'duran2', 'mariano2','balmeo2', 'cortez2','barcelo2','ladao2', 'diaz2','marollano2','santos2','accepted', 'elapsed'));

        // $pdf = PDF::loadView('global.isDashboardReport', $data, compact('duran', 'mariano','balmeo', 'cortez','barcelo','ladao', 'diaz','marollano','santos', 
        // 'duran2', 'mariano2','balmeo2', 'cortez2','barcelo2','ladao2', 'diaz2','marollano2','santos2','accepted', 'elapsed'));
        // return $pdf->stream();
        // return $pdf->download('IS Dashboard Report' . '.pdf')->setOptions(['defaultFont' => 'sans-serif']);;
    }

    public function csdashReport() {
        $user = new User;

        $userDetails = $user->getData('id',Auth::id());
        $data = [
            'id' => Auth::id(),
            'prefix' => $userDetails->prefix,
            'suffix' => $this->getSuffix(),
            'fname' => $userDetails->fname,
            'lname' => $userDetails->lname,
            'department' => $userDetails->department,
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

        return view('global/csDashboardReport', $data, compact('accepted', 'elapsed','seno','acula','cabero','cosme','decamora', 'estabillo',
            'ponay', 'sideno', 'torralba','seno2','acula2','cabero2','cosme2','decamora2', 'estabillo2',
            'ponay2', 'sideno2', 'torralba2'));

            
        // $pdf = PDF::loadView('global.csDashboardReport', $data, compact('accepted', 'elapsed','seno','acula','cabero','cosme','decamora', 'estabillo',
        // 'ponay', 'sideno', 'torralba','seno2','acula2','cabero2','cosme2','decamora2', 'estabillo2',
        // 'ponay2', 'sideno2', 'torralba2'));
        // return $pdf->stream();
        // return $pdf->download('CS Dashboard Report' . '.pdf');
    }
}
