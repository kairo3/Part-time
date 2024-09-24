<?php

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize search variables
$job_position = isset($_GET['job_position']) ? $_GET['job_position'] : '';
$location = isset($_GET['location']) ? $_GET['location'] : '';

// SQL query to fetch job listings
$sql = "SELECT * FROM job_listings1 WHERE 1=1";
if ($job_position) {
    $sql .= " AND job_position LIKE '%" . $conn->real_escape_string($job_position) . "%'";
}
if ($location) {
    $sql .= " AND work_location LIKE '%" . $conn->real_escape_string($location) . "%'";
}
$sql .= " ORDER BY id DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Listings</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 32px;
            margin: 0;
            color: #007bff;
        }
        .filter-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-bottom: 20px;
            align-items: center;
        }
        .filter-form input, .filter-form button {
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .filter-form input {
            width: 300px;
        }
        .filter-form button {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .filter-form button:hover {
            background-color: #0056b3;
        }
        .filter-buttons {
            display: flex;
            gap: 10px;
        }
        .filter-buttons button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .filter-buttons button:hover {
            background-color: #0056b3;
        }
        .job-listings {
            list-style: none;
            padding: 0;
        }
        .job-listings li {
            padding: 20px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #fafafa;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: box-shadow 0.3s, transform 0.3s;
        }
        .job-listings li:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transform: scale(1.02);
        }
        .job-listings a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            font-size: 18px;
        }
        .job-listings .job-info {
            font-size: 14px;
            color: #777;
        }
        .actions {
            display: flex;
            gap: 10px;
        }
        .actions a {
            padding: 8px 12px;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            font-size: 14px;
            color: white;
            cursor: pointer;
        }
        .actions .share {
            background-color: #007bff;
        }
        .actions .save {
            background-color: #6c757d;
        }
        .actions .details {
            background-color: #dc3545;
        }
        .no-jobs {
            text-align: center;
            color: #888;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>ประเภทงาน</h1>
        </div>
        
        <!-- Filter Form -->
        <form class="filter-form" method="get" action="">
            <input type="text" name="job_position" placeholder="Search by Job Position" value="<?= htmlspecialchars($job_position); ?>">
            
            <div class="filter-buttons">
                <!-- Filter by specific locations -->
                <button type="submit" name="location" value="ยะลา">ยะลา</button>
                <button type="submit" name="location" value="ปัตตานี">ปัตตานี</button>
                <button type="submit" name="location" value="นราธิวาส">นราธิวาส</button>
            </div>
        </form>

        <!-- Job Listings -->
        <ul class="job-listings">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <li>
                        <a href="job_detail.php?id=<?= $row['id']; ?>">
                            <?= htmlspecialchars($row['shop_name']); ?> - <?= htmlspecialchars($row['job_position']); ?>
                        </a>
                        <div class="job-info">
                            <span>ประเภทงาน: <?= htmlspecialchars($row['job_type']); ?></span> | 
                            <span>สถานที่: <?= htmlspecialchars($row['work_location']); ?></span>
                        </div>
                        <div class="actions">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode('http://yourwebsite.com/job_detail.php?id=' . $row['id']); ?>" target="_blank" class="share">แชร์</a>
                            <a href="#" class="save">บันทึก</a>
                            <a href="job_detail.php?id=<?= $row['id']; ?>" class="details">อ่านรายละเอียดงาน</a>
                        </div>
                    </li>
                <?php endwhile; ?>
            <?php else: ?>
                <li class="no-jobs">No jobs found</li>
            <?php endif; ?>
        </ul>
    </div>

    <?php $conn->close(); ?>
</body>
</html>
