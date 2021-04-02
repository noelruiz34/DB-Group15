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

    <section class="Header">
        <div class="logo">
            <img src="./POSWebsite_files/Logo_small.png" alt="POS Logo">

            
        </div>

        <div class="Header text-right">
            <ul>
                <li>
                    <a href="https://main.dr6hta4wx6gai.amplifyapp.com/?Search=hello&amp;submit=Submit#">Home</a>
                </li>
                <li>
                    <a href="https://main.dr6hta4wx6gai.amplifyapp.com/?Search=hello&amp;submit=Submit#">About</a>
                </li>
                <li>
                    <a href="https://main.dr6hta4wx6gai.amplifyapp.com/?Search=hello&amp;submit=Submit#">Contact</a>
                </li>
            </ul>
        </div>
        <div>
            <div class="clearfix">

            </div>
        </div>

    </section>

    <section class="Search Bar">
        <div class="text-center container">
             <form action="https://main.dr6hta4wx6gai.amplifyapp.com/?Search=hello&amp;submit=Submit">
                 <input type="Search" name="Search" placeholder="Search">
                 <input type="submit" name="submit" value="Submit"> <!-- Eventually replace the "submit" search button with Mag. Glass icon-->
             </form>
        </div>
    </section>

    <section class="Explore">
        <div class="container">
            
            <div class="Explore Our Products">
                <div class="Image - 1">
                    Image 1 Front Page
                </div>
                <div class="Image - 2">
                    Image 2 Front Page
                </div>
                <div class="Image - 3">
                    Image 3 Front Page
                </div>
                
            </div>
        </div>
    </section>

    <section class="Catalog Display">
        <div class="container">
            <h2>Browse Our Aisles</h2>
            <div class="Electronics">
                Electronics
            </div>
            <div class="Clothing">
                Clothing
            </div>
            <div class="Travel">
                Travel
            </div>
            <div class="Health">
                Health
            </div>
            <div class="Home">
                Home
            </div>
            <div class="Bath">
                Bath
            </div>
        </div>
    </section>

    

    <section class="Social Media">
        <div class="container">
            <ul>
                <li>
                    <a href="https://main.dr6hta4wx6gai.amplifyapp.com/?Search=hello&amp;submit=Submit#"> Facebook</a>
                </li>
                <li>
                    <a href="https://main.dr6hta4wx6gai.amplifyapp.com/?Search=hello&amp;submit=Submit#"> Instagram</a>
                </li>
                <li>
                    <a href="https://main.dr6hta4wx6gai.amplifyapp.com/?Search=hello&amp;submit=Submit#"> Twitter</a>
                </li>
            </ul>
        </div>
    </section>

    <section class="Footer">
        <div class="container">
            <p>All Rights Reserved. Created By Team15. 2021.</p>
        </div>
    </section>
</body>
</html>
