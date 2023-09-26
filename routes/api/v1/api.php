<?php


use App\Http\Controllers\LessonController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;

Route::get("/courses" , [CourseController::class , "index"]);

Route::get("/lessons/{course}", [LessonController::class , "index"]);

Route::post("/signup", [\App\Http\Controllers\UserController::class , "store"])
    ->withoutMiddleware("auth:sanctum");
Route::post("/login", [\App\Http\Controllers\UserController::class , "login"])
    ->withoutMiddleware("auth:sanctum");

Route::get("/get_daily_progress", [\App\Http\Controllers\UserController::class , "getDailyProgress"]);
Route::post("/store_daily_progress" , [\App\Http\Controllers\UserController::class , "storeDailyProgress"]);

Route::get("/get_courses_progress", [\App\Http\Controllers\UserController::class , "getLatestCoursesProgress"]);

Route::get("/test" , function (\Illuminate\Http\Request $request) {
   \Illuminate\Support\Facades\Broadcast::auth($request);
})->withoutMiddleware("auth:sanctum");

