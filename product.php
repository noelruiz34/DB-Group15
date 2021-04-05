

<!DOCTYPE html>

<html>
<head>
	<title>Products</title>
</head>
<body>
    
	<h1 style="text-align:center;">Check Out Our Products(Best Prices Around)</h1>




    <center style="margin-top: 2%">
       
    </center>


    <?php print_r($result);

     function test()
            {
                print_r("hello");
            }
            ?>

    <?php 
include 'db.php';


    $result = $connect->query("select category_name from product_category");

    

        while($row = mysqli_fetch_array($result)){

echo "<form method='post' name='proddisp' action=''>";
 
echo'<input type="submit" id="button" name="proddisp" value ="'.$row['category_name'].'">';
echo '<input type="hidden" name="disp_this" value="'.$row['category_name'].'">';
    echo "</form>";

        }

   
    if(isset($_POST["proddisp"]))
            {
               

            $result2 = $connect->query('select p_name from product where p_category = "' .$_POST["proddisp"]. '" ');
            
 
            while($row = mysqli_fetch_array($result2)){
                
                echo"<tr><td>". $row['p_name']." ".$row['p_price']."</td></tr><br>";
            
            }

          

            
                
            }

?>


</body>
</html>



