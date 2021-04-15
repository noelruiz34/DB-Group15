<?php
    $dbServername = "database-1.cgnsxr0vmecq.us-east-2.rds.amazonaws.com";
    $dbUser = "admin";
    $dbPass = "12345678";
    $dbName = "Point_of_Sale";
    
    $connect = mysqli_connect($dbServername, $dbUser, $dbPass, $dbName);
    session_start();
    if(isset($_SESSION['use'])) {
        #header("Location:employee_login.php");
    }

?>

<!DOCTYPE html>
<html>
<head>
	<title>Customer Login</title>
</head>
<body>
	<h1 style="text-align:center;">Login</h1>

    <center style="margin-top: 2%">
        <form action = "" method = "post">
            <label>Email  :</label><input type = "text" name = "email" class = "box"/><br /><br />
            <label>Password  :</label><input type = "password" name = "password" class = "box" /><br/><br />
            <input type = "submit" name = 'login' value = " Login "/><br />
        </form>
    </center>
    <?php
        if(isset($_POST['login'])) {
            $email = $_POST['email'];
            $pass = $_POST['password'];
            $sql = "SELECT * FROM customer WHERE email='$email' AND password='$pass'";
            $result = mysqli_query($connect,$sql);
            $row = mysqli_fetch_array($result);
            if($row) {
                $_SESSION['customer']= $row['customer_id'];
                header("Location:index.php");
            }
            else {
                echo  "<center> Wrong username and/or password </center>";
                echo  "<center> Please try again! </center>";
            }
        };
    ?>
    <center>
        <p> Don't have an account yet? </p>
        <a href="/customer/register.php">Create account</a>
        <br>
        <a href="index.php">Back to Home</a>
    </center>

   

</body>
</html>