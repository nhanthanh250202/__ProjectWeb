<?php
    include "createdb.php";
    session_start();
    
    global $username,$name;
    if (isset($_SESSION['user']) && isset($_SESSION['name'])) {
        $username = $_SESSION['user'];
        $name =$_SESSION['name'];

    }else{
        echo "Xảy ra lỗi";
        exit();
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $image = $_FILES['file'];
        $title = trim($_POST["title"]);
        $descr = trim($_POST["descr"]);
        $status = trim($_POST["status"]);
        $imageName = $image['name'];
        $imageType = $image['type'];
        $imageTempName = $image['tmp_name'];
    
        $fileExt = explode(".",$imageName);
        $fileActualExt = strtolower(end($fileExt));
        $allowed = array("jpg","jpeg","png");
    
        if (in_array($fileActualExt,$allowed)) {
            $imageFullname = $username .  "-avt" . "." .$fileActualExt;
            $fileDestination = "../user_data/image/" . $imageFullname;
        } else{
            echo "Vui lòng chọn đúng định dạng hình ảnh";
        }
        
        
        $idTopic = $username."-". time();
        if(createTopic($username,$idTopic,$title,$status,$descr)){
            $_SESSION['idTopic'] = $idTopic;
            $_SESSION['title']=$title;
            header("location: detail.php");
        }else{
            echo "Tạo không thành công, đã xảy ra lỗi";
            exit();
        };
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo mới - <?php echo $name ?></title>
    <link rel="shortcut icon" href="../image/favicon.webp" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet"  href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="shortcut icon" href="../image/favicon.webp" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    
</head>
<body>
    <div class="header finisher-header">

    </div>

    <section class="body">
        <div class="form-box">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <h1>Tạo trò chơi</h1>
                <div class="input-group">
                    <label for="myInput" class="label form-group">
                        <span class="label-title"> <require>*</require> Bạn muốn đặt Tên trò chơi là</span>
                        <input id="myInput" class="input" name="title" autocomplete="off" placeholder="" type="text" required>
                    </label>
                    <label  for="myInput" class="label form-group">
                        <span class="label-title">Miêu tả trò chơi</span>
                        <input id="myInput" class="input" name= "descr" autocomplete="off" placeholder="" type="text">
                    </label>



                    <label for="myInput" class="label form-group" style="margin-bottom: 10px;">
                        <div class="label-title">Bạn có muốn <b>CÔNG KHAI</b> không?</div>
                    </label>
                    <div class="container" >
                        <div class="radio-wrapper">
                            <input class="input-radio" name="status" id="value-1" type="radio" checked="checked" value="0">
                            <div class="btn">
                            <span aria-hidden="">_</span>Không<i class="ri-git-repository-private-fill"></i>;
                            <span class="btn__glitch" aria-hidden="">Riêng_tư<i class="ri-git-repository-private-fill"></i></span>
                            <label for="value-1" class="number">private</label>
                            </div>
                        </div>
                        <div class="radio-wrapper">
                            <input class="input-radio" name="status" id="value-2"  type="radio" value="1">
                            <div class="btn">
                            <span aria-hidden="">Đồng_ý<i class="ri-stackshare-line"></i></span>
                            <span class="btn__glitch" aria-hidden="">Công_khai<i class="ri-stackshare-line"></i></span>
                            <label for="value-2" class="number">public</label>
                            </div>
                        </div>
                    </div>

                </div>


                
                <div class="submit-button" style="margin-top: 50px;">

                    <div class="btn-conteiner">

                        <label for="submit-btn" class="btn-content" >
                            <span for = "submit-btn" class="btn-title" style="font-family: Geomanist;">Tiếp tục</span>
                            <span class="icon-arrow">
                            <svg width="66px" height="43px" viewBox="0 0 66 43" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <g id="arrow" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <path id="arrow-icon-one" d="M40.1543933,3.89485454 L43.9763149,0.139296592 C44.1708311,-0.0518420739 44.4826329,-0.0518571125 44.6771675,0.139262789 L65.6916134,20.7848311 C66.0855801,21.1718824 66.0911863,21.8050225 65.704135,22.1989893 C65.7000188,22.2031791 65.6958657,22.2073326 65.6916762,22.2114492 L44.677098,42.8607841 C44.4825957,43.0519059 44.1708242,43.0519358 43.9762853,42.8608513 L40.1545186,39.1069479 C39.9575152,38.9134427 39.9546793,38.5968729 40.1481845,38.3998695 C40.1502893,38.3977268 40.1524132,38.395603 40.1545562,38.3934985 L56.9937789,21.8567812 C57.1908028,21.6632968 57.193672,21.3467273 57.0001876,21.1497035 C56.9980647,21.1475418 56.9959223,21.1453995 56.9937605,21.1432767 L40.1545208,4.60825197 C39.9574869,4.41477773 39.9546013,4.09820839 40.1480756,3.90117456 C40.1501626,3.89904911 40.1522686,3.89694235 40.1543933,3.89485454 Z" fill="#FFFFFF"></path>
                                <path id="arrow-icon-two" d="M20.1543933,3.89485454 L23.9763149,0.139296592 C24.1708311,-0.0518420739 24.4826329,-0.0518571125 24.6771675,0.139262789 L45.6916134,20.7848311 C46.0855801,21.1718824 46.0911863,21.8050225 45.704135,22.1989893 C45.7000188,22.2031791 45.6958657,22.2073326 45.6916762,22.2114492 L24.677098,42.8607841 C24.4825957,43.0519059 24.1708242,43.0519358 23.9762853,42.8608513 L20.1545186,39.1069479 C19.9575152,38.9134427 19.9546793,38.5968729 20.1481845,38.3998695 C20.1502893,38.3977268 20.1524132,38.395603 20.1545562,38.3934985 L36.9937789,21.8567812 C37.1908028,21.6632968 37.193672,21.3467273 37.0001876,21.1497035 C36.9980647,21.1475418 36.9959223,21.1453995 36.9937605,21.1432767 L20.1545208,4.60825197 C19.9574869,4.41477773 19.9546013,4.09820839 20.1480756,3.90117456 C20.1501626,3.89904911 20.1522686,3.89694235 20.1543933,3.89485454 Z" fill="#FFFFFF"></path>
                                <path id="arrow-icon-three" d="M0.154393339,3.89485454 L3.97631488,0.139296592 C4.17083111,-0.0518420739 4.48263286,-0.0518571125 4.67716753,0.139262789 L25.6916134,20.7848311 C26.0855801,21.1718824 26.0911863,21.8050225 25.704135,22.1989893 C25.7000188,22.2031791 25.6958657,22.2073326 25.6916762,22.2114492 L4.67709797,42.8607841 C4.48259567,43.0519059 4.17082418,43.0519358 3.97628526,42.8608513 L0.154518591,39.1069479 C-0.0424848215,38.9134427 -0.0453206733,38.5968729 0.148184538,38.3998695 C0.150289256,38.3977268 0.152413239,38.395603 0.154556228,38.3934985 L16.9937789,21.8567812 C17.1908028,21.6632968 17.193672,21.3467273 17.0001876,21.1497035 C16.9980647,21.1475418 16.9959223,21.1453995 16.9937605,21.1432767 L0.15452076,4.60825197 C-0.0425130651,4.41477773 -0.0453986756,4.09820839 0.148075568,3.90117456 C0.150162624,3.89904911 0.152268631,3.89694235 0.154393339,3.89485454 Z" fill="#FFFFFF"></path>
                                </g>
                            </svg>
                            </span> 
                        </label>
                    </div>
                    <input style="display: none;" id="submit-btn" type="submit" value="Đồng ý">
                    
                </div>

            </form>
                
            <a class="cancel-btn" href="../dashboard.php">
                    <button class="tooltip" style="margin-right: 50px;">
                    <i class="ri-arrow-go-back-line"></i>
                    <!-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20" height="25" width="25">
                            <path fill="#6361D9" d="M8.78842 5.03866C8.86656 4.96052 8.97254 4.91663 9.08305 4.91663H11.4164C11.5269 4.91663 11.6329 4.96052 11.711 5.03866C11.7892 5.11681 11.833 5.22279 11.833 5.33329V5.74939H8.66638V5.33329C8.66638 5.22279 8.71028 5.11681 8.78842 5.03866ZM7.16638 5.74939V5.33329C7.16638 4.82496 7.36832 4.33745 7.72776 3.978C8.08721 3.61856 8.57472 3.41663 9.08305 3.41663H11.4164C11.9247 3.41663 12.4122 3.61856 12.7717 3.978C13.1311 4.33745 13.333 4.82496 13.333 5.33329V5.74939H15.5C15.9142 5.74939 16.25 6.08518 16.25 6.49939C16.25 6.9136 15.9142 7.24939 15.5 7.24939H15.0105L14.2492 14.7095C14.2382 15.2023 14.0377 15.6726 13.6883 16.0219C13.3289 16.3814 12.8414 16.5833 12.333 16.5833H8.16638C7.65805 16.5833 7.17054 16.3814 6.81109 16.0219C6.46176 15.6726 6.2612 15.2023 6.25019 14.7095L5.48896 7.24939H5C4.58579 7.24939 4.25 6.9136 4.25 6.49939C4.25 6.08518 4.58579 5.74939 5 5.74939H6.16667H7.16638ZM7.91638 7.24996H12.583H13.5026L12.7536 14.5905C12.751 14.6158 12.7497 14.6412 12.7497 14.6666C12.7497 14.7771 12.7058 14.8831 12.6277 14.9613C12.5495 15.0394 12.4436 15.0833 12.333 15.0833H8.16638C8.05588 15.0833 7.94989 15.0394 7.87175 14.9613C7.79361 14.8831 7.74972 14.7771 7.74972 14.6666C7.74972 14.6412 7.74842 14.6158 7.74584 14.5905L6.99681 7.24996H7.91638Z" clip-rule="evenodd" fill-rule="evenodd"></path>
                        </svg>   -->
                        <span class="tooltiptext">Quay lại trang chủ</span>
                    </button>
                </a>

           
        </div>
    </section>
    <script>
        new FinisherHeader({
            "count": 7,
            "size": {
            "min": 86,
            "max": 222,
            "pulse": 0.1
            },
            "speed": {
            "x": {
                "min": 0,
                "max": 0.7
            },
            "y": {
                "min": 0,
                "max": 1.9
            }
            },
            "colors": {
            "background": "#46d0ca",
            "particles": [
                "#ffffff",
                "#87ddfe",
                "#8481ff"
            ]
            },
            "blending": "screen",
            "opacity": {
            "center": 0.45,
            "edge": 0.45
            },
            "skew": 0,
            "shapes": [
            "c"
            ]
            });
    </script>

</body>
</html>
