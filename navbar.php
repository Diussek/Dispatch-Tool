<?php
echo '
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="index.php">Dispatch Tool</a>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="dispatchsr.php">SR dispatch</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="dispatchin.php">IN dispatch</a>
      </li>
	  <li class="nav-item">
        <a class="nav-link" href="adminpanel.php">Admin Panel</a>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Absence list?</a>
      </li>
    </ul>
	<div class="text-warning mr-sm-2"> '.$_SESSION[name].'</div>
	<form class="form-inline my-2 my-lg-0">
		<a href="logout.php" class="btn btn-danger">Logout</a>
    </form>
  </div>
</nav>
';
?>