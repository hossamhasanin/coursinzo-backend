<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Message;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Laravel\Firebase\Facades\Firebase;

class NotificationController extends Controller
{
    public function index() : JsonResponse{
        $messaging = Firebase::messaging();
        $message = CloudMessage::withTarget("topic", "test")
            ->withNotification(
                Notification::create("test title", "test body")
            );
        $messaging->send($message);

        return new JsonResponse(
            [
                "message" => "sent successfully"
            ]
        );
    }
}
