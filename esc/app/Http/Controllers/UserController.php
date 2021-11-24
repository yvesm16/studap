<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Files;
use App\Models\Course;
use App\Models\Appeal;
use App\Models\Credit;
use App\Models\ratings;
use Mailgun\Mailgun;
use Redirect;
use Hash;
use DB;
use Session;
use Response;
use Auth;

class UserController extends Controller
{

    public function login(){
      return view('index');
    }
  
    public function insertData(Request $request){
      $user = new User;

      if($user->getLastID() == null){
        $slug = md5(0);
      }else{
        $slug = md5($user->getLastID());
      }
  
      if(strlen($request->input('pwd'))<=8 || preg_match("#[0-9]+#", $request->input('pwd')) || preg_match("#[a-z]+#", $request->input('pwd')) || 
      preg_match("#[A-Z]+#", $request->input('pwd')) || preg_match("/[\'^£$%&*()}{@#~?><>,|=_+!-]/", $request->input('pwd'))) {
      if($request->input('pwd') == $request->input('rpwd')){
        $data = [
          'fname' => $request->input('fname'),
          'lname' => $request->input('lname'),
          'email' => $request->input('email'),
          'slug' => $slug,
          'password' => Hash::make($request->input('pwd')),
          'type' => $request->input('type'),
          'verified' => 0,
          'status' => 0
        ];
      
        if (str_contains($request->email, '@ust.edu.ph')) {
            $userDetails = $user->getData('email',$request->email);
            if($userDetails == null){
              $user->insertData($data);
              // if(env('APP_ENV') == 'local'){
                // \Mail::to(env('APP_EMAIL'))->send(new \App\Mail\Registration());
              // }else{
                // \Mail::to($request->email)->send(new \App\Mail\Registration());
              // }

              try {
                \Mail::to($request->email)->send(new \App\Mail\Registration());
              } catch(Exception $e) {
                return Response::json(array(
                    'success' => true
                ));
              }

              return Redirect::to('register')
                ->withInput()
                ->with('success','Verification Link has been sent to your email');
            }else{
              return Redirect::to('register')
                ->withInput()
                ->with('error','Account already exists!');
            }
        }else{
          return Redirect::to('register')
            ->withInput()
            ->with('error','Only your UST account shall be used for this website!');
        }
      }else{
        return Redirect::to('register')
          ->withInput()
          ->with('error','Password does not match!');
      }
    }else {
      return Redirect::to('register')
          ->withInput()
          ->with('error','Must contain 8 characters, capital letters, numbers, and special characters');
    }
  
    }

    public function verifyUser($slug){
      $user = new User;

      $userDetails = $user->getData('slug',$slug);

      if($userDetails->verified < 1){
        DB::table('users')
          ->where('slug',$slug)
          ->update([
            'verified' => 1,
            'status' => 1
          ]);

        return Redirect::to('/')
          ->with('success','Account is now verified!');
      }else{
        return Redirect::to('/')
          ->with('error','Account is already verified!');
      }
    }

    public function forgotPassword(Request $request){
      $user = new User;

      $userDetails = $user->getData('email',$request->input('email'));

      if($userDetails != null){
        session()->put('slug', $userDetails->slug);

        // if(env('APP_ENV') == 'local'){
        //   \Mail::to(env('APP_EMAIL'))->send(new \App\Mail\ResetPassword());
        // }else{
        //   \Mail::to($userDetails->email)->send(new \App\Mail\ResetPassword());
        // }

        try {
          \Mail::to($userDetails->email)->send(new \App\Mail\ResetPassword());
        } catch(Exception $e) {
          return Response::json(array(
              'success' => true
          ));
        }

        return Response::json(array(
            'success' => true
        ));

      }else{
        return Response::json(array(
            'success' => false
        ));
      }
    }

    public function resetPassword(Request $request){
      if(strlen($request->input('pwd'))<=8 || preg_match("#[0-9]+#", $request->input('pwd')) || preg_match("#[a-z]+#", $request->input('pwd')) || 
      preg_match("#[A-Z]+#", $request->input('pwd')) || preg_match("/[\'^£$%&*()}{@#~?><>,|=_+!-]/", $request->input('pwd'))) {
      if($request->input('pwd') == $request->input('cpwd')){

        $data = [
          'password' => Hash::make($request->input('pwd'))
        ];

        DB::table('users')
          ->where('slug',$request->input('slug'))
          ->update($data);

        return Redirect::to('/')
          ->with('success','Password was updated!');
      }else{
        return Redirect::to('reset-password/' . $request->input('slug'))
          ->with('error','Password mistmatch!');
      }
    }else {
      return Redirect::to('reset-password/' . $request->input('slug'))
          ->with('error','Must contain 8 characters, capital letters, numbers, and special characters');
    }
    }

    public function checkLogin(Request $request){
      $user = new User;
      $userDetails = $user->getData('email',$request->input('email'));

      if($userDetails != null){
        if($userDetails->verified > 0 && $userDetails->status > 0){
          if(Hash::check($request->input('pwd'),$userDetails->password)){
            Auth::loginUsingId($userDetails->id);
            if($userDetails->type == 0){
              return Redirect::to('student/home');
            }elseif($userDetails->type == 1){
              return Redirect::to('professor/home');
            }elseif($userDetails->type == 2){
              return Redirect::to('director/home');
            }elseif($userDetails->type == 3){
              return Redirect::to('secretary/home');
            }elseif($userDetails->type == 4){
              return Redirect::to('registrar/home');
            }else{
              return Redirect::to('professor/home');
            }
          }else{
            return Redirect::to('/')
              ->with('error','Invalid email/password!');
          }
        }else{
          return Redirect::to('/')
            ->with('error','Account is inactive!');
        }
      }else{
        return Redirect::to('/')
          ->with('error','Invalid email/password!');
      }

    }

    public function studentHome(){
      $user = new User;
      $userDetails = $user->getData('id',Auth::id());

      $data = [
        'id' => Auth::id(),
        'fname' => $userDetails->fname,
        'lname' => $userDetails->lname
      ];

      return view('student.index',$data);
    }

    private function isProfessorChairperson($id){
      $course = new Course;
      $course_details = $course->getChairperson($id);

      return $course_details ? true : false;
    }

    public function professorHome(){
      $user = new User;
      $files = new Files;

      $userDetails = $user->getData('id',Auth::id());
      $chairpersonSignature = $files->getAllActiveFileByUserByParameter('type',0);

      $data = [
        'id' => Auth::id(),
        'fname' => $userDetails->fname,
        'lname' => $userDetails->lname,
        'signature' => $chairpersonSignature,
        'isProfessorChairperson' => $this->isProfessorChairperson(Auth::id())
      ];

      return view('professor.index',$data);
    }

    public function directorHome(){
      $user = new User;
      $files = new Files;

      $userDetails = $user->getData('id',Auth::id());
      $directorSignature = $files->getAllActiveFileByUserByParameter('type',0);

      $data = [
        'id' => Auth::id(),
        'fname' => $userDetails->fname,
        'lname' => $userDetails->lname,
        'signature' => $directorSignature
      ];

      return view('director.index',$data);
    }

    public function secretaryHome(){
      $user = new User;
      $files = new Files;

      $userDetails = $user->getData('id',Auth::id());
      $secretarySignature = $files->getAllActiveFileByUserByParameter('type',0);

      $data = [
        'id' => Auth::id(),
        'fname' => $userDetails->fname,
        'lname' => $userDetails->lname,
        'signature' => $secretarySignature
      ];

      return view('secretary.index',$data);
    }

    public function registrarHome(){
      $user = new User;
      $files = new Files;

      $userDetails = $user->getData('id',Auth::id());
      $registrarSignature = $files->getAllActiveFileByUserByParameter('type',0);

      $data = [
        'id' => Auth::id(),
        'fname' => $userDetails->fname,
        'lname' => $userDetails->lname,
        'signature' => $registrarSignature
      ];

      return view('registrar.index',$data);
    }

    private function getCredit($pending_status,$completed_status){
      $user = new User;
      $files = new Files;
      $credit = new Credit;
      $userDetails = $user->getData('id',Auth::id());

      $data = [
        'id' => Auth::id(),
        'fname' => $userDetails->fname,
        'lname' => $userDetails->lname
      ];

      if ($userDetails->type != 1) {
        $data['pending'] = $credit->countByStatus($pending_status);
        $data['completed'] = $credit->countByGreaterThanStatus($completed_status);
      } else {
        $data['pending'] = $credit->countByStatusForChairperson($pending_status);
        $data['completed'] = $credit->countByGreaterThanStatusForChairperson($completed_status);
      }

      if ($userDetails->type != 3) {
        $signature = $files->getAllActiveFileByUserByParameter('type',0);
        $data['signature'] = $signature;
      }

      return $data;
    }

    public function chairpersonCredit(){
      $data = $this->getCredit(0,0);
      $data['isProfessorChairperson'] = $this->isProfessorChairperson(Auth::id());
      return view('professor.credit',$data);
    }

    public function directorCredit(){
      $data = $this->getCredit(1,1);
      return view('director.credit',$data);
    }

    public function secretaryCredit(){
      $data = $this->getCredit(2,2);
      return view('secretary.credit',$data);
    }

    public function registrarCredit(){
      $data = $this->getCredit(2,2);

      return view('registrar.credit',$data);
    }

    private function getAppeal($status){
      $user = new User;
      $files = new Files;
      $appeal = new Appeal;
      $userDetails = $user->getData('id',Auth::id());

      $data = [
        'id' => Auth::id(),
        'fname' => $userDetails->fname,
        'lname' => $userDetails->lname
      ];

      $data['pending'] = $appeal->countByStatus(0);
      $data['scheduled'] = $appeal->countByStatus(1);
      $data['completed'] = $appeal->countByStatus($status);
      $data['declined'] = $appeal->countByStatus(3);

      if ($userDetails->type != 3) {
        $signature = $files->getAllActiveFileByUserByParameter('type',0);
        $data['signature'] = $signature;
      }

      return $data;
    }

    public function directorAppeal(){
      $data = $this->getAppeal(2);
      return view('director.appeal',$data);
    }

    public function logout(Request $request){
      Auth::logout();
      $request->session()->invalidate();
      $request->session()->regenerateToken();
      return redirect('/');
    }

    public function changePassword(Request $request){ 
      $user = new User;
      $userDetails = $user->getData('id',Auth::id());
      if(strlen($request->input('pwd'))<=8 || preg_match("#[0-9]+#", $request->input('pwd')) || preg_match("#[a-z]+#", $request->input('pwd')) || 
      preg_match("#[A-Z]+#", $request->input('pwd')) || preg_match("/[\'^£$%&*()}{@#~?><>,|=_+!-]/", $request->input('pwd'))) {
        if(Hash::check($request->currentPassword,$userDetails->password)){
        
          if($request->newPassword == $request->confirmPassword){
            $data = [
              'password' => Hash::make($request->newPassword)
            ];

            $user->updateData('id',Auth::id(),$data);
            return Response::json(array(
                'result' => true,
                'text' => 'Password was successfully updated!'
            ));
          }else{
            return Response::json(array(
                'result' => false,
                'text' => 'New and confirm password mismatch!'
            ));
          }
        }else{
          return Response::json(array(
            'result' => false,
            'text' => 'Invalid current password!'
        ));
        }
      }else  {
      return Response::json(array(
        'result' => false,
        'text' => 'Must contain 8 characters, capital letters, numbers, and special characters'
      ));
    }
    } 
    

    public function addUser(Request $request) {
      $user = new User;
      $slug = md5($user->getLastID());
        if(str_contains($request->email, 'ust.edu.ph')) {
          $data = [
            'fname' => $request->input('fname'),
            'lname' => $request->input('lname'),
            'email' => $request->input('email'),
            'slug' => $slug,
            'password' => Hash::make($request->input('tempPassword')),
            'type' => $request->input('type'),
            'verified' => 1,
            'status' => 0
          ];
          $user->insertData($data);

          return back()->with('success','New User has been successfully added');

        }else {
          return back()->with('warning','Input UST Email only. Try Again');
        }

    
      return back();
    }

    public function uploadSignature(Request $request){
      $user = new User;
      $userDetails = $user->getData('id',Auth::id());

      if($userDetails->type == 1){
        $user_home = 'professor/home';
      }elseif($userDetails->type == 2){
        $user_home = 'director/home';
      }elseif($userDetails->type == 4){
        $user_home = 'registrar/home';
      }else{
        $user_home = 'professor/home';
      }

      if($request->file('fileUpload')->getError() != 1){
        if($request->file('fileUpload') == null){
          return Redirect::to($user_home)
            ->with('failed','Signature was successfully uploaded!');
        }else{
          if($request->file('fileUpload')->extension() != 'jpeg' && $request->file('fileUpload')->extension() != 'jpg' && $request->file('fileUpload')->extension() != 'png'){
            return Redirect::to($user_home)
              ->with('failed','Signature was successfully uploaded!');
          }else{
            if($request->file('fileUpload')->getSize() > 2097152){
              return Redirect::to($user_home)
                ->with('failed','Signature was successfully uploaded!');
            }else{
              $files = new Files;

              $lastID = $files->getLastID();

              if($lastID == null){
                $lastID = 1;
              }else{
                $lastID += 1;
              }

              $path = $request->file('fileUpload')->store('public/documents');

              $data = [
                'status' => 0
              ];

              $files->updateFilesByUser($data);

              $data = [
                'slug' => md5($lastID),
                'user_id' => Auth::id(),
                'path' => $path,
                'type' => 0,
                'status' => 1
              ];

              $files->insertData($data);

              return Redirect::to($user_home)
                ->with('success','Signature was successfully uploaded!');

              return $request->file('fileUpload')->store('public/documents');
            }
          }
        }
      }else{
        return Redirect::to($user_home)
          ->with('failed','Signature was successfully uploaded!');
      }

    }

    public function getSignature(Request $request){
      $files = new Files;
      $fileDetails = $files->getAllActiveFileByUserByParameter('type',0);

      if(count($fileDetails) == 0){
        return Response::json(array(
            'result' => false,
            'text' => 'Invalid current password!'
        ));
      }else{
        return Response::json(array(
            'result' => true,
            'data' => $fileDetails[0]
        ));
      }

    }

    public function getStudentID(Request $request){
      $user = new User;

      $userDetails = $user->getData('id',Auth::id());

      if($userDetails->student_id == null){
        return Response::json(array(
            'result' => false
        ));
      }else{
        return Response::json(array(
            'result' => true
        ));
      }

    }

    public function postStudentID(Request $request){
      $user = new User;

      $existStudentID = $user->studentIDExist($request->input('student_id'));

      if($existStudentID == null){
        $data = [
          'student_id' => $request->input('student_id'),
          'course_id' => $request->input('course_id')
        ];

        $user->updateData('id',Auth::id(),$data);

        return Response::json(array(
            'result' => true
        ));

      }else{
        return Response::json(array(
            'result' => false
        ));
      }

    }

    public function getCourses(){
      $course = new Course;

      $activeCourses = $course->getAllActiveCourse();

      return Response::json(array(
          'result' => true,
          'data' => $activeCourses
      ));


    }

    public function statisfaction(Request $request) {
      $rate = $request->stars;
      $rating = new ratings;

      if($rate) {
          $rating->rating = $rate;
          $rating->save();

          Session::flash('success', "Your rating has been submitted. Thank you for using ESC E-Services");
          return view('statisfaction');


      }else {
        Session::flash('warning', "An error has occured. Please refresh the page and Try Again");
        return view('statisfaction');
      }

      return view('statisfaction');
    }

}
