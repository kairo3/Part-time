<?php
// การตั้งค่าการเชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
}

// ดึงข้อมูลผู้สมัครที่มีการส่งข้อความจากฐานข้อมูล
$sql = "
    SELECT DISTINCT ja.id, ja.name, ja.email, ja.phone, jl.shop_name, jl.work_location
    FROM job_applications ja
    INNER JOIN chat_messages cm ON ja.id = cm.applicant_id
    INNER JOIN job_listings1 jl ON ja.job_id = jl.id
";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "ไม่มีผู้สมัครที่ส่งข้อความ.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เลือกผู้สมัครเพื่อเริ่มการแชท</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
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
            padding: 20px;
        }
        .header {
            background-color: #0e4f6f;
            color: #ffffff;
            text-align: center;
            padding: 20px;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }
        .shop-list {
            list-style-type: none;
            padding: 0;
        }
        .shop-list li {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 8px;
            background-color: #f0f0f0;
        }
        .shop-list a {
            text-decoration: none;
            color: #3a8591;
            font-weight: bold;
        }
        .shop-list a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            เลือกผู้สมัครเพื่อเริ่มการแชท
        </div>
        <ul class="shop-list">
            <?php while ($row = $result->fetch_assoc()): ?>
                <li>
                    <a href="chat_room.php?id=<?= $row['id'] ?>">
                        <?= htmlspecialchars($row['shop_name']) ?> - <?= htmlspecialchars($row['work_location']) ?>
                    </a>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>

    <?php $conn->close(); ?>
</body>
</html>
