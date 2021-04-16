<!DOCTYPE html>
<html>
<head>
	<title>Order: <?php $_POST['order_detail_id']?></title>
</head>
<a href="/customer/customer-orders.php">Back to My Orders</a>
<body>
    <h1> Support Ticket Form </h1><br>
        <form action='' method='post'>
        <label for='return_category'> Reason for Support Request: </label>
        <select id='category' name = 'return_category'>
            <option value='Return'> Return</option>
            <option value='Service'> Service</option>
            <option value='Exchange'> Exchange</option>
            <option value='Other'> Other</option>
        </select> <br>
</body>
</html>


