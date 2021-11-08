<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class AuditTrail extends Model
{
    use HasFactory;

    public function getLastID(){
      return DB::table('audit_trail')
        ->max('id');
    }

    public function insertData($data){
      DB::table('audit_trail')
        ->insert($data);
    }

    public function getAllDataByParameter($column,$id){
      return DB::table('audit_trail')
        ->where($column,$id)
        ->get();
    }

    public function getAllLoginUserDataByStatus($status){
      return DB::table('audit_trail')
        ->join('users','users.id','=','audit_trail.triggeredBy')
        ->join('professor_schedule','professor_schedule.id','=','audit_trail.row_id')
        ->where('audit_trail.targetReceiver',Auth::id())
        ->where('audit_trail.status',$status)
        ->orderBy('audit_trail.created_at')
        ->select(DB::raw('
              audit_trail.id as id,
              users.fname as fname,
              users.lname as lname,
              professor_schedule.status as schedule_status,
              audit_trail.status as audit_status
        '))
        ->get();
    }

    public function getAllLoginAdminDataByStatus($status){
      return DB::table('audit_trail')
        ->join('users','users.id','=','audit_trail.triggeredBy')
        ->join('credit_course','credit_course.id','=','audit_trail.row_id')
        ->where('audit_trail.targetReceiver',Auth::id())
        ->where('audit_trail.status',$status)
        ->orderBy('audit_trail.created_at')
        ->select(DB::raw('
              audit_trail.id as id,
              users.fname as fname,
              users.lname as lname,
              credit_course.status as schedule_status,
              audit_trail.status as audit_status
        '))
        ->get();
    }

    public function getAllLoginStudentDataByStatus($status){
      return DB::table('audit_trail')
        ->join('users','users.id','=','audit_trail.triggeredBy')
        ->where('audit_trail.targetReceiver',Auth::id())
        ->where('audit_trail.status',$status)
        ->orderBy('audit_trail.created_at')
        ->select(DB::raw('
              audit_trail.id as id,
              users.fname as fname,
              users.lname as lname,
              audit_trail.status as audit_status
        '))
        ->get();
    }

    public function updateLoginUserData($data){
      DB::table('audit_trail')
        ->where('targetReceiver',Auth::id())
        ->update($data);
    }

    public function getDataByID($id){
      return DB::table('audit_trail')
        ->where('id',$id)
        ->first();
    }

}
