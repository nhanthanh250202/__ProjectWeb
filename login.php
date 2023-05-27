<?php
    session_start();
    ob_start();
    require_once "php/condb.php";
    include "php/user.php";

    if (isset($_SESSION['user']) && isset($_SESSION['name'])) {
        header("location: ./dashboard.php");
    }

    if((isset($_POST['login'])) && ($_POST['login'])){
        $user = $_POST['user'];
        $pass = $_POST['pass'];
        
        $check = checkUser($user,$pass);
        if (checkUser($user,$pass))
        {
            $name = getInforUser($user,$pass)['name'];
            $_SESSION['user']= $user;
            $_SESSION['name']= $name;
            header("location: ./dashboard.php");
            
        }
        else
        {
            $txt_passerror = "Sai mật khẩu hoặc tài khoản";
        }
        
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập tài khoản</title>
    <link rel="stylesheet" href="/__ProjectWeb/css/login.css">
    <link rel="shortcut icon" href="/__ProjectWeb/image/favicon.webp" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet"  href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
</head>
<body>

    <video id="bgvideo" src="/__ProjectWeb/video/bg.mp4" muted autoplay loop ></video>
    
    <section>
        <div class="form-box">
            <a class="back" href="/__ProjectWeb/index.php"><i class="ri-arrow-go-back-line"></i>Trở về trang chủ</a>
            <div class="form-val">
                <form  action="<?php echo $_SERVER['PHP_SELF']; ?>"method="post" >
                    <h2>Đăng nhập tài khoản</h2>
                    <div class="inputbox">
                        <i class="ri-mail-fill"></i>
                        <input type="text" name="user" autocomplete="off" required>
                        <label for="">Username</label>
                    </div>
                    <div class="inputbox">
                        <i class="ri-key-fill"></i>
                        <input type="password" name="pass" autocomplete="off" required>
                        <label for="">Mật khẩu</label>
                    </div>
                    <p class="regist">Bạn chưa có tài khoản? Đăng kí ngay <a href="register.html"> tại đây</a></p>
                    
                    <input type="submit" name="login" value="Đăng nhập ngay">
                    <?php
                        if (isset($txt_passerror) && $txt_passerror!="") {
                            echo "<p class = 'error' style = 'color: red'; >".$txt_passerror. "</p>";
                        }
                     ?>

                </form>
                
            </div>
        </div>
    </section>
</body>
</html>