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
        <title>Account Created | Omazon.com</title>
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
                        <li><a href='/customer/customer-login.php'>Log in</a></li>
                        ";
                    }
                ?>
            </ul>
        </div>
        
        <h2 style='text-align:center;margin-top:100px;'>Account Created</h2>
        <p style='text-align:center;'>Your Omazon account has successfully been registered! You can now <a href='/customer/customer-login.php'>login</a>.</p>

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