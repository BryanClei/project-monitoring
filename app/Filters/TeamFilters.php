<?php

namespace App\Filters;

use Essa\APIToolKit\Filters\QueryFilters;

class TeamFilters extends QueryFilters
{
    protected array $allowedFilters = [];

    protected array $columnSearch = ["code", "name"];
}
