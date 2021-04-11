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
           header("Location:employee-login.php");  
       }
    
    $employee_id = $_SESSION['employee'];
    $ticket_id = $_POST['ticket_details'];

    function echoSupportTicketDetails($connect, $ticket_id) {
        $sql = "SELECT * FROM support_ticket where t_id = $ticket_id";
        $result = mysqli_query($connect,$sql);
        if(!$result) {
            echo "Support Ticket: " . $ticket_id . " was not found";
            echo "<p align='left'><a href = 'support-tickets.php'> Back to Support Tickets </a></p>";
        }
        $ticket_row = mysqli_fetch_array($result);
        if(!$ticket_row) {
            echo "Support Ticket: " . $ticket_id . " was not found";
            echo "<p align='left'><a href = 'support-tickets.php'> Back to Support Tickets </a></p>";
        }
        else{
            #display support ticket details
            $order_id = $ticket_row['o_id'];
            $order_sql = "SELECT Point_of_Sale.customer.email, Point_of_Sale.customer.phone_number
            FROM Point_of_Sale.customer INNER JOIN Point_of_Sale.order ON Point_of_Sale.order.customer_id = Point_of_Sale.customer.customer_id
            WHERE Point_of_Sale.order.o_id = $order_id";
            $result = mysqli_query($connect,$order_sql);
            $order_row = mysqli_fetch_array($result);

            echo "<h1>Support Ticket: $ticket_id</h1>";
            echo "<p align='left'><a href = 'support-tickets.php'> Back to Support Tickets </a></p>";
            echo "<font size='+1'>";
            echo "<p><strong> Order ID: </strong> $order_id</p>";
            echo "<p><strong> Employee ID: </strong> $ticket_row[e_id]</p>";
            echo "<p><strong> Date Requested: </strong> $ticket_row[t_time]</p>";
            echo "<p><strong> Category: </strong> $ticket_row[t_category]</p>";
            echo "<p><strong> Status: </strong> $ticket_row[t_status]</p>";
            echo "<p><strong> Description: </strong> $ticket_row[t_desc]</p>";
            echo "<p><strong> Customer Email: </strong> $order_row[email]</p>";
            echo "<p><strong> Customer Phone Number: </strong> $order_row[phone_number]</p>";
            echo "</font>";
        }
    }

    echoSupportTicketDetails($connect, $ticket_id);
    

?>

