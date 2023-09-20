<?php

namespace App\Http\Filter\v1;

use App\Http\Filter\FilterSearchApi;

class CoursesSearchFilter extends FilterSearchApi
{
    protected array $allowedColumnOperations = [
        "name" => ["se"],
        "price" => ["gt" , "lt" , "gte" , "lte"]
    ];
}
