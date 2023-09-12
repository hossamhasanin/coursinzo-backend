<?php

namespace Database\Factories\helpers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
class FactoryHelpers
{

    /**
     * @param HasFactory | string $table
     * @return int
     */
    public static function getRandomTableId(string $table): int {
        $count = $table::query()->count();

        if ($count === 0) {
            return $table::factory()->create()->id;
        } else {
            return rand(1 , $count);
        }
    }

}
