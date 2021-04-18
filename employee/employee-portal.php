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
           header("Location:/employee/employee-login.php");  
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
        <a href="/logout.php">Log Out</a>
    </p>
    <div>
        <a href="/employee/manage-products/add-update-product.php"> Add/Update Product </a>

        <a href="/employee/product-changes-history.php"> View Product Changes History </a>

        <a href="/employee/support-tickets.php"> Support Tickets </a>

        <a href="/employee/issue-return.php"> Issue Return </a>

        <a href = '/employee/order-summary.php'> Order lookup </a>

        <a href="/employee/sales.php"> Sales </a>

        <a href="/employee/pending-emails.php"> Pending Emails </a>
    </div>

</body>
</html>
