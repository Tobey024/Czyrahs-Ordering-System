<?php
session_start(); // Start the session

// Check if the user is not logged in or does not have the 'User', 'Admin', 'Employee', or 'Rider' type
if (!isset($_SESSION['username']) || ($_SESSION['type'] == 'User')) {
    // Redirect to the login page
    header("Location: ../logout.php");
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

$sql = "SELECT oh.id, oh.Username, oh.PizzaName, oh.Price, oh.Quantity, oh.TotalPrice, oh.OrderLocator, oh.OrderStatus, acc.contact 
        FROM orderhandler oh
        JOIN accounts acc ON oh.Username = acc.username";
$result = $conn->query($sql);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rider Panel</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    table{
        text-align:center;
    }
    .on-checking-text {
        background-color: grey; /* Yellow background */
        color: white; /* Text color */
        padding: 2px 5px; /* Optional: Add padding to the highlighted text */
        border-radius: 3px; /* Optional: Add rounded corners to the highlighted text */
        }
        .accepted-order-text {
        background-color: #0d6efd; /* Blue background */
        color: white; /* Text color */
        padding: 2px 5px; /* Optional: Add padding to the highlighted text */
        border-radius: 3px; /* Optional: Add rounded corners to the highlighted text */
        }

        .delivering-text {
            background-color: #0dcaf0; /* Light blue background */
            color: black; /* Text color */
            padding: 2px 5px; /* Optional: Add padding to the highlighted text */
            border-radius: 3px; /* Optional: Add rounded corners to the highlighted text */
        }
        .preparing-order-text {
            background-color: yellow; /* Light blue background */
            color: black; /* Text color */
            padding: 2px 5px; /* Optional: Add padding to the highlighted text */
            border-radius: 3px; /* Optional: Add rounded corners to the highlighted text */
        }
</style>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="riderinterface.php">Rider Panel</a>
        <div class="d-flex">
            <a class="btn btn-light me-2" href="riderinterface.php">Go Back</a>
        </div>
    </div>
</nav>

<!-- Food Start -->
<div class="container mt-3">
  <h2>Order Management</h2>
<div class="container">
<div class="table-responsive">
<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Username</th>
            <th>Pizza Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total Price</th>
            <th>Order Locator</th>
            <th>Contact</th>
            <th>Order Status</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($row = $result->fetch_assoc()) {
            $statusText = $row['OrderStatus'];

            if ($row['OrderStatus'] == 'On Checking') {
                $statusText = "<span class='on-checking-text'>{$statusText}</span>";
            } elseif ($row['OrderStatus'] == 'Accepted Order') {
                $statusText = "<span class='accepted-order-text'>{$statusText}</span>";
            } elseif ($row['OrderStatus'] == 'Preparing Order') {
                $statusText = "<span class='preparing-order-text'>{$statusText}</span>";
            } elseif ($row['OrderStatus'] == 'Delivering') {
                $statusText = "<span class='delivering-text'>{$statusText}</span>";
            } elseif ($row['OrderStatus'] == 'Finish Process') {
                $statusText = "<span style='background-color: green; color: white; padding: 2px 5px; border-radius: 3px;'>{$statusText}</span>";
            }

            echo "<tr>
            <td>{$row['Username']}</td>
            <td>{$row['PizzaName']}</td>
            <td>{$row['Price']}</td>
            <td>{$row['Quantity']}</td>
            <td>{$row['TotalPrice']}</td>
            <td>{$row['OrderLocator']}</td>
            <td>{$row['contact']}</td> <!-- Display the contact field -->
            <td>{$statusText}</td>
          </tr>";
        }
        ?>
        </tbody>
    </table>
</div>
    </div>

