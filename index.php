<?php
include('login.php'); // Includes Login Script

if(isset($_SESSION['login_user'])){
header("location: select.php");
}
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<title>Log in</title>
</head>
<body>
<div id="main">
<h1 align="center">School Booking System</h1><br>
<div id="login">
<h2 align='center'>Login to perform changes</h2><br>
<form action="" method="post">
<div style='text-align:center'>Username:
<input id="name" name="username" placeholder="Username" type="text"></div>
<div style='text-align:center'>Password:
<input id="password" name="password" placeholder="Password" type="password"></div>
<br>
<div style='text-align:center'><input name="submit" align='center' type="submit" value=" Login ">
<?php echo $error; ?></div>
</form>
</div>
</div>
</body>
</html>