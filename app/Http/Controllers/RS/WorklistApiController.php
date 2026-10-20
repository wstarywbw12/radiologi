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
        $search      = trim((string) ($request->search ?? ''));
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

        $cacheKey = 'worklist:' . md5($url);

        $result = Cache::remember($cacheKey, 60, function () use ($url) {
            try {
                $response = Http::timeout(5)->get($url);
                if ($response->successful()) {
                    return $response->json();
                }
            } catch (\Exception $e) {
                // silent
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

        $collection = collect($data);

        // === SEARCH (server-side, sebelum pagination) ===
        if ($search !== '') {
            $needle = mb_strtolower($search);
            $collection = $collection->filter(function ($row) use ($needle) {
                $haystack = mb_strtolower(implode(' ', [
                    $row['no_rontgen']       ?? '',
                    $row['nama_pasien']      ?? '',
                    $row['no_rm']            ?? '',
                    $row['nama_pemeriksaan'] ?? '',
                    $row['dokter_pengirim']  ?? '',
                    $row['tanggal_order']    ?? '',
                ]));
                return str_contains($haystack, $needle);
            })->values();
        }

        // === Pagination setelah filter ===
        $slice = $collection->forPage($page, $perPage)->values()->all();

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
            'search'       => $search,
            'sudahDikirim' => $sudahDikirim,
            'belumDikirim' => $belumDikirim,
        ]);
    }

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
                Cache::flush();

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