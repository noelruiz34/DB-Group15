
<html lang="en">
<style>
    table{
    border: 1px solid black;
    margin-top: 5%;
    align:left;
    }
    td {
        border: 1px solid black;
        border-spacing: 10px;
    }
    th {
        border: 1px solid black;
    }
</style>
<head>

</head>
<body>
<?php 
    $dbServername = "database-1.cgnsxr0vmecq.us-east-2.rds.amazonaws.com";
    $dbUser = "admin";
    $dbPass = "12345678";
    $dbName = "Point_of_Sale";
    $connect = mysqli_connect($dbServername, $dbUser, $dbPass, $dbName);
    session_start();
    if(mysqli_connect_errno())
    {
        die("connection Failed! " . mysqli_connect_error());
    }
    if(!isset($_SESSION['employee'])) // If session is not set then redirect to Login Page
       {
           header("Location:/employee/employee-login.php");  
       }
    $sql = "SELECT * FROM pending_email";
    $result = mysqli_query($connect,$sql);
    if(!$result) {
        die("Query Failed!");
    }

    echo "<a href = /employee/employee-portal.php> Back to Employee Portal </a>";
    echo "<table>";
        echo "<tr><th> Email ID </th><th> Recipient Email </th><th> Subject </th><th> Body </th></tr>";
        while($row=mysqli_fetch_array($result)){
            echo "<tr><td>". $row['pending_email_id']. "</td><td>" . $row ['p_email'] . "</td><td>" . $row ['email_subject'] . "</td><td>" . $row ['email_content'] . "</td></tr>";
        }
    echo "</table>";

?>
</body>
</html>

