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

// 打刻ページ
Route::get('/', function () {
    // [StampController::class,"create"];
    $user=Auth::user();
    return view("index",["user"=>$user]);
})->middleware(["auth"]);

Route::post('/', function () {
    [StampController::class,"create"];
})->middleware(["auth"]);



//勤怠開始ボタンを押した時
Route::post("/stamp/start",[StampController::class,"attendance_start"]
)->middleware(["auth"]);
// 勤怠終了ボタンを押した時
Route::post("/stamp/end",[StampController::class,"attendance_end"])->middleware(["auth"]);

//休憩開始ボタンを押した時
Route::post("rest/start",[StampController::class,"rest_start"])->middleware(["auth"]);
//休憩終了ボタンを押した時
Route::post("rest/end",[StampController::class,"rest_end"])->middleware(["auth"]);

// 日別勤怠管理


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
