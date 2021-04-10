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
    
    $employee_id = $_SESSION['employee'];

    function echoNeedReviewTickets($connect) {
        $sql = "SELECT * FROM support_ticket WHERE e_id IS NULL";
        $result = mysqli_query($connect,$sql);
        if(!$result) {
            die("Query Failed!");
        }

        echo "<table>";
            echo "<tr><td> Order ID </td><td> Category </td><td> Status </td></tr>";
            while($row=mysqli_fetch_array($result)){
                echo "<tr>
                <td>". $row['o_id']. "</td>
                <td>" . $row ['t_category'] . "</td>
                <td>" . $row ['t_status'] . "</td>
                <td><form action='' method=post>
                <input type = hidden name = address_ticket_value value=$row[t_id]>
                <input type = submit name = address_button value = 'Address Ticket' asdfdsf/><br />
                </form></td>
                </tr>";
            }
        echo "</table>";
    }

    function echoSupportTicketDetails($connect, $ticket_id, $ticket_row) {
        $sql = "SELECT * FROM support_ticket where t_id = $ticket_id";
        $result = mysqli_query($connect,$sql);
        $ticket_row = mysqli_fetch_array($result);

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
        <input type = "submit" name = "view_need_review_tickets" value = "View Need Review"/>
        <input type = "submit" name = "view_my_tickets" value = "View My Tickets"/>
    </form>

    <form action="" method="post">
        <label> Search For Support Ticket (ID): </label><input type = "text" name = "ticket_id" class = "box" />
        <input type = "submit" name = "search_ticket" value = "Search"/> <br /> <br />
    </form>
   
    <?php
        if(isset($_POST['view_need_review_tickets'])) {
            echoNeedReviewTickets($connect);
        }

        if(isset($_POST['view_my_tickets'])) {
            
        }

        if(isset($_POST['search_ticket'])) {
            $ticket_id = $_POST['ticket_id'];
            $sql = "SELECT * FROM support_ticket where t_id = $ticket_id";
            $result = mysqli_query($connect,$sql);
            $ticket_row = mysqli_fetch_array($result);
            
            if($ticket_row) { #display support ticket details
                echoSupportTicketDetails($connect, $ticket_id, $employee_id);
            }
            else {
                echo "Support Ticket: " . $ticket_id . " was not found";
            }

        }

        if(isset($_POST['address_button'])) {
            $ticket_id = $_POST['address_ticket_value'];
            $sql = "UPDATE support_ticket SET e_id=$employee_id WHERE t_id=$ticket_id";
            $result = mysqli_query($connect, $sql);

            if($result){
                echoNeedReviewTickets($connect);
            }
            else {
                die("Query Failed!");
            }
        }
    ?>

</body>
</html>