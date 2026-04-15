<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DicomObj extends Model
{
    protected $connection = 'dicom';
    protected $table = 'dicom_obj';

    public $timestamps = false;

    protected $guarded = [];
}
