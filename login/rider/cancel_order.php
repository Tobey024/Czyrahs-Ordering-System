<?php
session_start(); // Start the session

if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $orderLocator = $_POST['orderLocator'];

    // Perform the deletion
    $sql = "DELETE FROM orderhandler WHERE OrderLocator = '$orderLocator'";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Order cancelled successfully"]);
    } else {
        echo json_encode(["error" => "Error cancelling order: " . $conn->error]);
    }
}

$conn->close();
?>
