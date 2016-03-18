<?php
include('session.php');

if (isset($_POST['roomNumber'])){
	$_SESSION['sessionRoomNumber'] = $_POST['roomNumber'];
}

$selectedRoomNumber = $_SESSION['sessionRoomNumber'];

if (isset($_GET['var'])){
	$_SESSION['dateOffset'] = $_SESSION['dateOffset'] + $_GET['var'];
	$todayOffset = $_SESSION['dateOffset'];
	$fiveDaysLaterOffset = $todayOffset + 5;
	header("Location: booking.php");
	die;
} else {
	$todayOffset = $_SESSION['dateOffset'];
	$fiveDaysLaterOffset = $todayOffset + 5;
}

echo $_SESSION['dateOffset'];



?>
<html>
<head>
	<title>Bookings</title>
	<script>
	function refreshView(){
		window.location = "booking.php";
	}
	function logout(){
		if (confirm('Do you want to logout?')){
			window.location = "logout.php";
		} else {

		}
	}

	</script>

</head>
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<body>

<h2 align='center'>Select an open timeslot: Room <?php echo $selectedRoomNumber; ?></h2><br>
<h5 align='center'>You're logged in as: <?php echo $login_session; ?>  <a href="#" onclick='logout();'>Logout</a> </h5><br><br>

<?php

//
function createDateRange($startDate, $endDate, $format = "Y-m-d")
{
    $begin = new DateTime($startDate);
    $end = new DateTime($endDate);

    $interval = new DateInterval('P1D'); // 1 Day
    $dateRange = new DatePeriod($begin, $interval, $end);

    $range = [];
    foreach ($dateRange as $date) {
        $range[] = $date->format($format);
    }

    return $range;
}

//

$time_array = array('Period 1', 'Period 2', 'Period 3', 'Period 4', 'Period 5');

$today = date("Y-m-d", strtotime("+".$todayOffset." days"));
$fiveDaysLater = date("Y-m-d", strtotime("+".$fiveDaysLaterOffset." days"));

$date_array = createDateRange($today, $fiveDaysLater);

$link = mysqli_connect('localhost', 'root', 'root', "rooms") or die("Could not connect to MySQL server");

echo "<table border='2' width='50%' height='50%' align='center'>";

echo "<tr>";
echo '<td> Date: </td>';

for ($i=0;$i<count($date_array);$i++){
	echo '<td>';
	echo $date_array[$i];
	echo '</td>';
}
echo "</tr>";

//
// The booking table starts below this point.
//

echo '<form action="bookroom.php" method="post">';

for ($ii=0; $ii<5;$ii++){

	$iii = $ii + 1; //iii is the ROW NUMBER
	echo "<td> Period $iii: </td>";

for ($i=0;$i<count($time_array);$i++){
	$counter = $i + 1; //counter is the COLUMN number

	//$iii is the Y VALUE
	//$counter is the X VALUE

	$dateDay = $date_array[$counter - 1];
	
	$result = mysqli_query($link, "SELECT * FROM booking WHERE room = '$selectedRoomNumber' and period = '$iii' and day = '$dateDay'" );
	$result2 = mysqli_query($link, "SELECT * FROM booking WHERE room = '$selectedRoomNumber' and period = '$iii' and day = '$dateDay' and user = '$login_session'");
	$result3 = mysqli_query($link, "SELECT user FROM booking WHERE room = '$selectedRoomNumber' and period = '$iii' and day = '$dateDay'" );

	list($updatedBy) = mysqli_fetch_row($result3);
	
	if (mysqli_fetch_row($result2)> 0){
		//If it is booked by logged in user.
		echo "\n<td bgcolor='ffa500'>";
		echo "<input type='checkbox' id='timeCheckbox' name='rooms[]' value='$iii$counter'></checkbox>";
		echo "Booked by: You";
	} else if (mysqli_fetch_row($result) > 0){
		//If it is booked by another user.
		if ($login_session == "admin"){
			echo "\n<td bgcolor='ff0000'>";
			echo "<input type='checkbox' name='rooms[]'' value='$iii$counter'></checkbox>";
			echo " Clear Booking";
			echo "<br>";
			echo "  Booked by: ". $updatedBy;
		} else {
			echo "\n<td bgcolor='ff0000'>";
			echo "Booked by: ". $updatedBy;
		}
	} else {
		echo "\n<td bgcolor='00FF00'>";
		echo "<input type='checkbox' name='rooms[]'' value='$iii$counter'></checkbox>";
	}


	echo '</td>';
}
echo '</tr>';
}

echo "</table>";

mysqli_close();
?>
<br>

<input type="hidden" name="roomNumber" value=<?php echo htmlentities($selectedRoomNumber);?>>
<div style='text-align:right;margin-right:25%'><input type='button' value='Refresh' onclick='refreshView();'/>
<input type="submit" id="selectButton" value="Select timeslot">
<input type="text" name="bookingReason" placeholder="Reason for booking"></div>
</form>

<br><br>
<?php
$variableString = 'booking.php?var=5&room='. $selectedRoomNumber;
$variableString2 = 'booking.php?var=-5&room='. $selectedRoomNumber;
$variableString3 = 'booking.php?room='. $selectedRoomNumber;
?>
<a href=<?php echo $variableString?>>+ Days</a>
<a href=<?php echo $variableString2?>>-5 Days</a>
<a href=<?php echo $variableString3?>>Today</a>

<a href="index.php">Go back</a>

</body>
</html>