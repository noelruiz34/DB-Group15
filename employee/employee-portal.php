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
        outline: none;
        padding: 12px 16px;
        background-color: #3A4750;
        opacity: 90%;
        color: white;
        cursor: pointer;
        width: 100%;
    }
    
    .btn:hover {
        background-color: rgba(0, 0, 0, .2);
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
                <button class="btn" onclick="location.href='/employee/manage-products/add-update-product.php'" type="button">Add/Update Product</button>
            </td>
        </tr>
        <tr>
            <td>
                <button class="btn" onclick="location.href='/employee/product-changes-history.php'" type="button">View Product Changes History</button>
            </td>
        </tr>
        <tr>
            <td>
                <button class="btn" onclick="location.href='/employee/support-tickets.php'" type="button">Support Tickets</button>
            </td>
        </tr>
        <tr>
            <td>
                <button class="btn" onclick="location.href='/employee/issue-return.php'" type="button">Issue Return</button>        
            </td>
        </tr>
        <tr>
            <td>
                <button class="btn" onclick="location.href='/employee/order-summary.php'" type="button">Order lookup </button>            
            </td>
        </tr>
        <tr>
            <td>
                <button class="btn" onclick="location.href='/employee/sales.php'" type="button">Sales</button>
            </td>
        </tr>
        <tr>
            <td>
                <a href="/employee/pending-emails.php" class = "table"> Pending Emails </a>
                <button class="btn" onclick="location.href='/employee/support-tickets.php'" type="button">Support Tickets</button>
            </td>
        </tr>
</table>

</body>
</html>
