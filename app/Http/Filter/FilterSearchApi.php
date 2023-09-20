<?php

namespace App\Http\Filter;

use Illuminate\Http\Request;

abstract class FilterSearchApi
{
    protected array $allowedColumnOperations = [];

    protected array $supportedOperations = [
        "eq" => "=",
        "se" => "like",
        "ne" => "!=",
        "gt" => ">",
        "lt" => "<",
        "gte" => ">=",
        "lte" => "<="
    ];

    public function transform(Request $request) : array {
        $filterArr = [];

        foreach ($this->allowedColumnOperations as $param => $operations) {
            $query = $request->query($param);

            if (!isset($query)) {
                continue;
            }

            foreach ($operations as $operation) {
                if (isset($query[$operation])){
                    $filterArr[] = [$param , $this->supportedOperations[$operation], $operation == "se" ? "%${$query[$operation]}%" : $query[$operation]];
                }
            }
        }

        return  $filterArr;
    }
}
