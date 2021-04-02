

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


    <?php 
include 'db.php';


    $result = $connect->query("select category_name from product_category");

    echo "<table>";
    while($kid = mysqli_fetch_array($result)){
        
        echo "<tr><td>". $row['category_name']. "</td></tr>";
        
     // <button>Create account</button></a>
       // <button type="button" onclick="alert('Hello world!')">Click Me!</button>;
        
    }
    echo "</table>";


?>


</body>
</html>



