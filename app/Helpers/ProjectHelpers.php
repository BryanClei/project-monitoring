<?php

namespace App\Helpers;

use App\Models\Project;
use App\Response\Messages;
use App\Functions\GlobalFunctions;
use App\Http\Resources\ProjectResource;

class ProjectHelpers
{
    public static function createProject($requestName)
    {
        $post = Project::create([
            "name" => $requestName,
        ]);

        $posted = new ProjectResource($post);

        return GlobalFunctions::save(Messages::PROJECT_SAVE, $posted);
    }

    public static function updateProject($requestName, $model)
    {
        $model->update([
            "name" => $requestName,
        ]);

        new ProjectResource($model);

        return GlobalFunctions::save(Messages::PROJECT_UPDATED, $model);
    }

    public static function archiveProject($model)
    {
        if ($model->deleted_at === null) {
            $model->delete();
            $message = Messages::PROJECT_ARCHIVED;
        } else {
            $model->restore();
            $message = Messages::PROJECT_RESTORE;
        }

        new ProjectResource($model);

        return GlobalFunctions::save($message, $model);
    }
}
