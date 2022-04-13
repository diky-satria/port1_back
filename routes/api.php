<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Bimtek\BimtekSpmi;
use App\Http\Controllers\Bimtek\BimtekUmkm;
use App\Http\Controllers\Pos\PosController;
use App\Http\Controllers\MediaPromosi\Berita;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Bimtek\BimtekTrainer;
use App\Http\Controllers\MediaPromosi\Webinar;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RefreshTokenController;
use App\Http\Controllers\Bimtek\PelatihanAmiPt;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserDash\UserDashController;
use App\Http\Controllers\Bimtek\BimtekDigitalMarketing;
use App\Http\Controllers\Bimtek\BimtekManagementResiko;
use App\Http\Controllers\Bimtek\PelatihanAuditNonAcademic;
use App\Http\Controllers\Gallery\GalleryController;
use App\Http\Controllers\GalleryAdmin\GalleryAdminController;
use App\Http\Controllers\Minio\UrlController;
use App\Http\Controllers\Riwayat\RiwayatController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::post('register', [RegisterController::class, '__invoke']);
Route::post('login', [LoginController::class, '__invoke']);

// Route::post('login', [AuthController::class, 'login']);

Route::get('/test', [PosController::class, 'test']);

// Route::middleware('auth:sanctum')->group(function(){
Route::middleware('auth:api')->group(function(){
    
    Route::get('user', [UserController::class, '__invoke']);
    Route::post('ubah_password', [UserController::class, 'ubah_password']);

    // Route::get('user', [AuthController::class, 'user']);
    
    Route::get('user_dash', [UserDashController::class, 'index']);
    Route::post('user_dash', [UserDashController::class, 'store']);
    Route::get('user_dash/{id}', [UserDashController::class, 'show']);
    Route::patch('user_dash/{id}', [UserDashController::class, 'update']);
    Route::delete('user_dash/{id}', [UserDashController::class, 'delete']);

    Route::get('detail_riwayat/{id}', [RiwayatController::class, 'show']);
    
    Route::get('pos', [PosController::class, 'index']);
    Route::get('pos/{id}', [PosController::class, 'show']);
    Route::post('pos', [PosController::class, 'store']);
    Route::post('pos/{id}', [PosController::class, 'update']);
    Route::delete('pos/{id}', [PosController::class, 'destroy']);
    
    Route::get('user_dash_test', [UserDashController::class, 'test']);

    Route::get('gallery_adm', [GalleryAdminController::class, 'index']);
    Route::get('gallery_adm/{id}', [GalleryAdminController::class, 'show']);
    Route::post('gallery_adm', [GalleryAdminController::class, 'store']);
    Route::post('gallery_adm/{id}', [GalleryAdminController::class, 'update']);
    Route::delete('gallery_adm/{id}', [GalleryAdminController::class, 'delete']);

    Route::post('refresh', [RefreshTokenController::class, 'refresh']);
    
    Route::post('logout', [LogoutController::class, '__invoke']);
    // Route::post('logout', [AuthController::class, 'logout']);
});

Route::get('minio_url', [UrlController::class, 'index']);

Route::get('bimtek_digital_marketing', [BimtekDigitalMarketing::class, 'index']);
Route::get('bimtek_digital_marketing/{id}', [BimtekDigitalMarketing::class, 'show']);

Route::get('bimtek_pendamping_umkm', [BimtekUmkm::class, 'index']);
Route::get('bimtek_pendamping_umkm/{id}', [BimtekUmkm::class, 'show']);

Route::get('bimtek_trainer', [BimtekTrainer::class, 'index']);
Route::get('bimtek_trainer/{id}', [BimtekTrainer::class, 'show']);

Route::get('bimtek_management_resiko', [BimtekManagementResiko::class, 'index']);
Route::get('bimtek_management_resiko/{id}', [BimtekManagementResiko::class, 'show']);

Route::get('bimtek_spmi', [BimtekSpmi::class, 'index']);
Route::get('bimtek_spmi/{id}', [BimtekSpmi::class, 'show']);

Route::get('pelatihan_ami_pt', [PelatihanAmiPt::class, 'index']);
Route::get('pelatihan_ami_pt/{id}', [PelatihanAmiPt::class, 'show']);

Route::get('pelatihan_audit_non_academic', [PelatihanAuditNonAcademic::class, 'index']);
Route::get('pelatihan_audit_non_academic/{id}', [PelatihanAuditNonAcademic::class, 'show']);

Route::get('webinar', [Webinar::class, 'index']);
Route::get('webinar/{id}', [Webinar::class, 'show']);

Route::get('berita', [Berita::class, 'index']);
Route::get('berita/{id}', [Berita::class, 'show']);

Route::get('gallery', [GalleryController::class, 'index']);
Route::get('gallery/{kategori}', [GalleryController::class, 'show']);