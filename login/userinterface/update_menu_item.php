<?php
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

// Check if the ID parameter is set
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $pizzaName = $_POST['pizzaName'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Prepare an update statement
    $stmt = $conn->prepare("UPDATE menu1 SET PizzaName = ?, Description = ?, Price = ? WHERE id = ?");
    $stmt->bind_param("ssdi", $pizzaName, $description, $price, $id);

    // Execute the statement
    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>
