<!DOCTYPE html>
<html>
<head>
	<title>Employee Login</title>
</head>
<body>
    
    <h1 style="text-align:center;">Employee Login</h1>

    <center style="margin-top: 2%">
        <form action = "employee_portal.php" method = "POST">
            <label>Employee ID  :</label><input type = "text" name = "employee_id" class = "box"/><br /><br />
            <label>Password  :</label><input type = "password" name = "password" class = "box" /><br/><br />
            <input type = "submit" value = " Login "/><br />
        </form>
    </center>

    <a href="index.php">Back to Home</a>

</body>
</html>