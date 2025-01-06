<?php

namespace App\Models;

use App\Filters\MonitoringFilters;
use Essa\APIToolKit\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Monitoring extends Model
{
    protected string $default_filters = MonitoringFilters::class;
    use HasFactory, Filterable, SoftDeletes;

    protected $table = "monitoring";

    protected $fillable = [
        "system_id",
        "user_id",
        "module",
        "description",
        "raise_date",
        "start_date",
        "end_date",
        "remarks",
        "status",
    ];
}
