<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Files;
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

        return view('secretary/manage', ['user' => $user2, 'role'=>$role], compact('fname','lname'));
    }
    
    public function userChangeStatus(Request $request)
    {
    	Log::info($request->all());
        $user2 = User::find($request->user_id);
        $user2->status = $request->status;
        $user2->save();
  
        return response()->json(['success'=>'Status change successfully.']);
    }
}
