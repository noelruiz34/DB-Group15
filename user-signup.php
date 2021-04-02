<?php

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
    die('Please fill all required fields!1' . $passwordConfirm);
}

if ($data['password'] !== $data['password_confirm']) {
    die('Password and Confirm password should match!');
}

if (!isset($_POST['billing_same']) &&
    (empty($data['billstreet']) ||
    empty($data['billcity']) ||
    empty($data['billstate']) ||
    empty($data['billzip']))) {
    die('Please fill all required fields!2');
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
    die('Connection failed: ' . $expection->getMessage());
}

?>