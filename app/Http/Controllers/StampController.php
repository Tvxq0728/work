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
                    "message"=>"出勤記録しました。",
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
        $user = Auth::user();
        $today=Carbon::today()->format('Y-m-d');
        $start_at=Stamp::where('user_id', $user->id)->where('date', $today)->orderBy("id","desc")->value('start_at');
        $end_time=Stamp::where('user_id', $user->id)->where('date', $today)->value('end_at');

        if ($end_time !== null){
            return redirect("/")->with("message","退勤済");
        } else {
            $end_at=Carbon::now();
            $work_total=$start_at->diffINSeconds($end_at);
            $work_at=date("H:i:s",$work_total);

            Stamp::where("user_id",$user->id)->where("date",$today)->whereNull("end_at")->update([
                "user_id"=>Auth::id(),
                "end_at"=>Carbon::now(),
                "start_at"=>$start_at,
                "work_at"=>$work_total,
            ]);
        }
        return redirect("/")->with([
            "message"=>"退勤記録しました。",
            // "end_at"=>$end_at,
            // "start_at"=>$start_at,
            // "work_total"=>$work_total,
            // "work_at"=>$work_at,
            "end"=>"true",
            "rest_start"=>"true",
            "rest_end"=>"true",
        ]);
    }
    // 休憩開始を押した時の処理
    public function rest_start(){
        $user=Auth::user();
        $today=Carbon::today()->format("Y-m-d");
        $stamp=Stamp::where("user_id",$user->id)->orderBy("id","desc")->first();
        $stamp_test=Stamp::where("user_id",$user->id)->latest()->first();
        $rest=Rest::where("stamp_id",$stamp->id)->orderBy("created_at","desc")->first();

        // $rest_desc=Rest::where("stamp_id",$stamp->id)->orderBy("stamp_id","desc")->get();

        if(!empty($stamp->end_at))
        {
            // 勤怠終了していた場合。
            return redirect("/")->with([
                "message"=>"今日は.$today.です",
                "end"=>"true",
                "rest_start"=>"true",
                "rest_end"=>"true",
            ]);
        }
        elseif(empty($rest) || !empty($rest->end_at)){
                $rest_at=Rest::create([
                    "stamp_id"=>$stamp->id,
                    "date"=>$today,
                    "start_at"=>Carbon::now(),
                ]);
                return redirect("/")->with([
                    "message"=>"休憩開始記録しました。",
                    "start"=>"true",
                    "end"=>"true",
                    "rest_start"=>"true",
                    // "rest_desc"=>$rest_desc,
                    // "rest_first"=>$rest,
                ]);
        }
        else{
            return redirect("/")->with([
                "message"=>"休憩中です",
                "start"=>"true",
                "end"=>"true",
                "rest_start"=>"true",
                // "rest_desc"=>$rest_desc,
                // "rest_first"=>$rest,
            ]);
        }
    }
    // 休憩終了を押した時の処理
    public function rest_end(){
        $user=Auth::user();
        $today=Carbon::today()->format("Y-m-d");
        $stamp=Stamp::where("user_id",$user->id)->latest()->first();
        $rest=Rest::where("stamp_id",$stamp->id)->orderBy("created_at","desc")->first();

        $rest_desc=Rest::where("stamp_id",$stamp->id)->orderBy("created_at","desc")->get();

        if(empty($rest->end_at)){
        $start_at=Rest::where("stamp_id",$stamp->id)->orderby("created_at","desc")->value("start_at");
        $end_at=Carbon::now();
        $total=$start_at->diffINSeconds($end_at);
        $total_at=date("H:i:s",$total);

        $rest_at=Rest::where("stamp_id",$stamp->id)->orderBy("created_at","desc")->whereNull("end_at")->update([
            "stamp_id"=>$stamp->id,
            "end_at"=>Carbon::now(),
            "total_at"=>$total,
        ]);
        return redirect("/")->with([
            "message"=>"休憩終了記録しました。",
            "start"=>"true",
            "rest_end"=>"true",
        ]);
        }
        // 勤怠終了していた場合 本日日付を出す。
        elseif(!empty($rest->end_at) && !empty($stamp->end_at))
        {
            return redirect("/")->with([
            "message"=>"今日は.$today.です",
            "end"=>"true",
            "rest_start"=>"true",
            "rest_end"=>"true",
            ]);
        }else{
            return redirect("/")->with([
            "message"=>"休憩終了済",
            "start"=>"true",
            "rest_end"=>"true",
            ]);
    }
    }
}
