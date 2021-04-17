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
    $cart_sql = "SELECT *, product.p_name, product.p_price FROM shopping_cart INNER JOIN product ON shopping_cart.upc=product.upc WHERE customer_id=$cust_id";
    
    $cart_results = mysqli_query($conn, $cart_sql);
    
    echo "<table>";
    echo "<tr><td> Product Name </td><td> Quantity </td><td> Price </td></tr> ";
    $cart_total = 0;
    
    while($row=mysqli_fetch_array($cart_results)) 
    {
      $cart_qty =  floatval($row['cart_quantity']);
      $cart_p = floatval($row['p_price']);
      $cart_price = $cart_qty * $cart_p;
      echo "<tr>
      <td>" . $row['p_name'] . "</td>
      <td>" . $row['cart_quantity'] . "</td>
      ";
         
      echo"
      <td>" . $cart_price . "</td>
      </tr>";
      echo "<td>
      ";
      $cart_total = $cart_total + $cart_price;
    }
    echo "</table>";
    echo "<br>
      <tr>
      <td> Total:  </td>
      <td>  </td>
      $$cart_total
    </tr>
    ";
  }

  echo "<input type = 'submit' name = 'pay' value = 'Pay'/><br />
  </form>
  ";


#a customer can only be fully registered if they have a billing address and a shipping address and billing info, thus we can just proceed to payment
if(isset($_POST['pay'])) {

  $cart_sql = "SELECT *, product.p_name, product.p_price FROM shopping_cart INNER JOIN product ON shopping_cart.upc=product.upc WHERE customer_id=$customer_id";

  $cart_results = mysqli_query($connect, $cart_sql);
  #run a loop to get the upc of cart items, then reduce product database p_quantity by that amount
  #then add a new order with the appropriate o_status
  $cart_price = 0;
  while($row=mysqli_fetch_array($cart_results)) 
  {
    $cart_qty =  floatval($row['cart_quantity']);
    $cart_p = floatval($row['p_price']);
    $cart_price = $cart_qty * $cart_p;
    
    $cart_total = $cart_total + $cart_price;

    
  }
  $order_sql = "SELECT * FROM order";
  $order_results = mysqli_query($connect,$order_sql);
  $new_order_num = 0;
  #add this order to a new order number
  #loop through all order numbers and generate a new one?
  while($row = mysqli_fetch_array($order_results))
  {
    $new_order_num = $new_order_num + 1;
    #after this loop, the new_order_num variable will equal the greatest number order number in the DB
    #we want 1 number past this
  }
  
  $new_order_num = $new_order_num + 1;
  $timestamp = date('Y-m-d H:i:s');

  $whole_order = $connection->prepare('INSERT INTO order VALUES (:o_id, :customer_id, :otime, :o_status)');
  if ($whole_order)
  {
    $result = $whole_order->execute ([
      'o_id' => $new_order_num,
      'customer_id' => $customer_id,
      'otime' => $timestamp,
      'o_status' => "Processing"
    ]);
    if ($whole_order) {
      $_SESSION['messages'][] = 'Order placed! Thank you for shopping with Omazon!';
    }
    $cart_sql = "SELECT * FROM shopping_cart WHERE customer_id=$cust_id";
    $cart_results = mysqli_query($conn, $cart_sql);

    while($row=mysqli_fetch_array($cart_results)) 
    {
      $deleteCart = "DELETE FROM shopping_cart WHERE customer_id = $cust_id";
      mysqli_query($conn, $deleteCart);

      #DELETE FROM `Point_of_Sale`.`shopping_cart` WHERE (`customer_id` = '1') and (`upc` = '1');
      
    }

  }

}