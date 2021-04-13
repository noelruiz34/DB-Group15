

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
if(!isset($_SESSION['customer'])) // If session is not set then redirect to Login Page
  {
    header("Location:customer_login.php");  
  }

$customer_id = $_SESSION['customer'];

?>
<html>
<head>
	<title>Products</title>
</head>
<body>
    <a href="index.php">Back to Home</a>
	<h1 style="text-align:center;">Check Out Our Products(Best Prices Around)</h1>




    <center style="margin-top: 2%">
       
    </center>

    <?php /*print_r($result); 

     function test()
            {
                print_r("hello");
            }
            ?>
            */
    ?> 
    <?php

    


    $result = $connect->query("select category_name from product_category");

    

        while($row = mysqli_fetch_array($result)){

echo "<form method='post' name='proddisp' action=''>";
 
echo'<input type="submit" id="button" name="proddisp" value ="'.$row['category_name'].'">';
echo '<input type="hidden" name="disp_this" value="'.$row['category_name'].'">';
    echo "</form>";

        }

   
    if(isset($_POST["proddisp"]))
            {
               

            $result2 = $connect->query('select upc, p_name, p_price, p_quantity from product where p_category = "' .$_POST["proddisp"]. '" and  p_listed=1');
            
            echo "<table>";
            echo "<tr><td> Name </td><td> Price </td></tr>";
           // echo (mysqli_num_rows($result2));
            while($row = mysqli_fetch_array($result2)){
                
                echo "<tr>
                <td>" . $row['p_name'] . "</td>
                <td>$" . $row['p_price'] . "</td>
                <td><form method='post' action=''>
                <input type = 'hidden' name = 'add_upc' value= ".$row['upc'].">
                <input type = 'hidden' name = 'iquant' value= ".$row['p_quantity'].">
                <input type = 'submit' name = 'add_to_cart' value = 'Add to Cart'/><br />
                </td>
                </form>
                </tr>";
            
            }
            echo "</table>";
        
            }


  

    if(isset($_POST['add_to_cart'])) {
       // echo("is thiseven working at this point");

       // echo "select * from shopping_cart where customer_id = ".$customer_id." and upc = ".$_POST['add_upc'];
        $quantity = 1;
        $qcheck = $connect->query("select * from shopping_cart where customer_id = ".$customer_id." and upc = ".$_POST['add_upc']);

       $int = 0;

        while($row = mysqli_fetch_array($qcheck)){
           
            $int = $int +1;
        }
                
     
        
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
            
            echo "Cart Successfully Updated!<br>";

            echo($POST['p_quantity']);
           // $connect->query("update shopping_cart set cart_quantity = cart_quantity + ".$quantity);
            

            //$quancheck = $connect->query("select p_quantity from product where upc = ".$_POST['add_upc']);
           // echo("select p_quantity from product where upc = ".$_POST['add_upc']);
            //$q = mysqli_fetch_array($quancheck['p_quantity']); //quantity of product
           // $cq = mysqli_fetch_array($qcheck['cart_quantity']);
            //$qcheck3 = $connect->query("select * from shopping_cart where customer_id = '".$customer_id."' and upc = '".$_POST['add_upc'])."'";
           /* while($row = mysqli_fetch_array($quancheck)){
                echo"found a value: ";
                echo ($row['p_quantity']);
            }*/

            

            
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




        #if upc already in cart run sql update
        #else run sql insert into
    
?>


</body>
</html>



