<?php
include('session.php');
$roomToBook = $_SESSION['sessionRoomNumber'];
?>
<!DOCTYPE HTML>
<html> 
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<body>

<?php

$arrayThing = array();

foreach ($_POST['rooms'] as $check) {
	array_push($arrayThing, $check);
}

$periodOfDay = substr($arrayThing[0], 0,1);
$dateOfDay = substr($arrayThing[0], 1,2);
$_SESSION['bookingReason'] = $_POST['bookingReason'];
$reasonForBooking = $_POST['bookingReason'];
$currentTime = date("Y-m-d h:i:s", strtotime("+8 hours"));

if ($dateOfDay == 1){
	$dayOfBooking = date("Y-m-d", strtotime("today"));
} else {
	$dateOfDay = $dateOfDay - 1;
	$dayOfBooking = date("Y-m-d", strtotime("+".$dateOfDay." days"));
}

?>

<?php 
$link = mysql_connect('localhost', 'root', 'root') or die("Could not connect to MySQL server");
@ mysql_select_db("rooms") or die("Could not select database");

$selectResult = mysql_query("SELECT * from booking WHERE room = '$roomToBook' and period = '$periodOfDay' and day = '$dayOfBooking'");

if (mysql_fetch_row($selectResult) == 0){
	//We first search to see if there is an existing booking made by the user
	//If it doesn't exist, we delete it (unbook it)
	//If it exist, we create the booking (book it)
	//--------- If it does not exist
	$result = mysql_query("INSERT INTO `rooms`.`booking` (`user`, `period`, `reason`, `room`, `day`, `updatedOn`) VALUES ('$login_session', '$periodOfDay', '$reasonForBooking', '$roomToBook', '$dayOfBooking', '$currentTime');");
	if (!$result){
	echo "Error occured!";
} else{
	echo "<h2 align='center'>";
	echo "Your booking for room ";
	echo $roomToBook;
	echo "<br><br>";
	echo " have been placed.</h2>";
}

} else {
	//---------If the record does exist

	$result = mysql_query("DELETE from booking WHERE room = '$roomToBook' and period = '$periodOfDay' and day = '$dayOfBooking'");
	if (!$result){
	echo "Error occured!";
} else{
	echo "<h2 align='center'>";
	echo "Your booking for room: ";
	echo $roomToBook;
	echo "<br><br>";
	echo " have been cancelled.</h2>";
}
}

?>

<br><br>
<p style="text-align: center;"><a href='booking.php'>Go Back</a>
<a href='select.php'>  Book another room</a></p>
</body>
</html>