<?php

namespace App\Http\Controllers\RS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WorklistApiController extends Controller
{
    public function index(Request $request)
    {
        // Default tanggal hari ini
        $start = $request->start_date ?? now()->subDays(15)->toDateString();
        $end   = $request->end_date ?? now()->toDateString();
        $statusKirim = $request->status_kirim ?? 'all';
        
        // Build URL berdasarkan filter status kirim
        $baseUrl = "http://192.168.10.29/wslokal/satusehat/radiologi/worklist/allstudies/tanggal/$start/$end";
        
        if ($statusKirim == '1') {
            $url = "$baseUrl/1";
        } elseif ($statusKirim == '0') {
            $url = "$baseUrl/0";
        } else {
            $url = $baseUrl;
        }

        try {
            $response = Http::timeout(10)->get($url);

            if ($response->successful()) {
                $result = $response->json();

                $data = $result['response']['list'] ?? [];
                $total = $result['response']['jmlrec'] ?? 0;
            } else {
                $data = [];
                $total = 0;
            }
        } catch (\Exception $e) {
            $data = [];
            $total = 0;
        }

        return view('worklist.index', compact('data', 'total', 'start', 'end', 'statusKirim'));
    }
}