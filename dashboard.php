<?php
    include "php/user.php";
    session_start();
    ob_start();
    if (isset($_SESSION['$idTopic']))
    {
        unset($_SESSION['status']);
        unset($_SESSION['$idTopic']);
    } 
    if (isset($_SESSION['editing']))
    {
        unset($_SESSION['editing']);
    } 
    global $name, $username;
    if (isset($_GET['act'])) {
        switch ($_GET['act']) {
            case 'signout':
                unset($_SESSION['user']);
                unset($_SESSION['name']);
                header("location: ./login.php");
                break;
            
            default:
                break;
        }
    }
    if (isset($_SESSION['user']) && isset($_SESSION['name'])) {
        $username = $_SESSION['user'];
        $name =$_SESSION['name'];
        $avatar = getAvatarUser($username);
        
    }else{
        header("location: ./index.php");
    }
    function getNumberQuest($idTopic){
        include "php/condb.php";
        $sql_select = "SELECT COUNT(*) AS `Result` FROM `quest` WHERE `idTopic` = ?";
        if ($stmt = mysqli_prepare($conn,$sql_select)) {
            mysqli_stmt_bind_param($stmt,"s",$idTopic);
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
                if (mysqli_num_rows($result)==1) {
                    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
                    return $row['Result']; 
                }
                return NULL;
            } else{
                return NULL;
            }
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - <?php echo $name?> </title>
    <link rel="stylesheet" href="/__ProjectWeb/css/animation.css">
    <link rel="stylesheet" href="/__ProjectWeb/css/dashboard.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="js/dashboard.js"></script>
    <link rel="shortcut icon" href="/__ProjectWeb/image/favicon.webp" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">

    <link rel="stylesheet"  href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="css/uiverse.css">
</head>
<body>
    <div class="volume-control">
        <button id="volume-icon" class="ri-volume-up-line">
            </button>
        <input type="range" min="0" max="1" step="0.1" value="1" id="volume-range">
    </div>

    
    <video id="bgvideo" src="video/bg_dashboard.mp4" autoplay loop></video>
    
    <div >
        <!-- MENU HERE -->
        <header>
            <a href="dashboard.php" id="logo"><img src="/__ProjectWeb/image/logo.png" alt=""></a>
    
    
            <div class="user">
                
                    <a href="create/create.php"> <span class="btn"> Thêm trò chơi</span></a>
                
                <span class="avatar">
                    <button><img src="<?php echo $avatar ?>" alt=""></button>
                    <div class="hidden-menu">
                        <a href="user_infor/update-infor.php"><i class="ri-user-3-line"></i> Trang cá nhân</a>
                        <a href="dashboard.php?act=signout"><i class="ri-logout-box-r-line"></i> Đăng Xuất</a>
                    </div>
                </span>
            </div>
        </header>

        <!-- BODY HERE -->
        <div class="body">
           
            <name-title>
                 Chào <?php echo $name?>!
             </name-title>
            <section class="render-section">
                <div id="title">
                    <button class="tab-button tab-button-active" data-for-tab = "1"><i class='bx bx-library' ></i> Những bộ câu hỏi của bạn</button>
                    <button class="tab-button " data-for-tab = "2"><i class="ri-earth-line"></i> Khám phá của mọi người</button>
                </div>
                <div  class="render-table render-table-active"  data-tab="1">

                    <table id="myTable">
                        <?php
                            include 'php/condb.php';
                            $sql = "SELECT * FROM `listtopic` WHERE `username` = '$username' ORDER BY `date` DESC";
                            if($result = mysqli_query($conn,$sql)){
                                if (mysqli_num_rows($result)>0){
                                    $norow = 1;
                                    echo "<thead style='width: 100%'>
                                    <tr>
                                        <th style = 'width: 10%'>STT</th>
                                        <th style = 'width: 40%'>Tiêu đề</th>
                                        <th style = 'width: 10%'> </th>
                                        <th style = 'width: 30%'>Miêu tả</th>
                                        <th style = 'width: 10%' > </th>
                                    </tr>
                                        </thead>";
                                    echo" <tbody style = 'text-align:center'>";
                                    while ($row = mysqli_fetch_array($result)) {
                                        echo "<tr>";
                                            echo "<td style = 'width: 10%' >" . $norow. "</td>";
                                            echo "<td style = 'width: 40%'>" .$row['titleTopic'] . "</td>";
                                            echo "<td style = 'width: 10%'>";
                                            if ($row['status'] == 0){
                                                echo "<i class=\"ri-git-repository-private-fill\" title ='Riêng tư'></i>";
                                            }else
                                            {
                                                echo "<i class=\"ri-stackshare-line\" title ='Công khai'></i> ";
                                            }
                                            echo "</td>";
                                            echo "<td style = 'width: 30%'> <i>" .$row['description'] . "</i></td>";

                                            echo "<td style = 'width: 10%'>";
                                                echo "<button class='action-btn' onlick = 'openActionMenu()'>...</button>";
                                                echo "<div class='action-menu'>";
                                                echo "<a href='view/view.php?id=".$row['idTopic']."' title = 'Play' data-toggle = 'tooltip'><i class='ri-play-circle-fill'></i>Chơi ngay</a>";
                                                echo "<a href='create/update-detail.php?idTopic=".$row['idTopic']."' title ='Edit' data-toggle = 'tooltip'><i class='ri-file-edit-fill'></i>Chỉnh sửa</a>";
                                                echo "<a href='create/delete-detail.php?idTopic=".$row['idTopic']."' title = 'Delete' data-toggle = 'tooltip'><i class='ri-delete-bin-fill'></i>Xóa</a></div></td>";
                                        echo "</tr>";   
                                        
                                        $norow++;
                                    }
                                    echo "</tbody>";
                                    mysqli_free_result($result);
                                }
                                else{
                                    echo "<p class='lead'>Hiện tại chưa có câu hỏi</p>";
                                }

                            }
                            else{
                                
                            }
                            mysqli_close($conn);
                            
                        ?>
                    </table>

                </div>
                <div  class="render-table" data-tab="2">
                    <table id="myTable">
                        <?php
                            include 'php/condb.php';
                            $sql = "SELECT * FROM `listtopic` WHERE `status` = 1  AND `username` != '$username' ORDER BY `date` DESC";
                            if($result = mysqli_query($conn,$sql)){
                                if (mysqli_num_rows($result)>0){
                                    $is_have_quest=false;
                                    $norow = 1;
                                    echo "<thead style='width: 100%'>
                                    <tr>
                                        <th style = 'width: 40%'>Trò chơi</th>
                                        <th style = 'width: 30%'>Sở hữu</th>
                                        <th style = 'width: 20%'>Miêu tả</th>
                                        <th style = 'width: 10%' >Thao tác</th>
                                    </tr>
                                        </thead>";
                                    echo" <tbody style = 'text-align:center'>";
                                    while ($row = mysqli_fetch_array($result)) {
                                        if (getNumberQuest($row['idTopic'])>=9) {
                                            $is_have_quest= true;
                                            echo "<tr>";
                                                echo "<td style = 'width: 40%'>" .$row['titleTopic'] . "</td>";
                                                echo "<td style = 'width: 30%'>".$row['username'] . "</td>";
                                                echo "<td style = 'width: 20%'><i>" .$row['description'] . "</i></td>";
    
                                                echo "<td style = 'width: 10%'>";
                                                    echo "<a href='view/view.php?id=".$row['idTopic']."' title = 'Play' data-toggle = 'tooltip'><i class='ri-play-circle-fill'></i>";
                                            echo "</tr>";
                                        }
                                    }
                                    if ($is_have_quest ==false) {
                                        echo "<tr><td><p colspan='4' class='lead'>Hiện tại chưa có câu hỏi</p></tr></td>";
                                    }
                                    echo "</tbody>";
                                    mysqli_free_result($result);
                                }
                                else{
                                    echo "<p class='lead'>Hiện tại chưa có câu hỏi</p>";
                                }
                            }
                            else{
                                
                            }
                            mysqli_close($conn);
                            
                        ?>
                    </table>

                </div>

            </section>

        </div>
    </div> 
    
</body>

</html>