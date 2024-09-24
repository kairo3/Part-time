<?php
// การตั้งค่าการเชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("เชื่อมต่อฐานข้อมูลไม่สำเร็จ: " . $conn->connect_error);
}

// รับ job ID จาก URL
$job_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// ดึงข้อมูลรายละเอียดงานจาก ID สำหรับแสดงในแบบฟอร์ม
$sql = "SELECT * FROM job_listings1 WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $job_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $job = $result->fetch_assoc();
} else {
    echo "ไม่พบงานที่คุณต้องการ.";
    exit;
}

// จัดการเมื่อมีการส่งแบบฟอร์ม
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $education = $_POST['education'];
    $experience = $_POST['experience'];
    $skills = $_POST['skills'];
    $cover_letter = $_POST['cover_letter'];

    // ตรวจสอบและจัดการข้อมูลที่ป้อนเข้า
    $name = htmlspecialchars($name);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars($phone);
    $address = htmlspecialchars($address);
    $education = htmlspecialchars($education);
    $experience = htmlspecialchars($experience);
    $skills = htmlspecialchars($skills);
    $cover_letter = htmlspecialchars($cover_letter);

    // บันทึกใบสมัครลงในฐานข้อมูล
    $insert_sql = "INSERT INTO job_applications (job_id, name, email, phone, address, education, experience, skills, cover_letter) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("issssssss", $job_id, $name, $email, $phone, $address, $education, $experience, $skills, $cover_letter);

    if ($insert_stmt->execute()) {
        echo "ส่งใบสมัครเรียบร้อยแล้ว!";
    } else {
        echo "เกิดข้อผิดพลาด: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สมัครงาน</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
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
            padding: 20px;
        }
        .header {
            background-color: #0e4f6f;
            color: #ffffff;
            text-align: center;
            padding: 20px;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }
        .header .job-title {
            font-size: 24px;
            margin: 5px 0;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .form-group textarea {
            height: 100px;
            resize: vertical;
        }
        .submit-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3a8591;
            color: #ffffff;
            text-align: center;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
        }
        .submit-button:hover {
            background-color: #297d94;
        }
        .back-link {
            display: block;
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="job-title"><?= htmlspecialchars($job['shop_name']); ?></div>
            <p>สมัครงานในตำแหน่งที่ระบุด้านบนโดยกรอกแบบฟอร์มด้านล่างนี้:</p>
        </div>

        <form action="" method="POST">
            <div class="form-group">
                <label for="name">ชื่อเต็ม:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">อีเมล:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone">เบอร์โทรศัพท์:</label>
                <input type="text" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label for="address">ที่อยู่:</label>
                <textarea id="address" name="address" required></textarea>
            </div>
            <div class="form-group">
                <label for="education">ประวัติการศึกษา:</label>
                <textarea id="education" name="education" required></textarea>
            </div>
            <div class="form-group">
                <label for="experience">ประสบการณ์การทำงาน:</label>
                <textarea id="experience" name="experience" required></textarea>
            </div>
            <div class="form-group">
                <label for="skills">ทักษะ:</label>
                <textarea id="skills" name="skills" required></textarea>
            </div>
            <div class="form-group">
                <label for="cover_letter">จดหมายสมัครงาน:</label>
                <textarea id="cover_letter" name="cover_letter" required></textarea>
            </div>
            <input type="submit" value="ส่งใบสมัคร" class="submit-button">
        </form>

        <a href="Job.php" class="back-link">กลับไปที่หน้ารายการงาน</a>
    </div>

    <?php $conn->close(); ?>
</body>
</html>
