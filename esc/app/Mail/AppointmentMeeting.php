<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Schedule;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Session;

class AppointmentMeeting extends Mailable
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
        $scheduleDetails = $schedule->getDataByID(Session::get('appointment_id'));
        return $this->view('emails.meetingLink')
          ->with([
            'meeting_link' => $scheduleDetails->meeting_link,
            'start_time' => $scheduleDetails->start_time,
            'end_time' => $scheduleDetails->end_time,
            'professor_fname' => $user->getData('id',$scheduleDetails->professor_id)->fname,
            'professor_lname' => $user->getData('id',$scheduleDetails->professor_id)->lname,
            'student_fname' => $user->getData('id',$scheduleDetails->student_id)->fname,
            'student_lname' => $user->getData('id',$scheduleDetails->student_id)->lname
          ]);
    }
}
