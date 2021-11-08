<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Schedule;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Session;

class CreditCourse extends Mailable
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
        $schedule = new Schedule;
        $scheduleDetails = $schedule->getDataByID(Session::get('slug'));
        return $this->view('emails.creditCourse')
          ->with([
            'slug' => Session::get('slug'),
            'student_fname' => Session::get('fname'),
            'student_lname' => Session::get('lname')
          ]);
    }
}
