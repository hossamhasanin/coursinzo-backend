<?php

namespace App\Http\Controllers;

use App\Exceptions\CouldntCreateUser;
use App\Http\Requests\StoreDailyProgressRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Models\UserDailyProgress;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Throwable;

class UserController extends Controller
{
    public function getDailyProgress(Request $request) : JsonResponse {
        $dailyProgress = $request->user()->dailyProgress()->where("date" , "=" , Carbon::today())->get();

        return new JsonResponse($dailyProgress);
    }

    /**
     * @param StoreDailyProgressRequest $request
     * @return JsonResponse
     */
    public function storeDailyProgress(StoreDailyProgressRequest $request) : JsonResponse {
        /**
         * @var User $user
         */
        $user = $request->user();

        $todayProgress = $user->dailyProgress()->where("date" , "=" , Carbon::today())->get()->first();

        $requestData = $request->merge(["user_id" => $user->id, "date" => Carbon::today()])->all();
        if ($todayProgress == null){
            UserDailyProgress::query()->create($requestData);
        } else {
            $todayProgress->minutes = $todayProgress->minutes + $requestData["minutes"];
            $todayProgress->save();
        }

        return new JsonResponse([
            "message" => "Stored progress successfully"
        ]);
    }

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
