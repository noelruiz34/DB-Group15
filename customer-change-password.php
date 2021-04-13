<?php

session_start();
if(!isset($_SESSION['customer'])) // If session is not set then redirect to Login Page
{
    header("Location:customer_login.php");  
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
$currPw = $_POST['curr_password'];
$newPw = $_POST['new_password'];
$confirmPw = $_POST['new_password_confirm'];


$statement = $connection->prepare('SELECT * FROM customer WHERE customer_id = :customer_id AND password = :password');
if ($statement) {
    $statement->execute([
        ':customer_id' => $cust_id,
        ':password' => $currPw
    ]);

    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    if (empty($result)) {
        $_SESSION['messages'][] = 'Incorrect current password!';
        header('Location: edit-customer-account-info.php');
        exit;
    }
}

if ($newPw != $confirmPw) {
    $_SESSION['messages'][] = 'New passwords do not match!';
    header('Location: edit-customer-account-info.php');
    exit;
}



$statement = $connection->prepare('UPDATE customer SET password = :password WHERE customer_id = :customer_id');
if ($statement) {
    $result = $statement->execute ([
        ':customer_id' => $cust_id,
        ':password' => $newPw
    ]);

    $_SESSION['messages'][] = 'Password successfully updated';
    header('Location: edit-customer-account-info.php');
    exit;
}

$_SESSION['messages'][] = 'Error in updating password.';
header('Location: edit-customer-account-info.php');
exit;


?>