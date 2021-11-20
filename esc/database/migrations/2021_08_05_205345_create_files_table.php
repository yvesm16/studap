<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credit_course', function (Blueprint $table) {
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
          $table->string('institute',225);
          $table->integer('status')->comment('0-Pending|1-EvaluatedByProfessor|2-EvaluatedByDirector|3-EvaluatedByRegistrar/Done');
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
        Schema::dropIfExists('credit_course');
    }
}
