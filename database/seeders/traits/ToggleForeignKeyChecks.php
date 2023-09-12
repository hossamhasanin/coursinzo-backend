<?php

namespace Database\Seeders\traits;

use Illuminate\Support\Facades\DB;

trait ToggleForeignKeyChecks {

    protected function disableForeignKeys(): void {
        DB::statement("SET FOREIGN_KEY_CHECKS = 0");
    }

    protected function enableForeignKeys(): void {
        DB::statement("SET FOREIGN_KEY_CHECKS = 1");
    }
}
