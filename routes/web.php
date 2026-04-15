<?php

use App\Http\Controllers\DicomMonitoringController;
use App\Http\Controllers\RisOutController;
use App\Http\Controllers\RS\RisOutController as RSRisOutController;
use App\Http\Controllers\RS\ServiceRequestController as RSServiceRequestController;
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