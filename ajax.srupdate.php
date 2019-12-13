<?php

include ('db.php');
session_start();

$q = "UPDATE engineers SET srcount = srcount +1 WHERE engmail = '{$_POST['engmail']}'";
mysqli_query($conn, $q);

?>