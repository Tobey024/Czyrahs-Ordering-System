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

// Fetch data from orderhandler table
$sql = "SELECT * FROM orderhandler";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="icon" type="image/png" href="pizzatitle.png">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom styles for status colors */
        .on-checking-text {
            background-color: grey; /* Yellow background */
            color: white; /* Text color */
            padding: 2px 5px; /* Optional: Add padding to the highlighted text */
            border-radius: 3px; /* Optional: Add rounded corners to the highlighted text */
        }
        .accepted-order-text {
            background-color: #ffc107; /* Blue background */
            color: black; /* Text color */
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
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin Panel</a>
            <div class="d-flex">
                <a class="btn btn-light me-2" href="admndb.php">Go Back</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
    <div class="table-responsive">
        <?php if ($result->num_rows > 0): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Pizza Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Order Locator</th>
                        <th>Order Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row["username"]; ?></td>
                            <td><?php echo $row["pizzaname"]; ?></td>
                            <td><?php echo $row["price"]; ?></td>
                            <td><?php echo $row["quantity"]; ?></td>
                            <td><?php echo $row["totalprice"]; ?></td>
                            <td><?php echo $row["orderlocator"]; ?></td>
                            <td><?php 
                                $statusText = $row["orderstatus"];
                                switch ($statusText) {
                                    case 'On Checking':
                                        $statusText = "<span class='on-checking-text'>{$statusText}</span>";
                                        break;
                                    case 'Accepted Order':
                                        $statusText = "<span class='accepted-order-text'>{$statusText}</span>";
                                        break;
                                    case 'Preparing Order':
                                        $statusText = "<span class='preparing-order-text'>{$statusText}</span>";
                                        break;
                                    case 'Delivering':
                                        $statusText = "<span class='delivering-text'>{$statusText}</span>";
                                        break;
                                    case 'Finish Process':
                                        $statusText = "<span style='background-color: green; color: white; padding: 2px 5px; border-radius: 3px;'>{$statusText}</span>";
                                        break;
                                    default:
                                        break;
                                }
                                echo $statusText;
                            ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No data found</p>
        <?php endif; ?>
    </div>
</div>


    <!-- Bootstrap Bundle with Popper -->
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

<?php
// Close connection
$conn->close();
?>
