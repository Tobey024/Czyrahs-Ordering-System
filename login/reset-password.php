<?php

$token = isset($_GET["token"]) ? $_GET["token"] : null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $token = $_POST["token"];

    $token_hash = hash("sha256", $token);

    $mysqli = require __DIR__ . "/database.php";

    $sql = "SELECT * FROM accounts
            WHERE reset_token_hash = ?";

    $stmt = $mysqli->prepare($sql);

    $stmt->bind_param("s", $token_hash);

    $stmt->execute();

    $result = $stmt->get_result();

    $user = $result->fetch_assoc();

    if ($user === null) {
        die("token not found");
    }

    if (strtotime($user["reset_token_hash_expires_at"]) <= time()) {
        die("token has expired");
    }

    if ($_POST["password"] !== $_POST["password_confirmation"]) {
        echo "<script>alert('Passwords must match');</script>";
    } else {
        $password = $_POST["password"];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "UPDATE accounts
        SET password = ?,
            reset_token_hash = CASE
                WHEN reset_token_hash_expires_at > NOW() THEN ''
                ELSE reset_token_hash
            END,
            reset_token_hash_expires_at = CASE
                WHEN reset_token_hash_expires_at > NOW() THEN ''
                ELSE reset_token_hash_expires_at
            END
        WHERE id = ?";

        $stmt = $mysqli->prepare($sql);

        $stmt->bind_param("ss", $hashed_password, $user["id"]);

        $stmt->execute();

        // Display alert and redirect
        echo "<script>alert('Password updated. You can now login.'); window.location.href = 'login.php';</script>";
        exit(); // Stop further execution
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="icon" type="image/png" href="pizzatitle.png">
    <title>Czyrah's Pizza</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
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

        .login-content .input-group-addon,
        .login-content .input-group-text {
            background-color: #4fd845;
            color: white;
            border: none;
            border-radius: 5px 0 0 5px;
        }

        .login-content .input-group-text i {
            margin-right: 5px;
        }

        .login-content .input-group input {
            border-radius: 0 5px 5px 0;
        }

        .login-content .btn {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #4fd845;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        .login-content .btn:hover {
            background-color: #46a049;
        }

        .login-content a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }

        .login-content a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="login-content">
    <h2>Reset Password</h2>
    <form method="post" onsubmit="return validatePassword()">
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
            </div>
            <input type="password" class="form-control" id="password" name="password" placeholder="New Password" required>
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
            </div>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required>
        </div>
        <button type="submit" class="btn">Reset Password</button>
    </form>
    <span>Remembered your password? <a href="login.php">Login here</a></span>
    <br>
    <a href="../index.html"> Go back</a>
</div>
<!-- Modal -->
<div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="messageModalLabel">Message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="messageModalBody">
                <!-- Message content will be displayed here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap JS (Optional, if you want to use Bootstrap JS features) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- jQuery (required for Bootstrap's JavaScript components) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    function displayMessage(message) {
        $('#messageModalBody').html(message);
        $('#messageModal').modal('show');
    }

    function validatePassword() {
        var password = document.getElementById("password").value;
        var confirmPassword = document.getElementById("password_confirmation").value;

        if (password !== confirmPassword) {
            displayMessage("Passwords must match");
            return false; // Prevent form submission
        }

        return true; // Allow form submission
    }
</script>
</body>
</html>


