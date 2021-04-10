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
        <a href = 'employee_portal.php'> Back to Employee Portal </a>
    </p>
    
    <form action="" method="post">
        <input type = "submit" name = "view_all_tickets" value = "View All Tickets"/><br />
    </form>

    <form action="" method="post">
        <label> Search For Support Ticket (ID): </label><input type = "text" name = "ticket_id" class = "box" />
        <input type = "submit" name = "search_ticket" value = "Search"/> <br /> <br />
    </form>
   
    <?php
        if(isset($_POST['view_all_tickets'])) {
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
            $ticket_row = mysqli_fetch_array($result);
            
            
            if($ticket_row) { #display support ticket details
                $order_id = $ticket_row['o_id'];
                $order_sql = "SELECT Point_of_Sale.customer.email, Point_of_Sale.customer.phone_number
                FROM Point_of_Sale.customer INNER JOIN Point_of_Sale.order ON Point_of_Sale.order.customer_id = Point_of_Sale.customer.customer_id
                WHERE Point_of_Sale.order.o_id = $order_id";
                $result = mysqli_query($connect,$order_sql);
                $order_row = mysqli_fetch_array($result);

                echo "<h1>Support Ticket: $ticket_id</h1>";
                echo "<font size='+1'>";
                echo "<p><strong> Order ID: </strong> $order_id</p>";
                echo "<p><strong> Category: </strong> $ticket_row[t_category]</p>";
                echo "<p><strong> Status: </strong> $ticket_row[t_status]</p>";
                echo "<p><strong> Description: </strong> $ticket_row[t_desc]</p>";
                echo "<p><strong> Customer Email: </strong> $order_row[email]</p>";
                echo "<p><strong> Customer Phone Number: </strong> $order_row[phone_number]</p>";
                echo "</font>";
            }
            else {
                echo "Support Ticket: " . $ticket_id . " was not found";
            }

        }
    ?>

</body>
</html>