<?php

include "db.php";

// $order = $_POST["search"];

// // $sql = "select * from order where o_id = $order";
// // $result = $connect->query($sql);

// echo "<div>";

// echo $order
// // while($kid = mysqli_fetch_array($result)){
// //     echo "<tr><td>". $kid['name']. "</td> <td>". $kid['major']. "</td></tr>";
// // }
// echo "</div>";


if(isset($_POST['search'])){

    $order = $_POST["search"];
    // $result = $connect->query("select * from student");

    echo "<table>";
    echo $order
    // while($kid = mysqli_fetch_array($result)){
    //     echo "<tr><td>". $kid['name']. "</td> <td>". $kid['major']. "</td></tr>";
    // }
    echo "</table>";
}

?>