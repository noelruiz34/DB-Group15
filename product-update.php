<?php

session_start();

// Variables from POST

$upc = $_POST['upc'];
$pname = $_POST['pname'];
$quantity = $_POST['quantity'];
$price = $_POST['price'];
$category = $_POST['categories'];
$discount = $_POST['discount'];
$listed = $_POST['listed'];
if ($listed == 'on') {
    $listed = 1;
}

// FIX EMPLOYEEID LATER
$employeeId = 1;

$currTime = date('Y-m-d H:i:s');
$updateDesc = $_POST['update_desc'];

// Conditionals verifying correct input

if (empty($upc) ||
    empty($pname) ||
    empty($quantity) ||
    empty($category) ||
    empty($discount) ||
    empty($listed)) {
    $_SESSION['messages'][] = 'Please fill all required fields! (ERROR_ID:1)';
    header('Location: add-update-product.php');
    exit;
}

//Connect to DB

$dsn = 'mysql:dbname=Point_of_Sale;host=database-1.cgnsxr0vmecq.us-east-2.rds.amazonaws.com';
$dbUser = 'admin';
$dbPassword = '12345678';

try {
    $connection = new PDO($dsn, $dbUser, $dbPassword);
} catch (PDOException $expection) {
    $_SESSION['messages'][] = 'Connection to database failed: ' . $expection->getMessage();
    header('Location: register.php');
    exit;
}

$statement = $connection->prepare('UPDATE product SET p_name = :p_name, p_quantity = :p_quantity, p_price = :p_price, p_category = :p_category, p_discount = :p_discount, p_listed = :p_listed WHERE upc = :upc');
if ($statement) {
    $result = $statement->execute ([
        ':upc' => $upc,
        ':p_name' => $pname,
        ':p_quantity' => $quantity,
        ':p_price' => $price,
        ':p_category' => $category,
        ':p_discount' => $discount,
        ':p_listed' => $listed
    ]);
}

$statement = $connection->prepare('INSERT INTO product_update(employee_id, upc, update_time, update_desc) VALUES (:employee_id, :upc, :update_time, :update_desc)');
if ($statement) {
    $result = $statement->execute ([
        ':employee_id' => $employeeId,
        ':upc' => $upc,
        ':update_time' => $currTime,
        ':update_desc' => $updateDesc
    ]);

    if ($result) {
        $_SESSION['messages'][] = 'Product UPC#' . $upc . ' successfully updated.';
        header('Location: add-update-product.php');
        exit;
    }
}

?>