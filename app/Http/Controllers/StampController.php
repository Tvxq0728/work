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
    public function create(){
        $user = Auth::user();
        $today = Carbon::now()->format("Y-m-d");
        $end_at = Stamp::where('user_id', $user->id)->where('date', $today)->value('end_at');
        return view("index",
        ["user"=>$user]);
    }

// 勤怠開始を記録する。
// 既に出勤している状態で出勤打刻を押した場合、
// メッセージで知らせる。
    public function attendance_start() {
        $user = Auth::user();
        $today = Carbon::today()->format('Y-m-d');
        $start_time = Stamp::where("user_id",$user->id)->where("date",$today)->value("start_at");
        if ($start_time == null) {
            $start_at = Carbon::now()->format("H:i:s");
            Stamp::create([
                "user_id"=>Auth::id(),
                "date"=>Carbon::now()->format('Y-m-d'),
                "start_at"=>Carbon::now()->format("H:i:s"),
            ]);
            return redirect("/")->with([
                    "message"=>"出勤記録しました。",
                    "start"=>"true",
                    "rest_end"=>"true",
                    "start_test"=>$start_at,
                ]);
        }
        else {
            return redirect("/")->with([
                "message"=>"出勤済",
                "start"=>"true",
                "rest_rest"=>"true",
            ]);
        }
    }
// 勤怠終了を記録すると同時に勤怠時間も計算する。
// 既に退勤している状態で退勤打刻を押した場合、
// メッセージで知らせる。
// 勤怠時間は差分の秒数を計算後、
// 時間/分/秒に切り分けて処理する
    public function attendance_end(){
        $user = Auth::user();
        $today = Carbon::today()->format('Y-m-d');
        $start_at = Stamp::where('user_id', $user->id)->where('date', $today)->orderBy("id","desc")->value('start_at');
        $end_time = Stamp::where('user_id', $user->id)->where('date', $today)->value('end_at');
        if ($end_time !== null){
            return redirect("/")->with("message","退勤済");
        } else {
            $end_at = Carbon::now()->format("H:i:s");
            $work_total = $start_at->diffINSeconds($end_at);
            // 1時間=3600秒であるため、秒数から時間を算出するために差分から3600の商を出す。
            $work_hour = floor($work_total / 3600);
            $work_min = floor(($work_total - 3600 * $work_hour) / 60);
            $work_sec = floor($work_total % 60);
            // 条件式で○○:○○に合わせるようにする。
            $work_hour = $work_hour < 10 ? "0" . $work_hour : $work_hour;
            $work_min = $work_min < 10 ? "0" . $work_min : $work_min;
            $work_sec = $work_sec < 10 ? "0" . $work_sec : $work_sec;
            $work_total = $work_hour . ":" . $work_min . ":" . $work_sec;
            Stamp::where("user_id",$user->id)->where("date",$today)->whereNull("end_at")->update([
                "user_id"=>Auth::id(),
                "end_at"=>Carbon::now()->format("H:i:s"),
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
            "end_at"=>$end_at,

            "test"=>$work_total,
        ]);
    }
// 休憩開始の記録をする。
// 休憩開始を押した時にメッセージで知らせる
// 退勤していた場合、メッセージで知らせる。
    public function rest_start(){
        $user = Auth::user();
        $today = Carbon::today()->format("Y-m-d");
        $stamp = Stamp::where("user_id",$user->id)->orderBy("id","desc")->first();
        $stamp_test = Stamp::where("user_id",$user->id)->latest()->first();
        $rest = Rest::where("stamp_id",$stamp->id)->orderBy("created_at","desc")->first();
        if (!empty($stamp->end_at))
        {
            return redirect("/")->with([
                "message"=>"今日は.$today.です",
                "end"=>"true",
                "rest_start"=>"true",
                "rest_end"=>"true",
            ]);
        }
        elseif (empty($rest)){
                $rest_at = Rest::create([
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
        elseif (!empty($rest->end_at)){
            $rest_at = Rest::where("stamp_id",$stamp->id)->orderBy("created_at","desc")->update([
                    "stamp_id"=>$stamp->id,
                    "date"=>$today,
                    "start_at"=>Carbon::now()->format("H:i:s"),
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
// 休憩終了を記録し、休憩時間を計算する。
// 複数休憩時間を取得する場合上書きして管理をしていく。
// 休憩終了を押した時メッセージを表示する。
// 既に退勤していた場合、メッセージで知らせる。
    public function rest_end(){
        $user = Auth::user();
        $today = Carbon::today()->format("Y-m-d");
        $stamp = Stamp::where("user_id",$user->id)->latest()->first();
        $rest = Rest::where("stamp_id",$stamp->id)->orderBy("created_at","desc")->first();
        if (empty(Rest::where("stamp_id",$stamp->id)->orderBy("created_at","desc")->first()->end_at)){
        $start_at = Rest::where("stamp_id",$stamp->id)->orderby("created_at","desc")->value("start_at");
        $end_at = Carbon::now()->format("H:i:s");
        $rest_total = $start_at->diffINSeconds($end_at);
        $rest_hour = floor($rest_total / 3600);
        $rest_min = floor(($rest_total - 3600 * $rest_hour) / 60);
        $rest_sec = floor($rest_total % 60);
        $rest_hour = $rest_hour < 10 ? "0" . $rest_hour : $rest_hour;
        $rest_min = $rest_min < 10 ? "0" . $rest_min : $rest_min;
        $rest_sec = $rest_sec < 10 ? "0" . $rest_sec : $rest_sec;
        $rest_total = $rest_hour . ":" . $rest_min . ":" . $rest_sec;
        $rest_at = Rest::where("stamp_id",$stamp->id)->orderBy("created_at","desc")->whereNull("end_at")->update([
            "stamp_id"=>$stamp->id,
            "end_at"=>Carbon::now()->format("H:i:s"),
            "total_at"=>$rest_total,
        ]);
        return redirect("/")->with([
            "message"=>"休憩終了記録しました。",
            "start"=>"true",
            "rest_end"=>"true",
        ]);
        }
        elseif (!empty($rest->end_at) && !empty($stamp->end_at))
        {
            return redirect("/")->with([
            "message"=>"今日は. $today .です",
            "end"=>"true",
            "rest_start"=>"true",
            "rest_end"=>"true",
            ]);
        }
        elseif (!empty($rest->end_at)){
            $start_at = Rest::where("stamp_id",$stamp->id)->orderBy("created_at","desc")->value("start_at");
            $end_at = Carbon::now();
            $rest_total = $start_at->diffINSeconds($end_at);
            $rest_hour = floor($rest_total / 3600);
            $rest_min = floor(($rest_total - 3600 * $rest_hour) / 60);
            $rest_sec = floor($rest_total % 60);
            $rest_hour = $rest_hour < 10 ? "0" . $rest_hour : $rest_hour;
            $rest_min = $rest_min < 10 ? "0" . $rest_min : $rest_min;
            $rest_sec = $rest_sec < 10 ? "0" . $rest_sec : $rest_sec;
            $rest_total = $rest_hour . ":" . $rest_min . ":" . $rest_sec;
            $rest_previous = Rest::where("stamp_id",$stamp->id)->orderBy("created_at","desc")->value("total_at");

            $test_at = Rest::where("stamp_id",$stamp->id)->orderBy("created_at","desc")->update([
                "stamp_id"=>$stamp->id,
                "end_at"=>Carbon::now()->format("H:i:s"),
                "total_at"=>"0"
        ]);
        return redirect("/")->with([
            "message"=>"休憩終了記録しました。",
            "start"=>"true",
            "rest_end"=>"true",
            "test"=>$rest_previous,
            "testa"=>$rest_total
        ]);
        }
        else
        {
            return redirect("/")->with([
            "message"=>"休憩終了済",
            "start"=>"true",
            "rest_end"=>"true",
            ]);
    }
    }
}