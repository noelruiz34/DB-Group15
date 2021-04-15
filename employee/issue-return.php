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
                echo "<form action='' method=post>";
                echo "<table>";
                echo "<tr><td> UPC </td><td> Product Name </td><td> Quantity </td><td> Price </td></tr>";
                while($row=mysqli_fetch_array($order_result)) {
                    echo "<tr>
                    <td>$row[upc]</td>
                    <td>$row[p_name]</td>
                    <td>$row[quantity_ordered]</td>
                    <td>$row[p_price]</td>
                    <td><input type = checkbox name = $row[upc] value = 'Return'/><br />
                    </tr>";
                }
                echo "</table> <br>";
                echo "<input type = submit name = issue_return value = 'Issue Return'/><br><br />";
                echo "</form>";
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
        if(isset($_POST['view_all_returns'])) {
            $return_sql = "SELECT * FROM Point_of_Sale.return";
            $return_result = mysqli_query($connect, $return_sql);
            if(!$return_result) {
                die("View all returns query failed!");
            }

            echo "<table>";
            echo "<tr><td> Return ID </td><td> Order ID </td><td> Return Time </td></tr>";
            while($row=mysqli_fetch_array($return_result)) {
                echo "<tr>
                <td>$row[return_id]</td>
                <td>$row[order_id]</td>
                <td>$row[return_time]</td>
                <tr>";
            }
            echo "</table>";
        }

        if(isset($_POST['start_return'])) {
            $return_order = $_POST['return_order'];
            $_SESSION['return_order'] = $return_order;
            echoOrderDetails($connect, $return_order);
        }

        if(isset($_POST['issue_return'])) {
            $order_join_sql = "SELECT Point_of_Sale.product_purchase.upc, Point_of_Sale.product.p_name, Point_of_Sale.product_purchase.quantity_ordered, Point_of_Sale.product_purchase.p_price
            FROM Point_of_Sale.order INNER JOIN Point_of_Sale.product_purchase ON Point_of_Sale.order.o_id = Point_of_Sale.product_purchase.o_id
            JOIN Point_of_Sale.product ON Point_of_Sale.product.upc = Point_of_Sale.product_purchase.upc
            WHERE Point_of_Sale.order.o_id = $_SESSION[return_order]";
            $order_result = mysqli_query($connect,$order_join_sql);
            
            if(!$order_result) {
                die("order_result Query failed!");
            }
            
            $good_to_return = true;
            $upc_array = array();
            while($row=mysqli_fetch_array($order_result)) {
                if(isset($_POST[$row['upc']])){
                    $search_return_sql = "SELECT * FROM product_return WHERE o_id=$_SESSION[return_order] AND upc=$row[upc]";
                    $search_result = mysqli_query($connect, $search_return_sql);
                    if(!$search_result) {
                        die("Query failed!");
                    }
                    if(mysqli_num_rows($search_result) > 0) {
                        echo "Item $row[upc] has already been returned!";
                        $good_to_return = false;
                        break;
                    }
                    else {
                        $upc_array[$row['upc']] = array($row['quantity_ordered'], $row['p_price']);
                    } 
                }
            } 

            if($good_to_return) {
                $return_sql = "INSERT INTO Point_of_Sale.return (order_id) VALUES ($_SESSION[return_order])";
                $return_result = mysqli_query($connect, $return_sql);
                if(!$return_result) {
                    die("return_result Query failed!");
                }
                $latest_return_sql = "SELECT * FROM Point_of_Sale.return WHERE order_id = $_SESSION[return_order] ORDER BY return_time DESC";
                $latest_result = mysqli_query($connect, $latest_return_sql);
                if(!$latest_result) {
                    die("latest_result Query failed!");
                }
                $latest_row = mysqli_fetch_array($latest_result);
                $return_id = $latest_row['return_id'];

                foreach($upc_array as $upc => $quantity_and_price) {
                    $product_return_sql = "INSERT INTO product_return (upc, r_id, o_id, return_quantity, return_price)
                    VALUES ($upc, $return_id, $_SESSION[return_order], $quantity_and_price[0], $quantity_and_price[1])"; 
                    $product_return_result = mysqli_query($connect, $product_return_sql);
                    if(!$product_return_result) {
                        die("Product return result failed!");
                    }
                    echo "Sucessfully returned item: $upc <br>";
                }
            }
            else {
                unset($upc_array);
            }
            
            echoOrderDetails($connect, $_SESSION['return_order']);
        }
    ?>
    
    

</body>
</html>