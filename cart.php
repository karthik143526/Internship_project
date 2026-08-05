<?php  
session_start(); 
 
// Database connection variables 
$servername = "localhost";   // Change if using hosting 
$username   = "root";        // Your DB username 
$password   = "";            // Your DB password 
$dbname     = "flip";        // Your database name 
 
// Create connection 
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
<title>Your Cart</title>  
<style>  
    body {  
        font-family: Arial, sans-serif;  
        margin: 0; padding: 0;  
        background: url('3.jpg') no-repeat center center fixed;  
        background-size: cover;  
    }  
    header {  
        background: rgba(40, 116, 240, 0.9);  
        color: white;  
        padding: 15px;  
        text-align: center;  
        font-size: 24px;  
        font-weight: bold;  
    }  
    .container {  
        width: 80%;  
        margin: 30px auto;  
        background: rgba(255,255,255,0.9);  
        padding: 20px;  
        border-radius: 12px;  
        box-shadow: 0 4px 10px rgba(0,0,0,0.3);  
    }  
    table {  
        width: 100%;  
        border-collapse: collapse;  
        margin-bottom: 20px; 
    }  
    th, td {  
        border: 1px solid #ddd;  
        padding: 12px;  
        text-align: center;  
        font-size: 16px;  
    }  
    th {  
        background: #2874f0;  
        color: white;  
    }  
    .order-btn {  
        background: #ff5722;  
        color: white;  
        padding: 10px 15px;  
        border: none;  
        border-radius: 6px;  
        cursor: pointer;  
        margin-top: 5px;  
    }  
    .order-btn:hover { background: #e64a19; }  
    .remove-btn {  
        background: red;  
        color: white;  
        padding: 10px 15px;  
        border: none;  
        border-radius: 6px;  
        cursor: pointer;  
        margin-top: 5px;  
    }  
    .remove-btn:hover { background: darkred; }  
    .back {  
        margin-top: 20px;  
        display: inline-block;  
        text-decoration: none;  
        color: white;  
        background: green;  
        padding: 12px 20px;  
        border-radius: 8px;  
        font-size: 16px;  
    }  
    .empty-cart {  
        font-size: 18px;  
        font-weight: bold;  
        color: red;  
    }  
    .checkout-form { 
        margin-top: 20px; 
        text-align: left; 
    } 
    .checkout-form label { 
        display: block; 
        margin: 10px 0 5px; 
    } 
    .checkout-form input,  
    .checkout-form select,  
    .checkout-form textarea { 
        width: 100%; 
        padding: 10px; 
        margin-bottom: 15px; 
        border: 1px solid #ccc; 
        border-radius: 6px; 
    } 
    .payment-extra { 
        display: none; 
    }
</style>  
<script>  
function loadCart() {  
    let cart = JSON.parse(localStorage.getItem("cart")) || [];  
    let tableBody = document.getElementById("cart-body");  
    tableBody.innerHTML = "";  
 
    if (cart.length === 0) {  
        tableBody.innerHTML = "<tr><td colspan='3' class='empty-cart'>Cart is empty ❌</td></tr>";  
        document.getElementById("checkout-section").style.display = "none"; 
        return;  
    }  
 
    document.getElementById("checkout-section").style.display = "block"; 
 
    cart.forEach((item, index) => {  
        let row = `<tr>  
            <td>${item.name}</td>  
            <td>₹${item.price}</td>  
            <td> 
                <button class="remove-btn" onclick="removeFromCart(${index})">❌ Remove</button>  
            </td>  
            <input type="hidden" name="product_name" value="${item.name}"> 
            <input type="hidden" name="product_price" value="${item.price}"> 
        </tr>`;  
        tableBody.innerHTML += row;  
    });  
}  
 
function removeFromCart(index) { 
    let cart = JSON.parse(localStorage.getItem("cart")) || []; 
    cart.splice(index, 1);  // remove item 
    localStorage.setItem("cart", JSON.stringify(cart)); 
    loadCart(); // refresh table 
} 

function showPaymentFields() {
    let method = document.getElementById("payment-method").value;

    // Hide all extra fields first
    document.getElementById("card-details").style.display = "none";
    document.getElementById("upi-details").style.display = "none";

    if (method === "Credit Card" || method === "Debit Card") {
        document.getElementById("card-details").style.display = "block";
    } else if (method === "UPI") {
        document.getElementById("upi-details").style.display = "block";
    }
}
</script>  
</head>  
<body onload="loadCart()">  
 
<header>Your Shopping Cart 🛒</header>  
 
<div class="container">  
    <form method="POST" action="order.php"> 
        <table>  
            <thead>  
                <tr>  
                    <th>Product Name</th>  
                    <th>Price</th>  
                    <th>Action</th>  
                </tr>  
            </thead>  
            <tbody id="cart-body"></tbody>  
        </table>  
 
        <!-- Checkout Section --> 
        <div id="checkout-section" class="checkout-form" style="display:none;"> 
            <label>Email:</label> 
            <input type="email" name="user_email" required> 
 
            <label>Payment Method:</label> 
            <select name="payment_method" id="payment-method" onchange="showPaymentFields()" required> 
                <option value="">-- Select Payment Method --</option> 
                <option value="Credit Card">Credit Card</option> 
                <option value="Debit Card">Debit Card</option> 
                <option value="UPI">UPI (Google Pay / PhonePe etc.)</option> 
                <option value="Cash on Delivery">Cash on Delivery</option> 
            </select> 

            <!-- Card Details -->
            <div id="card-details" class="payment-extra">
                <label>Card Number:</label>
                <input type="text" name="card_number" pattern="\d{16}" placeholder="Enter 16-digit card number">
            </div>

            <!-- UPI Details -->
            <div id="upi-details" class="payment-extra">
                <label>UPI ID:</label>
                <input type="text" name="upi_id" placeholder="example@upi">
            </div>

            <label>Address:</label> 
            <textarea name="address" required></textarea> 

            <label>Phone Number:</label>
            <input type="tel" name="phone_number" pattern="[0-9]{10}" placeholder="Enter 10-digit phone number" required>

            <button type="submit" class="order-btn">🛍 Place Order</button> 
        </div> 
    </form> 
 
    <a href="product.html" class="back">⬅ Continue Shopping</a>  
</div>  
 
</body>  
</html>
