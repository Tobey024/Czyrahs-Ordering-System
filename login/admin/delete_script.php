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

// Check if ID parameter is set in the URL
if (isset($_GET["id"])) {
    $id = $_GET["id"];

    // Delete query
    $sql_delete = "DELETE FROM accounts WHERE id='$id'";

    if ($conn->query($sql_delete) === TRUE) {
        // Redirect to the same page
        header("Location: admnusermanage.php?delete_success=true");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "ID parameter not set.";
}

$conn->close();
?>
