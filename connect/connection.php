<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "hirkani";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
     //echo"connected";
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>