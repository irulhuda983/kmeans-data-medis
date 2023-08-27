<?php

namespace App\Exports;

use App\Models\RekamMedis;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RekamMedisExport implements FromView
{
    public function view(): View
    {
        return view('exports.rekam_medis', [
            'rekam' => RekamMedis::all()
        ]);
    }
}
