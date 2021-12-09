<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Course;
use App\Models\Files;
use Illuminate\Http\Request;
use Auth;
use Log;

class ManageController extends Controller
{
    public function manage(){

        $user = new User;
        $files = new Files;
        $getRole = User::all();
        $userDetails = $user->getData('id',Auth::id());
        $directorSignature = $files->getAllActiveFileByUserByParameter('type',0);

        $user_type = $userDetails->type;
        $prefix = $userDetails->prefix;
        $suffix = $this->getSuffix();
        $fname = $userDetails->fname;
        $lname = $userDetails->lname;

        $ids = [1,2,3,4];
        $user2 = User::whereIn('type', $ids)->get();
        $role= '';

        // if( $user->type == 1){
        //     $role= "Professor";   
        // }elseif($user->type == 2){
        //     $role = "Director";
        // }elseif($user->type == 3){
        //     $role = "Secretary/Clerks";
        // }elseif($user->type == 4){
        //     $role = "Registrar";
        // }else {
        //     $role = "Unidentified";
        // }

        return view('secretary/manage', ['user' => $user2, 'role'=>$role], compact('user_type','prefix','suffix','fname','lname'));
    }
    
    public function userChangeStatus(Request $request)
    {
    	Log::info($request->all());
        $user2 = User::find($request->user_id);
        $user2->status = $request->status;
        $user2->save();
  
        return response()->json(['success'=>'Status change successfully.']);
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
}
