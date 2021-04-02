<?php

$dbServername = "database-1.cgnsxr0vmecq.us-east-2.rds.amazonaws.com";
$dbUser = "admin";
$dbPass = "12345678";
$dbName = "Point_of_Sale";

$connect = mysqli_connect($dbServername, $dbUser, $dbPass, $dbName) or die("Unable to Connect to '$dbServername'");
// mysqli_select_db($connect, $dbName) or die("Could not open the db '$dbName'");
if($connect->connect_error) {
    die('Bad connection'. $connect->connect_error);
}

$result = $connect->query("SELECT * FROM product_category");
$results = $result->fetch_all();

if ($result->num_rows > 0) {
    echo "<table>";
    while($row = $result->fetch_assoc()){
        echo "<tr><td>". $row['category_name']. "</td></tr>";
    }
    echo "</table>";
}


print_r($results);

$connect->close()
// $test_query = "SHOW TABLES FROM $dbName";
// $result = mysqli_query($test_query);

// $tblCnt = 0;
// while($tbl = mysqli_fetch_array($result)) {
//   $tblCnt++;
//   #echo $tbl[0]."<br />\n";
// }

// if (!$tblCnt) {
//   echo "There are no tables<br />\n";
// } else {
//   echo "There are $tblCnt tables<br />\n";
// }


?>

