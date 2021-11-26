<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class Appeal extends Model
{
    use HasFactory;
    public $table = 'appeal';

    public function getLastID(){
      return DB::table('appeal')
        ->max('id');
    }

    public function getDataBySlug($slug){
      return DB::table('appeal')
        ->where('slug',$slug)
        ->first();
    }

    public function getDataByID($id){
      return DB::table('appeal')
        ->where('id',$id)
        ->first();
    }

    public function insertData($data){
      DB::table('appeal')
        ->insert($data);
    }

    public function countByStatus($status){
      return DB::table('appeal')
        ->where('status',$status)
        ->get();
    }

    public function countByStatusPending($status){
      return DB::table('appeal')
        ->where('status','<',$status)
        ->get();
    }

    public function getAppealByStatusByStudentID($status){
      return DB::table('appeal')
        ->where('status',$status)
        ->where('student_id',Auth::id())
        ->get();
    }

    public function getDataByParameter($column,$data){
      return DB::table('appeal')
        ->where($column,$data)
        ->first();
    }

    public function getCompletedDataTable(){
      return DB::table('appeal')
        ->join('users','users.id','=','appeal.student_id')
        ->join('course','course.id','=','appeal.new_course_id')
        ->where('appeal.status',2)
        ->select(DB::raw('
            appeal.id as id,
            appeal.slug as slug,
            appeal.section as section,
            appeal.contact_number as active_contact_number,
            appeal.email as active_email,
            appeal.status as status,
            users.fname as fname,
            users.lname as lname,
            users.student_id as student_id,
            users.email as email,
            course.text as program
        '));
    }

    public function getDataTableByStatus($status){
      return DB::table('appeal')
        ->join('users','users.id','=','appeal.student_id')
        ->join('course','course.id','=','appeal.new_course_id')
        ->where('appeal.status',$status)
        ->select(DB::raw('
            appeal.id as id,
            appeal.slug as slug,
            appeal.section as section,
            appeal.contact_number as active_contact_number,
            appeal.email as active_email,
            appeal.status as status,
            users.fname as fname,
            users.lname as lname,
            users.student_id as student_id,
            users.email as email,
            course.text as program
        '));
    }

    public function getAllDataTableByStudentID(){
      return DB::table('appeal')
        ->join('users','users.id','=','appeal.student_id')
        ->join('course','course.id','=','appeal.new_course_id')
        ->where('appeal.student_id',Auth::id())
        ->select(DB::raw('
            appeal.id as id,
            appeal.slug as slug,
            appeal.section as section,
            appeal.concerns as concerns,
            appeal.contact_number as active_contact_number,
            appeal.email as active_email,
            appeal.status as status,
            users.fname as fname,
            users.lname as lname,
            users.student_id as student_id,
            users.email as email,
            course.text as program
        '));
    }

    public function updateDataByID($data,$id){
      DB::table('appeal')
        ->where('id',$id)
        ->update($data);
    }

    public function getDataTableForPDF($status){
      return DB::table('appeal')
        ->join('users','users.id','=','appeal.student_id')
        ->where('appeal.status',$status)
        ->select(DB::raw('
            appeal.id as id,
            appeal.slug as slug,
            appeal.section as section,
            appeal.contact_number as active_contact_number,
            appeal.email as active_email,
            appeal.created_at as created_at,
            users.fname as fname,
            users.lname as lname,
            users.student_id as student_id,
            users.email as email
        '))
        ->get();
    }
}
