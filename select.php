<?php
include('session.php');
session_start();
$_SESSION['dateOffset']=0;
?>
<!DOCTYPE HTML>
<html> 
<head>
	<title>Welcome</title>
<script>
function logout(){
		if (confirm('Do you want to logout?')){
			window.location = "logout.php";
		} else {

		}
	}
</script>
</head>
<body>
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<form action="booking.php" method="post">
<br>
<h2 align='center'>Welcome to the Sample Room Booking System</h2>
<h2 align='center'>Which room do you want to book?</h2>
<br>
<h5 align='center'>You're logged in as: <?php echo $login_session; ?>  <a onclick="logout();">Logout</a></h5>
<br>
<div style='text-align:center'>Room: <input type="text" name="roomNumber" required><br><br>
<input type="submit" name="Submit" value="View Bookings for Room"></div>
</form>
</body>
</html>