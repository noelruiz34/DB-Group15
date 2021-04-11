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



<!DOCTYPE html>
<html>
<head>
	<title>Sales</title>
</head>
<body>
    
    <h1>Sales</h1>
    <a href = employee-portal.php> Back to Employee Portal </a>


    
</body>
</html>