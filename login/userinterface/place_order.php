<?php
session_start();

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

// Check if there is an ongoing order for the user
$ongoingOrder = checkOngoingOrder($conn, $username);

if (!$ongoingOrder) {
    // Get the total price from the JavaScript variable
    $quantities = isset($_POST['quantities']) ? json_decode($_POST['quantities'], true) : [];

    foreach ($quantities as $orderLocator => $data) {
        $quantity = $data['quantity'];
        $pizzaName = $data['pizzaName'];

        // Get the price of the item from the database
        $priceSql = "SELECT Price FROM cart WHERE Username = ? AND PizzaName = ?";
        $stmt = $conn->prepare($priceSql);
        $stmt->bind_param("ss", $username, $pizzaName);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $row = $result->fetch_assoc()) {
            $price = $row['Price'];
            $totalOrderPrice = $price * $quantity;

                        // Insert data into the 'orderhandler' table with the status set to 'On Checking' and a blank value for rider
            $transferSql = "INSERT INTO orderhandler (username, pizzaName, price, quantity, orderLocator, orderStatus, totalprice, rider) 
                            SELECT username, pizzaName, price, ?, MIN(orderLocator), 'On Checking', ?, ''
                            FROM cart WHERE username = ? AND pizzaName = ? GROUP BY pizzaName";
            
            $stmt = $conn->prepare($transferSql);
            $stmt->bind_param("dsss", $quantity, $totalOrderPrice, $username, $pizzaName);
            $stmt->execute();

        }
    }

    // Clear the cart for the user
    $clearCartSql = "DELETE FROM cart WHERE username = ?";
    $stmt = $conn->prepare($clearCartSql);
    $stmt->bind_param("s", $username);
    $stmt->execute();

    echo "success"; // Return 'success' if the order is processed successfully
} else {
    echo "ongoing"; // Return 'ongoing' if there is an ongoing order
}

$conn->close();

function checkOngoingOrder($conn, $username) {
    // Check if the user has an ongoing order
    $sql = "SELECT COUNT(*) AS orderCount FROM orderhandler WHERE username = ? AND orderStatus IN ('On Checking', 'Accept Order', 'Preparing Order', 'Delivering')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $row = $result->fetch_assoc()) {
        return $row['orderCount'] >= 3;
    } else {
        return false;
    }
}
?>
