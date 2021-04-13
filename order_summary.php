<!DOCTYPE html>
<?php 
    include 'db.php';
    session_start();
    if(!isset($_SESSION['employee'])) {
      header("Location:employee-login.php"); 
    }
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


<html>
<head>

<a href="employee-portal.php">Back to Employee Portal</a>


<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
body {
  font-family: Arial;
}

* {
  box-sizing: border-box;
}

form.example input[type=text] {
  padding: 10px;
  font-size: 17px;
  border: 1px solid grey;
  float: left;
  width: 55%;
  background: #f1f1f1;
  margin-left: 10%;
}

form.example button {
  float: left;
  width: 20%;
  padding: 10px;
  background: #2196F3;
  color: white;
  font-size: 17px;
  border: 1px solid grey;
  border-left: none;
  cursor: pointer;
}

form.example button:hover {
  background: #0b7dda;
}

form.example::after {
  content: "";
  clear: both;
  display: table;
}

table{
    border: 1px solid black;
    margin-top: 5%;
    margin-left: auto;
    margin-right: auto;
    width: 400px;
}
td {
    border: 1px solid black;
    border-spacing: 10px;

}
</style>
    <div>
        <center style="margin-top: 5%;font-size: 300%;">Order Summary</center>
        <hr style="width: 50%;">
    </div>
</head>
<body>

<form class="example" method="post">
  <input type="text" placeholder="Search.." name="search">
  <button type="submit" name="Search"><i class="fa fa-search"></i></button>
</form>

<div id="order_info">
    <?php 
    if(isset($_POST['search'])){

        $order = $_POST['search'];
        $result = $connect->query("select * from Point_of_Sale.order where o_id = $order");

        echo "<table>";
        while($order_info = mysqli_fetch_array($result))
        {
            echo "<tr><td> Order ID: ".$order_info['o_id']."</td></tr>";
            echo "<tr><td> Customer ID: ".$order_info['customer_id']."</td></tr>";
            echo "<tr><td> Date order Received: ".$order_info['o_time']."</td></tr>";
            echo "<tr><td> Status: ".$order_info['o_status']."</td></tr>";
        }

        echo "</table>";
        $result = $connect->query("select * from Point_of_Sale.product_purchase where o_id = $order");
        echo"<table>";
        echo "<div> <center style=\"margin-top: 5%;font-size: 75%;\">Order Contents</center><hr style=\"width: 30%;margin-bottom: -3%;\"></div>";
        echo "<tr><td>Item UPC</td> <td>Quantitiy Ordered</td> <td>Price</td></tr>";
        while($item = mysqli_fetch_array($result))
        {
            echo "<tr><td>".$item['upc']."</td><td>".$item['quantity_ordered']."</td><td>".$item['p_price']."</td></tr>";
        }
        echo "</table>";
    }
    ?>

</div>

</body>
</html> 