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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            overflow-x: hidden;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            padding: 2rem;
            background: linear-gradient(to right, #343a40, #343a40, #1e2124);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 200px;
            transition: width 0.3s;
        }

        .profile-pic {
            width: 100px;
            height: 100px;
            overflow: hidden;
            border-radius: 50%;
            margin: 0 auto;
            margin-bottom: 2rem;
            border: 4px solid #fff;
        }

        .profile-pic img {
            width: 100%;
            height: auto;
        }

        .logout-btn {
            display: block;
            width: 100%;
            padding: 0.5rem;
            background-color: #dc3545;
            color: #fff;
            border: none;
            border-radius: 0.25rem;
            margin-bottom: 2rem;
            cursor: pointer;
            text-decoration: none;
        }

        .nav-link {
            display: block;
            padding: 0.5rem 1rem;
            color: #fff;
            border-radius: 0.25rem;
            margin-bottom: 1rem;
            text-align: center;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .nav-link:hover {
            background-color: #495057;
        }

        .main-content {
            padding: 2rem;
            margin-left: 200px; /* Adjusted margin-left */
            transition: margin-left 0.3s;
        }

        .dashboard-title {
            font-size: 30px;
            margin-bottom: 1rem;
            color: #495057;
        }

        .dashboard-content {
            font-size: 16px;
            color: #495057;
        }

        .box {
            position: relative;
            display: flex;
            flex-direction: column;
            width: 250px;
            margin: 10px;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            color: #333;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-family: 'Arial', sans-serif;
        }

        .box:hover {
            transform: scale(1.05);
        }

        img {
            max-width: 100%;
            height: auto;
            max-height: 200px;
            object-fit: cover;
        }

        .box-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center; /* Center the content */
            text-align: center; /* Center text */
        }

        .price {
            margin-top: 5px; /* Adjusted margin for Price */
            margin-bottom: 5px;
        }

        .menu-row {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
            margin-top: auto; /* Push the buttons to the bottom */
            width: 100%; /* Full width */
        }

        .edit-btn {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            width: 48%; /* Adjusted width */
        }

        .edit-btn:hover {
            background-color: #0056b3;
        }
        .delete-btn {
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            width: 48%; /* Adjusted width */
        }

        .delete-btn:hover {
            background-color: #8f1722;
        }
        .add-item-btn {
            background-color: #28a745;
            margin-left: 10px;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            margin-bottom: 20px;
            text-decoration: none;
            display: inline-block;
        }

        .add-item-btn:hover {
            background-color: #218838;
        }

        /* Media queries for responsive design */
        @media (max-width: 992px) {
            .sidebar {
                width: 100px;
                padding: 1rem; 
            }

            .main-content {
                margin-left: 50px;
                padding: 1rem;
            }

            .add-item-btn {
                margin-left: 100px;
            }

            .box {
                width: 300px;
                margin: 5px;
                padding: 10px;
            }

            .edit-btn,
            .delete-btn {
                padding: 3px 6px;
                font-size: 12px;
            }

            .dashboard-title {
                font-size: 20px;
            }

            .dashboard-content {
                font-size: 14px;
            }
            .add-item-btn{
                margin-left: 10px;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin Panel</a>
            <div class="d-flex">
                <a class="btn btn-light me-2" href="../admin/admndb.php">Go Back</a>
            </div>
        </div>
    </nav>
    <div class="col-10 main-content">
        <center>
        <h1 class="dashboard-title">Menu Settings</h1>
        <p class="dashboard-content">Today's Menu</p>
        <a href="menuadd.php" class="btn btn-success add-item-btn">Add Item</a>
            <div class="menu-row">
        <?php
        $conn = mysqli_connect("localhost", "u471532386_czyrahs", "24Starexified!", "u471532386_czyrahs_os");
        $sql = "SELECT * FROM menu1";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_array($result)) {
            echo '<div class="box" id="menu-item-' . $row["id"] . '">';
            echo '<img src="' . $row['image'] . '" class="img-fluid" alt="Image">';
            echo '<div class="box-content">';
            echo '<h5>' . $row["PizzaName"] . '</h5>';
            echo '<p class="price">Price: $' . $row["Price"] . '</p>';
            echo '<p>' . $row["Description"] . '</p>';
            echo '<div class="button-container">';
            echo '<button class="btn btn-primary edit-btn" onclick="openEditModal(' . $row["id"] . ', \'' . $row["PizzaName"] . '\', \'' . $row["Description"] . '\', \'' . $row["Price"] . '\')">Edit</button>';
            echo '<button class="btn btn-danger delete-btn" onclick="deleteMenuItem(' . $row["id"] . ')">Delete</button>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }

        mysqli_close($conn);
        ?>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Menu Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    <div class="mb-3">
                        <label for="editPizzaName" class="form-label">Pizza Name</label>
                        <input type="text" class="form-control" id="editPizzaName" name="editPizzaName">
                    </div>
                    <div class="mb-3">
                        <label for="editDescription" class="form-label">Description</label>
                        <input type="text" class="form-control" id="editDescription" name="editDescription">
                    </div>
                    <div class="mb-3">
                        <label for="editPrice" class="form-label">Price</label>
                        <input type="text" class="form-control" id="editPrice" name="editPrice">
                    </div>
                    <input type="hidden" id="editItemId" name="editItemId">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="updateMenuItem()">Save changes</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function deleteMenuItem(itemId) {
        if (confirm('Are you sure you want to delete this item?')) {
            $.ajax({
                type: 'POST',
                url: 'delete_menu_item.php',
                data: { id: itemId },
                success: function(response) {
                    if (response === 'success') {
                        $('#menu-item-' + itemId).remove();
                        alert('Item deleted successfully');
                    } else {
                        alert('Failed to delete item');
                    }
                }
            });
        }
    }
    function openEditModal(id, pizzaName, description, price) {
    document.getElementById('editPizzaName').value = pizzaName;
    document.getElementById('editDescription').value = description;
    document.getElementById('editPrice').value = price;
    document.getElementById('editItemId').value = id;
    $('#editModal').modal('show');
}

function updateMenuItem() {
    var id = document.getElementById('editItemId').value;
    var pizzaName = document.getElementById('editPizzaName').value;
    var description = document.getElementById('editDescription').value;
    var price = document.getElementById('editPrice').value;

    $.ajax({
        type: 'POST',
        url: 'update_menu_item.php',
        data: {
            id: id,
            pizzaName: pizzaName,
            description: description,
            price: price
        },
        success: function(response) {
            if (response === 'success') {
                $('#menu-item-' + id + ' h5').text(pizzaName);
                $('#menu-item-' + id + ' .price').text('Price: $' + price);
                $('#menu-item-' + id + ' p:eq(1)').text(description);
                $('#editModal').modal('hide');
                alert('Item updated successfully');
            } else {
                alert('Failed to update item');
            }
        }
    });
}


</script>
</body>

</html>

