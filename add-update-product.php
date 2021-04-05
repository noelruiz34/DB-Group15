<!DOCTYPE html>

<html lang='en'>

<head>
  <title>Add/Update Product</title>
  <style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }
    input[type="number"] {
      -moz-appearance: textfield;
    }
  </style>
</head>

<body>
  <h1>Add/Update Product</h1>
  <?php require_once 'register-error-handling.php'; ?>
  <br>

  
  Please select an action to perform first:
  <select id='formPicker' name='formPicker' onchange='formSelect(this.value)'>
    <option disabled selected value> -- Choose an option -- </option>
    <option value='add_new'>Add a new product</option>
    <option value='update'>Update an existing product</option>
  </select>
  

  <form id='add_new' name='add_new' action='product-add.php' method='POST' style="display:none">
    <h3>TEST ADD</h3>
    E-mail address: <input type='email' id='email' name='email' maxlength='50' required/><br>
  </form>

  <form id='update' name='update' action='product-update.php' method='POST' style="display:none" >
    <br>
    Enter the product UPC: <input type='number' id='upc' name='upc' min='0' max='2147483647' onkeyup='findProduct(this.value)' required/><br>

    <!--
    <h3>Product Information</h3>
    Product name: <input type='text' id='pname' name='pname' maxlength='64' required/><br>
    Quantity: <input type='number' id='quantity' name='quantity' min='0' max='2147483647' required/><br>
    Price: <input type='number' id='quantity' name='quantity' min='0' max='2147483647' required/><br>
    Category:
    <select id='categories' name='categories' required>
      fill with categories
    </select>
    Current discount: <input type='number' id='discount' name='discount' min='0' max='100' required/>%<br>
    List product on catalog: <input type='checkbox' id='listed' name='listed'/>
    -->

    <div id="update_prefill">
      <br>
      Info will be listed here if a product is found...
    </div>
  </form>

  <form action='user-signup.php' method='POST' style="display:none">
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
  <a href="index.php">Return to homepage</a>

</body>

<script>
  function findProduct (upcToFind) {
    document.getElementById('update_prefill').innerHTML = "";
    if (upcToFind == "") {
      document.getElementById('update_prefill').innerHTML = "<br> Info will be listed here if a product is found...";
      return;
    } else {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById('update_prefill').innerHTML = this.responseText;
        }
      };

      xmlhttp.open('GET', 'get-product.php?q='+upcToFind, true);
      xmlhttp.send();
    }
  }

  function formSelect(_option) {
    if (_option == 'add_new') {
      document.getElementById('add_new').style.display = "block";
      document.getElementById('update').style.display = "none";
    } else if (_option == 'update') {
      document.getElementById('add_new').style.display = "none";
      document.getElementById('update').style.display = "block";
    }
  }

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