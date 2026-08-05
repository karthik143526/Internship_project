<?php
session_start();

// Database connection (optional if you want to save items later)
$servername = "localhost";  
$username   = "root";       
$password   = "";           
$dbname     = "flip";       

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Database Connection failed: " . $conn->connect_error);
}

// Initialize cart
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle Add to Cart
if (isset($_POST['add_to_cart'])) {
    $name  = $_POST['name'];
    $price = $_POST['price'];

    $_SESSION['cart'][] = [
        'name'  => $name,
        'price' => $price
    ];

    // Redirect directly to cart
    header("Location: cart.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Products Page</title>
<style>
body { font-family: Arial, sans-serif; background: #f5f5f5; margin: 0; padding: 0; }
header { background: #2874f0; color: white; padding: 15px; text-align: center; font-size: 20px; }
h2.section-title { margin: 20px; font-size: 22px; color: #444; }
.container { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; padding: 20px; }
.product { background: white; padding: 15px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); text-align: center; transition: transform 0.2s ease-in-out; }
.product:hover { transform: scale(1.05); }
.product img { width: 150px; height: 150px; object-fit: contain; margin-bottom: 10px; }
.product h3 { margin: 10px 0; font-size: 18px; color: #333; }
.product p { color: #009688; font-weight: bold; margin: 5px 0; font-size: 16px; }
button { background: #ff5722; color: white; padding: 10px; border: none; border-radius: 8px; cursor: pointer; margin-top: 10px; width: 100%; font-size: 14px; }
button:hover { background: #e64a19; }
</style>
</head>
<body>
<header>Welcome to Flipkart-Style Store 🛒</header>

<h2 class="section-title">📱 Electronics</h2>
<div class="container">
    <div class="product">
        <img src="mobile.jpg" alt="Mobile">
        <h3>Smartphone</h3>
        <p>₹15,999</p>
        <form method="post">
            <input type="hidden" name="name" value="Smartphone">
            <input type="hidden" name="price" value="15999">
            <button type="submit" name="add_to_cart">Add to Cart</button>
        </form>
    </div>

    <div class="product">
        <img src="laptop.jpg" alt="Laptop">
        <h3>Laptop</h3>
        <p>₹45,999</p>
        <form method="post">
            <input type="hidden" name="name" value="Laptop">
            <input type="hidden" name="price" value="45999">
            <button type="submit" name="add_to_cart">Add to Cart</button>
        </form>
    </div>
</div>

</body>
</html>
