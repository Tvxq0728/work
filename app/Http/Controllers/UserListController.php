<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Stamp;
use App\Models\Rest;

class UserListController extends Controller
{
    public function create(){
        $stamp = Stamp::where("user_id",Auth::user()->id)->orderBy("date","desc")->first();
        // $stamp = Stamp::where("user_id",$user)->orderBy("date","desc")->get();
        return view("userlist",[
            "stamp"=>$stamp,
            // "stamp" => $stamp,
        ]);
    }
}
