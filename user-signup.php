<?php

session_start();

$email = $_POST['email'];
$password = $_POST['password'];
$passwordConfirm = $_POST['password_confirm'];
$firstName = $_POST['firstname'];
$lastName = $_POST['lastname'];
$phone = $_POST['phone'];

$street = $_POST['street'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip = $_POST['zip'];

$billstreet = $_POST['billstreet'];
$billcity = $_POST['billcity'];
$billstate = $_POST['billstate'];
$billzip = $_POST['billzip'];

$ccNum = $_POST['cc_num'];
$cvv = $_POST['cvv'];
$expDate = $_POST['exp_date'];

if (empty($email) ||
    empty($password) ||
    empty($passwordConfirm) ||
    empty($firstName) ||
    empty($lastName) ||
    empty($phone) ||
    empty($street) ||
    empty($city) ||
    empty($state) ||
    empty($zip) ||
    empty($ccNum) ||
    empty($cvv) ||
    empty($expDate)) {
    $_SESSION['messages'][] = 'Please fill all required fields! (ERROR_ID:1)';
    header('Location: register.php');
    exit;
}

if (strlen($password) < 7) {
    $_SESSION['messages'][] = 'Password must be at least 7 characters long!';
    header('Location: register.php');
    exit;
}

if ($password !== $passwordConfirm) {
    $_SESSION['messages'][] = 'Password and confirm password should match!';
    header('Location: register.php');
    exit;
}

if (!isset($_POST['billing_same']) &&
    (empty($billstreet) ||
    empty($billcity) ||
    empty($billstate) ||
    empty($billzip))) {
    $_SESSION['messages'][] = 'Please fill all required fields! (ERROR_ID:2)';
    header('Location: register.php');
    exit;
} elseif (isset($_POST['billing_same'])) {
    $billstreet = $_POST['street'];
    $billcity = $_POST['city'];
    $billstate = $_POST['state'];
    $billzip = $_POST['zip'];
}



$dsn = 'mysql:host=database-1.cgnsxr0vmecq.us-east-2.rds.amazonaws.com';
$dbUser = 'admin';
$dbPassword = '12345678';

try {
    $connection = new PDO($dsn, $dbUser, $dbPassword);
} catch (PDOException $expection) {
    $_SESSION['messages'][] = 'Connection to database failed: ' . $expection->getMessage();
    header('Location: register.php');
    exit;
}

?>