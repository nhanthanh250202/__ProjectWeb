<?php
    if(isset($_POST['number_quest'])){
        session_start();
        include "../php/condb.php";
        $key = $_POST['number_quest'];
        $sql_select = "SELECT * FROM `quest` WHERE `idQuest` = ?";
        $idQuest  = $_SESSION['idTopic']."^Q".$key;
        if ($stmt = mysqli_prepare($conn,$sql_select)) {
            mysqli_stmt_bind_param($stmt,"s",$idQuest);
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
                if (mysqli_num_rows($result)==1) {
                    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
                    echo "<div class='backdrop'></div>";
                    echo "<div class= 'content-quest'>";
                    echo "<h id='heading-quest'>Câu hỏi của bạn</h>";
                    echo "<img id='corgi3' src='../image/view/corgi3.gif' >";
                    if($row['image'] != ""){
                        $imageQuest = "../user_data/quest_data/". $_SESSION['idTopic'] . "/" . $row['image'];
                        echo"<img src='$imageQuest'>";
                    }
                    echo "<div id = 'question-sec'>";
                    echo "<p id='current-score'>" . $row['score']."</p>";
                    echo "<h1>" . $row['nameQuest']."</h1>";
                    echo "<button id='result-btn-show' onclick='showResult()'>Đáp án</button>";
                    
                    echo "</div>";
                    echo "<div class='result' style='display:none'>
                    <p>Đáp án</p>
                    <h2>" . $row['answer']."</h2>
                    <button style='display:none' id='true-btn' onclick='scoreRecord(true)' >Đúng</button>
                    <button style='display:none' id='false-btn' onclick='scoreRecord(false)'>Sai</button>
                    <label id='true' for='true-btn'><i class='ri-check-fill'></i></label>
                    <label id='false' for='false-btn'><i class='ri-close-fill'></i></label>
                    </div>";
                    echo "</div>";
                }
                
            } else{
                echo "Xảy ra lỗi";
                exit();
            }
        }
    }
    function getTopic($idTopic){
        include "../php/condb.php";
        $sql_select = "SELECT * FROM `listtopic` WHERE idTopic = ?";
        if ($stmt = mysqli_prepare($conn,$sql_select)) {
            mysqli_stmt_bind_param($stmt,"s",$idTopic);
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
                if (mysqli_num_rows($result)==1) {
                    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
                    return $row; 
                }
                return NULL;
            } else{
                return NULL;
            }
        }
    }
    function numberQuest($idTopic){
        include "../php/condb.php";
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