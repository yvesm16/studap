<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class Appeal extends Model
{
    use HasFactory;

    public function getLastID(){
      return DB::table('appeal')
        ->max('id');
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

    public function getDataByParameter($column,$data){
      return DB::table('appeal')
        ->where($column,$data)
        ->first();
    }
}
