<?php

namespace App\Helpers;

use App\Response\Messages;
use App\Functions\GlobalFunctions;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class NotFoundHelpers
{
    public static function notFoundData($model)
    {
        if (empty($model)) {
            return GlobalFunctions::notFound(Messages::NO_DATA_FOUND);
        }

        if ($model instanceof LengthAwarePaginator && $model->total() === 0) {
            return GlobalFunctions::notFound(Messages::NO_DATA_TO_DISPLAY);
        }

        if ($model instanceof Collection && $model->isEmpty()) {
            return GlobalFunctions::notFound(Messages::NO_DATA_TO_DISPLAY);
        }

        return null;
    }
}
