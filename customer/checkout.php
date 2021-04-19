<!DOCTYPE html>
<html>
<body>
  <a href="/index.php">Return to homepage</a>
  </body>
  
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
    
    displayCart($customer_id, $connect);
function displayCart($cust_id, $conn)
  {
    ob_start();
    $cart_sql = "SELECT *, p_name, p_price, p_discount FROM shopping_cart INNER JOIN product ON shopping_cart.upc=product.upc WHERE customer_id=$cust_id";
    
    $cart_results = mysqli_query($conn, $cart_sql);
    $cart_total = 0.0;
    echo "<table>";
    echo "<tr><td> Product Name </td><td> Quantity </td><td> Price </td></tr> ";
    
    
    while($row=mysqli_fetch_array($cart_results)) 
    {
      $cart_qty =  floatval($row['cart_quantity']);
      $cart_p = floatval($row['p_price']);

      $cart_disc = floatval($row['p_discount']);
      $cart_disc = $cart_disc * (1/100);
      $cart_disc = 1 - $cart_disc;
      

      if ($row['p_discount'] == 000)
      {
        #there is no discount, thus the $cart_disc should not deduct anything from the cart_p
        $cart_disc = 1;
      }

      $cart_p = $cart_p * $cart_disc;
      $cart_p = round($cart_p, 2);

      $cart_p = $cart_qty * $cart_p;
      echo "<tr>
      <td>" . $row['p_name'] . "</td>
      <td>" . $row['cart_quantity'] . "</td>
      ";
         
      echo"
      <td>$" . $cart_p . "</td>
      </tr>";
      echo "<td>
      ";
      $cart_total = $cart_total + $cart_p;
    }
    echo "</table>";
    echo "<br>
      <tr>
      <td> Total:  </td>
      <td>  </td>
      $$cart_total
    </tr>
    ";
    if ($cart_total > 0.0)
    {
      echo "<td><form method='post' action=''>
    <input type = 'submit' name = 'pay' value = 'Pay'/><br />
    </form>
    ";
    }
      else {
        echo"
        <td>Your cart is empty.</td>
        ";
      }
    
  }
  
    
  
  


#a customer can only be fully registered if they have a billing address and a shipping address and billing info, thus we can just proceed to payment
if(isset($_POST['pay'])) {
  $cart_sql = "SELECT Point_of_Sale.shopping_cart.upc, Point_of_Sale.product.p_name, Point_of_Sale.shopping_cart.cart_quantity, Point_of_Sale.product.p_price, Point_of_Sale.product.p_quantity, Point_of_Sale.product.p_discount
  FROM Point_of_Sale.shopping_cart INNER JOIN Point_of_Sale.product 
  ON Point_of_Sale.shopping_cart.upc = Point_of_Sale.product.upc 
  WHERE Point_of_Sale.shopping_cart.customer_id=$customer_id;";

  $cart_result = mysqli_query($connect, $cart_sql);
  if(!$cart_result) {
    die("Cart result failed!");
  }

  $enough_stock = true;
  while($row=mysqli_fetch_array($cart_result)) { #this loop checks to make sure we have enough stock to carry out transaction
    if($row['p_quantity'] == 0) {
      echo "Sorry! Product $row[p_name] is out of stock! <br>";
      $enough_stock = false;
    }
    elseif($row['cart_quantity'] > $row['p_quantity']) {
      echo "Sorry! You are ordering more $row[p_name] than we have in stock! We currently have $row[p_quantity] in stock. <br>";
      $enough_stock = false;
    }
  }
  if(!$enough_stock) return;

  $create_order_sql = "INSERT INTO Point_of_Sale.order (customer_id) VALUES ('$customer_id')"; #inserting new order for customer
  $create_order_result = mysqli_query($connect, $create_order_sql);
  if(!$create_order_result) {
    die("Create Order Query failed");
  }

  $new_order_sql = "SELECT * FROM Point_of_Sale.order WHERE customer_id = $customer_id ORDER BY o_time DESC";
  $new_order_result = mysqli_query($connect, $new_order_sql);
  if(!$new_order_result) {
    die("new order query failed!");
  }
  $new_order_row = mysqli_fetch_array($new_order_result);
  $new_order_id = $new_order_row['o_id']; #the order id just created
  
  $cart_result = mysqli_query($connect, $cart_sql);
  while($row=mysqli_fetch_array($cart_result)) {
    $new_p_quantity = $row['p_quantity'] - $row['cart_quantity']; #value to update current upc in loop
    $update_quantity_sql = "UPDATE Point_of_Sale.product SET p_quantity = '$new_p_quantity' WHERE upc = '$row[upc]'";
    $update_quantity_result = mysqli_query($connect, $update_quantity_sql);
    if(!$update_quantity_result) {
      die("update quantity failed!");
    }

    $product_discounted_price =  number_format(($row['p_price'] * ((100 - $row['p_discount']) / 100)), 2);
    $product_purchase_sql = "INSERT INTO Point_of_Sale.product_purchase (upc, o_id, quantity_ordered, p_price) VALUES ($row[upc], $new_order_id, $row[cart_quantity], $product_discounted_price)";
    $product_purchase_result = mysqli_query($connect, $product_purchase_sql); #Creating product purchase entities for the order
    if(!$product_purchase_result) {
      die("product purchase insert failed! on $row[upc] | $product_purchase_sql");
    }
  }

  $clear_cart_sql = "DELETE FROM Point_of_Sale.shopping_cart WHERE customer_id = $customer_id";
  $clear_cart_result = mysqli_query($connect, $clear_cart_sql);
  if(!$clear_cart_result) {
    die("Could not clear cart!");
  }

  echo "Purchase Complete! Thank you!";

  
}