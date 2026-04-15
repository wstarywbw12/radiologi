<?php

namespace App\Models\RS;

use Illuminate\Database\Eloquent\Model;

class RisOut extends Model
{
     protected $table = 'ris_out';

    public $timestamps = false;

    protected $fillable = [
        'no_rontgen',
        'admin_datetime_start',
    ];
}
