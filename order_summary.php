<!DOCTYPE html>
<?php 
    include 'db.php';
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


<html>
<head>

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
  width: 80%;
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
    if(isset($_POST['Search'])){
    $result = $connect->query("select * from student");

    echo "<table>";
    while($kid = mysqli_fetch_array($result)){
        echo "<tr><td>". $kid['name']. "</td> <td>". $kid['major']. "</td></tr>";
    }
    echo "</table>";
}
    ?>

</div>


<div id="comments">

    </div>
    <button> Show one more </button>
</body>
<script>
    $(document).ready(function() {
        var count = 2;
         $("button").click(function() {
            count = count + 1;
            $("#comments").load("testingDB.php", {
                 numberOfStudents: count
            });
         });
    });
</script>
</html> 