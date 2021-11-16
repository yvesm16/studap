<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class Files extends Model
{
    use HasFactory;

    public function getDataByUserByParameter($column,$data){
      return DB::table('files')
        ->where($column,$data)
        ->where('user_id',Auth::id())
        ->first();
    }

    public function getAllActiveFileByUserByParameter($column,$data){
      return DB::table('files')
        ->where('status',1)
        ->where($column,$data)
        ->where('user_id',Auth::id())
        ->get();
    }
    
    public function getActiveFileByUserByParameter($column,$data){
      return DB::table('files')
        ->where('status',1)
        ->where($column,$data)
        ->where('user_id',Auth::id())
        ->first();
    }

    public function updateFilesByUser($data){
      DB::table('files')
        ->where('user_id',Auth::id())
        ->update($data);
    }

    public function getLastID(){
      return DB::table('files')
        ->max('id');
    }

    public function insertData($data){
      DB::table('files')
        ->insert($data);
    }

}
