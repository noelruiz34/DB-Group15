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

?>

<!DOCTYPE html>
<html>
<head>
	<title>Support Tickets</title>
</head>
<body>
	<h1>Support Tickets</h1>
    <p align='right'>
        <a href = 'employee_portal.php'> Back to Home </a>
    </p>
    
    <form action="" method="post">
        <input type = "submit" name = "view_all_reports" value = "View All Reports"/><br />
    </form>

    <form action="" method="post">
        <label> Search For Support Ticket (ID): </label><input type = "text" name = "ticket_id" class = "box" />
        <input type = "submit" name = "search_ticket" value = "Search"/> <br /> <br />
    </form>
   
    <?php
        if(isset($_POST['view_all_reports'])) {
            $sql = "SELECT * FROM support_ticket";
            $result = mysqli_query($connect,$sql);
            if(!$result) {
                die("Query Failed!");
            }
    
            echo "<table>";
                echo "<tr><td> Order ID </td><td> Category </td><td> Status </td></tr>";
                while($row=mysqli_fetch_array($result)){
                    echo "<tr><td>". $row['o_id']. "</td><td>" . $row ['t_category'] . "</td><td>" . $row ['t_status'] . "</td></tr>";
                }
            echo "</table>";
        }

        if(isset($_POST['search_ticket'])) {
            $ticket_id = $_POST['ticket_id'];
            $sql = "SELECT * FROM support_ticket where t_id = $ticket_id";
            $result = mysqli_query($connect,$sql);
            $row = mysqli_fetch_array($result);
            
            if($row) { #display support ticket details
                $customer_id = $row['customer_id'];
                $customer_query = "SELECT email FROM customer where customer_id = $customer_id";
                echo "<h1>Support Ticket: $ticket_id</h1>";
                echo "<font size='+1'>";
                echo "<p><strong> Order ID: </strong> $row[o_id]</p>";
                echo "</font>";
            }
            else {
                echo "Support Ticket: " . $ticket_id . " was not found";
            }

        }
        
    ?>

</body>
</html>