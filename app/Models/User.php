<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\UserSystem;
use App\Filters\UserFilters;
use Laravel\Sanctum\HasApiTokens;
use Essa\APIToolKit\Filters\Filterable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Filterable, SoftDeletes;
    protected string $default_filters = UserFilters::class;
    protected $fillable = [
        "fullname",
        "group_id",
        "role_id",
        "username",
        "password",
    ];

    protected $hidden = ["password", "remember_token"];

    public function role()
    {
        return $this->belongsTo(Role::class, "role_id", "id");
    }

    public function systems()
    {
        return $this->hasMany(UserSystem::class, "user_id", "id");
    }

    public function group()
    {
        return $this->belongsTo(Team::class, "group_id", "id");
    }
}
