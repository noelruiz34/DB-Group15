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


<!DOCTYPE html>
<html>

<head>
    <link href="styles.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">
	<title>Omazon Home</title>
</head>

<body>
    
    <ul>
        <li style='float:left'><a class='active' href='index.php' style='font-weight:700;'>Omazon</a></li>
        <li style='float:left'><a href="product-catalog.php">Browse Products</a></li>
        <?php
            if(isset($_SESSION['customer'])) {
                echo "
                <li><a href='edit-customer-account-info.php'>My Account</a></li>
                <li><a href = 'shopping_cart.php'>My Cart</a></li>
                <li><a href = 'logout.php'> Log out </a></li>
                ";
            }
            else {
                echo "
                <li><a href='register.php'>Register</a></li>
                <li><a href='customer_login.php'>Log in</a></li>
                ";
            }
        ?>
        <li><a href='order_summary.php'>Order Lookup</a></li>
    </ul>
    
    <?php
        if(isset($_SESSION['customer'])) {
            $sql = "SELECT f_name, l_name FROM customer WHERE customer_id=$customer_id";
            $result = mysqli_query($connect, $sql);
            $row = mysqli_fetch_array($result);
            
            echo "Hello, " . $row['f_name'] . " " . $row['l_name'] . "!";
        }
    ?>




    <p>UNDER CONSTRUCTION</p>
    

    <div style="position:relative">
        <p style="position:fixed; bottom: 0; width:100%; text-align:center">
            <a href="employee-login.php">Employee Login </a><br>
        </p>
    <div>
</body>


</html>
