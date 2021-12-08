<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfessorAppointmentSchedule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('professor_schedule', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug',225);
            $table->integer('professor_id')->unsigned()->comment('Professor');
            $table->foreign('professor_id')->references('id')->on('users');
            $table->integer('department');
            $table->integer('student_id')->unsigned()->comment('Student')->nullable();
            $table->foreign('student_id')->references('id')->on('users');
            $table->string('title');
            $table->datetime('start_time');
            $table->datetime('end_time');
            $table->string('concerns')->nullable();
            $table->string('concerns_others')->nullable();
            $table->string('meeting_link')->nullable();
            $table->string('remarks')->nullable();
            $table->integer('status')->comment('0-Pending|1-Approved|2-Disapproved|3-Ongoing|4-Complete');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('professor_schedule');
    }
}
