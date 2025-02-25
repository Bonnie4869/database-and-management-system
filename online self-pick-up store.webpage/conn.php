<?php

    $sern = "localhost";
    $usrn = "root";
    $pwd = "";
    $db = "dbms";

    $conn = new mysqli($sern, $usrn, $pwd, $db);

    if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);
    
?>