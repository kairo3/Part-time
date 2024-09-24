<?php
$servername = "localhost";
$username = "root"; // หรือชื่อผู้ใช้ที่คุณใช้
$password = ""; // หรือรหัสผ่านที่คุณใช้
$dbname = "as";

// สร้างการเชื่อมต่อฐานข้อมูล
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// การจัดการการส่งข้อความ
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['message'])) {
    $message = $conn->real_escape_string($_POST['message']);
    $sql = "INSERT INTO messages (message) VALUES ('$message')";
    $conn->query($sql);
}

// การดึงข้อความจากฐานข้อมูล
if (isset($_GET['fetch'])) {
    $sql = "SELECT * FROM messages ORDER BY created_at DESC";
    $result = $conn->query($sql);

    $messages = [];
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }
    
    echo json_encode($messages);
    $conn->close();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Room</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }

        .chat-container {
            width: 300px;
            margin: auto;
            padding: 10px;
            border: 1px solid #ddd;
            background-color: #fff;
        }

        #messages {
            list-style-type: none;
            padding: 0;
            margin: 0;
            height: 300px;
            overflow-y: scroll;
            border-bottom: 1px solid #ddd;
        }

        #messages li {
            padding: 5px;
            border-bottom: 1px solid #eee;
        }

        #chat-form {
            display: flex;
            margin-top: 10px;
        }

        #message {
            flex: 1;
            padding: 5px;
        }

        button {
            padding: 5px 10px;
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <ul id="messages"></ul>
        <form id="chat-form" action="index.php" method="post">
            <input id="message" name="message" autocomplete="off" placeholder="Type a message..." required />
            <button type="submit">Send</button>
        </form>
    </div>

    <script>
        function fetchMessages() {
            fetch('index.php?fetch=1')
                .then(response => response.json())
                .then(data => {
                    const messages = document.getElementById('messages');
                    messages.innerHTML = '';
                    data.forEach(msg => {
                        const li = document.createElement('li');
                        li.textContent = `${msg.created_at}: ${msg.message}`;
                        messages.appendChild(li);
                    });
                });
        }

        setInterval(fetchMessages, 2000);
    </script>
</body>
</html>
