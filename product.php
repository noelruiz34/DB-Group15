

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
            echo "<tr><td>". $row['category_name']. "</td></tr>";
        }
        echo "</table>";
    //


?>


</body>
</html>



