<?php

include ('db.php');
session_start();
$q = "SELECT engname FROM engineers WHERE engmail = '{$_POST['engmail']}'";
$result = mysqli_query($conn, $q);
$row = mysqli_fetch_assoc($result);

switch ($_POST['mailtype'])
{
    case 1:
        $body = "Dear Sir/Madam, %0D%0A%0D%0AThank you for sharing your request with us. It has been assigned to {$row['engname']}. Our Engineer will be attempting to contact you during your working hours to resolve the request. If you have preferences regarding time/date of contact, please let us know and we will do our best to take this into consideration.%0D%0ATicket Details:%0D%0ANumber: {$_POST['ticketnumber']} %0D%0AAssigned to: {$row['engname']} {$_POST['engmail']}%0D%0ATeam: CTS - IT Support Level 2%0D%0A%0D%0AKind Regards";
        $title = "CTS - L2 Support - ticket number: {$_POST['ticketnumber']} - {$_POST['tickettitle']} - {$row['engname']}";
		$sendit = '$("#send2mailto").attr("href", "mailto:' . $_POST['useremail'] . '?cc=' . $_POST['engmail'] . '&subject=' . $title . '&body=' . $body . '")';
		break;
    case 2:
        $body =""; //empty for now
        break;
    case 3:
        $body = "Hi!%0D%0A%0D%0AThere is new ticket in your queue marked as Unusual (e.g. security related/other uncommon circumstances). Please check your queue.%0D%0ATicket number: {$_POST['ticketnumber']} %0D%0A%0D%0AKind Regards";
		$title = "Desktop Patch Failure/Security/OTHER - new ticket in your queue - {$_POST['ticketnumber']} - {$row['engname']}";
		$sendit = '$("#send2mailto").attr("href", "mailto:' . $_POST['engmail'] . '?subject=' . $title . '&body=' . $body . '")';
        break;
}

echo $sendit;
$_SESSION['message'] = $body;
?>