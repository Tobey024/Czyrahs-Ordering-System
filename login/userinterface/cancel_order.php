<?php
session_start();

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the orderLocator parameter is set
    if (isset($_POST["orderLocator"])) {
        // Retrieve the orderLocator from the POST data
        $orderLocator = $_POST["orderLocator"];

        // Establish connection to the database
        $servername = "localhost";
        $username_db = "u471532386_czyrahs";
        $password_db = "24Starexified!";
        $dbname = "u471532386_czyrahs_os";

        $conn = new mysqli($servername, $username_db, $password_db, $dbname);

        // Check for connection errors
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare SQL statement to delete the order
        $sql = "DELETE FROM orderhandler WHERE OrderLocator = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $orderLocator);

        // Execute the statement
        if ($stmt->execute()) {
            echo "Order canceled successfully.";
        } else {
            echo "Failed to cancel order. Please try again later.";
        }

        // Close the prepared statement and connection
        $stmt->close();
        $conn->close();
    } else {
        echo "OrderLocator parameter is missing.";
    }
} else {
    echo "Invalid request method.";
}
?>
