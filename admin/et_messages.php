<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
}

$applicant_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sql = "SELECT message, is_admin FROM chat_messages WHERE applicant_id = ? ORDER BY created_at ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $applicant_id);
$stmt->execute();
$result = $stmt->get_result();
$messages = $result->fetch_all(MYSQLI_ASSOC);

header('Content-Type: application/json');
echo json_encode($messages);
?>
