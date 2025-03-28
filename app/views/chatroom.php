<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$login = isset($_SESSION['userid']);

$username = $_SESSION['username'] ?? "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php include "inc/head.inc.php"; ?>
<link rel="stylesheet" href="/public/css/chatroom.css">
<script src="/public/javascript/createRoomModal.js"></script>
<script src="/public/javascript/chat.js"></script>
<title>Chatrooms</title>
</head>
<body>
    <?php
    include "inc/header.inc.php";
    ?>
    
    <main class="container">
        <!-- Store PHP value in a data attribute -->
        <div id="user-info" data-username="<?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?>"></div>

        <div id ="btn-to-createRoom">
            <!-- Button to show the modal -->
            <button class="btn btn-primary" id="showCreateRoomModal">Add Chatroom</button>
        </div>
        <!-- Modal to create a new chatroom -->
        <div id="createRoomModal" style="display: none;">
            <div class="modal-content">
                <span class="close-btn" id="closeModal">&times;</span> <!-- Close button -->
                <!-- <form action="/createChatroom" method="POST"> -->
                <form id="createChatroomForm">
                    <input type="text" id="chatroom_name" name="chatroom_name" placeholder="Enter chatroom name" required>
                    <button type="submit">Create Chatroom</button>
                </form>
            </div>
        </div>

        <div id="roomList">
            <?php foreach ($chatrooms as $chatroom) : ?>
                <div class="room-item">
                    <span data-room-id=<?php echo htmlspecialchars($chatroom['chatroomid']); ?>><?php echo htmlspecialchars($chatroom['chatroom_name']); ?></span>
                    <button class="join-btn">Join</button>
                </div>
            <?php endforeach; ?>
        </div>

        <div id="messagesContainer" style="display: none;">
            <div id="roomName"></div>
            <div id="messages"></div>
            <div class="message-input-container">
                <textarea id="messageInput" placeholder="Type a message..." rows="3"></textarea>
                <button id="sendMessageBtn" class="send-btn">
                    <i class="fas fa-arrow-right"></i>
                </button>
            </div>
            <button id="leaveRoomBtn" style="display: none;">Leave Room</button>
        </div>
    </main>



    <?php include "inc/footer.inc.php"; ?>
</body>
</html>
