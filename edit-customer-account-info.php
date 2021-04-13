<?php
    session_start();
    if(!isset($_SESSION['customer'])) // If session is not set then redirect to Login Page
    {
    header("Location:customer_login.php");  
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
    <title>My Account</title>
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
    <h1>My Account</h1>
    <a href="index.php">Return to homepage</a>
    <?php require_once 'register-error-handling.php'; ?>

    <h2>Change Password</h2>
    <form action='customer-change-password.php' method='POST'>
        Enter current password: <input type='password' id='curr_password' name='curr_password' minlength='7' maxlength='50' required/><br>
        Enter new password: <input type='password' id='new_password' name='new_password' minlength='7' maxlength='50' placeholder='At least 7 characters' required/><br>
        Confirm new password: <input type='password' id='new_password_confirm' name='new_password_confirm' minlength='7' maxlength='50' required/><br>
        <input type='submit' id='change_password' value='Submit'/>
    </form>

    <br>

    <h2>Edit Account Info</h2>
    <form action='customer-info-update.php' method='POST'>
    
        <?php
            $sql="SELECT * FROM customer WHERE customer_id = '".$cust_id."'";
            $result = mysqli_query($con,$sql);
            while($row = mysqli_fetch_array($result)) {
                echo "
                    <h3>Personal Info</h3>
                    E-mail address: <input type='email' id='email' name='email' maxlength='50' value='" . $row['email'] . "' required/><br>
                    First name: <input type='text' id='firstname' name='firstname' maxlength='32' value='" . $row['f_name'] . "' required/><br>
                    Last name: <input type='text' id='lastname' name='lastname' maxlength='32' value='" . $row['l_name'] . "' required/><br>
                    Phone number: <input type='tel' id='phone' name='phone' placeholder='1234567890' pattern='[0-9]{10}' value='" . $row['phone_number'] . "' required/><br>
                    <br>
                ";
            }
            
            $sql="SELECT * FROM shipping_address WHERE customer_id = '".$cust_id."'";
            $result = mysqli_query($con,$sql);
            while($row = mysqli_fetch_array($result)) {
                echo "
                    <h3>Shipping Address</h3>
                    Street address: <input type='text' id='street' name='street' maxlength='25' value='" . $row['street'] . "' required/><br>
                    City: <input type='text' id='city' name='city' maxlength='25' value='" . $row['city'] . "' required/><br>
                    State: <input type='text' id='state' name='state' maxlength='2' value='" . $row['state'] . "' required/><br>
                    Zip code: <input type='text' id='zip' name='zip' pattern='[0-9]{5}' value='" . $row['zip'] . "' required/><br>
                    <br>
                ";
            }

            $sql="SELECT * FROM billing_address WHERE customer_id = '".$cust_id."'";
            $result = mysqli_query($con,$sql);
            while($row = mysqli_fetch_array($result)) {
                echo "
                    <h3>Billing Address</h3>
                    Street address: <input type='text' id='billstreet' name='billstreet' maxlength='25' value='" . $row['street'] . "' required/><br>
                    City: <input type='text' id='billcity' name='billcity' maxlength='25' value='" . $row['city'] . "' required/><br>
                    State: <input type='text' id='billstate' name='billstate' maxlength='2'value='" . $row['state'] . "' required/><br>
                    Zip code: <input type='text' id='billzip' name='billzip' pattern='[0-9]{5}' value='" . $row['zip'] . "' required/><br>
                    <br>
                ";
            }

            $sql="SELECT * FROM billing_info WHERE customer_id = '".$cust_id."'";
            $result = mysqli_query($con,$sql);
            while($row = mysqli_fetch_array($result)) {
                $convertedDate = date('Y-m', strtotime($row['exp_date']));
                echo "
                    <h3>Billing Info</h3>
                    Credit card number: <input type='text' id='cc_num' name='cc_num' pattern='[0-9]{16}' placeholder='16 digits' value='" . $row['cc_num'] . "' required/><br>
                    CVV: <input type='text' id='cvv' name='cvv' pattern='[0-9]{3}' placeholder='3 digits' value='" . $row['cvv'] . "' required/><br>
                    Expiration date: <input type='month' id='exp_date' name='exp_date' min='" . date('Y-m'). "' value='" . $convertedDate . "' required/><br>
                    <br>
                ";
            }
            
        ?>

        <br>
        Enter password to update info: <input type='password' id='password' name='password' minlength='7' maxlength='50' required/><br>
        <input type='submit' id='update_customer_info' value='Update Info'/>
    </form>
</body>



</html>