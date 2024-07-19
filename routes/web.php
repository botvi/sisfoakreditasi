<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardController,
    DataGuruController,
    KepalaSekolahController,
    StandarIsiController,
    LoginController,
    RegisterController,
    StandarKompetensiLulusanController,
    StandarPembiayaanController,
    StandarPendidikDanTenpenController,
    StandarPengelolaanController,
    StandarPenilaianController,
    StandarProsesController,
    StandarSaranaDanPraController,
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// AUTH
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register'])->name('register.post');
// AUTH
Route::middleware(['auth'])->group(function () {

Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');


Route::get('/data-gurus', [DataGuruController::class, 'index']);
Route::get('/data-gurus/create', [DataGuruController::class, 'create']);
Route::post('/data-gurus', [DataGuruController::class, 'store']);
Route::get('/data-gurus/{id}/edit', [DataGuruController::class, 'edit']);
Route::put('/data-gurus/{id}', [DataGuruController::class, 'update']);
Route::delete('/data-gurus/{id}', [DataGuruController::class, 'destroy']);

Route::get('/kepala-sekolah', [KepalaSekolahController::class, 'index']);
Route::get('/kepala-sekolah/create', [KepalaSekolahController::class, 'create']);
Route::post('/kepala-sekolah', [KepalaSekolahController::class, 'store']);
Route::get('/kepala-sekolah/{id}/edit', [KepalaSekolahController::class, 'edit']);
Route::put('/kepala-sekolah/{id}', [KepalaSekolahController::class, 'update']);
Route::delete('/kepala-sekolah/{id}', [KepalaSekolahController::class, 'destroy']);

Route::get('/standar-isis', [StandarIsiController::class, 'index']);
Route::get('/standar-isis/create', [StandarIsiController::class, 'create']);
Route::post('/standar-isis', [StandarIsiController::class, 'store']);
Route::get('/standar-isis/{id}/edit', [StandarIsiController::class, 'edit']);
Route::put('/standar-isis/{id}', [StandarIsiController::class, 'update']);
Route::delete('/standar-isis/{id}', [StandarIsiController::class, 'destroy']);

Route::get('/standar-kompetensi-lulusan', [StandarKompetensiLulusanController::class, 'index']);
Route::get('/standar-kompetensi-lulusan/create', [StandarKompetensiLulusanController::class, 'create']);
Route::post('/standar-kompetensi-lulusan', [StandarKompetensiLulusanController::class, 'store']);
Route::get('/standar-kompetensi-lulusan/{id}/edit', [StandarKompetensiLulusanController::class, 'edit']);
Route::put('/standar-kompetensi-lulusan/{id}', [StandarKompetensiLulusanController::class, 'update']);
Route::delete('/standar-kompetensi-lulusan/{id}', [StandarKompetensiLulusanController::class, 'destroy']);

Route::get('/standar-pembiayaan', [StandarPembiayaanController::class, 'index']);
Route::get('/standar-pembiayaan/create', [StandarPembiayaanController::class, 'create']);
Route::post('/standar-pembiayaan', [StandarPembiayaanController::class, 'store']);
Route::get('/standar-pembiayaan/{id}/edit', [StandarPembiayaanController::class, 'edit']);
Route::put('/standar-pembiayaan/{id}', [StandarPembiayaanController::class, 'update']);
Route::delete('/standar-pembiayaan/{id}', [StandarPembiayaanController::class, 'destroy']);

Route::get('/standar-pendidikan', [StandarPendidikDanTenpenController::class, 'index']);
Route::get('/standar-pendidikan/create', [StandarPendidikDanTenpenController::class, 'create']);
Route::post('/standar-pendidikan', [StandarPendidikDanTenpenController::class, 'store']);
Route::get('/standar-pendidikan/{id}/edit', [StandarPendidikDanTenpenController::class, 'edit']);
Route::put('/standar-pendidikan/{id}', [StandarPendidikDanTenpenController::class, 'update']);
Route::delete('/standar-pendidikan/{id}', [StandarPendidikDanTenpenController::class, 'destroy']);

Route::get('/standar-pengelolaan', [StandarPengelolaanController::class, 'index']);
Route::get('/standar-pengelolaan/create', [StandarPengelolaanController::class, 'create']);
Route::post('/standar-pengelolaan', [StandarPengelolaanController::class, 'store']);
Route::get('/standar-pengelolaan/{id}/edit', [StandarPengelolaanController::class, 'edit']);
Route::put('/standar-pengelolaan/{id}', [StandarPengelolaanController::class, 'update']);
Route::delete('/standar-pengelolaan/{id}', [StandarPengelolaanController::class, 'destroy']);

Route::get('/standar-penilaian', [StandarPenilaianController::class, 'index']);
Route::get('/standar-penilaian/create', [StandarPenilaianController::class, 'create']);
Route::post('/standar-penilaian', [StandarPenilaianController::class, 'store']);
Route::get('/standar-penilaian/{id}/edit', [StandarPenilaianController::class, 'edit']);
Route::put('/standar-penilaian/{id}', [StandarPenilaianController::class, 'update']);
Route::delete('/standar-penilaian/{id}', [StandarPenilaianController::class, 'destroy']);

Route::get('/standar-proses', [StandarProsesController::class, 'index']);
Route::get('/standar-proses/create', [StandarProsesController::class, 'create']);
Route::post('/standar-proses', [StandarProsesController::class, 'store']);
Route::get('/standar-proses/{id}/edit', [StandarProsesController::class, 'edit']);
Route::put('/standar-proses/{id}', [StandarProsesController::class, 'update']);
Route::delete('/standar-proses/{id}', [StandarProsesController::class, 'destroy']);

Route::get('/standar-sarana', [StandarSaranaDanPraController::class, 'index']);
Route::get('/standar-sarana/create', [StandarSaranaDanPraController::class, 'create']);
Route::post('/standar-sarana', [StandarSaranaDanPraController::class, 'store']);
Route::get('/standar-sarana/{id}/edit', [StandarSaranaDanPraController::class, 'edit']);
Route::put('/standar-sarana/{id}', [StandarSaranaDanPraController::class, 'update']);
Route::delete('/standar-sarana/{id}', [StandarSaranaDanPraController::class, 'destroy']);


});