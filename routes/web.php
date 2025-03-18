<?php

use App\Http\Controllers\PersonController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/people/degree', [PersonController::class, 'degree'])->name('people.degree');
Route::post('/people', [PersonController::class, 'store'])->name('people.store');
Route::post('/people/show', [PersonController::class, 'show'])->name('people.show');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/people/degree', [PersonController::class, 'degree'])->name('people.degree');
Route::get('/people', [PersonController::class, 'index'])->name('people.index');
Route::get('/people/create', [PersonController::class, 'create'])->name('people.create');
Route::get('/people/show', [PersonController::class, 'show'])->name('people.show');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::get('/login', [AuthController::class, 'login'])->name('login');
