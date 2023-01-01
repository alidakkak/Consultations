<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected  $table="experiences";
    protected  $fillable=["id","title","description","years","user_id"];

    protected $hidden=["updated_at","created_at"];
    public function users(){

        return $this->belongsTo("App\Models\User");
    }
}
