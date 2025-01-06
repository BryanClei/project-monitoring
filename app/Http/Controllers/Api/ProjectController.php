<?php

namespace App\Http\Controllers\Api;

use App\Models\Project;
use App\Response\Messages;
use Illuminate\Http\Request;
use App\Helpers\ProjectHelpers;
use App\Helpers\NotFoundHelpers;
use App\Functions\GlobalFunctions;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Http\Requests\Project\StoreRequest;

class ProjectController extends Controller
{
    public function index()
    {
        $project = Project::useFilters()->dynamicPaginate();

        $response = NotFoundHelpers::notFoundData($project);

        if ($response) {
            return $response;
        }

        ProjectResource::collection($project);

        return GlobalFunctions::responseFunction(
            Messages::PROJECT_DISPLAY,
            $project
        );
    }

    public function show($id)
    {
        $project = Project::where("id", $id)->first();

        $response = NotFoundHelpers::notFoundData($project);

        if ($response) {
            return $response;
        }

        new ProjectResource($project);

        return GlobalFunctions::responseFunction(
            Messages::PROJECT_DISPLAY,
            $project
        );
    }

    public function store(StoreRequest $request)
    {
        return ProjectHelpers::createProject($request->name);
    }

    public function update(StoreRequest $request, $id)
    {
        $model = Project::where("id", $id)
            ->get()
            ->first();

        $response = NotFoundHelpers::notFoundData($model);

        if ($response) {
            return $response;
        }

        return ProjectHelpers::updateProject($request->name, $model);
    }

    public function destroy($id)
    {
        $model = Project::withTrashed()
            ->where("id", $id)
            ->get()
            ->first();

        $response = NotFoundHelpers::notFoundData($model);

        if ($response) {
            return $response;
        }

        return ProjectHelpers::archiveProject($model);
    }
}
