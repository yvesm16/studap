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

        $target_suffix = '';
        if($user->getData('id',Session::get('target_id'))->type == 0) {
          $target_suffix = '- Student';
        } else if($user->getData('id',Session::get('target_id'))->type == 1) {
          $target_suffix = '- Academic Official';
        } else if($user->getData('id',Session::get('target_id'))->type == 2) {
          $target_suffix = '- Admin Official';
        } 

        $with_suffix = '';
        if($user->getData('id',Session::get('with_id'))->type == 0) {
          $with_suffix = '- Student';
        } else if($user->getData('id',Session::get('with_id'))->type == 1) {
          $with_suffix = '- Academic Official';
        } else if($user->getData('id',Session::get('with_id'))->type == 2) {
          $with_suffix = '- Admin Official';
        } 

        return $this->view('emails.scheduleConsultationReminder')
          ->with([
            'meeting_link' => $scheduleDetails->meeting_link,
            'start_time' => $scheduleDetails->start_time,
            'end_time' => $scheduleDetails->end_time,
            'target_prefix' => $user->getData('id',Session::get('target_id'))->prefix,
            'target_suffix' => $target_suffix,
            'target_fname' => $user->getData('id',Session::get('target_id'))->fname,
            'target_lname' => $user->getData('id',Session::get('target_id'))->lname,
            'with_prefix' => $user->getData('id',Session::get('with_id'))->prefix,
            'with_suffix' => $with_suffix,
            'with_fname' => $user->getData('id',Session::get('with_id'))->fname,
            'with_lname' => $user->getData('id',Session::get('with_id'))->lname
          ]);
    }
}
