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

// ดึงข้อมูลผู้สมัครทั้งหมดจากตาราง job_applications
$sql = "SELECT ja.id, ja.name, ja.email, ja.phone, ja.address, ja.education, ja.experience, ja.skills, ja.cover_letter, ja.application_date, 
        jl.shop_name, jl.job_position 
        FROM job_applications ja
        JOIN job_listings1 jl ON ja.job_id = jl.id
        ORDER BY ja.application_date DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
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
        }
        .sidebar a {
            padding: 15px 20px;
            text-decoration: none;
            font-size: 16px;
            color: white;
            display: flex;
            align-items: center;
            transition: all 0.3s;
        }
        .sidebar a:hover,
        .sidebar a.active {
            background-color: #34495e;
            color: #ecf0f1;
        }
        .sidebar a .fas {
            margin-right: 10px;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
            transition: all 0.3s;
        }
        .container {
            max-width: 1000px;
            margin: 20px auto;
            background-color: #fff;
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
        .applicant-table {
            width: 100%;
            border-collapse: collapse;
        }
        .applicant-table th, .applicant-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        .applicant-table th {
            background-color: #0e4f6f;
            color: #fff;
        }
        .applicant-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .applicant-table tr:hover {
            background-color: #f1f1f1;
        }
        .details-link {
            color: #3a8591;
            text-decoration: none;
            font-weight: bold;
        }
        .chat-link {
            color: #3498db;
            text-decoration: none;
            font-weight: bold;
        }
        .chat-link:hover {
            color: #2980b9;
        }
        .footer {
            background-color: #f1f1f1;
            text-align: center;
            padding: 10px;
            font-size: 12px;
            color: #777;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
            }
            .sidebar a {
                padding: 10px;
                font-size: 14px;
                justify-content: center;
            }
            .sidebar a .fas {
                margin-right: 0;
            }
            .sidebar a span {
                display: none;
            }
            .main-content {
                margin-left: 70px;
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i><span class="d-none d-md-inline"> Dashboard</span></a>
        <a href="manage_content.php"><i class="fas fa-edit"></i><span class="d-none d-md-inline"> Manage Content</span></a>
        <a href="manage_users.php" class="active"><i class="fas fa-users"></i><span class="d-none d-md-inline"> Manage Users</span></a>
        <a href="Chat.php"><i class="fas fa-comments"></i><span class="d-none d-md-inline"> Chat</span></a>
        <a href="settings.php"><i class="fas fa-cogs"></i><span class="d-none d-md-inline"> Settings</span></a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i><span class="d-none d-md-inline"> Logout</span></a>
    </div>

    <div class="main-content">
        <div class="container">
            <div class="header">รายละเอียดผู้สมัครงาน</div>

            <?php if ($result->num_rows > 0): ?>
                <table class="applicant-table">
                    <thead>
                        <tr>
                            <th>ชื่อผู้สมัคร</th>
                            <th>อีเมล</th>
                            <th>เบอร์โทร</th>
                            <th>ตำแหน่งงาน</th>
                            <th>ชื่อร้าน</th>
                            <th>วันที่สมัคร</th>
                            <th>รายละเอียด</th>
                            <th>เริ่มแชท</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['name']); ?></td>
                                <td><?= htmlspecialchars($row['email']); ?></td>
                                <td><?= htmlspecialchars($row['phone']); ?></td>
                                <td><?= htmlspecialchars($row['job_position']); ?></td>
                                <td><?= htmlspecialchars($row['shop_name']); ?></td>
                                <td><?= date('d-m-Y', strtotime($row['application_date'])); ?></td>
                                <td><a href="applicant_profile.php?id=<?= $row['id']; ?>" class="details-link">ดูรายละเอียด</a></td>
                                <td>
                                    <a href="https://m.me/YOUR_FACEBOOK_PAGE_USERNAME" class="chat-link" target="_blank">เริ่มแชท</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p style="padding: 20px; text-align: center;">ไม่พบข้อมูลผู้สมัคร</p>
            <?php endif; ?>

            <div class="footer">
                &copy; 2024 การัน โฮม เอเยนซี่ จำกัด. สงวนลิขสิทธิ์
            </div>
        </div>
    </div>

    <?php $conn->close(); ?>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
</body>

</html>
