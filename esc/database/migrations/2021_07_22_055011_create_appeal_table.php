<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppealTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appeal', function (Blueprint $table) {
          $table->increments('id');
          $table->string('slug',225);
          $table->integer('student_id')->unsigned()->comment('User');
          $table->foreign('student_id')->references('id')->on('users');
          $table->integer('new_course_id')->unsigned()->comment('Course');
          $table->foreign('new_course_id')->references('id')->on('course');
          $table->string('section',225);
          $table->string('concerns',225);
          $table->string('contact_number',225);
          $table->string('email',225);
          $table->string('prof_email',225)->nullable();
          $table->datetime('start_time')->nullable();
          $table->datetime('end_time')->nullable();
          $table->string('attached1')->nullable();
          $table->string('attached2')->nullable();
          $table->string('attached3')->nullable();
          $table->string('message')->nullable();
          $table->string('remarks')->nullable();
          $table->integer('status')->comment('0-Pending|1-EvaluatedByDirector|2-OnlineConference/Done');
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
        Schema::dropIfExists('appeal');
    }
}
