<?php
    function checkUser($user, $pass){
        include "condb.php";

        $sql = "SELECT * FROM `account` WHERE `username` = '$user' AND `password` = '$pass'" ;
        $query = mysqli_query($conn,$sql);
        $num = mysqli_num_rows($query);
        if ($num > 0){
            return true;
        }
        else{
            return false;

        }
    }

    function getInforUser($user, $pass){
        include "condb.php";

        $sql = "SELECT * FROM `account` WHERE `username` = '$user' AND `password` = '$pass'" ;
        $query = mysqli_query($conn,$sql);
        $num = mysqli_num_rows($query);
        if ($num > 0){
            $row = mysqli_fetch_array($query,MYSQLI_ASSOC);
            return $row;
        }
        else{
            return false;
        }
    }
    function getInfor($user){
        include "condb.php";

        $sql = "SELECT * FROM `account` WHERE `username` = '$user'" ;
        $query = mysqli_query($conn,$sql);
        $num = mysqli_num_rows($query);
        if ($num > 0){
            $row = mysqli_fetch_array($query,MYSQLI_ASSOC);
            return $row;
        }
        else{
            return false;
        }
    }
    function updateInfor($name, $username, $bday, $email, $avatar,$od_user){
        include "condb.php";

        $sql = "UPDATE `account` SET `name`=?,`username`=?,`bday`=?,`email`=?,`image`=? WHERE username = ?" ;
        if ($stmt = mysqli_prepare($conn,$sql)) {
            mysqli_stmt_bind_param ($stmt,"ssssss",$name,$username,$bday,$email,$avatar,$od_user);
            if (mysqli_stmt_execute($stmt)) {
                return 1;
            } else{
                if (mysqli_errno($conn) == 1062)
                {
                    return -1;
                }else{
                    return 0;
                } 
            }
            mysqli_stmt_close($stmt);
    
        }
    }

    function getAvatarUser($user){
        include "condb.php";

        $sql = "SELECT * FROM `account` WHERE `username` = '$user'" ;
        $query = mysqli_query($conn,$sql);
        $num = mysqli_num_rows($query);
        if ($num > 0){
            $row = mysqli_fetch_array($query,MYSQLI_ASSOC);
            if ($row['image'] == NULL)
            {
                return "/__ProjectWeb/user_data/image/_default.jpg";
            }else
            {
                return "/__ProjectWeb/user_data/image/" . $row['image'];
            }
        }
        else{
            return false;

        }
    }


?>