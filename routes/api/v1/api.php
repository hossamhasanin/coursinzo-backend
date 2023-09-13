<?php


use App\Http\Controllers\LessonController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;

Route::get("/courses" , [CourseController::class , "index"]);

Route::get("/lessons/{course}", [LessonController::class , "index"]);

Route::post("/signup", [\App\Http\Controllers\UserController::class , "store"])
    ->withoutMiddleware("auth:sanctum");
