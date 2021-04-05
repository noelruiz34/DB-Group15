<?php
    $dbServername = "database-1.cgnsxr0vmecq.us-east-2.rds.amazonaws.com";
    $dbUser = "admin";
    $dbPass = "12345678";
    $dbName = "Point_of_Sale";
    $connect = mysqli_connect($dbServername, $dbUser, $dbPass, $dbName);
    if(mysqli_connect_errno())
    {
        die("connection Failed! " . mysqli_connect_error());
    }
?>

<!DOCTYPE html> <!-- This page is for after an employee logs in -->
<html>
<head>
	<title>Employee Portal</title>
</head>
<body>
    
	<h1>Employee Portal</h1>

    <p align="right">
        <a href="index.php"><button>Log Out</button></a>
    </p>

    <font size="+1"> <!-- Not sure if this is necessary -->
        Hello "insert login name here"!
    </font>

    <h1><a href="add-update-product.php"> Add/Update Product </a></h1>

    <!--<a href="add_product_category.php"><button>Add Product Category</button></a>
    <a href="add_product_category.php"><button>Update Product Category</button></a>
    <p><label>Search Product Update History  :</label><input type = "text" name = "product_update_history" class = "box"/><br /><br /></p>
    -->
    <h1><a href="support_tickets.php"> Support Tickets </a></h1>

    <h1><a href="sales.php"> Sales </a></h1>

</body>
</html>
