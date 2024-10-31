<?php

namespace App\Http\Controllers\Api;

use App\Models\Team;
use App\Response\Messages;
use Illuminate\Http\Request;
use App\Functions\GlobalFunctions;
use App\Http\Controllers\Controller;
use App\Http\Resources\TeamResource;
use App\Http\Requests\Team\StoreRequest;
use App\Http\Requests\Team\DeleteRequest;
use App\Http\Requests\Team\UpdateRequest;

class TeamController extends Controller
{
    public function index()
    {
        return $teams = Team::useFilters()->dynamicPaginate();
    }

    public function show()
    {
    }

    public function store(StoreRequest $request)
    {
        $post = Team::create([
            "code" => $request->code,
            "name" => $request->name,
        ]);

        $post = new TeamResource($post);

        return GlobalFunctions::save(Messages::TEAM_SAVE, $post);
    }

    public function update(UpdateRequest $request, $id)
    {
        $team = Team::find($id);

        if (!$team) {
            return GlobalFunctions::notFound(Messages::TEAM_NOT_FOUND);
        }

        $patch = $team->update([
            "code" => $request->code,
            "name" => $request->name,
        ]);

        $patch = new TeamResource($team);

        return GlobalFunctions::responseFunction(
            Messages::TEAM_UPDATED,
            $patch
        );
    }

    public function destroy(DeleteRequest $request, $id)
    {
        $delete_type = $request->delete_type;

        $team = Team::withTrashed()
            ->where("id", $id)
            ->first();

        if (!$team) {
            return GlobalFunctions::notFound(Messages::TEAM_NOT_FOUND);
        }

        switch ($delete_type) {
            case "archive":
                if ($team->deleted_at) {
                    $team->restore();
                    return GlobalFunctions::responseFunction(
                        Messages::TEAM_RESTORE,
                        $team
                    );
                } else {
                    $team->delete();
                    return GlobalFunctions::responseFunction(
                        Messages::TEAM_ARCHIVED,
                        $team
                    );
                }
                break;
            case "permanent":
                $team->forceDelete();
                return GlobalFunctions::responseFunction(
                    Messages::TEAM_PERMANENTLY_DELETED,
                    $team
                );
                break;
        }
    }
}
