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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message = $conn->real_escape_string($_POST['message']);
    $applicant_id = intval($_POST['applicant_id']);
    $sender = 'admin'; // สามารถปรับเป็นผู้ส่งจริงตามระบบที่คุณต้องการ

    $sql = "INSERT INTO chat_messages (applicant_id, sender, message) VALUES ($applicant_id, '$sender', '$message')";
    if ($conn->query($sql) === TRUE) {
        echo "ส่งข้อความสำเร็จ";
    } else {
        echo "เกิดข้อผิดพลาด: " . $conn->error;
    }
}

$conn->close();
?>
