<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResource
    {

//        dd(Course::query()->select('courses.*')
//            ->leftJoin('lessons', 'courses.id', '=', 'lessons.course_id')
//            ->selectRaw('SUM(lessons.duration) as total_duration')
//            ->groupBy('courses.id', 'courses.name', 'courses.description',
//                'courses.thumbnail', 'courses.user_id', 'courses.created_at', 'courses.updated_at', 'courses.price')
//            ->havingRaw('total_duration >= ? AND total_duration <= ?', [0, 90])
//            ->get()
//        );
        return new JsonResource(
            Course::query()->select('courses.*')
                ->leftJoin('lessons', 'courses.id', '=', 'lessons.course_id')
                ->selectRaw('COALESCE(SUM(lessons.duration), 0) as total_duration')
                ->groupBy('courses.id', 'courses.name', 'courses.description',
                    'courses.thumbnail', 'courses.user_id', 'courses.created_at',
                    'courses.updated_at', 'courses.price')
                ->havingRaw('total_duration >= ? AND total_duration <= ?', [0, 90])
                ->paginate()
        );
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        //
    }
}
