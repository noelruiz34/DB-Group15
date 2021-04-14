<!DOCTYPE html>

<html lang='en'>

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

  <title>Customer Registration</title>
</head>

<body>
  <div class='navbar'>
    <ul>
      <li style='float:left'><a href='index.php' style='font-weight:700;'>Omazon</a></li>
      <li style='float:left'><a href="product-catalog.php">Browse Products</a></li>
      <?php
          if(isset($_SESSION['customer'])) {
              echo "
              <li><a href = 'logout.php'  style='color:#ec0016;'> Log out </a></li>
              <li><a href='edit-customer-account-info.php'>My Account</a></li>
              <li><a href = 'shopping_cart.php'>My Cart</a></li>
              
              ";
          }
          else {
              echo "
              <li><a class='active' href='register.php'>Register</a></li>
              <li><a href='customer_login.php'>Log in</a></li>
              ";
          }
      ?>
      <li><a href='order_summary.php'>Order Lookup</a></li>
    </ul>
  </div>
  
  <div class='container-portal'>
    <div class='portal-content'>
      <h1 style='margin-bottom:1px;'>Customer Registration</h1>
      
      <p style='text-align: center;'>
        Already have an account? <a href="customer_login.php">Log in to existing account</a><br>
        <br>
        
      </p><br>
      <?php require_once 'register-error-handling.php'; ?><br>
      
      <i style='font-size:13px;'>(All fields are required for account creation)</i>
      
      
      <form action='user-signup.php' method='POST'>
        <!-- Personal Info -->
        <h3>Personal Info</h3>
        E-mail address: <br>
        <input type='email' id='email' name='email' maxlength='50' placeholder='Your email...' required/><br>
        Password: <br>
        <input type='password' id='password' name='password' minlength='7' maxlength='50' placeholder='At least 7 characters...' required/><br>
        Confirm password: <br>
        <input type='password' id='password_confirm' minlength='7' maxlength='50' name='password_confirm' placeholder='Re-enter password...' required/><br>
        First name: <br>
        <input type='text' id='firstname' name='firstname' maxlength='32' placeholder='Your first name...' required/><br>
        Last name: <br>
        <input type='text' id='lastname' name='lastname' maxlength='32' placeholder='Your last name...' required/><br>
        Phone number: <br>
        <input type='tel' id='phone' name='phone' placeholder='1234567890' pattern='[0-9]{10}' placeholder='Your phone number...' required/><br>


        <!-- Shipping Address -->
        <h3>Shipping Address</h3>
        Street address: <br>
        <input type='text' id='street' name='street' maxlength='25' placeholder='Enter street address...' required/><br>
        City: <br>
        <input type='text' id='city' name='city' maxlength='25' placeholder='Enter city...' required/><br>
        State: <br>
        <input type='text' id='state' name='state' maxlength="2" placeholder='Enter state (2 characters)...' required/><br>
        Zip code: <br>
        <input type='text' id='zip' name='zip' pattern='[0-9]{5}' placeholder='Enter zip code...' required/><br>
        <br>

        <!-- Billing Address -->
        <h3>Billing Address</h3>
        <i>(Billing address same as shipping):</i> <input style='padding:0px;margin:0px; width:1%' type='checkbox' id='billing_same' name='billing_same' onchange='toggleDisabled(this.checked)'/><br>
        <br>
        <div id='hideCheck'>
          Street address: <br>
          <input type='text' id='billstreet' name='billstreet' maxlength='25' placeholder='Enter street address...'/><br>
          City: <br>
          <input type='text' id='billcity' name='billcity' maxlength='25' placeholder='Enter city...'/><br>
          State: <br>
          <input type='text' id='billstate' name='billstate' maxlength="2" placeholder='Enter state (2 characters)...'/><br>
          Zip code: <br>
          <input type='text' id='billzip' name='billzip' pattern='[0-9]{5}' placeholder='Enter zip code...'/><br>
          <br>
        </div>

        <!-- Billing Info -->
        <h3>Billing Info</h3>
        Credit card number: <br>
        <input type='text' id='cc_num' name='cc_num' pattern='[0-9]{16}' placeholder='16 digits' placeholder='Your 16-digit credit card number...' required/><br>
        CVV: <br>
        <input type='text' id='cvv' name='cvv' pattern='[0-9]{3}' placeholder='3-digit security code...' required/><br>
        Expiration date: <br>
        <input type='month' id='exp_date' name='exp_date' min='<?php echo date("Y-m"); ?>' required/><br>
        <br>

        <input type='submit' id='register' value='Register'/>
      </form>
  
      <br>
    </div>

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

<script>
  function toggleDisabled(_checked) {
    if(_checked)
    {
      document.getElementById('billstreet').value = '';
      document.getElementById('billcity').value = '';
      document.getElementById('billstate').value = '';
      document.getElementById('billzip').value = '';
    }

    document.getElementById('billstreet').disabled = _checked ? true : false;
    document.getElementById('billcity').disabled = _checked ? true : false;
    document.getElementById('billstate').disabled = _checked ? true : false;
    document.getElementById('billzip').disabled = _checked ? true : false;
    document.getElementById('hideCheck').hidden = _checked ? true : false;
  }
</script>

</html>