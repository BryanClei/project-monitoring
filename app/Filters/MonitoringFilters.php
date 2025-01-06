<?php

namespace App\Filters;

use Essa\APIToolKit\Filters\QueryFilters;

class MonitoringFilters extends QueryFilters
{
    protected array $allowedFilters = [];

    protected array $columnSearch = [
        "system_id",
        "user_id",
        "module",
        "status",
    ];
}
