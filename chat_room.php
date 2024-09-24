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
$applicant_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// ดึงข้อมูลผู้สมัครตาม ID
$sql = "SELECT ja.id, ja.name, ja.email, ja.phone, ja.address, ja.education, ja.experience, ja.skills, ja.cover_letter, ja.application_date, 
        jl.shop_name, jl.job_position 
        FROM job_applications ja
        JOIN job_listings1 jl ON ja.job_id = jl.id
        WHERE ja.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $applicant_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "ไม่พบผู้สมัคร.";
    exit;
}

?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เริ่มแชทกับ <?= htmlspecialchars($row['name']); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        .header {
            background-color: #0e4f6f;
            color: #ffffff;
            text-align: center;
            padding: 20px;
            font-size: 24px;
        }
        .chat-box {
            padding: 20px;
        }
        .message {
            margin-bottom: 15px;
        }
        .message .sender {
            font-weight: bold;
            color: #0e4f6f;
        }
        .message .content {
            margin-top: 5px;
        }
        .message-form {
            margin-top: 20px;
            padding: 10px;
            border-top: 1px solid #ddd;
            background-color: #fafafa;
        }
        .message-form textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .message-form button {
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #3a8591;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .message-form button:hover {
            background-color: #297d94;
        }
        .footer {
            background-color: #f1f1f1;
            text-align: center;
            padding: 10px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">เริ่มแชทกับ <?= htmlspecialchars($row['name']); ?></div>

        <div class="chat-box">
            <!-- Messages will be loaded here -->
            <div class="message">
                <div class="sender">John Doe:</div>
                <div class="content">Hello, how are you?</div>
            </div>
            <div class="message">
                <div class="sender"><?= htmlspecialchars($row['name']); ?>:</div>
                <div class="content">I'm fine, thank you!</div>
            </div>
        </div>

        <div class="message-form">
            <form action="send_message.php" method="post">
                <textarea name="message" rows="4" placeholder="พิมพ์ข้อความของคุณที่นี่..." required></textarea>
                <input type="hidden" name="applicant_id" value="<?= htmlspecialchars($row['id']); ?>">
                <button type="submit">ส่งข้อความ</button>
            </form>
        </div>

        <div class="footer">
            &copy; 2024 การัน โฮม เอเยนซี่ จำกัด. สงวนลิขสิทธิ์.
        </div>
    </div>

    <?php $conn->close(); ?>
</body>
</html>
