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
        $start = $request->start_date ?? now()->toDateString();
        $end   = $request->end_date ?? now()->toDateString();

        $url = "http://192.168.10.29/wslokal/satusehat/radiologi/worklist/allstudies/tanggal/$start/$end/";

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

        return view('worklist.index', compact('data', 'total', 'start', 'end'));
    }
}