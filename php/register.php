<?php
    require "condb.php";
    
    $image = $_FILES['file'];
    $name = $_POST['name'];     
    $username = $_POST['username'];     
    $gender = $_POST['gender'];     
    $bday = $_POST['bday'];     
    $email = $_POST['email'];     
    $password = $_POST['password'];  


    $imageName = $image['name'];
    $imageType = $image['type'];
    $imageTempName = $image['tmp_name'];

    $fileExt = explode(".",$imageName);
    $fileActualExt = strtolower(end($fileExt));
    $allowed = array("jpg","jpeg","png");
    $fileDestination = "";
    if (in_array($fileActualExt,$allowed)) {
        $imageFullname = $username .  "-avt" . "." .$fileActualExt;
        $fileDestination = "../user_data/image/" . $imageFullname;
    }

    $sql = "INSERT INTO `account`(`name`, `username`, `gender`, `bday`, `email`, `password`,`image`) VALUES (?,?,?,?,?,?,?)";
    if ($stmt = mysqli_prepare($conn,$sql)) {
        mysqli_stmt_bind_param ($stmt,"sssssss",$name,$username,$gender,$bday,$email,$password,$imageFullname);
        if (mysqli_stmt_execute($stmt)) {
            move_uploaded_file($imageTempName,$fileDestination);
            echo "<div class='alert'>
            <h3>Đăng kí tài khoản thành công<br><br>
            <a href='../login.php'>Ok</a></h3>
            </div>";
        } else{
            if (mysqli_errno($conn) == 1062)
            {
                echo "<div class='alert'>
                    <h3>Username đã tồn tại <br> Vui lòng thử đặt username khác<br><br>
                    <a href='../register.html'>Ok</a></h3>
                </div>";
            }else{
                echo "Xảy ra lỗi vui lòng thử lại";
            } 
        }
        mysqli_stmt_close($stmt);

    }
    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/register.css">
    <title>Đăng kí tài khoản</title>
</head>
<body>
    
</body>
</html>