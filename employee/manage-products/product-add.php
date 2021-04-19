<?php

session_start();
if(!isset($_SESSION['employee'])) // If session is not set then redirect to Login Page
{
    header("Location:/employee/employee-login.php");  
}

// Variables from POST

$upc = $_POST['add_upc'];
$pname = addSlashes($_POST['add_pname']);
$quantity = $_POST['add_quantity'];
$price = $_POST['add_price'];
$category = $_POST['add_category'];
$discount = $_POST['add_discount'];
$listed = $_POST['add_listed'];
if ($listed == 'on') {
    $listed = 1;
} else {
    $listed = 0;
}

$employeeId = $_SESSION['employee'];

$currTime = date('Y-m-d H:i:s');
$updateDesc = 'Added product to database';


// Conditionals verifying correct input

if (empty($upc) ||
    empty($pname) ||
    empty($quantity) ||
    empty($price) ||
    empty($category)) {
    $_SESSION['messages'][] = 'Please fill all required fields! (ERROR_ID:1)';
    header('Location: /employee/manage-products/add-update-product.php');
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
    header('Location: /employee/manage-products/add-update-product.php');
    exit;
}

$statement = $connection->prepare('SELECT * FROM product WHERE upc = :upc');
if ($statement) {
    $statement->execute([
        ':upc' => $upc
    ]);

    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($result)) {
        $_SESSION['messages'][] = 'Error: Product with the UPC# ' . $upc . ' already exists in the database!';
        header('Location: /employee/manage-products/add-update-product.php');
        exit;
    }
}

$statement = $connection->prepare('INSERT INTO product VALUES (:upc, :p_name, :p_quantity, :p_price, :p_category, :p_discount, :p_listed)');
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

    if ($result) {
        $_SESSION['messages'][] = 'Product UPC#' . $upc . ' successfully added to database.';
    }
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
        $_SESSION['messages'][] = 'Addition of product UPC#' . $upc . ' successfully logged.';
        header('Location: /employee/manage-products/add-update-product.php');
        exit;
    }
}

?>