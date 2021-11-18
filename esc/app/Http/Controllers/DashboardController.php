<?php

namespace App\Http\Controllers;
use Chartisan\PHP\Chartisan;
use App\Charts\SampleChart;
use Illuminate\Http\Request;
use App\Models\ratings;
use App\Models\Schedule;
use App;


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
        
        $ar = new Schedule();
        $accptReq = $ar->getAllApprovedScheduleByParameter();
        //$accptReq = $total/7;

        return view('director/dashboard', compact('oc', 'tc', 'thc', 'fc','fic', 'ave','accptReq'));
    }

   
}
