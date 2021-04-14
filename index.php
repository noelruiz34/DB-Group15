<?php
$dbServername = "database-1.cgnsxr0vmecq.us-east-2.rds.amazonaws.com";
$dbUser = "admin";
$dbPass = "12345678";
$dbName = "Point_of_Sale";

$connect = mysqli_connect($dbServername, $dbUser, $dbPass, $dbName) or die("Unable to Connect to '$dbServername'");
// mysqli_select_db($connect, $dbName) or die("Could not open the db '$dbName'");
if($connect->connect_error) {
    die('Bad connection'. $connect->connect_error);
}

session_start();
$customer_id = $_SESSION['customer']
?>


<!DOCTYPE html>
<html>

<head>
    <link href="styles.css" rel="stylesheet">
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

	<title>Omazon.com: The Point-Of-Sale System For All Your Needs</title>
</head>

<body>
    <div class='navbar'>
        <ul>
            <li style='float:left'><a class='active' href='index.php' style='font-weight:900;'>Omazon <img src='/images/favicon/favicon-192.png' width='16' height='16'></a></li>
            <li style='float:left'><a href="product-catalog.php">Browse Products</a></li>
            <?php
                if(isset($_SESSION['customer'])) {
                    echo "
                    <li><a href = 'logout.php'  style='color:#ec0016;'> Log out </a></li>
                    <li><a href='edit-customer-account-info.php'>My Account</a></li>
                    <li><a href = 'shopping-cart.php'>My Cart</a></li>
                    
                    ";
                }
                else {
                    echo "
                    <li><a href='register.php'>Register</a></li>
                    <li><a href='customer-login.php'>Log in</a></li>
                    ";
                }
            ?>
        </ul>
    </div>

    <div class='main-container'>
    
        <!-- hero image begin -->
        <div class="hero-image">
            <div class="hero-text">
                <h1>High-quality goods for highly-awesome customers.</h1>
                <div class='hero-body'>
                    <p>Don't settle for cheap knockoffs. Come discover the point-of-sale system of all time.</p>
                    <br>
                    <?php
                        if(isset($_SESSION['customer'])) {
                            echo "<a class='link-button' href='product-catalog.php'>Browse our products</a>";
                        } else {
                            echo "<a class='link-button' href='register.php'>Register an account</a>";
                        }
                    ?>
                    
                </div>
            </div>
        </div>
        <!-- hero image end -->
        
        <img class='center-image' style='width:40px;margin-top:50px;margin-bottom:50px;' src='/images/down-arrow.png'>

        <h1 style='padding-top:7vh;'>Welcome to Omazon.</h1>

        

        <div class='homepage-info'>
            <p>
                <img class='homepage-info-image' src='/images/homepage-ecommerce.png'>
                <p class='homepage-info-text'>
                    <?php
                        if(isset($_SESSION['customer'])) {
                            $sql = "SELECT f_name, l_name FROM customer WHERE customer_id=$customer_id";
                            $result = mysqli_query($connect, $sql);
                            $row = mysqli_fetch_array($result);
                            
                            echo "Hello, " . $row['f_name'] . " " . $row['l_name'] . "! ";
                        }
                    ?>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus imperdiet, nulla et dictum interdum, nisi lorem egestas odio, 
                    vitae scelerisque enim ligula venenatis dolor. Maecenas nisl est, ultrices nec congue eget, auctor vitae massa. Fusce luctus 
                    vestibulum augue ut aliquet. Mauris ante ligula, facilisis sed ornare eu, lobortis in odio. Praesent convallis urna a lacus interdum 
                    ut hendrerit risus congue. Nunc sagittis dictum nisi, sed ullamcorper ipsum dignissim ac. In at libero sed nunc venenatis imperdiet 
                    sed ornare turpis. Donec vitae dui eget tellus gravida venenatis. Integer fringilla congue eros non fermentum. Sed dapibus pulvinar 
                    nibh tempor porta. Cras ac leo purus. Mauris quis diam velit.
                    <br><br>
                    Ut id nunc erat. Quisque sodales est neque, vel lacinia turpis bibendum eu. Sed condimentum tempus risus, eu fringilla tellus 
                    aliquam quis. Praesent a tortor vulputate, ultrices orci ut, dapibus tellus. Aenean at suscipit libero, et porta lorem. Vivamus 
                    tincidunt tellus sed lacus tempor, eget lobortis arcu vulputate. Aliquam venenatis orci vitae libero interdum sagittis. Nam tempus 
                    rhoncus feugiat. Aliquam quis cursus eros, pharetra molestie est. Nunc orci lorem, semper vitae mauris sit amet, egestas semper 
                    augue. Donec et placerat ante. Vivamus ullamcorper leo dictum dui lobortis ullamcorper.    
                </p>
            </p>
        </div>
        
        
        <?php
            if(isset($_SESSION['customer'])) {
                echo "<div style='text-align:center;'><a class='link-button' href='edit-customer-account-info.php'>View my account</a></div>";
            } else {
                echo "<div style='text-align:center;'><a class='link-button' href='product-catalog.php'>Browse our products</a></div>";
            }
        ?>
        
        <div class='footer'>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="employee-login.php">Employee Portal</a></li>
                <li><a href="about.html">About</a></li>
            </ul>
            <p>Omazon © 2021</p>
        </div>

    </div>
</body>


</html>
