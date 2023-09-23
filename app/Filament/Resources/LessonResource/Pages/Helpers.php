<?php

namespace App\Filament\Resources\LessonResource\Pages;

use App\Models\Course;
use App\Models\Lesson;
use FFMpeg\FFProbe;
use Illuminate\Database\Eloquent\Model;

class Helpers
{
    public static function addLessonDurationToCourseDuration(array $data) : array {
        $ffprobe = FFProbe::create();

        $uploadedVideosDuration = 0;
        foreach ($data["video"] as &$video) {
            $duration = $ffprobe->format(storage_path("app/public/{$video["video_file"]}"))->get('duration');
            $video["duration"] = $duration;
            $uploadedVideosDuration += $duration;
        }

        // increase the course total duration
        $course = Course::query()->find($data["course_id"]);
        $course->duration = $course->duration + $uploadedVideosDuration;
        $course->save();

        return $data;
    }

    public static function subtractDeletedLessonDurationFromCourseDuration(Lesson|Model $lesson): void
    {
        $course = Course::query()->find($lesson->course_id);
        foreach ($lesson->video as $item){
            $course->duration -= $item["duration"];
        }
        $course->save();
    }
}
