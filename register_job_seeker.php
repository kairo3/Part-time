<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // ทำความสะอาดและตรวจสอบข้อมูลที่กรอก
    $name = htmlspecialchars(trim($name));
    $email = htmlspecialchars(trim($email));
    $password = htmlspecialchars(trim($password));

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
    } else {
        // ตรวจสอบว่าอีเมลมีอยู่แล้วหรือไม่
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "อีเมล์นี้ลงทะเบียนเรียบร้อยแล้ว";
        } else {
            $stmt->close(); // ปิดคำสั่งก่อนเตรียมคำสั่งใหม่

            // แฮชรหัสผ่าน
            $hashed_password = ($password);

            // เพิ่มผู้ใช้ใหม่เข้าในฐานข้อมูล
            $stmt = $conn->prepare("INSERT INTO users (email, password, name) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $email, $hashed_password, $name);

            if ($stmt->execute()) {
                $success = "ลงทะเบียนสำเร็จ";
            } else {
                $error = "Error: " . $stmt->error;
            }
        }

        $stmt->close(); // ปิดคำสั่งหลังจากการแทรกข้อมูลเสร็จสิ้น
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สมัครสมาชิกสำหรับผู้สมัครงาน - Jobthai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Arial', sans-serif;
        }
        .register-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        .register-card {
            max-width: 450px;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .register-card .card-body {
            padding: 40px;
            background: #ffffff;
        }
        .btn-primary {
            background-color: #ff5c00;
            border-color: #ff5c00;
            transition: background-color 0.3s, transform 0.3s;
        }
        .btn-primary:hover {
            background-color: #e94b00;
            transform: translateY(-2px);
        }
        .register-header {
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .input-group-text {
            background-color: #ff5c00;
            color: #fff;
        }
        .alert {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="card register-card">
            <div class="card-body">
                <h5 class="register-header"><i class="fas fa-user-tie"></i> สมัครสมาชิกสำหรับสมัครงาน</h5>
                <?php if (isset($success)): ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $success; ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                <form method="POST" action="">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" class="form-control" id="job-seeker-name" name="name" placeholder="ชื่อ" required>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" class="form-control" id="job-seeker-email" name="email" placeholder="อีเมล" required>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" class="form-control" id="job-seeker-password" name="password" placeholder="รหัสผ่าน" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mt-3">สมัครสมาชิก</button>
                </form>
                <div class="text-center mt-3">
                    <small>มีบัญชีอยู่แล้ว? <a href="login.php" class="text-danger text-decoration-none"> เข้าสู่ระบบ</a></small>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
