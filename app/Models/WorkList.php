<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkList extends Model
{
    protected $connection = 'dicom';
    protected $table = 'work_list';

    public $timestamps = false;

    protected $guarded = [];
}
