<?php 
    $dbServername = "database-1.cgnsxr0vmecq.us-east-2.rds.amazonaws.com";
    $dbUser = "admin";
    $dbPass = "12345678";
    $dbName = "Point_of_Sale";
    $connect = mysqli_connect($dbServername, $dbUser, $dbPass, $dbName);
    if(mysqli_connect_errno())
    {
        die("connection Failed! " . mysqli_connect_error());
    }
    $sql = "SELECT * FROM pending_email";
    $result = mysqli_query($connect,$sql);
    if(!$result) {
        die("Query Failed!");
    }

    echo "<table>";
        echo "<tr><td> Email ID </td><td> Recipient Email </td><td> Subject </td></tr>";
        while($row=mysqli_fetch_array($result)){
            echo "<tr><td>". $row['pending_email_id']. "</td><td>" . $row ['p_email'] . "</td><td>" . $row ['email_subject'] . "</td></tr>";
        }
    echo "</table>";

?>