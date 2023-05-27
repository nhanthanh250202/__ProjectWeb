<?php
    include "createdb.php";
    session_start();
    global $username,$name,$idTopic,$title,$image,$image_path,$idQuest,$quest,$answer,$score,$id_edit,$url_img;
    if (isset($_GET["id"]) && $_GET["act"] == 'delete') {
        $id_delete = trim(($_GET["id"]));
        if (deleteQuest($id_delete)) {
            header("location: detail.php");
        }
        else{
            echo "Xảy ra lỗi trong quá trình XÓA";
            exit();
        }
    }

    if (isset($_GET["id"]) && $_GET["act"] == 'edit') {
        
        $id_edit = trim(($_GET["id"]));
        $_SESSION['editing']= $id_edit;
        
        $edit_row = getQuest($id_edit);
        if ($edit_row != NULL) {
            $quest = $edit_row['nameQuest'];
            $answer = $edit_row["answer"];
            $score = $edit_row["score"];
            if($edit_row['image']==""){
                $image_path = "../image/input-photo.png";
            }
            else{
                $image_path = "../user_data/quest_data/".$edit_row['idTopic']."/". $edit_row['image'];
            }
            $_SESSION['image_url']= $edit_row['image'];
            
        }
        else{
            echo "Xảy ra lỗi trong quá trình Chỉnh sửa";
            exit();
        }
    }
    if(isset($_GET["edit-topic"])){
        $editTopic = trim($_GET['edit-topic']);
        $newTitle = trim($_POST['edit-title']);
        // echo" $newTitle , $editTopic";
        // exit();
        updateTitleTopic($editTopic,$newTitle);
        $_SESSION['title'] = $newTitle;
        header("location: detail.php");
    }
    // echo "$id_edit, $quest, $answer, $url_img, $score";
    
    if (isset($_SESSION['idTopic']) && isset($_SESSION['title'])) {
        $username = $_SESSION['user'];
        $name =$_SESSION['name'];
        $idTopic = $_SESSION['idTopic'];
        $title = $_SESSION['title'];
    }else{
        echo "Xảy ra lỗi";
        exit();
    }

    // if (isset($_GET["id"]) && $_GET["act"] == 'edit') {
    //     if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //         $image = $_FILES['file'];
    //         //Kiểm tra: CÓ HÌNH -> true; KHÔNG CÓ -> false
    //         $haveImage = !empty($_FILES["file"]['name']);
    
    //         if ($haveImage) {
    //             $imageName = $image['name'];
    //             $imageType = $image['type'];
    //             $imageTempName = $image['tmp_name'];
                
                
    //             $fileExt = explode(".",$imageName);
    //             $fileActualExt = strtolower(end($fileExt));
    //             $allowed = array("jpg","jpeg","png");
    //             $imageFullname = $idQuest . "." .$fileActualExt;
    //             if (!in_array($fileActualExt,$allowed)) {
    //                 echo "Vui lòng đúng định dạng hình ảnh";
    //                 exit();
    //             }
    //         }else{
    //             $imageFullname ="";
    //         }
    
    //         $pathCreate= "../user_data/quest_data/$idTopic/";
    //         if (!file_exists($pathCreate)){
    //             mkdir($pathCreate);
    //         }
    //         $fileDestination = "$pathCreate" . $imageFullname;
            
    //         if(editQuest($id_edit, $quest,$answer,$url_img,$score)){
    //             if ($imageFullname !="") move_uploaded_file($imageTempName,$fileDestination);
    //             header("location: detail.php");
    //         }else{
    //             echo "Tạo câu hỏi không thành công, đã xảy ra lỗi";
    //             exit();
    //         };
    
    //     }

    // }else{
        if ($_SERVER["REQUEST_METHOD"] == "POST" && $_GET["edit-topic"]!= $idTopic) {

            $numrow = getNumRow('quest',"idTopic = '$idTopic'");
            $image = $_FILES['file'];
            //Kiểm tra: CÓ HÌNH -> true; KHÔNG CÓ -> false
            $haveImage = !empty($_FILES["file"]['name']);

            $idQuest = $idTopic."^Q".$numrow;



            $quest = trim($_POST["quest"]);
            $answer = trim($_POST["answer"]);
            $score = trim($_POST["score"]);
            if (isset($_SESSION['editing'])){
                $idQuest = $_SESSION['editing'];
                
            }


            if ($haveImage) {
                $imageName = $image['name'];
                $imageType = $image['type'];
                $imageTempName = $image['tmp_name'];
                
                
                $fileExt = explode(".",$imageName);
                $fileActualExt = strtolower(end($fileExt));
                $allowed = array("jpg","jpeg","png");
                $imageFullname = $idQuest . "." .$fileActualExt;
                if (!in_array($fileActualExt,$allowed)) {
                    echo "Vui lòng đúng định dạng hình ảnh";
                    exit();
                }
            }else{
                $imageFullname ="";
            }


            $pathCreate= "../user_data/quest_data/$idTopic/";
            if (!file_exists($pathCreate)){
                mkdir($pathCreate);
            }
            $fileDestination = "$pathCreate" . $imageFullname;
            

            // echo "$idQuest, $quest, $answer, $url_img, $score";

            if (isset($_SESSION['editing'])){
                if($imageFullname ==""){
                    $imageFullname = $_SESSION['image_url'];
                }
                if(editQuest($idQuest, $quest,$answer,$imageFullname,$score)){
                    move_uploaded_file($imageTempName,$fileDestination);
                    unset($_SESSION['editing']);
                    unset($_SESSION['image_url']);
                    header("location: detail.php");
                }else{
                    echo "Tạo câu hỏi không thành công, đã xảy ra lỗi";
                    exit();
                };
            }
            else{
                if(createQuest($idTopic,$idQuest,$quest,$answer,$imageFullname,$score)){
                    move_uploaded_file($imageTempName,$fileDestination);
                    header("location: detail.php");
                }else{
                    echo "Tạo câu hỏi không thành công, đã xảy ra lỗi";
                    exit();
                };
            }

    
        }
    // }




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../image/favicon.webp" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="script.js"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="detail.css">
    <link rel="stylesheet" href="ui.css">
    <title>Topic: <?php echo $title ?></title>
</head>
<body>

    <div class="heading">
        <a href="../dashboard.php"><i class="ri-arrow-go-back-line"></i>  Quay lại trang chủ</a>
        <div class="loader">
            <span>TOPIC</span>
            <span>TOPIC</span>
        </div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?edit-topic=" .$idTopic; ?>" method="POST">
            <input type="text"  name="edit-title" value="<?php echo $title; ?>">
            <input id="edit-topic" type="submit" value="Lưu">
        </form>
    </div>
    <div class="ready">
        <a id="play" href="../view/view.php?id=<?php echo $idTopic ?>">
            <button class="cta">
                <span>Chuẩn bị</span>
                <svg viewBox="0 0 13 10" height="10px" width="15px">
                    <path d="M1,5 L11,5"></path>
                    <polyline points="8 1 12 5 8 9"></polyline>
                </svg>
            </button> 
        </a>
    </div>
    <div class="grid-container">
        <div class="question body-detail">   
            <div class="form-box">
                <div class="form-val">
                    <form class="detail-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data" method="post" >
                        <div class="preview">
                            <div class="card">
                                <div class="first-content">
                                    <img id="output" src="<?php if(isset($_SESSION['editing'])) {
                                        echo $image_path;
                                        } else {echo "../image/input-photo.png";} ?>" >
                                </div>
                                <div class="second-content">
                                    <label for="file-input" id="">
                                        <img src="../image/input-photo.png" alt="">
                                    </label>
                                </div>
                            </div>


                            <!-- <label for="">Ảnh miêu tả</label> -->
                            <input style="display:none" type="file" id="file-input" accept="image/png, image/jpg, image/jpeg" name="file" onchange="loadFile(event)" >

                        </div>

                        <div>
                            <div class="form-group">
                                <label for=""><i class="ri-question-mark"></i> Câu hỏi</label>
                                <input  class="input-detail" placeholder="Nội dung Câu hỏi"  type="text" name="quest" value="<?php echo $quest; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for=""><i class="ri-reply-fill"></i> Câu trả lời</label>
                                <input class="input-detail" placeholder="Câu trả lời"  type="text" name= "answer"  value="<?php echo $answer; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for=""><i class="ri-numbers-fill"></i> Số điểm:</label>
                                <select class="input-detail" style="height: 40px; width: 50%"  name="score" id="">
                                    <option value="10">--Chọn số điểm--</option>
                                    <option value="5" <?php if (isset($score) && $score == '5') echo "selected=\"selected\"";?> >5 điểm</option>
                                    <option value="10" <?php if (isset($score) && $score == '10') echo "selected=\"selected\"";?> >10 điểm</option>
                                    <option value="15" <?php if (isset($score) && $score == '15') echo "selected=\"selected\"";?> >15 điểm</option>
                                    <option value="20" <?php if (isset($score) && $score == '20') echo "selected=\"selected\"";?> >20 điểm</option>
                                </select>
                            </div>
                        </div>

                        <input style="display: none;"  id="reset-btn" type="reset" value="Hủy">
                        <!-- <a id="reload" href="detail.php"></a> -->
                        <input style="display: none;" id="submit-question" type="submit" value="Lưu">

                    </form>

                    <div class="button-form">
                        <button class="button-detail">
                            <label for="submit-question"><?php if(isset($_SESSION['editing'])) {echo "Hoàn tất chỉnh sửa";} else {echo "Thêm câu hỏi";} ?></label>
                        </button>
                        <button class="reset-detail">
                            <label for="reset-btn"><i class="ri-refresh-line"></i></label>
                        </button>
                    </div>
                </div>
            </div>
        </div>
            
        <div class="render-section">
            <div class="render-table" >
                <table id="myTable" style="text-align: center">
                        <?php
                            include '../php/condb.php';
                            $sql = "SELECT `idQuest`, `nameQuest`, `answer`, `score`FROM `quest` WHERE `idTopic` = '$idTopic'ORDER BY `date-create` ASC";
                            echo "<thead style = 'width: 100%'>
                            <tr>
                                <th style = 'width: 10%'>STT</th>
                                <th style = 'width: 30%'>Câu hỏi</th>
                                <th style = 'width: 30%'>Đáp án</th>
                                <th style = 'width: 10%'>Số điểm</th>
                                <th style = 'width: 20%'>Thao tác</th>
                            </tr>
                                </thead>";
                            echo" <tbody>";
                            if($result = mysqli_query($conn,$sql)){
                                if (mysqli_num_rows($result)>0){
                                    $norow = 1;

                                    while ($row = mysqli_fetch_array($result)) {

                            

                                        echo "<tr>";
                                            echo "<td style = 'width: 10%'>" . $norow. "</td>";
                                            echo "<td style = 'width: 30%'>" .$row['nameQuest'] . "</td>";
                                            echo "<td style = 'width: 30%'>" .$row['answer'] . "</td>";
                                            echo "<td style = 'width: 10%'>" .$row['score'] . "</td>";
                                            echo "<td style = 'width: 20%'>";
                                                echo "<a href='detail.php?act=edit&id=".$row['idQuest']."' title ='Edit' data-toggle = 'tooltip'><i class='ri-pencil-fill'></i></a>";
                                                echo "<i style=' color: transparent' class='ri-space'></i>";
                                                echo "<a href='detail.php?act=delete&id=".$row['idQuest']."' title = 'Delete' data-toggle = 'tooltip'><i class='ri-delete-back-2-line'></i></a> </td>";
                                        echo "</tr>";
                                        
                                        $norow++;
                                    }
                                    echo "</tbody>";
                                    mysqli_free_result($result);
                                }
                                else{
                                    echo "<tr>";
                                    echo "<td colspan='4' style='text-align:center' class='lead'>Hiện tại chưa có câu hỏi</td>";
                                    echo "</tr>";
                                }
                            }
                            echo "</tbody>";
                            mysqli_close($conn);
                            
                        ?>
                </table>
            </div>
        </div>
    </div>


</body>
</html>