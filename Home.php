<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webpage Design</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="stylehome.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
            color: #333;
            background-color: #f8f9fa;
            overflow-x: hidden;
        }

        .main {
            background-image: url('photo/44.png');
            background-size: cover;
            background-position: center;
            height: 100vh;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
        }

        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 40px;
            background: rgba(0, 0, 0, 0.7);
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            animation: slideDown 0.5s ease-out;
        }

        @keyframes slideDown {
            from {
                top: -100px;
            }
            to {
                top: 0;
            }
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #ffc107;
            transition: color 0.3s;
        }

        .logo:hover {
            color: #fff;
        }

        .menu ul {
            list-style: none;
            display: flex;
            gap: 20px;
            padding: 0;
            margin: 0;
        }

        .menu ul li {
            position: relative;
        }

        .menu ul li a {
            text-decoration: none;
            color: #fff;
            padding: 10px 15px;
            border-radius: 4px;
            transition: background 0.3s, color 0.3s;
        }

        .menu ul li a:hover {
            background: #ffc107;
            color: #333;
        }

        .menu ul li ul {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 10px;
            list-style: none;
            border-radius: 4px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .menu ul li:hover ul {
            display: block;
            animation: fadeIn 0.5s ease-in-out;
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

        .menu ul li ul li {
            padding: 10px;
            width: 150px;
        }

        .menu ul li ul li a {
            padding: 0;
            color: #333;
        }

        .search {
            display: flex;
            align-items: center;
        }

        .srch {
            padding: 10px 15px;
            border: 2px solid #ffc107;
            border-radius: 20px 0 0 20px;
            outline: none;
            transition: border-color 0.3s;
        }

        .srch:focus {
            border-color: #ffca2c;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            background-color: #ffc107;
            color: #333;
            border-radius: 0 20px 20px 0;
            cursor: pointer;
            transition: background 0.3s, transform 0.3s;
        }

        .btn:hover {
            background-color: #ffca2c;
            transform: scale(1.05);
        }

        .content {
            text-align: center;
            margin-bottom: 50px;
            padding: 0 20px;
            animation: fadeIn 1.5s ease-in-out;
        }

        .content h1 {
            font-size: 50px;
            color: #354344;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            margin-top: 0;
            animation: textGlow 1.5s infinite alternate;
        }

        @keyframes textGlow {
            from {
                text-shadow: 2px 2px 4px rgba(255, 255, 255, 0.5);
            }
            to {
                text-shadow: 2px 2px 20px rgba(255, 255, 255, 1);
            }
        }

        .content .par {
            margin: 20px 0;
            font-size: 18px;
            line-height: 1.6;
            color: #ffe200;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }

        .cn a {
            text-decoration: none;
            color: white;
        }

        .cn {
            display: inline-block;
            padding: 10px 20px;
            border: none;
            background-color: #ffc107;
            color: #333;
            border-radius: 20px;
            cursor: pointer;
            transition: background 0.3s, transform 0.3s;
            animation: bounce 2s infinite;
        }

        .cn:hover {
            background-color: #ffca2c;
            transform: scale(1.05);
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }

        .background-animation {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(120deg, rgba(0, 0, 0, 0.5) 0%, rgba(0, 0, 0, 0.7) 100%);
            animation: backgroundMove 10s infinite alternate;
            z-index: -1;
        }

        @keyframes backgroundMove {
            from {
                background-position: 0% 50%;
            }
            to {
                background-position: 100% 50%;
            }
        }

        .scrolling-text {
            position: absolute;
            bottom: 20px;
            width: 100%;
            text-align: center;
            font-size: 16px;
            color: #ffc107;
            animation: scrollText 10s linear infinite;
        }

        @keyframes scrollText {
            0% {
                transform: translateX(100%);
            }
            100% {
                transform: translateX(-100%);
            }
        }

        /* Additional interactive elements */
        .card {
            background: #1c000057;
            backdrop-filter: blur(5px);
            border-radius: 15px;
            padding: 20px;
            margin: 20px;
            color: #fff;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .card h2 {
            margin: 0 0 10px;
        }

        .card p {
            margin: 0;
        }

        .cards-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
        }

        .footer {
            background: rgba(0, 0, 0, 0.7);
            color: #fff;
            text-align: center;
            padding: 20px;
            position: relative;
        }

        .footer a {
            color: #ffc107;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer a:hover {
            color: #fff;
        }

        .social-icons {
            margin-top: 10px;
        }

        .social-icons a {
            margin: 0 10px;
            color: #ffc107;
            font-size: 24px;
            transition: color 0.3s;
        }

        .social-icons a:hover {
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="main">
        <div class="background-animation"></div>
        <div class="navbar">
            <div class="icon">
                <h2 class="logo">หางาน พาร์ทไทม์</h2>
            </div>
            <div class="menu">
                <ul>
                    <li><a href="#">HOME</a></li>
                    <li><a href="#">ABOUT</a></li>
                    <li><a href="#">SERVICE</a>
                        <ul>
                            <li><a href="#">Web Design</a></li>
                            <li><a href="#">SEO</a></li>
                            <li><a href="#">aaaa</a></li>
                        </ul>
                    </li>
                    <li><a href="#">เข้าสู่ระบบ</a>
                        <ul>
                            <li><a href="admin/index.php">เจ้าของร้าน</a></li>
                            <li><a href="users/index.php">คนหางาน</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="search">
                <input class="srch" type="search" name="" placeholder="เลือกงาน">
                <button class="btn">ค้นหา</button>
            </div>
        </div> 
        <div class="content">
            <h1>ยินดีต้อนรับ</h1>
            <p class="par">สามารถเลือกงานที่คุณต้องการ เเละ งานที่หน้าสนใจ เงินดีงานดี เว็บพาร์ทไทม์ที่นี้ที่เดียว</p>
            <button class="cn"><a href="users/home.php">หน้าเเรก</a></button>
        </div>
        <div class="cards-container">
            <div class="card">
                <h2>บริการ 1</h2>
                <p>รายละเอียดของบริการที่ 1</p>
            </div>
            <div class="card">
                <h2>บริการ 2</h2>
                <p>รายละเอียดของบริการที่ 2</p>
            </div>
            <div class="card">
                <h2>บริการ 3</h2>
                <p>รายละเอียดของบริการที่ 3</p>
            </div>
        </div>
        <div class="scrolling-text">Welcome to the best part-time job website!</div>
        <div class="footer">
            <p>© 2024  เว็บไซต์ หางาน พาร์ทไทม์ ตัวเมืองยะลา</p>
            <div class="social-icons">
                <a href="#"><ion-icon name="logo-facebook"></ion-icon></a>
                <a href="#"><ion-icon name="logo-twitter"></ion-icon></a>
                <a href="#"><ion-icon name="logo-instagram"></ion-icon></a>
                <a href="#"><ion-icon name="logo-linkedin"></ion-icon></a>
            </div>
        </div>
    </div>
    <script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script>
</body>
</html>
