<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    protected $fillable = [
        'client_id',
        'alias',
        'type',
        'breed',
        'color',
    ];

//    protected $fillable = [
//        'owner_id',
//        'alias',
//        'type_id',
//        'breed_id',
//        'sex',
//    ];

    public static function create(array $array)
    {
    }
}
