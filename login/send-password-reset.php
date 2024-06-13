<?php

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

    $mail = require __DIR__ . "/mailer.php";

    $mail->setFrom("czyrahspizza3@gmail.com");
    $mail->addAddress($email);
    $mail->Subject = "Password Reset";
    $mail->Body = <<<END

    Click <a href="https://czyrahsorderingpizza.000webhostapp.com/login/reset-password.php?token=$token">here</a> 
    to reset your password.

    END;

    try {

        $mail->send();

    } catch (Exception $e) {

        echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";

    }

}

echo "Message sent, please check your inbox.";
