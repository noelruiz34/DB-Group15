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
    <!-- use join tables to make the report -->
    <h1>Sales</h1>
    <a href = employee-portal.php> Back to Employee Portal </a> <br> <br>
    <form action='' method='post'>
        Start Date: <input type='date' id='start' name='sales_start' required/><br>
        End Date: <input type='date' id='end' name='sales_end' required/><br> <br>
        <input type = "submit" name = "generate_report" value = "Generate Report"/>
        <br>
    </form>
    
    <?php 
        if(isset($_POST['generate_report'])) {
            $start_date = $_POST['sales_start'];
            $end_date = $_POST['sales_end'];
            $sales_sql = "SELECT * FROM Point_of_Sale.order WHERE DATE(o_time) >= '$start_date' AND DATE(o_time) <= '$end_date'";
            $result = mysqli_query($connect, $sales_sql);

            if(!$result) {
                die("query failed");
            }

            if(mysqli_num_rows($result)==0) {
                echo "There are no sales in this date range!";
            }
            else {
                echo "<table>";
                echo "<tr><td> Date </td><td> Order ID </td><td>";
                while($row=mysqli_fetch_array($result)) {
                    echo "<tr>
                    <td>" . $row['o_time'] . "</td>
                    <td>" . $row['o_id'] . "</td>
                    </tr>";
                }
                echo "</table>";
            }
            
        }
        
    ?>

    
</body>
</html>