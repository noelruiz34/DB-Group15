<!DOCTYPE html>
<?php
$dbServername = "database-1.cgnsxr0vmecq.us-east-2.rds.amazonaws.com";
$dbUser = "admin";
$dbPass = "12345678";
$dbName = "Point_of_Sale";

$connect = mysqli_connect($dbServername, $dbUser, $dbPass, $dbName) or die("Unable to Connect to '$dbServername'");
// mysqli_select_db($connect, $dbName) or die("Could not open the db '$dbName'");
if($connect->connect_error) {
    die('Bad connection'. $connect->connect_error);
}

session_start();
$customer_id = $_SESSION['customer']
?>

<html>

<head>  
	<title>Omazon Home</title>
</head>

<body>
    
	<h1>Omazon</h1>
    <?php
    if(isset($_SESSION['customer'])) {
        $sql = "SELECT f_name, l_name FROM customer WHERE customer_id=$customer_id";
        $result = mysqli_query($connect, $sql);
        $row = mysqli_fetch_array($result);
        echo "Hello, " .$row['f_name'] . " " . $row['l_name'] . "!";
        echo "<p align='right'>
                <a href = 'shopping_cart.php'> My Cart </a>
                <a href = 'logout.php'> Log out </a>
                <a href = 'order_summary.php'> Order lookup </a>";
    }
    else {
        echo "<p align='right'>
        <a href='customer_login.php'>Log in (login system not working yet)</a>
        <a href='register.php'>Create account</a>
        <a href='order_summary.php'>Order lookup</a>
        </p>";
    }
    

    ?>
   

    <h1> <a href="product-catalog.php">Browse Products</a></h1>
    <?php
    

    $connect = mysqli_connect($dbServername, $dbUser, $dbPass, $dbName) or die("Unable to Connect to '$dbServername'");
    // mysqli_select_db($connect, $dbName) or die("Could not open the db '$dbName'");
    if($connect->connect_error) {
        die('Bad connection'. $connect->connect_error);
    }

    $result = $connect->query("SELECT * FROM product_category");
    $resultCheck = mysqli_num_rows($result);
    if ($resultCheck > 0)
    {
        while ($row = mysqli_fetch_assoc($result))
            {
                echo $row['category_name'];
                echo " ";
            }
    }
    
?>

    <?php 
    //include 'db.php';
    ?>

    <p> display of items down here </p>
    
    <!-- OLD JUNK
	<br>
    <center style="margin-top: 2%">
        <form method="post">
            <input type="submit" name="btn-jack" value="Jack">
        </form>
    </center>
    <a href="rules_status.html">Rules</a>
    <a href="index2.php">index2 page</a>

    <div id="comments">
        <?php
            $sql = "select * from student limit 2";
            $result = $connect->query($sql);

            echo "<table>";
            while($kid = mysqli_fetch_array($result)){
                echo "<tr><td>". $kid['name']. "</td> <td>". $kid['major']. "</td></tr>";
            }
            echo "</table>";
        ?>
    </div>
    <button> Show one more </button>
    -->

    

    <div style="position: relative">
        <p style="position:fixed; bottom: 0; width:100%; text-align:center">
            <a href="employee_login.php">Employee Login (login system not working yet)</a><br>
            <a href="employee_portal.php">Skip directly to employee portal (since login system does not work yet)</a><br>
        </p>
    <div>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        var count = 2;
         $("button").click(function() {
            count = count + 1;
            $("#comments").load("testingDB.php", {
                 numberOfStudents: count
            });
         });
    });
</script>

</html>
