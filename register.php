<?php
// Database connection
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "flip";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check DB connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // ✅ If User Registration
    if (isset($_POST["name"])) {

        $name     = trim($_POST["name"]);
        $email    = trim($_POST["email"]);
        $password = $_POST["password"];
        $confirm  = $_POST["confirm_password"];

        if ($password !== $confirm) {
            die("❌ Passwords do not match! <a href='register.html'>Try again</a>");
        }

        // Check if user already exists
        $check = $conn->prepare("SELECT id FROM users WHERE email=?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {

            echo "
            <body style='background:url(2.jpg) no-repeat center center fixed; background-size:cover; text-align:center;'>
                <h2 style='color:red;'>⚠️ User Already Registered!</h2>
                <a href='login.html'>
                    <button style='padding:10px 20px; border:none; border-radius:8px; background:#28a745; color:white; cursor:pointer;'>
                        Go to Login
                    </button>
                </a>
            </body>";

        } else {

            $hashed = password_hash($password, PASSWORD_BCRYPT);
            $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $name, $email, $hashed);

            if ($stmt->execute()) {

                echo "
                <body style='background:url(2.jpg) no-repeat center center fixed; background-size:cover; text-align:center;'>
                    <h2 style='color:green;'>✅ User Registered Successfully!</h2>
                    <a href='login.html'>
                        <button style='padding:10px 20px; border:none; border-radius:8px; background:#007BFF; color:white; cursor:pointer;'>
                            Go to Login
                        </button>
                    </a>
                </body>";

            } else {
                echo "❌ Error: " . $stmt->error;
            }
        }
    }

    // ✅ If Admin Registration
    if (isset($_POST["username"])) {

        $username = trim($_POST["username"]);
        $email    = trim($_POST["email"]);
        $password = $_POST["password"];
        $confirm  = $_POST["confirm_password"];

        if ($password !== $confirm) {
            die("❌ Passwords do not match! <a href='register.html'>Try again</a>");
        }

        // Check if admin already exists
        $check = $conn->prepare("SELECT id FROM admins WHERE email=?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {

            echo "
            <body style='background:url(2.jpg) no-repeat center center fixed; background-size:cover; text-align:center;'>
                <h2 style='color:red;'>⚠️ Admin Already Registered!</h2>
                <a href='login.html'>
                    <button style='padding:10px 20px; border:none; border-radius:8px; background:#28a745; color:white; cursor:pointer;'>
                        Go to Login
                    </button>
                </a>
            </body>";

        } else {

            $hashed = password_hash($password, PASSWORD_BCRYPT);
            $sql = "INSERT INTO admins (username, email, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $username, $email, $hashed);

            if ($stmt->execute()) {

                echo "
                <body style='background:url(2.jpg) no-repeat center center fixed; background-size:cover; text-align:center;'>
                    <h2 style='color:green;'>✅ Admin Registered Successfully!</h2>
                    <a href='login.html'>
                        <button style='padding:10px 20px; border:none; border-radius:8px; background:#007BFF; color:white; cursor:pointer;'>
                            Go to Login
                        </button>
                    </a>
                </body>";

            } else {
                echo "❌ Error: " . $stmt->error;
            }
        }
    }
}

$conn->close();
?>
