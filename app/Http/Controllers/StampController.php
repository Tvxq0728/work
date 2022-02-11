<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Stamp;
class StampController extends Controller
{
    public function create(){
        return view("index");
    }
    // 出勤時の処理
    public function start_attendance(Request $request){
        $user=Auth::user();
        $today=Carbon::today()->format("Y-m-d");
        $start_time=Stamp::where("user_id",$user->id)->where("start_at",$today)->value("start_at");

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
}
