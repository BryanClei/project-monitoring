<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\UserSystem;
use App\Response\Messages;
use Illuminate\Http\Request;
use App\Functions\GlobalFunctions;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\DisplayRequest;
use App\Http\Resources\LoginResource;
use App\Http\Requests\User\LoginRequest;
use App\Http\Resources\TagSystemResource;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Requests\User\TagSystemRequest;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index(DisplayRequest $request)
    {
        $status = $request->status;

        $post = User::with("role", "systems.projects")
            ->when("inactive" === $status, function ($query) {
                $query->onlyTrashed();
            })
            ->useFilters()
            ->orderByDesc("updated_at")
            ->dynamicPaginate();

        if (!$post) {
            return GlobalFunctions::responseFunction(Messages::NO_DATA_FOUND);
        }

        LoginResource::collection($post);

        return GlobalFunctions::responseFunction(Messages::USER_DISPLAY, $post);
    }

    public function show(Request $request, $id)
    {
        $status = $request->status;

        $post = User::with("role")
            ->when("inactive" === $status, function ($query) {
                $query->onlyTrashed();
            })
            ->where("id", $id)
            ->first();

        if (!$post) {
            return GlobalFunctions::responseFunction(Messages::NO_DATA_FOUND);
        }

        new LoginResource($post);

        return GlobalFunctions::responseFunction(Messages::USER_DISPLAY, $post);
    }

    public function store(RegisterRequest $request)
    {
        $post = User::create([
            "fullname" => $request->fullname,
            "group_id" => $request->group_id,
            "username" => $request->username,
            "password" => Hash::make($request->password),
            "role_id" => $request->role_id,
        ]);

        if (!empty($request->systems)) {
            $post->systems()->createMany(
                array_filter($request->systems, function ($system) {
                    return !empty([$system["system_id"]]);
                })
            );
        }

        return GlobalFunctions::save(Messages::USER_SAVE, $post);
    }

    public function login(LoginRequest $request)
    {
        $user = User::with("role")
            ->where("username", $request->username)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                "username" => [Messages::INCORRECT_CREDENTIALS],
                "password" => [Messages::INCORRECT_CREDENTIALS],
            ]);
        }

        $token = $user->createToken("PersonalAccessToken")->plainTextToken;
        $user["token"] = $token;

        $cookie = cookie("project-monitoring", $token);

        $user = new LoginResource($user);

        return GlobalFunctions::responseFunction(
            Messages::LOGIN_USER,
            $user
        )->withCookie($cookie);
    }

    public function destroy($id)
    {
        $post = User::where("id", $id)
            ->withTrashed()
            ->first();

        if (!$post) {
            return GlobalFunctions::responseFunction(
                Messages::USER_NOT_FOUND,
                $post
            );
        }

        if (!$post->deleted_at) {
            $post->delete();
            $message = Messages::ARCHIVE_STATUS;
        } else {
            $post->restore();
            $message = Messages::RESTORE_STATUS;
        }

        return GlobalFunctions::responseFunction($message, $post);
    }

    public function tag_system(TagSystemRequest $request)
    {
        $taggedUserSystems = collect();

        foreach ($request->users as $userInfo) {
            $userId = $userInfo["user_id"];

            foreach ($request->systems as $systemInfo) {
                $systemId = $systemInfo["system_id"];

                $userSystem = UserSystem::firstOrCreate([
                    "user_id" => $userId,
                    "system_id" => $systemId,
                ]);

                $taggedUserSystems->push($userSystem);
            }
        }

        $taggedUserSystemsResource = TagSystemResource::collection(
            $taggedUserSystems
        );

        return GlobalFunctions::responseFunction(
            Messages::USER_SYSTEM_SAVE,
            $taggedUserSystemsResource
        );
    }
}
