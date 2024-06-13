<?php
session_start(); // Start the session

// Check if the user is not logged in or does not have the 'Admin' type
if (!isset($_SESSION['username']) || ($_SESSION['type'] != 'Admin')) {
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

$sql = "SELECT * FROM orderhandler WHERE rider IS NULL OR rider = ''";
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="riderinterface.php">Rider Panel</a>
        <div class="d-flex">
            <a class="btn btn-light me-2" href="admndb.php">Go Back</a>
        </div>
    </div>
</nav>

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
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['username'] . "</td>";
                        echo "<td>" . $row['pizzaname'] . "</td>";
                        echo "<td>" . $row['orderstatus'] . "</td>";
                        echo "<td><button type='button' class='btn btn-primary viewBtn' data-bs-toggle='modal' data-bs-target='#orderModal' data-username='" . $row['username'] . "' data-pizzaname='" . $row['pizzaname'] . "' data-orderstatus='" . $row['orderstatus'] . "' data-orderlocator='" . $row['orderlocator'] . "' data-quantity='" . $row['quantity'] . "'>View</button>&nbsp;&nbsp;<button type='button' class='btn btn-danger deleteBtn' data-bs-toggle='modal' data-bs-target='#deleteModal' data-username='" . $row['username'] . "' data-pizzaname='" . $row['pizzaname'] . "' data-id='" . $row['id'] . "'>Delete</button></td>";



                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No orders found</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete Order Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this order of <span id="deleteUsername"></span>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderModalLabel">Order Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" readonly>
                </div>
                <div class="mb-3">
                    <label for="pizzaname" class="form-label">Pizza Name</label>
                    <input type="text" class="form-control" id="pizzaname" readonly>
                </div>
                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="text" class="form-control" id="quantity" readonly>
                </div>
                <div class="mb-3">
                    <label for="orderstatus" class="form-label">Order Status</label>
                    <input type="text" class="form-control" id="orderstatus" readonly>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="acceptOrderBtn">Accept Order</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

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
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Order accepted successfully!
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="deleteSuccessModal" tabindex="-1" aria-labelledby="deleteSuccessModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteSuccessModalLabel">Success</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Successfully Deleted the Order
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        var viewButtons = document.querySelectorAll('.viewBtn');
        var orderModal = new bootstrap.Modal(document.getElementById('orderModal'));
        var successModal = new bootstrap.Modal(document.getElementById('successModal'));

        viewButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                var username = this.getAttribute('data-username');
                var pizzaname = this.getAttribute('data-pizzaname');
                var orderstatus = this.getAttribute('data-orderstatus');
                var orderlocator = this.getAttribute('data-orderlocator');
                var quantity = this.getAttribute('data-quantity');
                document.getElementById('username').value = username;
                document.getElementById('pizzaname').value = pizzaname;
                document.getElementById('orderstatus').value = orderstatus;
                document.getElementById('quantity').value = quantity;

                // Show the order modal
                orderModal.show();

                // Add event listener for Accept Order button
                document.getElementById('acceptOrderBtn').addEventListener('click', function () {
                    acceptOrder(username, orderlocator);
                });
            });
        });


        // Add event listener for Close button in success modal
        document.getElementById('successCloseBtn').addEventListener('click', function () {
            successModal.hide();
        });

        function acceptOrder(username, orderlocator) {
            // Send an AJAX request to update the rider column
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Hide the order modal
                    orderModal.hide();

                    // Show the success modal
                    successModal.show();

                    // Reload the page after 3 seconds
                    setTimeout(function () {
                        successModal.hide();
                        location.reload();
                    }, 2000);
                }
            };
            xhr.open("POST", "accept_order.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("username=" + username + "&orderlocator=" + orderlocator);
        }
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var deleteButtons = document.querySelectorAll('.deleteBtn');
    var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    var successModal = new bootstrap.Modal(document.getElementById('successModal'));

    deleteButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var username = this.getAttribute('data-username');
            var pizzaname = this.getAttribute('data-pizzaname');
            var id = this.getAttribute('data-id');
            document.getElementById('deleteUsername').textContent = username + ' (' + pizzaname + ')';
            document.getElementById('confirmDelete').addEventListener('click', function() {
                deleteOrder(id);
            });
            deleteModal.show();
        });
    });

    function deleteOrder(id) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Close the delete modal
                deleteModal.hide();
                // Show the success modal after the delete modal is closed
                successModal.show();
                setTimeout(function() {
                    successModal.hide();
                    location.reload(); // Refresh the page after deletion
                }, 2000);
            }
        };
        xhr.open("POST", "delete_order.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("id=" + id);
    }

    var successCloseBtn = document.getElementById('successCloseBtn');
    successCloseBtn.addEventListener('click', function() {
        successModal.hide();
    });
});


</script>


</body>
</html>

