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
    $sql = "SELECT * FROM support_ticket";
    $result = mysqli_query($connect,$sql);
    if(!$result) {
        die("Query Failed!");
    }
    /*while($row=mysqli_fetch_array($result)) {
        echo $row['o_id'] ;
    } */
    echo "<table>";
        echo "<tr><td> Order ID </td><td> Category </td><td> Status </td></tr>";
        while($row=mysqli_fetch_array($result)){
            echo "<tr><td>". $row['o_id']. "</td><td>" . $row ['t_category'] . "</td><td>" . $row ['t_status'] . "</td></tr>";
        }
    echo "</table>";

?>