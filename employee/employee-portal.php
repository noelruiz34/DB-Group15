<?php
    include '../db.php';
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
            $result = $connect->query("select * from Point_of_Sale.employee where ssn = $employee_id");
            if ($result->num_rows > 0) {
                while($employee_info = $result->fetch_assoc())
                {      
                    echo "Hello, ".$employee_info["f_name"]." ".$employee_info["l_name"]."!";
                }
            }
        ?>
    </font>
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
                <button class="btn" onclick="location.href='/employee/pending-emails.php'" type="button">Pending Emails</button>
            </td>
        </tr>
</table>

    <p style="text-align: center;">
        <a href="/logout.php">Log Out</a>
    </p>

</body>
</html>
