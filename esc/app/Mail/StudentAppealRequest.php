<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Appeal;
use App\Models\Course;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Session;

class StudentAppealRequest extends Mailable
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
      $appeal = new Appeal;
      $course = new Course;
      
      $appointmentDetails = $appeal->getDataByID(Session::get('appeal_id'));
      $director_id = $course->getCourseByID($appointmentDetails->new_course_id);

      return $this->view('emails.studentAppealRequest')
        ->with([
          'director_fname' => $user->getData('id',$director_id->director)->fname,
          'director_lname' => $user->getData('id',$director_id->director)->lname,
          'student_fname' => $user->getData('id',$appointmentDetails->student_id)->fname,
          'student_lname' => $user->getData('id',$appointmentDetails->student_id)->lname
        ]);
    }
}
