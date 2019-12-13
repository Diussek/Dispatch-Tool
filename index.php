<?php
session_start();
include 'db.php';

If($_POST['srinput']){
	$lines = explode("\n",$_POST['srinput']);
	
	foreach($lines as $row){
		$words = explode(" ", preg_replace('/ +/', ' ', trim($row)));
		$q = 'UPDATE engineers SET srcount='.$words[2].' WHERE maximologin = "'.$words[1].'" '; // The ticket system I use generates plain text looking like "TEST   NAME.SURNAME@COMPANY.COM    2   1    3"
		$query = mysqli_query($conn,$q); 														// which is related to engineer and his/her ticket amount
	}
}

If(isset($_POST['ininput'])){
	$lines = explode("\n",$_POST['ininput']);
	
	foreach($lines as $row){
		$words = explode(" ", preg_replace('/ +/', ' ', trim($row)));
		$q = 'UPDATE engineers SET incount='.$words[2].' WHERE maximologin = "'.$words[1].'" ';
		$query = mysqli_query($conn,$q);
	}
}
?>

<HTML>
<head>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="js/bootstrap.min.js">
<link rel="stylesheet" href="js/bootstrap.js">
<title>Wood Dispatch Tool</title>
<style>
.orange{
	color: #fcad03;
}
</style>
</head>
<body>

<?php

If (isset($_SESSION['loged'])){
include 'navbar.php';

if(isset($_SESSION[e])){
	echo '
	<div align="center" class="alert alert-success" role="alert">
		'.$_SESSION[e].'
	</div>';
	unset($_SESSION[e]);
}
echo '
<br>
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col col-sm-5">
	<!--left column aka ticket counter-->
      <div class="card">
  <div class="card-header" align="center">
    Ticket input
  </div>
  <div class="card-body" >
  <form method="post">
	<div class="input-group">
		<div class="input-group-prepend">
			<span class="input-group-text">SR</span>
		</div>
			<textarea name="srinput" rows="5" class="form-control"></textarea>
	</div>
	<button class="btn btn-secondary btn-block">Input SR</button>
	<br>
	<div class="input-group">
		<div class="input-group-prepend">
			<span class="input-group-text">IN</span>
		</div>
			<textarea name="ininput" rows="5" class="form-control"></textarea>
	</div>
	<button class="btn btn-secondary btn-block">Input IN</button>
  </div>
</div>
    </div>
    <div class="col-sm-3">
	<!--right column aka auto-emails-->
		<div class="card">
			<div class="card-header" align="center">
				Auto-emails
			</div>
	<div class="card-body">
		<input type="email" disabled id="usermail" class="form-control zmiana" name="useremail" placeholder="User mail"><br>
		<input type="text" disabled id="ticketnumber" class="form-control zmiana" name="ticketnumber" placeholder="SR/IN number"><br>
		<input type="text" disabled id="tickettitle" class="form-control zmiana" name="tickettitle" placeholder="Ticket title"><br>
				
		<div class="form-check">
		  <label class="form-check-label" for="mailtype1">
			<input disabled class="form-check-input zmiana" type="radio" name="mailtype" id="mailtype1" value="1">
			Normal mail
		  </label>
		</div>
		<div class="form-check">
		  <label class="form-check-label" for="mailtype2">
			<input disabled disabled class="form-check-input zmiana" type="radio" name="mailtype" id="mailtype2" value="2">
			Passed back
		  </label>
		</div>
		<div class="form-check">
		  <label class="form-check-label" for="mailtype3">
			<input disabled class="form-check-input zmiana" type="radio" name="mailtype" id="mailtype3" value="3">
			Panic button
		  </label>
		</div>

		<br><button disabled class="btn btn-primary">Send</button><br>
		<hr style="width: 100%; color: black; height: 1px; background-color:black;" />
		<div class="text-center">
			<div class="btn-group" role="group">
				<button disabled type="button" class="btn btn-warning" data-clipboard-text="V-MWS-XX-MDS-DSS-EMEA-CTS15">EMEA</button>
				<button disabled type="button" class="btn btn-warning" data-clipboard-text="V-MWS-XX-MDS-DSS-AMER-CTS15">AMER</button>
				<button disabled type="button" class="btn btn-warning" data-clipboard-text="V-MWS-XX-MDS-DSS-APAC-CTS15">APAC</button>
			</div>
		</div>
		<br><button disabled class="btn btn-warning btn-block" data-clipboard-target="#area">LOG</button>
		<button disabled class="btn btn-warning btn-block" data-clipboard-text="001 &ndash; User unavailable for information/troubleshooting">001</button><button disabled class="btn btn-warning btn-block" data-clipboard-text="003 &ndash; Ticket for a Future Event">003</button>
				
		<textarea disabled id="area" style="width:100%;" rows="4">'.$messagelog.'</textarea>
				
	</div>
	</form>
</div>
    </div>
  </div>
</div>';
}else{
	
if(isset($_SESSION[e])){
	echo '
	<div align="center" class="alert alert-danger" role="alert">
		'.$_SESSION[e].'
	</div>';
	unset($_SESSION[e]);
}

echo '
<div class="container">
	<div class="row justify-content-center">
		<div class="card">
			<div class="card-header" align="center">
				Wood Dispatch Tool
			</div>
			<div class="card-body">
				<form method="post" action="login.php">
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text">Login:</span>
						</div>
						<input required type="text" class="form-control" placeholder="username" id="login" name="login"><br>
					</div>
					<div class="input-group mb-3">
						<div class="input-group-prepend">
							<span class="input-group-text">Password:</span>
						</div>
						<input required type="password" class="form-control" placeholder="password" id="password" name="password"><br>
					</div>
					<button type="submit" name="log" value="submit" class="btn btn-secondary">Log in</button>
					<h2>Use: test test</h2>
				</form>
			</div>
		</div>
	</div>
</div>
';
}

?>
</body>

</HTML>