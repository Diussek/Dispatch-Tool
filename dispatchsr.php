<?php

session_start();
include 'db.php';


if ($_POST['minus'])
{
    $q = "UPDATE engineers SET srcount = srcount - 1 WHERE engname='{$_POST['minus']}'";
    $minusresult = mysqli_query($conn, $q);
	$_SESSION[e] = "<b>{$_POST['minus']}</b> got a <b>minus</b> ticket.";
}

if ($_POST['plus'])
{
    $q = "UPDATE engineers SET srcount = srcount + 1 WHERE engname='{$_POST['plus']}'";
    $plusresult = mysqli_query($conn, $q);
	$_SESSION[p] = "<b>{$_POST['plus']}</b> got a <b>plus</b> ticket.";
}


$query = "SELECT * FROM engineers WHERE shiftcount=1  && visible=1 ORDER by srcount/minioncount";
$result = mysqli_query($conn, $query);

$query1 = "SELECT * FROM engineers WHERE shiftcount=2  && visible=1 ORDER by srcount/minioncount";
$result1 = mysqli_query($conn, $query1);

$query2 = "SELECT * FROM engineers WHERE shiftcount=3  && visible=1 ORDER by srcount/minioncount";
$result2 = mysqli_query($conn, $query2);

$query3= "SELECT * FROM engineers WHERE visible=0 ORDER by srcount/minioncount";
$result3 = mysqli_query($conn, $query3);


if($_SESSION['message']){
	$temp = preg_replace('/%0D%0A/', '&#10;', trim($_SESSION['message']));
	$messagelog = "User Contacted via IT Service desk email, awaiting response &#10;&#10;&#10;".$temp."";
}

function drawTable($res){
	echo '<table class="table table-sm table-hover">
	  <thead class="thead-light">
		<tr>
		  <th scope="col" style="width: 30%">Engineer</th>
		  <th scope="col" style="width: 5%">Tickets</th>
		  <th scope="col" style="width: 5%">SR</th>
		  <th scope="col" style="width: 5%">SR/Eng</th>
		  <th scope="col" style="width: 5%">Minions</th>
		  <th scope="col" style="width: 15%" class="text-center">Send mail</th>
		  <th scope="col" style="width: 10%">+/-</th>
		</tr>
	  </thead>
	  <tbody>';

    while ($row = mysqli_fetch_assoc($res)){
		$tickets = $row['srcount'] + $row['incount'];
        echo '<tr>
		  <td>' . $row['engname'] . '</td>
		  <td>' . $tickets . '</td>
		  <td>' . $row['srcount'] . '</td>
		  <td>' . $row['srcount'] / $row['minioncount'] . '</td>
		  <td>' . $row['minioncount'] . '</td>
		  <td  class="text-center"><div class="form-check"><input class="zmiana" type="radio" name="engmail" value="' . $row['engmail'] . '"></div></td>
		  <td><button name="minus" value="' . $row['engname'] . '" class="btn btn-sm btn-danger">-</button><button name="plus" value="' . $row['engname'] . '" class="btn btn-sm btn-success">+</button></td>
		</tr>';
    }
	echo '</tbody>
	</table>';
}

?>
<HTML>
<head>
<link rel="stylesheet" href="css/bootstrap.min.css" />
<link rel="stylesheet" href="css/bootstrap.css" />
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="dist/clipboard.min.js"></script>
<title>Wood Dispatch Tool</title>
<style>
body{
	background-color: #fffae3;
}
</style>
</head>
<body>

<?php

#print_r($_POST);
#print_r($_SESSION);

if (isset($_SESSION['loged']))
{
    include 'navbar.php';
	
		if(isset($_SESSION[p])){
	echo '
	<div align="center" class="alert alert-success" role="alert">
		'.$_SESSION[p].'
	</div>';
	unset($_SESSION[p]);
	}
		
	if(isset($_SESSION[e])){
	echo '
	<div align="center" class="alert alert-danger" role="alert">
		'.$_SESSION[e].'
	</div>';
	unset($_SESSION[e]);
	}
    echo '
<br>
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col col-sm-5">
      <div class="card">
  <div class="card-header" align="center">
    SR counter
  </div>
  <div class="card-body" >
  <form method="post" accept-charset="utf-8" id="dispatch_form">';
  
 drawTable($result); #drawing table 1 - First shift
 drawTable($result1); #drawing table 2 - Second shift
 drawTable($result2); #drawing table 3 - Third shift
 
  echo '
	<hr style="width: 100%; color: black; height: 1px; background-color:black;" />';
	if (mysqli_num_rows($result3)){
		echo '
		<table class="table table-sm table-hover">
		  <thead class="thead-light">
			<tr>
			  <th scope="col" style="width: 30%">Engineer</th>
			  <th scope="col" style="width: 5%">Tickets</th>
			  <th scope="col" style="width: 5%">SR</th>
			  <th scope="col" style="width: 5%">SR/Eng</th>
			  <th scope="col" style="width: 5%">Minions</th>
			  <th scope="col" style="width: 15%" class="text-center">Send mail</th>
			  <th scope="col" style="width: 10%">+/-</th>
			</tr>
		  </thead>
		  <tbody>';

		while ($row3 = mysqli_fetch_assoc($result3))
		{
			$tickets = $row3['srcount'] + $row3['incount'];
			echo '<tr>
			  <td>' . $row3['engname'] . '</td>
			  <td>' . $tickets . '</td>
			  <td>' . $row3['srcount'] . '</td>
			  <td>' . $row3['srcount'] / $row3['minioncount'] . '</td>
			  <td>' . $row3['minioncount'] . '</td>
			  <td class="text-center"><div class="form-check"><input disabled class="zmiana" type="radio" name="engmail" value="' . $row3['engmail'] . '"></div></td>
			  <td><button disabled name="minus" value="' . $row3['engname'] . '" class="btn btn-sm btn-danger">-</button><button disabled name="plus" value="' . $row3['engname'] . '" class="btn btn-sm btn-success">+</button></td>
			</tr>
		</tbody>
		</table>';
		}
	}else echo '<div class="text-center">There are no absent/disabled engineers</div>';
    echo '</div>
</div>
    </div>
    <div class="col-sm-3">
		<div class="card">
			<div class="card-header" align="center">
				Auto-emails
			</div>
			<div class="card-body">
						<input type="email" id="usermail" class="form-control zmiana" name="useremail" placeholder="User mail"><br>
						<input type="text" id="ticketnumber" class="form-control zmiana" name="ticketnumber" placeholder="SR/IN number"><br>
						<input type="text" id="tickettitle" class="form-control zmiana" name="tickettitle" placeholder="Ticket title"><br>
						
						<div class="form-check">
						  <label class="form-check-label" for="mailtype1">
                            <input class="form-check-input zmiana" type="radio" name="mailtype" id="mailtype1" value="1">
							Normal mail
						  </label>
						</div>
						<div class="form-check">
						  <label class="form-check-label" for="mailtype2">
                            <input disabled class="form-check-input zmiana" type="radio" name="mailtype" id="mailtype2" value="2">
							Passed back
						  </label>
						</div>
						<div class="form-check">
						  <label class="form-check-label" for="mailtype3">
                            <input class="form-check-input zmiana" type="radio" name="mailtype" id="mailtype3" value="3">
							Panic button
						  </label>
						</div>

						<br><a href="" id="send2mailto" class="btn btn-primary">Send</a><br>
						<hr style="width: 100%; color: black; height: 1px; background-color:black;" />
						<div class="text-center">
							<div class="btn-group" role="group">
								<button type="button" class="btn btn-warning" data-clipboard-text="V-MWS-XX-MDS-DSS-EMEA-CTS15">EMEA</button>
								<button type="button" class="btn btn-warning" data-clipboard-text="V-MWS-XX-MDS-DSS-AMER-CTS15">AMER</button>
								<button type="button" class="btn btn-warning" data-clipboard-text="V-MWS-XX-MDS-DSS-APAC-CTS15">APAC</button>
							</div>
						</div>
						<br><button class="btn btn-warning btn-block" data-clipboard-target="#area">LOG</button>
						<button class="btn btn-warning btn-block" data-clipboard-text="001 &ndash; User unavailable for information/troubleshooting">001</button><button class="btn btn-warning btn-block" data-clipboard-text="003 &ndash; Ticket for a Future Event">003</button>

							<textarea id="area" style="width:100%;" rows="4">'.$messagelog.'</textarea>

					</div>
				</form>
				
			</div>
		</div>
    </div>
  </div>
</div>
';
} else
{
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
				</form>
			</div>
		</div>
	</div>
';
}

?>
<script>
$(".zmiana").on("change", function(e) {
  $.ajax({
      type     : "POST",
      url      : "ajax.prepare2send.php",
      data     : $("#dispatch_form").serialize(),
      dataType : "script"
  });
});

$("#send2mailto").on("click", function(e) {
  $.ajax({
      type     : "POST",
      url      : "ajax.srupdate.php",
      data     : $("#dispatch_form").serialize(),
	  dataType : "script",
	  success: function() {   
        window.location='dispatchsr.php'  
    }
  });
});

var clipboard = new ClipboardJS('.btn');
</script>
</body>

</HTML>