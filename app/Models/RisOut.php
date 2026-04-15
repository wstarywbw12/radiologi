<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RisOut extends Model
{
    protected $connection = 'pacs';
    protected $table = 'ris_out';

    public $timestamps = false;

    protected $fillable = [
        'no_rontgen'
    ];
}
