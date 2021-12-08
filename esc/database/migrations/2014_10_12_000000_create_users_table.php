<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

      Schema::create('course', function (Blueprint $table) {
          $table->increments('id');
          $table->string('slug',225);
          $table->string('text');
          $table->integer('chairperson')->unsigned()->comment('user_id')->nullable();
          $table->integer('director')->unsigned()->comment('user_id')->nullable();
          $table->integer('secretary')->unsigned()->comment('user_id')->nullable();
          $table->integer('status')->comment('0-Inactive|1-Active');
          $table->timestamp('created_at')->useCurrent();
          $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
      });

      Schema::create('users', function (Blueprint $table) {
          $table->increments('id');
          $table->string('slug',225);
          $table->string('prefix',225)->nullable(true);
          $table->string('fname',225);
          $table->string('lname',225);
          $table->string('email',225)->unique();
          $table->string('password',225)->nullable(true);
          $table->string('student_id',225)->nullable(true);
          $table->integer('course_id')->unsigned()->comment('Course')->nullable();
          $table->foreign('course_id')->references('id')->on('course');
          $table->integer('type')->comment('0-Student|1-Faculty|2-Director|3-Secretary|4-Registrar|5-Clerk');
          $table->integer('department')->comment('0-IT|1-IS|2-CS|3-staffs')->nullable(true);
          $table->integer('verified')->comment('0 - No | 1 - Yes');
          $table->integer('status')->comment('0 - Inactive | 1 - Active');
          $table->rememberToken();
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
        Schema::dropIfExists('users');
        Schema::dropIfExists('course');
    }
}
