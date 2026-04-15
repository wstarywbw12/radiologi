<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    // Ambil semua device
    public function index()
    {
        $data = Device::orderBy('id', 'desc')->get();

        return response()->json([
            'status' => true,
            'message' => 'Data Devices',
            'total' => $data->count(),
            'data' => $data
        ]);
    }

    // Ambil 1 device
    public function show($id)
    {
        $data = Device::findOrFail($id);

        return response()->json($data);
    }
}