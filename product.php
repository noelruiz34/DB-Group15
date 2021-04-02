

<!DOCTYPE html>

<html>
<head>
	<title>Products</title>
</head>
<body>
    
	<h1 style="text-align:center;">Check Out Our Products(Best Prices in Town)</h1>




    <center style="margin-top: 2%">
       
    </center>


    <?php print_r($result);?>
</body>
</html>
<?php 
include 'db.php';


    $result = $connect->query("select category_name from product_category");

    echo "<table>";
    while($kid = mysqli_fetch_array($result)){
        echo "<input type='button>";
        echo "<tr><td>". $kid['category_name']. "</td> <td>". $kid['category_id']. "</td></tr>";
    }
    echo "</table>";


?>



