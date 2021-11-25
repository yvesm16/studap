<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class Schedule extends Model
{
    use HasFactory;
    public $table = 'professor_schedule';

    public function getAllApprovedScheduleByParameter($column,$param){
      return DB::table('professor_schedule')
        ->where($column,$param)
        ->whereIn('status', [1, 3, 4])
        ->get();
    }

    public function getDataTable($id){
      return DB::table('professor_schedule')
        ->join('users','users.id','=','professor_schedule.professor_id')
        ->where('professor_schedule.student_id',$id)
        ->select(DB::raw('
            professor_schedule.id as id,
            professor_schedule.slug as slug,
            users.fname as fname,
            users.lname as lname,
            professor_schedule.created_at as created_at,
            professor_schedule.start_time as start_time,
            professor_schedule.status as status
        '));
    }

    public function getSlotDataTable($id){
      return DB::table('professor_schedule')
        ->where('professor_id',Auth::id())
        ->where('student_id',null)
        ->select(DB::raw('
            id,
            slug,
            title,
            start_time,
            end_time,
            status
        '));
    }

    public function getCountByStatus($status,$column){
      if($column == 'professor_id'){
        return DB::table('professor_schedule')
          ->where('status',$status)
          ->where('student_id','<>','')
          ->where($column,Auth::id())
          ->count();
      }else{
        return DB::table('professor_schedule')
          ->where('status',$status)
          ->where($column,Auth::id())
          ->count();
      }
    }

    public function getLastID(){
      return DB::table('professor_schedule')
        ->max('id');
    }

    public function insertData($data){
      DB::table('professor_schedule')
        ->insert($data);
    }

    public function checkSlotOverlap($date,$column,$id){
      return DB::table('professor_schedule')
        ->where($column,$id)
        ->where('start_time','<=',$date)
        ->where('end_time','>',$date)
        ->whereIn('status', [0, 1, 3, 4])
        ->count();
    }

    public function checkExistingSlotOverlap($date){
      return DB::table('professor_schedule')
        ->where('professor_id',Auth::id())
        ->where('start_time','<=',$date)
        ->where('end_time','>',$date)
        ->where('status','=',1)
        ->orWhere('status','=',3)
        ->count();
    }

    public function getDataByID($id){
      return DB::table('professor_schedule')
        ->where('id',$id)
        ->first();
    }

    public function updateDataByID($data,$id){
      DB::table('professor_schedule')
        ->where('id',$id)
        ->update($data);
    }

    public function getAppointmentRequest($status){
      if($status == 1){
        return DB::table('professor_schedule')
          ->join('users','users.id','=','professor_schedule.student_id')
          ->where('professor_schedule.professor_id',Auth::id())
          ->whereIn('professor_schedule.status',[1,3])
          ->select(DB::raw('
              professor_schedule.id as id,
              professor_schedule.slug as slug,
              users.fname as fname,
              users.lname as lname,
              users.email as email,
              professor_schedule.created_at as created_at,
              professor_schedule.start_time as start_time,
              professor_schedule.end_time as end_time,
              professor_schedule.concerns as concerns,
              professor_schedule.concerns_others as concerns_others,
              professor_schedule.status as status
          '));
      }else{
        return DB::table('professor_schedule')
          ->join('users','users.id','=','professor_schedule.student_id')
          ->where('professor_schedule.professor_id',Auth::id())
          ->where('professor_schedule.status',$status)
          ->select(DB::raw('
              professor_schedule.id as id,
              professor_schedule.slug as slug,
              users.fname as fname,
              users.lname as lname,
              users.email as email,
              professor_schedule.created_at as created_at,
              professor_schedule.start_time as start_time,
              professor_schedule.end_time as end_time,
              professor_schedule.concerns as concerns,
              professor_schedule.concerns_others as concerns_others,
              professor_schedule.status as status
          '));
      }
    }

}
