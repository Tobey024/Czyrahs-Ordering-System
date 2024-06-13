<?php
$servername = "localhost";
$username = "u471532386_czyrahs";
$password = "24Starexified!";
$dbname = "u471532386_czyrahs_os";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$search_query = isset($_GET['search']) ? $_GET['search'] : '';
if (!empty($search_query)) {
    $search_query = $conn->real_escape_string($search_query);
    $sql = "SELECT * FROM accounts WHERE fname LIKE '%$search_query%' OR lname LIKE '%$search_query%' OR username LIKE '%$search_query%' OR email LIKE '%$search_query%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<p>" . $row["fname"] . " " . $row["lname"] . "</p>";
        }
    } else {
        echo "<p>No accounts found</p>";
    }
} else {
    echo "<p>Please enter a search term</p>";
}

$conn->close();
?>