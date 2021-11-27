<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Schedule;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Session;

class ScheduleConsultationReminder extends Mailable
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
        $scheduleDetails = $schedule->getDataByID(Session::get('schedule_id'));
        return $this->view('emails.scheduleConsultationReminder')
          ->with([
            'meeting_link' => $scheduleDetails->meeting_link,
            'start_time' => $scheduleDetails->start_time,
            'end_time' => $scheduleDetails->end_time,
            'target_fname' => $user->getData('id',Session::get('target_id'))->fname,
            'target_lname' => $user->getData('id',Session::get('target_id'))->lname,
            'with_fname' => $user->getData('id',Session::get('with_id'))->fname,
            'with_lname' => $user->getData('id',Session::get('with_id'))->lname
          ]);
    }
}
