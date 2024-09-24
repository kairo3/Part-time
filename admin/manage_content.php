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

// ฟังก์ชันลบข้อมูล
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    
    // Start a transaction
    $conn->begin_transaction();
    
    try {
        // Delete related job applications
        $stmt = $conn->prepare("DELETE FROM job_applications WHERE job_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        // Delete the job listing
        $stmt = $conn->prepare("DELETE FROM job_listings1 WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        // Commit the transaction
        $conn->commit();
        
        $_SESSION['message'] = "ลบข้อมูลเรียบร้อยแล้ว!";
    } catch (Exception $e) {
        // Rollback the transaction in case of error
        $conn->rollback();
        $_SESSION['message'] = "เกิดข้อผิดพลาดในการลบข้อมูล!";
    }
    
    header("Location: manage_content.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Content</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
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
            margin-left: 250px;
            padding: 20px;
            transition: all 0.3s;
            background-color: #ffffff;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }

        table {
            background-color: #ffffff;
            width: 100%;
            text-align: left;
            border-radius: 10px;
            overflow: hidden;
        }

        th {
            background-color: #2980b9;
            color: white;
            font-weight: bold;
            border-bottom: 2px solid #2980b9;
        }

        td,
        th {
            padding: 12px;
        }

        tr:nth-child(even) {
            background-color: #ecf0f1;
        }

        .table-hover tbody tr:hover {
            background-color: #d5d8dc;
            transition: background-color 0.3s;
        }

        .btn-custom {
            border-radius: 20px;
            padding: 8px 16px;
            font-size: 14px;
            transition: all 0.3s;
        }

        .btn-custom:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .btn-add {
            background-color: #27ae60;
            color: #ffffff;
        }

        .btn-add:hover {
            background-color: #2ecc71;
        }

        .btn-edit {
            background-color: #f39c12;
            color: #ffffff;
        }

        .btn-edit:hover {
            background-color: #f1c40f;
        }

        .btn-delete {
            background-color: #e74c3c;
            color: #ffffff;
        }

        .btn-delete:hover {
            background-color: #c0392b;
        }

        .alert {
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i><span class="d-none d-md-inline"> Dashboard</span></a>
        <a href="manage_content.php" class="active"><i class="fas fa-edit"></i><span class="d-none d-md-inline"> Manage Content</span></a>
        <a href="manage_users.php"><i class="fas fa-users"></i><span class="d-none d-md-inline"> Manage Users</span></a>
        <a href="Chat.php"><i class="fas fa-comments"></i><span class="d-none d-md-inline"> Chat</span></a>
        <a href="settings.php"><i class="fas fa-cogs"></i><span class="d-none d-md-inline"> Settings</span></a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i><span class="d-none d-md-inline"> Logout</span></a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container-fluid">
            <h1 class="mt-4">ข้อมูลลงสมัครงาน</h1>
            <p>ทางร้าน ลงข้อมูลเกี่ยวกับการสมัครงานได้เลย - ข้อมูลนี้จะไปแสดงหน้าผู้สมัครงาน</p>

            <!-- Alerts -->
            <?php if (isset($_SESSION['message'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($_SESSION['message']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['message']); ?>
            <?php endif; ?>

            <!-- Content Management -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i> Content List
                </div>
                <div class="card-body">
                    <table class="table table-hover table-bordered">
                    <thead>
    <tr>
        <th>ชื่อร้าน</th>
        <th>รายละเอียดงาน</th>
        <th>ตำแหน่งงาน</th>
        <th>ลักษณะงาน</th>
        <th>จำนวนที่รับ</th>
        <th>คุณสมบัติ</th>
        <th>สวัสดิการ</th>
        <th>วิธีการสมัคร</th>
        <th>ติดต่อ</th>
        <th>สถานที่ปฏิบัติงาน</th>
        <th>แผนที่ (maps)</th> <!-- Added qualifications column -->
        <th>จัดการ</th>
    </tr>
</thead>
<tbody>
    <?php
    // ดึงข้อมูลจากฐานข้อมูล
    $result = $conn->query("SELECT * FROM job_listings1 ORDER BY id DESC");
    if ($result->num_rows > 0):
        while ($row = $result->fetch_assoc()):
    ?>
    <tr>
        <td><?= htmlspecialchars($row['shop_name']); ?></td>
        <td><?= nl2br(htmlspecialchars($row['job_details'])); ?></td>
        <td><?= htmlspecialchars($row['job_position']); ?></td>
        <td><?= htmlspecialchars($row['job_type']); ?></td>
        <td><?= htmlspecialchars($row['num_people']); ?></td>
        <td><?= nl2br(htmlspecialchars($row['qualifications'])); ?></td> <!-- Display qualifications -->
        <td><?= nl2br(htmlspecialchars($row['benefits'])); ?></td>
        <td><?= nl2br(htmlspecialchars($row['application_method'])); ?></td>
        <td><?= htmlspecialchars($row['contact']); ?></td>
        <td><?= htmlspecialchars($row['work_location']); ?></td>
        <td>
            <a href="<?= htmlspecialchars($row['maps']); ?>" target="_blank" class="btn btn-info btn-sm btn-custom">แผนที่</a>
        </td>
   
        <td>
            <a href="edit_content.php?id=<?= $row['id']; ?>" class="btn btn-edit btn-sm btn-custom">แก้ไข</a>
            <a href="manage_content.php?delete=<?= $row['id']; ?>" class="btn btn-delete btn-sm btn-custom" onclick="return confirm('คุณต้องการลบข้อมูลนี้หรือไม่?');">ลบ</a>
        </td>
    </tr>
                            <?php
                                endwhile;
                            else:
                            ?>
                            <tr>
                                <td colspan="11" class="text-center">ไม่มีข้อมูล</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Add Content Button -->
            <a href="add_content.php" class="btn btn-add"><i class="fas fa-plus"></i> เพิ่มข้อมูลทางร้าน</a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
</body>

</html>
<?php
$conn->close();
?>
