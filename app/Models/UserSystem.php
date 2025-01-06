<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSystem extends Model
{
    use HasFactory;

    protected $table = "user_systems";

    protected $fillable = ["user_id", "system_id"];

    public function users()
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }

    public function projects()
    {
        return $this->belongsTo(Project::class, "system_id", "id");
    }
}
