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
    if(!isset($_SESSION['customer'])) // If session is not set then redirect to Login Page
       {
           header("Location:/customer/customer-login.php");  
       }
    
    $customer_id = $_SESSION['customer'];
    $order_id = $_POST['order_detail_id'];
?>

<!DOCTYPE html>
<html>
<head>
	<title>Support Ticket Form</title>
</head>
<a href="/customer/customer-orders.php">Back to My Orders</a>
<body>
    <h1> Support Ticket Form </h1><br>
    <p> This form is for Order #: <?php echo $order_id ?> </p>
        <form action='' method='post'>
        <label for='ticket_category'> Reason for Support Request: </label>
        <select id='category' name = 'ticket_category'>
            <option value='Return'> Return</option>
            <option value='Service'> Service</option>
            <option value='Exchange'> Exchange</option>
            <option value='Other'> Other</option>
        </select> <br> <br>
        <label for="ticket_desc"> Please give us a short description as to how we can help you: </label> <br>
        <textarea id="ticket_desc" name ="ticket_desc" rows="4" cols="50" maxlength="750">
        </textarea> <br><br>
        <input type="hidden" name = "order_id" value = <?php echo $order_id ?>>
        <input type="submit" name = "submit_ticket" value = "Submit Ticket">
        </form>

</body>

       <?php
            if(isset($_POST['submit_ticket'])){
                $order_id = $_POST['order_id'];
                $ticket_category = $_POST['ticket_category'];
                $ticket_desc = addslashes($_POST['ticket_desc']);

                $ticket_insert_sql = "INSERT INTO support_ticket (o_id, t_category, t_desc)
                VALUES ($order_id, '$ticket_category','$ticket_desc')";
                $ticket_insert_result = mysqli_query($connect, $ticket_insert_sql);

                if(!$ticket_insert_result) {
                    echo $ticket_insert_sql;
                    die("Support Ticket Insert failed!");
                }
                else {
                    echo "Your support ticket for order #: $order_id has been submitted!";
                }
            }
       ?>
</html>


