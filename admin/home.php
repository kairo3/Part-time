



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
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

        .profile-card {
            background-color: white;
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 600px;
            margin: 0 auto;
            text-align: center;
            margin-top: 50px;
        }

        .profile-card img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
            margin-bottom: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .profile-card h3 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #2d3436;
        }

        .profile-card p {
            font-size: 16px;
            color: #636e72;
            margin-bottom: 20px;
        }

        .profile-card .btn-primary {
            background-color: #3498db;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .profile-card .btn-primary:hover {
            background-color: #2980b9;
        }

        .profile-card .btn-secondary {
            background-color: #636e72;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s;
            margin-left: 10px;
        }

        .profile-card .btn-secondary:hover {
            background-color: #b2bec3;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i><span class="d-none d-md-inline"> Dashboard</span></a>
        <a href="manage_content.php"><i class="fas fa-edit"></i><span class="d-none d-md-inline"> Manage Content</span></a>
        <a href="manage_users.php"><i class="fas fa-users"></i><span class="d-none d-md-inline"> Manage Users</span></a>
        <a href="settings.php"><i class="fas fa-cogs"></i><span class="d-none d-md-inline"> Settings</span></a>
        <a href="admin_profile.php"><i class="fas fa-user"></i><span class="d-none d-md-inline"> Profile</span></a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i><span class="d-none d-md-inline"> Logout</span></a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="profile-card">
            <img src="https://via.placeholder.com/150" alt="Admin Profile Picture">
            <h3>Admin Name</h3>
            <p>Email: admin@example.com</p>
            <p>Role: Administrator</p>
            <a href="edit_profile.php" class="btn btn-primary">Edit Profile</a>
            <a href="change_password.php" class="btn btn-secondary">Change Password</a>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
</body>

</html>
