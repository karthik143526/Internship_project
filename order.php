<?php
session_start();

// Database connection variables
$servername = "localhost";   // Change this if using hosting (e.g. InfinityFree server name)
$username   = "root";        // Your DB username
$password   = "";            // Your DB password
$dbname     = "flip";        // Your database name

// Create DB connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Order Confirmation</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background: url('3.jpg') no-repeat center center fixed;
        background-size: cover;
        color: #333;
        text-align: center;
        padding-top: 100px;
    }
    .container {
        background: rgba(255, 255, 255, 0.9);
        padding: 30px;
        border-radius: 15px;
        display: inline-block;
    }
    h2 {
        color: green;
    }
    .btn {
        display: inline-block;
        margin-top: 20px;
        padding: 12px 25px;
        font-size: 16px;
        text-decoration: none;
        color: white;
        background-color: #2874f0;
        border-radius: 8px;
        transition: 0.3s;
    }
    .btn:hover {
        background-color: #1a5fc1;
    }
</style>
</head>
<body>

<div class="container">
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name   = $_POST['product_name'];
    $product_price  = $_POST['product_price'];
    $user_email     = $_POST['user_email'];
    $phone_number   = $_POST['phone_number'];
    $payment_method = $_POST['payment_method'];
    $address        = $_POST['address'];

    // Save order in session
    $_SESSION['orders'][] = [
        'name'    => $product_name,
        'price'   => $product_price,
        'email'   => $user_email,
        'phone'   => $phone_number,
        'payment' => $payment_method,
        'address' => $address
    ];

    // Save order into database (with phone number)
    $sql = "INSERT INTO orders (product_name, product_price, user_email, phone_number, payment_method, address) 
            VALUES ('$product_name', '$product_price', '$user_email', '$phone_number', '$payment_method', '$address')";
    if ($conn->query($sql) === TRUE) {
        echo "<h2>✅ Order Placed Successfully!</h2>";
    } else {
        echo "<h2>❌ Error: " . $conn->error . "</h2>";
    }

    echo "<p>Product: <strong>$product_name</strong></p>";
    echo "<p>Price: <strong>₹$product_price</strong></p>";
    echo "<p>Email: <strong>$user_email</strong></p>";
    echo "<p>Phone: <strong>$phone_number</strong></p>";
    echo "<p>Payment Method: <strong>$payment_method</strong></p>";
    echo "<p>Address: <strong>$address</strong></p>";

    // ✅ Single button → Go back to products
    echo "<a href='product.html' class='btn'>🛒 Continue Shopping</a>";
} else {
    echo "<p>Invalid access.</p>";
}
?>
</div>

</body>
</html>
