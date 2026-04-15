<?php

namespace App\Http\Controllers\RS;

use App\Http\Controllers\Controller;
use App\Models\RS\RisOut;
use Illuminate\Http\Request;

class RisOutController extends Controller
{
    public function index(Request $request)
    {
        $query = RisOut::query();

        // 🔥 Filter tanggal
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('admin_datetime_start', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        $data = $query->orderBy('admin_datetime_start', 'desc')
                      ->paginate(10)
                      ->withQueryString(); // 🔥 biar filter tidak hilang saat pagination

        return view('ris_out.index', compact('data'));
    }
}