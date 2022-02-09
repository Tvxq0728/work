<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StampController;
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

// 打刻ページ処理
Route::get('/', function () {
    return view("index");
    // [StampController::class,"create"];
})->middleware(["auth"]);

Route::post("/",function(){
    [StampController::class,"create"];
})->middleware(["auth"]);

// 勤怠開始処理
Route::post("/stamp/start",[StampController::class,"start_attendance"]
)->middleware(["auth"]);



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
