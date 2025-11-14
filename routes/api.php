<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TemporaryItemApiController;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\PengaduanApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\PetugasApiController;
use App\Http\Controllers\Api\LokasiApiController;
use App\Http\Controllers\Api\ItemApiController;

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

// Public routes (tidak perlu authentication)
Route::post('/login', [AuthApiController::class, 'login'])->name('api.login');

// Protected routes (perlu authentication)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthApiController::class, 'user'])->name('api.user');
    Route::post('/logout', [AuthApiController::class, 'logout'])->name('api.logout');
    
    // Temporary Items API (Read-only for Flutter)
    Route::prefix('temporary-items')->group(function () {
        Route::get('/', [TemporaryItemApiController::class, 'index'])->name('api.temporary-items.index');
        Route::get('/{id}', [TemporaryItemApiController::class, 'show'])->name('api.temporary-items.show');
    });

    // Pengaduan API
    Route::prefix('pengaduan')->group(function () {
        Route::get('/', [PengaduanApiController::class, 'index'])->name('api.pengaduan.index');
        Route::get('/my', [PengaduanApiController::class, 'myPengaduan'])->name('api.pengaduan.my');
        Route::get('/ditolak', [PengaduanApiController::class, 'ditolak'])->name('api.pengaduan.ditolak');
    });

    // Users API (Admin only)
    Route::prefix('users')->group(function () {
        Route::get('/', [UserApiController::class, 'index'])->name('api.users.index');
        Route::get('/admins', [UserApiController::class, 'admins'])->name('api.users.admins');
    });

    // Petugas API (Admin only)
    Route::get('/petugas', [PetugasApiController::class, 'index'])->name('api.petugas.index');

    // Lokasi API
    Route::get('/lokasi', [LokasiApiController::class, 'index'])->name('api.lokasi.index');

    // Items API
    Route::get('/items', [ItemApiController::class, 'index'])->name('api.items.index');
});
