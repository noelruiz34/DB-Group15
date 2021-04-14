<?php
    session_start();
    if(!isset($_SESSION['customer'])) // If session is not set then redirect to Login Page
    {
    header("Location:customer-login.php");  
    }

    $cust_id = $_SESSION['customer'];

    $con = mysqli_connect('database-1.cgnsxr0vmecq.us-east-2.rds.amazonaws.com','admin','12345678','Point_of_Sale');
    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }

    mysqli_select_db($con,"ajax_demo");
?>


<!DOCTYPE html>

<html lang='en'>

<head>
    <link href="styles.css" rel="stylesheet">
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

    <title>My Account | Omazon.com</title>
    <style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type="number"] {
        -moz-appearance: textfield;
    }
    </style>
</head>



<body>
    <div class='navbar'>
        <ul>
        <li style='float:left'><a href='index.php' style='font-weight:900;'>Omazon <img src='/images/favicon/favicon-192.png' width='16' height='16'></a></li>
        <li style='float:left'><a href="product-catalog.php">Browse Products</a></li>
        <?php
            if(isset($_SESSION['customer'])) {
                echo "
                <li><a href = 'logout.php'  style='color:#ec0016;'> Log out </a></li>
                <li><a class='active' href='edit-customer-account-info.php'>My Account</a></li>
                <li><a href = 'shopping-cart.php'>My Cart</a></li>
                
                ";
            }
            else {
                echo "
                <li><a href='register.php'>Register</a></li>
                <li><a href='customer-login.php'>Log in</a></li>
                ";
            }
        ?>
        </ul>
    </div>

    <h1 style='margin-top: 100px;margin-bottom:15px;'>My Account</h1>
    <?php require_once 'register-error-handling.php'; ?>
    
    <div class='row'>
        <div class='column'>
            <div class='shade-content'>
            <h2>Edit Account Info</h2>
            <form action='customer-info-update.php' method='POST'>
            
                <?php
                    $sql="SELECT * FROM customer WHERE customer_id = '".$cust_id."'";
                    $result = mysqli_query($con,$sql);
                    while($row = mysqli_fetch_array($result)) {
                        echo "
                            <h3>Personal Info</h3>
                            E-mail address: <input type='email' id='email' name='email' maxlength='50' placeholder='Your email...' value='" . $row['email'] . "' required/><br>
                            First name: <input type='text' id='firstname' name='firstname' maxlength='32' placeholder='Your first name...' value='" . $row['f_name'] . "' required/><br>
                            Last name: <input type='text' id='lastname' name='lastname' maxlength='32' placeholder='Your last name...' value='" . $row['l_name'] . "' required/><br>
                            Phone number: <input type='tel' id='phone' name='phone' placeholder='1234567890' pattern='[0-9]{10}' value='" . $row['phone_number'] . "' required/><br>
                            <br>
                        ";
                    }
                    
                    $sql="SELECT * FROM shipping_address WHERE customer_id = '".$cust_id."'";
                    $result = mysqli_query($con,$sql);
                    while($row = mysqli_fetch_array($result)) {
                        echo "
                            <h3>Shipping Address</h3>
                            Street address: <input type='text' id='street' name='street' maxlength='25' placeholder='Enter street address...' value='" . $row['street'] . "' required/><br>
                            City: <input type='text' id='city' name='city' maxlength='25' placeholder='Enter city...' value='" . $row['city'] . "' required/><br>
                            State: <input type='text' id='state' name='state' maxlength='2' placeholder='Enter state (2 characters)...' value='" . $row['state'] . "' required/><br>
                            Zip code: <input type='text' id='zip' name='zip' pattern='[0-9]{5}' placeholder='Enter zip code...' value='" . $row['zip'] . "' required/><br>
                            <br>
                        ";
                    }

                    $sql="SELECT * FROM billing_address WHERE customer_id = '".$cust_id."'";
                    $result = mysqli_query($con,$sql);
                    while($row = mysqli_fetch_array($result)) {
                        echo "
                            <h3>Billing Address</h3>
                            Street address: <input type='text' id='billstreet' name='billstreet' maxlength='25' placeholder='Enter street address...' value='" . $row['street'] . "' required/><br>
                            City: <input type='text' id='billcity' name='billcity' maxlength='25' placeholder='Enter city...' value='" . $row['city'] . "' required/><br>
                            State: <input type='text' id='billstate' name='billstate' maxlength='2' placeholder='Enter state (2 characters)...' value='" . $row['state'] . "' required/><br>
                            Zip code: <input type='text' id='billzip' name='billzip' pattern='[0-9]{5}' placeholder='Enter zip code...' value='" . $row['zip'] . "' required/><br>
                            <br>
                        ";
                    }

                    $sql="SELECT * FROM billing_info WHERE customer_id = '".$cust_id."'";
                    $result = mysqli_query($con,$sql);
                    while($row = mysqli_fetch_array($result)) {
                        $convertedDate = date('Y-m', strtotime($row['exp_date']));
                        echo "
                            <h3>Billing Info</h3>
                            Credit card number: <input type='text' id='cc_num' name='cc_num' pattern='[0-9]{16}' placeholder='Your 16-digit credit card number...' value='" . $row['cc_num'] . "' required/><br>
                            CVV: <input type='text' id='cvv' name='cvv' pattern='[0-9]{3}' placeholder='3-digit security code...' value='" . $row['cvv'] . "' required/><br>
                            Expiration date: <input type='month' id='exp_date' name='exp_date' min='" . date('Y-m'). "' value='" . $convertedDate . "' required/><br>
                            <br>
                        ";
                    }
                    
                ?>

                <br>
                Enter password to update info: <input type='password' id='password' name='password' minlength='7' maxlength='50' placeholder='Enter password...' required/><br>
                <input type='submit' id='update_customer_info' value='Update Info'/>
            </form>
            </div>
        </div>

        <div class='column'>
            <div class='shade-content'>
            <h2>Change Password</h2>
            <form action='customer-change-password.php' method='POST'>
                Enter current password: <input type='password' id='curr_password' name='curr_password' minlength='7' maxlength='50' placeholder='Enter current password...' required/><br>
                Enter new password: <input type='password' id='new_password' name='new_password' minlength='7' maxlength='50' placeholder='At least 7 characters...' required/><br>
                Confirm new password: <input type='password' id='new_password_confirm' name='new_password_confirm' minlength='7' maxlength='50' placeholder='Re-enter new password...' required/><br>
                <input type='submit' id='change_password' value='Submit'/>
            </form>

            </div>
        </div>

    </div>

    <div class='footer'>
      <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="employee-login.php">Employee Portal</a></li>
          <li><a href="about.html">About</a></li>
      </ul>
      <p>Omazon © 2021</p>
    </div>
</body>



</html>