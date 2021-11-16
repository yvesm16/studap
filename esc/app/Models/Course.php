<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Course extends Model
{
    use HasFactory;

    public function getAllActiveCourse(){
      return DB::table('course')
        ->where('status',1)
        ->get();
    }

    public function getCourseByID($id){
      return DB::table('course')
        ->where('id',$id)
        ->first();
    }

    public function getChairperson($user_id){
      return DB::table('course')
        ->where('chairperson',$user_id)
        ->where('status',1)
        ->first();
    }

    public function getDirector($user_id){
      return DB::table('course')
        ->where('director',$user_id)
        ->where('status',1)
        ->first();
    }

    public function getSecretary($user_id){
      return DB::table('course')
        ->where('secretary',$user_id)
        ->where('status',1)
        ->first();
    }

    public function getActiveCourseDetails($column,$data){
      return DB::table('course')
        ->where($column,$data)
        ->where('status',1)
        ->first();
    }
}
