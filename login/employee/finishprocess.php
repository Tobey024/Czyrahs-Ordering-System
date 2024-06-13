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

$sql = "SELECT id, customer_tag, pizzaname, price, quantity, orderstatus FROM pos WHERE user = '$username' AND orderstatus = 'Finish Process'";
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
        .finish-text {
            background-color: #198754; /* Yellow background */
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
  <h2>Finished Order.</h2>
  <div class="container">
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead class="table-dark">
          <tr>
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

            if ($row['orderstatus'] == 'Finish Process') {
                $statusClass = 'finish-text'; // Set the class for styling
            }

            echo "<tr>
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
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>document.addEventListener('DOMContentLoaded', () => {
  var disclaimer =  document.querySelector("img[alt='www.000webhost.com']");
   if(disclaimer){
       disclaimer.remove();
   }  
 });
</script>
</body>
</html>
