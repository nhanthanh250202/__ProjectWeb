<?php
    $BD_SERVER = 'localhost';
    $BD_USERNAME = 'root';
    $BD_PASSWORD = '';
    $BD_NAME  = '_web';

    $conn = mysqli_connect($BD_SERVER,$BD_USERNAME,$BD_PASSWORD,$BD_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>
