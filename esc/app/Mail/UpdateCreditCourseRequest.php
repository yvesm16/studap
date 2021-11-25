<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Course;
use App\Models\Credit;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Session;
use Auth;

class UpdateCreditCourseRequest extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct()
    {
      //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      $user = new User;
      $credit = new Credit;
      $course = new Course;
      
      $creditDetails = $credit->getDataByID(Session::get('credit_course_id'));

      if ($creditDetails->status == 0) {
        $status = 'Pending';
      } else if ($creditDetails->status == 1) {
        $status = 'Evaluated By Chairperson';
      } else if ($creditDetails->status == 2) {
        $status = 'Evaluated By Dean';
      } else if ($creditDetails->status == 3) {
        $status = 'Evaluated By Registrar';
      }

      return $this->view('emails.updateCreditCourseRequest')
        ->with([
          'status' => $status,
          'current_fname' => $user->getData('id',Auth::id())->fname,
          'current_lname' => $user->getData('id',Auth::id())->lname,
          'student_fname' => $user->getData('id',$creditDetails->student_id)->fname,
          'student_lname' => $user->getData('id',$creditDetails->student_id)->lname
        ]);
    }
}
