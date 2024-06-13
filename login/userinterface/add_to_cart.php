<?php
session_start(); // Start the session

// Check if the user is not logged in or does not have the 'User', 'Admin', or 'Employee' type
if (!isset($_SESSION['username']) || ($_SESSION['type'] != 'User' && $_SESSION['type'] != 'Admin')) {
    // Redirect to the login page
    header("Location: ../logout.php");
    exit();
}

$servername = "localhost";
$username_db = "u471532386_czyrahs";
$password_db = "24Starexified!";
$dbname = "u471532386_czyrahs_os";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_SESSION['username'];
$pizzaName = $_POST['pizza_name'];
$pizzaPrice = $_POST['pizza_price'];
$orderLocator = generateOrderLocator();
$orderLimit = 5; // Set your desired order limit

// Check if the pizza is already in the cart
$pizzaExists = checkPizzaInCart($conn, $username, $pizzaName);
if ($pizzaExists) {
    echo 'exists'; // Return 'exists' if the pizza is already in the cart
} else {
    // Check if the user has reached the order limit
    $orderCount = getOrderCount($conn, $username);
    if ($orderCount < $orderLimit) {
        // Insert data into the cart table
        $sql = "INSERT INTO cart (username, pizzaName, price, orderLocator) VALUES ('$username', '$pizzaName', '$pizzaPrice', '$orderLocator')";
        if ($conn->query($sql) === TRUE) {
            echo 'success'; // Return 'success' if the pizza is added to the cart successfully
        } else {
            echo 'error'; // Return 'error' if there's an error inserting the pizza into the cart
        }
    } else {
        echo 'limit'; // Return 'limit' if the user has reached the order limit
    }
}

$conn->close();

function checkPizzaInCart($conn, $username, $pizzaName) {
    // Check if the pizza is already in the user's cart
    $sql = "SELECT * FROM cart WHERE username = '$username' AND pizzaName = '$pizzaName'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}

function generateOrderLocator() {
    // Generate a random order locator (you can customize this further)
    return 'ORD' . rand(1000, 9999);
}

function getOrderCount($conn, $username) {
    // Get the current order count for the user
    $sql = "SELECT COUNT(*) AS orderCount FROM cart WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result && $row = $result->fetch_assoc()) {
        return $row['orderCount'];
    } else {
        return 0;
    }
}
?>
