<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectCreditingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subject_crediting', function (Blueprint $table) {
          $table->increments('id');
          $table->string('slug',225);
          $table->integer('credit_course_id')->unsigned()->comment('Credit Course ID');
          $table->foreign('credit_course_id')->references('id')->on('credit_course');
        //   $table->string('course_abbr',225);
        //   $table->string('course_title',225);
        //   $table->string('equivalent_course_abbr',225)->nullable();
        //   $table->string('equivalent_course_title',225)->nullable();
          $table->integer('admin_id')->unsigned()->comment('Admin')->nullable();
          $table->foreign('admin_id')->references('id')->on('users');
          $table->string('remarks',225)->nullable();
          $table->integer('status')->comment('0-Pending|1-EvaluatedByProfessor|2-EvaluatedByDirector|3-EvaluatedByRegistrar|5-Disapproved');
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
        Schema::dropIfExists('subject_crediting');
    }
}
