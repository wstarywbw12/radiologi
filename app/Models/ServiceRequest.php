<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    protected $connection = 'satusehat';
    protected $table = 'service_request';

    public $timestamps = false;

    protected $fillable = [
        'connection_name',
        'satusehat_id',
        'request_param'
    ];
}
