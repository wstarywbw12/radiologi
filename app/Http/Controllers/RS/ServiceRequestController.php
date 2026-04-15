<?php

namespace App\Http\Controllers\RS;

use App\Http\Controllers\Controller;
use App\Models\RS\ServiceRequest;
use Illuminate\Http\Request;

class ServiceRequestController extends Controller
{
      public function index(Request $request)
    {
        $query = ServiceRequest::query();

        // 🔍 search
        if ($request->search) {
            $query->where('satusehat_id', 'like', '%' . $request->search . '%')
                  ->orWhere('request_param', 'like', '%' . $request->search . '%');
        }
        $data = $query->orderBy('id', 'desc')
                      ->where('connection_name', '=', 'radiology')
                      ->whereNotNull('satusehat_id')
                      ->paginate(10)
                      ->withQueryString();

        return view('service_request.index', compact('data'));
    }
}
