<?php


use \Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;

Route::get("/courses" , [CourseController::class , "index"]);

Route::get("/lessons/{course}", [\App\Http\Controllers\LessonController::class , "index"]);
