<?php

namespace Database\Seeders;

use App\Models\Category;
use Database\Seeders\traits\ToggleForeignKeyChecks;
use Database\Seeders\traits\TruncateTable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    use ToggleForeignKeyChecks, TruncateTable;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->disableForeignKeys();
        $this->truncate("categories");
        Category::factory(5)->create();
        $this->enableForeignKeys();
    }
}
