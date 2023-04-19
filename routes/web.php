<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendancesController;
use App\Http\Controllers\BreaKTimesController;

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
Auth::routes();


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/', [AttendancesController::class,'index'])->name('attendance.index');
Route::post('/attendance', [AttendancesController::class,'store'])->name('attendance.store');
Route::put('/attendance', [AttendancesController::class,'update'])->name('attendance.update');
Route::post('/break_time', [BreaKTimesController::class,'store'])->name('break_time.store');
Route::put('/break_time', [BreaKTimesController::class,'update'])->name('break_time.update');
Route::get('/attendance/{date}', [AttendancesController::class,
'show'])->name('attendance.show');

Route::get('/bootstrap', function () {
    return view('bootstrap');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

