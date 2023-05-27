<?php
    include "createdb.php";
    include "../php/condb.php";
    session_start();



    if (isset($_POST["idTopic"])&& !empty($_POST["idTopic"])) {
        $sql = "DELETE FROM `listtopic` WHERE `idTopic` = ?";

        if ($stmt = mysqli_prepare($conn,$sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_id);

            $param_id = trim($_POST["idTopic"]);

            if (mysqli_stmt_execute($stmt)) {
                if(deleteFolderTopic($param_id)){
                    header ("location: ../dashboard.php");
                }else{
                    echo "Xảy ra lỗi lúc xóa folder";
                    exit();
                }
            }
            else{
                echo "Đã xảy ra lỗi vui lòng thử lại sau!";
                exit();
            }
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
    if (isset($_GET["idTopic"]) && !empty(trim($_GET["idTopic"] ))){
        
        //Get URL
        $id = trim(($_GET["idTopic"]));

        // Prepare stament

        $sql = "SELECT * FROM `listtopic` WHERE `idTopic` = ?";

        if ($stmt = mysqli_prepare($conn,$sql)) {

            mysqli_stmt_bind_param($stmt,"s",$para_id);
            $para_id = $id;

            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result)==1) {
                    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);

                    if($row['username'] != $_SESSION['user'])
                    {
                        header("location: ../dashboard.php ");
                    }
                    else{
                        $title = $row["titleTopic"];
                    }
                } else {
                    echo "Đã xảy ra lỗi";
                    exit();
                }
                
            }else{
                echo "Oopss! đã xảy ra lỗi";
                
                exit();
            }
        }
        mysqli_stmt_close($stmt);

        mysqli_close($conn);

    }else {
        echo "Có lỗi";
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="script.js"></script>
    <link rel="stylesheet" href="detail.css">
    <link rel="stylesheet" href="style.css">
    <title>Topic: <?php echo $title ?></title>
</head>
<body>
    <section class="delform">
        <form class="delbox" method = "POST">
                <input type="hidden" name="idTopic" value="<?php echo trim($_GET["idTopic"]); ?>" >
                <h1>XÓA BỘ CÂU HỎI</h1>
                <h2> <?php echo  $title; 
                echo "?" ?></h2>

                <div style="margin-top:10%; display:flex; width: 17vw; justify-content: space-around;">
                    <input style="display: none;" id="delbtn" type="submit" value="">
                    <label for="delbtn"><i class='ri-check-fill'></i>Xác nhận xóa</label>
                    <label style="background-color: #91ff42e8;"><a href="../dashboard.php"><i class="ri-close-fill"></i> Hủy</a></label>
                </div>
            </div>
        </form>
    </section>


</body>
</html>