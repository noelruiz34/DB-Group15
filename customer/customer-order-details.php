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
    $order_id = $_POST['order_detail_id'];

    function echoOrderDetails($connect, $order_id) {
        $order_join_sql = "SELECT Point_of_Sale.product_purchase.upc, Point_of_Sale.product.p_name, Point_of_Sale.product_purchase.quantity_ordered, Point_of_Sale.product_purchase.p_price
            FROM Point_of_Sale.order INNER JOIN Point_of_Sale.product_purchase ON Point_of_Sale.order.o_id = Point_of_Sale.product_purchase.o_id
            JOIN Point_of_Sale.product ON Point_of_Sale.product.upc = Point_of_Sale.product_purchase.upc
            WHERE Point_of_Sale.order.o_id = $order_id";
            $order_result = mysqli_query($connect,$order_join_sql);
            
            $order_info_sql = "SELECT * FROM Point_of_Sale.order WHERE o_id = $order_id";
            $order_info_result = mysqli_query($connect,$order_info_sql);
            if(!$order_result) {
                die("Query failed!");
            }

            if(mysqli_num_rows($order_result) == 0) {
                echo "Order ID: $order_id does not exist!";
            }
            else {
                $total = 0;
                echo "<h1 style='text-align:center; margin:2px; margin-top:8vh;'> Order ID: $order_id </h1>";
                while($row=mysqli_fetch_array($order_info_result)) {
                    echo "<h3 style='text-align:center; margin:0;'>Placed: $row[o_time]</h3>";
                    echo "<h3 style='text-align:center; margin:0; margin-bottom:4vh;'>Status: $row[o_status]</h3>";
                }

                echo "<form action='support-ticket-form.php' target='_blank' method=post>";
                echo "<table>";
                echo "<tr><th> UPC </th><th> Product Name </th><th> Quantity </th><th> Price </th></tr>";
                while($row=mysqli_fetch_array($order_result)) {
                    echo "<tr>
                    <td>$row[upc]</td>
                    <td>$row[p_name]</td>
                    <td>$row[quantity_ordered]</td>
                    <td>$$row[p_price]</td>
                    </tr>";
                    $total += $row['p_price'] * $row['quantity_ordered'];
                }

                
                echo "<tr style='border-top:25px solid #303841;'><td></td><td></td><td>Total:</td><td>$$total</td></tr>";
                
                
                echo "</table> <br>";
                echo "<input type = 'hidden' name = 'order_detail_id' value=$order_id>";
                echo "<input style='margin: 0 auto; margin-top:50px; display:block; width: 50%;' type ='submit' name = 'request_support' value = 'Request Support Ticket'/><br><br />";
                echo "</form>";
            }
            
            
    }

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
	<title>Order Details</title>
</head>

<body>
    <?php
        if(isset($_POST['order_details'])) {
            echoOrderDetails($connect, $order_id);
        }
    ?>
</body>
</html>