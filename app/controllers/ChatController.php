<?php

require_once __DIR__ . "/../models/Chatroom.php";

class ChatController {

    public function displayChatrooms() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // if (!isset($_SESSION['userid'])) {
        //     header('Location: /home');
        //     exit;
        // }

        $chatModel = new Chatroom();
        $chatrooms = $chatModel->fetchChatrooms();

        require_once __DIR__ . '/../views/chatroom.php';
    }

    public function createChatroom() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Ensure the session is started
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
    
            // Prepare necessary variables
            $chatModel = new Chatroom();
            $userid = $_SESSION['userid'];
            $data = json_decode(file_get_contents("php://input"), true);
            // $chatroomName = $data['chatroom_name'];
            $chatroomName = htmlspecialchars($data['chatroom_name'], ENT_QUOTES, 'UTF-8');
    
            // Create the chatroom and get the result
            $result = $chatModel->createChatroom($userid, $chatroomName);
            $success = $result[0];
            $roomId = $result[1];
            $roomName = $result[2];
    
            // Check if the room was successfully created
            if ($success) {
                // Return the roomId and roomName in JSON format
                echo json_encode([
                    'roomId' => $roomId,
                    'roomName' => $roomName
                ]);
            } 
            else {
                // If creation failed, send an error message
                echo json_encode(['error' => 'Failed to create room']);
            }
    
            // Ensure further script execution is stopped after sending the response
            exit;
        }
    }    

}

?>

