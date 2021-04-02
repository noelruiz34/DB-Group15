<!DOCTYPE html> <!-- This page is for after an employee logs in -->
<html>
<head>
	<title>Employee Portal</title>
</head>
<body>
    
	<h1>Employee Portal</h1>

    <p align="right">
        <a href="index.php"><button>Log Out</button></a>
    </p>

    <font size="+1"> <!-- Not sure if this is necessary -->
        Hello "insert login name here"!
    </font>

    <h1>Product</h1>
    <a href="add_product.php"><button>Add Product</button></a>
    <a href="update_product.php"><button>Update Product</button></a>
    <p><label>Search Product Update History  :</label><input type = "text" name = "product_update_history" class = "box"/><br /><br /></p>

    <h1>Support Tickets</h1>
    <input type = "submit" value = " View All Tickets "/><br />
    <a href="update_tickets.php"><button>Update Ticket</button></a>
    <p><label>Search Support Ticket  :</label><input type = "text" name = "support_ticket" class = "box"/><br /><br /></p>

    <h1>Sales</h1>
    <input type = "submit" value = " Generate Sales Report "/><br />
    Search Sales for Date: <input type='month' id='exp_date' name='exp_date'/><br/>




</body>
</html>
