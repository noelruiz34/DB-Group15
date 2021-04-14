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
           header("Location:employee-login.php");  
       }
    
    $employee_id = $_SESSION['employee']; //Use this for queries on employee

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
                echo "<h1> Order Details </h1>";
                echo "<table>";
                echo "<tr><td> UPC </td><td> Product Name </td><td> Quantity </td><td> Price </td></tr>";
                while($row=mysqli_fetch_array($order_result)) {
                    echo "<tr>
                    <td>$row[upc]</td>
                    <td>$row[p_name]</td>
                    <td>$row[quantity_ordered]</td>
                    <td>$row[p_price]</td>
                    <td><form action='' method=post>
                    <input type = hidden name = return_upc value=$row[upc]>
                    <input type = hidden name = return_quantity value=$row[quantity_ordered]>
                    <input type = hidden name = return_price value=$row[p_price]>
                    <input type = submit name = issue_return value = 'Issue Return'/><br />
                    </form>
                    </tr>";
                }
                echo "</table>";
            }
            
            
    }
?>

<!DOCTYPE html>
<html>
<head>
	<title>Issue Return</title>
</head>
<body>
    <h1>Issue Return</h1>
    <a href = employee-portal.php> Back to Employee Portal </a> <br> <br>
    <form action='' method="post">
        <input type = "submit" name = "view_all_returns" value = "View All Returns"/><br>
    </form>

    <form action='' method="post">
        <label> Issue Return for Order ID: </label><input type = "text" name = "return_order" class = "box" />
        <input type = "submit" name = "start_return" value = "Start"/> <br /> <br />
    </form>

    <?php
        if(isset($_POST['start_return'])) {
            $return_order = $_POST['return_order'];
            $_SESSION['return_order'] = $return_order;
            echoOrderDetails($connect, $return_order);
        }

        if(isset($_POST['issue_return'])) {
            $search_return_sql = "SELECT * FROM product_return WHERE r_id=$_SESSION[return_order] AND upc=$_POST[return_upc]";
            $search_result = mysqli_query($connect, $search_return_sql);
            if(!$search_result) {
                die("Query failed!");
            }
            if(mysqli_num_rows($search_result) > 0) {
                echo "<br> This item has already been returned!";
                echoOrderDetails($connect, $_SESSION['return_order']);
                
            }
            else {
                $return_sql = "INSERT IGNORE INTO Point_of_Sale.return (return_id, order_id) VALUES ($_SESSION[return_order], $_SESSION[return_order])";
                $product_return_sql = "INSERT INTO product_return (upc, r_id, return_quantity, return_price) 
                VALUES ($_POST[return_upc], $_SESSION[return_order], $_POST[return_quantity], $_POST[return_price])";
                $return_result = mysqli_query($connect, $return_sql);
                if(!$return_result) {
                    die("Return_result died!");
                }
                $product_return_result = mysqli_query($connect, $product_return_sql);
                if(!$product_return_result) {
                    die("product_return died!");
                }
                
                echo "<br> Item $_POST[return_upc] has been returned!";
            }
            
            
        }
    ?>
    
    

</body>
</html>