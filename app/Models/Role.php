<?php

namespace App\Models;

use App\Filters\RoleFilters;
use Essa\APIToolKit\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory, Filterable, SoftDeletes;

    protected $table = "role";
    protected string $default_filters = RoleFilters::class;
    protected $fillable = ["name", "access_permission"];
}
