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
    <table>
        <tr href="/employee/manage-products/add-update-product.php"> Add/Update Product </tr>

        <tr href="/employee/product-changes-history.php"> View Product Changes History </tr>

        <tr href="/employee/support-tickets.php"> Support Tickets </tr>

        <tr href="/employee/issue-return.php"> Issue Return </tr>

        <tr href = '/employee/order-summary.php'> Order lookup </tr>

        <tr href="/employee/sales.php"> Sales </tr>

        <tr href="/employee/pending-emails.php"> Pending Emails </tr>
    </table>

</body>
</html>
