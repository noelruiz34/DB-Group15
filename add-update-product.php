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
    <h3>Product Information</h3>
    UPC: <input type='number' id='add_upc' name='add_upc' min='0' max='2147483647' required/>
    Product name: <input type='text' id='add_pname' name='add_pname' maxlength='64' required/><br>
    Quantity: <input type='number' id='add_quantity' name='add_quantity' min='0' max='2147483647' required/><br>
    Price: <input type='number' id='add_price' name='add_price' min='0' max='2147483647' step='.01' required/><br>
    Category:
    <select id='add_category' name='add_category' required>
      <?php 
        $con = mysqli_connect('database-1.cgnsxr0vmecq.us-east-2.rds.amazonaws.com','admin','12345678','Point_of_Sale');
        $sql = mysqli_query($con, "SELECT category_name FROM product_category");
        while ($row = $sql->fetch_assoc()){
          echo "<option value='" . $row['category_name'] . "'>" . $row['category_name'] . "</option>";
        }
      ?>
    </select>
    <br>
    Discount: <input type='number' id='add_discount' name='add_discount' min='0' max='100' value='0' required/>%<br>
    List product on catalog: <input type='checkbox' id='add_listed' name='add_listed'/><br>
    <br>

    <input type='submit' id='add_product' value='Add New Product'/>
  </form>



  <form id='update' name='update' action='product-update.php' method='POST' style="display:none" >
    <br>
    Enter the product UPC: <input type='number' id='upc' name='upc' min='0' max='2147483647' onkeyup='findProduct(this.value)' required/><br>

    <div id="update_prefill">
      <br>
      Info will be listed here if a product is found...
    </div>
  </form>

  <br>
  <br>
  <br>
  <br>
  <a href="employee-portal.php">Return to Employee Portal</a>

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
</script>

</html>