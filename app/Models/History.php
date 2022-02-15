<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'user_id',
        'status_code',
        'mount',
        'destination_code',
        'source_code_id',
        'tackle_id',
        'message',
        'code',
    ];


    protected $hidden = [
        'id',
        'user_id',
        'created_at',
        'updated_at'
    ];

}
