<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $connection = 'wa';
    protected $table = 'devices';

    public $timestamps = false;

    protected $fillable = [
        'name_device'
    ];
}