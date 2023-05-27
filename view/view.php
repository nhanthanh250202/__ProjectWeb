<?php
    include "../php/condb.php";
    include "viewdb.php";
    session_start();
    global $idTopic;

    if(isset($_GET["id"])){
        $idTopic = $_GET["id"];
        $_SESSION["idTopic"]= $idTopic;
        $statusTopic = getTopic($idTopic)['status'];
        $title = getTopic($idTopic)['titleTopic'];
        $creator = getTopic($idTopic)['username'];
        $viewer = $_SESSION['user'];
        if ($statusTopic == 0 && ($viewer != $creator) )
        {
            header("location: ../dashboard.php");
        }
        
        
    }
    else
    {
        header("location: ../dashboard.php");
    }

    // if (!isset($_SESSION["idTopic"])) {
    // }else{
    //     $idTopic = $_GET["id"];
    // }
    $amountquest = numberQuest($idTopic);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.0.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="shortcut icon" href="../image/favicon.webp" type="image/x-icon">
    <title><?php echo $title?></title>
    <link rel="stylesheet" href="view-animation.css">
    <link rel="stylesheet" href="view.css">
    <link rel="stylesheet" href="uiverse.css">
    <script src="view.js"></script>
</head>
<body>
    <div class="volume-control">
        <button id="volume-icon" class="ri-volume-up-line">
            </button>
        <input type="range" min="0" max="1" step="0.1" value="1" id="volume-range">
    </div>
    <audio id="bgm" autoplay loop >
        <source src="../audio/view-bgm.mp3" type="audio/mpeg">
    </audio>
    <header>
        <a href="../dashboard.php" id="logo"><img src="/__ProjectWeb/image/logo.png" alt=""></a>
        <a id="back" href="../create/update-detail.php?idTopic=<?php echo $idTopic ?>"><i class="ri-arrow-go-back-fill"></i>Quay trở lại</a>
    </header>
    
    
    <div class="heading">
        <h1><?php echo $title?></h1>
    </div>

    
    
    <div id="setting-block" class="setting-block" data-role="rangeslider">
        
        <img id="corgi1" src="../image/view/corgi1.gif" alt="">
        <div class="first-block">
            <label for=""><i class="ri-question-answer-fill"></i>Số câu hỏi: </label>
            <br>
            <label id="output-slider" for="">9</label>
            <br>
            <input type="range" name="num-grid" class="num-grid" id="num-grid" value="9" min="9" max="<?php echo numberQuest($idTopic) ?>" required>
            <br>
            <label for=""><i class="ri-group-line"></i>Số đội tham gia</label>
            <br>
            <input type="number" name="team-input" id="team-input" onchange="createNumTeams()" required >
            <!-- <button id="name-set" onclick="createNumTeams()">Đặt tên</button> -->
            <p id="errorNum" class="error">Số đội tham gia phải từ 2 trở lên</p>
        </div>
        <div class="second-block">
            <h1 ><i class="ri-sparkling-fill"></i>Các đội chơi</h1>
            <p style="font-weight: normal;">Hiện tại chưa có đội</p>
            <div id="teams">
                <p></p>
            </div>
            <p id="errorRange" class="error">Số câu hỏi phải từ 2 trở lên</p>
            <br>
        </div>

    </div>
    <?php
        if (numberQuest($idTopic)<9) {
            echo "<p id = 'numquest-erro'><i class='ri-error-warning-fill'></i> Số câu hỏi phải lớn hơn 9 để có thể bắt đầu <br><a href='../create/update-detail.php?idTopic=$idTopic'>OK</a></p>";
        }else{
            echo '<div class="start">
            <button class="start-btn" onclick="createGame()">
                <div class="button__line"></div>
                <div class="button__line"></div>
                <span class="button__text">BẮT ĐẦU!!!</span>
                <div class="button__drow1"></div>
                <div class="button__drow2"></div>
            </button>  
        </div>';

        }
    ?>

    <section style="display: none;" class="second-section">
        <div id="score-display" class="score-display">
            <p></p>
        </div>
        <img id="corgi2" src="../image/view/corgi2.gif" alt="" srcset="">
        <div id="grid-btn" class="grid-btn">
            <p></p>
        </div>
        <div id="quest-display" class="quest-display" >
        </div>
        <div id="winner" class="myCard">
            <div id="teamwin" class="innerCard">
                <div class="frontSide">
                    <p class="title">Đội chiến thắng <br>chính là...</p>
                </div>
                <div class="backSide">
    
                </div>
            </div>
        </div>
    </section>

    <!-- <div id="winner" class="winner" > -->
        <!-- <div class='backdrop'></div> -->
        <!-- <div id="teamwin" class="teamwin">
            <h1>
                Xin chúc mừng!
            </h1>
            <div>
                                    
            </div>
        </div>
    </div> -->


</body>
</html>