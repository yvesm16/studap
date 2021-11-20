<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Files;
use Auth;

class ManageController extends Controller
{
    public function manage(){

        $user = new User;
        $files = new Files;
  
        $userDetails = $user->getData('id',Auth::id());
        $directorSignature = $files->getAllActiveFileByUserByParameter('type',0);

        $fname = $userDetails->fname;
        $lname = $userDetails->lname;

        $ids = [1,2,3,4];
        $user2 = User::whereIn('type', $ids)->get();
        $role='';

        // if( $user->type==1){
        //     $role= "Professor";   
        // }elseif(User::where('type',2)){
        //     $role = "Director";
        // }elseif(User::where('type',3)){
        //     $role = "Secretary/Clerks";
        // }elseif(User::where('type',4)){
        //     $role = "Registrar";
        // }else {
        //     $role = "Unidentified";
        // }

        return view('director/manage', ['user' => $user2, 'role'=>$role], compact('fname','lname'));
    }

}
