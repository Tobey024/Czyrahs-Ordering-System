<?php
session_start(); // Start the session to access session variables

$servername = "localhost";
$username = "u471532386_czyrahs";
$password = "24Starexified!";
$dbname = "u471532386_czyrahs_os";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle the add order request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the username from the session
    $username = $_SESSION['username'];

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO pos (user, customer_tag, pizzaname, price, quantity, orderstatus) VALUES (?, ?, ?, ?, ?, ?)");

    // Iterate over each row in the table
    foreach ($_POST['orders'] as $order) {
        $customerTag = $order['customerTag'];
        $pizzaName = $order['pizzaName'];
        $price = $order['price'];
        $quantity = $order['quantity'];
        $orderStatus = $order['orderStatus'];

        // Bind parameters and execute the statement
        $stmt->bind_param("ssssss", $username, $customerTag, $pizzaName, $price, $quantity, $orderStatus);
        if ($stmt->execute()) {
            echo "Order added successfully";
        } else {
            echo "Error adding order: " . $stmt->error;
        }
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>
