<?php
session_start();

// Check if the user is logged in and has the 'User', 'Admin', or 'Employee' type
if (isset($_SESSION['username']) && ($_SESSION['type'] == 'User' || $_SESSION['type'] == 'Admin')) {
    $username = $_SESSION['username'];

    $servername = "localhost";
    $username_db = "u471532386_czyrahs";
    $password_db = "24Starexified!";
    $dbname = "u471532386_czyrahs_os";

    $conn = new mysqli($servername, $username_db, $password_db, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Delete order history for the logged-in user
    $sql = "DELETE FROM orderhandler WHERE username='$username' AND orderstatus='Finish Process'";

    if ($conn->query($sql) === TRUE) {
        echo "Order history deleted successfully.";
    } else {
        echo "Error deleting order history: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Access denied. Please log in as a user or admin.";
}
?>