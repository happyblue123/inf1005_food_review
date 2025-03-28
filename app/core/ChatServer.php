<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . "/../models/Chatroom.php";

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

class Chat implements MessageComponentInterface {
    protected $clients;  // All connected clients with their usernames
    protected $rooms;    // Rooms and their respective clients

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->rooms = [];
    }

    public function onOpen(ConnectionInterface $conn) {
        // Debugging message to check the onOpen function
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onClose(ConnectionInterface $conn) {
        // Handle user leaving a room
        foreach ($this->rooms as $room => $clients) {
            if (isset($clients[$conn->resourceId])) {
                $username = $this->clients->offsetGet($conn)['username'];
                unset($this->rooms[$room][$conn->resourceId]);
                echo "Connection {$conn->resourceId} has left room: $room\n";

                // Broadcast the leave message
                $this->broadcastToRoom($conn, $room, "{$username} has left the chat.", "System");

                // Broadcast the updated user count to the room
                $this->broadcastUserCountToRoom($room);

                // Check if the room is empty and delete from db
                if (empty($this->rooms[$room])) {
                    $chatroomModel = new Chatroom();
                    $chatroomModel->deleteRoomById($room);
                    echo "$room deleted from db\n";
                }
                break;
            }
        }

        $this->clients->detach($conn);
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $messageData = json_decode($msg, true);

        if (isset($messageData['action']) && $messageData['action'] === 'join') {
            // Store the username when joining and join the room
            $this->clients->offsetSet($from, ['username' => $messageData['sender']]);

            $this->joinRoom($from, $messageData['sender'], $messageData['room'], $messageData['roomName']);

            // Broadcast the join message
            $this->broadcastToRoom($from, $messageData['room'], "{$messageData['sender']} has joined the chat.", "System");

            // Broadcast the updated user count to the room
            $this->broadcastUserCountToRoom($messageData['room']);

            return;
        }

        if (isset($messageData['room']) && isset($messageData['message'])) {
            // Broadcast regular chat message
            $this->broadcastToRoom($from, $messageData['room'], $messageData['message'], $messageData['sender']);
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error occurred: {$e->getMessage()}\n";
        $conn->close();
    }

    private function joinRoom(ConnectionInterface $conn, $username, $room, $roomName) {
        if (!isset($this->rooms[$room])) {
            $this->rooms[$room] = [];
        }

        // Remove user from any previous room they might have been in
        foreach ($this->rooms as $r => $clients) {
            if (isset($clients[$conn->resourceId])) {
                unset($this->rooms[$r][$conn->resourceId]);
                break;
            }
        }

        // Add user to the new room
        $this->rooms[$room][$conn->resourceId] = $conn;
        echo "User[$username, $conn->resourceId] joined room[$room, $roomName]\n";
    }

    private function broadcastToRoom(ConnectionInterface $from, $room, $message, $sender) {
        if (!isset($this->rooms[$room])) {
            return;
        }

        foreach ($this->rooms[$room] as $client) {
            if ($from !== $client) {
                // Use 'sender' instead of 'user' to match client-side expectation
                $client->send(json_encode([
                    'sender' => $sender,
                    'message' => $message
                ]));
            }
        }
    }

    private function broadcastUserCountToRoom($room) {
        if (!isset($this->rooms[$room])) {
            return;
        }

        // Count the number of users in the room
        $userCount = count($this->rooms[$room]);

        // Broadcast the user count to all clients in the room
        foreach ($this->rooms[$room] as $client) {
            $client->send(json_encode([
                'type' => 'userCount',
                'numOfUsers' => $userCount
            ]));
        }
    }
}

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Chat()
        )
    ),
    8080,
    '0.0.0.0'
);

echo "Chat server started\n";
$server->run();
