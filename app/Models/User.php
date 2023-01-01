<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Builder;
use App\Filters\UserFilter;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;
    protected  $table = "users";

    protected $fillable = [
        "id",
        'name',
        'email',
        'password',
        'role',
        'specialization',
        'Phone_Number',
        'address',
        'image',
        'rating',
        'category'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        "pivot",
        "created_at",
        "updated_at"
    ];
    public function Availabletime()
    {

        return $this->hasMany("App\Models\Availabletime");
    }
    public function Consulation()
    {

        return $this->hasMany("App\Models\Consulation");
    }

    public function Registeraton()
    {

        return $this->hasMany("App\Models\Registeraton");
    }
    public function Registeraton_normal()
    {

        return $this->hasMany("App\Models\Registeraton","normal_id","id");
    }

    public function Experience()
    {

        return $this->hasMany("App\Models\Experience");
    }

    public function expert()
    {

        return $this->belongsToMany("App\Models\User", "wishlists", "normal_id", "expert_id");
    }
    public function normal()
    {

        return $this->belongsToMany("App\Models\User", "wishlists", "expert_id", "normal_id");
    }

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }


    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function scopeFilter(Builder $builder, $request)
    {
        return (new UserFilter($request))->filter($builder);
    }
}
