<?php

namespace App\Models\RS;

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

    // 🔥 Ambil Accession Number dari JSON
    public function getAccessionNumberAttribute()
    {
        if (!$this->request_param) return null;

        $json = json_decode($this->request_param, true);

        if (!isset($json['resource']['identifier'])) return null;

        foreach ($json['resource']['identifier'] as $identifier) {
            if (
                isset($identifier['type']['coding'][0]['code']) &&
                $identifier['type']['coding'][0]['code'] === 'ACSN'
            ) {
                return $identifier['value'] ?? null;
            }
        }

        return null;
    }
}