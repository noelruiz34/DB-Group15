<?php

session_start();
if(!isset($_SESSION['customer'])) // If session is not set then redirect to Login Page
{
    header("Location:customer-login.php");  
}

$dsn = 'mysql:dbname=Point_of_Sale;host=database-1.cgnsxr0vmecq.us-east-2.rds.amazonaws.com';
$dbUser = 'admin';
$dbPassword = '12345678';

try {
    $connection = new PDO($dsn, $dbUser, $dbPassword);
} catch (PDOException $expection) {
    $_SESSION['messages'][] = 'Connection to database failed: ' . $expection->getMessage();
    header('Location: edit-customer-account-info.php');
    exit;
}

$cust_id = $_SESSION['customer'];

$email = strtolower($_POST['email']);
$firstName = ucwords(strtolower($_POST['firstname']));
$lastName = ucwords(strtolower($_POST['lastname']));
$phone = $_POST['phone'];

$street = ucwords(strtolower($_POST['street']));
$city = ucwords(strtolower($_POST['city']));
$state = strtoupper($_POST['state']);
$zip = $_POST['zip'];

$billstreet = ucwords(strtolower($_POST['billstreet']));
$billcity = ucwords(strtolower($_POST['billcity']));
$billstate = strtoupper($_POST['billstate']);
$billzip = $_POST['billzip'];

$ccNum = $_POST['cc_num'];
$cvv = $_POST['cvv'];
$expDate = $_POST['exp_date'];
$expDate = $expDate.'-30';

$password = $_POST['password'];




$statement = $connection->prepare('SELECT * FROM customer WHERE customer_id = :customer_id AND password = :password');
if ($statement) {
    $statement->execute([
        ':customer_id' => $cust_id,
        ':password' => $password
    ]);

    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    if (empty($result)) {
        $_SESSION['messages'][] = 'Incorrect current password!';
        header('Location: edit-customer-account-info.php');
        exit;
    }
}

$statement = $connection->prepare('SELECT * FROM customer WHERE email = :email AND customer_id != :customer_id');
if ($statement) {
    $statement->execute([
        ':customer_id' => $cust_id,
        ':email' => $email
    ]);

    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($result)) {
        $_SESSION['messages'][] = 'Email already exists in database!';
        header('Location: edit-customer-account-info.php');
        exit;
    }
}



$statement = $connection->prepare('UPDATE customer SET email = :email, f_name = :f_name, l_name = :l_name, phone_number = :phone_number WHERE customer_id = :customer_id');
if ($statement) {
    $result = $statement->execute ([
        ':customer_id' => $cust_id,
        ':email' => $email,
        ':f_name' => $firstName,
        ':l_name' => $lastName,
        ':phone_number' => $phone
    ]);
}

$statement = $connection->prepare('UPDATE shipping_address SET street = :street, city = :city, zip = :zip, state = :state WHERE customer_id = :customer_id');
if ($statement) {
    $result = $statement->execute ([
        ':customer_id' => $cust_id,
        ':street' => $street,
        ':city' => $city,
        ':zip' => $zip,
        ':state' => $state,
    ]);
}

$statement = $connection->prepare('UPDATE billing_address SET street = :street, city = :city, zip = :zip, state = :state WHERE customer_id = :customer_id');
if ($statement) {
    $result = $statement->execute ([
        ':customer_id' => $cust_id,
        ':street' => $billstreet,
        ':city' => $billcity,
        ':zip' => $billzip,
        ':state' => $billstate,
    ]);
}

$statement = $connection->prepare('UPDATE billing_info SET cc_num = :cc_num, cvv = :cvv, exp_date = :exp_date WHERE customer_id = :customer_id');
if ($statement) {
    $result = $statement->execute ([
        ':customer_id' => $cust_id,
        ':cc_num' => $ccNum,
        ':cvv' => $cvv,
        ':exp_date' => $expDate,
    ]);

    if ($result) {
        $_SESSION['messages'][] = 'Account info successfully updated!';
        header('Location: edit-customer-account-info.php');
        exit;
    }
}


$_SESSION['messages'][] = 'Error in updating info.';
header('Location: edit-customer-account-info.php');
exit;

?>