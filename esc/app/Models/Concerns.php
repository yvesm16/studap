<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Concerns extends Model
{
    use HasFactory;

    public function getAllDataByStatus($status){
      return DB::table('concerns')
        ->where('status',$status)
        ->get();
    }

    public function getDataByID($id){
      return DB::table('concerns')
        ->where('id',$id)
        ->first();
    }

}
