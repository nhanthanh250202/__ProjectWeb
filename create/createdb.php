<?php
    function createTopic($user,$idtopic,$title,$status,$descr){
        include "../php/condb.php";
        $sql = "INSERT INTO `listtopic`(`username`, `idTopic`, `titleTopic`, `status`, `description`) VALUES (?,?,?,?,?)" ;
        if ($stmt = mysqli_prepare($conn,$sql)) {
            mysqli_stmt_bind_param($stmt,"sssss",$user,$idtopic,$title,$status,$descr);
            if (mysqli_stmt_execute($stmt)) {
                return true;
            } else{
                return false;
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

    function deleteFolderTopic($idTopic){
        $path_folder = "../user_data/quest_data/".$idTopic;
        if (file_exists($path_folder)) {
            array_map('unlink', glob("$path_folder/*.*"));
            if(!rmdir($path_folder)) {
                return false;
            }else{
                return true;
            }
        }else{
            return true;
        }

    }
    
    function updateTitleTopic($idtopic,$title){
        include "../php/condb.php";
        $sql = "UPDATE `listtopic` SET `titleTopic`= ? WHERE `idTopic` = ?" ;
        if ($stmt = mysqli_prepare($conn,$sql)) {
            mysqli_stmt_bind_param($stmt,"ss",$title,$idtopic);
            if (mysqli_stmt_execute($stmt)) {
                return true;
            } else{
                return false;
            }
        }
    }


    function updateStatusTopic($idtopic,$status){
        include "../php/condb.php";
        $sql = "UPDATE `listtopic` SET `status`= ? WHERE `idTopic` = ?" ;
        if ($stmt = mysqli_prepare($conn,$sql)) {
            mysqli_stmt_bind_param($stmt,"is",$status,$idtopic);
            if (mysqli_stmt_execute($stmt)) {
                return true;
            } else{
                return false;
            }
        }
    }
    
    function updateTimeTopic($idtopic){
        include "../php/condb.php";
        $sql = "UPDATE `listtopic` SET `date`=? WHERE `idTopic` = ?" ;
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = date('Y-m-d H:i:s');
        if ($stmt = mysqli_prepare($conn,$sql)) {
            mysqli_stmt_bind_param($stmt,"ss",$date,$idtopic);
            if (mysqli_stmt_execute($stmt)) {
                return true;
            } else{
                return false;
            }
        }
    }


    // @ $condition ghi trong ngoặc kép ví dụ: getNumRow('quest',"idTopic = '$idTopic'")
    function getNumRow($table,$condition){
    
        include "../php/condb.php";
        $sql = "SELECT * FROM $table WHERE $condition" ;
        if ($stmt = mysqli_prepare($conn,$sql)) {
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
                $row = mysqli_num_rows($result);
                return $row+1;
            } else{
                return -1;
            }
        }
    }

    function createQuest($idtopic,$idquest,$quest,$answer,$image,$score){
        include "../php/condb.php";
        $sql = "INSERT INTO `quest`(`idTopic`, `idQuest`, `nameQuest`, `answer`, `image`,`score`) VALUES (?,?,?,?,?,?)" ;
        if ($stmt = mysqli_prepare($conn,$sql)) {
            mysqli_stmt_bind_param($stmt,"sssssi",$idtopic,$idquest,$quest,$answer,$image,$score);
            if (mysqli_stmt_execute($stmt)) {
                return true;
            } else{
                return false;
            }
        }
    }

    function getQuest($idquest){
        include "../php/condb.php";
        $sql_select = "SELECT * FROM `quest` WHERE idQuest = ?";
        if ($stmt = mysqli_prepare($conn,$sql_select)) {
            mysqli_stmt_bind_param($stmt,"s",$idquest);
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

    function deleteQuest($idquest){
        include "../php/condb.php";
        $sql_select = "SELECT `idTopic`,`image` FROM `quest` WHERE idQuest = ?";
        if ($stmt = mysqli_prepare($conn,$sql_select)) {
            mysqli_stmt_bind_param($stmt,"s",$idquest);
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
                if (mysqli_num_rows($result)==1) {
                    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
                    if ($row["image"] !="") {
                        $path_file = "../user_data/quest_data/".$row['idTopic']."/". $row["image"];
                        if (file_exists($path_file)) {
                            if(!unlink($path_file)){
                                return false;
                            }
                        }
                    }
                }
                $sql = "DELETE FROM `quest` WHERE idQuest= ? " ;
                if ($stmt = mysqli_prepare($conn,$sql)) {
                    mysqli_stmt_bind_param($stmt,"s",$idquest);
                    if (mysqli_stmt_execute($stmt)) {
                        return true;
                    } else{
                        return false;
                    }
                }
            } else{
                return false;
            }
        }
    }

    function editQuest($idquest,$quest,$answer,$image,$score){
        include "../php/condb.php";
        $sql = "UPDATE `quest` SET `nameQuest`=?,`answer`=?,`score`=?,`image`=? WHERE `idQuest`=?" ;
        if ($stmt = mysqli_prepare($conn,$sql)) {
            mysqli_stmt_bind_param($stmt,"ssiss",$quest,$answer,$score,$image,$idquest);
            if (mysqli_stmt_execute($stmt)) {
                return true;
            } else{
                return false;
            }
        }
    }
?>