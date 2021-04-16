<!DOCTYPE html>
<body>
  <a href="/index.php">Return to homepage</a>
  </body>
  <?php>
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
displayCart($customer_id,$connect);
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
      <select name = qp>
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

  #retrieve billing info from customer if they have it
  function getBilling($cust_id,$conn)
  {
    #First thing to do is check if this customer has billing info at all. If 
    $billing_sql = "SELECT *, * FROM shopping_cart FULL OUTER JOIN billing_info ON shopping_cart.customer_id=billing_info.customer_id WHERE customer_id=$cust_id";
    
    $billing_results = mysqli_query($conn, $billing_sql);
    echo "<tr>
      <td>" . $row['cc_num'] ."</td>";

  }

  
    #
    ?>
    
  





