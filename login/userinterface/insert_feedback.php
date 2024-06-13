<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../logout.php");
    exit();
}

$username = $_SESSION['username'];
$message = $_POST['message'];
$rating = $_POST['rating'];

$servername = "localhost";
$username_db = "u471532386_czyrahs";
$password_db = "24Starexified!";
$dbname = "u471532386_czyrahs_os";

// Create a new connection
$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare the SQL statement using a prepared statement
$sql = "INSERT INTO feedbacks (username, message, rating) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

// Bind parameters to the prepared statement
$stmt->bind_param("ssi", $username, $message, $rating);

// Execute the prepared statement
$stmt->execute();

// Close the prepared statement and the connection
$stmt->close();
$conn->close();
?>
