<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use DB;
use Auth;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getLastID(){
      return DB::table('users')
        ->max('id');
    }

    public function getAllActiveUserByType($type){
      return DB::table('users')
        ->where('status',1)
        ->where('type',$type)
        ->get();
    }

    public function getData($column,$data){
      return DB::table('users')
        ->where($column,$data)
        ->first();
    }

    public function studentIDExist($id){
      return DB::table('users')
        ->where('student_id',$id)
        ->where('id','<>',Auth::id())
        ->first();
    }

    public function insertData($data){
      DB::table('users')
        ->insert($data);
    }

    public function updateData($column,$param,$data){
      DB::table('users')
        ->where($column,$param)
        ->update($data);
    }

    public function getAllDataByParameter($column,$param){
      return DB::table('users')
        ->where($column,$param)
        ->get();
    }

    public function getStudentDataByParameter($column,$param){
      return DB::table('users')
        ->where($column,$param)
        ->where('type',0)
        ->first();
    }

    public function getAllDataByWhereIn($column,$param){
      return DB::table('users')
        ->whereIn($column,$param)
        ->get();
    }
    
    public function getAllDataByWhereInAndByDepartment($column,$param,$department){
      return DB::table('users')
        ->whereIn($column,$param)
        ->where('department',$department)
        ->get();
    }
}
