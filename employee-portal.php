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
    session_start();
    if(!isset($_SESSION['employee'])) // If session is not set then redirect to Login Page
       {
           header("Location:employee_login.php");  
       }
    
    $employee_id = $_SESSION['employee']; //Use this for queries on employee
?>

<!DOCTYPE html> <!-- This page is for after an employee logs in -->
<html>
<head>
	<title>Employee Portal</title>
</head>
<body>
    
	<h1>Employee Portal</h1>

    <font size="+1"> <!-- Not sure if this is necessary -->
       <?php
            $sql = "SELECT f_name, l_name FROM employee WHERE employee_id=$employee_id";
            $result = mysqli_query($connect, $sql);
            $row = mysqli_fetch_array($result);
            echo "Hello, " . $row['f_name'] . " " . $row['l_name'] . "!";
        ?>
    </font>
    <p align="left">
        <a href="logout.php">Log Out</a>
    </p>
    
    <h1><a href="add-update-product.php"> Add/Update Product </a></h1>

    <!--<a href="add_product_category.php"><button>Add Product Category</button></a>
    <a href="add_product_category.php"><button>Update Product Category</button></a>
    <p><label>Search Product Update History  :</label><input type = "text" name = "product_update_history" class = "box"/><br /><br /></p>
    -->
    <h1><a href="support-tickets.php"> Support Tickets </a></h1>

    <h1><a href="sales.php"> Sales </a></h1>

    <h1><a href="pending-emails.php"> Pending Emails </a></h1>

</body>
</html>