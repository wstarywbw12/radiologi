<?php

namespace App\Http\Controllers\RS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Pagination\LengthAwarePaginator;

class WorklistApiController extends Controller
{
    public function index(Request $request)
    {
        $start       = $request->start_date ?? now()->subDays(15)->toDateString();
        $end         = $request->end_date ?? now()->toDateString();
        $statusKirim = $request->status_kirim ?? 'all';
        $perPage     = 20;
        $page        = (int) ($request->page ?? 1);

        $baseUrl = "http://192.168.10.29/wslokal/satusehat/radiologi/worklist/allstudies/tanggal/$start/$end";

        if ($statusKirim == '1') {
            $url = "$baseUrl/1";
        } elseif ($statusKirim == '0') {
            $url = "$baseUrl/0";
        } else {
            $url = $baseUrl;
        }

        // Cache key unik per kombinasi filter
        $cacheKey = 'worklist:' . md5($url);

        $result = Cache::remember($cacheKey, 60, function () use ($url) {
            try {
                $response = Http::timeout(5)->get($url);

                if ($response->successful()) {
                    return $response->json();
                }
            } catch (\Exception $e) {
                // log jika perlu
            }
            return null;
        });

        if ($result) {
            $data         = $result['response']['list'] ?? [];
            $total        = $result['response']['jmlrec'] ?? count($data);
            $sudahDikirim = $result['response']['rekap']['jmlsudahdikirim'] ?? 0;
            $belumDikirim = $result['response']['rekap']['jmlbelumdikirim'] ?? 0;
        } else {
            $data = [];
            $total = $sudahDikirim = $belumDikirim = 0;
        }

        // Manual pagination (karena API tidak support pagination)
        $collection = collect($data);
        $slice      = $collection->forPage($page, $perPage)->values()->all();

        $paginator = new LengthAwarePaginator(
            $slice,
            $collection->count(),
            $perPage,
            $page,
            [
                'path'  => $request->url(),
                'query' => $request->query(),
            ]
        );

        return view('worklist.index', [
            'data'         => $slice,
            'paginator'    => $paginator,
            'total'        => $total,
            'start'        => $start,
            'end'          => $end,
            'statusKirim'  => $statusKirim,
            'sudahDikirim' => $sudahDikirim,
            'belumDikirim' => $belumDikirim,
        ]);
    }

    /**
     * Kirim data radiologi ke endpoint SatuSehat.
     */
    public function kirim(Request $request)
    {
        $request->validate([
            'no_rontgen' => 'required|string',
        ]);

        $noRontgen = $request->input('no_rontgen');
        $url       = "http://192.168.10.135:9090/kirimdata/123312/1/{$noRontgen}";

        try {
            $response = Http::timeout(300)->get($url);

            if ($response->successful()) {
                // hapus cache supaya data terbaru muncul setelah reload
                Cache::flush(); // atau Cache::forget() spesifik key

                return response()->json([
                    'status'  => 'success',
                    'message' => 'Data berhasil dikirim.',
                    'url'     => $url,
                    'result'  => $response->json(),
                ]);
            }

            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal mengirim data. HTTP ' . $response->status(),
                'url'     => $url,
                'result'  => $response->body(),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                'url'     => $url,
            ], 200);
        }
    }
}