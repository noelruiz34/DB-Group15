<!DOCTYPE html>

<html lang='en'>

<head>
  <title>Customer Registration</title>
</head>

<body>
  <h1>Register</h1>
  <i>All fields required for account creation</i><br/>
  <br/>

  <form action='user-signup.php' method='POST'>
    <!-- Personal Info -->
    <h3>Personal Info</h3>
    E-mail address: <input type='email' id='email' name='email'/><br/>
    Password: <input type='password' id='password' name='password' placeholder='At least 7 characters'/><br/>
    Re-enter password: <input type='password' id='password_confirm' name='repassword_confirm'/><br/>
    First name: <input type='text' id='firstname' name='firstname'/><br/>
    Last name: <input type='text' id='lastname' name='lastname'/><br/>
    Phone number: <input type='tel' id='phone' name='phone' placeholder='1234567890' pattern='[0-9]{10}' required/><br/>
    <br/>


    <!-- Shipping Address -->
    <h3>Shipping Address</h3>
    Street address: <input type='text' id='street' name='street'/><br/>
    City: <input type='text' id='city' name='city'/><br/>
    State: <input type='text' id='state' name='state'/><br/>
    Zip code: <input type='text' id='zip' name='zip'/><br/>
    <br/>

    <!-- Billing Address -->
    <h3>Billing Address</h3>
    Billing address same as shipping: <input type='checkbox' id='billing_same' name='billing_same' onchange='toggleDisabled(this.checked)'/><br/>
    <br/>
    Street address: <input type='text' id='billstreet' name='billstreet'/><br/>
    City: <input type='text' id='billcity' name='billcity'/><br/>
    State: <input type='text' id='billstate' name='billstate'/><br/>
    Zip code: <input type='text' id='billzip' name='billzip'/><br/>
    <br/>

    <!-- Billing Info -->
    <h3>Billing Info</h3>
    Credit card number: <input type='text' id='cc_num' name='cc_num'/><br/>
    CVV: <input type='text' id='cvv' name='cvv'/><br/>
    Expiration date: <input type='month' id='exp_date' name='exp_date'/><br/>
    <br/>

    <input type='submit' id='register' value='Register'/>
  </form>
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