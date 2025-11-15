<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\PetugasDashboardController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\LokasiCrudController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PetugasItemController;
use App\Http\Controllers\PetugasLokasiCrudController;
use App\Http\Controllers\PenolakanController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\TemporaryItemController;

/*
|--------------------------------------------------------------------------
| WEB ROUTES
|--------------------------------------------------------------------------
*/

// 🔹 Root - selalu redirect ke login (session akan expire on close)
Route::get('/', function () {
    // Jika user sudah login, tetap redirect ke login untuk memastikan session fresh
    // Karena expire_on_close = true, session akan expire saat browser ditutup
    if (auth()->check()) {
        // Jika session masih valid, redirect ke dashboard sesuai role
        $user = auth()->user();
        switch ($user->role) {
            case 'admin':
                return redirect()->route('dashboard');
            case 'petugas':
                return redirect()->route('petugas.dashboard');
            case 'pengguna':
                return redirect()->route('user.dashboard');
            default:
                return redirect()->route('login');
        }
    }
    // Jika tidak login, redirect ke login
    return redirect()->route('login');
});

/* =====================================================
   🔐 AUTH (Login, Register, Logout)
===================================================== */
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/* =====================================================
   🧭 ADMIN
===================================================== */
Route::middleware(['auth', 'role:admin'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Pengaduan (Admin)
    Route::prefix('admin/pengaduan')->name('admin.pengaduan.')->group(function () {
        Route::put('/{id}/status', [PengaduanController::class, 'updateStatus'])->name('updateStatus');
        Route::get('/{id}/cetak', [PengaduanController::class, 'cetak'])->name('cetak');
        Route::delete('/{id}', [PengaduanController::class, 'destroy'])->name('destroy');
        Route::put('/{id}', [PengaduanController::class, 'update'])->name('update');
        
        // ✅ Update status dengan parameter
        Route::put('/{id}/{status}', [PengaduanController::class, 'updateStatus'])
            ->where('status', 'Disetujui|Ditolak')
            ->name('updateStatusParam');
        
        // 🆕 Route untuk tolak dengan saran
        Route::put('/{id}/tolak-saran', [PengaduanController::class, 'tolakWithSaran'])->name('tolakWithSaran');
    });

    // 📁 Kelola Petugas
    Route::prefix('admin/petugas')->name('admin.petugas.')->group(function () {
        Route::get('/', [PetugasController::class, 'index'])->name('index');
        Route::get('/create', [PetugasController::class, 'create'])->name('create');
        Route::post('/', [PetugasController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [PetugasController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PetugasController::class, 'update'])->name('update');
        Route::delete('/{id}', [PetugasController::class, 'destroy'])->name('destroy');
    });

    // 👥 Kelola User - CRUD Lengkap di DashboardController
    Route::prefix('admin/users')->name('admin.users.')->group(function () {
        Route::get('/', [DashboardController::class, 'userIndex'])->name('index');
        Route::get('/create', [DashboardController::class, 'userCreate'])->name('create');
        Route::post('/', [DashboardController::class, 'userStore'])->name('store');
        Route::get('/{id}/edit', [DashboardController::class, 'userEdit'])->name('edit');
        Route::put('/{id}', [DashboardController::class, 'userUpdate'])->name('update');
        Route::delete('/{id}', [DashboardController::class, 'userDestroy'])->name('destroy');
    });

    // ⚙ Daftar Admin
    Route::get('/admin/daftar-admin', [PetugasController::class, 'daftarAdmin'])->name('admin.daftarAdmin');

    // 📦 Kelola Barang (Item)
    Route::prefix('admin/barang')->group(function () {
        Route::get('/', [LokasiController::class, 'index'])->name('lokasi.index');
        Route::get('/{id_lokasi}', [ItemController::class, 'showByLokasi'])->name('item.byLokasi');
        Route::get('/{id_lokasi}/tambah', [ItemController::class, 'create'])->name('item.create');
        Route::post('/{id_lokasi}/store', [ItemController::class, 'store'])->name('item.store');
        Route::get('/{id_item}/edit', [ItemController::class, 'edit'])->name('item.edit');
        Route::post('/{id_item}/update', [ItemController::class, 'update'])->name('item.update');
        Route::delete('/{id_item}/delete', [ItemController::class, 'destroy'])->name('item.delete');
    });

    // 🧱 CRUD Lokasi untuk Admin
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::prefix('lokasi-crud')->name('lokasi.crud.')->group(function () {
            Route::get('/', [LokasiCrudController::class, 'index'])->name('index');
            Route::get('/create', [LokasiCrudController::class, 'create'])->name('create');
            Route::post('/', [LokasiCrudController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [LokasiCrudController::class, 'edit'])->name('edit');
            Route::put('/{id}', [LokasiCrudController::class, 'update'])->name('update');
            Route::delete('/{id}', [LokasiCrudController::class, 'destroy'])->name('destroy');
        });
    });

    // 📦 Temporary Items untuk Admin
    Route::prefix('admin/temporary')->name('admin.temporary.')->group(function () {
        Route::get('/', [TemporaryItemController::class, 'index'])->name('index');
        Route::get('/create', [TemporaryItemController::class, 'create'])->name('create');
        Route::post('/', [TemporaryItemController::class, 'store'])->name('store');
        Route::post('/{id}/approve', [TemporaryItemController::class, 'approve'])->name('approve');
        Route::post('/{id}/reject', [TemporaryItemController::class, 'reject'])->name('reject');
        Route::delete('/{id}', [TemporaryItemController::class, 'destroy'])->name('destroy');
    });
});

/* =====================================================
   🧩 PETUGAS
===================================================== */
Route::middleware(['auth', 'role:petugas'])->group(function () {

    // Dashboard Petugas
    Route::get('/petugas/dashboard', [PetugasDashboardController::class, 'index'])->name('petugas.dashboard');

    // ✅ PERBAIKAN: Ubah ke PetugasDashboardController
    Route::get('/petugas/formsaran/{id}', [PetugasDashboardController::class, 'formSaran'])->name('petugas.formsaran');
    Route::post('/petugas/kirim-saran/{id}', [PetugasDashboardController::class, 'kirimSaran'])->name('petugas.kirim.saran');

    // Pengaduan actions
    Route::prefix('petugas/pengaduan')->name('petugas.pengaduan.')->group(function () {
        Route::delete('/{id}/delete', [PetugasDashboardController::class, 'destroy'])->name('delete');
        Route::post('/{id}/terima', [PetugasDashboardController::class, 'terima'])->name('terima');
        Route::post('/{id}/mulai', [PetugasDashboardController::class, 'mulai'])->name('mulai');
        Route::post('/{id}/selesai', [PetugasDashboardController::class, 'selesai'])->name('selesai');
        
        // Tolak Pengaduan
        Route::get('/{id}/tolak-form', [PetugasDashboardController::class, 'formTolak'])->name('tolak.form');
        Route::post('/{id}/tolak', [PetugasDashboardController::class, 'tolak'])->name('tolak');
    });

    // 📦 Barang & Lokasi (Petugas)
    Route::prefix('petugas')->name('petugas.')->group(function () {
        // Barang per lokasi
        Route::get('/lokasi', [PetugasItemController::class, 'index'])->name('lokasi.index');
        Route::get('/lokasi/{id_lokasi}/barang', [PetugasItemController::class, 'showByLokasi'])->name('item.byLokasi');
        Route::get('/lokasi/{id_lokasi}/barang/tambah', [PetugasItemController::class, 'create'])->name('item.create');
        Route::post('/lokasi/{id_lokasi}/barang/store', [PetugasItemController::class, 'store'])->name('item.store');
        Route::get('/barang/edit/{id_item}', [PetugasItemController::class, 'edit'])->name('item.edit');
        Route::post('/barang/update/{id_item}', [PetugasItemController::class, 'update'])->name('petugas.item.update');
        Route::delete('/barang/delete/{id_item}', [PetugasItemController::class, 'destroy'])->name('item.delete');

        // Lokasi CRUD
        Route::prefix('lokasi-crud')->name('lokasi.crud.')->group(function () {
            Route::get('/', [PetugasLokasiCrudController::class, 'index'])->name('index');
            Route::get('/create', [PetugasLokasiCrudController::class, 'create'])->name('create');
            Route::post('/', [PetugasLokasiCrudController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [PetugasLokasiCrudController::class, 'edit'])->name('edit');
            Route::put('/{id}', [PetugasLokasiCrudController::class, 'update'])->name('update');
            Route::delete('/{id}', [PetugasLokasiCrudController::class, 'destroy'])->name('destroy');
        });

        // 📋 Daftar Penolakan
        Route::get('/penolakan', [PenolakanController::class, 'index'])->name('penolakan.index');
    });
});

/* =====================================================
   👤 PENGGUNA (USER)
===================================================== */
Route::middleware(['auth', 'role:pengguna'])->group(function () {
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');

    // Pengaduan - GUNAKAN CONTROLLER TERPISAH (UserPengaduanController)
    Route::prefix('user/pengaduan')->name('user.pengaduan.')->group(function () {
        Route::get('/tambah', [UserController::class, 'create'])->name('create');
        Route::post('/simpan', [UserController::class, 'store'])->name('store');
    });
    
    // AJAX untuk mendapatkan barang berdasarkan lokasi
    Route::get('/user/barang-by-lokasi/{id_lokasi}', [UserController::class, 'getBarangByLokasi'])->name('user.barang_by_lokasi');
});