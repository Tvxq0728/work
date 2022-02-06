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

    public function stampstart(Request $request){
        $user=Auth::user();
        $stampstart=Carbon::today();
        $stamp_at=Stamp::create([
            "user_id"=>$user->id,
            "start_at"=>Carbon::now()
        ]);
    }
}
