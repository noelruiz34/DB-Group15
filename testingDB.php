<?php

// if(isset($_POST['btn-jack'])){
//     $result = $connect->query("select * from student");

//     echo "<table>";
//     while($kid = mysqli_fetch_array($result)){
//         echo "<tr><td>". $kid['name']. "</td> <td>". $kid['major']. "</td></tr>";
//     }
//     echo "</table>";
// }
$numberOfStudents = $_POST['numberOfStudents'];

$sql = "select * from student limit $numberOfStudents";
$result = $connect->query($sql);

echo "<table>";
while($kid = mysqli_fetch_array($result)){
    echo "<tr><td>". $kid['name']. "</td> <td>". $kid['major']. "</td></tr>";
}
echo "</table>";

?>