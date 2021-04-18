<!DOCTYPE html>
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
    $cart_total = 0.0;
    
    while($row=mysqli_fetch_array($cart_results)) 
    {
      $cart_qty =  floatval($row['cart_quantity']);
      $cart_p = floatval($row['p_price']);
      $cart_price = $cart_qty * $cart_p;
      if ($cart_price > 0.0)
      {
        echo "<tr>
        <td>" . $row['p_name'] . "</td>
        ";
        echo"
        <form method='post' action=''>
        <input type = 'hidden' name = 'remove_upc' value= ".$row['upc'].">
        <input type = 'hidden' name = 'iquant' value= ".$row['p_quantity'].">
        ";
        echo "<td>
        <select name = qp>
        ";
        
        for ($h = $row['cart_quantity']; $h >= 1; $h--) 
          {
            echo '<option value='.$h.'>'.$h.'</option>';
          }
        echo '</select>';
        echo "<input type = 'submit' name = 'remove_from_cart' value = 'Remove'/><br />
              </form>
              ";
              
        echo"
        <td><form method='post' action=''>
        <input type = 'hidden' name = 'remove_upc' value= ".$row['upc'].">
        <input type = 'hidden' name = 'add_upc' value= ".$row['upc'].">
        <input type = 'hidden' name = 'iquant' value= ".$row['p_quantity'].">
        <td>" . $cart_price . "</td>
        </tr>";
        echo "<td>
        <select name = qp>
        ";

        for ($h = 1; $h <=($row['p_quantity'] - $row['cart_quantity']); $h++) 
          {
            echo '<option value='.$h.'>'.$h.'</option>';
          }
        echo '</select>';
        echo "<input type = 'submit' name = 'add_more_to_cart' value = 'Add More To Cart'/><br />
              </form>
              ";
        
        $cart_total = $cart_total + $cart_price;
    echo "</table>";
    echo "<br>
      <tr>
      <td> Total </td>
      <td>  </td>
      $$cart_total
    </tr>
    ";
    }
      }
      
    if ($cart_total > 0.0)
    {
      echo "<td><form method='post' action=''>
    <input type = 'submit' name = 'checkout' value = 'Proceed To Checkout'/><br />
    </form>
    ";
    }
      else {
        echo"
        <td>Your cart is empty.</td>
        ";
      }
    
  }
  if(isset($_POST['pay'])) {
     header("Location:/customer/checkout.php");
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

        #DELETE FROM `Point_of_Sale`.`shopping_cart` WHERE (`customer_id` = '1') and (`upc` = '1');
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



