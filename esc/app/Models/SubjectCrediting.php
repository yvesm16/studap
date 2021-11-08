<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class SubjectCrediting extends Model
{
    use HasFactory;

    public function getLastID(){
      return DB::table('subject_crediting')
        ->max('id');
    }

    public function insertData($data){
      DB::table('subject_crediting')
        ->insert($data);
    }

    public function getAllDataByCreditIDPDF($id){
      return DB::table('subject_crediting')
        ->join('users','users.id','=','subject_crediting.admin_id')
        ->join('files','files.user_id','=','subject_crediting.admin_id')
        ->where('files.status',1)
        ->where('subject_crediting.credit_course_id',$id)
        ->select(DB::raw('
            subject_crediting.id as id,
            subject_crediting.slug as slug,
            subject_crediting.course_abbr as course_abbr,
            subject_crediting.course_title as course_title,
            subject_crediting.equivalent_course_abbr as equivalent_course_abbr,
            subject_crediting.equivalent_course_title as equivalent_course_title,
            subject_crediting.remarks as remarks,
            users.fname as fname,
            users.lname as lname,
            files.path as path,
            subject_crediting.status as status
        '))
        ->get();
    }

    public function getAllDataByCreditID($id){
      return DB::table('subject_crediting')
        ->where('credit_course_id',$id)
        ->get();
    }

    public function updateDataByID($id,$data){
      DB::table('subject_crediting')
        ->where('id',$id)
        ->update($data);
    }

    public function getAllDataBySlugAndByStatus($slug,$status){
      return DB::table('subject_crediting')
        ->where('slug',$slug)
        ->where('status',$status)
        ->get();
    }

}
