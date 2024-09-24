<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ - Jobthai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Arial', sans-serif;
        }
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        .login-card {
            max-width: 450px;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .login-card .card-body {
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
        .login-header {
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .tab-pane {
            animation: fadeIn 0.3s ease-in-out;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .input-group-text {
            background-color: #ff5c00;
            color: #fff;
        }
        .form-control:invalid {
            border-color: #dc3545;
        }
        .form-control:valid {
            border-color: #28a745;
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="d-flex flex-column align-items-center">
        <div class="card login-card">
            <div class="card-body">
                <!-- Tab Navigation -->
                <ul class="nav nav-tabs mb-4" id="loginTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="find-job-tab" data-bs-toggle="tab" data-bs-target="#find-job" type="button" role="tab" aria-controls="find-job" aria-selected="true">หางาน</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="find-person-tab" data-bs-toggle="tab" data-bs-target="#find-person" type="button" role="tab" aria-controls="find-person" aria-selected="false">หาคน</button>
                    </li>
                </ul>
                <!-- Tab Content -->
                <div class="tab-content" id="loginTabContent">
                    <!-- Find Job Tab -->
                    <div class="tab-pane fade show active" id="find-job" role="tabpanel" aria-labelledby="find-job-tab">
                        <h5 class="login-header"><i class="fas fa-user-tie"></i> เข้าสู่ระบบสำหรับผู้สมัครงาน</h5>
                        <form method="POST" action="login_job_seeker.php">
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control" id="username" name="username" placeholder="อีเมล" aria-label="อีเมล" required>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control" id="password" name="password" placeholder="รหัสผ่าน" aria-label="รหัสผ่าน" required>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="#" class="small text-decoration-none">ลืมรหัสผ่าน?</a>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mt-3">เข้าสู่ระบบ</button>
                        </form>
                        <div class="text-center mt-3">
                            <small>ยังไม่ได้เป็นสมาชิก? <a href="register_job_seeker.php" class="text-danger text-decoration-none">สมัครสมาชิกสำหรับผู้สมัครงาน</a></small>
                        </div>
                    </div>
                    <!-- Find Person Tab -->
                    <div class="tab-pane fade" id="find-person" role="tabpanel" aria-labelledby="find-person-tab">
                        <h5 class="login-header"><i class="fas fa-users"></i> เข้าสู่ระบบสำหรับผู้ว่าจ้าง</h5>
                        <form method="POST" action="login_employer.php">
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control" id="employer-username" name="employer_username" placeholder="อีเมล" aria-label="อีเมล" required>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control" id="employer-password" name="employer_password" placeholder="รหัสผ่าน" aria-label="รหัสผ่าน" required>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="#" class="small text-decoration-none">ลืมรหัสผ่าน?</a>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mt-3">เข้าสู่ระบบ</button>
                        </form>
                        <div class="text-center mt-3">
                            <small>ยังไม่ได้เป็นสมาชิก? <a href="register_employer.php" class="text-danger text-decoration-none">สมัครสมาชิกสำหรับผู้ว่าจ้าง</a></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
