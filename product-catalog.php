

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

    <style>
  .hide { position:absolute; top:-1px; left:-1px; width:1px; height:1px; }
</style>

<iframe name="hiddenFrame" class="hide"></iframe>

	<title>Omazon.com: The Point-Of-Sale System For All Your Needs</title>
	<title>Product Catalog | Omazon.com</title>
</head>
<body>
    <div class='navbar'>
        <ul>
            <li style='float:left'><a href='/index.php' style='font-weight:900;'>Omazon<img src='/images/favicon/favicon-192.png' width='16' height='16'></a></li>
            <li style='float:left'><a class='active' href="/product-catalog.php">Browse Products</a></li>
            <?php
                if(isset($_SESSION['customer'])) {
                    echo "
                    <li><a href = '/logout.php'  style='color:#ec0016;'> Log out </a></li>
                    <li><a href='/customer/account/edit-customer-account-info.php'>My Account</a></li>
                    <li><a href='/customer/customer-orders.php'>My Orders</a></li>
                    <li><a href = '/customer/shopping-cart.php'>My Cart</a></li>
                    
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

    
	<h1 style='margin-top: 100px;margin-bottom:45px;'>Product Catalog</h1>
    
    <?php $path = $_SERVER['DOCUMENT_ROOT']; $path .= '/error-message.php'; require_once $path; ?>
    <br>
    <img style='margin: auto; width:35%;display:block; margin-bottom:26px' src='/images/salebanner.png'>
    

    
    <br>
    <?php


        /*
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
            <td>" . $row2['p_name'] . "</td>";

            if($row2['p_discount'] <= 0) {
                echo "<td>$" . $row2['p_price'] . "</td>";
            }
            else {
                $discountPrice = number_format($row2['p_price'] * ((100 - $row2['p_discount']) / 100), 2);
                echo "<td><s>$$row2[p_price]</s> $discountPrice (-$row2[p_discount]%)";
            }


            echo"
            <td>" . $row2['upc'] . "</td>
            <td><form method='post' action=''>
            <input type = 'hidden' name = 'add_upc' value= ".$row2['upc'].">
            <input type = 'hidden' name = 'iquant' value= ".$row2['p_quantity'].">";
           
            if ($row2['p_quantity'] >= 1) {
                echo '<select name = qp>';
                for ($h = 1; $h <= $row2['p_quantity']; $h++) 
                {
                echo '<option value='.$h.'>'.$h.'</option>';
                }
                echo '</select>';


                echo "<td><input type = 'submit' name = 'add_to_cart' value = 'Add to Cart'/><br />
                </td>";
                
            } else {
                echo "<td>Out of Stock<br />
                </td>";
            }
            echo "</form></tr>";

           
        }
        echo "</table>";
        ?>




    <?php*/

    $_SESSION['catty'];
    $_SESSION['ubnd'];
    $_SESSION['lbnd'];

    if(isset($_POST['catsel']))
{
    $_SESSION['catty'] = $_POST['categories'];
    $_SESSION['ubnd'] = $_POST['up'];
    $_SESSION['lbnd'] =  $_POST['lp'];
    
}

if(!isset($_SESSION['catty']))
{

        $_SESSION['catty'] = 'All';
        $_SESSION['lbnd'] = 0;
        $_SESSION['ubnd'] =  1000000;
    
    
}



    $result = $connect->query("select category_name from product_category");
  

                
            echo"<div class='shade-content' style='width:20%; margin: 0 auto; margin-bottom: 50px; padding-top: 45px; padding-bottom:35px;'><h2>View Products</h2><form action='' method='post'>";

            echo "Min Price: <input type='number' min='0' max='1000000' id='lp' name = 'lp' value=".$_SESSION['lbnd'].">";





            
            echo "Max Price: <input type='number' min='' max='1000000' id='up' name = 'up'  value=".$_SESSION['ubnd'].">";
               
            echo "Choose Category:
    <select id='categories' name='categories' required>";
    echo "<option value='All'";
    if ($_SESSION['catty'] == 'All') {
        echo "selected";
    }    
    echo ">All</option>";
    while ($catRow = mysqli_fetch_array($result)) {
        echo "<option value='" . $catRow['category_name'] . "' ";
        if ($catRow['category_name'] == $_SESSION['catty']) {
            echo "selected";
        }
        echo ">" . $catRow['category_name'] . "</option>";
    }
    
    echo "<option value='Clearance'";
    if ($_SESSION['catty'] == 'Clearance') {
        echo "selected";
    }    
    echo ">Clearance</option>";
    echo'<input style="margin-top:32px" type="submit" name="catsel" value="Choose options">';
    echo '</form></div>';
  

if(isset($_POST['catsel']))
{
    $_SESSION['catty'] = $_POST['categories'];
    $_SESSION['ubnd'] = $_POST['up'];
    $_SESSION['lbnd'] =  $_POST['lp'];
    
}

    
    $upper = $_SESSION['ubnd'];
    $lower = $_SESSION['lbnd'];


    if(isset($_SESSION['catty']))
    {
              
            
            if ($_POST['lp']> $_POST['up'])
            {
                echo"Max price must be higher than Min price.";
                $_SESSION['messages'][] = 'Max price must be higher than Min price.';
                header("Location:/product-catalog.php");
                
            }
            else
            {

            

        $result3 = $connect->query('select upc, p_name, p_price, p_quantity, p_discount from product where p_category = "'.$_SESSION['catty'].'" and  p_listed=1');
        if ($_SESSION['catty'] == 'All')
        {
            $result3 = $connect->query('select upc, p_name, p_price, p_quantity, p_discount from product where p_listed=1 order by p_name asc');
        }

        if ($_SESSION['catty'] == 'Clearance')
        {
            $result3 = $connect->query('select upc, p_name, p_price, p_quantity, p_discount from product where p_listed=1 and p_discount >20');
        }

        echo "<table style='width:60%'>";
        echo "<tr><th> Name </th><th> Price </th><th> UPC </th><th></th></tr>";
       // echo (mysqli_num_rows($result2));
       $int = 0;
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
                echo "<td>$" . number_format($row['p_price'],2) . "</td>";
            }
            else {
                $discountPrice = number_format($row['p_price'] * ((100 - $row['p_discount']) / 100), 2);
                echo "<td><s>$$row[p_price]</s> $$discountPrice (-$row[p_discount]%)";
            }

            
            $customer_id2 = $_SESSION['customer'];   
            $qcheck2 = $connect->query("select cart_quantity from shopping_cart where customer_id = ".$customer_id2." and upc = ".$row['upc']);

            $int = 0;
            
            while($qrow= mysqli_fetch_array($qcheck2)){
               
                $int = $qrow['cart_quantity'];
            }
            
            echo "<td>" . $row['upc'] . "</td>  <td>

            
           <form method='post' action='' '>
            <input type = 'hidden' name = 'add_upc' value= ".$row['upc'].">
            <input type = 'hidden' name = 'iquant' value= ".$row['p_quantity'].">";
           
            if ($row['p_quantity'] > 0) {
                
                echo '<select name = qp>';
                for ($h = 1; $h <=$row['p_quantity']; $h++) 
                {
                echo '<option value='.$h.'>'.$h.'</option>';
                }
                echo '</select>';
            
                echo "<input type = 'submit' name = 'add_to_cart' value = 'Add to Cart' />";
                if ($int > 0)
                {
                echo"$int in cart";
                }
            } else {
                echo "<p style='color:#ec0016;'>Out of Stock</p>";
            }
            echo "</td>
            
            </tr>
            </form>";
        }

        }
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
        $qcheck = $connect->query("select cart_quantity from shopping_cart where customer_id = ".$customer_id." and upc = ".$_POST['add_upc']);

        $int = 0;
            
        while($row= mysqli_fetch_array($qcheck)){
           
            $int = $row['cart_quantity'];
        }
             
        if($quantity == 0)
        {

            $_SESSION['messages'][] = 'ERROR: Item is out of stock! Please check back later.';
            header("Location:/product-catalog.php");
        }

        else
        {
             
        if ($int == 0) { 
            
            $connect->query("insert into shopping_cart (customer_id, upc, cart_quantity) values ('".$customer_id."', '".$_POST['add_upc']."', '".$quantity."')");
            $_SESSION['messages'][] = 'Item successfully added to cart!';
            header("Location:/product-catalog.php");
            
        }

        else{
                  
            if( $_POST['iquant'] >= ($int + $quantity)){
             $connect->query("update shopping_cart set cart_quantity = cart_quantity + ".$quantity." where upc = ".$_POST['add_upc']." and customer_id = ".$customer_id);
             $_SESSION['messages'][] = 'Cart Succesfully Updated!';
                header("Location:/product-catalog.php");
                
            }
            else{
                $_SESSION['messages'][] = 'ERROR: You cannot exceed the available quantity. Please choose a lower quantity.';
                header("Location:/product-catalog.php");
        }

                     

        }
    }



    


    }




     
?>

<div class='footer'>
        <div class='row'>
            <div class='column'>
                <div style='padding-left:30%; padding-right: 20px; padding-top:0px; margin:32px;'>
                    <h3 style='margin-bottom: 6px;'>Omazon<img src='/images/favicon/favicon-192.png' width='26' height='26'></h3>
                    <p style='padding:0;'>Omazon is a fictional company conceived for the purpose of a database class project. There is no intention of profit or infringement of copyright. However, it still has many functionalities that a typical ecommerce website would have.</p>
                </div>
            </div>

            <div class='column' style='flex:25%'>
                <div style='padding-left: 20px; padding-right: 30%; padding-top:0px; margin:32px; text-align:left;'>
                    <p>
                        <a href="/index.php">Home</a> | 
                        <a href="/product-catalog.php">Products</a> | 
                        <a href="/customer/register.php">Register</a> | 
                        <a href="/about.html">About</a>
                    </p>
                    <p><a href="/employee/employee-login.php">Employee Portal</a></p>
                    <p class='copyright'>Omazon © 2021</p>
                </div>
            </div>
        </div>
    </div>


</body>
</html>



