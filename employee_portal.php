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

    <?php
        $sql = "SELECT * FROM product_category";
        $result = mysqli_query($connect,$sql);
        if(!$result) {
            die("Query Failed!");
        }
        while($row=mysqli_fetch_array($result)) {
            echo $row['category_name'];
        }
        
    ?>

    <h1>Product</h1>
    <a href="add_product.php"><button>Add Product</button></a>
    <a href="update_product.php"><button>Update Product</button></a>
    <a href="add_product_category.php"><button>Add Product Category</button></a>
    <a href="add_product_category.php"><button>Update Product Category</button></a>
    <p><label>Search Product Update History  :</label><input type = "text" name = "product_update_history" class = "box"/><br /><br /></p>

    <h1>Support Tickets</h1>


    <a href="view_all_tickets.php"><button>View All Tickets</button></a>

        
    <a href="update_tickets.php"><button>Update Ticket</button></a>
    <p><label>Search Support Ticket  :</label><input type = "text" id = "support_ticket" name = "support_ticket" class = "box"/><br /><br /></p>

    <h1>Sales</h1>
    <input type = "submit" value = " Generate Sales Report "/><br />
    Search Sales for Date: <input type='month' id='exp_date' name='exp_date'/><br/>



</body>
</html>
