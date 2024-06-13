<?php
session_start(); // Start the session

if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to the login page if not logged in
    exit();
}

$username = $_SESSION['username'];

$servername = "localhost";
$username_db = "u471532386_czyrahs";
$password_db = "24Starexified!";
$dbname = "u471532386_czyrahs_os";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['orderLocator'])) {
    $orderLocator = $_POST['orderLocator'];

    // Use a prepared statement to prevent SQL injection
    $deleteSql = "DELETE FROM cart WHERE OrderLocator = ? AND Username = ?";
    $stmt = $conn->prepare($deleteSql);
    $stmt->bind_param("ss", $orderLocator, $username);

    if ($stmt->execute()) {
        $response = array('success' => true);
    } else {
        $response = array('success' => false, 'message' => "Error deleting item: " . $stmt->error);
    }

    echo json_encode($response);
}

$stmt->close();
$conn->close();
?>
