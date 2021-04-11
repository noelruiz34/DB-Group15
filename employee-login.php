<?php
    $dbServername = "database-1.cgnsxr0vmecq.us-east-2.rds.amazonaws.com";
    $dbUser = "admin";
    $dbPass = "12345678";
    $dbName = "Point_of_Sale";
    
    $connect = mysqli_connect($dbServername, $dbUser, $dbPass, $dbName);
    session_start();
    if(isset($_SESSION['employee'])) {
        header("Location:employee-portal.php");
    }

?>

<!DOCTYPE html>
<html>
<head>
	<title>Employee Login</title>
</head>
<body>
    
    <h1 style="text-align:center;">Employee Login</h1>

    <center style="margin-top: 2%">
        <form action = "" method = "post">
            <label>Employee ID  :</label><input type = "text" name = "employee_id" class = "box"/><br /><br />
            <label>Password  :</label><input type = "password" name = "password" class = "box" /><br/><br />
            <input type = "submit" name = login value = " Login "/><br />
        </form>
        <p><a href="index.php">Back to Home</a></p>
    </center>

    

    <?php
        if(isset($_POST['login'])) {
            $id = $_POST['employee_id'];
            $pass = $_POST['password'];
            $sql = "SELECT * FROM employee WHERE employee_id=$id AND password=$pass";
            $result = mysqli_query($connect,$sql);
            if($result) {
                $_SESSION['employee']=$id;
                header("Location:employee-portal.php");
            }
            else {
                echo  "<center> Wrong username and/or password </center>";
                echo  "<center> Please try again! </center>";
            }
        };
    ?>

</body>
</html>