<!-- In your delete_order.php file -->
<?php
// Connect to the database
$servername = "localhost";
$username_db = "u471532386_czyrahs";
$password_db = "24Starexified!";
$dbname = "u471532386_czyrahs_os";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the id from the POST request
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Delete the order from the database
    $sql = "DELETE FROM orderhandler WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "Order deleted successfully";
    } else {
        echo "Error deleting order: " . $conn->error;
    }
} else {
    echo "ID not provided";
}

$conn->close();
?>
