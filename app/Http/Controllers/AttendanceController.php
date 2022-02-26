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

        return view("attendance",[
            "today" => Carbon::now()->format("Y-m-d"),
            "attendance" => $attendance,
        ]);
    }

    public function search(){
        return redirect("/attendance");
    }
}
