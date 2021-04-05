

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

    
        //echo "<table>";
        while($row = mysqli_fetch_array($result)){
        $cat =  $row['category_name'];
        echo($cat);

echo "<form method='post' name='proddisp' action=''>";
 
echo'<input type="submit" id="button" name="proddisp" value ='.$row['category_name'].'>';
echo '<input type="hidden" name="disp_this" value="'.$row['category_name'].'">';
    echo "</form>";

        }


      //  echo "</table>";
    //
   
    if(isset($_POST["proddisp"]))
            {
               

            /*echo"print_r('Hello')";
            print_r('hello');
            echo"hello";*/
            $result2 = $connect->query('select p_name from product where p_category = "' .$_POST["proddisp"]. '" ');
            
            //where p_category ".$_POST["proddisp"]. "
            //$pcat = $_GET['value'];

            while($row = mysqli_fetch_array($result2)){
                //echo($row['p_name']);

                echo"<tr><td>". $row['p_name']. "</td></tr><br>";
                
                

            }

          

            
                
            }

?>


</body>
</html>



