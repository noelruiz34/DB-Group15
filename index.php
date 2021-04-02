<?php 
include 'db.php';
?>


<!DOCTYPE html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        var count = 2;
         $("button").click(function() {
            count = count + 1;
            $("#comments").load("testingDB.php", {
                 numberOfStudents: count
            });
         });
    });
</script>

<html>
<head>  
	<title>My website</title>
</head>
<body>
    
    <a href="rules_status.html">Rules</a>
	<h1>Omazon</h1>
    <a href="index2.php">index2 page</a>

    <p align="right">
        <a href="register.php"><button>Create account</button></a>
        <a href="customer_login.php"><button>Log in</button></a>
    </p>

   

    <h1>Categories</h1>
    <font size="+2">
        Display all the categories from DB here somehow
    </font>

    <p> display of items down here </p>
    
	<br>
    <center style="margin-top: 2%">
        <form method="post">
            <input type="submit" name="btn-jack" value="Jack">


        </form>
    </center>

    <div id="comments">
        <?php
            $sql = "select * from student limit 2";
            $result = $connect->query($sql);

            echo "<table>";
            while($kid = mysqli_fetch_array($result)){
                echo "<tr><td>". $kid['name']. "</td> <td>". $kid['major']. "</td></tr>";
            }
            echo "</table>";
        ?>
    </div>
    <button> Show one more </button>
</body>
</html>
