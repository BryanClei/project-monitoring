<?php

namespace App\Helpers;

use App\Models\Monitoring;
use App\Response\Messages;
use App\Functions\GlobalFunctions;
use App\Http\Resources\MonitoringResource;

class MonitoringHelpers
{
    public static function createMonitoring($data)
    {
        $post = Monitoring::create([
            "system_id" => $data["system_id"],
            "user_id" => $data["user_id"],
            "module" => $data["module"],
            "description" => $data["description"],
            "raise_date" => $data["raise_date"],
            "start_date" => $data["start_date"],
            "end_date" => $data["end_date"],
            "remarks" => $data["remarks"],
            "status" => $data["status"],
        ]);

        $posted = new MonitoringResource($post);

        return GlobalFunctions::save(Messages::MONITORING_SAVE, $posted);
    }

    public static function updateMonitoring($model, $data)
    {
        $model->update([
            "system_id" => $data["system_id"],
            "user_id" => $data["user_id"],
            "module" => $data["module"],
            "description" => $data["description"],
            "raise_date" => $data["raise_date"],
            "start_date" => $data["start_date"],
            "end_date" => $data["end_date"],
            "remarks" => $data["remarks"],
            "status" => $data["status"],
        ]);

        new MonitoringResource($model);

        return GlobalFunctions::responseFunction(
            Messages::MONITORING_UPDATED,
            $model
        );
    }

    public static function archivedMonitoring($model)
    {
        if ($model->deleted_at === null) {
            $model->delete();
            $message = Messages::MONITORING_ARCHIVED;
        } else {
            $model->restore();
            $message = Messages::MONITORING_RESTORED;
        }

        new MonitoringResource($model);

        return GlobalFunctions::responseFunction($message, $model);
    }
}
