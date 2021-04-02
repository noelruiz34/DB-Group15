<?php 
include 'db.php';

if(isset($_POST['btn-jack'])){
    $result = $connect->query("select * from student");

    echo "<table>";
    while($kid = mysqli_fetch_array($result)){
        echo "<tr><td>". $kid['name']. "</td> <td>". $kid['major']. "</td></tr>";
    }
    echo "</table>";
}

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
    
    <a href="rules_status.html">Rules</a>
	<h1>This is the index page</h1>
    <a href="index2.php">index2 page</a>

    <center style="margin-top: 2%">
        <form method="post">
            <input type="submit" name="btn-jack" value="Jack">
        </form>
    </center>
    
	<br>

	<?php print_r($results);?>
</body>
</html>
