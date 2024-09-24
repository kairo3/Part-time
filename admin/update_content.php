<?php
// เชื่อมต่อกับฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// รับค่าจากฟอร์ม
$id = $_POST['id'];
$shop_name = $_POST['shop_name'];
$job_details = $_POST['job_details'];
$job_position = $_POST['job_position'];
$job_type = $_POST['job_type'];
$num_people = $_POST['num_people'];
$benefits = $_POST['benefits'];
$application_method = $_POST['application_method'];
$contact = $_POST['contact'];
$work_location = $_POST['work_location'];
$qualifications = $_POST['qualifications'];
$maps = $_POST['maps'];

// อัปเดตข้อมูลในฐานข้อมูล
$query = "UPDATE job_listings1 SET shop_name = ?, job_details = ?, job_position = ?, job_type = ?, num_people = ?, benefits = ?, application_method = ?, contact = ?, work_location = ?, qualifications = ?, maps = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssssissssssi", $shop_name, $job_details, $job_position, $job_type, $num_people, $benefits, $application_method, $contact, $work_location, $qualifications, $maps, $id);

if ($stmt->execute()) {
    $_SESSION['message'] = "อัปเดตข้อมูลเรียบร้อยแล้ว!";
} else {
    $_SESSION['message'] = "เกิดข้อผิดพลาดในการอัปเดตข้อมูล!";
}

// ปิดการเชื่อมต่อฐานข้อมูล
$stmt->close();
$conn->close();

// เปลี่ยนเส้นทางกลับไปที่หน้า manage_content.php
header("Location: manage_content.php");
exit;
?>
