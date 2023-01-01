<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registeraton extends Model
{

    protected  $table="registeratons";
    protected  $fillable=["id","day","start_time","end_time","registered","normal_id","user_id"];

    protected$hidden=["updated_at","created_at"];

    public function users(){

        return $this->belongsTo("App\Models\User");
    }
    public function normals(){

        return $this->belongsTo("App\Models\User","normal_id","id");
    }
}
