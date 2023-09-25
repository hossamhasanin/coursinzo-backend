<?php

namespace App\Http\Controllers;

use App\Exceptions\CouldntCreateUser;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreDailyProgressRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;
use App\Models\UserDailyProgress;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Throwable;

class UserController extends Controller
{
    public function getDailyProgress(Request $request) : JsonResponse {
        $dailyProgress = $request->user()->dailyProgress()->where("date" , "=" , Carbon::today())->get();

        return new JsonResponse($dailyProgress);
    }

    public function getLatestCoursesProgress(Request $request) : JsonResponse {
        $numCoursesToGet = $request->courses_num ?? 2;
        $boughtCourses = DB::table("courses")
            ->join("orders", "courses.id", "=", "orders.course_id")
            ->join("users", "orders.user_id", "=", "users.id")
            ->where("users.id" , "=", $request->user()->id)
            ->where("orders.status", "=", 1)
            ->select("courses.*", "orders.status as order_status")
            ->latest()
            ->take($numCoursesToGet)
            ->get();

        $coursesProgress = $boughtCourses->map(function ($course, int $key) use ($request) {
            $watchedLessons = Course::query()
                ->find($course->id)
                ->join("lessons" , "courses.id" , "=" , "lessons.course_id")
                ->join("watched_lessons", "lessons.id", "=" , "watched_lessons.lesson_id")
                ->where("watched_lessons.user_id" , "=" , $request->user()->id)
                ->count();
            $courseLessons = Lesson::query()
                ->where("course_id" , "=" , $course->id)
                ->count();
            return [
                "watched_lessons" => $watchedLessons,
                "course_lessons" => $courseLessons,
                "course_name" => $course->name
            ];
        });

        return new JsonResponse([
            "data" => $coursesProgress
        ]);
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

    public function login(LoginUserRequest $request) : JsonResponse {
        /**
         * @var User $user
         */
        $user = User::query()->firstWhere([
            ["email" , "=" , $request->validated()["email"]]
        ]);

        if (Hash::check($request->validated()["password"], $user->password)){
            $user->tokens()->delete();
            return new JsonResponse([
                "message" => "Logged in successfully",
                "token" => $user->createToken("access_token")->plainTextToken
            ]);
        } else {
            return new JsonResponse([
                "message" => "Wrong email or password"
            ], 401);
        }
    }
}
