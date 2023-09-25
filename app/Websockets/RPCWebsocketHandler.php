<?php

namespace App\Websockets;

use App\Exceptions\WebSocketWrongAccessToken;
use BeyondCode\LaravelWebSockets\Apps\App;
use BeyondCode\LaravelWebSockets\QueryParameters;
use BeyondCode\LaravelWebSockets\WebSockets\Exceptions\UnknownAppKey;
use BeyondCode\LaravelWebSockets\WebSockets\Exceptions\WebSocketException;
use Ratchet\ConnectionInterface;
use Ratchet\RFC6455\Messaging\MessageInterface;
use Ratchet\WebSocket\MessageComponentInterface;

class RPCWebsocketHandler implements MessageComponentInterface
{

    function onOpen(ConnectionInterface $conn)
    {
        $this->verifyAppKey($conn)
            ->generateSocketId($conn)
            ->verifyUserAccessToken($conn);
    }

    /**
     * @throws WebSocketWrongAccessToken
     */
    protected function verifyUserAccessToken(ConnectionInterface $connection)
    {
        $accessToken = QueryParameters::create($connection->httpRequest)->get("auth");

        $personalToken = \Laravel\Sanctum\PersonalAccessToken::findToken($accessToken);
        if ($personalToken == null){
            throw new WebSocketWrongAccessToken();
        }

        return $this;
    }

    protected function generateSocketId(ConnectionInterface $connection)
    {
        $socketId = sprintf('%d.%d', random_int(1, 1000000000), random_int(1, 1000000000));

        $connection->socketId = $socketId;

        return $this;
    }

    /**
     * @throws UnknownAppKey
     */
    protected function verifyAppKey(ConnectionInterface $connection)
    {
        $appKey = QueryParameters::create($connection->httpRequest)->get('appKey');

        if (! $app = App::findByKey($appKey)) {
            throw new UnknownAppKey($appKey);
        }

        $connection->app = $app;

        return $this;
    }

    function onClose(ConnectionInterface $conn)
    {
        // TODO: Implement onClose() method.
    }

    function onError(ConnectionInterface $conn, \Exception $e)
    {
        // TODO: Implement onError() method.
        if ($e instanceof WebSocketException) {
            $conn->send(json_encode($e->getPayload()));
        }
    }

    public function onMessage(ConnectionInterface $conn, MessageInterface $msg)
    {
        dump($msg->getPayload());
    }
}
