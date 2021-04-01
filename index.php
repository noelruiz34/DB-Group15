<?php

$dbServername = "database-1.cgnsxr0vmecq.us-east-2.rds.amazonaws.com";
$dbUser = "admin";
$dbPass = "12345678";
$dbName = "database-1";

// $link = new mysqli($_SERVER['database-1.cgnsxr0vmecq.us-east-2.rds.amazonaws.com'], $_SERVER['admin'], $_SERVER['12345678'], $_SERVER['database-1'], $_SERVER['3306']);
$conn = mysqli_connect($dbServername, $dbUser, $dbPass, $dbName);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Hello world"

// $sql = "SELECT * from student;"

// echo $sql
// $result = $conn->query($sql);
// if ($result->num_rows > 0) {
//     // output data of each row
//     while($row = $result->fetch_assoc()) {
//       echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
//     }
//   } else {
//     echo "0 results";
//   }

?>