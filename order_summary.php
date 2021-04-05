<!DOCTYPE html>
<?php 
    include 'db.php';
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


<html>
<head>

<a href="index.php">Back to Home</a>


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
  width: 60%;
  background: #f1f1f1;
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

        include "db.php";
        $order = $_POST['search'];
        $result = $connect->query("select * from Point_Sale.order where o_id = $order");

        echo "<table>";
        while($order = mysqli_fetch_array($result))
        {
            echo "<tr> Order ID: ".$order['o_id']."</tr>";
            echo "<tr> Customer ID: ".$order['customer_id']."</tr>";
            echo "<tr> Date order Received: ".$order['o_time']."</tr>";
            echo "<tr> Status: ".$order['o_status']."</tr>";
        }
        echo "</table>";
    }
    ?>

</div>

</body>
</html> 