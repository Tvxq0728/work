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
        $today=Carbon::today()->format('Y-m-d');
        $start_time=Stamp::where("user_id",$user->id)->where("date",$today)->value("start_at");
        // 同日に既に出勤していた場合打刻できないようにする。(else)
        if($start_time == null){
            Stamp::create([
                "user_id"=>Auth::id(),
                "date"=>Carbon::now()->format('Y-m-d'),
                "start_at"=>Carbon::now(),
            ]);
            return redirect("/")->with([
                    "message"=>"出勤を記録",
                    "user"=>$user,
                ]);
        }else{
            return redirect("/")->with("message","出勤済");
        }
        // $start_day=Stamp::where("user_id",$user->id)->where("start_at",$today)->value("start_at")->latest()->first()->format('Y-m-d');
        // if($start_day == $today){
        //     return redirect("/")->with("message","出勤済");
        // }else{
        //     Stamp::create([
        //         "user_id"=>Auth::id(),
        //         "start_at"=>Carbon::now(),
        //     ]);
        //     return redirect("/")->with([
        //             "message"=>"出勤を記録",
        //             "user"=>$user,
        //             "day"=>$start_day,
        //         ]);
        // }


    }

    // 勤怠終了ボタンを押した時の処理
    public function attendance_end(){
        $user=Auth::user();
        $today=Carbon::today()->format('Y-m-d');
        $start_at=Stamp::where('user_id', $user->id)->where('date', $today)->value('start_at');
        $end_time=Stamp::where('user_id', $user->id)->where('date', $today)->value('end_at');

        if($end_time !== null){
            return redirect("/")->with("message","退勤済");
        }else{
            $end_at=Carbon::now();
            $work_total=$start_at->diffINSeconds($end_at);
            $work_at=date("H:i:s",$work_total);

            Stamp::where("user_id",$user->id)->where("date",$today)->whereNull("end_at")->update([
                "user_id"=>Auth::id(),
                "end_at"=>Carbon::now(),
                "start_at"=>$start_at,
                "work_at"=>$work_at,
            ]);
        }
        return redirect("/")->with([
            "message"=>"退勤記録しました",
            "end_at"=>$end_at,
            "start_at"=>$start_at,
            "work_total"=>$work_total,
            "work_at"=>$work_at,
        ]);
    }
}
