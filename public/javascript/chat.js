const socketserver = 'ws://localhost:8080'; // when sftp to server, set to server's websocket IP
document.addEventListener('DOMContentLoaded', function () {
    const socket = new WebSocket(socketserver);
    let currentRoom = '';
    let currentRoomName = ''; // Track the room name
    const userInfo = document.getElementById('user-info');
    const username = userInfo.getAttribute('data-username');

    const storedRoomId = sessionStorage.getItem('currentRoom');
    const storedRoomName = sessionStorage.getItem('currentRoomName');

    if (storedRoomId && storedRoomName) {
        joinRoom(storedRoomId, storedRoomName); // Automatically rejoin
        document.getElementById('createRoomModal').style.display = 'none';
        document.getElementById('btn-to-createRoom').style.display = 'none';
        document.getElementById('roomList').style.display = 'none';
        document.getElementById('leaveRoomBtn').style.display = 'block';
    }

    socket.onopen = function () {
        console.log("Connected to WebSocket server");
    };

    socket.onmessage = function (event) {
        const data = JSON.parse(event.data);
        const messages = document.getElementById('messages');
        const messageElement = document.createElement('div');
        messageElement.classList.add('message');
        
        // Handle the user count update
        if (data.type === 'userCount') {
            const numOfUsers = data.numOfUsers;
            document.getElementById('numOfUsers').textContent = `Users: ${numOfUsers}`;
            return;
        }

        if (data.sender === username) {
            messageElement.classList.add('self-message');
        } 
        else if (data.sender === "System") {
            messageElement.classList.add('leave-message');
            const senderElement = document.createElement('div');
            messageElement.appendChild(senderElement);
        } 
        else {
            messageElement.classList.add('other-message');
            const senderElement = document.createElement('div');
            senderElement.classList.add('sender');
            senderElement.textContent = data.sender;
            messageElement.appendChild(senderElement);
        }
        
        const textElement = document.createElement('div');
        textElement.textContent = data.message;
        messageElement.appendChild(textElement);
        messages.appendChild(messageElement);
        messages.scrollTop = messages.scrollHeight;
        
    };
    
    socket.onerror = function (error) {
        console.log("WebSocket Error: " + error);
    };
    
    // Join Room Function (using roomId and roomName)
    function joinRoom(roomId, roomName) {
        currentRoom = roomId;  // Store the roomId for tracking
        currentRoomName = roomName; // Store the roomName to display it
        // Store room details in sessionStorage
        sessionStorage.setItem('currentRoom', roomId);  
        sessionStorage.setItem('currentRoomName', roomName);  

        sessionStorage.setItem('currentRoom', roomId);  // Store room ID
        sessionStorage.setItem('currentRoomName', roomName);  // Store room name

        document.getElementById('messages').innerHTML = '';
        document.getElementById('roomName').textContent = `Room: ${roomName}`;  // Display room name in UI
        document.getElementById('messagesContainer').style.display = 'flex';  // Show the messages container
        const joinData = {
            action: 'join',
            room: roomId,  // Send roomId to the WebSocket server
            roomName: roomName,
            sender: username
        };

        // Wait for WebSocket to be open before sending the message
        if (socket.readyState === WebSocket.OPEN) {
            socket.send(JSON.stringify(joinData));
            console.log("Joined room with ID " + roomId);
        } 
        else {
            // Listen for the `open` event before sending the message
            socket.addEventListener('open', function once() {
                socket.send(JSON.stringify(joinData));
                console.log("Joined room with ID " + roomId);
                socket.removeEventListener('open', once); // Remove listener after sending
            });
        }
        

        // socket.send(JSON.stringify(joinData));
        // console.log("Joined room with ID " + roomId);
    }

    function leaveRoom() {
        sessionStorage.removeItem('currentRoom');  
        sessionStorage.removeItem('currentRoomName');  
        socket.close();
        window.location.href = '/chatroom';
    }

    // Send message on button click or Enter key press
    function sendMessage() {
        const message = messageInput.value.trim();

        if (message) {
            // Create the message element
            const messageContainer = document.getElementById("messages");
            const newMessage = document.createElement("div");
            newMessage.classList.add("message", "self-message");
            newMessage.innerHTML = `
                
                <div class="message-content">${message}</div>
            `;
            messageContainer.appendChild(newMessage);

            // Scroll to the bottom
            messageContainer.scrollTop = messageContainer.scrollHeight;

            // Send the message to the server (this is where you would send it)
            const messageData = {
                room: currentRoom, // Ensure you pass the correct room identifier
                sender: username,
                message: message
            };

            // Example: You can send the message via WebSocket or any method you prefer
            socket.send(JSON.stringify(messageData));

            // Clear the input
            messageInput.value = "";
        }
    }

    function openLoginModal() {
        let loginModal = new bootstrap.Modal(document.getElementById("loginModal"));
        loginModal.show();
    }

    // Add click event listener for the send button
    sendMessageBtn.addEventListener("click", sendMessage);

    // Add keypress event listener for the Enter key (without Shift)
    messageInput.addEventListener("keypress", function(event) {
        if (event.key === "Enter" && !event.shiftKey) { // If Enter is pressed (and not Shift)
            event.preventDefault();  // Prevent new line
            sendMessage();
        }
    });

    // Handle the leave room button
    document.getElementById('leaveRoomBtn').addEventListener('click', leaveRoom);

    // Join Buttons Event Listeners (Joining by roomId)
    document.querySelectorAll('.join-btn').forEach(button => {
        button.addEventListener('click', function () {
            if (username == "") {
                openLoginModal();
                return;
            }
            const roomName = this.parentElement.querySelector('span').textContent.trim();  // Get room name
            const roomId = this.parentElement.querySelector('span').getAttribute('data-room-id'); // Get roomId
            joinRoom(roomId, roomName);  // Join room using both roomId and roomName
            document.getElementById('createRoomModal').style.display = 'none';
            document.getElementById('btn-to-createRoom').style.display = 'none';
            document.getElementById('roomList').style.display = 'none';  // Hide the room list when a room is joined
            document.getElementById('leaveRoomBtn').style.display = 'block'; // Show the Leave button
        });
    });

    document.getElementById('createChatroomForm').addEventListener('submit', function (event) {
        event.preventDefault();  // Prevent default form submission
    
        const chatroomName = document.getElementById('chatroom_name').value;
        // Send POST request to create chatroom
        fetch('/createChatroom', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ chatroom_name: chatroomName })
        })
        .then(response => response.json())  // Assuming the response contains roomId and roomName
        .then(data => {
            if (data.roomId) {
                // Once the room is created, join the room immediately
                joinRoom(data.roomId, chatroomName);  // Assuming joinRoom function is defined
                // Update UI
                document.getElementById('createRoomModal').style.display = 'none';  // Hide form
                document.getElementById('btn-to-createRoom').style.display = 'none';  // Hide button
                document.getElementById('roomList').style.display = 'none';  // Hide room list
                document.getElementById('leaveRoomBtn').style.display = 'block';  // Show Leave button
            } 
            else {
                alert("Failed to create room!");
            }
        })
        .catch(error => {
            console.error("Error creating room:", error);
            alert("Error creating room!");
        });
    });    
    
});
