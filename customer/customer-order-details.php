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
            
            if(!$order_result) {
                die("Query failed!");
            }

            if(mysqli_num_rows($order_result) == 0) {
                echo "Order ID: $order_id does not exist!";
            }
            else {
                echo "<h1> Order: $order_id </h1>";
                echo "<form action='support-ticket-form.php' method=post>";
                echo "<table>";
                echo "<tr><td> UPC </td><td> Product Name </td><td> Quantity </td><td> Price </td></tr>";
                while($row=mysqli_fetch_array($order_result)) {
                    echo "<tr>
                    <td>$row[upc]</td>
                    <td>$row[p_name]</td>
                    <td>$row[quantity_ordered]</td>
                    <td>$row[p_price]</td>
                    </tr>";
                }
                echo "</table> <br>";
                echo "<input type = hidden name = order_detail_id value=$order_id>";
                echo "<input type = submit name = request_support value = 'Request Support Ticket'/><br><br />";
                echo "</form>";
            }
            
            
    }

?>

<!DOCTYPE html>
<html>
<head>
	<title>Order: <?php $order_id?></title>
</head>
<a href="/customer/customer-orders.php">Back to My Orders</a> <br>
<body>
    <?php
        if(isset($_POST['order_details'])) {
            echoOrderDetails($connect, $order_id);
        }
    ?>
</body>
</html>