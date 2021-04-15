

<!DOCTYPE html>
<?php
$dbServername = "database-1.cgnsxr0vmecq.us-east-2.rds.amazonaws.com";
$dbUser = "admin";
$dbPass = "12345678";
$dbName = "Point_of_Sale";

$connect = mysqli_connect($dbServername, $dbUser, $dbPass, $dbName) or die("Unable to Connect to '$dbServername'");
// mysqli_select_db($connect, $dbName) or die("Could not open the db '$dbName'");
if($connect->connect_error) {
    die('Bad connection'. $connect->connect_error);
}

session_start();
ob_start();

?>
<html>
<head>
	<title>Products</title>
</head>
<body>
    <a href="/index.php">Back to Home</a>
	<h1 style="text-align:center;">Check Out Our Products(Best Prices Around)</h1>




    <center style="margin-top: 2%">
       
    </center>

    <?php

    


    $result = $connect->query("select category_name from product_category");
  

 
            echo"<form action='' method='post'>";

            echo "Choose Category:
    <select id='categories' name='categories' required>";
    while ($catRow = mysqli_fetch_array($result)) {
        echo "<option value='" . $catRow['category_name'] . "' ";
        if ($catRow['category_name'] == $row['p_category']) {
            echo "selected";
        }
        echo ">" . $catRow['category_name'] . "</option>";
    }
    echo'<input type="submit" name="catsel" vlaue="Choose options">';
    echo('</form>');

    if(isset($_POST['catsel']))
    {
//echo ($_POST['categories']);
        $result3 = $connect->query('select upc, p_name, p_price, p_quantity from product where p_category = "' .$_POST['categories']. '" and  p_listed=1');
            
        echo "<table>";
        echo "<tr><td> Name </td><td> Price </td><td> UPC </td></tr>";
       // echo (mysqli_num_rows($result2));
        while($row = mysqli_fetch_array($result3)){
            
            echo "<tr>
            <td>" . $row['p_name'] . "</td>
            <td>$" . $row['p_price'] . "</td>
            <td>" . $row['upc'] . "</td>
            <td><form method='post' action=''>
            <input type = 'hidden' name = 'add_upc' value= ".$row['upc'].">
            <input type = 'hidden' name = 'iquant' value= ".$row['p_quantity'].">";
           
            echo '<select name = qp>';
            for ($h = 1; $h <=$row['p_quantity']; $h++) 
            {
            echo '<option value='.$h.'>'.$h.'</option>';
            }
            echo '</select>';


           echo "<input type = 'submit' name = 'add_to_cart' value = 'Add to Cart'/><br />
            </td>
            </form>
            </tr>";
        
        }
        echo "</table>";
    }
    else{

     
      echo" <html>
      <h2 style='text-align:left;'>Popular Items!</h2>
        </html>";


        $popi = $connect->query("
        SELECT product_purchase.upc,  p_name, product.p_price ,p_quantity, 
COUNT(product_purchase.upc) AS val
 FROM Point_of_Sale.product_purchase
INNER JOIN Point_of_Sale.product ON product_purchase.upc = product.upc
GROUP BY product_purchase.upc
ORDER BY `val` DESC
LIMIT 3;");


echo "<table>";
echo "<tr><td> Name </td><td> Price </td><td> UPC </td></tr>";
        
        
        while($row2 = mysqli_fetch_array($popi)){
            echo "<tr>
            <td>" . $row2['p_name'] . "</td>
            <td>$" . $row2['p_price'] . "</td>
            <td>" . $row2['upc'] . "</td>
            <td><form method='post' action=''>
            <input type = 'hidden' name = 'add_upc' value= ".$row2['upc'].">
            <input type = 'hidden' name = 'iquant' value= ".$row2['p_quantity'].">";
           
            echo '<select name = qp>';
            for ($h = 1; $h <=$row2['p_quantity']; $h++) 
            {
            echo '<option value='.$h.'>'.$h.'</option>';
            }
            echo '</select>';


           echo "<input type = 'submit' name = 'add_to_cart' value = 'Add to Cart'/><br />
            </td>
            </form>
            </tr>";
           
           
        }
        echo "</table>";

        
    }

  

    if(isset($_POST['add_to_cart'])) {
        
    
       if(!isset($_SESSION['customer'])) // If session is not set then redirect to Login Page
        {
            ob_start();
            header("Location: /customer/customer-login.php");

        }

        $customer_id = $_SESSION['customer'];
        $quantity = $_POST['qp'];
        $qcheck = $connect->query("select * from shopping_cart where customer_id = ".$customer_id." and upc = ".$_POST['add_upc']);

        $int = 0;

        while($row = mysqli_fetch_array($qcheck)){
           
            $int = $int +1;
        }
             
        if($quantity == 0)
        {

            echo"Item is out of stock! Please check back later<br>";
        }

        else
        {
     
        
       // $connect->query("insert into shopping_cart (customer_id, upc, cart_quantity) values ('".$customer_id."', '".$_POST['add_upc']."', '".$quantiy."')");
        if ($int == 0) { 
            echo"Item Successfully Added to Cart!";
            
            $connect->query("insert into shopping_cart (customer_id, upc, cart_quantity) values ('".$customer_id."', '".$_POST['add_upc']."', '".$quantity."')");
            /*echo "cart updated";
            $qcheck2 = $connect->query("select * from shopping_cart where customer_id = '".$customer_id."' and upc = '".$_POST['add_upc'])."'";

            while($row5 = mysqli_fetch_array($qcheck2)){
                
                echo( $row5['upc']);
            
            }

*/

            
        }

        else{
            
           

            //echo($_POST['iquant']);


           // $connect->query("update shopping_cart set cart_quantity = cart_quantity + ".$quantity);
            

           // echo("select p_quantity from product where upc = ".$_POST['add_upc']);
            //$q = mysqli_fetch_array($quancheck['p_quantity']); //quantity of product
           // $cq = mysqli_fetch_array($qcheck['cart_quantity']);
            //$qcheck3 = $connect->query("select * from shopping_cart where customer_id = '".$customer_id."' and upc = '".$_POST['add_upc'])."'";
           /* while($row = mysqli_fetch_array($quancheck)){
                echo"found a value: ";
                echo ($row['p_quantity']);
            }*/

            if( $_POST['iquant'] >= ($int + $quantity)){
                echo "Cart Successfully Updated!<br>";
             $connect->query("update shopping_cart set cart_quantity = cart_quantity + ".$quantity." where upc = ".$_POST['add_upc']." and customer_id = ".$customer_id);
                
            }
            else{
                echo "You cannot exceed the available quantity. Please choose a lower quantity";
        }

            

            
          /*
            if ($q >= $cq)
            {
               // $connect->query("update shopping_cart set cart_quantity = cart_quantity + ".$quantity);
                echo "item in cart";
            }

            else{
                echo "You cannot add more than the available quantity";



            }
*/
        }
    }
    }




        #if upc already in cart run sql update
        #else run sql insert into
    
?>


</body>
</html>



