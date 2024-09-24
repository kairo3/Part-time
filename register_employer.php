<?php
session_start();
include 'db.php'; // Ensure this file establishes your database connection properly

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize form data
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = trim($_POST['password']); // No need to use htmlspecialchars for password
    $errors = []; // Array to hold errors

    // Validate name field
    if (empty($name)) {
        $errors['name'] = "โปรดกรอกชื่อร้าน";
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "รูปแบบอีเมลไม่ถูกต้อง";
    }

    // Validate password field
    if (empty($password)) {
        $errors['password'] = "โปรดกรอกรหัสผ่าน";
    } elseif (strlen($password) < 6) {
        $errors['password'] = "รหัสผ่านต้องมีความยาวอย่างน้อย 6 ตัวอักษร";
    }

    // Check if the email already exists in the database
    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT id FROM admin WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $errors['email'] = "อีเมล์นี้ลงทะเบียนเรียบร้อยแล้ว";
        } else {
            $stmt->close(); // Close the statement before preparing a new one

            // If no errors, proceed with registration
            if (empty($errors)) {
                // Hash the password using MD5 (Not recommended for security reasons)
                $hashed_password =  ($password);

                // Insert the new user into the database
                $stmt = $conn->prepare("INSERT INTO admin (email, password, company_name) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $email, $hashed_password, $name);

                if ($stmt->execute()) {
                    $success = "ลงทะเบียนสำเร็จ";
                } else {
                    $errors['general'] = "เกิดข้อผิดพลาด: " . $stmt->error;
                }
            }
        }

        $stmt->close(); // Close the statement after the insert operation
    }

    $conn->close(); // Close the database connection
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
                <h5 class="register-header"><i class="fas fa-user-tie"></i> เข้าสู่ระบบสำหรับผู้ว่าจ้าง</h5>
                <?php if (isset($success)): ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $success; ?>
                    </div>
                <?php endif; ?>
                <?php if (!empty($errors)): ?>
                    <?php foreach ($errors as $field => $message): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $message; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <form method="POST" action="">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" class="form-control" id="job-seeker-name" name="name" placeholder="ชื่อร้าน" aria-label="Company Name" required>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" class="form-control" id="job-seeker-email" name="email" placeholder="อีเมล" aria-label="Email" required>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" class="form-control" id="job-seeker-password" name="password" placeholder="รหัสผ่าน" aria-label="Password" required>
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
