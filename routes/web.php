<?php

use App\Http\Controllers\DicomMonitoringController;
use App\Http\Controllers\RisOutController;
use App\Http\Controllers\RS\RisOutController as RSRisOutController;
use App\Http\Controllers\RS\ServiceRequestController as RSServiceRequestController;
use App\Http\Controllers\SatusehatImagingController;
use App\Http\Controllers\ServiceRequestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dicom-monitoring', [DicomMonitoringController::class, 'index']);

Route::get('/ris-out', [RisOutController::class, 'index']);
Route::get('/rs-ris-out', [RSRisOutController::class, 'index']);

Route::get('/service-request', [ServiceRequestController::class, 'index']);
Route::get('/rs-service-request', [RSServiceRequestController::class, 'index']);


Route::get('/cek-image-study', [SatusehatImagingController::class, 'index']);
Route::post('/satusehat/search', [SatusehatImagingController::class, 'search'])->name('satusehat.search');

Route::get('/dashboard', function () {
    return response()->json([
        'base_url_stg' => env('SATUSEHAT_BASE_URL_STG')
    ]);
});
