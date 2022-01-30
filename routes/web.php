<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StampController;
use App\Http\Controllers\AttendanceController;


Route::get('/', function () {
    return view('welcome');
});

Route::get("/register",[UserController::class,"create"]);
Route::post("/register",[UserController::class,"store"]);
// 会員登録

Route::get("/login",[UserController::class,"login_create"]);
Route::post("/login",[UserController::class,"login_store"]);
// ログイン画面･処理

Route::get("/",[StampController::class,"create"]);
Route::post("/",[StampController::class,"store"]);
// 出退･休憩打刻画面･処理

Route::get("/attendance",[AttendanceController::class,"create"]);
Route::post("/attendance",[AttendanceController::class,"store"]);
