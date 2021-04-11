

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
               

            $result2 = $connect->query('select p_name, p_price from product where p_category = "' .$_POST["proddisp"]. '" ');
            
 
            while($row = mysqli_fetch_array($result2)){
                
                echo "<div class='product_wrapper'>
                <form method='post' action=''>
                
    
                <div class='p_name'>".$row['p_name']."</div>
                <div class='p_price'>$".$row['p_price']."</div>
                <button type='submit' class='buy'>Add To Cart</button>
                </form>
                </div>";
            
            }

          

            
                
            }

?>


</body>
</html>



