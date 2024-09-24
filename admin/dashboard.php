
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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

        .sidebar a:hover {
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
            background-color: #f5f5f5;
        }

        .navbar {
            margin-left: 250px;
            width: calc(100% - 250px);
            transition: all 0.3s;
            background-color: #2980b9;
        }

        .container-fluid {
            padding-top: 20px;
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

            .navbar {
                margin-left: 70px;
                width: calc(100% - 70px);
            }

            .main-content {
                margin-left: 70px;
            }
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }

        .btn-primary {
            background-color: #3498db;
            border: none;
        }

        .btn-primary:hover {
            background-color: #2980b9;
        }

        .navbar-dark .navbar-brand {
            color: white;
        }

        .navbar-dark .navbar-nav .nav-link {
            color: white;
        }

        .navbar-dark .navbar-nav .nav-link:hover {
            color: #dcdcdc;
        }

        .card-header {
            background-color: #2980b9;
            color: white;
        }

        .card-body i {
            font-size: 2em;
            margin-bottom: 10px;
        }

        .stat-card {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
        }

        .stat-card h5 {
            margin: 0;
            font-size: 1.2em;
        }

        .stat-card span {
            font-size: 2.5em;
            font-weight: bold;
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

    <!-- Main Content -->
    <div class="main-content">
        <div class="container-fluid">
            <h1 class="mt-4">Dashboard</h1>
            <p>Welcome to the Admin Dashboard. Here you can manage your content, users, and settings.</p>

            <!-- Statistics -->
            <div class="row">
                <!-- Total Contents -->
                <div class="col-md-3">
                    <div class="card mb-4">
                        <div class="card-header">Total Contents</div>
                        <div class="card-body stat-card">
                            <i class="fas fa-edit"></i>
                            <span>
                                <?php
                                // ฟังก์ชันการดึงข้อมูลจากฐานข้อมูล
                                function getCount($table) {
                                    global $conn;
                                    $sql = "SELECT COUNT(*) as count FROM $table";
                                    $result = $conn->query($sql);
                                    $row = $result->fetch_assoc();
                                    return $row['count'];
                                }

                                // เชื่อมต่อกับฐานข้อมูล
                                $servername = "localhost";
                                $username = "root";
                                $password = "";
                                $dbname = "test_db";                            
                                $conn = new mysqli($servername, $username, $password, $dbname);

                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                // แสดงจำนวนเนื้อหาทั้งหมด
                                echo getCount('job_listings1');
                                ?>
                            </span>
                        </div>
                    </div>
                </div>
                <!-- Total Users -->
                <div class="col-md-3">
                    <div class="card mb-4">
                        <div class="card-header">Total Users</div>
                        <div class="card-body stat-card">
                            <i class="fas fa-users"></i>
                            <span>
                                <?php
                                // แสดงจำนวนผู้ใช้ทั้งหมด
                                echo getCount('job_applications');
                                ?>
                            </span>
                        </div>
                    </div>
                </div>
             
                <!-- New Users -->
                <div class="col-md-3">
                    <div class="card mb-4">
                        <div class="card-header">New Users</div>
                        <div class="card-body stat-card">
                            <i class="fas fa-user-plus"></i>
                            <span>
                                <?php
                                $sql = "SELECT COUNT(*) as count FROM admin WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())";
                                $result = $conn->query($sql);
                                $row = $result->fetch_assoc();
                                echo $row['count'];
                                ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

           

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
</body>

</html>
