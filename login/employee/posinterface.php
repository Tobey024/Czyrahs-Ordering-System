<?php
session_start(); // Start the session

// Check if the user is not logged in or does not have the 'Employee' type
if (!isset($_SESSION['username']) || $_SESSION['type'] !== 'Employee') {
    // Redirect to the logout page
    header("Location: ../logout.php");
    exit();
}

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

// Check if the user is logged in and set the username
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest'; // Default to 'Guest' if not logged in

// Redirect to login.php if the user is not logged in
if ($username === 'Guest') {
    header("Location: login.php");
    exit;
}

// Query to get the PizzaNames and Prices
$sql = "SELECT PizzaName, Price FROM menu1";
$result = $conn->query($sql);

$pizzaData = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pizzaData[$row['PizzaName']] = $row['Price'];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>P.O.S</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .card {
        margin-top: 1rem;
        padding: 20px;
    }
    
    @media (max-width: 768px) {
        .card {
            padding: 30px; /* Increase padding for smaller screens */
            font-size: 1.2em; /* Increase font size for smaller screens */
            min-width: auto; /* Remove the minimum width for smaller screens */
        }

        /* Keep the original size of the Menu table columns */
        #orderTable th, #orderTable td {
            white-space: nowrap;
        }
        
        /* Keep the action buttons in the same position */
        .btn-group {
            display: inline-flex;
            margin: 0;
        }

        .btn-group .btn {
            margin-right: 5px; /* Adjust margin between buttons if needed */
        }
    }
    
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="employeeinterface.php">P.O.S Panel</a>
        <div class="d-flex">
            <a class="btn btn-light me-2" href="employeeinterface.php">Go Back</a>
        </div>
    </div>
</nav>
<div class="container mt-5">
    <div class="card">
        <h1><center>Order Maker</center></h1>
                <div class="form-group row">
            <label for="customerTag" class="col-sm-3 col-form-label">Customer Tag:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="customerTag" name="customerTag">
            </div>
        </div>
        <div class="form-group row">
    <div class="col-sm-9"></div>
</div>
<div class="table-responsive">
    <table class="table table-bordered" id="orderTable">
        <thead>
            <tr>
                <th>Menu</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="min-width: 200px;">
    <select class="form-control pizza-select">
        <option value="">Select Pizza</option>
        <?php foreach ($pizzaData as $pizzaName => $price): ?>
            <option value="<?php echo $pizzaName; ?>" data-price="<?php echo $price; ?>"><?php echo $pizzaName; ?></option>
        <?php endforeach; ?>
    </select>
</td>

<td style="min-width: 100px;">
    <input type="text" class="form-control price" readonly>
</td>

                <td><input type="number" class="form-control quantity" value="1" min="1"></td>
                <td>
                    <button type="button" class="btn btn-primary duplicate-row">+</button>
                    <button type="button" class="btn btn-danger remove-row" style="display: none;">-</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>



        <div class="form-group row">
            <label for="orderStatus" class="col-sm-3 col-form-label">Order Status:</label>
            <div class="col-sm-9">
                <select id="orderStatus" class="form-control">
                    <option value="Pending">Pending</option>
                    <option value="Cooking">Cooking</option>
                    <option value="Finish Process">Finish Process</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="orderTaker" class="col-sm-3 col-form-label">Order Taker:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="orderTaker" name="orderTaker" value="<?php echo $username; ?>" readonly>
            </div>
        </div>
        <div class="form-group row">
            <label for="totalPrice" class="col-sm-3 col-form-label">Total Price:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="totalPrice" readonly>
            </div>
        </div>
        <div class="form-group row">
    <label for="Balance" class="col-sm-3 col-form-label">Balance:</label>
    <div class="col-sm-9">
        <input type="text" class="form-control" id="Balance" pattern="[0-9]*">
    </div>
</div>

        <div class="form-group row">
            <label for="Change" class="col-sm-3 col-form-label">Change:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="Change" readonly>
            </div>
        </div>
<div class="form-group row">
    <div class="col-sm-9 offset-sm-3">
        <div class="btn-group btn-group-lg" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-success mr-2" id="addButton"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 30" style="fill: white;transform: ;msFilter:;"><path d="M16 2H8C4.691 2 2 4.691 2 8v13a1 1 0 0 0 1 1h13c3.309 0 6-2.691 6-6V8c0-3.309-2.691-6-6-6zm4 14c0 2.206-1.794 4-4 4H4V8c0-2.206 1.794-4 4-4h8c2.206 0 4 1.794 4 4v8z"></path><path d="M13 7h-2v4H7v2h4v4h2v-4h4v-2h-4z"></path></svg>Add Order</button>
            
            <button type="button" class="btn btn-secondary mr-2" id="printButton"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 30" style="fill: white;transform: ;msFilter:;"><path d="M19 7h-1V2H6v5H5c-1.654 0-3 1.346-3 3v7c0 1.103.897 2 2 2h2v3h12v-3h2c1.103 0 2-.897 2-2v-7c0-1.654-1.346-3-3-3zM8 4h8v3H8V4zm8 16H8v-4h8v4zm4-3h-2v-3H6v3H4v-7c0-.551.449-1 1-1h14c.552 0 1 .449 1 1v7z"></path><path d="M14 10h4v2h-4z"></path></svg>Print Order</button>
            
            <button type="button" class="btn btn-info" id="driversReceiptButton"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 30" style="fill: white;transform: ;msFilter:;"><path d="M21 11h-3V4a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v14c0 1.654 1.346 3 3 3h14c1.654 0 3-1.346 3-3v-6a1 1 0 0 0-1-1zM5 19a1 1 0 0 1-1-1V5h12v13c0 .351.061.688.171 1H5zm15-1a1 1 0 0 1-2 0v-5h2v5z"></path><path d="M6 7h8v2H6zm0 4h8v2H6zm5 4h3v2h-3z"></path></svg>Driver's Receipt</button>
        </div>
    </div>
</div>


        
    </div>
</div>

<center>

<h3>Search Order</h3>
<button type="button" class="btn btn-info" onclick="window.location.href = 'pendingorderemp.php';">Pending</button>

<button type="button" class="btn btn-warning" onclick="window.location.href = 'cookingorder.php';">Cooking</button>
<button type="button" class="btn btn-success" onclick="window.location.href = 'finishprocess.php';">Finish Process</button>
<!-- Bootstrap JS and jQuery for handling the selection change -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
    $('#pizzaSelect').change(calculateTotal);
    $('#quantity').change(calculateTotal);
    $('#Balance').change(calculateChange); // Call calculateChange when Balance changes

    function calculateTotal() {
        var total = 0;

        // Iterate over each row in the table body
        $('#orderTable tbody tr').each(function() {
            var price = parseFloat($(this).find('.pizza-select option:selected').data('price'));
            var quantity = parseFloat($(this).find('.quantity').val());

            // Ensure quantity is at least 1
            if (quantity < 1) {
                quantity = 1;
                $(this).find('.quantity').val(quantity); // Update the quantity input in the current row
            }

            var totalPrice = price * quantity;
            $(this).find('.price').val(totalPrice.toFixed(2)); // Update the price input in the current row
            total += totalPrice; // Add the total price of the current row to the total
        });

        $('#totalPrice').val(total.toFixed(2)); // Update the total price input
        calculateChange(); // Recalculate the change
    }

    function calculateChange() {
        var total = parseFloat($('#totalPrice').val());
        var balance = parseFloat($('#Balance').val());

        var change = balance - total;
        $('#Change').val(change.toFixed(2));
    }

    // Trigger calculation when the page loads and when the pizza selection, quantity, or balance changes
    $(document).on('change', '.pizza-select, .quantity, #Balance', calculateTotal);

      // Add Order button click handler
$('#addButton').click(function() {
    var orders = [];

    // Check if the customer tag field is not blank
    var customerTag = $('#customerTag').val().trim(); // Trim the value to remove whitespace

    if (customerTag === '') {
        $('#alertModalBody').text('Customer Tag cannot be blank.');
        $('#alertModal').modal('show');
        return;
    }

    // Check for empty inputs
    var emptyInputs = $('#orderTable tbody tr').filter(function() {
        return $(this).find('.pizza-select').val() === '' || $(this).find('.quantity').val() === '';
    });

    if (emptyInputs.length > 0) {
        $('#alertModalBody').text('Please fill all the inputs in the order table.');
        $('#alertModal').modal('show');
        return;
    }

    // Iterate over each row in the table
    $('#orderTable tbody tr').each(function() {
        var pizzaName = $(this).find('.pizza-select').val();
        var price = $(this).find('.pizza-select option:selected').attr('data-price');
        var quantity = $(this).find('.quantity').val();
        var orderStatus = $('#orderStatus').val();

        // Push the order data to the orders array
        orders.push({
            customerTag: customerTag,
            pizzaName: pizzaName,
            price: price,
            quantity: quantity,
            orderStatus: orderStatus
        });
    });

    // AJAX call to add the orders to the database
    $.ajax({
        url: 'add_order.php',
        type: 'POST',
        data: { orders: orders },
        success: function(response) {
            // Display a modal with the success message
            $('#successModal').modal('show');
        },
        error: function(xhr, status, error) {
            // Handle errors
            console.error(xhr.responseText);
        }
    });
});

        // Duplicate and remove row functionality
        $(document).on('click', '.duplicate-row', function() {
            var newRow = $(this).closest('tr').clone(); // Clone the current row
            newRow.find('select').val(''); // Reset the cloned select element
            newRow.find('.price').val(''); // Reset the price input
            newRow.find('.quantity').val('1'); // Reset the quantity input
            newRow.find('.remove-row').show(); // Show the remove button
            $('#orderTable tbody').append(newRow); // Append the cloned row to the table
            calculateTotal(); // Recalculate total price
        });

        $(document).on('click', '.remove-row', function() {
            $(this).closest('tr').remove(); // Remove the row from the table
            calculateTotal(); // Recalculate total price
        });
        // Reload the page when the success modal is hidden
    $('#successModal').on('hidden.bs.modal', function (e) {
        window.location.reload();
    });
    });
// Print Order button click handler
$('#printButton').click(function() {
    // Check for empty inputs
    var emptyInputs = $('#orderTable tbody tr').filter(function() {
        return $(this).find('.pizza-select').val() === '' || $(this).find('.quantity').val() === '' || $('#Balance').val() === '' || $('#Change').val() === '';
    });

    if (emptyInputs.length > 0) {
        $('#alertModalBody').text('Please fill all the inputs in the order table.');
        $('#alertModal').modal('show');
        return;
    }

    // Get the current date and time
    var now = new Date();
    var dateTime = now.toLocaleString();

    // Build the content to be printed
    var content = '<div style="text-align: center;">' +
                  '<h2 style="margin: 0;">Czyrahs Pizza</h2>' +
                  '<h4 style="margin: 0;">Marcelo H. Del Pilar St, Malabon</h4>' +
                  '<p style="margin: 0;">Contact: 09127008504</p>' +
                  '<p style="margin: 0;">-----------------------------------</p>' +
                  '<h4 style="margin: 0;">Official Receipt</h4>' +
                  '<p style="margin: 0;">-----------------------------------</p>' +
                  '<p style="margin: 0;">Customer: ' + $('#customerTag').val() + '</p>' +
                  '<table style="width: 20%; border-collapse: collapse; border: 1px solid #000; text-align: center; margin: 0 auto;">' +
                  '<thead>' +
                  '<tr>' +
                  '<th style="padding: 8px; background-color: #f2f2f2; border: 1px solid #000;">Menu</th>' +
                  '<th style="padding: 8px; background-color: #f2f2f2; border: 1px solid #000;">Price</th>' +
                  '<th style="padding: 8px; background-color: #f2f2f2; border: 1px solid #000;">Quantity</th>' +
                  '</tr>' +
                  '</thead>' +
                  '<tbody>';

    // Iterate over each row in the table and add it to the content
    $('#orderTable tbody tr').each(function() {
        var menu = $(this).find('.pizza-select option:selected').text();
        var price = $(this).find('.price').val();
        var quantity = $(this).find('.quantity').val();
        content += '<tr>' +
                   '<td style="padding: 8px; border: 1px solid #000;">' + menu + '</td>' +
                   '<td style="padding: 8px; border: 1px solid #000;">₱' + price + '</td>' +
                   '<td style="padding: 8px; border: 1px solid #000;">' + quantity + '</td>' +
                   '</tr>';
    });

    // Add Total Price, Balance, and Change to the table
    var totalPrice = $('#totalPrice').val();
    var balance = $('#Balance').val();
    var change = $('#Change').val();
    content += '<tr>' +
               '<td colspan="3" style="padding: 8px; border: 1px solid #000;"><strong>Total Price:</strong> ₱' + totalPrice + '</td>' +
               '</tr>' +
               '<tr>' +
               '<td colspan="3" style="padding: 8px; border: 1px solid #000;"><strong>Balance:</strong> ₱' + balance + '</td>' +
               '</tr>' +
               '<tr>' +
               '<td colspan="3" style="padding: 8px; border: 1px solid #000;"><strong>Change:</strong> ₱' + change + '</td>' +
               '</tr>';

    content += '</tbody>' +
               '</table>' +
               '<p style="margin: 0;">Order Taker: ' + $('#orderTaker').val() + '</p>' +
               '<p style="margin: 0;">' + dateTime + '</p>' + // Display the date and time
               '<p style="margin: 0;">-----------------------------------</p>' +
               '<h3 style="margin: 0;">Thank you for Choosing Czyrahs!</h3>' +
               '</div>';

// Send the content to printdialog.php using AJAX
$.ajax({
    url: 'printdialog.php',
    type: 'POST',
    data: { content: content },
    success: function(response) {
        // Open the print dialog returned from printdialog.php
        var printWindow = window.open('', '_blank');
        printWindow.document.write(response);
        printWindow.document.close();

        // Print the content directly without showing the print dialog
        printWindow.print();

        // Close the print window and the current window after printing
        setTimeout(function() {
            printWindow.close();
            window.close();
        }, 5000); // 5 seconds timeout
    }
});




});
// Driver's Receipt button click handler
$('#driversReceiptButton').click(function() {
    // Check for empty inputs
    var emptyInputs = $('#orderTable tbody tr').filter(function() {
        return $(this).find('.pizza-select').val() === '' || $(this).find('.quantity').val() === '' || $('#Balance').val() === '' || $('#Change').val() === '';
    });

    if (emptyInputs.length > 0) {
        $('#alertModalBody').text('Please fill all the inputs in the order table.');
        $('#alertModal').modal('show');
        return;
    }

    // Get the current date and time
    var now = new Date();
    var dateTime = now.toLocaleString();

    // Build the content to be printed
    var content = '<div style="text-align: center;">' +
                  '<h2 style="margin: 0;">Czyrahs Pizza</h2>' +
                  '<h4 style="margin: 0;">Marcelo H. Del Pilar St, Malabon</h4>' +
                  '<p style="margin: 0;">Contact: 09127008504</p>' +
                  '<p style="margin: 0;">-----------------------------------</p>' +
                  '<h4 style="margin: 0;">Driver Receipt</h4>' +
                  '<p style="margin: 0;">-----------------------------------</p>' +
                  '<p style="margin: 0;">Customer: ' + $('#customerTag').val() + '</p>' +
                  '<table style="width: 20%; border-collapse: collapse; border: 1px solid #000; text-align: center; margin: 0 auto;">' +
                  '<thead>' +
                  '<tr>' +
                  '<th style="padding: 8px; background-color: #f2f2f2; border: 1px solid #000;">Menu</th>' +
                  '<th style="padding: 8px; background-color: #f2f2f2; border: 1px solid #000;">Price</th>' +
                  '<th style="padding: 8px; background-color: #f2f2f2; border: 1px solid #000;">Quantity</th>' +
                  '</tr>' +
                  '</thead>' +
                  '<tbody>';

    // Iterate over each row in the table and add it to the content
    $('#orderTable tbody tr').each(function() {
        var menu = $(this).find('.pizza-select option:selected').text();
        var price = $(this).find('.price').val();
        var quantity = $(this).find('.quantity').val();
        content += '<tr>' +
                   '<td style="padding: 8px; border: 1px solid #000;">' + menu + '</td>' +
                   '<td style="padding: 8px; border: 1px solid #000;">₱' + price + '</td>' +
                   '<td style="padding: 8px; border: 1px solid #000;">' + quantity + '</td>' +
                   '</tr>';
    });

    // Add Total Price, Balance, Change, and Service Fee to the table
    var totalPrice = parseFloat($('#totalPrice').val());
    var balance = $('#Balance').val();
    var change = $('#Change').val();
    var serviceFee = 40; // Service fee
    totalPrice += serviceFee; // Add service fee to total price
    content += 
               '<tr>' +
               '<td colspan="3" style="padding: 8px; border: 1px solid #000;"><strong>Service Fee:</strong> ₱' + serviceFee + '</td>' +
               '</tr>' +
               '<tr>' +
               '<td colspan="3" style="padding: 8px; border: 1px solid #000;"><strong>Total Price:</strong> ₱' + totalPrice.toFixed(2) + '</td>' +
               '</tr>';

    content += '</tbody>' +
               '</table>' +
               '<p style="margin: 0;">Order Taker: ' + $('#orderTaker').val() + '</p>' +
               '<p style="margin: 0;">' + dateTime + '</p>' + // Display the date and time
               '<p style="margin: 0;">-----------------------------------</p>' +
               '<h3 style="margin: 0;">Thank you for Choosing Czyrahs!</h3>' +
               '</div>';

    // Send the content to printdialog2.php using AJAX
    $.ajax({
        url: 'printdialog2.php',
        type: 'POST',
        data: { content: content },
        success: function(response) {
            // Open the print dialog returned from printdialog2.php
            var printWindow = window.open('', '_blank');
            printWindow.document.write(response);
            printWindow.document.close();

            // Print the content directly without showing the print dialog
            printWindow.print();

            // Close the print window and the current window after printing
            setTimeout(function() {
                printWindow.close();
                window.close();
            }, 5000); // 5 seconds timeout
        },
        error: function(xhr, status, error) {
            // Handle errors
            console.error(xhr.responseText);
        }
    });
});






</script>

<script>document.addEventListener('DOMContentLoaded', () => {
  var disclaimer =  document.querySelector("img[alt='www.000webhost.com']");
   if(disclaimer){
       disclaimer.remove();
   }  
 });
 $(document).ready(function(){
        $('#Balance').on('input', function(){
            $(this).val(function(_, val){
                return val.replace(/\D/g, '');
            });
        });
    });
$(document).ready(function(){
        $('#customerTag').on('input', function(){
            $(this).val(function(_, val){
                return val.replace(/[0-9]/g, '');
            });
        });
    });
</script>

<!-- Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Success!</h5>
            </div>
            <div class="modal-body">
                Order of <span id="customerTagModal"></span> has been successfully saved.
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="refreshPage()">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="alertModalLabel">Alert</h5>
            </div>
            <div class="modal-body" id="alertModalBody">
                <!-- Alert message will be displayed here -->
            </div>

        </div>
    </div>
</div>


</body>
</html>
