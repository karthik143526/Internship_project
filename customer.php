<?php
session_start();

// Database connection
$servername = "localhost";
$username   = "root";
$password   = "";
$database   = "flip";

$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// ============================================================
// HANDLE DELETE REQUEST
// ============================================================
if (isset($_GET['delete'])) {

    $delete_id = intval($_GET['delete']);

    $delete_sql = "DELETE FROM orders WHERE order_id = $delete_id";

    if (mysqli_query($conn, $delete_sql)) {

        // SUCCESS REMOVE PAGE
        echo "
        <!DOCTYPE html>
        <html>
        <head>
            <title>Order Removed</title>

            <style>
                body{
                    margin:0;
                    padding:0;
                    font-family:Arial,sans-serif;
                    background:url('2.jpg') no-repeat center center fixed;
                    background-size:cover;
                    display:flex;
                    justify-content:center;
                    align-items:center;
                    height:100vh;
                }

                .success-box{
                    background:rgba(255,255,255,0.95);
                    padding:40px;
                    border-radius:15px;
                    text-align:center;
                    width:400px;
                    box-shadow:0px 5px 15px rgba(0,0,0,0.3);
                    animation:fadeIn 1s ease-in-out;
                }

                h1{
                    color:green;
                    margin-bottom:15px;
                }

                p{
                    font-size:18px;
                    color:#333;
                }

                .loader{
                    margin:20px auto;
                    border:5px solid #f3f3f3;
                    border-top:5px solid #28a745;
                    border-radius:50%;
                    width:50px;
                    height:50px;
                    animation:spin 1s linear infinite;
                }

                @keyframes spin{
                    0%{
                        transform:rotate(0deg);
                    }
                    100%{
                        transform:rotate(360deg);
                    }
                }

                @keyframes fadeIn{
                    from{
                        opacity:0;
                        transform:translateY(-20px);
                    }
                    to{
                        opacity:1;
                        transform:translateY(0);
                    }
                }
            </style>

            <script>
                setTimeout(function(){
                    window.location.href='customer.php';
                },3000);
            </script>

        </head>

        <body>

            <div class='success-box'>
                <h1>✅ Order Removed Successfully</h1>

                <p>Redirecting to Customer Page...</p>

                <div class='loader'></div>
            </div>

        </body>
        </html>
        ";

        exit;

    } else {

        echo "<script>alert('Failed to remove order');</script>";
    }
}

// ============================================================
// FETCH ORDERS
// ============================================================
$sql = "SELECT order_id, user_email, phone_number, product_name, product_price, payment_method, address, order_date 
        FROM orders 
        ORDER BY order_date DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Customer Orders</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('2.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
        }

        header {
            background: rgba(40, 116, 240, 0.9);
            color: white;
            padding: 15px;
            text-align: center;
        }

        table {
            width: 90%;
            margin: 30px auto;
            border-collapse: collapse;
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background: #2874f0;
            color: white;
        }

        tr:nth-child(even) {
            background: #f9f9f9;
        }

        .btn-remove {
            background: red;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-remove:hover {
            background: darkred;
        }

        .btn-login {
            display: block;
            width: 220px;
            margin: 20px auto;
            padding: 12px;
            text-align: center;
            background: green;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
        }

        .btn-login:hover {
            background: darkgreen;
        }
    </style>

</head>

<body>

    <header>
        <h2>📦 Customer Ordered Products</h2>
    </header>

    <table>

        <tr>
            <th>Order ID</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Product Name</th>
            <th>Price (₹)</th>
            <th>Payment Method</th>
            <th>Address</th>
            <th>Order Date</th>
            <th>Action</th>
        </tr>

        <?php if ($result && mysqli_num_rows($result) > 0): ?>

            <?php while ($row = mysqli_fetch_assoc($result)): ?>

                <tr>

                    <td><?php echo $row['order_id']; ?></td>

                    <td>
                        <?php echo htmlspecialchars($row['user_email']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['phone_number']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['product_name']); ?>
                    </td>

                    <td>
                        ₹<?php echo number_format((float)$row['product_price'], 2); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['payment_method']); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row['address']); ?>
                    </td>

                    <td>
                        <?php echo $row['order_date']; ?>
                    </td>

                    <td>
                        <a class="btn-remove"
                           href="customer.php?delete=<?php echo $row['order_id']; ?>"
                           onclick="return confirm('Are you sure you want to delete this order?')">
                           ❌ Remove
                        </a>
                    </td>

                </tr>

            <?php endwhile; ?>

        <?php else: ?>

            <tr>
                <td colspan="9">No orders found</td>
            </tr>

        <?php endif; ?>

    </table>

    <!-- LOGIN BUTTON -->
    <a href="admin_login.html" class="btn-login">
        🔑 Go to Login
    </a>

</body>
</html>

<?php mysqli_close($conn); ?>