<?php
// ตั้งค่าการเชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
}

// รับ ID ของผู้ใช้จาก URL
if (isset($_GET['id'])) {
    $applicant_id = intval($_GET['id']);

    // ดึงข้อมูลผู้สมัครงานจากฐานข้อมูล
    $sql = "SELECT * FROM job_applications WHERE id = $applicant_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $applicant = $result->fetch_assoc();
    } else {
        echo "ไม่พบข้อมูลผู้สมัคร";
        exit();
    }

    // ดึงข้อความแชทจากฐานข้อมูล
    $sql_chat = "SELECT * FROM chat_messages WHERE applicant_id = $applicant_id ORDER BY timestamp ASC";
    $chat_result = $conn->query($sql_chat);

    $chat_messages = [];
    if ($chat_result->num_rows > 0) {
        while ($row = $chat_result->fetch_assoc()) {
            $chat_messages[] = $row;
        }
    }
} else {
    echo "ไม่มี ID ผู้ใช้";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ห้องแชท</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #18191A;
            color: #E4E6EB;
            margin: 0;
            padding: 0;
        }

        .chat-container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            background-color: #242526;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .chat-header {
            display: flex;
            align-items: center;
            padding-bottom: 10px;
            border-bottom: 1px solid #3A3B3C;
        }

        .chat-header h2 {
            font-size: 18px;
            color: #E4E6EB;
        }

        .chat-box {
            height: 400px;
            overflow-y: auto;
            margin-top: 15px;
            background-color: #242526;
            padding: 15px;
            border: 1px solid #3A3B3C;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
        }

        .message {
            margin-bottom: 10px;
            max-width: 60%;
        }

        .message.incoming {
            align-self: flex-start;
            background-color: #3A3B3C;
            color: #E4E6EB;
            border-radius: 18px 18px 18px 0;
        }

        .message.outgoing {
            align-self: flex-end;
            background-color: #0084FF;
            color: #fff;
            border-radius: 18px 18px 0 18px;
        }

        .message p {
            padding: 10px;
            margin: 0;
            word-wrap: break-word;
        }

        .timestamp {
            font-size: 12px;
            color: #B0B3B8;
            text-align: right;
        }

        .chat-input-container {
            display: flex;
            margin-top: 10px;
            border-top: 1px solid #3A3B3C;
            padding-top: 10px;
        }

        .chat-input {
            flex: 1;
            padding: 10px;
            border: none;
            border-radius: 20px;
            background-color: #3A3B3C;
            color: #E4E6EB;
        }

        .send-btn {
            background-color: #0084FF;
            border: none;
            padding: 10px 15px;
            border-radius: 50%;
            color: #fff;
            margin-left: 10px;
            cursor: pointer;
        }

        .send-btn:hover {
            background-color: #0057CC;
        }
    </style>
</head>

<body>

    <div class="chat-container">
        <div class="chat-header">
            <h2>เริ่มแชทกับ <?= htmlspecialchars($applicant['name']); ?></h2>
        </div>

        <div class="chat-box" id="chat-box">
            <!-- ดึงข้อความแชทจากฐานข้อมูล -->
            <?php foreach ($chat_messages as $message) : ?>
                <div class="message <?= $message['sender'] == 'admin' ? 'outgoing' : 'incoming'; ?>">
                    <p><?= htmlspecialchars($message['message']); ?></p>
                    <div class="timestamp"><?= date('H:i', strtotime($message['timestamp'])); ?></div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="chat-input-container">
            <input type="text" id="chat-input" class="chat-input" placeholder="พิมพ์ข้อความ...">
            <button class="send-btn" id="send-btn">ส่ง</button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#send-btn').click(function () {
                var message = $('#chat-input').val();
                var applicant_id = <?= $applicant_id; ?>;
                if (message.trim() !== '') {
                    // ส่งข้อความไปยังเซิร์ฟเวอร์
                    $.post('send_message.php', { message: message, applicant_id: applicant_id }, function (response) {
                        // แสดงข้อความในกล่องแชท
                        $('#chat-box').append('<div class="message outgoing"><p>' + message + '</p><div class="timestamp">' + new Date().toLocaleTimeString() + '</div></div>');
                        $('#chat-input').val('');
                        // เลื่อนแชทลงไปที่ข้อความล่าสุด
                        $('#chat-box').scrollTop($('#chat-box')[0].scrollHeight);
                    });
                }
            });
        });
    </script>
</body>

</html>
