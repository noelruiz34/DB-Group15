<?php
$servername = "database-1.cgnsxr0vmecq.us-east-2.rds.amazonaws.com";
$username = "admin";
$password = "12345678";
$dbname = "aws";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT student_id, name, major FROM student";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo "id: " . $row["student_id"]. " - Name: " . $row["name"]. " " . $row["major"]. "<br>";
  }
} else {
  echo "0 results";
}
$conn->close();

?>