<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Stamp;
class StampController extends Controller
{
    // ログイン時勤務状態によってボタン機能を制限する。
    public function create(){
        $start_time=null;
        $end_time=null;
        //↓ ○休憩ボタン作成時上記と同じく作る



        $user=Auth::user();
        return view("index",["user"=>$user]);
    }
    // 勤怠開始ボタンを押した時の処理
    public function attendance_start(){
        $user=Auth::user();
        // 日付カラムを追加する必要がある?start_atの型と$todayの型が一致しないため。
        $today=Carbon::today()->format('Y-m-d');
        $start_time=Stamp::where("user_id",$user->id)->where("start_at",$today)->value("start_at");
        // 同日に既に出勤していた場合打刻できないようにする。(else)
        if($start_time == null){
            Stamp::create([
                "user_id"=>Auth::id(),
                "start_at"=>Carbon::now(),
            ]);
            return redirect("/")->with([
                    "message"=>"出勤を記録",
                    "user"=>$user,
                ]);
        }else{
            return redirect("/")->with("message","出勤済");
        }
    }

    // 勤怠終了ボタンを押した時の処理
    public function attendance_end(){
        
    }
}
