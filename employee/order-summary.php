<!DOCTYPE html>
<?php 
    include '../db.php';
    session_start();
    if(!isset($_SESSION['employee'])) {
      header("Location:/employee/employee-login.php"); 
    }
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>

  function showOptions() {
    const div = document.getElementById('options')
    let html = ''

    html += '<a style=\"fontSize: 150%; marginRight: 1%;\";>Price:</a>'
    html += '<input type=\"radio\" name="status" id="p1" /> $'
    html +=  '<input type="radio" name="status" id="p2" /> $ $'
    html +=  '<input type="radio" name="status" id="p3" /> $ $ $'
    html +=  '<input type="radio" name="status" id="p4" /> $ $ $ $'

    div.innerHTML = html
  }
</script>


<html>
<head>

<a href="/employee/employee-portal.php">Back to Employee Portal</a>


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
        <center style="margin-top: 5%;font-size: 300%;">Order Lookup</center>
        <hr style="width: 50%;">
    </div>

</head>
<body>

<form class="example" action='' method="post">
  <input type="text" placeholder="Search.." name="search">
  <button type="submit" name="Search" ><i class="fa fa-search"></i></button>
</form>

<div id="options"></div>


<div id="order_info">
    <?php 
    if(isset($_POST['search'])){

        $order = $_POST['search'];
        $result = $connect->query("select * from Point_of_Sale.order where o_id = $order");

        $_SESSION['order'] = $order;

        echo "<table id=\"orderInfo\">";
        while($order_info = mysqli_fetch_array($result))
        {
            echo "<tr><td> Order ID: ".$order_info['o_id']."</td></tr>";
            echo "<tr><td> Customer ID: ".$order_info['customer_id']."</td></tr>";
            echo "<tr><td> Date order Received: ".$order_info['o_time']."</td></tr>";
            echo "<tr><td> Status: ".$order_info['o_status']."</td></tr>";
        }
        echo " <form class=\"example\" action='' method=\"POST\"> <a style=\"fontSize: 150%; marginRight: 1%;\";>Update Order Status:</a>
                  <input type=\"radio\" name=\"status\" value=\"Processing\" > Processing
                  <input type=\"radio\" name=\"status\" value=\"In Transit\" > In Transit
                  <input type=\"radio\" name=\"status\" value=\"Delivered\" > Delivered 
                  <input type=\"submit\" name=\"Result\"> 
                </form>";


        echo "</table>";
        $result = $connect->query("select * from Point_of_Sale.product_purchase where o_id = $order");
        echo"<table>";
        echo "<div> <center style=\"margin-top: 5%;font-size: 75%;\">Order Contents</center><hr style=\"width: 35%;margin-bottom: -3%;\"></div>";
        echo "<tr><td>Item UPC</td> <td>Quantitiy Ordered</td> <td>Price</td></tr>";
        while($item = mysqli_fetch_array($result))
        {
            echo "<tr><td>".$item['upc']."</td><td>".$item['quantity_ordered']."</td><td>".$item['p_price']."</td></tr>";
        }
        echo "</table>";

    }

    if(isset($_POST['status']))
    {
      $status = $_POST['status'];
      $order = $_SESSION['order'];

      echo $status;
      $update = $connect->query("update Point_of_Sale.order set o_status = '$status' where o_id = $order");
    }
    ?>

</div>

</body>
</html> 