

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
            //echo "<tr><td>". $row['category_name']. "</td></tr>";

            //print_r($row['category_name']);
           /* function test()
            {
                print_r("hello");
            }*/
            
           // echo "<button>".$row['category_name']. "</button>";

            //echo "<input type='submit' name=".$row['category_name']." value = ".$row['category_name']." id ='submit'>";
            //echo "<input type='button' onclick='test()' name =".$row['category_name']." value = ".$row['category_name']." />";
/*
            echo '<form method="post">';
            echo '<u>'.$row_all["name"].'</u>';

            echo '<br>';

            echo '<button name='.$row['category_name'].' value='.$row['category_name'].' type="submit">'.$row['category_name'].'</button>';

            echo '<hr>';
        echo '</form>';
*/

echo "<form method='post' name='proddisp' action=''>";
 
echo'<input type="submit" id="button" name="proddisp" value =' .$row['category_name']. ' >';
echo '<input type="hidden" name="disp_this" value="'.$row['category_name'].'">';
    echo "</form>";

        }


      //  echo "</table>";
    //
   
    if(isset($_POST["proddisp"]))
            {

            echo"print_r('Hello')";
            print_r('hello');
            echo"hello";
                
            }

?>


</body>
</html>



