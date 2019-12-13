<?php

$servername = "localhost";
$username = "root";
$password = "";
$db_name = "dispatch1";


try {
    $conn = mysqli_connect($servername, $username, $password, $db_name);
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
?>