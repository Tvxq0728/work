<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Stamp;
use App\Models\User;

class Rest extends Model
{
    use HasFactory;
    protected $fillable=["stamp_id","start_at","date","end_at","total_at"];
    protected $dates=["start_at","total_at"];
    public function user(){
        return $this->hasMany("App\Models\Stamp");
    }
}
