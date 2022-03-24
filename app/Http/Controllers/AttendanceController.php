<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Stamp;
use App\Models\Rest;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
// 今日日付の勤怠しているユーザーを表示する。
// 1ページ5人を出力し、ページで管理する。
    public function create(){
        $stamp_time = Stamp::whereDate("date",Carbon::now()->format("Y-m-d"))->orderBy("user_id","asc")->Paginate(5);
        $page       = User::Paginate(5);
        $rest_time  = DB::table("rests")->whereDate("date",Carbon::now()->format("Y-m-d"))->orderBy("stamp_id","asc")->get();
        return view("attendance",[
            "today"      => Carbon::now()->format("Y-m-d"),
            "attendance" => $stamp_time,
            "rest"       => $rest_time,
        ]);
    }
// 日付サイドの｢</>｣を押すと日付の1日前/1日後のデータを表示する。
// < =　値｢back」を受け取り1日前に戻す。
// > =　値｢next｣を受け取り1日後に進む。
    public function search(Request $request){
        $date     = $request->input("date");
        $day      = date("Y-m-d",strtotime("-1day",strtotime($request->input("date"))));
        // 検証用↓
        $total_at = Rest::whereDate("date",Carbon::now()->format("Y-m-d"))->value("total_at");
        // １日前の処理
        if($request->input("back") == "back"){
            $day        = date("Y-m-d",strtotime("-1day",strtotime($request->input("date"))));
            $attendance = Stamp::whereDate("date",$day)->orderBy("user_id","asc")->Paginate(5);
            $rest_time  = DB::table("rests")->whereDate("date",Carbon::now()->format("Y-m-d"))->orderBy("stamp_id","asc")->get();
        }
        // 1日後の処理
        if($request->input("next") == "next"){
            $day        = date("Y-m-d",strtotime("+1day",strtotime($request->input("date"))));
            $attendance = Stamp::whereDate("date",$day)->orderBy("user_id","asc")->Paginate(5);
            $rest_time  = Rest::whereDate("date",$day)->select("total_at")->get();
        }
        return view("/attendance")->with([
            "today"     =>$day,
            "attendance"=>$attendance,
            "rest"      =>$rest_time,
        ]);
    }
}
