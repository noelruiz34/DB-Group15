<?php 
// include_once("home.html"); 
$dbServername = "database-1.cgnsxr0vmecq.us-east-2.rds.amazonaws.com";
$dbUser = "admin";
$dbPass = "12345678";
$dbName = "Point_of_Sale";

$connect = mysqli_connect($dbServername, $dbUser, $dbPass, $dbName) or die("Unable to Connect to '$dbServername'");
// mysqli_select_db($connect, $dbName) or die("Could not open the db '$dbName'");
if($connect->connect_error) {
    die('Bad connection'. $connect->connect_error);
}

$result = $connect->query("select * from student");
$results = $result->fetch_all();


$connect->close()

?>
<!DOCTYPE html>
<html>
<head>
	<title>My website</title>
</head>
<body>
	<h1>This is the index page</h1>

	<br>
	<?php echo $results?>
</body>
</html>
