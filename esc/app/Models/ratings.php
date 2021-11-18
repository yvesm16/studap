<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ratings extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'rating'
    ];

    // public static function getRate() {
    //     $data = UserDetail::select('rating')->get()->toArray();

    //     $structuredData = array_map(function ($item){
    //         return ($item['rating']);
    //     }, $data);
    //     // dd($data, $structuredData);
    //     return $structuredData;
    // }
}

