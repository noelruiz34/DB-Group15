<!DOCTYPE html>

<html lang='en'>

<head>
  <title>Customer Registration</title>
</head>

<body>
  <h1>Customer Registration</h1>
  <i>All fields required for account creation</i><br>
  <br>

  <?php require_once 'register-error-handling.php'; ?>
  
  <form action='user-signup.php' method='POST'>
    <!-- Personal Info -->
    <h3>Personal Info</h3>
    E-mail address: <input type='email' id='email' name='email' maxlength='50' required/><br>
    Password: <input type='password' id='password' name='password' minlength='7' maxlength='50' placeholder='At least 7 characters' required/><br>
    Confirm password: <input type='password' id='password_confirm' minlength='7' maxlength='50' name='password_confirm' required/><br>
    First name: <input type='text' id='firstname' name='firstname' maxlength='32' required/><br>
    Last name: <input type='text' id='lastname' name='lastname' maxlength='32' required/><br>
    Phone number: <input type='tel' id='phone' name='phone' placeholder='1234567890' pattern='[0-9]{10}' required/><br>
    <br>


    <!-- Shipping Address -->
    <h3>Shipping Address</h3>
    Street address: <input type='text' id='street' name='street' maxlength='25' required/><br>
    City: <input type='text' id='city' name='city' maxlength='25' required/><br>
    State: <input type='text' id='state' name='state' maxlength="2" required/><br>
    Zip code: <input type='text' id='zip' name='zip' pattern='[0-9]{5}' required/><br>
    <br>

    <!-- Billing Address -->
    <h3>Billing Address</h3>
    Billing address same as shipping: <input type='checkbox' id='billing_same' name='billing_same' onchange='toggleDisabled(this.checked)'/><br>
    <br>
    Street address: <input type='text' id='billstreet' name='billstreet' maxlength='25'/><br>
    City: <input type='text' id='billcity' name='billcity' maxlength='25'/><br>
    State: <input type='text' id='billstate' name='billstate' maxlength="2"/><br>
    Zip code: <input type='text' id='billzip' name='billzip' pattern='[0-9]{5}'/><br>
    <br>

    <!-- Billing Info -->
    <h3>Billing Info</h3>
    Credit card number: <input type='text' id='cc_num' name='cc_num' pattern='[0-9]{16}' placeholder='16 digits' required/><br>
    CVV: <input type='text' id='cvv' name='cvv' pattern='[0-9]{3}' placeholder='3 digits' required/><br>
    Expiration date: <input type='month' id='exp_date' name='exp_date' min='<?php echo date("Y-m"); ?>' required/><br>
    <br>

    <input type='submit' id='register' value='Register'/>
  </form>

  <br>
  <br>
  Already have an account?
  <a href="customer_login.php">Log in to existing account</a>
  <br>
  <br>
  <a href="index.php">Return to homepage</a>
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
  }
</script>

</html>