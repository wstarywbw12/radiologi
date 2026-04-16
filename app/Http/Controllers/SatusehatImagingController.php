<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class SatusehatImagingController extends Controller
{
    public function index()
    {
        return view('satusehat.index');
    }

    public function search(Request $request)
    {
        $request->validate([
            'accnumber' => 'required',
        ]);

        $accnumber = $request->accnumber;

        // ==========================
        // CONFIG (PRODUCTION ONLY)
        // ==========================
        $baseUrl     = config('satusehat.base_url_prod');
        $clientId    = config('satusehat.client_id');
        $clientSecret= config('satusehat.client_secret');
        $orgId       = config('satusehat.org_id');

        if (!$baseUrl) {
            abort(500, 'Base URL tidak terbaca dari config');
        }

        // ==========================
        // TOKEN CACHE
        // ==========================
        $accessToken = Cache::remember('satusehat_token_prod', 3500, function () use ($baseUrl, $clientId, $clientSecret) {

            $response = Http::asForm()->post(
                $baseUrl . '/oauth2/v1/accesstoken?grant_type=client_credentials',
                [
                    'client_id' => $clientId,
                    'client_secret' => $clientSecret,
                ]
            );

            if (!$response->successful()) {
                abort(500, 'Gagal generate token: ' . $response->body());
            }

            return $response->json()['access_token'];
        });

        // ==========================
        // HIT API
        // ==========================
        $identifier = "http://sys-ids.kemkes.go.id/acsn/$orgId|$accnumber";

        $response = Http::withToken($accessToken)
            ->get($baseUrl . '/fhir-r4/v1/ImagingStudy', [
                'identifier' => $identifier,
            ]);

        if (!$response->successful()) {
            abort(500, 'Gagal hit API: ' . $response->body());
        }

        $data = $response->json();

        // ==========================
        // STATUS
        // ==========================
        $status_message = '';
        $status_class   = '';

        if (isset($data['resourceType']) && $data['resourceType'] == 'Bundle') {

            $total = $data['total'] ?? 0;

            if ($total == 0) {
                $status_message = 'Data belum dikirim ke SATUSEHAT';
                $status_class   = 'warning';
            } elseif ($total == 1) {
                $status_message = 'Data ImagingStudy sudah dikirim';
                $status_class   = 'success';
            } else {
                $status_message = 'Data lebih dari 1, perlu pengecekan';
                $status_class   = 'info';
            }
        } else {
            $status_message = 'Response tidak valid';
            $status_class   = 'danger';
        }

        return view('satusehat.result', compact(
            'data',
            'status_message',
            'status_class',
            'accnumber'
        ));
    }


    public function api(Request $request)
{
    $request->validate([
        'accnumber' => 'required',
    ]);

    $accnumber = $request->accnumber;

    $baseUrl     = config('satusehat.base_url_prod');
    $clientId    = config('satusehat.client_id');
    $clientSecret= config('satusehat.client_secret');
    $orgId       = config('satusehat.org_id');

    // 🔐 TOKEN
    $accessToken = Cache::remember('satusehat_token_prod', 3500, function () use ($baseUrl, $clientId, $clientSecret) {

        $response = Http::asForm()->post(
            $baseUrl . '/oauth2/v1/accesstoken?grant_type=client_credentials',
            [
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
            ]
        );

        if (!$response->successful()) {
            return null;
        }

        return $response->json()['access_token'] ?? null;
    });

    if (!$accessToken) {
        return response()->json([
            'status' => false,
            'message' => 'Gagal generate token'
        ], 500);
    }

    // 🔎 HIT API
    $identifier = "http://sys-ids.kemkes.go.id/acsn/$orgId|$accnumber";

    $response = Http::withToken($accessToken)
        ->get($baseUrl . '/fhir-r4/v1/ImagingStudy', [
            'identifier' => $identifier,
        ]);

    if (!$response->successful()) {
        return response()->json([
            'status' => false,
            'message' => 'Gagal hit API',
            'error' => $response->body()
        ], 500);
    }

    $data = $response->json();

  
    return response()->json([
        'status' => true,
        'data' => $data
    ]);
}
}