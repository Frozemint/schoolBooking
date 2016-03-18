<?php
include('session.php');
?>
<html>
<link ref="stylesheet" type="text/css" href="css/bootstrap.css">
<body>

<?php
echo $_SESSION['sessionRoomNumber'];
echo "<br>";
echo $_SESSION['bookingReason'];
?>
</body>
</html>