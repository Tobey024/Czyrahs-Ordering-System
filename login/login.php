<?php
session_start(); // Start the session

if (isset($_SESSION['username'])) {
    // Redirect based on user type
    if ($_SESSION['type'] == 'Admin') {
        header("Location: admin/admndb.php");
    } elseif ($_SESSION['type'] == 'Employee') {
        header("Location: employee/employeeinterface.php");
    } elseif ($_SESSION['type'] == 'rider') {
        header("Location: rider/riderinterface.php");
    } elseif ($_SESSION['type'] == 'User') {
        header("Location: userinterface/userlandingpage.php");
    } else {
        header("Location: login.php");
    }
    exit();
}

$servername = "localhost";
$username = "u471532386_czyrahs";
$password = "24Starexified!";
$dbname = "u471532386_czyrahs_os";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$alert_message = ""; // Initialize an empty alert message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Using prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM accounts WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Check the hashed password
        if (password_verify($password, $row['password'])) {
            // Check if account_activation_hash is null
            if ($row['account_activation_hash'] === null) {
                // Set session variables
                $_SESSION['username'] = $username;
                $_SESSION['type'] = $row['type']; // Assuming 'type' is the column for user type in your database

                // Redirect based on user type
                if ($row['type'] == 'Admin') {
                    header("Location: admin/admndb.php");
                    exit();
                } elseif ($row['type'] == 'Employee') {
                    header("Location: employee/employeeinterface.php");
                    exit();
                } elseif ($row['type'] == 'Rider') {
                    header("Location: rider/riderinterface.php");
                    exit();
                } elseif ($row['type'] == 'User') {
                    header("Location: userinterface/userlandingpage.php");
                    exit();
                }
            } else {
                $alert_message = '<div class="alert alert-danger" role="alert">Verify your account!</div>';
            }
        } else {
            $alert_message = '<div class="alert alert-danger" role="alert">Invalid password!</div>';
        }
    } else {
        $alert_message = '<div class="alert alert-danger" role="alert">User not found!</div>';
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html>
<head>
    <link rel="icon" type="image/png" href="pizzatitle.png">
    <title>Czyrahs Pizza</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            background-color: #c9d6ff;
            background: linear-gradient(to right, #e2e2e2, #c9d6ff);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            max-width: 900px;
            width: 100%;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .login-image {
            flex: 1;
            background-image: url('czyr.jpg'); /* Replace with the actual path to your image */
            background-size: cover;
            background-position: center;
            min-height: 400px;
        }

        .login-content {
            flex: 1;
            padding: 50px;
        }

        .login-content h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .input-group-addon {
            background-color: #4fd845;
            color: white;
            border: none;
            border-radius: 5px 0 0 5px;
        }

        .input-group-text {
            background-color: #4fd845;
            color: white;
            border: none;
        }

        .input-group-text i {
            margin-right: 5px;
        }

        .input-group input {
            border-radius: 0 5px 5px 0;
        }

        .btn {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #4fd845;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #46a049;
        }

        a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Responsive styles */
        @media (max-width: 767px) {
            .login-container {
                flex-direction: column;
            }

            .login-image {
        width: 100%;
        height: 100%;
            }
        }

        /* Loader styles */
        .loader-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .spinner {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            border: 5px solid #f3f3f3;
            border-top: 5px solid green;
            animation: spin 1s linear infinite;
            position: relative;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .loading-text {
            font-family: monospace;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: black;
            font-size: 24px;
            text-align: center;
        }

        .line {
            border-bottom: 1px solid black; /* Set the line color to black */
            width: 100%; /* Make the line span the width of the container */
            margin-bottom: 0; /* Add some spacing below the line */
        }

        .forgot-password {
            text-align: center;
            margin-top: 15px;
        }

        .forgot-password a {
            color: #1877f2;
            text-decoration: none;
        }

        .or {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 20px 0;
        }

        .or::before,
        .or::after {
            content: "";
            flex: 1;
            border-top: 1px solid #ccc;
        }

        .or span {
            padding: 0 10px;
        }

        .button-container {
            text-align: center;
        }

        .btn2 {
            display: inline-block;
            padding: 8px 16px; /* Adjust the padding as needed */
            font-size: 14px; /* Adjust the font size as needed */
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .btn2:hover {
            background-color: #0056b3; /* Darker shade of blue */
            color: white;
            text-decoration: none; /* Remove underline */
        }
    </style>
</head>
<body>
    <div class="loader-container">
        <div class="loading-text">Loading...</div>
        <div class="spinner"></div>
    </div>
    <div class="login-container">
        <div class="login-image"></div>
        <div class="login-content">
            <h2>Login</h2>
            <?php echo $alert_message; ?>
            <form action="login.php" method="POST">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" class="form-control" name="username" placeholder="Username">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    </div>
                    <input type="password" class="form-control" name="password" placeholder="Password">
                </div>
                <input type="submit" class="btn" value="Login">
            </form>
            <div class="forgot-password">
                <a href="forgot-password.php">Forgot password?</a>
            </div>
            <div class="or">
                <span>Or</span>
            </div>
            <div class="button-container">
                <a href="register.php" class="btn2">Create New Account</a>
            </div>
            <center><a href="../index.html"> Go back</a></center>
        </div>
    </div>
</body>
<script>
    window.addEventListener('load', function() {
            const spinner = document.querySelector('.spinner');
            const loadingText = document.querySelector('.loading-text');
            setTimeout(() => {
                let opacity = 1;
                let fadeOutInterval = setInterval(() => {
                    opacity -= 0.1;
                    spinner.style.opacity = opacity;
                    loadingText.style.opacity = opacity;
                    if (opacity <= 0) {
                        clearInterval(fadeOutInterval);
                        document.querySelector('.loader-container').style.display = 'none';
                    }
                }, 50);
            }, 500);
        });
        document.addEventListener('DOMContentLoaded', () => {
  var disclaimer =  document.querySelector("img[alt='www.000webhost.com']");
   if(disclaimer){
       disclaimer.remove();
   }  
 });
</script>
</html>