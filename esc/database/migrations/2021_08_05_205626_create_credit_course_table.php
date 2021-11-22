<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditCourseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
          $table->increments('id');
          $table->string('slug',225);
          $table->integer('user_id')->unsigned()->comment('User');
          $table->foreign('user_id')->references('id')->on('users');
          $table->integer('credit_course_id')->unsigned()->comment('Credit Course ID')->nullable();
          $table->foreign('credit_course_id')->references('id')->on('credit_course');
          $table->integer('appeal_id')->unsigned()->comment('Student Appeal ID')->nullable();
          $table->foreign('appeal_id')->references('id')->on('appeal');
          $table->string('path',225);
          $table->integer('type')->comment('0-Signature|1-Document');
          $table->integer('status')->comment('0-Inactive|1-Active');
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
        Schema::dropIfExists('files');
    }
}
