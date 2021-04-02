<?php 
include 'db.php';


    $result = $connect->query("select * from student");

    echo "<table>";
    while($kid = mysqli_fetch_array($result)){
        echo "<tr><td>". $kid['name']. "</td> <td>". $kid['major']. "</td></tr>";
    }
    echo "</table>";


?>

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




