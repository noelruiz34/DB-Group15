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
    <title>Shopping Cart | Omazon.com</title>
</head>


<body>
    <div class='navbar'>
        <ul>
            <li style='float:left'><a href='/index.php' style='font-weight:900;'>Omazon<img src='/images/favicon/favicon-192.png' width='16' height='16'></a></li>
            <li style='float:left'><a href="/product-catalog.php">Browse Products</a></li>
            <?php
                if(isset($_SESSION['customer'])) {
                    echo "
                    <li><a href = '/logout.php'  style='color:#ec0016;'> Log out </a></li>
                    <li><a href='/customer/account/edit-customer-account-info.php'>My Account</a></li>
                    <li><a href='/customer/customer-orders.php'>My Orders</a></li>
                    <li><a class='active' href = '/customer/shopping-cart.php'>My Cart</a></li>
                    
                    ";
                }
                else {
                    echo "
                    <li><a href='/customer/register.php'>Register</a></li>
                    <li><a href='/customer/customer-login.php'>Log in</a></li>
                    ";
                }
            ?>
        </ul>
    </div>

    <h1 style='margin-top: 100px;margin-bottom:50px;'>Shopping Cart</h1>

  <?php
  displayCart($customer_id, $connect);
  function displayCart($cust_id, $conn)
  {
    ob_start();
    $cart_sql = "SELECT *, p_name, p_price, p_discount FROM shopping_cart INNER JOIN product ON shopping_cart.upc=product.upc WHERE customer_id=$cust_id";
    
    $cart_results = mysqli_query($conn, $cart_sql);
    
    
    $cart_total = 0.0;
    $do_once = 0;
    
    while($row=mysqli_fetch_array($cart_results)) 
    {
      $cart_qty =  floatval($row['cart_quantity']);
      $cart_p = floatval($row['p_price']);

      $cart_disc = floatval($row['p_discount']);
      $cart_disc = $cart_disc * (1/100);
      $cart_disc = 1 - $cart_disc;
      $is_empty = 0;
      $calcPreDisc = $row['p_price'] * $row['cart_quantity'];
      $calcPreDisc = number_format($calcPreDisc, 2);

      if ($row['p_discount'] == 000)
      {
        #there is no discount, thus the $cart_disc should not deduct anything from the cart_p
        $cart_disc = 1;
      }

      $cart_p = $cart_p * $cart_disc;
      $cart_p = number_format($cart_p, 2);

      
      if ($do_once == 0)
      {
        echo "<table>";
        echo "<tr><th> Product Name </th><th> Quantity </th><th> Add More </th><th>Price</th></tr> ";
        $do_once = 1;
      }

      echo "<tr>

      <td>" . $row['p_name'] . "</td>
      ";

      echo "
      <td>
      <form method='post' action=''>
      <input type = 'hidden' name = 'remove_upc' value= ".$row['upc'].">
      <input type = 'hidden' name = 'iquant' value= ".$row['p_quantity'].">
      
      <select name = qp>
      ";  
      for ($h = $row['cart_quantity']; $h >= 1; $h--) 
      {
        echo '<option value='.$h.'>'.$h.'</option>';
      }
      echo '</select>';
      echo "<input type = 'submit' name = 'remove_from_cart' value = 'Remove'/>
      </form>
      </td>
      ";

      echo "<td><form method='post' action=''>
      <input type = 'hidden' name = 'add_upc' value= ".$row['upc'].">
      <input type = 'hidden' name = 'iquant' value= ".$row['p_quantity'].">
      <select name = qp>";

      ?><select name = 'qtymod' id = 'add_upc'> <?php
      for ($h = 1; $h <=($row['p_quantity'] - $row['cart_quantity']); $h++) 
      {
        #echo ('<option selected = "selected" value = '. $row['cart_quantity'] . ' > ' . $row['cart_quantity'] . '</option');
        
        #echo '<option value='.$h.'>'.$h.'</option>';
        ?> 
        
          <option value = <?php $h ?> /option>
        <?php
        
      }
      
        echo '</select>';
        echo "<input type = 'submit' name = 'add_more_to_cart' value = 'Add'/><br />
              </form>
              ";

        echo "</td>";

       
      echo "<td>";
      $cart_p = $cart_p * $cart_qty;
      if($row['p_discount'] <= 0) {
          echo"
        <form method='post' action=''>
        <input type = 'hidden' name = 'remove_upc' value= ".$row['upc'].">
        <input type = 'hidden' name = 'add_upc' value= ".$row['upc'].">
        <input type = 'hidden' name = 'iquant' value= ".$row['p_quantity'].">
        $" . $cart_p . "
        ";

      } else {
            echo"
        <form method='post' action=''>
        <input type = 'hidden' name = 'remove_upc' value= ".$row['upc'].">
        <input type = 'hidden' name = 'add_upc' value= ".$row['upc'].">
        <input type = 'hidden' name = 'iquant' value= ".$row['p_quantity'].">
        <s>$$calcPreDisc</s> $" . $cart_p . " (-$row[p_discount]%)";
      }
      echo "</td>";
      
        echo "</tr>";
        $cart_total = $cart_total + $cart_p;
    }
  
  $cart_total = number_format($cart_total, 2);
  if ($cart_total > 0.0)
  {
    echo "</table>";
    echo "<br>
      <h3 style='text-align:center;'>Total: $$cart_total</h3>

      ";
    echo "<form method='post' action=''>
    <input style='width:50%; margin:auto; display:block;' type = 'submit' name = 'checkout' value = 'Proceed To Checkout'/><br />
    </form>
    ";
  }
    else {
        
        echo"
        <p style='text-align:center;'>Your cart is empty.<p>
        ";
        }

  if(isset($_POST['checkout'])) {
     header("Location:/customer/checkout.php");
  }

}
  


function checkEmpty($cust_id, $conn)
{
  $cart_sql = "SELECT *, product.p_name, product.p_price, product.upc FROM shopping_cart INNER JOIN product ON shopping_cart.upc=product.upc WHERE customer_id=$cust_id";
    
  $cart_results = mysqli_query($conn, $cart_sql);
  while($row=mysqli_fetch_array($cart_results)) 
  {
    if ($row['cart_quantity'] <= 0)
    {
      $deleteEmpRow = "DELETE FROM shopping_cart WHERE customer_id = $cust_id and upc = $row[upc]";
      mysqli_query($conn, $deleteEmpRow);
    }
  }
}

  

  if(isset($_POST['remove_from_cart'])) {
   

    $customer_id = $_SESSION['customer'];
    $quantity = $_POST['qp'];
    $qcheck = $connect->query("select * from shopping_cart where customer_id = ".$customer_id." and upc = ".$_POST['remove_upc']);
 
   $int = 0;
 
    while($row = mysqli_fetch_array($qcheck)){
        $int = $int +1;
    }
      
    if ($int == 0) { 
        $connect->query("insert into shopping_cart (customer_id, upc, cart_quantity) values ('".$customer_id."', '".$_POST['remove_upc']."', '".$quantity."')");
        
    }
 
    else{
        if( $_POST['iquant'] >= ($int + $quantity)){
           $connect->query("update shopping_cart set cart_quantity = cart_quantity - ".$quantity." where upc = ".$_POST['remove_upc']." and customer_id = ".$customer_id);
            }
        else{
            echo "Remove Cart Error. Cannot Delete More Than Cart Quantity";
           }
       }
       ob_end_clean();
       checkEmpty($customer_id, $connect);
       displayCart($customer_id, $connect);
 
 }

if(isset($_POST['add_more_to_cart'])) {
   

   $customer_id = $_SESSION['customer'];
   $quantity = $_POST['qp'];
   $qcheck = $connect->query("select * from shopping_cart where customer_id = ".$customer_id." and upc = ".$_POST['add_upc']);

  $int = 0;

   while($row = mysqli_fetch_array($qcheck)){
       $int = $int +1;
   }
     
   if ($int == 0) { 
       echo"Item Successfully Added to Cart!";
       $connect->query("insert into shopping_cart (customer_id, upc, cart_quantity) values ('".$customer_id."', '".$_POST['add_upc']."', '".$quantity."')");
       
   }

   else{
       if( $_POST['iquant'] >= ($int + $quantity)){
          $connect->query("update shopping_cart set cart_quantity = cart_quantity + ".$quantity." where upc = ".$_POST['add_upc']." and customer_id = ".$customer_id);
           }
       else{
           echo "You cannot exceed the available quantity. Please choose a lower quantity";
          }
      }
      ob_end_clean();
      checkEmpty($customer_id, $connect);
      displayCart($customer_id, $connect);
}
?>
</body>

</html>

