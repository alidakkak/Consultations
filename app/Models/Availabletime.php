<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Availabletime extends Model
{
    protected  $table="availabletimes";
    protected  $fillable=["id","day","start_time","end_time","user_id"];

    protected$hidden=["updated_at","created_at"];

    public function users(){

        return $this->belongsTo("App\Models\User");
    }
}
