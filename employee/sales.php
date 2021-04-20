<?php
    include 'table-sort-scripts.php';
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


    function render_orders_and_returns_report($connect, $start_date, $end_date) {
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
        echo "<div class='column'>";
        echo "<h2>Orders</h2>";
        if(mysqli_num_rows($sales_result)==0) {
            echo "<p>There are no orders in this date range!</p>";
        }
        else {
            $avg_order_cost = $running_sold_total / mysqli_num_rows($sales_result);
            $avg_order_item = $running_item_total / mysqli_num_rows($sales_result);
            echo "<p> Average Order Cost: $" . number_format($avg_order_cost, 2);
            echo "<p> Average Number of Items Per Order: " . number_format($avg_order_item, 2);
            echo "<table>";
            echo "<tr><th> Date </th><th> Order ID </th><th> Total Cost </th><th> Number of Items </th></tr>";
            while($row=mysqli_fetch_array($sales_result)) {
                echo "<tr>
                <td>" . $row['o_time'] . "</td>
                <td>" . $row['o_id'] . "</td>
                <td>$" . $order_total_array[$row['o_id']] . "</td>
                <td>" . $order_items_array[$row['o_id']] . "</td>
                </tr>";
            }
            echo "</table>";
        }
        
        echo "</div>";

        $returns_result = mysqli_query($connect, $returns_sql);
        echo "<div class='column'>";
        echo "<h2>Returns</h2>";
        if(mysqli_num_rows($returns_result)==0) {
            echo "<p>There are no returns in this date range!</p>";
        }
        else {
            $avg_return_cost = $running_return_total/ mysqli_num_rows($returns_result);
            $avg_order_item = $running_return_item_total / mysqli_num_rows($returns_result);
            echo "<p> Average Return Amount: $" . number_format($avg_return_cost, 2);
            echo "<p> Average Number of Items Per Return: " . number_format($avg_order_item, 2);
            echo "<table>";
            echo "<tr><th> Date </th><th> Return ID </th><th> Order ID </th><th> Return Cost </th><th> Number of Items </th></tr>";
            while($row=mysqli_fetch_array($returns_result)) {
                echo "<tr>
                <td>$row[return_time]</td>
                <td>$row[return_id]</td>
                <td>$row[order_id]</td>
                <td>$" . $return_total_array[$row['return_id']] . "</td>
                <td>" . $return_items_array[$row['return_id']] . "</td>
                <tr>";

            }
            echo "</table>";
            echo "</div> </div>";
        }
    }

    function render_products_and_categories_report($connect, $start_date, $end_date) {
        $product_join_sql = "SELECT Point_of_Sale.order.o_time, Point_of_Sale.product_purchase.upc, Point_of_Sale.product.p_category, Point_of_Sale.order.o_id, Point_of_Sale.product_purchase.quantity_ordered, Point_of_Sale.product_purchase.p_price
        FROM Point_of_Sale.order INNER JOIN Point_of_Sale.product_purchase ON Point_of_Sale.order.o_id = Point_of_Sale.product_purchase.o_id
        INNER JOIN Point_of_Sale.product ON Point_of_Sale.product_purchase.upc = Point_of_Sale.product.upc
        WHERE DATE(o_time) >= '$start_date' AND DATE(o_time) <= '$end_date'";
        $product_join_result = mysqli_query($connect, $product_join_sql);
        if(!$product_join_result) {
            die("product_join Query failed!");
        }

        
        $categories_array = array();
        $products_array = array();

        while($row=mysqli_fetch_array($product_join_result)) {
            $row_cost_total = $row['quantity_ordered'] *$row['p_price'];

            if(!array_key_exists($row['p_category'],$categories_array)) {
                $categories_array[$row['p_category']] = array($row['quantity_ordered'], $row_cost_total);
            }
            else {
                $categories_array[$row['p_category']][0] += $row['quantity_ordered'];
                $categories_array[$row['p_category']][1] += $row_cost_total;
            }
            
            if(!array_key_exists($row['upc'], $products_array)) {
                $products_array[$row['upc']] = array($row['quantity_ordered'], $row_cost_total);
            }
            else {
                $products_array[$row['upc']][0] += $row['quantity_ordered'];
                $products_array[$row['upc']][1] += $row_cost_total;
            }

        }
        
        echo "<h1>Summary for Date: $start_date to $end_date</h1>";
        if(mysqli_num_rows($product_join_result) == 0){
            echo "There are no sales in this date range!";
        }
        else {
            echo "<div class='row'>";
            echo "<div class='column'>";
            echo "<h2>Sales by Category</h2>";
        
                echo "<table id='categoriesTable'>";
                echo "<tr>
                <th onclick='sortCategoriesTableStr(0)' style=color:#F44C67>Category </a></th>
                <th onclick='sortCategoriesTableInt(1)' style=color:#F44C67>Items Sold  </a></th>
                <th onclick='sortCategoriesTableInt(2)' style=color:#F44C67>Total Revenue $</a> </th>
                </tr>";
                foreach($categories_array as $category => $quantity_and_revenue) {
                    echo "<tr>
                    <td>$category</td>
                    <td>$quantity_and_revenue[0]</td>
                    <td>" . number_format($quantity_and_revenue[1], 2) . "</td>
                    </tr>";
                }
                echo "</table>";
            
            echo "</div>";
    
            echo "<div class='column'>";
            echo "<h2>Sales by Product(UPC)</h2>";
       
                echo "<table id='productTable'>";
                echo "<tr>
                <th onclick='sortProductsTableStr(0)' style=color:#ec0016> UPC </th>
                <th onclick='sortProductsTableInt(1)' style=color:#ec0016> Items Sold </th>
                <th onclick='sortProductsTableInt(2)' style=color:#ec0016> Total Revenue $</th>
                </tr>";
        
                foreach($products_array as $upc => $quantity_and_revenue) {
                    echo "<tr>
                    <td>$upc</td>
                    <td>$quantity_and_revenue[0]</td>
                    <td>" . number_format($quantity_and_revenue[1], 2) . "</td>
                    </tr>";
                }
                echo "</table>";
                echo "</div> </div>";        
        }
        
    }
?>

<!DOCTYPE html>
<html>
<style>
* {
  box-sizing: border-box;
}

.row {
  display: flex;
  margin-left:-5px;
  margin-right:-5px;
}

.column {
  flex: 50%;
  padding: 5px;
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

<script>


</script>
<script>
        function checkDateRange(){
        var start  = document.forms["dates"]['sales_start'].value;
        var end = document.forms["dates"]['sales_end'].value;

        if (new Date(start) > new Date(end))
        {
            alert("Start date must be before end date");
            var form = document.getElementById("client");
            start = "";
            end = "";
            return false;
        }
    }
</script>
<head>
	<title>Sales</title>
</head>
<body>
    <!-- use join tables to make the report -->
    <h1>Sales</h1>
    <a href = /employee/employee-portal.php> Back to Employee Portal </a> <br> <br>
    <form name="dates" action='' method='post' onsubmit="return checkDateRange()">
        <label for="view_method"> View Sales Report: </label>
        <select id="method" name = "view_method">
                <option value="orders_and_returns"> Orders and Returns</option>
                <option value="product_view"> Products and Categories</option>
        </select> <br> <br> Start Date: <input type='date' id='start' name='sales_start' required/>
                    End Date: <input type='date' id='end' name='sales_end' required/>
        <input type = "submit" name = "generate_report" value = "Generate Report"/>
        <br>
    </form>
    
    <?php 
        $start_date = $_POST['sales_start'];
        $end_date = $_POST['sales_end'];
        if(isset($_POST['generate_report']) && $_POST['view_method'] == "orders_and_returns") {
            render_orders_and_returns_report($connect, $start_date, $end_date);
        }
        if(isset($_POST['generate_report']) && $_POST['view_method'] == "product_view") {
            $_SESSION['category_sort'] = "category_revenue";
            render_products_and_categories_report($connect, $start_date, $end_date);
        }
    ?>

    
</body>

</html>