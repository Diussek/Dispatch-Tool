<?php
include 'db.php';
    
$q = "UPDATE engineers SET srcount=+1 WHERE id=".$row['engname']."";
echo $q;
$query = $conn->query($q);
$result = mysqli_query($conn, $q);

if (mysqli_num_rows($result))
{
	header("Location:index.php");
} else
{
	echo 'Nie zmieniono wartosci';
}
?>