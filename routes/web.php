<?php

use App\Http\Controllers\ProfileController;
use App\Http\Livewire\Auth\Register;
use App\Http\Livewire\Test;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', Dashboard::class);
});


Route::middleware('guest')->group(function () {
    Route::get('/register', Register::class)->name('auth.register');
});

