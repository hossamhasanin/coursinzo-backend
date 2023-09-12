<?php

namespace Database\Seeders;

use App\Models\Course;
use Database\Seeders\traits\ToggleForeignKeyChecks;
use Database\Seeders\traits\TruncateTable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    use TruncateTable, ToggleForeignKeyChecks;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->disableForeignKeys();
        $this->truncate("courses");
        Course::factory(5)->create();
        $this->enableForeignKeys();
    }
}
