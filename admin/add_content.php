<?php
// เริ่มการเชื่อมต่อกับฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test_db";

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตรวจสอบการส่งข้อมูล
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับค่าจากฟอร์ม
    $shop_name = $_POST['shop_name'] ?? '';
    $job_details = $_POST['job_details'] ?? '';
    $job_position = $_POST['job_position'] ?? '';
    $job_type = $_POST['job_type'] ?? '';
    $num_people = $_POST['num_people'] ?? 0;
    $benefits = $_POST['benefits'] ?? '';
    $application_method = $_POST['application_method'] ?? '';
    $contact = $_POST['contact'] ?? '';
    $work_location = $_POST['work_location'] ?? '';
    $maps = $_POST['maps'] ?? '';
    $qualifications = $_POST['qualifications'] ?? '';

    // ตรวจสอบว่าข้อมูลถูกส่งมาครบถ้วน
    if (empty($shop_name) || empty($job_details) || empty($job_position) || empty($job_type) || empty($contact) || empty($work_location)) {
        echo "กรุณากรอกข้อมูลให้ครบถ้วน!";
    } else {
        // SQL สำหรับการเพิ่มข้อมูล
        $sql = "INSERT INTO job_listings1 (shop_name, job_details, job_position, job_type, num_people, benefits, application_method, contact, work_location, maps, qualifications)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        // เตรียมคำสั่ง SQL
        $stmt = $conn->prepare($sql);
        
        // ตรวจสอบข้อผิดพลาดในการเตรียมคำสั่ง SQL
        if (!$stmt) {
            die("Error preparing statement: " . $conn->error);
        }
        
        // ผูกพารามิเตอร์
        $stmt->bind_param("ssssissssss", $shop_name, $job_details, $job_position, $job_type, $num_people, $benefits, $application_method, $contact, $work_location, $maps, $qualifications);
        
        // ดำเนินการคำสั่ง SQL และตรวจสอบความสำเร็จ
        if ($stmt->execute()) {
            echo "เพิ่มข้อมูลสำเร็จ!";
        } else {
            echo "เกิดข้อผิดพลาด: " . $stmt->error;
        }
        
        // ปิดคำสั่ง
        $stmt->close();
    }
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Content</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>เพิ่มข้อมูลทางร้าน</h2>
    <form action="" method="post">
        <input type="hidden" name="id" value="<?= isset($row['id']) ? htmlspecialchars($row['id']) : ''; ?>">
        <div class="mb-3">
            <label for="shop_name" class="form-label">ชื่อร้าน</label>
            <input type="text" class="form-control" id="shop_name" name="shop_name" value="<?= isset($row['shop_name']) ? htmlspecialchars($row['shop_name']) : ''; ?>" required>
        </div>
        <div class="mb-3">
            <label for="job_details" class="form-label">รายละเอียดงาน</label>
            <textarea class="form-control" id="job_details" name="job_details" rows="4" required><?= isset($row['job_details']) ? htmlspecialchars($row['job_details']) : ''; ?></textarea>
        </div>
        <div class="mb-3">
            <label for="job_position" class="form-label">ตำแหน่งงาน</label>
            <input type="text" class="form-control" id="job_position" name="job_position" value="<?= isset($row['job_position']) ? htmlspecialchars($row['job_position']) : ''; ?>" required>
        </div>
        <div class="mb-3">
            <label for="job_type" class="form-label">ลักษณะงาน</label>
            <input type="text" class="form-control" id="job_type" name="job_type" value="<?= isset($row['job_type']) ? htmlspecialchars($row['job_type']) : ''; ?>" required>
        </div>
        <div class="mb-3">
            <label for="num_people" class="form-label">จำนวนที่รับ</label>
            <input type="number" class="form-control" id="num_people" name="num_people" value="<?= isset($row['num_people']) ? htmlspecialchars($row['num_people']) : ''; ?>" required>
        </div>
        <div class="mb-3">
            <label for="qualifications" class="form-label">คุณสมบัติ</label>
            <textarea class="form-control" id="qualifications" name="qualifications" rows="3"><?= isset($row['qualifications']) ? htmlspecialchars($row['qualifications']) : ''; ?></textarea>
        </div>
        <div class="mb-3">
            <label for="benefits" class="form-label">สวัสดิการ</label>
            <textarea class="form-control" id="benefits" name="benefits" rows="4" required><?= isset($row['benefits']) ? htmlspecialchars($row['benefits']) : ''; ?></textarea>
        </div>
        <div class="mb-3">
            <label for="application_method" class="form-label">วิธีการสมัคร</label>
            <textarea class="form-control" id="application_method" name="application_method" rows="4" required><?= isset($row['application_method']) ? htmlspecialchars($row['application_method']) : ''; ?></textarea>
        </div>
        <div class="mb-3">
            <label for="contact" class="form-label">ติดต่อ</label>
            <input type="text" class="form-control" id="contact" name="contact" value="<?= isset($row['contact']) ? htmlspecialchars($row['contact']) : ''; ?>" required>
        </div>
        <div class="mb-3">
            <label for="work_location" class="form-label">สถานที่ปฏิบัติงาน</label>
            <input type="text" class="form-control" id="work_location" name="work_location" value="<?= isset($row['work_location']) ? htmlspecialchars($row['work_location']) : ''; ?>" required>
        </div>
        <div class="mb-3">
            <label for="maps" class="form-label">แผนที่ (maps)</label>
            <input type="text" class="form-control" id="maps" name="maps" value="<?= isset($row['maps']) ? htmlspecialchars($row['maps']) : ''; ?>" required>
        </div>
        <button type="submit" name="update" class="btn btn-primary">บันทึกการแก้ไข</button>
        <a href="manage_content.php" class="btn btn-secondary">ยกเลิก</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
