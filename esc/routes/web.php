<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\CreditController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('login', ['as' => 'login', 'uses' => 'UserController@login']);

Route::get('register', function () {
    return view('register');
});

Route::get('verifyEmail/{slug}', [UserController::class, 'verifyUser']);

Route::get('reset-password/{slug}', function ($slug) {
    return view('resetPassword',['slug' => $slug]);
});

Route::match(array('GET', 'POST'), 'forgotPassword',[UserController::class, 'forgotPassword']);
Route::match(array('GET', 'POST'), 'resetPassword',[UserController::class, 'resetPassword']);

Route::match(array('GET', 'POST'), 'checkLogin',[UserController::class, 'checkLogin']);

Route::get('emailRegistration', function () {
    return view('emails.registration');
});

Route::match(array('GET', 'POST'), 'postRegister',[UserController::class, 'insertData']);

Route::group(['middleware' => 'auth'], function(){

    Route::group(['prefix' => 'student'], function(){
      Route::match(array('GET', 'POST'), 'home',[UserController::class, 'studentHome']);
      Route::match(array('GET', 'POST'), 'schedule',[ScheduleController::class, 'studentSchedule']);
      Route::match(array('GET', 'POST'), 'postConsultation',[ScheduleController::class, 'postConsultation']);
      Route::match(array('GET', 'POST'), 'getProfessorSchedule',[ScheduleController::class, 'getProfessorSchedule']);
      Route::match(array('GET', 'POST'), 'tracker/consultation',[ScheduleController::class, 'trackerConsultation']);
      Route::match(array('GET', 'POST'), 'getStudentID',[UserController::class, 'getStudentID']);
      Route::match(array('GET', 'POST'), 'postStudentID',[UserController::class, 'postStudentID']);
      Route::match(array('GET', 'POST'), 'getCourses',[UserController::class, 'getCourses']);
      Route::match(array('GET', 'POST'), 'tracker/crediting',[CreditController::class, 'getTrackerCrediting']);
      Route::match(array('GET', 'POST'), 'getStudentCreditDetails',[CreditController::class, 'getStudentCreditDetails']);
      // Route::match(array('GET', 'POST'), 'tracker/crediting/details/{slug}',[CreditController::class, 'trackerCreditingDetailsPage']);
      Route::match(array('GET', 'POST'), 'crediting',[CreditController::class, 'studentForm']);
      Route::match(array('GET', 'POST'), 'postCredit',[CreditController::class, 'postCredit']);
    });

    Route::group(['prefix' => 'professor'], function(){
      Route::match(array('GET', 'POST'), 'home',[UserController::class, 'professorHome']);
      Route::match(array('GET', 'POST'), 'schedule',[ScheduleController::class, 'getUserSchedule']);
      Route::match(array('GET', 'POST'), 'getProfessorSchedule',[ScheduleController::class, 'getProfessorSchedule']);
      Route::match(array('GET', 'POST'), 'postSlot',[ScheduleController::class, 'postSlot']);
      Route::match(array('GET', 'POST'), 'updateSlotStatus',[ScheduleController::class, 'updateSlotStatus']);
      Route::match(array('GET', 'POST'), 'getSlotDetails',[ScheduleController::class, 'getSlotDetails']);
      Route::match(array('GET', 'POST'), 'updateSlotDetails',[ScheduleController::class, 'updateSlotDetails']);
      Route::match(array('GET', 'POST'), 'requests/{status}',[ScheduleController::class, 'requestPage']);
      Route::match(array('GET', 'POST'), 'updateAppointmentStatus',[ScheduleController::class, 'updateAppointmentStatus']);
      Route::match(array('GET', 'POST'), 'getAppointmentDetails',[ScheduleController::class, 'getAppointmentDetails']);
      Route::match(array('GET', 'POST'), 'updateMeeting',[ScheduleController::class, 'updateMeeting']);
      Route::match(array('GET', 'POST'), 'crediting/{id}',[UserController::class, 'chairpersonCredit']);
      Route::match(array('GET', 'POST'), 'crediting/details/{slug}',[CreditController::class, 'chairpersonCreditDetailsPage']);
      Route::match(array('GET', 'POST'), 'uploadSignature',[UserController::class, 'uploadSignature']);
      Route::match(array('GET', 'POST'), 'getSignature',[UserController::class, 'getSignature']);
    });

    Route::group(['prefix' => 'director'], function(){
      Route::match(array('GET', 'POST'), 'home',[UserController::class, 'directorHome']);
      Route::match(array('GET', 'POST'), 'uploadSignature',[UserController::class, 'uploadSignature']);
      Route::match(array('GET', 'POST'), 'getSignature',[UserController::class, 'getSignature']);
      Route::match(array('GET', 'POST'), 'crediting/{id}',[UserController::class, 'directorCredit']);
      Route::match(array('GET', 'POST'), 'crediting/details/{slug}',[CreditController::class, 'directorCreditDetailsPage']);
    });

    Route::group(['prefix' => 'secretary'], function(){
      Route::match(array('GET', 'POST'), 'home',[UserController::class, 'secretaryHome']);
      Route::match(array('GET', 'POST'), 'crediting/{id}',[UserController::class, 'secretaryCredit']);
      Route::match(array('GET', 'POST'), 'crediting/details/{slug}',[CreditController::class, 'secretaryCreditDetailsPage']);
    });

    Route::group(['prefix' => 'credit'], function(){
      Route::match(array('GET', 'POST'), 'getSubjectCreditStatus',[CreditController::class, 'getSubjectCreditStatus']);
      Route::match(array('GET', 'POST'), 'updateDetails',[CreditController::class, 'updateDetails']);
      Route::match(array('GET', 'POST'), 'updateCreditStatus',[CreditController::class, 'updateCreditStatus']);
    });

    Route::group(['prefix' => 'assistant'], function(){
      Route::match(array('GET', 'POST'), 'home',[UserController::class, 'studentHome']);
    });

    Route::match(array('GET', 'POST'), 'ajax','AjaxController@ajax');
    Route::match(array('GET', 'POST'), 'logout',[UserController::class, 'logout']);
    Route::match(array('GET', 'POST'), 'changePassword',[UserController::class, 'changePassword']);
    Route::match(array('GET', 'POST'), 'getNotification',[NotificationController::class, 'getNotification']);
    Route::match(array('GET', 'POST'), 'getNotificationDetails',[NotificationController::class, 'getNotificationDetails']);
    Route::match(array('GET', 'POST'), 'updateNotificationStatus',[NotificationController::class, 'updateNotificationStatus']);

    Route::match(array('GET', 'POST'), 'crediting/details/pdf/{slug}',[CreditController::class, 'detailsPagePDF']);

});
