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
    public function index(){
        $user   = Auth::user();
        $end_at = Stamp::where('user_id', $user->id)
        ->where('date', Carbon::now()
        ->format("Y-m-d"))
        ->value('end_at');
        return view("index",
        ["user"=>$user]);
    }
// 勤怠開始を記録する。
// 既に出勤している状態で出勤打刻を押した場合、メッセージで知らせる。
    public function attendance_start() {
        $start_time = Stamp::where("user_id",Auth::user()->id)
        ->where("date",Carbon::today()
        ->format("Y-m-d"))
        ->value("start_at");
        if ($start_time == null) {
            Stamp::create([
                "user_id" =>Auth::id(),
                "date"    =>Carbon::now()->format('Y-m-d'),
                "start_at"=>Carbon::now()->format("H:i:s"),
            ]);
            return redirect("/")->with([
                    "message" =>"出勤記録しました。",
                    "start"   =>"true",
                    "rest_end"=>"true",
                ]);
        }
            return redirect("/")->with([
                    "message"  =>"出勤済",
                    "start"    =>"true",
                    "rest_rest"=>"true",
        ]);

    }
// 勤怠終了を記録すると同時に勤怠時間も計算する。
// 既に退勤している状態で退勤打刻を押した場合、
// メッセージで知らせる。
// 勤怠時間は差分の秒数を計算後、
// 時間/分/秒に切り分けて処理する
    public function attendance_end(){
        $user     = Auth::user();
        $today    = Carbon::today()->format('Y-m-d');
        $end_time = Stamp::where('user_id', $user->id)->where('date', $today)->value('end_at');
        if ($end_time !== null)
        {
            return redirect("/")->with("message","退勤済または休憩中");
        }
        elseif (!empty( Stamp::where('user_id', $user->id)->where('date', $today)->value('rest_id')))
        {
        $work_total = Stamp::where('user_id', $user->id)
        ->where('date', $today)
        ->orderBy("id","desc")
        ->value('start_at')
        ->diffINSeconds(Carbon::now()->format("H:i:s"));
        // 1時間=3600秒であるため、秒数から時間を算出するために差分から3600の商を出す。
        $work_hour  = floor($work_total / 3600);
        $work_min   = floor(($work_total - 3600 * $work_hour) / 60);
        $work_sec   = floor($work_total % 60);
        // 条件式で○○:○○に合わせるようにする。
        $work_hour  = $work_hour < 10 ? "0" . $work_hour : $work_hour;
        $work_min   = $work_min < 10 ? "0" . $work_min : $work_min;
        $work_sec   = $work_sec < 10 ? "0" . $work_sec : $work_sec;
        $work_total = $work_hour . ":" . $work_min . ":" . $work_sec;
        // 休憩時間を差し引いた勤務時間
        $attendance_total = Rest::where("stamp_id",Stamp::where("user_id",Auth::user()->id)
        ->latest()
        ->first()
        ->id)
        ->orderby("created_at","desc")
        ->value("total_at")
        ->diffINSeconds($work_total);
        $attendance_hour  = floor($attendance_total / 3600);
        $attendance_min   = floor(($attendance_total - 3600 * $attendance_hour) / 60);
        $attendance_sec   = floor($attendance_total % 60);
        $attendance_hour  = $attendance_hour < 10 ? "0" . $attendance_hour : $attendance_hour;
        $attendance_min   = $attendance_min < 10 ? "0" . $attendance_min : $attendance_min;
        $attendance_sec   = $attendance_sec < 10 ? "0" . $attendance_sec : $attendance_sec;
        $attendance_total = $attendance_hour . ":" . $attendance_min . ":" . $attendance_sec;
        Stamp::where("user_id",$user->id)
            ->where("date",$today)
            ->whereNull("end_at")
            ->update([
            "user_id"=>Auth::id(),
            "end_at" =>Carbon::now()->format("H:i:s"),
            "work_at"=>$attendance_total,
            ]);
        return redirect("/")->with([
            "message"   =>"退勤記録しました。",
            "end"       =>"true",
            "rest_start"=>"true",
            "rest_end"  =>"true",
        ]);
        }
        $work_total = Stamp::where('user_id', $user->id)
        ->where('date', $today)
        ->orderBy("id","desc")
        ->value('start_at')
        ->diffINSeconds(Carbon::now()->format("H:i:s"));
        // 1時間=3600秒であるため、秒数から時間を算出するために差分から3600の商を出す。
        $work_hour  = floor($work_total / 3600);
        $work_min   = floor(($work_total - 3600 * $work_hour) / 60);
        $work_sec   = floor($work_total % 60);
        // 条件式で○○:○○に合わせるようにする。
        $work_hour  = $work_hour < 10 ? "0" . $work_hour : $work_hour;
        $work_min   = $work_min < 10 ? "0" . $work_min : $work_min;
        $work_sec   = $work_sec < 10 ? "0" . $work_sec : $work_sec;
        $work_total = $work_hour . ":" . $work_min . ":" . $work_sec;
        Rest::create([
            "stamp_id"=>Stamp::where("user_id",$user->id)
            ->orderBy("id","desc")
            ->first()
            ->id,
            "date"    =>$today,
            "start_at"=>Carbon::today()->format("H:i:s"),
            "end_at"  =>Carbon::today(),
            "total_at"=>Carbon::today(),
        ]);
        Stamp::where("user_id",$user->id)
            ->where("date",$today)
            ->whereNull("end_at")
            ->update([
            "user_id"=>Auth::id(),
            "end_at" =>Carbon::now()->format("H:i:s"),
            "work_at"=>$work_total,
            "rest_id"=>Rest::where("stamp_id",Stamp::where("user_id",$user->id)
        ->orderBy("id","desc")
        ->first()->id)
            ->orderBy("created_at","desc")
            ->value("id")
        ]);
        return redirect("/")->with([
            "message"   =>"退勤記録しました。",
            "end"       =>"true",
            "rest_start"=>"true",
            "rest_end"  =>"true",
        ]);
    }
// 休憩開始の記録をする。
// 休憩開始を押した時にメッセージで知らせる
// 退勤していた場合、メッセージで知らせる。
    public function rest_start(){
        $user       = Auth::user();
        $today      = Carbon::today()->format("Y-m-d");
        $stamp      = Stamp::where("user_id",$user->id)
        ->orderBy("id","desc")
        ->first();
        $stamp_test = Stamp::where("user_id",$user->id)
        ->latest()
        ->first();
        $rest       = Rest::where("stamp_id",$stamp->id)
        ->orderBy("created_at","desc")
        ->first();
        if (!empty($stamp->end_at))
        {
            return redirect("/")->with([
                "message"   =>"今日は.$today.です",
                "end"       =>"true",
                "rest_start"=>"true",
                "rest_end"  =>"true",
            ]);
        }
        elseif (empty($rest)){
                $rest_at = Rest::create([
                    "stamp_id"=>$stamp->id,
                    "date"    =>$today,
                    "start_at"=>Carbon::now(),
                ]);
                Stamp::where("user_id",$user->id)
                ->orderBy("id","desc")
                ->first()
                ->update([
                    "rest_id" => Rest::where("stamp_id",$stamp->id)
                                ->orderBy("created_at","desc")
                                ->value("id")
                ]);
                return redirect("/")->with([
                    "message"   =>"休憩開始記録しました。",
                    "start"     =>"true",
                    "end"       =>"true",
                    "rest_start"=>"true",
                ]);
        }
        elseif (!empty($rest->end_at)){
            $rest_at = Rest::where("stamp_id",$stamp->id)
            ->orderBy("created_at","desc")
            ->update([
                    "stamp_id"=>$stamp->id,
                    "date"    =>$today,
                    "start_at"=>Carbon::now()->format("H:i:s"),
                ]);
                return redirect("/")->with([
                    "message"   =>"休憩開始記録しました。",
                    "start"     =>"true",
                    "end"       =>"true",
                    "rest_start"=>"true",
                ]);
        }
                return redirect("/")->with([
                    "message"   =>"休憩中です",
                    "start"     =>"true",
                    "end"       =>"true",
                    "rest_start"=>"true",
        ]);
    }
// 休憩終了を記録し、休憩時間を計算する。
// 複数休憩時間を取得する場合上書きして管理をしていく。
// 2回目以降の休憩は休憩時間を時/分/秒に分けてそれぞれ計算し結合させる。
// 休憩終了を押した時メッセージを表示する。
// 既に退勤していた場合、メッセージで知らせる。
    public function rest_end(){
        $user  = Auth::user();
        $today = Carbon::today()->format("Y-m-d");
        $stamp = Stamp::where("user_id",Auth::user()->id)
        ->latest()
        ->first();
        $rest  = Rest::where("stamp_id",$stamp->id)
        ->orderBy("created_at","desc")
        ->first();
        if (empty(Rest::where("stamp_id",$stamp->id)
        ->orderBy("created_at","desc")
        ->first()->end_at)){
        $rest_total = Rest::where("stamp_id",$stamp->id)
        ->orderby("created_at","desc")
        ->value("start_at")
        ->diffINSeconds(Carbon::now()->format("H:i:s"));
        $rest_hour  = floor($rest_total / 3600);
        $rest_min   = floor(($rest_total - 3600 * $rest_hour) / 60);
        $rest_sec   = floor($rest_total % 60);
        $rest_hour  = $rest_hour < 10 ? "0" . $rest_hour : $rest_hour;
        $rest_min   = $rest_min < 10 ? "0" . $rest_min : $rest_min;
        $rest_sec   = $rest_sec < 10 ? "0" . $rest_sec : $rest_sec;
        $rest_total = $rest_hour . ":" . $rest_min . ":" . $rest_sec;
        $rest_at = Rest::where("stamp_id",$stamp->id)
        ->orderBy("created_at","desc")
        ->whereNull("end_at")
        ->update([
            "stamp_id"=>$stamp->id,
            "end_at"  =>Carbon::now()->format("H:i:s"),
            "total_at"=>$rest_total,
        ]);
        return redirect("/")->with([
            "message" =>"休憩終了記録しました。",
            "start"   =>"true",
            "rest_end"=>"true",
        ]);
        }
        elseif (!empty($rest->end_at) && !empty($stamp->end_at))
        {
            return redirect("/")->with([
            "message"   =>"今日は. $today .です",
            "end"       =>"true",
            "rest_start"=>"true",
            "rest_end"  =>"true",
            ]);
        }
        elseif (!empty($rest->end_at)){
            $rest_total = Rest::where("stamp_id",$stamp->id)
            ->orderBy("created_at","desc")
            ->value("start_at")
            ->diffINSeconds(Carbon::now());
            $rest_hour  = floor($rest_total / 3600);
            $rest_min   = floor(($rest_total - 3600 * $rest_hour) / 60);
            $rest_sec   = floor($rest_total % 60);
            $rest_hour  = $rest_hour < 10 ? "0" . $rest_hour : $rest_hour;
            $rest_min   = $rest_min < 10 ? "0" . $rest_min : $rest_min;
            $rest_sec   = $rest_sec < 10 ? "0" . $rest_sec : $rest_sec;
            $rest_total = $rest_hour . ":" . $rest_min . ":" . $rest_sec;
            // 休憩時間の更新　↓
            $rest_previous_total = Carbon::today()
            ->diffInSeconds(Rest::where("stamp_id",$stamp->id)
            ->orderBy("created_at","desc")
            ->value("total_at")
            ->format("H:i:s"));
            $test_hour  = floor(floor($rest_previous_total / 3600) + $rest_hour);
            $test_min   = floor(floor($rest_previous_total - 3600 * $test_hour) / 60 + $rest_min);
            $test_sec   = floor(floor($rest_previous_total % 60) + $rest_sec);
            $test_hour  = $test_hour < 10 ? "0" . $test_hour : $test_hour;
            $test_min   = $test_min < 10 ? "0" . $test_min : $test_min;
            $test_sec   = $test_sec < 10 ? "0" . $test_sec : $test_sec;
            $test_total = $test_hour . ":" . $test_min . ":" . $test_sec;
            $test_at    = Rest::where("stamp_id",$stamp->id)
            ->orderBy("created_at","desc")
            ->update([
                "stamp_id"=>$stamp->id,
                "end_at"  =>Carbon::now()->format("H:i:s"),
                "total_at"=>$test_total
            ]);
        return redirect("/")->with([
            "message" =>"休憩終了記録しました。",
            "start"   =>"true",
            "rest_end"=>"true",
        ]);
        }
        return redirect("/")->with([
            "message" =>"休憩終了済",
            "start"   =>"true",
            "rest_end"=>"true",
        ]);
    }
}
