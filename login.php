<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "flip";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $sql = "
        SELECT id, email, password, 'user' AS role FROM users WHERE email = ? 
        UNION 
        SELECT id, email, password, 'admin' AS role FROM admins WHERE email = ?
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $_SESSION['id'] = $row['id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['role'] = $row['role'];

            // ✅ Redirect based on role
            if ($row['role'] === "admin") {
                header("Location: customer.php");
            } else {
                header("Location: product.html");
            }
            exit();
        } else {
            $message = "❌ Wrong Password!";
        }
    } else {
        $message = "❌ Account not found!";
    }
    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login</title>
<style>
body {
    font-family: Arial, sans-serif;
    background: url('2.jpg') no-repeat center center fixed;
    background-size: cover;
    margin: 0; padding: 0;
    display: flex; justify-content: center; align-items: center;
    height: 100vh;
}
.container { background: rgba(255,255,255,0.9); padding: 30px;
    border-radius: 15px; width: 350px; text-align: center;
    box-shadow: 0 4px 10px rgba(0,0,0,0.3);}
h2 { margin-bottom: 20px; color: #333;}
input { width: 100%; padding: 10px; margin: 8px 0;
    border: 1px solid #aaa; border-radius: 8px;}
button { width: 100%; padding: 10px; margin-top: 10px;
    border: none; border-radius: 8px; background: #007BFF;
    color: white; font-size: 16px; cursor: pointer;}
button:hover { background: #0056b3;}
.message { margin: 15px 0; font-weight: bold;}
.register-link { margin-top: 15px;}
.register-link a { color: green; text-decoration: none; font-weight: bold;}
.register-link a:hover { text-decoration: underline;}
.extra-btn {
    background: #28a745;
    margin-top: 15px;
}
.extra-btn:hover {
    background: #218838;
}
</style>
</head>
<body>
<div class="container">
    <h2>Login</h2>
    <?php if(!empty($message)) echo "<div class='message'>$message</div>"; ?>
    <form method="post" action="">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>

    <!-- ✅ New Register Button -->
    <form action="register.html">
        <button type="submit" class="extra-btn">Register</button>
    </form>

    <div class="register-link">
        Don’t have an account? <a href="register.html">Register here</a>
    </div>
</div>
</body>
</html>
