<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\JenisUmur;
use App\Models\JenisPenyakit;

class OptionsController extends Controller
{
    
    public function jenisPenyakit(Request $request)
    {
        $query = JenisPenyakit::select('id', 'nama as text')->get();

        return response()->json([
            'data' => $query
        ]);
    }
}
