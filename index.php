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
    <div class='navbar'>
        <ul>
            <li style='float:left'><a class='active' href='index.php' style='font-weight:700;'>Omazon</a></li>
            <li style='float:left'><a href="product-catalog.php">Browse Products</a></li>
            <?php
                if(isset($_SESSION['customer'])) {
                    echo "
                    <li><a href = 'logout.php'  style='color:#ec0016;'> Log out </a></li>
                    <li><a href='edit-customer-account-info.php'>My Account</a></li>
                    <li><a href = 'shopping_cart.php'>My Cart</a></li>
                    
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
    </div>

    <div class='main-container'>
    
        <!-- <div class='hero-image-bg'> -->
            <div class="hero-image">

            <div class="hero-text">
                <h1>High-quality goods for highly-awesome customers.</h1>

                <div class='hero-body'>
                    <p>Don't settle for cheap knockoffs. Come discover the point-of-sale system of all time.</p>
                    <br>
                    <a href='register.php'>Sign Up</a>
                </div>
            </div>
            
        </div>
        

        <?php
            if(isset($_SESSION['customer'])) {
                $sql = "SELECT f_name, l_name FROM customer WHERE customer_id=$customer_id";
                $result = mysqli_query($connect, $sql);
                $row = mysqli_fetch_array($result);
                
                echo "Hello, " . $row['f_name'] . " " . $row['l_name'] . "!";
            }
        ?>


        

        
        


        <div class='footer'>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="employee-login.php">Employee Login</a></li>
            </ul>
            <p>Omazon © 2021</p>
        </div>

    </div>
</body>


</html>
