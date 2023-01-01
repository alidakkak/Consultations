<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
  protected  $table="wishlists";
    protected  $fillable=["id","normal_id","expert_id"];

    protected$hidden=["updated_at","created_at","pivot"];



}
