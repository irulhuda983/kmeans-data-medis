<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\RekamMedisController;
use App\Http\Controllers\API\ClusterController;
use App\Http\Controllers\API\ManageUserController;
use App\Http\Controllers\API\OptionsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('user')->controller(AuthController::class)->group(function () {
    Route::post('issue-token', 'issueToken');

    Route::get('', 'getMe')->middleware('auth:sanctum');
    Route::post('ubah-profil', 'updateProfil')->middleware('auth:sanctum');
    Route::post('ubah-password', 'ubahPassword')->middleware('auth:sanctum');
    Route::post('logout', 'logout')->middleware('auth:sanctum');
});

Route::prefix('rekam-medis')
->controller(RekamMedisController::class)
->middleware('auth:sanctum')
->group(function () {
    Route::get('/', 'index');
    Route::get('/{rekam}/show', 'show');
    Route::post('/', 'store');
    Route::post('/import', 'import');
    Route::post('/export', 'export');
    Route::post('/{rekam}/update', 'update');
    Route::delete('/{rekam}/delete', 'destroy');
    Route::delete('/truncate', 'truncate');
});

Route::prefix('manage-user')
->controller(ManageUserController::class)
->middleware('auth:sanctum')
->group(function () {
    Route::get('/', 'index');
    Route::get('/{user}/show', 'show');
    Route::post('/', 'store');
    Route::post('/{user}/update', 'update');
    Route::delete('/{user}/delete', 'destroy');
    // Route::post('/import', 'import');
    // Route::post('/export', 'export');
    // Route::post('/{rekam}/update', 'update');
    // Route::delete('/{rekam}/delete', 'destroy');
});

Route::prefix('clustering')
->controller(ClusterController::class)
->middleware('auth:sanctum')
->group(function () {
    Route::get('/get-by-tanggal', 'getClusterByTanggal');
    Route::get('/get-by-nama', 'getClusterByNamaPasien');
    // Route::get('/{rekam}/show', 'show');
});

Route::prefix('options')
->controller(OptionsController::class)
->middleware('auth:sanctum')
->group(function () {
    Route::get('/jenis-penyakit', 'jenisPenyakit');
});


// generate url dokumen
Route::get('upload/{pathA}/{pathB}/{pathC?}', function ($pathA, $pathB, $pathC = null) {
    $path = "{$pathA}/{$pathB}";
    if ($pathC !== null) $path .= "/{$pathC}";
    $mime = Storage::mimeType($path);
    $allowedMime = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/msword', 'application/vnd.ms-excel'];

    if (!in_array($mime, $allowedMime))
        return response()->json(['error' => 'Tidak terpenuhi.'], 400);
    else
        return response()->file(storage_path("app/{$path}"));
});
// end generate url dokumen
