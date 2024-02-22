<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Command extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'commands'];

    protected $casts = [
        'commands' => 'array',
    ];

    protected $hidden = ['created_at',  'updated_at'];

    public function __toString()
    {
        $commands = collect($this->commands)->join(",");
        return "Command (name: {$this->name}, description: {$this->description}), command: [{$commands}])";
    }
}
