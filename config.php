<?php

    $servername ="localhost";
    $username ="root";
    $password ="";
    $db = "shop_db";

    $conn = @new mysqli($servername, $username, $password, $db)
        or die("Cannot create connection: ") . $conn->connect_error;
    
    mysqli_set_charset($conn,"utf8");

?>