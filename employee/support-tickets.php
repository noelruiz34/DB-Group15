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
    session_start();
    if(!isset($_SESSION['employee'])) // If session is not set then redirect to Login Page
       {
           header("Location:/employee/employee-login.php");  
       }
    
    $employee_id = $_SESSION['employee'];

    function echoNeedReviewTickets($connect) {
        $sql = "SELECT * FROM support_ticket WHERE e_id=0";
        $result = mysqli_query($connect,$sql);
        if(!$result) {
            die("Query Failed!");
        }

        if(mysqli_num_rows($result)==0) {
            echo "There are no support tickets that need review!";
        }
        else {
            echo "<table>";
                echo "<tr><td> Order ID </td><td> Date Requested </td><td> Category </td><td> Status </td></tr>";
                while($row=mysqli_fetch_array($result)){
                    echo "<tr>
                    <td>". $row['o_id']. "</td>
                    <td>". $row['t_time']. "</td>
                    <td>" . $row ['t_category'] . "</td>
                    <td>" . $row ['t_status'] . "</td>
                    <td><form action='' method=post>
                    <input type = hidden name = address_ticket_id value=$row[t_id]>
                    <input type = submit name = address_button value = 'Address Ticket'/><br />
                    </form></td>
                    </tr>";
                }
            echo "</table>";
        }
    }

    function echoReviewMyTickets($connect, $employee_id) {
        $sql = "SELECT * FROM support_ticket WHERE e_id=$employee_id AND t_status='In Review'";
        $result = mysqli_query($connect,$sql);
        if(!$result) {
            die("Query Failed!");
        }

        if(mysqli_num_rows($result)==0) {
            echo "There are no tickets you are reviewing!";
        }
        else {
            echo "<table>";
            echo "<tr><td> Order ID </td><td> Date Requested </td><td> Category </td><td> Status </td></tr>";
            while($row=mysqli_fetch_array($result)){
                echo "<tr>
                <td>". $row['o_id']. "</td>
                <td>". $row['t_time']. "</td>
                <td>" . $row ['t_category'] . "</td>
                <td>" . $row ['t_status'] . "</td>
                <td><form action='/employee/support-ticket-details.php' method=post>
                <input type = hidden name = ticket_details value=$row[t_id]>
                <input type = submit name = my_tickets_details_button value = 'Details'/><br />
                </form></td>
                </tr>";
            }
            echo "</table>";
        }
        
    }

    function echoResolvedTickets($connect) {
        $sql = "SELECT * FROM support_ticket WHERE t_status='Resolved'";
        $result = mysqli_query($connect,$sql);
        if(!$result) {
            die("Query Failed!");
        }

        if(mysqli_num_rows($result)==0) {
            echo "There are no resolved support tickets!";
        }
        else{
            echo "<table>";
            echo "<tr><td> Order ID </td><td> Employee ID </td><td> Date Requested </td><td> Category </td><td> Status </td></tr>";
            while($row=mysqli_fetch_array($result)){
                echo "<tr>
                <td>". $row['o_id']. "</td>
                <td>" . $row ['e_id'] . "</td>
                <td>". $row['t_time']. "</td>
                <td>" . $row ['t_category'] . "</td>
                <td>" . $row ['t_status'] . "</td>
                <td><form action='/employee/support-ticket-details.php' method=post>
                <input type = hidden name = ticket_details value=$row[t_id]>
                <input type = submit name = resolved_details_button value = 'Details'/><br />
                </form></td>
                </tr>";
            }
            echo "</table>";
        } 
    }
?>

<!DOCTYPE html>
<html>
<head>
	<title>Support Tickets</title>
</head>
<body>
	<h1>Support Tickets</h1>
    <p align='left'>
        <a href = '/employee/employee-portal.php'> Back to Employee Portal </a>
    </p>
    
    <form action="" method="post">
        <input type = "submit" name = "view_need_review_tickets" value = "View Needs Review"/>
        <input type = "submit" name = "review_my_tickets" value = "Review My Tickets"/>
        <input type = "submit" name = "view_resolved_tickets" value = "View Resolved Tickets"/>
    </form>

    <form action="/employee/support-ticket-details.php" method="post">
        <label> Search For Support Ticket (ID): </label><input type = "text" name = "ticket_details" class = "box" />
        <input type = "submit" name = "search_ticket" value = "Search"/> <br /> <br />
    </form>
   
    <?php
        if(isset($_POST['view_need_review_tickets'])) {
            echoNeedReviewTickets($connect);
        }

        if(isset($_POST['review_my_tickets'])) {
            echoReviewMyTickets($connect, $employee_id);
        }

        if(isset($_POST['view_resolved_tickets'])) {
            echoResolvedTickets($connect);
        }

        if(isset($_POST['address_button'])) {
            $ticket_id = $_POST['address_ticket_id'];
            $sql = "UPDATE support_ticket SET e_id=$employee_id, t_status='In Review' WHERE t_id=$ticket_id";
            $result = mysqli_query($connect, $sql);

            if($result){
                echoNeedReviewTickets($connect);
            }
            else {
                die("Query Failed!");
            }
        }
    ?>

</body>
</html>