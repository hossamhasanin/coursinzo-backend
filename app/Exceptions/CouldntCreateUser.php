<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CouldntCreateUser extends Exception
{
    protected $code = 422;
    public function render(Request $request): JsonResponse {
        return new JsonResponse([
            "code" => $this->getCode(),
            "error" => $this->getMessage()
        ], $this->getCode());
    }
}
