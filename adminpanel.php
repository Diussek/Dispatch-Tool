<?php
session_start();
include 'db.php';
?>

<HTML>
<head>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="js/bootstrap.min.js">
<link rel="stylesheet" href="js/bootstrap.js">
<title>Wood Dispatch Tool</title>
</head>
<body>

<?php

if ($_POST['engchange'] && $_POST['engchangevalue'])
{
    $q = "UPDATE engineers SET minioncount = {$_POST['engchangevalue']} WHERE engname = '{$_POST['engchange']}'";
    $query = mysqli_query($conn, $q);
    $_SESSION['p'] = "Minion count of {$_POST['engchange']} has been changed to {$_POST['engchangevalue']} successfuly.";
}

if ($_POST['engshift'] && $_POST['shiftvalue'])
{
    $q = "UPDATE engineers SET shiftcount = {$_POST['shiftvalue']} WHERE engname = '{$_POST['engshift']}'";
    $query = mysqli_query($conn, $q);
    $_SESSION['p'] = "Shift of {$_POST['engshift']} has been set for {$_POST['shiftvalue']}";
}

if ($_POST['newengname'] && $_POST['newengmail'] && $_POST['newengmaximo'] && $_POST['newengshift'])
{
    $q = "INSERT INTO engineers (engname, engmail, maximologin, shiftcount, minioncount, srcount, incount) VALUES ('{$_POST['newengname']}', '{$_POST['newengmail']}', '{$_POST['newengmaximo']}', '{$_POST['newengshift']}', '1', '1', '1')";
    $query = mysqli_query($conn, $q);

    $_SESSION['p'] = "New engineer: {$_POST['newengname']} has been created successfuly.";
}

if ($_POST['newusername'] && $_POST['newuserpassword'] && $_POST['newuserpassword1'])
{
    if ($_POST['newuserpassword'] == $_POST['newuserpassword1'])
    {

        $q = "SELECT * FROM users WHERE username = '" . $_POST['newusername'] . "'";
        $query = mysqli_query($conn, $q);

        if (mysqli_num_rows($query))
        {
            $_SESSION['e'] = "User " . $_POST['newusername'] . " already exists.";
        } else
        {
            $hash = 'fmQSB07ko9ah6';
            $pass = $_POST['newuserpassword'];
            $password = md5($hash . $pass);

            $q = "INSERT INTO users (username, password, rights) VALUES ('" . $_POST['newusername'] . "', '" . $password . "', '1')";
            $query = mysqli_query($conn, $q);

            $_SESSION['p'] = "User " . $_POST['newusername'] . " has been created successfuly.";
        }


    }
}

if($_POST['disableeng']){
	$q = "UPDATE engineers SET visible=0 WHERE engname = '{$_POST['disableeng']}'";
	mysqli_query($conn, $q);
}

if($_POST['enableeng']){
	$q = "UPDATE engineers SET visible=1 WHERE engname = '{$_POST['enableeng']}'";
	mysqli_query($conn, $q);
}



if (isset($_SESSION['loged']))
{
    include 'navbar.php';

    if (isset($_SESSION['e']))
    {
        echo '
	<div align="center" class="alert alert-danger" role="alert">
		' . $_SESSION['e'] . '
	</div>';
        unset($_SESSION['e']);
    }

    if (isset($_SESSION['p']))
    {
        echo '
	<div align="center" class="alert alert-success" role="alert">
		' . $_SESSION['p'] . '
	</div>';
        unset($_SESSION['p']);
    }
    echo '
<br>
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col col-sm-5">
	<!--left column aka ticket counter-->
      <div class="card">
  <div class="card-header" align="center">
    Admin Panel
  </div>
  <div class="card-body" >
  <form method="post" class="form-inline">
  <div class="form-group mb-2">
	<label for="exampleFormControlSelect1">Change Minion</label>

  <div class="form-group mx-sm-3 mb-2">
  
	<select name="engchange" class="form-control form-control-sm">
		<option>Select enigneer</option>
		';
    $q = "SELECT * FROM engineers ORDER by engname";
    $eng = mysqli_query($conn, $q);
    while ($option = mysqli_fetch_assoc($eng))
    {
        echo '<option value="' . $option['engname'] . '">' . $option['engname'] . '</option>
			';
    }
    echo '
	</select>
	<select name="engchangevalue" class="form-control form-control-sm">
	  <option>0</option>
      <option>1</option>
      <option>2</option>
      <option>3</option>
      <option>4</option>
      <option>5</option>
    </select>
	<button type="submit" class="btn btn-primary">Change</button>
	</div>
  </div>
<hr style="width: 100%; color: black; height: 1px; background-color:black;" />

  <div class="form-group mb-2">
	<label for="exampleFormControlSelect1">Change Shift</label>
	<div class="form-group mx-sm-3 mb-2">
		<select name="engshift" class="form-control form-control-sm">
			<option>Select enigneer</option>
			';
    $q = "SELECT * FROM engineers ORDER by engname";
    $eng = mysqli_query($conn, $q);
    while ($option = mysqli_fetch_assoc($eng))
    {
        echo '<option value="' . $option['engname'] . '">' . $option['engname'] . '</option>
				';
    }
    echo '
		</select>
		<select name="shiftvalue" class="form-control form-control-sm">
		  <option>0</option>
		  <option>1</option>
		  <option>2</option>
		  <option>3</option>
		</select>
		<button type="submit" class="btn btn-primary">Change</button>
		</div>

  </div>


<hr style="width: 100%; color: black; height: 1px; background-color:black;" />


   <div class="form-group mb-2">
	<label for="exampleFormControlSelect1">New Engineer</label>

  <div class="form-group mx-sm-3 mb-2">
	<input name="newengname" type="text" style="text-transform: capitalize" class="form-control form-control-sm" placeholder="Name Surname">
	<input name="newengmail" type="email" class="form-control form-control-sm" placeholder="Engineer mail">
	<input name="newengmaximo" type="email" style="text-transform: uppercase" class="form-control form-control-sm" placeholder="Maximo acc">
	<select name="newengshift" class="form-control form-control-sm">
	  <option>Shift</option>
	  <option>1</option>
	  <option>2</option>
	  <option>3</option>
	</select>
	<button type="submit" class="btn btn-primary">Add</button>
	</div>
	  </div>


<hr style="width: 100%; color: black; height: 1px; background-color:black;" />



<div class="form-group mb-2">
	<label for="exampleFormControlSelect1">New Dispatcher</label>
	
	<div class="form-group mx-sm-3 mb-2">
	<input name="newusername" type="text" style="text-transform: capitalize" class="form-control form-control-sm" placeholder="Name Surname">
	<input name="newuserpassword" type="password" class="form-control form-control-sm" placeholder="Password">
	<input name="newuserpassword1" type="password" class="form-control form-control-sm" placeholder="Password">
	<button type="submit" class="btn btn-primary">Add</button>
	</div>
</div>
  
	<hr style="width: 100%; color: black; height: 1px; background-color:black;" />
	<div class="form-group mb-2">
	<label for="exampleFormControlSelect1">Disable Engineer</label>
	<div class="form-group mx-sm-3 mb-2">
		<select name="disableeng" class="form-control form-control-sm">
			<option>Select enigneer</option>
			';
				$q = "SELECT * FROM engineers WHERE visible=1 ORDER by engname";
				$eng = mysqli_query($conn, $q);
				while ($option = mysqli_fetch_assoc($eng))
				{
					echo '<option value="' . $option['engname'] . '">' . $option['engname'] . '</option>
							';
				}
				echo '
		</select>
		<button type="submit" class="btn btn-primary">Disable</button>
	</div>
		
	</div>
	<hr style="width: 100%; color: black; height: 1px; background-color:black;" />
		<div class="form-group mb-2">
		<label for="exampleFormControlSelect1">Enable Engineer</label>
		<div class="form-group mx-sm-3 mb-2">
			<select name="enableeng" class="form-control form-control-sm">
				<option>Select enigneer</option>
				';
					$q = "SELECT * FROM engineers WHERE visible=0 ORDER by engname";
					$eng = mysqli_query($conn, $q);
					while ($option = mysqli_fetch_assoc($eng))
					{
						echo '<option value="' . $option['engname'] . '">' . $option['engname'] . '</option>
								';
					}
					echo '
			</select>
			<button type="submit" class="btn btn-primary">Enable</button>
		</div>
			
		</div>
  
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
</div>

';
}

?>
</body>

</HTML>