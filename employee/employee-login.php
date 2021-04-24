<?php
    $dbServername = "database-1.cgnsxr0vmecq.us-east-2.rds.amazonaws.com";
    $dbUser = "admin";
    $dbPass = "12345678";
    $dbName = "Point_of_Sale";
    
    $connect = mysqli_connect($dbServername, $dbUser, $dbPass, $dbName);
    session_start();
    if(isset($_SESSION['employee'])) {
        header("Location:/employee/employee-portal.php");
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
	<title>Employee Portal | Omazon.com</title>
</head>
<body>
    <div style='background: rgb(34,193,195); background: linear-gradient(0deg, rgba(34,193,195,1) 0%, rgba(246,201,14,1) 100%); min-height: 100vh; min-width: 100%;background-position: center; background-repeat: no-repeat;'>
        <div class='portal-content' style='padding-bottom: 48px; position:absolute; top: 50%; left: 50%; transform: translate(-50%,-70%);'>
            <h1 style="text-align:center;">Employee Login</h1>
            <?php $path = $_SERVER['DOCUMENT_ROOT']; $path .= '/error-message.php'; require_once $path; ?>
            <br>
            <form action = "" method = "post">
                <label>Employee ID:</label>
                <input type = "text" name = "employee_id" class = "box" placeholder='Enter employee ID...'/>

                <label>Password:</label>
                <input type = "password" name = "password" class = "box" placeholder='Enter password...'/>

                <input type = "submit" name = login value = " Login "/><br />
            </form>

            <br>
            <p style='text-align:center;'><a href="/index.php">Back to Home</a></p>
        </div>
    </div>

    <?php
        if(isset($_POST['login'])) {
            $id = $_POST['employee_id'];
            $pass = $_POST['password'];
            $sql = "SELECT * FROM employee WHERE employee_id=$id AND password=$pass";
            $result = mysqli_query($connect,$sql);
            if(mysqli_num_rows($result) >= 1) {
                $_SESSION['employee']=$id;
                header("Location:/employee/employee-portal.php");
            }
            else {
                $_SESSION['messages'][] = 'Invalid username and/or password! Please try again.';
                header("Location:/employee/employee-login.php");
            }
        };
    ?>

</body>
</html>