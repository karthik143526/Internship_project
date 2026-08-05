<?php
session_start();

// ============================================================
// DATABASE CONNECTION
// ============================================================
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "flip";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ============================================================
// ONLY HANDLE POST REQUESTS
// ============================================================
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $admin_email = trim($_POST['admin_email']);
    $admin_id    = trim($_POST['admin_id']);

    // CHECK ADMIN CREDENTIALS
    $stmt = $conn->prepare("SELECT id, email, admin_id FROM admin_credentials WHERE email = ? AND admin_id = ?");
    $stmt->bind_param("ss", $admin_email, $admin_id);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {

        // SUCCESS LOGIN
        $row = $result->fetch_assoc();

        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_email']     = $row['email'];
        $_SESSION['admin_id']        = $row['admin_id'];
        $_SESSION['role']            = 'admin';

        $stmt->close();
        $conn->close();

        // SUCCESS PAGE
        echo "
        <!DOCTYPE html>
        <html>
        <head>
            <title>Login Success</title>

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
                    background:rgba(255,255,255,0.9);
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
                    0%{ transform:rotate(0deg); }
                    100%{ transform:rotate(360deg); }
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
                <h1>✅ Login Successful</h1>

                <p>Redirecting to Customer Page...</p>

                <div class='loader'></div>
            </div>

        </body>
        </html>
        ";

        exit();

    } else {

        // WRONG CREDENTIALS
        $stmt->close();
        $conn->close();

        header("Location: admin_login.html?error=1");
        exit();
    }

} else {

    // NOT POST REQUEST
    header("Location: admin_login.html");
    exit();
}
?>