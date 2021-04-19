

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
ob_start(); //added this line for login redirect hopefully it doesn't mess anything up -Bryan

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

            echo "Min Price: <select id='lp' name = 'lp' onchange='lpsel(this.value)' >";
            for ($h = 0; $h <=1000; $h++) 
            {
            echo '<option value='.$h.'>$'.$h.'</option>';
            };
            echo "</select>";
            
            echo "Max Price: <select id='up' name = 'up' onchange=upsel(this.value) >";
            for ($h = 0; $h <=1000; $h++) 
            {
            echo '<option selected value='.$h.'>$'.$h.'</option>';
            };
            echo "</select>";
            
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

        $lower = 0;
                        
            if(isset($_POST['lp']))
            {
                $lower = $_POST['lp'];
            }

            if(isset($_POST['up']))
            {
                $upper = $_POST['up'];
            }

            if ($lower > $upper)
            {
                echo"Max price must be higher than Min price.";
            }
            else
            {
//echo ($_POST['categories']);
        $result3 = $connect->query('select upc, p_name, p_price, p_quantity, p_discount from product where p_category = "' .$_POST['categories']. '" and  p_listed=1');
            
        echo "<table>";
        echo "<tr><td> Name </td><td> Price </td><td> UPC </td></tr>";
       // echo (mysqli_num_rows($result2));
        while($row = mysqli_fetch_array($result3)){

            $realp = $row['p_price'];
            if($row['p_discount'] > 0)
            {
            $realp =  number_format($row['p_price'] * ((100 - $row['p_discount']) / 100), 2);
            }
            if($realp >= $lower && $realp <= $upper)
            {
            echo "<tr>
            <td>" . $row['p_name'] . "</td>";
            if($row['p_discount'] <= 0) {
                echo "<td>$" . $row['p_price'] . "</td>";
            }
            else {
                $discountPrice = number_format($row['p_price'] * ((100 - $row['p_discount']) / 100), 2);
                echo "<td><s>$$row[p_price]</s> $discountPrice (-$row[p_discount]%)";
            }
            echo "<td>" . $row['upc'] . "</td>
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

        }
        }
        echo "</table>";
    }
    else{

     
      echo" <html>
      <h2 style='text-align:left;'>Popular Items!</h2>
        </html>";


        $popi = $connect->query("
        SELECT product_purchase.upc,  p_name, product.p_price ,p_quantity, p_discount, 
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



