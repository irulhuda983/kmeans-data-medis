<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\RekamMedis;
use App\Http\Resources\RekamMedisResource;
use App\Imports\RekamMedisImport;
use App\Exports\RekamMedisExport;
use App\Models\JenisUmur;

class RekamMedisController extends Controller
{
    
    public function index(Request $request)
    {
        $search = $request->search ?? null;
        list($order, $dir) = explode(':', $request->order ?? 'tanggal:desc');
        $limit = $request->limit ?? 10;


        $query = RekamMedis::search($search)->orderBy($order, $dir);
        return RekamMedisResource::collection( $query->paginate($limit) );
    }

    public function show(RekamMedis $rekam)
    {
        return new RekamMedisResource( $rekam );
    }

    public function store(Request $request)
    {
        $rules = [
            'kode' => 'nullable',
            'nama' => 'required',
            'jenis_kelamin' => 'required|in:l,p',
            'tempat_lahir' => 'nullable',
            'tanggal_lahir' => 'nullable|date',
            'umur' => 'numeric|min:0|max:150',
            'penyakit' => 'required',
            'pelayanan' => 'required|in:rawat_inap,rawat_jalan',
            'tanggal' => 'required|date',
        ];

        $request->validate($rules);

        try {
            DB::beginTransaction();

            $jenisUmur = JenisUmur::where([
                ['min', '<=', (int) $request->umur],
                ['max', '>=', (int) $request->umur],
            ])->first();

            $data = RekamMedis::create([
                'kode' => $request->kode, 
                'nama' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir ? date('Y-m-d', strtotime($request->tanggal_lahir)) : null,
                'umur' => $request->umur,
                'id_jenis_umur' => $jenisUmur->id,
                'id_jenis_penyakit' => $request->penyakit,
                'pelayanan' => $request->pelayanan,
                'tanggal' => date('Y-m-d H:i:s', strtotime($request->tanggal)),
            ]);

            DB::commit();
            return response()->json([
                'message' => 'success',
                'data' => $jenisUmur
            ], 200);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|max:10000|mimes:xlsx,xls',
        ]);

        $path = $request->file('file');

        Excel::import(new RekamMedisImport, $path);
        
        return response()->json(['message' => 'success']);
    }

    public function export() 
    {
        return Excel::download(new RekamMedisExport, 'data-rekam-medis-'.time().'.xlsx');
    }

    public function update(Request $request, RekamMedis $rekam)
    {
        $rules = [
            'kode' => 'nullable',
            'nama' => 'required',
            'jenis_kelamin' => 'required|in:l,p',
            'tempat_lahir' => 'nullable',
            'tanggal_lahir' => 'nullable|date',
            'umur' => 'numeric|min:0|max:150',
            'penyakit' => 'required',
            'pelayanan' => 'required|in:rawat_inap,rawat_jalan',
            'tanggal' => 'required|date',
        ];

        $request->validate($rules);

        try {
            DB::beginTransaction();

            $jenisUmur = JenisUmur::where([
                ['min', '<=', (int) $request->umur],
                ['max', '>=', (int) $request->umur],
            ])->first();
            
            $rekam->update([
                'kode' => $request->kode, 
                'nama' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir ? date('Y-m-d', strtotime($request->tanggal_lahir)) : null,
                'umur' => $request->umur,
                'id_jenis_umur' => $jenisUmur->id,
                'id_jenis_penyakit' => $request->penyakit,
                'pelayanan' => $request->pelayanan,
                'tanggal' => date('Y-m-d H:i:s', strtotime($request->tanggal)),
            ]);

            DB::commit();
            return response()->json([
                'message' => 'success',
                'data' => $rekam
            ], 200);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e->getMessage(), 'data' => null], 500);
        }
    }

    public function destroy(RekamMedis $rekam)
    {
        try {
            DB::beginTransaction();
            
            $rekam->delete();

            DB::commit();
            return response()->json([
                'message' => 'success',
                'data' => $rekam
            ], 200);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e->getMessage(), 'data' => null], 500);
        }
    }
}
