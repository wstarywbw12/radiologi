<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use Illuminate\Http\Request;

class ServiceRequestController extends Controller
{
     public function index()
    {
        $data = ServiceRequest::orderBy('id', 'desc')->paginate(10);

        return response()->json([
            'status' => true,
            'message' => 'Data RIS OUT',
            'total' => $data->count(),
            'data' => $data
        ]);
    }
}
