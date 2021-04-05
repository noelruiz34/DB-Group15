

<!DOCTYPE html>

<html>
<head>
	<title>Products</title>
</head>
<body>
    
	<h1 style="text-align:center;">Check Out Our Products(Best Prices Around)</h1>




    <center style="margin-top: 2%">
       
    </center>


    <?php print_r($result);?>


    <?php 
include 'db.php';


    $result = $connect->query("select category_name from product_category");

    
        echo "<table>";
        while($row = mysqli_fetch_array($result)){
            //echo "<tr><td>". $row['category_name']. "</td></tr>";

            //print_r($row['category_name']);
            function test()
            {
                print_r("hello");
            }
            
            echo "<button onclick = 'test()' >".$row['category_name']. "</button>";
/*
            echo "<input type='submit' name=".$row['category_name']." value = 'submit'>";
            if(isset($_POST['submit'])) {
                print_r("Hello");
                }*/


        }
        echo "</table>";
    //


?>


</body>
</html>



