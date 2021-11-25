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

class CreditCourseRequest extends Mailable
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
      $chairperson_id = $course->getCourseByID($creditDetails->new_course_id);

      return $this->view('emails.creditCourseRequest')
        ->with([
          'concerns' => $creditDetails->concerns,
          'contact_number' => $creditDetails->contact_number,
          'chairperson_fname' => $user->getData('id',$chairperson_id->chairperson)->fname,
          'chairperson_lname' => $user->getData('id',$chairperson_id->chairperson)->lname,
          'student_fname' => $user->getData('id',$creditDetails->student_id)->fname,
          'student_lname' => $user->getData('id',$creditDetails->student_id)->lname
        ]);
    }
}
