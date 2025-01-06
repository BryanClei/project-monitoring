<?php

namespace App\Models;

use App\Filters\ProjectFilters;
use Essa\APIToolKit\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory, Filterable, SoftDeletes;

    protected string $default_filters = ProjectFilters::class;
    protected $fillable = ["name"];

    public function user_system()
    {
        return $this->belongsTo(UserSystem::class, "user_id", "id");
    }
}
