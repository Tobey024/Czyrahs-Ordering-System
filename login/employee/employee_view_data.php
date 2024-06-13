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

$sql = "SELECT id, customer_tag, pizzaname, price, quantity, orderstatus, user FROM pos WHERE user = '$username'";
$result = $conn->query($sql);


// Fetch data from the pos table
$rows = array();
while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
}

// Encode the data as JSON
$data = json_encode($rows);

// Pass the JSON data to JavaScript
echo "<script>var pizzaData = $data;</script>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .finish-text {
            background-color: #198754; /* Green background for 'Finish Process' */
            color: white; /* Text color */
            padding: 2px 5px; /* Optional: Add padding to the highlighted text */
            border-radius: 3px; /* Optional: Add rounded corners to the highlighted text */
        }
        .cooking-text {
            background-color: #ffc107; /* Yellow background for 'Cooking' */
            color: black; /* Text color */
            padding: 2px 5px; /* Optional: Add padding to the highlighted text */
            border-radius: 3px; /* Optional: Add rounded corners to the highlighted text */
        }
        .pending-text {
            background-color: #6c757d; /* Grey background for 'Pending' */
            color: white; /* Text color */
            padding: 2px 5px; /* Optional: Add padding to the highlighted text */
            border-radius: 3px; /* Optional: Add rounded corners to the highlighted text */
        }
        table th,tr,td{
            text-align:center;
        }

        /* Loader styles */
.loader-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .spinner {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            border: 5px solid #f3f3f3;
            border-top: 5px solid black;
            animation: spin 1s linear infinite;
            position: relative;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .loading-text {
            font-family:monospace;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: black;
            font-size: 24px;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="loader-container">
        <div class="loading-text">Employee...</div>
        <div class="spinner"></div>
    </div>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="employeeinterface.php">Employee Panel</a>
        <div class="d-flex">
            <a class="btn btn-light me-2" href="employeeinterface.php">Go Back</a>
        </div>
    </div>
</nav>

<div class="container mt-3">
  <h2>All Orders.</h2>
  <div class="container">
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead class="table-dark">
          <tr>
            <th>Order Taker</th>
            <th>Customer Tag</th>
            <th>Pizza Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Order Status</th>
          </tr>
        </thead>
        <tbody>
<?php
foreach ($rows as $row) {
    $statusText = $row['orderstatus'];
    $statusClass = '';

    if ($row['orderstatus'] == 'Finish Process') {
        $statusClass = 'finish-text'; // Set the class for 'Finish Process'
    } elseif ($row['orderstatus'] == 'Cooking') {
        $statusClass = 'cooking-text'; // Set the class for 'Cooking'
    } elseif ($row['orderstatus'] == 'Pending') {
        $statusClass = 'pending-text'; // Set the class for 'Pending'
    }

    echo "<tr>
        <td>{$row['user']}</td>
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
<center>
<!-- Add this modal markup at the end of your employeeinterface.php file -->
<div class="modal fade" id="resetShiftModal" tabindex="-1" aria-labelledby="resetShiftModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resetShiftModalLabel">Reset Shift</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to reset your shift? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <form action="reset_shift.php" method="post">
                    <button type="submit" class="btn btn-danger">Reset Shift</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Add this line before your script that uses $ -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Update the button in your employeeinterface.php file to open the modal -->
<button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#resetShiftModal"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 30" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;"><path d="M13 3h4v2h-4zM3 8h4v2H3zm0 8h4v2H3zm-1-4h3.99v2H2zm19.707-5.293-1.414-1.414L18.586 7A6.937 6.937 0 0 0 15 6c-3.859 0-7 3.141-7 7s3.141 7 7 7 7-3.141 7-7a6.968 6.968 0 0 0-1.855-4.73l1.562-1.563zM16 14h-2V8.958h2V14z"></path></svg>Reset Shift</button>

<button type="button" class="btn btn-success" id="printButton"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 30" style="fill: white;transform: ;msFilter:;"><path d="M21 11h-3V4a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v14c0 1.654 1.346 3 3 3h14c1.654 0 3-1.346 3-3v-6a1 1 0 0 0-1-1zM5 19a1 1 0 0 1-1-1V5h12v13c0 .351.061.688.171 1H5zm15-1a1 1 0 0 1-2 0v-5h2v5z"></path><path d="M6 7h8v2H6zm0 4h8v2H6zm5 4h3v2h-3z"></path></svg>Print Earnings</button>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    window.addEventListener('load', function() {
            const spinner = document.querySelector('.spinner');
            const loadingText = document.querySelector('.loading-text');
            setTimeout(() => {
                let opacity = 1;
                let fadeOutInterval = setInterval(() => {
                    opacity -= 0.1;
                    spinner.style.opacity = opacity;
                    loadingText.style.opacity = opacity;
                    if (opacity <= 0) {
                        clearInterval(fadeOutInterval);
                        document.querySelector('.loader-container').style.display = 'none';
                    }
                }, 50);
            }, 500);
        });
// Print Earnings button click handler
$('#printButton').click(function() {
    // Create an object to store aggregated data
    var aggregatedData = {};

    // Iterate over the pizza data and aggregate quantities and earnings
    pizzaData.forEach(function(row) {
        if (!aggregatedData[row.pizzaname]) {
            aggregatedData[row.pizzaname] = {
                quantity: 0,
                earnings: 0
            };
        }
        aggregatedData[row.pizzaname].quantity += parseInt(row.quantity);
        aggregatedData[row.pizzaname].earnings += parseFloat(row.price) * parseInt(row.quantity);
    });

    // Build the content to be printed
    var now = new Date();
    var dateTime = now.toLocaleString();
    var content = '<div style="text-align: center;">' +
                  '<h3 style="margin: 0;">Czyrahs Pizza</h3>' +
                  '<h4 style="margin: 0;">Marcelo H. Del Pilar St, Malabon</h4>' +
                  '<p style="margin: 0;">Contact: 09127008504</p>' +
                  '<p style="margin: 0;">-------------------------------</p>' +
                  '<h4 style="margin: 0;">Official Earning</h4>' +
                  '<p style="margin: 0;">-------------------------------</p>' +
                  '<table style="width: 50%; font-size: 12px; border-collapse: collapse; border: 1px solid #000; text-align: center; margin: 0 auto;">' + // Adjusted width and font size
                  '<thead>' +
                  '<tr>' +
                  '<th style="padding: 5px; background-color: #f2f2f2; border: 1px solid #000;">Pizza Name</th>' +
                  '<th style="padding: 5px; background-color: #f2f2f2; border: 1px solid #000;">Quantity</th>' +
                  '<th style="padding: 5px; background-color: #f2f2f2; border: 1px solid #000;">Price</th>' +
                  '</tr>' +
                  '</thead>' +
                  '<tbody>';

    // Iterate over the aggregated data and add it to the content
    Object.keys(aggregatedData).forEach(function(pizzaName) {
        content += '<tr>' +
                   '<td style="padding: 5px; border: 1px solid #000;">' + pizzaName + '</td>' +
                   '<td style="padding: 5px; border: 1px solid #000;">' + aggregatedData[pizzaName].quantity + '</td>' +
                   '<td style="padding: 5px; border: 1px solid #000;">₱' + aggregatedData[pizzaName].earnings.toFixed(2) + '</td>' +
                   '</tr>';
    });

    content += '</tbody>' +
               '</table>';

    // Calculate total price
    var totalPrice = Object.keys(aggregatedData).reduce(function(total, pizzaName) {
        return total + aggregatedData[pizzaName].earnings;
    }, 0);

    // Add Total Price to the content
    content += '<p style="margin: 0;"><strong>Total Earning:</strong> ₱' + totalPrice.toFixed(2) + '</p>';

    content += '<p style="margin: 0;">' + dateTime + '</p><br><br><br><br>' + // Display the date and time
               '<p style="margin: 0; text-decoration: overline;">Full Name w/Signature</p>' + 
               '</div>';

    // Open the print dialog tab
    var printWindow = window.open('', '_blank');
    printWindow.document.write(content);
    printWindow.document.close();

    // Trigger the print dialog after setting up the event listener
    setTimeout(function() {
        printWindow.print();
        
        // Close the print dialog tab after 5 seconds
        setTimeout(function() {
            printWindow.close();
        }, 5000);
    }, 100);
});
</script>
                    
</body>
</html>
