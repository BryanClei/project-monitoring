<?php

namespace App\Models;

use App\Filters\TeamFilters;
use Essa\APIToolKit\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Team extends Model
{
    use HasFactory, Filterable, SoftDeletes;

    protected string $default_filters = TeamFilters::class;
    protected $fillable = ["code", "name"];
}
