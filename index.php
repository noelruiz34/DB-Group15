<?php 

$dbServername = "database-1.cgnsxr0vmecq.us-east-2.rds.amazonaws.com";
$dbUser = "admin";
$dbPass = "12345678";
$dbName = "Point_of_Sale";

$connect = mysqli_connect($dbServername, $dbUser, $dbPass, $dbName) or die("Unable to Connect to '$dbServername'");

if($connect->connect_error) {
    die('Bad connection'. $connect->connect_error);
}

$result = $connect->query("select * from student");
$results = $result->fetch_all();


if(isset($_POST['btn-jack'])){
    $result = $connect->query("select * from student");
    while($kid = mysqli_fetch_array($result)){
        echo "<tr><td>". $kid['name']. "</td></tr>";
    }
}

// $connect->close()

?>
<!DOCTYPE html>

<script>
    function getMajor() {
        $
    }
</script>
<html>
<head>
	<title>My website</title>
</head>
<body>
	<h1>This is the index page</h1>

    <!-- <button type="button" onClick=>Jack</button> -->
    <?php
      
    ?>

    <form method="post">
        <input type="submit" name="btn-jack" value="Jack">
    </form>
	<br>
	<?php print_r($results);?>
</body>
</html>
