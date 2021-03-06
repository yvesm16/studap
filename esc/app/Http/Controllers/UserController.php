<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Files;
use App\Models\Course;
use App\Models\Credit;
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

    public function professorHome(){
      $user = new User;
      $userDetails = $user->getData('id',Auth::id());

      $data = [
        'id' => Auth::id(),
        'fname' => $userDetails->fname,
        'lname' => $userDetails->lname
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

    public function directorCredit(){
      $user = new User;
      $files = new Files;
      $credit = new Credit;
      $userDetails = $user->getData('id',Auth::id());

      $directorSignature = $files->getAllActiveFileByUserByParameter('type',0);

      $data = [
        'id' => Auth::id(),
        'fname' => $userDetails->fname,
        'lname' => $userDetails->lname,
        'signature' => $directorSignature,
        'pending' => $credit->countByStatus(0),
        'completed' => $credit->countByStatus(1)
      ];

      return view('director.credit',$data);
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

    }

    public function uploadSignature(Request $request){
      if($request->file('fileUpload')->getError() != 1){
        if($request->file('fileUpload') == null){
          return Redirect::to('director/home')
            ->with('failed','Signature was successfully uploaded!');
        }else{
          if($request->file('fileUpload')->extension() != 'jpeg' && $request->file('fileUpload')->extension() != 'jpg' && $request->file('fileUpload')->extension() != 'png'){
            return Redirect::to('director/home')
              ->with('failed','Signature was successfully uploaded!');
          }else{
            if($request->file('fileUpload')->getSize() > 2097152){
              return Redirect::to('director/home')
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

              return Redirect::to('director/home')
                ->with('success','Signature was successfully uploaded!');

              return $request->file('fileUpload')->store('documents');
            }
          }
        }
      }else{
        return Redirect::to('director/home')
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


}
