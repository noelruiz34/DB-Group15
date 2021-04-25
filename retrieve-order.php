<?php

$dbServername = "database-1.cgnsxr0vmecq.us-east-2.rds.amazonaws.com";
$dbUser = "admin";
$dbPass = "12345678";
$dbName = "Point_of_Sale";

$connect = mysqli_connect($dbServername, $dbUser, $dbPass, $dbName);
if (!$connect) {
    die('Could not connect: ' . mysqli_error($connect));
}

if(isset($_POST['search'])){

    $order = $_POST["search"];
    // $result = $connect->query("select * from student");

    echo "<table>";
    echo $order;
    // while($kid = mysqli_fetch_array($result)){
    //     echo "<tr><td>". $kid['name']. "</td> <td>". $kid['major']. "</td></tr>";
    // }
    echo "</table>";
}

?>