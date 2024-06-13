<?php
$servername = "localhost";
$username = "u471532386_czyrahs";
$password = "24Starexified!";
$dbname = "u471532386_czyrahs_os";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start session
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST['firstName'];
    $mname = $_POST['middleName'];
    $lname = $_POST['lastName'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $birthday = $_POST['birthday'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];

    // Check if username, email, or contact already exist
    $check_sql = "SELECT * FROM accounts WHERE username=? OR email=? OR contact=?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("sss", $username, $email, $contact);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        $_SESSION['error_message'] = "Account already exists.";
    } else {
        $activation_token = bin2hex(random_bytes(16));
        $activation_token_hash = hash("sha256", $activation_token);

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert new record
        $sql = "INSERT INTO accounts (fname, mname, lname, username, password, email, birthday, address, contact, type, account_activation_hash) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'User', ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssss", $fname, $mname, $lname, $username, $hashed_password, $email, $birthday, $address, $contact, $activation_token_hash);
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Successfully registered! Please Check your email to activate your account.";
            if ($stmt->affected_rows) {
                require_once __DIR__ . "/mailer.php"; // Corrected require_once statement
                $mail->setFrom("czyrahspizza3@gmail.com");
                $mail->addAddress($_POST["email"]);
                $mail->Subject = "Verify Account";
                $mail->Body = <<<END
<h4>Greetings From Czyrah's Pizza!</h4>
<h5>Dear $username,</h5>
Click <a href="https://czyrahspizzamalabon2013.com/login/activate-account.php?token=$activation_token">here</a> to Verify your Account.
END;

                try {
                    $mail->send();
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
                }
            }
        } else {
            $_SESSION['error_message'] = "Error: " . $sql . "<br>" . $conn->error;
        }
        $stmt->close();
    }
    $check_stmt->close();
}

$conn->close();
?>


<!DOCTYPE html>
<html>
<head>
    <link rel="icon" type="image/png" href="pizzatitle.png">
    <title>Czyrah's Pizza</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            background-color: #c9d6ff;
            background: linear-gradient(to right, #e2e2e2, #c9d6ff);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .register-content {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            padding: 50px;
            width: 100%;
            max-width: 800px;
        }

        .register-content h2 {
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

        /* Adjusted style for inline block */
        .form-group-inline {
            display: inline-block;
            width: calc(33.33% - 20px); /* Adjust width as needed */
            margin-right: 10px;
        }

        .form-group-inline:last-child {
            margin-right: 0;
        }

        .success-message {
            text-align: center;
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
            display: <?php echo empty($success_message) ? 'none' : 'block'; ?>;
        }

        .error-message {
            text-align: center;
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
            display: <?php echo empty($error_message) ? 'none' : 'block'; ?>;
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
            font-family:monospace;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: black;
            font-size: 24px;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="loader-container">
        <div class="loading-text">Loading...</div>
        <div class="spinner"></div>
    </div>
    <div class="register-content">
        <h2>Register</h2>
        <div class="success-message"><?php echo $success_message; ?></div>
        <div class="error-message"><?php echo $error_message; ?></div>
        <form action="#" method="POST">
            <div class="form-group form-group-inline">
                <label for="firstName"><span>First Name</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" class="form-control" name="firstName" placeholder="First Name" required>
                </div>
            </div>
            <div class="form-group form-group-inline">
                <label for="middleName"><span>Middle Name</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" class="form-control" name="middleName" placeholder="Middle Name">
                </div>
            </div>
            <div class="form-group form-group-inline">
                <label for="lastName"><span>Last Name</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" class="form-control" name="lastName" placeholder="Last Name" required>
                </div>
            </div>
            <div class="form-group">
                <label for="username"><span>Username</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" class="form-control" name="username" placeholder="Username" required>
                </div>
            </div>
            <div class="form-group">
                <label for="email"><span>Email</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    </div>
                    <input type="email" class="form-control" name="email" placeholder="Email" required>
                </div>
            </div>
            <div class="form-group">
                <label for="password"><span>Password</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    </div>
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                </div>
            </div>
            <div class="form-group">
                <label for="birthday"><span>Birthday</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                    </div>
                    <input type="date" class="form-control" name="birthday" placeholder="Birthday">
                </div>
            </div>
            <div class="form-group">
                <label for="address"><span>Address</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                    </div>
                    <input type="text" class="form-control" name="address" placeholder="Address">
                </div>
            </div>
            <div class="form-group">
    <label for="contact"><span>Contact</span></label>
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="fas fa-phone"></i></span>
        </div>
        <input type="text" class="form-control" name="contact" id="contact" placeholder="0900-000-0000" required pattern="09\d{9}" oninvalid="this.setCustomValidity('Contact number must start with 09.')" oninput="this.setCustomValidity('')">


    </div>
    <div class="invalid-feedback">Contact number must start with 09.</div>
</div>

            <input type="submit" class="btn" value="Register">
            <span>Already Have an Account?<a href="login.php"> Login here</a></span>
            <br>
            <a href="../index.html">Go back</a>
        </form>
    </div>
    
    <!-- Modal for success message -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Success</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo $_SESSION['success_message']; ?>
            </div>
        </div>
    </div>
</div>
<!-- Modal for error message -->
<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel">Error</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo $_SESSION['error_message']; ?>
            </div>
        </div>
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
        document.getElementById('contact').addEventListener('input', function() {
    if (!this.checkValidity()) {
        this.setCustomValidity('Contact number must start with 09.');
    } else {
        this.setCustomValidity('');
    }
});
</script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function(){
        // Show success modal if success message is set
        <?php if(isset($_SESSION['success_message'])): ?>
            $('#successModal').modal('show');
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>
        
        // Show error modal if error message is set
        <?php if(isset($_SESSION['error_message'])): ?>
            $('#errorModal').modal('show');
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>
    });
</script>
</html>