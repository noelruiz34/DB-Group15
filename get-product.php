<!DOCTYPE html>
<html>
<body>

<?php
$q = intval($_GET['q']);

$con = mysqli_connect('database-1.cgnsxr0vmecq.us-east-2.rds.amazonaws.com','admin','12345678','Point_of_Sale');
if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,"ajax_demo");
$sql="SELECT * FROM product WHERE upc = '".$q."'";
$result = mysqli_query($con,$sql);
$catSql="SELECT * FROM product_category";
$catResult = mysqli_query($con,$catSql);


$checker = 0;
while($row = mysqli_fetch_array($result)) {
    $checker = 1;
    echo "<h3>Product Information</h3>";

    echo "Product name: <input type='text' id='pname' name='pname' maxlength='64' value='" . $row['p_name'] . "' required/><br>";
    echo "Quantity: <input type='number' id='quantity' name='quantity' min='0' max='2147483647' value='" . $row['p_quantity'] . "' required/><br>";
    echo "Price: <input type='number' id='price' name='price' min='0' max='2147483647' value='" . $row['p_price'] . "' required/><br>";
    echo "Category:
    <select id='categories' name='categories' required>";
    while ($catRow = mysqli_fetch_array($catResult)) {
        echo "<option value='" . $catRow['category_name'] . "' ";
        if ($catRow['category_name'] == $row['p_category']) {
            echo "selected";
        }
        echo ">" . $catRow['category_name'] . "</option>";
    }
    echo "</select> <br>";
    echo "Current discount: <input type='number' id='discount' name='discount' min='0' max='100' value='" . $row['p_discount'] . "' required/>%<br>";
    echo "List product on catalog: <input type='checkbox' id='listed' name='listed' ";
    if ($row['p_listed'] == 1)
    {
        echo "checked";
    }
    echo "/>";
    echo "<br><br>";
    echo "Describe the changes made: <input type='text' id='update_desc' name='update_desc' minlength='4' maxlength='200' placeholder='200 characters max' required/> <br><br>";
    echo "<input type='submit' id='update_product' value='Update Product'/><br>";



}

if ($checker == 0)
{
    echo "<br>";
    echo "No product found (UPC does not exist)";
}

mysqli_close($con);
?>

</body>
</html>