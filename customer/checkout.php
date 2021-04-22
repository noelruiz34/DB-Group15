<!DOCTYPE html>
<script> 
          function myFunction(message) {
            alert(message);
          }

</script>
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
    <title>Checkout | Omazon.com</title>
  </head>
<body>
  <h1>Checkout</h1>
  
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
    $shipping_billing_sql = "SELECT * FROM Point_of_Sale.shipping_address INNER JOIN Point_of_Sale.billing_info
     ON Point_of_Sale.shipping_address.customer_id = Point_of_Sale.billing_info.customer_id
     WHERE shipping_address.customer_id = $cust_id";

     $shipping_billing_result = mysqli_query($conn, $shipping_billing_sql);
     if(!$shipping_billing_result) {
       die("shipping_billing query failed!");
     }

     $shipping_billing_row = mysqli_fetch_array($shipping_billing_result);

     echo "<p style='text-align:center'> Shipping Address </p>";
     echo "<table>";
     echo "<tr><th>Street</th><th>City</th><th>Zip</th><th>State</th></tr>";
     echo "<tr><td>$shipping_billing_row[street]</td><td>$shipping_billing_row[city]</td><td>$shipping_billing_row[zip]</td><td>$shipping_billing_row[state]</td></tr>";
     echo "</table> <br>";

     echo "<p style='text-align:center'> Payment Method </p>";
     echo "<table>";
     echo "<tr><th>Card Number</th><th>Expiration Date</th><th>CVV</th></tr>";
     $last_four_digits = substr($shipping_billing_row['cc_num'], -4);
     echo "<tr><td>Ending in $last_four_digits</td><td>$shipping_billing_row[exp_date]</td><td>$shipping_billing_row[cvv]</td></tr>";
     echo "</table> <br>";

    $cart_sql = "SELECT *, p_name, p_price, p_discount FROM shopping_cart INNER JOIN product ON shopping_cart.upc=product.upc WHERE customer_id=$cust_id";
    
    $cart_results = mysqli_query($conn, $cart_sql);
    $cart_total = 0.0;
    echo "<p style='text-align:center'> Cart Total </p>";
    echo "<table>";
    echo "<tr><th> Product Name </th><th> Quantity </th><th> Price </th></tr> ";
    
    
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
      <td>$" . number_format($cart_p, 2) . "</td>
      </tr>";
      

      $cart_total = $cart_total + $cart_p;
    }
    echo "</table>";
    echo "<br>
  
       <h3 style='text-align:center;'>Total: $" . number_format($cart_total, 2) . "</h3>
    ";
    $cart_total = number_format($cart_total, 2);
    if ($cart_total > 0.0)
    {
      ob_start();
      echo "<td><form method='post' action=''>
    <input style='width:50%; margin:auto; display:block;' type = 'submit' name = 'pay' value = 'Pay'/>
    </form>
    <br>
    ";
    }
      else {
        echo"
        <p style='text-align:center;'>Your cart is empty.</p>
        ";
      }
     echo '<a href="/customer/shopping-cart.php"><p style="text-align:center;">Return to shopping cart</p></a>';
     echo '<a href="/index.php"><p style="text-align:center;">Return to home</p></a> <br>';

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
      $error = "Sorry! Product $row[p_name] is out of stock!"
      echo "<script> myFunction($error) </script>"
      // echo "Sorry! Product $row[p_name] is out of stock! <br>";
      $enough_stock = false;
    }
    elseif($row['cart_quantity'] > $row['p_quantity']) {
      $error = "Sorry! You are ordering more $row[p_name] than we have in stock! We currently have $row[p_quantity] in stock."
      echo "<script> myFunction($error) </script>"
      // echo "Sorry! You are ordering more $row[p_name] than we have in stock! We currently have $row[p_quantity] in stock. <br>";
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

  ob_end_clean();
  echo "<br><h3 style='text-align:center;'>Purchase Complete! Thank you!</h3>";
  echo '<a href="/index.php"><p style="text-align:center;">Return to home</p></a> <br>';

  
}
?>

</body>

</html>