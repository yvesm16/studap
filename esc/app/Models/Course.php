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

}
