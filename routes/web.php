<?php

use App\Http\Controllers\DicomMonitoringController;
use App\Http\Controllers\RisOutController;
use App\Http\Controllers\RS\RisOutController as RSRisOutController;
use App\Http\Controllers\RS\ServiceRequestController as RSServiceRequestController;
use App\Http\Controllers\RS\WorklistApiController;
use App\Http\Controllers\SatusehatImagingController;
use App\Http\Controllers\ServiceRequestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dicom-monitoring', [DicomMonitoringController::class, 'index']);
Route::get('/dashboard', [DicomMonitoringController::class, 'dikom']);

Route::get('/ris-out', [RisOutController::class, 'index']);
Route::get('/rs-ris-out', [RSRisOutController::class, 'index']);

Route::get('/service-request', [ServiceRequestController::class, 'index']);
Route::get('/rs-service-request', [RSServiceRequestController::class, 'index']);


Route::get('/cek-image-study', [SatusehatImagingController::class, 'index'])->name('satusehat.index');
Route::post('/satusehat/search', [SatusehatImagingController::class, 'search'])->name('satusehat.search');



Route::get('/worklist', [WorklistApiController::class, 'index']);


Route::get('/satusehat/imaging', [SatusehatImagingController::class, 'api']);

