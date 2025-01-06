<?php

namespace App\Helpers;

use App\Models\Role;
use App\Response\Messages;
use App\Functions\GlobalFunctions;
use App\Http\Resources\RoleResource;

class RoleHelpers
{
    public static function createRole($name, $accessConvertedToString)
    {
        $post = Role::create([
            "name" => $name,
            "access_permission" => $accessConvertedToString,
        ]);

        $posted = new RoleResource($post);

        return GlobalFunctions::save(Messages::ROLE_SAVE, $posted);
    }

    public static function updateRole(
        $roleName,
        $accessConvertedToString,
        $role
    ) {
        $role->update([
            "name" => $roleName,
            "access_permission" => $accessConvertedToString,
        ]);

        new RoleResource($role);

        return GlobalFunctions::save(Messages::ROLE_UPDATED, $role);
    }

    public static function archivedRole($model)
    {
        if ($model->deleted_at === null) {
            $model->delete();
            $message = Messages::ROLE_ARCHIVED;
        } else {
            $model->restore();
            $message = Messages::ROLE_RESTORE;
        }

        new RoleResource($model);

        return GlobalFunctions::responseFunction($message, $model);
    }
}
