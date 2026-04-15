<?php

namespace App\Http\Controllers;

use App\Models\DicomObj;
use Illuminate\Support\Facades\DB;

class DicomMonitoringController extends Controller
{
    public function index()
    {
        $total = DB::connection('dicom')->table('work_list')->count();

        $sent = DB::connection('dicom')->table('work_list')
            ->where('sent_status', 0)
            ->count();

        $pending = DB::connection('dicom')->table('work_list')
            ->where('sent_status', 1)
            ->count();

        $recent = DB::connection('dicom')
            ->table('work_list as w')
            ->leftJoin('patient as p', 'w.patient_id', '=', 'p.patient_id')
            ->select(
                'w.accession_number',
                'w.patient_id',
                'w.modality',
                'w.requested_procedure_description',
                'w.referring_phyisician_name',
                'p.patient_name',
                'w.sent_status'
            )
            ->orderByDesc('w.id')
            ->limit(20)
            ->get();

        return view('dicom.dashboard', compact(
            'total',
            'sent',
            'pending',
            'recent'
        ));
    }

    public function dikom()
    {
        $sub = DicomObj::selectRaw('MAX(id) as id')
            ->where('sent_status', 1)
            ->groupBy('accession_number');

        $recent = DicomObj::whereIn('id', $sub)
            ->orderByDesc('id')
            ->paginate(20);

        return view('dicom.dicom', compact(
            'recent'
        ));
    }
}
