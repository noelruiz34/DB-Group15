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
	<title>My Orders</title>
</head>
<a href="/index.php">Back to Home</a>
<h1> My Orders </h1>
<body>
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
        <td> Order ID </td>
        <td> Date </td>
        <td> Status </td>
        </tr>";
        while($row=mysqli_fetch_array($customer_order_result)) {
            echo "<tr>
            <td>$row[o_id]</td>
            <td>$row[o_time]</td>
            <td>$row[o_status]</td>
            <td><form action='/customer/customer-order-details.php' method=post>
            <input type = hidden name = order_detail_id value=$row[o_id]>
            <input type='submit' name='order_details' value='View Order Details'><br>
            </form></td>
            </tr>";
        }
        echo "</table>";
        
    ?>

</body>
</html>