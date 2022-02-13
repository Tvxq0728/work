<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stamp extends Model
{
    use HasFactory;

    protected $fillable=["user_id","start_at"];

    public function user(){
        return $this->belongTo("App\Models\User");
    }
}
