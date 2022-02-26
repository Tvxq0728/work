<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Stamp;
use App\Models\Rest;

class AttendanceController extends Controller
{
    public function create(){
        $attendance = Stamp::whereDate("date",Carbon::now()->format("Y-m-d"))->latest()->Paginate(5);

        $total_at = Rest::whereDate("date",Carbon::now()->format("Y-m-d")->value("total_at"));

        return view("attendance",[
            "today" => Carbon::now()->format("Y-m-d"),
            "attendance" => $attendance,
            "test1"=>$total_at,
        ]);
    }

    public function search(){
        return redirect("/attendance");
    }
}
