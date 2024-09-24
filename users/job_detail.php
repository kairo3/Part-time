<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get job ID from URL
$job_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch job details by ID
$sql = "SELECT * FROM job_listings1 WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $job_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Job not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Detail</title>
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
        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin: 20px 0;
        }
        .job-details, .applicant-details, .benefits, .application-method, .contact, .work-location {
            padding: 0 20px 20px;
        }
        .job-details ul, .applicant-details ul, .benefits ul, .application-method ul, .contact ul, .work-location ul {
            list-style-type: none;
            padding-left: 0;
        }
        .job-details li, .applicant-details li, .benefits li, .application-method li, .contact li, .work-location li {
            margin-bottom: 10px;
            line-height: 1.6;
        }
        .map-container iframe {
            width: 100%;
            height: 300px;
            border: 0;
            margin-top: 10px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3a8591;
            color: #ffffff;
            text-align: center;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
        }
        .button:hover {
            background-color: #297d94;
        }
        .apply-button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #3a8591;
            color: #fff;
            text-align: center;
            border-radius: 4px;
            text-decoration: none;
            font-size: 16px;
            margin-top: 20px;
            transition: background-color 0.3s;
        }
        .apply-button:hover {
            background-color: #297d94;
        }
        .footer {
            background-color: #f1f1f1;
            text-align: center;
            padding: 10px;
            font-size: 12px;
            color: #777;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
        }
        .back-link {
            margin: 20px;
            display: block;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="job-title"><?= htmlspecialchars($row['shop_name']); ?></div>
            <p><?= htmlspecialchars($row['job_details']); ?></p>
        </div>

        <!-- Job Details -->
        <div class="job-details">
            <div class="section-title">รายละเอียดงาน</div>
            <ul>
                <li>ตำแหน่งงาน: <?= htmlspecialchars($row['job_position']); ?></li>
                <li>ลักษณะงาน: <?= htmlspecialchars($row['job_type']); ?></li>
                <li>จำนวนที่รับ: <?= htmlspecialchars($row['num_people']); ?> อัตรา</li>
            </ul>
        </div>

        <!-- Applicant Details -->
        <div class="applicant-details">
            <div class="section-title">คุณสมบัติผู้สมัคร</div>
            <ul>
                <?php 
                $qualifications = isset($row['qualifications']) ? explode("\n", $row['qualifications']) : ['ไม่ระบุ'];
                foreach ($qualifications as $qualification): 
                ?>
                    <li><?= htmlspecialchars(trim($qualification)); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Benefits -->
        <div class="benefits">
            <div class="section-title">สวัสดิการ</div>
            <ul>
                <?php 
                $benefits = isset($row['benefits']) ? explode("\n", $row['benefits']) : ['ไม่ระบุ'];
                foreach ($benefits as $benefit): 
                ?>
                    <li><?= htmlspecialchars(trim($benefit)); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Contact Details -->
        <div class="contact">
            <div class="section-title">ติดต่อ</div>
            <ul>
                <li>โทรศัพท์-อีเมล์: <?= isset($row['contact']) ? htmlspecialchars($row['contact']) : 'ไม่ระบุ'; ?></li>
            </ul>
        </div>

        <!-- Work Location -->
        <div class="work-location">
            <div class="section-title">สถานที่ปฏิบัติงาน</div>
            <ul>
                <li><?= htmlspecialchars($row['work_location']); ?></li>
            </ul>
            <div class="map-container">
                <a href="<?= htmlspecialchars($row['maps']); ?>" target="_blank" class="button">แผนที่</a>
            </div>
        </div>

        <!-- Apply Now Button -->
        <a href="form.php?id=<?= $row['id']; ?>" class="apply-button">สมัครงาน</a>

        <div class="footer">
            &copy; 2024 การัน โฮม เอเยนซี่ จำกัด. All Rights Reserved.
        </div>
    </div>

    <a href="Job.php" class="back-link">กลับไปที่หน้ารายการงาน</a>

    <?php $conn->close(); ?>
</body>
</html>
