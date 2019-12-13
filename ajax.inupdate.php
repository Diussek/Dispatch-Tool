<?php

include ('db.php');
session_start();

$q = "UPDATE engineers SET incount = incount +1 WHERE engmail = '{$_POST['engmail']}'";
mysqli_query($conn, $q);

?>