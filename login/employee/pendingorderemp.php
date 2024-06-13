<?php
session_start(); // Start the session

// Check if the user is not logged in or does not have the 'Employee' type
if (!isset($_SESSION['username']) || $_SESSION['type'] !== 'Employee') {
    // Redirect to the logout page
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

// Check if the Cooking or Cancel button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['cookingButton']) || isset($_POST['cancelButton']))) {
    // Get the IDs of the selected orders
    if (!empty($_POST['selectedOrders'])) {
        $selectedOrders = implode(',', $_POST['selectedOrders']);

        // Update the order status based on the button clicked
        if (isset($_POST['cookingButton'])) {
            $newStatus = 'Cooking';
        } else {
            // Delete the selected orders
            $deleteSql = "DELETE FROM pos WHERE id IN ($selectedOrders)";
            if ($conn->query($deleteSql) === TRUE) {
                $modalMessage = "Orders deleted successfully";
                echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var modal = new bootstrap.Modal(document.getElementById('orderSuccessModal'));
                            modal.show();
                        });
                    </script>";
            } else {
                $modalMessage = "Error deleting orders: " . $conn->error;
                echo "<script>alert('$modalMessage');</script>";
            }
        }

        // Update the order status for the selected orders
        if (isset($newStatus)) {
            $updateSql = "UPDATE pos SET orderstatus = '$newStatus' WHERE id IN ($selectedOrders)";
            if ($conn->query($updateSql) === TRUE) {
                $modalMessage = "Orders updated successfully";
                echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var modal = new bootstrap.Modal(document.getElementById('orderSuccessModal'));
                            modal.show();
                        });
                    </script>";
            } else {
                $modalMessage = "Error updating orders: " . $conn->error;
                echo "<script>alert('$modalMessage');</script>";
            }
        }
    }
}


$sql = "SELECT id, customer_tag, pizzaname, price, quantity, orderstatus FROM pos WHERE user = '$username' AND orderstatus NOT IN ('Cooking', 'Finish Process')";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Panel</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .Pending-text {
            background-color: grey; /* Yellow background */
            color: white; /* Text color */
            padding: 2px 5px; /* Optional: Add padding to the highlighted text */
            border-radius: 3px; /* Optional: Add rounded corners to the highlighted text */
        }
        table th,tr,td{
            text-align:center;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="posinterface.php">Employee Panel</a>
        <div class="d-flex">
            <a class="btn btn-light me-2" href="posinterface.php">Go Back</a>
        </div>
    </div>
</nav>

<div class="container mt-3">
  <h2>Order Management</h2>
  <div class="container">
    <div class="table-responsive">
      <form method="post" action="">
      <table class="table table-bordered">
        <thead class="table-dark">
          <tr>
            <th>Checkbox</th>
            <th>Customer Tag</th>
            <th>Pizza Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Order Status</th>
          </tr>
        </thead>
        <tbody>
        <?php
        while ($row = $result->fetch_assoc()) {
            $statusText = $row['orderstatus'];
            $statusClass = '';

            if ($row['orderstatus'] == 'Pending') {
                $statusClass = 'Pending-text'; // Set the class for styling
            }

            echo "<tr>
            <td><input type='checkbox' name='selectedOrders[]' value='{$row['id']}'></td>
            <td>{$row['customer_tag']}</td>
            <td>{$row['pizzaname']}</td>
            <td>{$row['price']}</td>
            <td>{$row['quantity']}</td>
            <td><span class='$statusClass'>$statusText</span></td>
            </tr>";
        }
        ?>
        </tbody>
      </table>
      <button type="submit" name="cookingButton" class="btn btn-primary">Cooking</button> <!-- Cooking button -->
      <button type="submit" name="cancelButton" class="btn btn-danger">Cancel</button> <!-- Cancel button -->
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="orderSuccessModal" tabindex="-1" aria-labelledby="orderSuccessModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderSuccessModalLabel">Success</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php echo $modalMessage ?? ''; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
