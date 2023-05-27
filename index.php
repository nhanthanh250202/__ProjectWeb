<?php
    session_start();
    ob_start();
    require_once "php/condb.php";
    include "php/user.php";

    if (isset($_SESSION['user']) && isset($_SESSION['name'])) {
        header("location: ./dashboard.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhóm 9 - Công cụ hỗ trợ dạy học</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="shortcut icon" href="image/favicon.webp" type="image/x-icon">
    
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet"  href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
</head>
<body>
    <video id="bgvideo" src="video/bg_index.mp4" autoplay loop ></video>
    <header>
        <a href="index.php" id="logo"><img src="image/logo.png" alt=""></a>

        <ul class="navbar">
            <li><a href="index.php" class="active">Trang chủ</a></li>
            <li><a href="about.html">Về chúng tôi</a></li>
        </ul>

        <div class="user">
            <span id="code">
                <a href="register.html"><i class="ri-door-lock-box-fill" style="margin-right: 10px;"></i>Đăng ký ngay</a>
            </span>
            <span id="login">
                <a href="login.php"></i>Đăng nhập</a>
            </span>
        </div>
    </header>
    

    <div id="first_title">
        <h2>Chào mừng bạn đã đến với</h2>
        <h1>pandacotta</h1>
        <p>Hướng tới việc chuyển đổi số trong dạy và học</p>
        <h3>
            Chúng tôi mong muốn mang đến cho người học và người dạy những trải nghiệm mới mẻ và hữu ích nhất.
        </h3>
    </div>
    <!-- <div class="registbtn">
        <a  href="register.html" >Đăng ký tài khoản ngay<i class="ri-arrow-right-line" style="margin-left: 10px;"></i></a>
    </div> -->
</body>
</html>