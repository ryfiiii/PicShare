<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::post("/post", [HomeController::class, "post"]);
Route::get("/search", [HomeController::class, "search"]);
Route::get("/history", [HomeController::class, "history"])->name("history");
Route::get("/edit/{id}", [HomeController::class, "edit"]);
Route::post("/editt/{id}", [HomeController::class, "editt"]);
Route::get("/delete/{id}", [HomeController::class, "delete"]);
Route::post("/deletee/{id}", [HomeController::class, "deletee"]);