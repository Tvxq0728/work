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
    public function create(){
        $attendance = Stamp::whereDate("date",Carbon::now()->format("Y-m-d"))->orderBy("user_id","asc")->Paginate(5);
        

        $attendance_total = Stamp::whereDate("date",Carbon::now()->format("Y-m-d"))->orderBy("user_id","asc")->Paginate(5);

        $total_at = DB::table("rests")->whereDate("date",Carbon::now()->format("Y-m-d"))->orderBy("stamp_id","asc")->get();

        $rest_at = Rest::whereDate("date",Carbon::now()->format("Y-m-d"))->select("total_at")->get();

        return view("attendance",[
            "today" => Carbon::now()->format("Y-m-d"),
            "attendance" => $attendance,
            "attendance_total"=>$attendance_total,
            "total"=>$total_at,
            "rest"=>$rest_at,
        ]);
    }

    public function search(Request $request){
        // 今日日付
        $date = $request->input("date");
        $day=date("Y-m-d",strtotime("-1day",strtotime($request->input("date"))));
        // 検証用↓
        $total_at = Rest::whereDate("date",Carbon::now()->format("Y-m-d"))->value("total_at");


        // １日前の処理
        if($request->input("back") == "back"){
            $day = date("Y-m-d",strtotime("-1day",strtotime($request->input("date"))));
            $attendance = Stamp::whereDate("date",$day)->orderBy("user_id","asc")->Paginate(5);
            $attendance_total = Stamp::whereDate("date",$day)->orderBy("user_id","asc")->Paginate(5);
            $rest_at = Rest::whereDate("date",$day)->select("total_at")->get();
        }
        // 1日後の処理
        if($request->input("next") == "next"){
            $day = date("Y-m-d",strtotime("+1day",strtotime($request->input("date"))));
            $attendance = Stamp::whereDate("date",$day)->orderBy("user_id","asc")->Paginate(5);
            $rest_at = Rest::whereDate("date",$day)->select("total_at")->get();
        }


        return view("/attendance")->with([
            "today"=>$day,
            "attendance"=>$attendance,
            "attendance_total"=>$attendance_total,
            // 検証用↓ 休憩時間
            "total"=>$total_at,
            "rest"=>$rest_at,
        ]);
    }
}
