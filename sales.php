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
    if(!isset($_SESSION['employee'])) // If session is not set then redirect to Login Page
       {
           header("Location:/employee/employee-login.php");  
       }
    
    $employee_id = $_SESSION['employee']; //Use this for queries on employee
?>



<!DOCTYPE html>
<html>
<head>
	<title>Sales</title>
</head>
<body>
    <!-- use join tables to make the report -->
    <h1>Sales</h1>
    <a href = /employee/employee-portal.php> Back to Employee Portal </a> <br> <br>
    <form action='' method='post'>
        Start Date: <input type='date' id='start' name='sales_start' required/><br>
        End Date: <input type='date' id='end' name='sales_end' required/><br> <br>
        <input type = "submit" name = "generate_report" value = "Generate Report"/>
        <br>
    </form>
    
    <?php 
        if(isset($_POST['generate_report'])) {
            $start_date = $_POST['sales_start'];
            $end_date = $_POST['sales_end'];
            $sales_sql = "SELECT * FROM Point_of_Sale.order WHERE DATE(o_time) >= '$start_date' AND DATE(o_time) <= '$end_date'";
            $result = mysqli_query($connect, $sales_sql);

            if(!$result) {
                die("query failed");
            }

            if(mysqli_num_rows($result)==0) {
                echo "There are no sales in this date range!";
            }
            else {
                $running_item_total = 0;
                $running_sold_total = 0;
                $order_items_array = array();
                $order_total_array = array();
                while($row=mysqli_fetch_array($result)) {
                    $order_id = $row['o_id'];
                    $order_join_sql = "SELECT Point_of_Sale.order.o_id, Point_of_Sale.product_purchase.quantity_ordered, Point_of_Sale.product_purchase.p_price
                    FROM Point_of_Sale.order INNER JOIN Point_of_Sale.product_purchase ON Point_of_Sale.order.o_id = Point_of_Sale.product_purchase.o_id
                    WHERE Point_of_Sale.order.o_id = $order_id";
                    $join_result = mysqli_query($connect, $order_join_sql);

                    if(!$join_result) {
                        die("Query Failed!");
                    }
                    
                    $item_total = 0;
                    $cost_total = 0;
                    while($join_row=mysqli_fetch_array($join_result)){
                        $item_amount = $join_row['quantity_ordered'];
                        $cost_amount = $join_row['quantity_ordered'] * $join_row['p_price'];
                        $item_total += $item_amount;
                        $cost_total += $cost_amount;
                    }
                    
                    $order_items_array[$order_id] = $item_total;
                    $order_total_array[$order_id] = $cost_total;
                    $running_item_total += $item_total;
                    $running_sold_total += $cost_total;
                }
                
                echo "<h1>Summary for Date: $start_date to $end_date</h1>";
                echo "<font size='+3'>
                    Total sold: $$running_sold_total <br>
                    Number of Items Sold: $running_item_total <br>
                </font>";
                $result = mysqli_query($connect, $sales_sql);
                if(mysqli_num_rows($result)==0) {
                    echo "There are no sales in this date range!";
                }
                echo "<table>";
                echo "<tr><td> Date </td><td> Order ID </td><td> Total Cost </td><td> Number of Items </td><td>";
                while($row=mysqli_fetch_array($result)) {
                    echo "<tr>
                    <td>" . $row['o_time'] . "</td>
                    <td>" . $row['o_id'] . "</td>
                    <td>" . $order_total_array[$row['o_id']] . "</td>
                    <td>" . $order_items_array[$row['o_id']] . "</td>
                    </tr>";
                }
                echo "</table>";
            }
            
        }
        
    ?>

    
</body>
</html>