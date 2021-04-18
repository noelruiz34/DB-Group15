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

<style>

    table {
        margin: auto;
        width: 100%;
        background-color: #303841;
        padding: 10px;
    }

    td {
        align: center;
        background-color: #3A4750;
    }
    a.table{
        font-size: 25px;
    }
    a.table:link, a.table:visited {
        color: white;
        text-decoration: none;
        display: inline-block;
    }

    a.table:hover, a.table:active {
        opacity: 90%;
        color: white;
    }
    td {
        text-align: center;
    }
    table {
        width: 55%;
    }

    .btn {
        border-style: ridge;
        outline: none;
        padding: 12px 16px;
        background-color: #f1f1f1;
        cursor: pointer;
    }
    
    .btn:hover {
        background-color: #ddd;
    }
    
    .btn.active {
        background-color: #666;
        color: white;
    }
</style> 
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
        <tr>
            <td>
                <a href="/employee/manage-products/add-update-product.php" class = "table" > Add/Update Product </a>
                <button class="btn" onclick="location.href='/employee/manage-products/add-update-product.php'" type="button">Return to Main</button>
            </td>
        </tr>
        <tr>
            <td>
                <a href="/employee/product-changes-history.php" class = "table"> View Product Changes History </a>
            </td>
        </tr>
        <tr>
            <td>
                <a href="/employee/support-tickets.php" class = "table" class = "table"> Support Tickets </a>
            </td>
        </tr>
        <tr>
            <td>
                <a href="/employee/issue-return.php" class = "table"> Issue Return </a>
            </td>
        </tr>
        <tr>
            <td>
                <a href = '/employee/order-summary.php' class = "table"> Order lookup </a>
            </td>
        </tr>
        <tr>
            <td>
                <a href="/employee/sales.php" class = "table"> Sales </a>
            </td>
        </tr>
        <tr>
            <td>
                <a href="/employee/pending-emails.php" class = "table"> Pending Emails </a>
            </td>
        </tr>
</table>

</body>
</html>
