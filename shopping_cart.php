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
      header("Location:customer-login.php");  
    }

  $customer_id = $_SESSION['customer'];
  
  $cart_sql = "SELECT * FROM shopping_cart WHERE customer_id=$customer_id";
  $cart_results = mysqli_query($connect, $cart_sql);
  echo "<table>";
  echo "<tr><td> Product Name </td><td> Quantity </td></tr> ";
  while($row=mysqli_fetch_array($cart_results)) {
    echo "<tr>
    <td>" . $row['p_name'] . "</td>
    <td>" . $row['cart_quantity'] . "</td>
    </tr>";
  }
  echo "</table>";

?>
<div class="cart">
<?php
if(isset($_SESSION["shopping_cart"])){
    $total_price = 0;
?> 
<table class="table">
<tbody>
<tr>
<td></td>
<td>ITEM NAME</td>
<td>QUANTITY</td>
<td>UNIT PRICE</td>
<td>ITEMS TOTAL</td>
</tr> 
<?php 
foreach ($_SESSION["shopping_cart"] as $product){
?>
<tr>

<td><?php echo $product["p_name"]; ?><br />
<form method='post' action=''>
<input type='hidden' name='code' value="<?php echo $product["code"]; ?>" />
<input type='hidden' name='action' value="remove" />
<button type='submit' class='remove'>Remove Item</button>
</form>
</td>
<td>
<form method='post' action=''>
<input type='hidden' name='upc' value="<?php echo $product["upc"]; ?>" />
<input type='hidden' name='action' value="change" />
<select name='p_quantity' class='p_quantity' onChange="this.form.submit()">
<option <?php if($product["p_quantity"]==1) echo "selected";?>
value="1">1</option>
<option <?php if($product["p_quantity"]==2) echo "selected";?>
value="2">2</option>
<option <?php if($product["p_quantity"]==3) echo "selected";?>
value="3">3</option>
<option <?php if($product["p_quantity"]==4) echo "selected";?>
value="4">4</option>
<option <?php if($product["p_quantity"]==5) echo "selected";?>
value="5">5</option>
</select>
</form>
</td>
<td><?php echo "$".$product["p_price"]; ?></td>
<td><?php echo "$".$product["p_price"]*$product["p_quantity"]; ?></td>
</tr>
<?php
$total_price += ($product["p_price"]*$product["p_quantity"]);
}
?>
<tr>
<td colspan="5" align="right">
<strong>TOTAL: <?php echo "$".$total_price; ?></strong>
</td>
</tr>
</tbody>
</table> 
  <?php
}else{
 echo "<h3>Your cart is empty!</h3>";
 }
?>
</div>
 
<div style="clear:both;"></div>
 
<div class="message_box" style="margin:10px 0px;">
<?php echo $status; ?>
</div>