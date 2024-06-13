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
        JOIN accounts acc ON oh.Username = acc.username
        WHERE oh.rider = '$username' AND oh.OrderStatus != 'Finish Process'";
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
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
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
<div class="table-responsive text-center">
<table class="table table-bordered table">
    <thead class="table-dark">
        <tr>
            <th>Username</th>
            <th>Pizza</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($row = $result->fetch_assoc()) {
            $statusText = $row['OrderStatus'];
            $disableDelete = '';

            if ($row['OrderStatus'] == 'Finish Process' || $row['OrderStatus'] == 'On Process' || $row['OrderStatus'] == 'Delivering' || $row['OrderStatus'] == 'Preparing Order') {
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

            echo "<tr>
            <td>{$row['Username']}</td>
            <td>{$row['PizzaName']}</td>
            <td>{$statusText}</td>

            <td>
            <div style='display: flex; flex-direction: row; justify-content: center; gap: 10px;'>
        <button class='btn btn-primary' onclick='openEditModal(\"{$row['id']}\", \"{$row['OrderStatus']}\", \"{$row['Username']}\", \"{$row['PizzaName']}\", \"{$row['Price']}\", \"{$row['Quantity']}\", \"{$row['TotalPrice']}\", \"{$row['OrderLocator']}\")'><svg xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" style=\"fill: white;transform: ;msFilter:;\">
        <path d=\"M12 9a3.02 3.02 0 0 0-3 3c0 1.642 1.358 3 3 3 1.641 0 3-1.358 3-3 0-1.641-1.359-3-3-3z\"></path>
        <path d=\"M12 5c-7.633 0-9.927 6.617-9.948 6.684L1.946 12l.105.316C2.073 12.383 4.367 19 12 19s9.927-6.617 9.948-6.684l.106-.316-.105-.316C21.927 11.617 19.633 5 12 5zm0 12c-5.351 0-7.424-3.846-7.926-5C4.578 10.842 6.652 7 12 7c5.351 0 7.424 3.846 7.926 5-.504 1.158-2.578 5-7.926 5z\"></path>
        </svg>View</button>
        <button class='btn btn-danger' onclick='cancelOrder(\"{$row['OrderLocator']}\")' {$disableDelete}><svg xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 2 24 24\" style=\"fill: white;transform: ;msFilter:;\">
        <path d=\"M9.172 16.242 12 13.414l2.828 2.828 1.414-1.414L13.414 12l2.828-2.828-1.414-1.414L12 10.586 9.172 7.758 7.758 9.172 10.586 12l-2.828 2.828z\"></path>
        <path d=\"M12 22c5.514 0 10-4.486 10-10S17.514 2 12 2 2 6.486 2 12s4.486 10 10 10zm0-18c4.411 0 8 3.589 8 8s-3.589 8-8 8-8-3.589-8-8 3.589-8 8-8z\"></path>
    </svg>Cancel</button>
    </div>
            </td>
          </tr>";
        }
        ?>
        </tbody>
    </table>
</div>
    </div>
<!-- Edit Order Status Modal -->
<div class="modal fade" id="editOrderModal" tabindex="-1" aria-labelledby="editOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editOrderModalLabel">Edit Order Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editOrderForm">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="pizzaName" class="form-label">Pizza Name</label>
                        <input type="text" class="form-control" id="pizzaName" name="pizzaName" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="text" class="form-control" id="price" name="price" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="text" class="form-control" id="quantity" name="quantity" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="totalPrice" class="form-label">Total Price</label>
                        <input type="text" class="form-control" id="totalPrice" name="totalPrice" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="orderLocator" class="form-label">Order Locator</label>
                        <input type="text" class="form-control" id="orderLocator" name="orderLocator" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="orderStatus" class="form-label">Order Status</label>
                        <select class="form-select" id="orderStatus" name="orderStatus">
                            <option value="Accepted Order">Accepted Order</option>
                            <option value="Preparing Order">Preparing Order</option>
                            <option value="Delivering">Delivering</option>
                            <option value="Finish Process">Finish Process</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="contact" class="form-label">Contact</label>
                        <input type="text" class="form-control" id="contact" name="contact" readonly>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveChangesBtn" onclick="saveChanges()">Save Changes</button>
            </div>
        </div>
    </div>
</div>



<!-- Cancel Order Modal -->
<div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelOrderModalLabel">Cancel Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to Cancel Order of <span id="cancelOrderLocator"></span>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <button type="button" class="btn btn-danger" id="confirmCancelOrder">Yes, Cancel Order</button>
            </div>
        </div>
    </div>
</div>


<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Success</h5>
            </div>
            <div class="modal-body">
                Record updated successfully.
            </div>
        </div>
    </div>
</div>


<!-- Cancelled Order Modal -->
<div class="modal fade" id="cancelledOrderModal" tabindex="-1" aria-labelledby="cancelledOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelledOrderModalLabel">Order Cancelled</h5>
            </div>
            <div class="modal-body">
                <p>Order has been cancelled successfully.</p>
            </div>
        </div>
    </div>
</div>




<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Your custom JavaScript -->
<!-- Your custom JavaScript -->
<script>
function openEditModal(id, orderStatus, username, pizzaName, price, quantity, totalPrice, orderLocator) {
    var modal = new bootstrap.Modal(document.getElementById('editOrderModal'), {
        keyboard: false
    });

    document.getElementById('orderStatus').value = orderStatus;
    document.getElementById('username').value = username;
    document.getElementById('pizzaName').value = pizzaName;
    document.getElementById('price').value = price;
    document.getElementById('quantity').value = quantity;
    document.getElementById('totalPrice').value = totalPrice;
    document.getElementById('orderLocator').value = orderLocator;

    // Fetch the address and contact using an AJAX request
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var response = JSON.parse(xhr.responseText);
            document.getElementById('address').value = response.address;
            document.getElementById('contact').value = response.contact;
        }
    };
    xhr.open("GET", "get_user_info.php?username=" + username, true);
    xhr.send();

    document.getElementById('saveChangesBtn').setAttribute('data-id', id);
    modal.show();
}



    document.getElementById('saveChangesBtn').addEventListener('click', function() {
        var orderId = this.getAttribute('data-id');
        var newStatus = document.getElementById('orderStatus').value;

        // Use AJAX or form submission to update the order status in the database
        // Here, we're just logging the values for demonstration purposes
        console.log("Updating order ID: " + orderId + " to status: " + newStatus);

        // Close the modal
        var modal = bootstrap.Modal.getInstance(document.getElementById('editOrderModal'));
        modal.hide();
    });

    function saveChanges() {
        var orderId = document.getElementById('saveChangesBtn').getAttribute('data-id');
        var newStatus = document.getElementById('orderStatus').value;

        // AJAX request
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (this.readyState == 4) {
                if (this.status == 200) {
                    console.log("Updated order ID: " + orderId + " to status: " + newStatus);
                    // Show success modal
                    var successModal = new bootstrap.Modal(document.getElementById('successModal'));
                    successModal.show();

                    // Reload the page after a delay
                    setTimeout(function() {
                        location.reload();
                    }, 1500); // Reload after 1.5 seconds
                } else {
                    console.error("Error updating record: " + this.responseText);
                    // Optionally, you can display an error message or perform other actions
                }
            }
        };
        xhr.open("POST", "update_order_status.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("orderId=" + orderId + "&newStatus=" + newStatus);
    }

    function cancelOrder(orderLocator) {
        var modal = new bootstrap.Modal(document.getElementById('cancelOrderModal'), {
            keyboard: false
        });
        document.getElementById('cancelOrderLocator').innerText = orderLocator;
        modal.show();
    }

    document.getElementById('confirmCancelOrder').addEventListener('click', function() {
    var orderLocator = document.getElementById('cancelOrderLocator').innerText;
    console.log("Cancelled order with Order Locator: " + orderLocator);

    // Send an AJAX request to cancel_order.php to delete the order
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4) {
            if (this.status == 200) {
                var response = JSON.parse(this.responseText);
                if (response.message === "Order cancelled successfully") {
                    console.log("Order cancelled successfully");
                    // Close the modal
                    var modal = bootstrap.Modal.getInstance(document.getElementById('cancelOrderModal'));
                    modal.hide();

                    // Show the "Order Cancelled Successfully" modal
                    var cancelledOrderModal = new bootstrap.Modal(document.getElementById('cancelledOrderModal'));
                    cancelledOrderModal.show();
                } else {
                    console.error(response.error);
                    // Handle the error
                }
            } else {
                console.error("Error cancelling order: " + this.responseText);
                // Handle the error
            }
        }
    };
    xhr.open("POST", "cancel_order.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("orderLocator=" + orderLocator);
});
document.getElementById('cancelledOrderModal').addEventListener('hidden.bs.modal', function () {
    location.reload();
});

</script>

</body>
</html>
