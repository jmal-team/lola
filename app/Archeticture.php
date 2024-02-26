<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archeticture extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'tree'];

    protected $casts = [
        'tree' => 'array',
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
