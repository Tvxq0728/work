<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Stamp;
use App\Models\Rest;
class StampController extends Controller
{
    // ログイン時勤務状態によってボタン機能を制限する。
    public function create(){
        $start_time=null;
        $end_time=null;
        //↓ ○休憩ボタン作成時上記と同じく作る


        $user=Auth::user();
        return view("index",
        ["user"=>$user]);
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
                    "start"=>"true",
                    "rest_end"=>"true",
                ]);
        }else{
            return redirect("/")->with([
                "message"=>"出勤済",
                "start"=>"true",
                "rest_rest"=>"true",
            ]);
        }
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

            "end"=>"true",
            "rest_start"=>"true",
            "rest_end"=>"true",
        ]);
    }
    // 休憩開始を押した時の処理
    public function rest_start(){
        $user=Auth::user();
        $today=Carbon::today()->format("Y-m-d");
        $stamp=Stamp::where("user_id",$user->id)->latest()->first();
        $rest_at=Rest::create([
            "stamp_id"=>$stamp->id,
            "date"=>$today,
            "start_at"=>Carbon::now(),
        ]);
        return redirect("/")->with([
            "start"=>"true",
            "end"=>"true",
            "rest_start"=>"true",
        ]);
    }
    // 休憩終了を押した時の処理
    public function rest_end(){
        $user=Auth::user();
        $stamp=Stamp::where("user_id",$user->id)->latest()->first();
        $rest=Rest::where("stamp_id",$stamp->id)->latest()->first();
        $rest_at=Rest::where("stamp_id",$stamp->id)->update([
            "end_at"=>Carbon::now(),
        ]);
        return redirect("/")->with([
            "start"=>"true",
            "rest_end"=>"true",
        ]);
    }
}
