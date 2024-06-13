<?php
session_start(); // Start the session

// Check if the user is not logged in or does not have the 'User', 'Admin', or 'Employee' type
if (!isset($_SESSION['username']) || ($_SESSION['type'] != 'User' && $_SESSION['type'] != 'Admin')) {
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

// Selecting data related to the logged-in user
$sql = "SELECT PizzaName, Price, Quantity, TotalPrice, OrderLocator, OrderStatus FROM orderhandler WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

$totalPrice = 0; // Initialize total price variable
$totalPrice += 40; // Add service fee to total price

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Czyrah's Pizza</title>
    <link rel="icon" type="image/png" href="pizzatitle.png">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free Website Template" name="keywords">
    <meta content="Free Website Template" name="description">

    
    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400|Nunito:600,700" rel="stylesheet">

    <!-- CSS Libraries -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/flaticon/font/flaticon.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>
<style>
.navbar {
    position: relative;
    transition: .5s;
    z-index: 999;
}

.navbar.nav-sticky {
    position: fixed;
    top: 0;
    width: 100%;
    box-shadow: 0 2px 5px rgba(0, 0, 0, .3);
}

.navbar .navbar-brand {
    margin: 0;
    color: #fbaf32;
    font-size: 35px;
    line-height: 0px;
    font-weight: 700;
    font-family: 'Nunito', sans-serif;
    transition: .5s;
    
}

.navbar .navbar-brand span {
    color: #719a0a;
}

.navbar .navbar-brand:hover {
    color: #4fd845;
}

.navbar .navbar-brand:hover span {
    color: #4fd845;
}

.navbar .navbar-brand img {
    max-width: 100%;
    max-height: 40px;
}

.navbar .dropdown-menu {
    margin-top: 0;
    border: 0;
    border-radius: 0;
    background: #f8f9fa;
}

@media (min-width: 992px) {
    .navbar {
        position: absolute;
        width: 100%;
        padding: 30px 60px;
        background: transparent !important;
        z-index: 9;
    }
    
    .navbar.nav-sticky {
        padding: 10px 60px;
        background: #ffffff !important;
    }
    
    .navbar .navbar-brand {
        color: #4fd845;
    }
    
    .navbar.nav-sticky .navbar-brand {
        color: #4fd845;
    }

    .navbar-light .navbar-nav .nav-link,
    .navbar-light .navbar-nav .nav-link:focus {
        padding: 10px 10px 8px 10px;
        font-family: 'Nunito', sans-serif;
        color: #ffffff;
        font-size: 18px;
        font-weight: 600;
    }
    
    .navbar-light.nav-sticky .navbar-nav .nav-link,
    .navbar-light.nav-sticky .navbar-nav .nav-link:focus {
        color: #666666;
    }

    .navbar-light .navbar-nav .nav-link:hover,
    .navbar-light .navbar-nav .nav-link.active {
        color: #4fd845;
    }
    
    .navbar-light.nav-sticky .navbar-nav .nav-link:hover,
    .navbar-light.nav-sticky .navbar-nav .nav-link.active {
        color: #4fd845;
    }
}

@media (max-width: 991.98px) {   
    .navbar {
        padding: 15px;
        background: #ffffff !important;
    }
    
    .navbar .navbar-brand {
        color: #4fd845;
    }
    
    .navbar .navbar-nav {
        margin-top: 15px;
    }
    
    .navbar a.nav-link {
        padding: 5px;
    }
    
    .navbar .dropdown-menu {
        box-shadow: none;
    }
}
        .navbar-nav .nav-item .nav-link:hover {
            color: #ffffff; /* Change to your desired hover color */
        }

        .btn-delete {
        background-color: #dc3545;
        border-color: #dc3545;
        }

        .btn-delete:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

        .quantity-input {
            max-width: 50px;
            margin: auto; /* Center the input */
        }

        .quantity-input .btn {
            margin: 0; /* Remove margin on buttons */
        }
        #total-price-container {
            background-color: white;
            color: black;
            padding: 10px;
            margin-top: 10px;
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
        td{
            text-align: center;
        }
        tr{
            text-align: center;
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
            border-top: 5px solid green;
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
<body>
<div class="loader-container">
        <div class="loading-text">Preparing..</div>
        <div class="spinner"></div>
    </div>
    <!-- Nav Bar Start -->
    <div class="navbar navbar-expand-lg bg-light navbar-light">
        <div class="container-fluid">
            <a href="userlandingpage.php" class="navbar-brand">Czyrahs <span>Pizza</span></a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                <div class="navbar-nav ml-auto">
                    <a href="userlandingpage.php" class="nav-item nav-link">Home</a>
                    <a href="menu.php" class="nav-item nav-link">Menu</a>
                    <a href="usercart.php" class="nav-item nav-link">Cart</a>
                    <a href="userordering.php" class="nav-item nav-link active">Orders</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Profile</a>
                        <div class="dropdown-menu">
                            <a href="userprofile.php" class="dropdown-item">Settings</a>
                            <a href="recentorder.php" class="dropdown-item">Recent</a>
                            <a href="feedback.php" class="dropdown-item">Feedback</a>
                            <a href="logout.php" class="dropdown-item">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Nav Bar End -->

    <!-- Page Header Start -->
    <div class="page-header mb-0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2>Orders</h2>
                </div>
                <div class="col-12">
                    <a href="menu.php">Menu</a>
                    <a href="usercart.php">Cart</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Food Start -->
    <br><br>
    <div class="container">
    <div class="table-responsive">
    <table class="table table-striped table-bordered table-sm">
        <thead>
            <tr>
                <th>Pizza</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
                while ($row = $result->fetch_assoc()) {
                    if ($row['OrderStatus'] == 'Finish Process') {
                        continue; // Skip this row if the Order Status is 'Finish Process'
                    }

                    $statusText = $row['OrderStatus'];
                    $disableDelete = '';

                    if ($row['OrderStatus'] == 'Finish Process' || $row['OrderStatus'] == 'On Process' || $row['OrderStatus'] == 'Delivering' || $row['OrderStatus'] == 'Accepted Order' || $row['OrderStatus'] == 'Preparing Order') {
                        $disableDelete = 'disabled'; // Disable the delete button
                    }

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

                    $totalPrice += $row['TotalPrice']; // Accumulate total price

                    echo "<tr>
                    <td>{$row['PizzaName']}</td>
        <td>{$statusText}</td>
        <td style='text-align: center;'>
            <div style='display: flex; flex-direction: row; justify-content: center; gap: 10px;'>
                <button type='button' class='btn btn-info' data-bs-toggle='modal' data-bs-target='#orderModal' onclick='populateModal(\"{$row['PizzaName']}\", {$row['Price']}, {$row['Quantity']}, {$row['TotalPrice']}, \"{$row['OrderLocator']}\")'>
                    <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" style=\"fill: white;transform: ;msFilter:;\">
                        <path d=\"M12 9a3.02 3.02 0 0 0-3 3c0 1.642 1.358 3 3 3 1.641 0 3-1.358 3-3 0-1.641-1.359-3-3-3z\"></path>
                        <path d=\"M12 5c-7.633 0-9.927 6.617-9.948 6.684L1.946 12l.105.316C2.073 12.383 4.367 19 12 19s9.927-6.617 9.948-6.684l.106-.316-.105-.316C21.927 11.617 19.633 5 12 5zm0 12c-5.351 0-7.424-3.846-7.926-5C4.578 10.842 6.652 7 12 7c5.351 0 7.424 3.846 7.926 5-.504 1.158-2.578 5-7.926 5z\"></path>
                    </svg>
                    Info
                </button>
                <button class='btn btn-danger' onclick='cancelOrder(\"{$row['OrderLocator']}\")' {$disableDelete}>
                    <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 2 24 24\" style=\"fill: white;transform: ;msFilter:;\">
                        <path d=\"M9.172 16.242 12 13.414l2.828 2.828 1.414-1.414L13.414 12l2.828-2.828-1.414-1.414L12 10.586 9.172 7.758 7.758 9.172 10.586 12l-2.828 2.828z\"></path>
                        <path d=\"M12 22c5.514 0 10-4.486 10-10S17.514 2 12 2 2 6.486 2 12s4.486 10 10 10zm0-18c4.411 0 8 3.589 8 8s-3.589 8-8 8-8-3.589-8-8 3.589-8 8-8z\"></path>
                    </svg>Cancel
                </button>
            </div>
        </td>
    </tr>";






                }
                ?>
        </tbody>
    </table>
<?php if ($totalPrice > 41): ?>
<div id="total-price-container">
    <strong>Service Fee: ₱40.00</strong><br>
    <strong>Total Price: ₱<?php echo number_format($totalPrice, 2); ?></strong>
</div>
<?php endif; ?>






<!-- Modal markup -->
<div class='modal fade' id='orderModal' tabindex='-1' aria-labelledby='orderModalLabel' aria-hidden='true'>
    <div class='modal-dialog'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h5 class='modal-title' id='orderModalLabel'>Order Details</h5>
                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
            </div>
            <div class='modal-body'>
                <form>
                    <div class='mb-3'>
                        <label for='pizzaName' class='form-label'>Pizza Name</label>
                        <input type='text' class='form-control' id='pizzaName' readonly>
                    </div>
                    <div class='mb-3'>
                        <label for='price' class='form-label'>Price</label>
                        <input type='text' class='form-control' id='price' readonly>
                    </div>
                    <div class='mb-3'>
                        <label for='quantity' class='form-label'>Quantity</label>
                        <input type='text' class='form-control' id='quantity' readonly>
                    </div>
                    <div class='mb-3'>
                        <label for='totalPrice' class='form-label'>Total Price</label>
                        <input type='text' class='form-control' id='totalPrice' readonly>
                    </div>
                    <div class='mb-3'>
                        <label for='orderLocator' class='form-label'>Order Locator</label>
                        <input type='text' class='form-control' id='orderLocator' readonly>
                    </div>
                </form>
            </div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
            </div>
        </div>
    </div>
</div>


            

<!-- Modal -->
<div class="modal fade" id="cancelOrderModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cancel Order</h5>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to cancel this order?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="confirmCancelOrder">Cancel Order</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

            




    <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
    
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <!-- Bootstrap JS Bundle (Popper.js included) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Custom JavaScript for quantity input and delete confirmation -->
<script>
    var orderLimit = 10;

    function increment(btn) {
        var input = $(btn).siblings('.quantity');
        var value = parseInt(input.val(), 10);
        if (value < orderLimit) {
            input.val(value + 1);
        } else {
            displayErrorMessage(input, 'Limited orders only.', 'error-message-' + getOrderLocator(btn));
        }
        updateTotalPrice();
    }

    function decrement(btn) {
        var input = $(btn).siblings('.quantity');
        var value = parseInt(input.val(), 10);
        if (value > 1) {
            input.val(value - 1);
            clearErrorMessage('error-message-' + getOrderLocator(btn));
        }
        updateTotalPrice();
    }

    function updateTotalPrice() {
        var totalPrice = 0;
        var isOrderExceeded = false;

        $('tbody tr').each(function () {
            var orderLocator = $(this).data('order-locator');
            var priceText = $(this).find('.price').text().trim();
            var quantity = parseInt($(this).find('.quantity').val(), 10);

            // Use parseFloat to handle decimal prices
            var price = parseFloat(priceText.replace(/[^0-9.]/g, '')); // Remove non-numeric characters

            if (!isNaN(price) && !isNaN(quantity)) {
                totalPrice += price * quantity;

                if (quantity > orderLimit) {
                    isOrderExceeded = true;
                } else {
                    clearErrorMessage('error-message-' + orderLocator);
                }
            }
        });

        $('#total-price').html('<strong>' + totalPrice.toFixed(2) + '</strong>');

        // Display error message if order limit is exceeded
        if (isOrderExceeded) {
            // Display error message only if it doesn't exist
            if (!$('#order-exceed-message').length) {
                console.log('Not gonna happen.')
            }
        } else {
            // Clear the error message when order limit is not exceeded
            clearErrorMessage('order-exceed-message');
        }
    }

    function clearErrorMessage(id) {
        $('#' + id).remove(); // Clear error message
    }

    function displayErrorMessage(element, message, id) {
        clearErrorMessage(id); // Clear existing error messages with the same ID
        var errorMessage = $('<div id="' + id + '" class="error-message" style="color: red;">' + message + '</div>');
        element.parent().append(errorMessage);
    }

    function confirmDelete(orderLocator) {
    var confirmation = confirm('Are you sure you want to delete?');
    if (confirmation) {
        $.ajax({
            type: "POST",
            url: "cancel_order.php",
            data: { orderLocator: orderLocator },
            success: function (response) {
                response = JSON.parse(response);
                if (response.success) {
                    alert(response.message);
                    // Remove the table row for the deleted item
                    $('tr[data-order-locator="' + orderLocator + '"]').remove();
                    updateTotalPrice();
                } else {
                    alert(response.message);
                }
            },
            error: function (error) {
                console.log(error); // Log any errors
            }
        });
    }
}


    function placeOrder() {
        var isOrderExceeded = false;

        $('tbody tr').each(function () {
            var quantity = parseInt($(this).find('.quantity').val(), 10);

            if (quantity > orderLimit) {
                isOrderExceeded = true;
                // Display error message and prevent placing the order
                displayErrorMessage($(this).find('.quantity'), 'Order exceeds limit.', 'order-exceed-message');
                return false; // Exit the loop early
            }
        });

        if (isOrderExceeded) {
            // Log the error message to the console
            console.log('One or more orders exceed the limit.');
            return;
        }

        // Proceed with placing the order logic
        var totalPrice = parseFloat($('#total-price').text().replace(/[^0-9.]/g, ''));
        var quantities = {};

        $('tbody tr').each(function () {
            var orderLocator = $(this).data('order-locator');
            var quantity = parseInt($(this).find('.quantity').val(), 10);
            var pizzaName = $(this).find('td:first-child').text().trim(); // Get pizza name

            quantities[orderLocator] = {
                quantity: quantity,
                pizzaName: pizzaName
            };
        });

        $.ajax({
            type: "POST",
            url: "place_order.php",
            data: { totalPrice: totalPrice, quantities: JSON.stringify(quantities) },
            success: function (response) {
                alert(response);
                location.reload(); // Refresh the page after placing the order
            },
            error: function (error) {
                console.log(error); // Log any errors
            }
        });
    }

    // Get order locator from the button's parent tr element
    function getOrderLocator(btn) {
        return $(btn).closest('tr').data('order-locator');
    }

    // Initial update of total price
    updateTotalPrice();
    function cancelOrder(orderLocator) {
    // Set the orderLocator to a data attribute of the modal for later use
    $('#cancelOrderModal').attr('data-order-locator', orderLocator);

    // Show the modal
    $('#cancelOrderModal').modal('show');

    // Handle the cancel action
    $('#confirmCancelOrder').on('click', function () {
        var orderLocator = $('#cancelOrderModal').attr('data-order-locator');
        $.ajax({
            type: "POST",
            url: "cancel_order.php",
            data: { orderLocator: orderLocator },
            success: function (response) {
                $('#cancelOrderModal').modal('hide'); // Close the modal

                // Display the success message in a new modal
                var successModal = `
                    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="successModalLabel">Success</h5>
                                    
                                </div>
                                <div class="modal-body">
                                    Order canceled successfully.
                                </div>
                                <div class="modal-footer">
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                $('body').append(successModal); // Append the modal to the body
                $('#successModal').modal('show'); // Show the success modal

                // Reload the page after the success modal is closed
                $('#successModal').on('hidden.bs.modal', function () {
                    location.reload();
                });
            },
            error: function (error) {
                console.log(error); // Log any errors
            }
        });
    });
}


// Calculate total price for each row
$('tbody tr').each(function () {
        var totalPrice = 0;
        $(this).find('td:nth-child(4)').text().split(',').forEach(function (price) {
            totalPrice += parseFloat(price.trim());
        });
        $(this).find('.total-price').text(totalPrice.toFixed(2));
    });



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
    
        function populateModal(pizzaName, price, quantity, totalPrice, orderLocator) {
        document.getElementById('pizzaName').value = pizzaName;
        document.getElementById('price').value = price;
        document.getElementById('quantity').value = quantity;
        document.getElementById('totalPrice').value = totalPrice;
        document.getElementById('orderLocator').value = orderLocator;
    }
</script>

</body>

</html>
