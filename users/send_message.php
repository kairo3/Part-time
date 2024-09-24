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

// รับข้อมูลจาก POST
$applicant_id = isset($_POST['applicant_id']) ? intval($_POST['applicant_id']) : null;
$message = isset($_POST['message']) ? $_POST['message'] : '';

if ($applicant_id !== null && !empty($message)) {
    // ตรวจสอบว่าผู้สมัครมีอยู่ในฐานข้อมูล
    $sql_check = "SELECT 1 FROM job_applications WHERE id = $applicant_id";
    $check_result = $conn->query($sql_check);

    if ($check_result->num_rows > 0) {
        // บันทึกข้อความลงฐานข้อมูล
        $stmt = $conn->prepare("INSERT INTO chat_messages (applicant_id, message, sender) VALUES (?, ?, 'admin')");
        $stmt->bind_param("is", $applicant_id, $message);

        if ($stmt->execute()) {
            echo "ข้อความส่งเรียบร้อย";
        } else {
            echo "เกิดข้อผิดพลาด: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "ID ผู้สมัครไม่ถูกต้อง";
    }
} else {
    echo "ข้อมูลไม่ครบถ้วน";
}

$conn->close();
?>
