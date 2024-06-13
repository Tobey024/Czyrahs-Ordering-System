<?php
$alert_message = ""; // Define the variable with an empty string

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];

    $token = bin2hex(random_bytes(16));

    $token_hash = hash("sha256", $token);

    $expiry = date("Y-m-d H:i:s", time() + 60 * 30);

    $mysqli = require __DIR__ . "/database.php";

    $sql = "UPDATE accounts
            SET reset_token_hash = ?,
                reset_token_hash_expires_at = ?
            WHERE email = ?";

    // Prepare the statement
    $stmt = $mysqli->prepare($sql);

    if ($stmt === false) {
        die("Error preparing statement: " . $mysqli->error);
    }

    // Bind parameters
    $stmt->bind_param("sss", $token_hash, $expiry, $email);

    // Execute the statement
    $stmt->execute();

    // Check for errors
    if ($stmt->error) {
        die("Error executing statement: " . $stmt->error);
    }

    if ($mysqli->affected_rows) {
        // Fetch the username from the database
        $sql = "SELECT username FROM accounts WHERE email = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($username);
        $stmt->fetch();
        $stmt->close();

        // Send the email
        $mail = require __DIR__ . "/mailer.php";

        $mail->setFrom("czyrahspizza3@gmail.com");
        $mail->addAddress($email);
        $mail->Subject = "Password Reset";
        $mail->isHTML(true); // Set email format to HTML
        $mail->Body = "
            <h3>Greetings From Czyrah's Pizza!</h3>
            <h5>Dear $username,</h5>
            Click <a href='https://czyrahspizzamalabon2013.com/login/reset-password.php?token=$token'>here</a> 
            to reset your password.";

        try {
            $mail->send();
            $alert_message = "Message sent, please check your inbox."; // Update the variable
        } catch (Exception $e) {
            $alert_message = "Message could not be sent. Mailer error: {$mail->ErrorInfo}"; // Update the variable
        }

    } else {
        $alert_message = "Email not found."; // Update the variable
    }
    
    // Return the alert message to the AJAX call
    echo $alert_message;
    exit(); // Stop further execution
}
?>


<!DOCTYPE html>
<html>
<head>
    <link rel="icon" type="image/png" href="pizzatitle.png">
    <title>Forgot Password</title>
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

        .login-content {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            padding: 50px;
            width: 100%;
            max-width: 400px;
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
    </style>
</head>
<body>
<div class="login-content">
        <h2>Forgot Password</h2>
        <div id="alert-message"></div>
        <form id="forgotPasswordForm" action="forgot-password.php" method="POST">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                </div>
                <input type="email" class="form-control" name="email" placeholder="Email" required>
            </div>
            <button type="submit" class="btn">Send</button>
        </form>
        <span>Remembered your password? <a href="login.php">Login here</a></span>
        <br>
        <a href="../index.html"> Go back</a>
    </div>
    <!-- Bootstrap JS (Optional, if you want to use Bootstrap JS features) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery (required for Bootstrap's JavaScript components) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#forgotPasswordForm').submit(function(event) {
                event.preventDefault(); // Prevent default form submission

                var formData = $(this).serialize(); // Serialize form data

                $.ajax({
                    type: 'POST',
                    url: 'forgot-password.php',
                    data: formData,
                    success: function(response) {
                        var modal = new bootstrap.Modal(document.getElementById('myModal'));

                        // Show modal and update message on modal shown
                        $('#myModal').on('shown.bs.modal', function() {
                            if (response === 'Message sent, please check your inbox.') {
                                document.getElementById('modal-message').innerHTML = 'Message sent, please check your inbox.';
                            } else if (response === 'Email not found.') {
                                document.getElementById('modal-message').innerHTML = 'Email not found.';
                            }
                        });

                        modal.show();

                        // Redirect when modal is closed
                        $('#myModal').on('hidden.bs.modal', function() {
                            window.location.href = 'login.php';
                        });
                    },
                    error: function() {
                        console.log('Error submitting form');
                    }
                });
            });
        });
    </script>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Reset Password</h5>
                </div>
                <div class="modal-body">
                    <p id="modal-message"></p>
                </div>
            </div>
        </div>
    </div>
        <script>document.addEventListener('DOMContentLoaded', () => {
  var disclaimer =  document.querySelector("img[alt='www.000webhost.com']");
   if(disclaimer){
       disclaimer.remove();
   }  
 });</script>
</body>
</html>
