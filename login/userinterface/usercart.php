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

// Use a prepared statement to prevent SQL injection
$sql = "SELECT PizzaName, Price, OrderLocator FROM cart WHERE Username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$orderLimit = 10;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Czyrah's Pizza - Food Website Template</title>
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
    display: flex;
    align-items: center;
    justify-content: center;
}

.quantity-controls {
    display: flex;
    align-items: center;
    justify-content: center;
}

.quantity-controls button {
    flex: 0 0 auto;
}

        #total-price-container {
            background-color: white;
            color: black;
            padding: 10px;
            margin-top: 10px;
        }
        .total-order-price {
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
        <div class="loading-text">Picking Up!</div>
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
                    <a href="usercart.php" class="nav-item nav-link active">Cart</a>
                    <a href="userordering.php" class="nav-item nav-link">Orders</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Profile</a>
                        <div class="dropdown-menu">
                            <a href="userprofile.php" class="dropdown-item">Setting</a>
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
                    <h2>Cart</h2>
                </div>
                <div class="col-12">
                    <a href="menu.php">Menu</a>
                    <a href="userordering.php">Orders</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Food Start -->
<div class="container mt-5">
        <?php if ($result->num_rows === 0) : ?>
            <p><center>No Items Yet</center></p>
        <?php else : ?>
            <div class="table-responsive">
            <table class="table table-striped table-bordered table-sm">
                <thead>
                    <tr>
                        <th><center>Pizza</th>
                        <th><center>Price</th>
                        <th><center>Quantity</th>
                        <th><center>Total</th>
                        <th><center>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
    // Set the order limit
    $orderLimit = 10;

    while ($row = $result->fetch_assoc()) {
        $orderLocator = $row['OrderLocator'];
        echo "<tr data-order-locator='{$orderLocator}'>
            <td><center>{$row['PizzaName']}</td>
            <td class='price'><center>{$row['Price']}</td>
            <td class='quantity-input'>
                <!-- Button for decrementing quantity -->
                <button type='button' class='btn btn-primary' onclick='decrement(this);'>-</button>
                
                <!-- Span element to display the quantity -->
                <span class='form-control text-center quantity' style='display: inline-block; width: 50px;'>1</span>
                
                <!-- Button for incrementing quantity -->
                <button type='button' class='btn btn-primary' onclick='increment(this);'>+</button>
                
                <td class='total-order-price'>₱0.00</td>
                <div id='error-message-{$orderLocator}' style='color: red;'><br></div>
            </td>

            <td><center><button class='btn btn-danger btn-delete' onclick='confirmDelete(\"{$orderLocator}\")'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 2 24 24' style='fill: white;transform: ;msFilter:;'><path d='M16 2H8C4.691 2 2 4.691 2 8v13a1 1 0 0 0 1 1h13c3.309 0 6-2.691 6-6V8c0-3.309-2.691-6-6-6zm.706 13.293-1.414 1.414L12 13.415l-3.292 3.292-1.414-1.414 3.292-3.292-3.292-3.292 1.414-1.414L12 10.587l3.292-3.292 1.414 1.414-3.292 3.292 3.292 3.292z'></path></svg><span> Delete </span></button></td>
        </tr>";
    }
?>

                </tbody>
                <div id='error-message-{$orderLocator}' style='color: red;'></div>
            </table>
            <!-- Total Price Row -->
            <div id="total-price-container">
                <strong>Total Price: ₱<span id="total-price">0.00</span></strong>
            </div>

            <!-- Place Order Button -->
            <button class="btn btn-success place-order-btn" onclick="placeOrder()"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: white;transform: ;msFilter:;"><path d="M12 15c-1.84 0-2-.86-2-1H8c0 .92.66 2.55 3 2.92V18h2v-1.08c2-.34 3-1.63 3-2.92 0-1.12-.52-3-4-3-2 0-2-.63-2-1s.7-1 2-1 1.39.64 1.4 1h2A3 3 0 0 0 13 7.12V6h-2v1.09C9 7.42 8 8.71 8 10c0 1.12.52 3 4 3 2 0 2 .68 2 1s-.62 1-2 1z"></path><path d="M5 2H2v2h2v17a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V4h2V2H5zm13 18H6V4h12z"></path></svg>Place Order</button>
        <?php endif; ?>
    </div>
</div>




<!-- Modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Delete</h5>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this item?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>


<!-- Place Order Modal -->
<div class="modal fade" id="placeOrderModal" tabindex="-1" aria-labelledby="placeOrderModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="placeOrderModalLabel">Placing Order</h5>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to place this order?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="confirmPlaceOrderBtn">Place Order</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- Order Limit Exceeded Modal -->
<div class="modal fade" id="orderLimitModal" tabindex="-1" aria-labelledby="orderLimitModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderLimitModalLabel">Order Limit Exceeded</h5>
            </div>
            <div class="modal-body">
                <p>Sorry, you have reached the maximum order limit.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for order processed message -->
<div class="modal fade" id="orderProcessedModal" tabindex="-1" aria-labelledby="orderProcessedModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderProcessedModalLabel">Order Processed</h5>
            </div>
            <div class="modal-body">
                <p>Thanks for ordering!</p>
            </div>
        </div>
    </div>
</div>


<!-- Modal for ongoing order message -->
<div class="modal fade" id="ongoingOrderModal" tabindex="-1" aria-labelledby="ongoingOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ongoingOrderModalLabel">Ongoing Order</h5>
            </div>
            <div class="modal-body">
                <p>Sorry, you have an ongoing order. You need to wait.</p>
            </div>
        </div>
    </div>
</div>


<!-- Empty Cart Modal -->
<div class="modal fade" id="emptyCartModal" tabindex="-1" aria-labelledby="emptyCartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="emptyCartModalLabel">Empty Cart</h5>
            </div>
            <div class="modal-body">
                <p>Your cart is empty. Please add items to your cart before placing an order.</p>
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


    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <!-- Bootstrap JS Bundle (Popper.js included) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Custom JavaScript for quantity input and delete confirmation -->
<script>
var orderLimit = <?php echo $orderLimit; ?>;

function increment(btn) {
    var input = $(btn).siblings('.quantity');
    var value = parseInt(input.text(), 10);
    if (value < orderLimit) {
        input.text(value + 1);
    } else {
        $('#orderLimitModal').modal('show'); // Display the order limit exceeded modal
    }
    updateTotalPrice();
    updateTotalOrderPrice(); // Update Total Order Price
}

function decrement(btn) {
    var input = $(btn).siblings('.quantity');
    var value = parseInt(input.text(), 10);
    if (value > 1) {
        input.text(value - 1);
        clearErrorMessage('error-message-' + getOrderLocator(btn));
    }
    updateTotalPrice();
    updateTotalOrderPrice(); // Update Total Order Price
}

function updateTotalOrderPrice() {
    $('tbody tr').each(function () {
        var price = parseFloat($(this).find('.price').text().trim().replace('₱', ''));
        var quantity = parseInt($(this).find('.quantity').text(), 10);
        var totalOrderPrice = price * quantity;
        $(this).find('.total-order-price').text('₱'+ totalOrderPrice.toFixed(2));
    });
}

function updateTotalPrice() {
    var totalPrice = 0;
    var isOrderExceeded = false;

    $('tbody tr').each(function () {
        var orderLocator = $(this).data('order-locator');
        var priceText = $(this).find('.price').text().trim();
        var quantity = parseInt($(this).find('.quantity').text(), 10); // Use text() instead of val()

        // Use parseFloat to handle decimal prices
        var price = parseFloat(priceText.replace(/[^0-9.]/g, '')); // Remove non-numeric characters

        if (!isNaN(price) && !isNaN(quantity)) {
            if (quantity > orderLimit) {
                isOrderExceeded = true;
            } else {
                totalPrice += price * quantity; // Multiply price by quantity for each item
            }
        }
    });

    $('#total-price').html('<strong>' + totalPrice.toFixed(2) + '</strong>');

    // Display error message if order limit is exceeded
    if (isOrderExceeded) {
        if (!$('#order-exceed-message').length) {
            console.log('One or more orders exceed the limit.');
        }
    } else {
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

    // Update the confirmDelete function to show the modal
function confirmDelete(orderLocator) {
    $('#deleteConfirmationModal').modal('show');

    // Handle delete operation when the user confirms
    $('#confirmDeleteBtn').on('click', function() {
        $.ajax({
            type: "POST",
            url: "delete_item.php",
            data: { orderLocator: orderLocator },
            success: function () {
                // Remove the table row for the deleted item
                $('tr[data-order-locator="' + orderLocator + '"]').remove();
                updateTotalPrice();

            },
            error: function () {
                alert('Error deleting item.');
            }
        });

        // Close the modal after handling the delete operation
        $('#deleteConfirmationModal').modal('hide');
    });
}


function placeOrder() {
    var totalPrice = 0;
    var quantities = {};

    $('tbody tr').each(function () {
        var orderLocator = $(this).data('order-locator');
        var quantity = parseInt($(this).find('.quantity').text(), 10);

        if (!isNaN(quantity) && quantity > 0) {
            var price = parseFloat($(this).find('.price').text().trim().replace('₱', ''));
            if (quantity <= orderLimit) {
                totalPrice += price * quantity;
                quantities[orderLocator] = {
                    quantity: quantity,
                    pizzaName: $(this).find('td:first-child').text().trim()
                };
            }
        }
    });

    if (totalPrice === 0) {
        // Display a modal indicating that the cart is empty
        $('#emptyCartModal').modal('show');
        return;
    }

    // Display the confirmation modal
    $('#placeOrderModal').modal('show');

    // Handle place order when the user confirms
    $('#confirmPlaceOrderBtn').off('click').on('click', function() {
        $.ajax({
            type: "POST",
            url: "place_order.php",
            data: { totalPrice: totalPrice, quantities: JSON.stringify(quantities) },
            success: function (response) {
                if (response === 'success') {
                    // Show the order processed modal
                    $('#orderProcessedModal').modal('show');
                } else {
                    // Show the ongoing order modal
                    $('#ongoingOrderModal').modal('show');
                }
            },
            error: function (error) {
                console.log(error); // Log any errors
            }
        });

        // Close the modal after handling the place order operation
        $('#placeOrderModal').modal('hide');
    });
}



    // Get order locator from the button's parent tr element
    function getOrderLocator(btn) {
        return $(btn).closest('tr').data('order-locator');
    }

    // Initial update of total price and total order price
    updateTotalPrice();
    updateTotalOrderPrice();

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

    $(document).ready(function() {
        // Event listener for quantity input field
        $('.quantity').on('input', function() {
            var value = parseInt($(this).val(), 10);
            if (value <= 0 || isNaN(value)) {
                $(this).val(1); // Change the value to 1 if it's less than or equal to 0 or NaN
                updateTotalOrderPrice(); // Update total order price
                updateTotalPrice(); // Update total price
            } else if (value > orderLimit) {
                $(this).val(orderLimit); // Change the value to orderLimit if it's greater than orderLimit
                updateTotalOrderPrice(); // Update total order price
                updateTotalPrice(); // Update total price
            } else {
                updateTotalOrderPrice(); // Update total order price
                updateTotalPrice(); // Update total price
            }
        });
    });
    $('#orderProcessedModal').on('hidden.bs.modal', function () {
    location.reload();
});
$('#emptyCartModal').on('hidden.bs.modal', function () {
        location.reload(); // Reload the page when the modal is closed
    });
</script>


</body>

</html>