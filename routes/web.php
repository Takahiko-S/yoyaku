<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\YoyakuController;
use App\Http\Controllers\AdminController;

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

Route::get('/', [YoyakuController::class, 'index'])->name('index');
Route::get('/test',[YoyakuController::class, 'test']);
Route::post('/get_data',[YoyakuController::class, 'getData']);
Route::post('/yoyaku',[YoyakuController::class, 'yoyaku']);
Route::post('/yoyaku_fix',[YoyakuController::class, 'yoyakuFix']);



Route::get('/dashboard', function () {return view('dashboard');})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/ichiran',[AdminController::class,'ichiran'])->name('ichiran');
    Route::post('/get_meisai',[AdminController::class,'getMeisai']);//ajax
    Route::get('/date_meisai',[AdminController::class,'dateMeisai']);
    
});

require __DIR__.'/auth.php';
