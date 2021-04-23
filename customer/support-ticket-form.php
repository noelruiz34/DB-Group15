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
    if(isset($_POST['order_detail_id'])) {
        $order_id = $_POST['order_detail_id'];
        unset($_SESSION['ticket_submitted']);
    }
    
?>

<!DOCTYPE html>
<html>
<script> 
          function closeTab() {
            window.open('','_self').close()          }

</script>
<head>
<link href="/styles.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">
    
    <!-- ****** faviconit.com favicons ****** -->
	<link rel="shortcut icon" href="/images/favicon/favicon.ico">
	<link rel="icon" sizes="16x16 32x32 64x64" href="/images/favicon/favicon.ico">
	<link rel="icon" type="image/png" sizes="196x196" href="/images/favicon/favicon-192.png">
	<link rel="icon" type="image/png" sizes="160x160" href="/images/favicon/favicon-160.png">
	<link rel="icon" type="image/png" sizes="96x96" href="/images/favicon/favicon-96.png">
	<link rel="icon" type="image/png" sizes="64x64" href="/images/favicon/favicon-64.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/images/favicon/favicon-32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/images/favicon/favicon-16.png">
	<link rel="apple-touch-icon" href="/images/favicon/favicon-57.png">
	<link rel="apple-touch-icon" sizes="114x114" href="/images/favicon/favicon-114.png">
	<link rel="apple-touch-icon" sizes="72x72" href="/images/favicon/favicon-72.png">
	<link rel="apple-touch-icon" sizes="144x144" href="/images/favicon/favicon-144.png">
	<link rel="apple-touch-icon" sizes="60x60" href="/images/favicon/favicon-60.png">
	<link rel="apple-touch-icon" sizes="120x120" href="/images/favicon/favicon-120.png">
	<link rel="apple-touch-icon" sizes="76x76" href="/images/favicon/favicon-76.png">
	<link rel="apple-touch-icon" sizes="152x152" href="/images/favicon/favicon-152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="/images/favicon/favicon-180.png">
	<meta name="msapplication-TileColor" content="#FFFFFF">
	<meta name="msapplication-TileImage" content="/images/favicon/favicon-144.png">
	<meta name="msapplication-config" content="/images/favicon/browserconfig.xml">
	<!-- ****** faviconit.com favicons ****** -->

	<title>Request Support Ticket | Omazon.com</title>
</head>

<body>
    <h1 style='text-align:center; margin:2px; margin-top:8vh;'> Support Ticket Form </h1><br>
    <?php $path = $_SERVER['DOCUMENT_ROOT']; $path .= '/error-message.php'; require_once $path; ?>
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
                     /*echo "<div style='width:50%; margin:0 auto; text-align:center;'> 
                        <h3> Your support ticket for Order #: $order_id has been submitted! </h3>
                        <a href = '/customer/customer-orders.php'> Back to My Orders </a>
                        </div>"; */
                    $_SESSION['messages'][] = "Your support ticket for Order #:$order_id has been submitted!";
                    $_SESSION['ticket_submitted'] = true;
                    header("Location:/customer/support-ticket-form.php");
                    // echo "<script> closeTab() </script>";
                }
            }
       ?>
    <div style='width:50%; margin:0 auto; text-align:center;'>
        <?php if($_SESSION['ticket_submitted'] != true) { ?>
        <h3> This form is for Order #<?php echo $order_id ?> </h3>
        <form action='' method='post'>
        <label style='font-size:20px;' for='ticket_category'> Reason for Support Request: </label>
        <select style='font-size:16px;' id='category' name = 'ticket_category'>
            <option value='Return'> Return</option>
            <option value='Service'> Service</option>
            <option value='Exchange'> Exchange</option>
            <option value='Other'> Other</option>
        </select> <br> <br>
        <label style='font-size:20px;'  for="ticket_desc"> Please give us a short description of your issue (750 characters max): </label> <br>
        <textarea style='width:100%; resize: none;' id="ticket_desc" name ="ticket_desc" rows="4" cols="50" maxlength="750" required></textarea> <br><br>
        <input type="hidden" name = "order_id" value = <?php echo $order_id ?>>
        <input type='submit' name = 'submit_ticket' id = 'submit_ticket' value = 'Submit Ticket'>
        <?php } ?>
        </form>
    </div>
        
</body>

       
</html>


