<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    protected $fillable = [
        'client_id',
        'name',
        'type',
        'breed',
        'color',
        'age',
    ];

    public static function create(array $array)
    {
    }
}
