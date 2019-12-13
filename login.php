<?php
include 'db.php';
session_start();

if ($_POST['login']){
	$hash = 'fmQSB07ko9ah6';
	$pass = md5($hash.$_POST['password']);
	$login = htmlentities($_POST['login']);
	
	$q = "SELECT * FROM users WHERE username = '".$login."' && password = '".$pass."'";
	$result = mysqli_query($conn, $q);
	if (mysqli_num_rows($result))
    {
		$_SESSION[name] = $login;
        $_SESSION[e] = 'Hello '.$_SESSION[name].'. Have a nice day :)';
        $_SESSION[loged] = true;
		header("Location:index.php");
    } else
    {
        $_SESSION[e] = 'Bad login '.$login.'';
		header("Location:index.php");
    }

}
?>