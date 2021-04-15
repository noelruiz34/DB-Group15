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
<style>
* {
  box-sizing: border-box;
}

.row {
  margin-left:-5px;
  margin-right:-5px;
}
  
.column {
  float: left;
  width: 50%;
  padding: 5px;
}

/* Clearfix (clear floats) */
.row::after {
  content: "";
  clear: both;
  display: table;
}

table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  border: 1px solid #ddd;
}

th, td {
  text-align: left;
  padding: 16px;
}

tr:nth-child(even) {
  background-color: #f2f2f2;
}
</style>
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
            $returns_sql = "SELECT * FROM Point_of_Sale.return WHERE DATE(return_time) >= '$start_date' AND DATE(return_time) <= '$end_date'";
            $sales_result = mysqli_query($connect, $sales_sql);
            $returns_result = mysqli_query($connect, $returns_sql);

            if(!$sales_result || !$returns_result) {
                die("query failed");
            }

            $running_item_total = 0;
            $running_sold_total = 0;
            $order_items_array = array();
            $order_total_array = array();
            while($row=mysqli_fetch_array($sales_result)) {
                $order_id = $row['o_id'];
                $order_join_sql = "SELECT Point_of_Sale.order.o_id, Point_of_Sale.product_purchase.quantity_ordered, Point_of_Sale.product_purchase.p_price
                FROM Point_of_Sale.order INNER JOIN Point_of_Sale.product_purchase ON Point_of_Sale.order.o_id = Point_of_Sale.product_purchase.o_id
                WHERE Point_of_Sale.order.o_id = $order_id";
                $order_join_result = mysqli_query($connect, $order_join_sql);

                if(!$order_join_result) {
                    die("Query Failed!");
                }
                
                $item_total = 0;
                $cost_total = 0;
                while($join_row=mysqli_fetch_array($order_join_result)){
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
            

            $running_return_item_total = 0;
            $running_return_total = 0;
            $return_items_array = array();
            $return_total_array = array();

            while($row=mysqli_fetch_array($returns_result)) {
                $return_id = $row['return_id'];
                $return_join_sql = "SELECT Point_of_Sale.return.return_id, Point_of_Sale.return.order_id, Point_of_Sale.return.return_time, Point_of_Sale.product_return.return_quantity, Point_of_Sale.product_return.return_price
                FROM Point_of_Sale.return INNER JOIN Point_of_Sale.product_return ON Point_of_Sale.return.return_id = Point_of_Sale.product_return.r_id
                WHERE Point_of_Sale.return.return_id=$return_id";
                $return_join_result = mysqli_query($connect, $return_join_sql);

                if(!$return_join_result) {
                    die("Query Failed!");
                }
                
                $item_total = 0;
                $cost_total = 0;
                while($join_row=mysqli_fetch_array($return_join_result)){
                    $item_amount = $join_row['return_quantity'];
                    $cost_amount = $join_row['return_quantity'] * $join_row['return_price'];
                    $item_total += $item_amount;
                    $cost_total += $cost_amount;
                }
                
                $return_items_array[$return_id] = $item_total;
                $return_total_array[$return_id] = $cost_total;
                $running_return_item_total += $item_total;
                $running_return_total += $cost_total;
            } 
            
            echo "<h1>Summary for Date: $start_date to $end_date</h1>";
            echo "<font size='+3'>
                Total Sold: $$running_sold_total <br>
                Total Returned: $$running_return_total<br>
                Number of Items Sold: $running_item_total <br>
                Number of Items Returned: $running_return_item_total<br>
                Profit: $" . ($running_sold_total - $running_return_total) ."<br>
            </font>";


          

            echo "<div class='row'>";
            $sales_result = mysqli_query($connect, $sales_sql);
            echo "<div class='column style='background-color:#aaa;'>";
            echo "<h2>Orders</h2>";
            if(mysqli_num_rows($sales_result)==0) {
                echo "<p>There are no orders in this date range!</p>";
            }
            else {
                echo "<table>";
                echo "<tr><th> Date </th><th> Order ID </th><th> Total Cost </th><th> Number of Items </th><th>";
                while($row=mysqli_fetch_array($sales_result)) {
                    echo "<tr>
                    <td>" . $row['o_time'] . "</td>
                    <td>" . $row['o_id'] . "</td>
                    <td>" . $order_total_array[$row['o_id']] . "</td>
                    <td>" . $order_items_array[$row['o_id']] . "</td>
                    </tr>";
                }
                echo "</table>";
            }
            
            echo "</div>";

            $returns_result = mysqli_query($connect, $returns_sql);
            echo "<div class='column style='background-color:#aaa;'>";
            echo "<h2>Returns</h2>";
            if(mysqli_num_rows($returns_result)==0) {
                echo "<p>There are no returns in this date range!</p>";
            }
            else {
                echo "<table>";
                echo "<tr><th> Date </th><th> Return ID </th><th> Order ID </th><th> Return Cost </th><th> Number of Items </th><th>";
                while($row=mysqli_fetch_array($returns_result)) {
                    echo "<tr>
                    <td>$row[return_time]</td>
                    <td>$row[return_id]</td>
                    <td>$row[order_id]</td>
                    <td>" . $return_total_array[$row['return_id']] . "</td>
                    <td>" . $return_items_array[$row['return_id']] . "</td>
                    <tr>";

                }
                echo "</table>";
                echo "</div> </div>";
            }
            
        }
        
    ?>

    
</body>
</html>