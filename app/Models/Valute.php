<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Valute extends Model
{
    protected $fillable = [
        'sec_id',
        'name',
        'english_name',
        'alphabetic_code',
        'digit_code',
        'rate'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    
}