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

<!DOCTYPE html>

<style>
    table{
    border: 1px solid black;
    margin-top: 5%;
    margin-left: auto;
    margin-right: auto;
    width: 400px;
    }
    td {
        border: 1px solid black;
        border-spacing: 10px;
    }
</style>
<html>
<head>
	<title>Product Changes Report</title>
</head>
<body>
    <!-- use join tables to make the report -->
    <h1>Product Changes Report</h1>
    <a href = /employee/employee-portal.php> Back to Employee Portal </a> <br> <br>
    <form action='' method='post'>
        <input type = "submit" name = "view_all_updates" value = "View All Updates"/><br><br>
        <label for="search"> Search Changes History By </label>
        <select id="method" name = "search_method">
            <option value="upc"> UPC</option>
            <option value="e_id"> Employee ID</option>
        </select>
        <label> Search:  </label><input type = "text" name = "search_id" class = "box" />
        <input type = "submit" name = "history_search" value = "Search"/>
        <br> <br>
    </form>
    
    <?php
        if(isset($_POST['history_search']) || isset($_POST['view_all_updates'])) {
            $search_attribute = "";
            $search_id = $_POST['search_id'];
            if($_POST['search_method'] == "upc") {
                $search_attribute = "upc";
            }
            else {
                $search_attribute = "employee_id";
            }

            if(isset($_POST['view_all_updates'])) {
                $update_sql = "SELECT * FROM product_update";
            }
            else {
                $update_sql = "SELECT * FROM product_update WHERE $search_attribute=$search_id";
            }
            
            $update_result = mysqli_query($connect, $update_sql);

            if(!$update_result) {
                die("Query failed!");
            }
            
            if(mysqli_num_rows($update_result) == 0) {
                $upper_attribute = strtoupper($search_attribute);
                echo "There are no changes for $upper_attribute: $search_id!";
            }
            else{
                echo "<table>";
                echo "<tr><td> Update ID </td><td> Update Time </td><td> Employee ID </td><td> UPC </td><td> Update Description </td></tr>";
                while($row=mysqli_fetch_array($update_result)) {
                    echo "<tr>
                    <td>$row[update_id]</td>
                    <td>$row[update_time]</td>
                    <td>$row[employee_id]</td>
                    <td>$row[upc]</td>
                    <td>$row[update_desc]</td>
                    </tr>";
                }
                echo "</table>";
            }
            
        }

    ?>

</body>
</html>