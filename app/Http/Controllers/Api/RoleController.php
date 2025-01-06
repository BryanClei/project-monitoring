<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use App\Response\Messages;
use App\Helpers\RoleHelpers;
use Illuminate\Http\Request;
use App\Helpers\NotFoundHelpers;
use App\Functions\GlobalFunctions;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use App\Http\Requests\DisplayRequest;
use App\Http\Requests\Role\StoreRequest;

class RoleController extends Controller
{
    public function index(DisplayRequest $request)
    {
        $status = $request->status;
        $post = Role::when("inactive" === $status, function ($query) {
            $query->onlyTrashed();
        })
            ->useFilters()
            ->orderByDesc("updated_at")
            ->dynamicPaginate();

        $response = NotFoundHelpers::notFoundData($post);

        if ($response) {
            return $response;
        }

        RoleResource::collection($post);

        return GlobalFunctions::responseFunction(Messages::ROLE_DISPLAY, $post);
    }

    public function show($id)
    {
        $post = Role::withTrashed()
            ->where("id", $id)
            ->get()
            ->first();

        $response = NotFoundHelpers::notFoundData($post);

        if ($response) {
            return $response;
        }

        new RoleResource($post);

        return GlobalFunctions::responseFunction(Messages::ROLE_DISPLAY, $post);
    }

    public function store(StoreRequest $request)
    {
        $access_permission = $request->access_permission;
        $accessConvertedToString = implode(",", $access_permission);

        return RoleHelpers::createRole(
            $request->name,
            $accessConvertedToString
        );
    }

    public function update(StoreRequest $request, $id)
    {
        $access_permission = $request->access_permission;
        $accessConvertedToString = implode(",", $access_permission);

        $model = Role::where("id", $id)
            ->get()
            ->first();

        $response = NotFoundHelpers::notFoundData($model);

        if ($response) {
            return $response;
        }

        return RoleHelpers::updateRole(
            $request->name,
            $accessConvertedToString,
            $model
        );
    }

    public function destroy($id)
    {
        $model = Role::withTrashed()
            ->where("id", $id)
            ->get()
            ->first();

        $response = NotFoundHelpers::notFoundData($model);

        if ($response) {
            return $response;
        }

        return RoleHelpers::archivedRole($model);
    }
}
