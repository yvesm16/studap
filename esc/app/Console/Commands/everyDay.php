<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Schedule;
use App\Models\User;
use Session;

class everyDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:everyDay';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will run everyday at 1:00 AM';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = new User;
        $schedule = new Schedule;

        $date_tomorrow = date("Y-m-d", strtotime("tomorrow"));

        $tomorrow_start_time = $date_tomorrow . ' 00:00:00';
        $tomorrow_end_time = $date_tomorrow . ' 23:59:59';

        $reminder_list = $schedule->getApprovedAppointmentForTomorrow($tomorrow_start_time,$tomorrow_end_time);

        foreach($reminder_list as $reminder) {
            Session::put('schedule_id', $reminder->id);
            $studentDetails = $user->getData('id',$reminder->student_id);
            
            Session::put('target_id', $reminder->student_id);
            Session::put('with_id', $reminder->professor_id);
            \Mail::to($studentDetails->email)->send(new \App\Mail\ScheduleConsultationReminder());

            Session::put('target_id', $reminder->professor_id);
            Session::put('with_id', $reminder->student_id);
            $profDetails = $user->getData('id',$reminder->professor_id);
            \Mail::to($profDetails->email)->send(new \App\Mail\ScheduleConsultationReminder());
        }
    }
}
