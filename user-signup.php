<?php

session_start();

// Variables from POST

$email = $_POST['email'];
$password = $_POST['password'];
$passwordConfirm = $_POST['password_confirm'];
$firstName = $_POST['firstname'];
$lastName = $_POST['lastname'];
$phone = $_POST['phone'];

$street = $_POST['street'];
$city = $_POST['city'];
$state = strtoupper($_POST['state']);
$zip = $_POST['zip'];

$billstreet = $_POST['billstreet'];
$billcity = $_POST['billcity'];
$billstate = $_POST['billstate'];
$billzip = $_POST['billzip'];

$ccNum = $_POST['cc_num'];
$cvv = $_POST['cvv'];
$expDate = $_POST['exp_date'];
$expDate = $expDate.'-30';




// Conditionals verifying correct input

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

<<<<<<< HEAD
$statement = $connection->prepare('SELECT * FROM customer WHERE email = :email');
if ($statement) {
    $statement->execute([
        ':email' => $email
    ]);

    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($result)) {
        $_SESSION['messages'][] = 'User with the email already exists!';
        header('Location: register.php');
        exit;
    }
}

$statement = $connection->prepare('INSERT INTO customer(email, password, f_name, l_name, phone_number) VALUES (:email, :password, :f_name, :l_name, :phone_number)');
if ($statement) {
    $result = $statement->execute ([
        ':email' => $email,
        ':password' => $password,
        ':f_name' => $firstName,
        ':l_name' => $lastName,
        ':phone_number' => $phone,
    ]);
}

$fetchedId;
$statement = $connection->prepare('SELECT customer_id FROM customer WHERE email = :email');
if ($statement) {
    $statement->execute([
        ':email' => $email
    ]);

    $result = $statement->fetch(PDO::FETCH_ASSOC);

    if (empty($result)) {
        $_SESSION['messages'][] = 'ERROR IN SIGNING UP USER';
        header('Location: register.php');
        exit;
    } else {
        $fetchedId = $result['customer_id'];
    }
}

$statement = $connection->prepare('INSERT INTO shipping_address(customer_id, street, city, zip, state) VALUES (:customer_id, :street, :city, :zip, :state)');
if ($statement) {
    $result = $statement->execute ([
        ':customer_id' => $fetchedId,
        ':street' => $street,
        ':city' => $city,
        ':zip' => $zip,
        ':state' => $state,
    ]);
}

$statement = $connection->prepare('INSERT INTO billing_address(customer_id, street, city, zip, state) VALUES (:customer_id, :street, :city, :zip, :state)');
if ($statement) {
    $result = $statement->execute ([
        ':customer_id' => $fetchedId,
        ':street' => $billstreet,
        ':city' => $billcity,
        ':zip' => $billzip,
        ':state' => $billstate,
    ]);
}

$statement = $connection->prepare('INSERT INTO billing_info(customer_id, cc_num, cvv, exp_date) VALUES (:customer_id, :cc_num, :cvv, :exp_date)');
if ($statement) {
    $result = $statement->execute ([
        ':customer_id' => $fetchedId,
        ':cc_num' => $ccNum,
        ':cvv' => $cvv,
        ':exp_date' => $expDate,
    ]);

    if ($result) {
        $_SESSION['messages'][] = 'Account successfully registered. Thank you registering an account!';
        header('Location: account-created.html');
        exit;
    }
}
=======
>>>>>>> 55fc4a705823f3a8d527ba0b5b0d303155129628

?>