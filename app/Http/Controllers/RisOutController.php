<?php

namespace App\Http\Controllers;

use App\Models\RisOut;
use Illuminate\Http\Request;

class RisOutController extends Controller
{
    public function index()
    {
        $data = RisOut::orderBy('no_rontgen', 'desc')->paginate(10);

        return response()->json([
            'status' => true,
            'message' => 'Data RIS OUT',
            'total' => $data->count(),
            'data' => $data
        ]);
    }
}