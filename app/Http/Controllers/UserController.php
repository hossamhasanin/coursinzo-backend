<?php

namespace App\Http\Controllers;

use App\Exceptions\CouldntCreateUser;
use App\Http\Requests\StoreUserRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class UserController extends Controller
{
    /**
     * @param StoreUserRequest $request
     * @param UserRepository $repository
     * @throws Throwable
     * @return JsonResponse
     */
    public function store(StoreUserRequest $request, UserRepository $repository) : JsonResponse{
        $checkIfPasswordMatchesConfirmPassword = $request->validated()["password"] != $request->validated()["confirm_password"];

        throw_if($checkIfPasswordMatchesConfirmPassword, CouldntCreateUser::class, "Password doesn't match confirm password.");

        $att = $request->safe()->only(["email" , "name", "password"]);
        $newUser = $repository->store($att);

        $newAccessToken = $newUser->createToken("access_token");

        return new JsonResponse([
            "message" => "User registered successfully",
            "token" => $newAccessToken->plainTextToken
        ]);
    }
}
