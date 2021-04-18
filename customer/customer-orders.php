<?php 
    $dbServername = "database-1.cgnsxr0vmecq.us-east-2.rds.amazonaws.com";
    $dbUser = "admin";
    $dbPass = "12345678";
    $dbName = "Point_of_Sale";
    $connect = mysqli_connect($dbServername, $dbUser, $dbPass, $dbName);
    if(mysqli_connect_errno())
    {
        die("connection Failed! " . mysqli_connect_error());
    }
    session_start();
    if(!isset($_SESSION['customer'])) // If session is not set then redirect to Login Page
       {
           header("Location:/customer/customer-login.php");  
       }
    
    $customer_id = $_SESSION['customer'];
?>

<!DOCTYPE html>
<html>
<head>
    <link href="/styles.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">
    
    <!-- ****** faviconit.com favicons ****** -->
	<link rel="shortcut icon" href="/images/favicon/favicon.ico">
	<link rel="icon" sizes="16x16 32x32 64x64" href="/images/favicon/favicon.ico">
	<link rel="icon" type="image/png" sizes="196x196" href="/images/favicon/favicon-192.png">
	<link rel="icon" type="image/png" sizes="160x160" href="/images/favicon/favicon-160.png">
	<link rel="icon" type="image/png" sizes="96x96" href="/images/favicon/favicon-96.png">
	<link rel="icon" type="image/png" sizes="64x64" href="/images/favicon/favicon-64.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/images/favicon/favicon-32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/images/favicon/favicon-16.png">
	<link rel="apple-touch-icon" href="/images/favicon/favicon-57.png">
	<link rel="apple-touch-icon" sizes="114x114" href="/images/favicon/favicon-114.png">
	<link rel="apple-touch-icon" sizes="72x72" href="/images/favicon/favicon-72.png">
	<link rel="apple-touch-icon" sizes="144x144" href="/images/favicon/favicon-144.png">
	<link rel="apple-touch-icon" sizes="60x60" href="/images/favicon/favicon-60.png">
	<link rel="apple-touch-icon" sizes="120x120" href="/images/favicon/favicon-120.png">
	<link rel="apple-touch-icon" sizes="76x76" href="/images/favicon/favicon-76.png">
	<link rel="apple-touch-icon" sizes="152x152" href="/images/favicon/favicon-152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="/images/favicon/favicon-180.png">
	<meta name="msapplication-TileColor" content="#FFFFFF">
	<meta name="msapplication-TileImage" content="/images/favicon/favicon-144.png">
	<meta name="msapplication-config" content="/images/favicon/browserconfig.xml">
	<!-- ****** faviconit.com favicons ****** -->

	<title>My Orders | Omazon.com</title>
</head>


<body>
    <div class='navbar'>
        <ul>
            <li style='float:left'><a href='/index.php' style='font-weight:900;'>Omazon<img src='/images/favicon/favicon-192.png' width='16' height='16'></a></li>
            <li style='float:left'><a href="/product-catalog.php">Browse Products</a></li>
            <?php
                if(isset($_SESSION['customer'])) {
                    echo "
                    <li><a href = '/logout.php'  style='color:#ec0016;'> Log out </a></li>
                    <li><a href='/customer/account/edit-customer-account-info.php'>My Account</a></li>
                    <li><a class='active' href='/customer/customer-orders.php'>My Orders</a></li>
                    <li><a href = '/customer/shopping-cart.php'>My Cart</a></li>
                    
                    ";
                }
                else {
                    echo "
                    <li><a href='/customer/register.php'>Register</a></li>
                    <li><a href='/customer/customer-login.php'>Log in</a></li>
                    ";
                }
            ?>
        </ul>
    </div>

    <h1 style='margin-top: 100px;margin-bottom:15px;'>My Orders</h1>

    <?php
        $customer_order_sql = "SELECT * FROM Point_of_Sale.order WHERE customer_id=$customer_id";
        $customer_order_result = mysqli_query($connect, $customer_order_sql);

        if(!$customer_order_result) {
            die("customer order Query failed!");
        }
        if(mysqli_num_rows($customer_order_result) == 0) {
            echo "You have not placed any orders!";
            return;
        }

        echo "<table>";
        echo "<tr>
        <th> Order ID </th>
        <th> Date Placed </th>
        <th> Status </th>
        <th style='text-align:center'> Action </th>
        </tr>";
        while($row=mysqli_fetch_array($customer_order_result)) {
            echo "<tr>
            <td>$row[o_id]</td>
            <td>$row[o_time]</td>
            <td>$row[o_status]</td>
            <td><form action='/customer/customer-order-details.php' target='_blank' method=post>
            <input type = hidden name = order_detail_id value=$row[o_id]>
            <input style='margin:12px; width: 90%' type='submit' name='order_details' value='View Items/Request Support'><br>
            </form></td>
            </tr>";
        }
        echo "</table>";
        
    ?>

    <div class='footer' style='top:20vh; position:relative; width:100%;'>
        <div class='row'>
            <div class='column'>
                <div style='padding-left:30%; padding-right: 20px; padding-top:0px; margin:32px;'>
                    <h3 style='margin-bottom: 6px;'>Omazon<img src='/images/favicon/favicon-192.png' width='26' height='26'></h3>
                    <p style='padding:0;'>Omazon is a fictional company conceived for the purpose of a database class project. There is no intention of profit or infringement of copyright. However, it still has many functionalities that a typical ecommerce website would have.</p>
                </div>
            </div>

            <div class='column' style='flex:25%'>
                <div style='padding-left: 20px; padding-right: 30%; padding-top:0px; margin:32px; text-align:left;'>
                    <p>
                        <a href="/index.php">Home</a> | 
                        <a href="/product-catalog.php">Products</a> | 
                        <a href="/customer/register.php">Register</a> | 
                        <a href="/about.html">About</a>
                    </p>
                    <p><a href="/employee/employee-login.php">Employee Portal</a></p>
                    <p class='copyright'>Omazon © 2021</p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>