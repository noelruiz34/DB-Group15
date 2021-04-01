<?

$dbServername = "database-1.cgnsxr0vmecq.us-east-2.rds.amazonaws.com";
$dbUser = "admin";
$dbPass = "12345678";
$dbName = "Point_of_Sale";

$connect = mysqli_connect($dbServername, $dbUser, $dbPass, $dbName) or die("Unable to Connect to '$dbServername'");

if($connect->connect_error) {
    die('Bad connection'. $connect->connect_error);
}

$result = $connect->query("select * from student");
$results = $result->fetch_all();

?>
