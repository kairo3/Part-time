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

// ตรวจสอบว่าได้รับ ID หรือไม่
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid ID.");
}

$id = $_GET['id'];

// ดึงข้อมูลที่ต้องการแก้ไข
$stmt = $conn->prepare("SELECT * FROM job_listings1 WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("No record found.");
}

$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Job Listing</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            margin-left: 250px;
            transition: margin-left 0.3s;
        }
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #2c3e50;
            padding-top: 20px;
            transition: all 0.3s;
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 0 10px 10px 0;
        }
        .sidebar a {
            padding: 15px 20px;
            text-decoration: none;
            font-size: 16px;
            color: white;
            display: flex;
            align-items: center;
            transition: all 0.3s;
            border-radius: 5px;
        }
        .sidebar a:hover,
        .sidebar a.active {
            background-color: #34495e;
            color: #ecf0f1;
            box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.2);
        }
        .sidebar a .fas {
            margin-right: 10px;
        }
        .main-content {
            padding: 20px;
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        h1 {
            margin-bottom: 20px;
            color: #2980b9;
        }
        .form-label {
            font-weight: bold;
            color: #333;
        }
        .form-control {
            border-radius: 10px;
            border: 1px solid #ddd;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            border-radius: 20px;
            padding: 10px 20px;
            font-size: 16px;
            transition: all 0.3s;
        }
        .btn-primary:hover {
            background-color: #1e7e34;
            border-color: #1e7e34;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .btn-secondary {
            border-radius: 20px;
            padding: 10px 20px;
            font-size: 16px;
            transition: all 0.3s;
        }
        .btn-secondary:hover {
            background-color: #95a5a6;
            border-color: #95a5a6;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i><span class="d-none d-md-inline"> Dashboard</span></a>
        <a href="manage_content.php"><i class="fas fa-edit"></i><span class="d-none d-md-inline"> Manage Content</span></a>
        <a href="manage_users.php"><i class="fas fa-users"></i><span class="d-none d-md-inline"> Manage Users</span></a>
        <a href="Chat.php"><i class="fas fa-comments"></i><span class="d-none d-md-inline"> Chat</span></a>
        <a href="settings.php"><i class="fas fa-cogs"></i><span class="d-none d-md-inline"> Settings</span></a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i><span class="d-none d-md-inline"> Logout</span></a>
    </div>
    <body>
    <div class="container mt-4">
        <h1>แก้ไขข้อมูล</h1>
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

        // รับข้อมูลที่ต้องการแก้ไข
        $id = $_GET['id'];
        $stmt = $conn->prepare("SELECT * FROM job_listings1 WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        ?>
        <form action="update_content.php" method="post">
            <input type="hidden" name="id" value="<?= htmlspecialchars($data['id']); ?>">
            
            <div class="mb-3">
                <label for="shop_name" class="form-label">ชื่อร้าน</label>
                <input type="text" class="form-control" id="shop_name" name="shop_name" value="<?= htmlspecialchars($data['shop_name']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="job_details" class="form-label">รายละเอียดงาน</label>
                <textarea class="form-control" id="job_details" name="job_details" rows="3" required><?= htmlspecialchars($data['job_details']); ?></textarea>
            </div>

            <div class="mb-3">
                <label for="job_position" class="form-label">ตำแหน่งงาน</label>
                <input type="text" class="form-control" id="job_position" name="job_position" value="<?= htmlspecialchars($data['job_position']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="job_type" class="form-label">ลักษณะงาน</label>
                <input type="text" class="form-control" id="job_type" name="job_type" value="<?= htmlspecialchars($data['job_type']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="num_people" class="form-label">จำนวนที่รับ</label>
                <input type="number" class="form-control" id="num_people" name="num_people" value="<?= htmlspecialchars($data['num_people']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="benefits" class="form-label">สวัสดิการ</label>
                <textarea class="form-control" id="benefits" name="benefits" rows="3"><?= htmlspecialchars($data['benefits']); ?></textarea>
            </div>

            <div class="mb-3">
                <label for="application_method" class="form-label">วิธีการสมัคร</label>
                <textarea class="form-control" id="application_method" name="application_method" rows="3"><?= htmlspecialchars($data['application_method']); ?></textarea>
            </div>

            <div class="mb-3">
                <label for="contact" class="form-label">ติดต่อ</label>
                <input type="text" class="form-control" id="contact" name="contact" value="<?= htmlspecialchars($data['contact']); ?>">
            </div>

            <div class="mb-3">
                <label for="work_location" class="form-label">สถานที่ปฏิบัติงาน</label>
                <input type="text" class="form-control" id="work_location" name="work_location" value="<?= htmlspecialchars($data['work_location']); ?>">
            </div>

            <div class="mb-3">
                <label for="qualifications" class="form-label">คุณสมบัติ</label>
                <textarea class="form-control" id="qualifications" name="qualifications" rows="3"><?= htmlspecialchars($data['qualifications']); ?></textarea>
            </div>

            <div class="mb-3">
                <label for="maps" class="form-label">แผนที่ (maps)</label>
                <input type="text" class="form-control" id="maps" name="maps" value="<?= htmlspecialchars($data['maps']); ?>">
            </div>

            <button type="submit" class="btn btn-primary">บันทึกการเปลี่ยนแปลง</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
</body>

</html>