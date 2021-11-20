<?php

namespace App\Http\Controllers;
use Chartisan\PHP\Chartisan;
use App\Charts\SampleChart;
use Illuminate\Http\Request;
use App\Models\ratings;
use App\Models\Schedule;
use App\Models\User;
use App\Models\Files;
// use App\Models\CreateAuditTrail;
use Auth;
use App;
use Carbon\Carbon;


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
        $accptReq = count($total);

        //backlogs
       
        // $getDate = CreateAuditTrail::all();
        // $reqDate = $getDate->created_at; 

        // if ($reqdate->addDays(3) )

        $user = new User;
        $files = new Files;
  
        $userDetails = $user->getData('id',Auth::id());
        $directorSignature = $files->getAllActiveFileByUserByParameter('type',0);

        $fname = $userDetails->fname;
        $lname = $userDetails->lname;
        
        
  
        // $data = [
        //   'id' => Auth::id(),
        //   'fname' => $userDetails->fname,
        //   'lname' => $userDetails->lname,
        //   'signature' => $directorSignature
        // ];
        
        return view('director/dashboard', compact('oc', 'tc', 'thc', 'fc','fic', 'ave','accptReq', 'fname','lname'));
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
