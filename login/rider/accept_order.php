<?php
session_start();

if (isset($_SESSION['username']) && isset($_POST['orderlocator'])) {
    $username = $_SESSION['username'];
    $orderlocator = $_POST['orderlocator'];

    $servername = "localhost";
    $username_db = "u471532386_czyrahs";
    $password_db = "24Starexified!";
    $dbname = "u471532386_czyrahs_os";

    $conn = new mysqli($servername, $username_db, $password_db, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind the update statement
    $stmt = $conn->prepare("UPDATE orderhandler SET rider = ?, OrderStatus = 'Accepted Order' WHERE orderlocator = ?");
    $stmt->bind_param("ss", $username, $orderlocator);

    // Execute the update statement
    if ($stmt->execute()) {
        echo "Order accepted successfully!";
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}

?>
