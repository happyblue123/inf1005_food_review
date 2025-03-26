<?php
require_once __DIR__ . "/../core/Database.php";

class Chatroom {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function createChatroom($userid, $chatroomName) {
        $stmt = $this->db->conn->prepare("INSERT INTO chatrooms (chatroom_name, userid) VALUES (?, ?)");
        $stmt->execute([$chatroomName, $userid]);
        $result = $stmt->rowCount() > 0;
        $chatroomid = $this->db->conn->lastInsertId();
        return [$result, $chatroomid, $chatroomName];  
    }

    public function fetchChatrooms() {
        $stmt = $this->db->conn->prepare("SELECT * FROM chatrooms");
        $stmt->execute();
        $chatrooms = $stmt->fetchAll();
        return $chatrooms;
    }

    public function deleteRoomById($roomId) {
        $stmt = $this->db->conn->prepare("DELETE FROM chatrooms where chatroomid = ?");
        $stmt->execute([$roomId]);
    }

}
?>
