<?php

if(isset($_POST['btn-jack'])){
    $result = $connect->query("select * from student");

    echo "<table>";
    while($kid = mysqli_fetch_array($result)){
        echo "<tr><td>". $kid['name']. "</td> <td>". $kid['major']. "</td></tr>";
    }
    echo "</table>";
}

?>