<?php
// การตั้งค่าการเชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
}

// รับ ID ของผู้สมัครจาก URL
$applicant_id = isset($_GET['id']) ? intval($_GET['id']) : null;

if ($applicant_id !== null) {
    // ดึงข้อมูลผู้สมัครงานจากฐานข้อมูล
    $sql = "SELECT * FROM job_applications WHERE id = $applicant_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $applicant = $result->fetch_assoc();
    } else {
        echo "ไม่พบข้อมูลผู้สมัคร";
        exit();
    }

    // ดึงข้อมูลงานที่ผู้สมัครได้สมัครเข้ามา
    $job_sql = "SELECT * FROM job_listings1 WHERE id = (SELECT job_id FROM job_applications WHERE id = $applicant_id)";
    $job_result = $conn->query($job_sql);

    if ($job_result->num_rows > 0) {
        $job = $job_result->fetch_assoc();
    } else {
        echo "ไม่พบข้อมูลงาน";
        exit();
    }

    // ดึงข้อความแชทจากฐานข้อมูล
    $sql_chat = "SELECT * FROM chat_messages WHERE applicant_id = $applicant_id ORDER BY timestamp ASC";
    $chat_result = $conn->query($sql_chat);

    if ($chat_result === false) {
        die("เกิดข้อผิดพลาดในการดึงข้อมูลแชท: " . $conn->error);
    }

    $chat_messages = [];
    if ($chat_result->num_rows > 0) {
        while ($row = $chat_result->fetch_assoc()) {
            $chat_messages[] = $row;
        }
    }
} else {
    echo "ไม่มี ID ผู้สมัคร";
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
        <h2>แชทกับ <?= isset($applicant['name']) ? htmlspecialchars($applicant['name']) : 'ไม่ทราบชื่อ' ?> - งาน: <?= isset($job['shop_name']) ? htmlspecialchars($job['shop_name']) : 'ไม่ทราบงาน' ?></h2>
    </div>
    <div class="chat-box">
    <?php if (!empty($chat_messages)): ?>
        <?php foreach ($chat_messages as $message): ?>
            <div class="message <?= $message['sender'] == 'admin' ? 'outgoing' : 'incoming' ?>">
                <p><?= htmlspecialchars($message['message']); ?></p>
                <div class="timestamp"><?= $message['timestamp']; ?></div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>ไม่มีข้อความแชท</p>
    <?php endif; ?>
</div>

    <div class="chat-input-container">
        <input type="text" id="chat-input" class="chat-input" placeholder="พิมพ์ข้อความ...">
        <button id="send-btn" class="send-btn">ส่ง</button>
    </div>
</div>

<script>
    document.getElementById('send-btn').addEventListener('click', function() {
        var message = document.getElementById('chat-input').value;
        var applicant_id = <?= json_encode($applicant_id) ?>;

        if (message.trim() !== '') {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'send_message.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    console.log('ข้อความที่ส่ง:', message);
                    document.getElementById('chat-input').value = '';
                    loadChatMessages();  // รีเฟรชการแสดงข้อความ
                } else {
                    console.error('ข้อผิดพลาดในการส่งข้อความ:', xhr.responseText);
                }
            };
            xhr.onerror = function() {
                console.error('ข้อผิดพลาดในการส่งคำสั่ง');
            };
            xhr.send('applicant_id=' + encodeURIComponent(applicant_id) + '&message=' + encodeURIComponent(message));
        }
    });

    function loadChatMessages() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'chat_room.php?id=' + <?= json_encode($applicant_id) ?>, true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                document.body.innerHTML = xhr.responseText;
            } else {
                console.error('ข้อผิดพลาดในการโหลดข้อความ:', xhr.responseText);
            }
        };
        xhr.onerror = function() {
            console.error('ข้อผิดพลาดในการโหลดข้อความ');
        };
        xhr.send();
    }
</script>

</body>
</html>