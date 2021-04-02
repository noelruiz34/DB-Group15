

<!DOCTYPE html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js">

</script>

<html>
<head>  
	<title>My website</title>
</head>
<body>
    
    <a href="rules_status.html">Rules</a>
	<h1>Omazon</h1>
    <a href="index2.php">index2 page</a>

    <p align="right">
        <a href="register.php"><button>Create account</button></a>
        <a href="customer_login.php"><button>Log in</button></a>
    </p>

   

    <h1>Categories</h1>
    <font size="+2">
        Display all the categories from DB here somehow
    </font>

    <p> display of items down here </p>
    
	<br>

	<?php print_r($results) ;?>

    <center style="margin-top: 2%">
        <form method="post">
            <input type="submit" name="btn-jack" value="Jack">
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
        </form>
    </center>
</body>
</html>
