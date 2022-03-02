<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Stamp extends Model
{
    use HasFactory;

    protected $fillable=["user_id","start_at","date"];
    protected $dates=["start_at","date"];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    public function rest(){
        return $this->hasMany("App\Models\Rest");
    }
}
