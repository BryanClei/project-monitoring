<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Response\Messages;
use Illuminate\Http\Request;
use App\Functions\GlobalFunctions;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;

class UserController extends Controller
{
    public function index()
    {
    }

    public function store(RegisterRequest $request)
    {
        return "me";
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

            if ($user || Hash::check($request->password, $user->username)) {
                return GlobalFunctions::invalid(Message::INVALID_ACTION);
            }
        }
        $token = $user->createToken("PersonalAccessToken")->plainTextToken;
        $user["token"] = $token;

        $cookie = cookie("project-monitoring", $token);

        $user = new LoginResource($user);

        return GlobalFunction::responseFunction(
            Message::LOGIN_USER,
            $user
        )->withCookie($cookie);
    }
}
