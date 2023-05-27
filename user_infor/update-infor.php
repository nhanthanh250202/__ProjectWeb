<?php
    include "../php/condb.php";
    include "../php/user.php";
    session_start();
    $error_change_username = false;
    // global $username,$name,$avatar, $pr_avt;

    if (isset($_SESSION['user']) && isset($_SESSION['name'])) {
        $username = $_SESSION['user'];
        $name =$_SESSION['name'];
        $bday  = getInfor($username)['bday'];
        $image = getAvatarUser($username);
        $email = getInfor($username)['email'];
        
    }else{
        header("location: ./index.php");
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $change_avatar = true;

        $od_username = $username;
        $od_image = getInfor($username)['image'];
        $od_url  = "../user_data/image/" . $od_image;
        $name = trim($_POST["name"]);
        $username = trim($_POST["username"]);
        $bday = trim($_POST["bday"]);
        $email = trim($_POST["email"]);

        $image = $_FILES['file'];
        //Kiểm tra: CÓ HÌNH -> true; KHÔNG CÓ -> false
        $change_avatar = !empty($_FILES["file"]['name']);

        if ($change_avatar) {
            $imageName = $image['name'];
            $imageType = $image['type'];
            $imageTempName = $image['tmp_name']; 
            $fileExt = explode(".",$imageName);
            $fileActualExt = strtolower(end($fileExt));
            $allowed = array("jpg","jpeg","png");
            $imageFullname = $username . "-avt." .$fileActualExt;
            if (!in_array($fileActualExt,$allowed)) {
                echo "Vui lòng đúng định dạng hình ảnh";
                exit();
            }
        }else{
            $fileExt = explode(".",$od_image);
            $fileActualExt = strtolower(end($fileExt));
            $imageFullname = $username . "-avt." .$fileActualExt;
        }
        $fileDestination = "../user_data/image/" . $imageFullname;
        
        if (updateInfor($name,$username,$bday,$email,$imageFullname,$od_username) == 1) {
            if($username != $od_username){
                rename($od_url,$fileDestination);
            };
            if ($change_avatar) {
                if(file_exists("../user_data/image/".$username . "-avt.jpg")){
                    unlink("../user_data/image/".$username . "-avt.jpg");
                }
                if(file_exists("../user_data/image/".$username . "-avt.png")){
                    unlink("../user_data/image/".$username . "-avt.png");
                }
                if(file_exists("../user_data/image/".$username . "-avt.jpeg")){
                    unlink("../user_data/image/".$username . "-avt.jpeg");
                }
                move_uploaded_file($imageTempName,$fileDestination);
            }
            
            $_SESSION['user'] = $username;
            $_SESSION['name'] = $name;
            header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
            header("Pragma: no-cache"); // HTTP 1.0.
            header("Expires: 0");
            header("refresh:0");

        }elseif(updateInfor($name,$username,$bday,$email,$imageFullname,$od_username) == -1)
        {
           $error_change_username = true;
        }else{
            echo "lỗi update";
            exit();
        }


    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật thông tin</title>

    <link rel="stylesheet" href="/__ProjectWeb/css/register.css">
    <link rel="stylesheet" href="user-infor.css">
    <link rel="shortcut icon" href="/__ProjectWeb/image/favicon.webp" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet"  href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="/__ProjectWeb/js/register.js"></script>
    <script src="user-infor.js"></script>
</head>
<body>
    <video id="bgvideo" src="../video/bg_dashboard.mp4" muted autoplay loop ></video>
   
    <section>
        <div class="form-box" id="inforChange">
            <a class="back" href="../dashboard.php"><i class="ri-arrow-go-back-line"></i>Trở về trang chủ</a>
            <div class="form-val">
                <h2>Thông tin tài khoản</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" name="changeInfor" enctype="multipart/form-data" >
                    <div class="preview" id="image">
                        <input style="margin-top: 20px; display: none;" type="file" name="file" accept="image/*"  id="file-input" onchange="loadFile(event)">
                        <img for="file-input" id="output" src=" <?php echo $image?>">
                        <label for="file-input"><i class="ri-upload-2-line"></i> Ảnh đại diện của bạn</label>
                    </div>
                    <div class="inputbox" id="name">
                        <i class="ri-emotion-line"></i>
                        <input type="text" name="name" value="<?php echo $name ?>" required>
                        <label for="">Tên của bạn là</label>
                    </div>
                    <div class="inputbox" id="username">
                        <i class="ri-user-line"></i>
                        <input type="text" name="username" value="<?php echo $username ?>" required onchange="checkUser()">
                        <label for="">Username của bạn là</label>
                    </div>
                    <error id="username-error">Username không gồm khoảng cách và tự đặc biệt</error>
                    <div class="inputbox" id="bday">
                        <i class="ri-calendar-2-line"></i>
                        <input name="bday" placeholder=" " type ="text" value="<?php echo $bday?>" onfocus="(this.type='date')" required >
                        <label for="">Bạn sinh ngày</label>
                    </div>
                    <div class="inputbox">
                        <i class="ri-at-line"></i>  
                        <input type="email" name="email" value="<?php echo $email?>" required>
                        <label for="">Email</label>
                    </div>



                    <div class="bot-form">
                        <?php if($error_change_username) echo "<p style='color: red'>Username đã tồn tại hãy thử dùng username khác</p>" ?>
                        <button type="submit">Hoàn tất chỉnh sửa</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

</body>
</html>