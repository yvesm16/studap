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

class UpdateCreditCourse extends Mailable
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

      return $this->view('emails.updateCreditCourse')
        ->with([
          'concerns' => $creditDetails->concerns,
          'contact_number' => $creditDetails->contact_number,
          'target_fname' => $user->getData('id',Session::get('next_target_id'))->fname,
          'target_lname' => $user->getData('id',Session::get('next_target_id'))->lname,
          'student_fname' => $user->getData('id',$creditDetails->student_id)->fname,
          'student_lname' => $user->getData('id',$creditDetails->student_id)->lname
        ]);
    }
}
