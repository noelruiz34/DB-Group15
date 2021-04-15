<?php
    $dbServername = "database-1.cgnsxr0vmecq.us-east-2.rds.amazonaws.com";
    $dbUser = "admin";
    $dbPass = "12345678";
    $dbName = "Point_of_Sale";
    
    $connect = mysqli_connect($dbServername, $dbUser, $dbPass, $dbName);
    session_start();
    if(isset($_SESSION['use'])) {
        #header("Location:employee_login.php");
    }

?>

<!DOCTYPE html>
<html>

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
	<title>Customer Login | Omazon.com</title>
</head>

<body>
    <div class='navbar'>
        <ul>
            <li style='float:left'><a href='/index.php' style='font-weight:900;'>Omazon <img src='/images/favicon/favicon-192.png' width='16' height='16'></a></li>
            <li style='float:left'><a href="/product-catalog.php">Browse Products</a></li>
            <?php
                if(isset($_SESSION['customer'])) {
                    echo "
                    <li><a href = '/logout.php'  style='color:#ec0016;'> Log out </a></li>
                    <li><a href='/customer/account/edit-customer-account-info.php'>My Account</a></li>
                    <li><a href = '/customer/shopping-cart.php'>My Cart</a></li>
                    
                    ";
                }
                else {
                    echo "
                    <li><a href='/customer/register.php'>Register</a></li>
                    <li><a class='active' href='/customer/customer-login.php'>Log in</a></li>
                    ";
                }
            ?>
        </ul>
    </div>


    <div class='container-portal'>
        <div class='portal-content' style='padding-bottom: 48px'>
            <h1 style="text-align:center;">Log In</h1>
            <?php $path = $_SERVER['DOCUMENT_ROOT']; $path .= '/error-message.php'; require_once $path; ?>

            <form action = "" method = "post">
                <label>Email:</label>
                <input type = "text" name = "email" class = "box" placeholder='Enter email address...'/>

                <label>Password:</label>
                <input type = "password" name = "password" class = "box" placeholder='Enter password...'/>

                <input type = "submit" name = 'login' value = " Login "/><br />
            </form>

            <?php
                if(isset($_POST['login'])) {
                    $email = $_POST['email'];
                    $pass = $_POST['password'];
                    $sql = "SELECT * FROM customer WHERE email='$email' AND password='$pass'";
                    $result = mysqli_query($connect,$sql);
                    $row = mysqli_fetch_array($result);
                    if($row) {
                        $_SESSION['customer']= $row['customer_id'];
                        header("Location:/index.php");
                    }
                    else {
                        $_SESSION['messages'][] = 'Invalid username and/or password! Please try again.';
                        header("Location:/customer/customer-login.php");
                    }
                };
            ?>

        <br>
            <p style='text-align:center;'>Don't have an account yet? <a href="/customer/register.php">Create account</a></p>

        </div>
    </div>

    <div class='footer' style='bottom:0; position:absolute; width:100%;'>
            <ul>
                <li><a href="/index.php">Home</a></li>
                <li><a href="/employee/employee-login.php">Employee Portal</a></li>
                <li><a href="/about.html">About</a></li>
            </ul>
            <p>Omazon © 2021</p>
        </div>

</body>
</html>