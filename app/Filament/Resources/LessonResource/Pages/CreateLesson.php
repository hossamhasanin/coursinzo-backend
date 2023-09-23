<?php

namespace App\Filament\Resources\LessonResource\Pages;

use App\Filament\Resources\LessonResource;
use App\Models\Course;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use FFMpeg\FFProbe;

class CreateLesson extends CreateRecord
{
    protected static string $resource = LessonResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return Helpers::addLessonDurationToCourseDuration($data);
    }

}
