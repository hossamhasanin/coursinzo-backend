<?php

namespace App\Exceptions;

use BeyondCode\LaravelWebSockets\WebSockets\Exceptions\WebSocketException;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WebSocketWrongAccessToken extends WebSocketException
{
    public function __construct()
    {
        $this->message = "Wrong access token.";

        $this->code = 4001;
    }
}
