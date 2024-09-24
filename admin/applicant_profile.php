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
    <title>ข้อมูลผู้สมัคร</title>
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
        .section {
            padding: 20px;
            border-bottom: 1px solid #ddd;
        }
        .section:last-child {
            border-bottom: none;
        }
        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }
        .details {
            margin-bottom: 10px;
            line-height: 1.6;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3a8591;
            color: #ffffff;
            text-align: center;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
        }
        .button:hover {
            background-color: #297d94;
        }
        .footer {
            background-color: #f1f1f1;
            text-align: center;
            padding: 10px;
            font-size: 12px;
            color: #777;
        }
        .back-link {
            display: block;
            text-align: center;
            margin: 20px 0;
            color: #3a8591;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">ข้อมูลผู้สมัคร</div>

        <!-- ข้อมูลส่วนตัว -->
        <div class="section">
            <div class="section-title">ข้อมูลส่วนตัว</div>
            <div class="details"><strong>ชื่อ:</strong> <?= htmlspecialchars($row['name']); ?></div>
            <div class="details"><strong>อีเมล:</strong> <?= htmlspecialchars($row['email']); ?></div>
            <div class="details"><strong>เบอร์โทรศัพท์:</strong> <?= htmlspecialchars($row['phone']); ?></div>
            <div class="details"><strong>ที่อยู่:</strong> <?= htmlspecialchars($row['address']); ?></div>
        </div>

        <!-- ข้อมูลงานที่สมัคร -->
        <div class="section">
            <div class="section-title">งานที่สมัคร</div>
            <div class="details"><strong>ชื่อร้าน:</strong> <?= htmlspecialchars($row['shop_name']); ?></div>
            <div class="details"><strong>ตำแหน่งงาน:</strong> <?= htmlspecialchars($row['job_position']); ?></div>
            <div class="details"><strong>วันที่สมัคร:</strong> <?= date('d-m-Y', strtotime($row['application_date'])); ?></div>
        </div>

        <!-- การศึกษาและประสบการณ์ -->
        <div class="section">
            <div class="section-title">การศึกษา & ประสบการณ์</div>
            <div class="details"><strong>การศึกษา:</strong> <?= htmlspecialchars($row['education']); ?></div>
            <div class="details"><strong>ประสบการณ์:</strong> <?= nl2br(htmlspecialchars($row['experience'])); ?></div>
        </div>

        <!-- ทักษะ -->
        <div class="section">
            <div class="section-title">ทักษะ</div>
            <div class="details"><?= nl2br(htmlspecialchars($row['skills'])); ?></div>
        </div>

        <!-- จดหมายสมัครงาน -->
        <div class="section">
            <div class="section-title">จดหมายสมัครงาน</div>
            <div class="details"><?= nl2br(htmlspecialchars($row['cover_letter'])); ?></div>
        </div>

        <div class="footer">
            &copy; 2024 การัน โฮม เอเยนซี่ จำกัด. สงวนลิขสิทธิ์.
        </div>
    </div>

    <a href="manage_users.php" class="back-link">กลับไปยังหน้ารายชื่อผู้สมัคร</a>

    <?php $conn->close(); ?>
</body>
</html>
