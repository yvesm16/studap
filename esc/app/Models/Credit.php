<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class Credit extends Model
{
    use HasFactory;

    public function getLastID(){
      return DB::table('credit_course')
        ->max('id');
    }

    public function insertData($data){
      DB::table('credit_course')
        ->insert($data);
    }

    public function countByStatus($status){
      return DB::table('credit_course')
        ->where('status',$status)
        ->get();
    }

    public function getDataTable($status){
      return DB::table('credit_course')
        ->join('users','users.id','=','credit_course.student_id')
        ->where('credit_course.status',$status)
        ->select(DB::raw('
            credit_course.id as id,
            credit_course.slug as slug,
            users.fname as fname,
            users.lname as lname,
            users.student_id as student_id,
            users.email as email,
            credit_course.section as section,
            credit_course.status as status
        '));
    }

    public function getDataByParameter($column,$data){
      return DB::table('credit_course')
        ->where($column,$data)
        ->first();
    }

    public function updateDataByParamater($column,$param,$data){
      DB::table('credit_course')
        ->where($column,$param)
        ->update($data);
    }

}
