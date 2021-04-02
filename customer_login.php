<!DOCTYPE html>
<html>
<head>
	<title>My website</title>
</head>
<body>
    <?php 
    
    if ($_SERVER["REQUEST_METHOD"]=="POST") {
        include 'db.php';
        
        $email = $_POST["email"];
        $password = $_POST["password"]; 
        echo $email;
        
        $sql = "SELECT customer_id FROM customer WHERE email = '".$email."' AND password = '".$password."'";
        $result = mysqli_query($connect, $sql);
        echo $result; /*
        $row = mysqli_fetch_array($result);
        
        $count = mysqli_num_rows($result);
        
        // If result matched $email and $mypassword, table row must be 1 row
            
        if($count == 1) {
            echo "Login sucessful";
        }else {
            echo "Failed to login";
        }
        */
    }
    ?> 
    
	<h1 style="text-align:center;">Login</h1>

    <center style="margin-top: 2%">
        <form action = "customer_login.php" method = "POST">
            <label>email  :</label><input type = "text" name = "email" class = "box"/><br /><br />
            <label>Password  :</label><input type = "password" name = "password" class = "box" /><br/><br />
            <input type = "submit" value = " Login "/><br />
        </form>
        <p> Don't have an account yet? </p>
        <a href="register.php">Create account</a>
    </center>

   

</body>
</html>