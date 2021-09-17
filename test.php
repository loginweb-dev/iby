<?php

    require __DIR__ . '/vendor/autoload.php';

    $loop = \React\EventLoop\Factory::create();
    $reactConnector = new \React\Socket\Connector($loop, [
        'dns' => '8.8.8.8',
        'timeout' => 10
    ]);
    $connector = new \Ratchet\Client\Connector($loop, $reactConnector);

    $connector('ws://127.0.0.1:9000', ['protocol1', 'subprotocol2'], ['Origin' => 'http://localhost:8888'])
    ->then(function(\Ratchet\Client\WebSocket $conn) {
        $conn->on('message', function(\Ratchet\RFC6455\Messaging\MessageInterface $msg) use ($conn) {
            echo "Received: {$msg}\n";
            $conn->close();
        });

        $conn->on('close', function($code = null, $reason = null) {
            echo "Connection closed ({$code} - {$reason})\n";
        });

        $conn->send('Hello World!');
    }, function(\Exception $e) use ($loop) {
        echo "Could not connect: {$e->getMessage()}\n";
        $loop->stop();
    });

    $loop->run();
