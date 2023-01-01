<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consulation extends Model
{

    protected  $table="consulations";
    protected  $fillable=["id","title","description","price","user_id"];

    protected$hidden=["updated_at","created_at"];

    public function users(){

        return $this->belongsTo("App\Models\User");
    }
}
