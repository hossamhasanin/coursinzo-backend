<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lesson;
use Database\Seeders\traits\ToggleForeignKeyChecks;
use Database\Seeders\traits\TruncateTable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LessonSeeder extends Seeder
{
    use ToggleForeignKeyChecks, TruncateTable;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->disableForeignKeys();
        $this->truncate("lessons");
        Lesson::factory(3)->create();
        $this->enableForeignKeys();
    }
}
