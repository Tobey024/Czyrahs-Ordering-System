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

// Update data if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_account'])) {
    $id = $_POST["id"];
    $fname = $_POST["fname"];
    $mname = $_POST["mname"];
    $lname = $_POST["lname"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $birthday = $_POST["birthday"];
    $address = $_POST["address"];
    $contact = $_POST["contact"];
    $type = $_POST["type"];

    // Check if username, email, or contact already exist
    $check_query = "SELECT * FROM accounts WHERE (username='$username' OR email='$email' OR contact='$contact') AND id != '$id'";
    $result = $conn->query($check_query);

    if ($result->num_rows > 0) {
        $modalMessage = "Username, email, or contact already exists";
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    var modal = new bootstrap.Modal(document.getElementById('dataUpdateModal'));
                    modal.show();
                });
            </script>";
    } else {
        $password = $_POST["password"];
        if(empty($password)){
            $modalMessage = "Password cannot be blank";
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var modal = new bootstrap.Modal(document.getElementById('dataUpdateModal'));
                        modal.show();
                    });
                </script>";
        }else{
            $password = password_hash($password, PASSWORD_DEFAULT);
            // Update query
            $sql_update = "UPDATE accounts SET fname='$fname', mname='$mname', lname='$lname', username='$username', password='$password', email='$email', birthday='$birthday', address='$address', contact='$contact', type='$type' WHERE id='$id'";

            if ($conn->query($sql_update) === TRUE) {
                $modalMessage = "Data updated successfully";
                echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var modal = new bootstrap.Modal(document.getElementById('dataUpdateModal'));
                            modal.show();
                        });
                    </script>";
            } else {
                echo "Error updating record: " . $conn->error;
            }
        }
    }
}

// Check if form is submitted for adding an account
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_account'])) {
    $fname = $_POST["fname"];
    $mname = $_POST["mname"];
    $lname = $_POST["lname"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $birthday = $_POST["birthday"];
    $address = $_POST["address"];
    $contact = $_POST["contact"];
    $type = $_POST["type"];

    // Check if username, email, or contact already exist
    $check_query = "SELECT * FROM accounts WHERE username='$username' OR email='$email' OR contact='$contact'";
    $result = $conn->query($check_query);

    if ($result->num_rows > 0) {
        $modalMessage = "Username, email, or contact already exists";
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    var modal = new bootstrap.Modal(document.getElementById('dataUpdateModal'));
                    modal.show();
                });
            </script>";
    } else {
        if(empty($password)){
            $modalMessage = "Password cannot be blank";
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var modal = new bootstrap.Modal(document.getElementById('dataUpdateModal'));
                        modal.show();
                    });
                </script>";
        }else{
            $password = password_hash($password, PASSWORD_DEFAULT);
            // Insert query
            $sql_insert = "INSERT INTO accounts (fname, mname, lname, username, password, email, birthday, address, contact, type) 
                            VALUES ('$fname', '$mname', '$lname', '$username', '$password', '$email', '$birthday', '$address', '$contact', '$type')";

            if ($conn->query($sql_insert) === TRUE) {
                // Redirect to the same page to avoid resubmission
                header("Refresh:2");
            } else {
                echo "Error adding record: " . $conn->error;
            }
        }
    }
}

// Query to get total number of records from the "accounts" table
$sql_accounts = "SELECT COUNT(*) AS total_accounts FROM accounts";
$result_accounts = $conn->query($sql_accounts);

if ($result_accounts->num_rows > 0) {
    // Fetch the total number of records from the "accounts" table
    $row_accounts = $result_accounts->fetch_assoc();
    $totalAccounts = $row_accounts["total_accounts"];
} else {
    $totalAccounts = 0;
}

// Search query
$search_query = isset($_GET['search']) ? $_GET['search'] : '';
if (!empty($search_query)) {
    $search_query = $conn->real_escape_string($search_query);
    $sql = "SELECT * FROM accounts WHERE fname LIKE '%$search_query%' OR lname LIKE '%$search_query%' OR username LIKE '%$search_query%' OR email LIKE '%$search_query%'";
    $result = $conn->query($sql);
} else {
    // Original query to fetch all users
    $sql = "SELECT * FROM accounts";
    $result = $conn->query($sql);
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
    <!-- Search form -->
<form method="get">
    <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="Search..." name="search">
        <button class="btn btn-outline-secondary" type="submit">Search</button>
    </div>
</form>

    <div class="container mt-5">
        <h2><center>User Management <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">Add Account</button></h2>
        <div class="table-responsive">
            <table class="table table-bordered">
    <thead>
        <tr>
            <th>Username</th>
            <th>Type</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["username"] . "</td>";
                echo "<td>" . $row["type"] . "</td>";
                echo "<td class='text-center'>";
                echo "<button type='button' class='btn btn-primary me-2' data-bs-toggle='modal' data-bs-target='#editModal{$row["id"]}'>Edit</button>";
                echo "<button class='btn btn-danger ms-2 delete-btn' data-bs-toggle='modal' data-bs-target='#confirmDeleteModal' data-id='{$row["id"]}'>Delete</button>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3' class='text-center'>No accounts found</td></tr>";
        }
        ?>
    </tbody>
</table>

        </div>
    </div>

    <!-- Edit Modal -->
    <?php
    $result_edit = $conn->query($sql);
    if ($result_edit->num_rows > 0) {
        while($row_edit = $result_edit->fetch_assoc()) {
            echo "<div class='modal fade' id='editModal{$row_edit["id"]}'>";
            echo "<div class='modal-dialog'>";
            echo "<div class='modal-content'>";
            echo "<div class='modal-header'>";
            echo "<h5 class='modal-title'>Edit Account</h5>";
            echo "<button type='button' class='btn-close' data-bs-dismiss='modal'></button>";
            echo "</div>";
            echo "<div class='modal-body'>";
            echo "<form method='POST'>";
            echo "<input type='hidden' name='id' value='{$row_edit["id"]}'>";
            echo "<div class='mb-3'>";
            echo "<label for='fname' class='form-label'>First Name</label>";
            echo "<input type='text' class='form-control' id='fname' name='fname' value='{$row_edit["fname"]}'>";
            echo "</div>";
            echo "<div class='mb-3'>";
            echo "<label for='mname' class='form-label'>Middle Name</label>";
            echo "<input type='text' class='form-control' id='mname' name='mname' value='{$row_edit["mname"]}'>";
            echo "</div>";
            echo "<div class='mb-3'>";
            echo "<label for='lname' class='form-label'>Last Name</label>";
            echo "<input type='text' class='form-control' id='lname' name='lname' value='{$row_edit["lname"]}'>";
            echo "</div>";
            echo "<div class='mb-3'>";
            echo "<label for='username' class='form-label'>Username</label>";
            echo "<input type='text' class='form-control' id='username' name='username' value='{$row_edit["username"]}'>";
            echo "</div>";
            echo "<div class='mb-3'>";
echo "<label for='password' class='form-label'>Password</label>";
echo "<input type='password' class='form-control' id='password' name='password' value=''>";
echo "</div>";

            echo "<div class='mb-3'>";
            echo "<label for='email' class='form-label'>Email</label>";
            echo "<input type='email' class='form-control' id='email' name='email' value='{$row_edit["email"]}'>";
            echo "</div>";
            echo "<div class='mb-3'>";
            echo "<label for='birthday' class='form-label'>Birthday</label>";
            echo "<input type='text' class='form-control' id='birthday' name='birthday' value='{$row_edit["birthday"]}'>";
            echo "</div>";
            echo "<div class='mb-3'>";
            echo "<label for='address' class='form-label'>Address</label>";
            echo "<input type='text' class='form-control' id='address' name='address' value='{$row_edit["address"]}'>";
            echo "</div>";
            echo "<div class='mb-3'>";
            echo "<label for='contact' class='form-label'>Contact</label>";
            echo "<input type='text' class='form-control' id='contact' name='contact' value='{$row_edit["contact"]}'>";
            echo "</div>";
            echo "<div class='mb-3'>";
            echo "<label for='type' class='form-label'>Type</label>";
            echo "<select class='form-select' id='type' name='type'>";
            echo "<option value='Admin'" . ($row_edit["type"] == "Admin" ? " selected" : "") . ">Admin</option>";
            echo "<option value='Employee'" . ($row_edit["type"] == "Employee" ? " selected" : "") . ">Employee</option>";
            echo "<option value='Rider'" . ($row_edit["type"] == "Rider" ? " selected" : "") . ">Rider</option>";
            echo "<option value='User'" . ($row_edit["type"] == "User" ? " selected" : "") . ">User</option>";
            echo "</select>";
            echo "</div>";
            echo "<button type='submit' name='edit_account' class='btn btn-primary'>Edit</button>";
            echo "</form>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
    }
    ?>

    <!-- Add Account Modal -->
<div class='modal fade' id='addModal'>
    <div class='modal-dialog'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h5 class='modal-title'>Add Account</h5>
                <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
            </div>
            <div class='modal-body'>
                <form method='POST'>
                    <div class='mb-3'>
                        <label for='fname' class='form-label'>First Name</label>
                        <input type='text' class='form-control' id='fname' name='fname' value=''>
                    </div>
                    <div class='mb-3'>
                        <label for='mname' class='form-label'>Middle Name</label>
                        <input type='text' class='form-control' id='mname' name='mname' value=''>
                    </div>
                    <div class='mb-3'>
                        <label for='lname' class='form-label'>Last Name</label>
                        <input type='text' class='form-control' id='lname' name='lname' value=''>
                    </div>
                    <div class='mb-3'>
                        <label for='username' class='form-label'>Username</label>
                        <input type='text' class='form-control' id='username' name='username' value=''>
                    </div>
                    <div class='mb-3'>
                        <label for='password' class='form-label'>Password</label>
                        <input type='password' class='form-control' id='password' name='password' value=''>
                    </div>
                    <div class='mb-3'>
                        <label for='email' class='form-label'>Email</label>
                        <input type='email' class='form-control' id='email' name='email' value=''>
                    </div>
                    <div class='mb-3'>
                        <label for='birthday' class='form-label'>Birthday</label>
                        <input type='date' class='form-control' id='birthday' name='birthday' value=''>
                    </div>
                    <div class='mb-3'>
                        <label for='address' class='form-label'>Address</label>
                        <input type='text' class='form-control' id='address' name='address' value=''>
                    </div>
                    <div class='mb-3'>
                        <label for='contact' class='form-label'>Contact</label>
                        <input type='number' class='form-control' id='contact' name='contact' value=''>
                    </div>
                    <div class='mb-3'>
                            <label for='type' class='form-label'>Type</label>
                            <select class='form-select' id='type' name='type'>
                                <option value='Admin'>Admin</option>
                                <option value='Employee'>Employee</option>
                                <option value='Rider'>Rider</option>
                                <option value='User'>User</option>
                            </select>
                        </div>
                    <button type='submit' name='add_account' class='btn btn-primary'>Add Account</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="dataUpdateModal" tabindex="-1" aria-labelledby="dataUpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataUpdateModalLabel">Update</h5>
            </div>
            <div class="modal-body">
                <?php echo $modalMessage ?? ''; ?>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this record?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Delete</button>

            </div>
        </div>
    </div>
</div>


    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
    var confirmDeleteButton = document.getElementById('confirmDeleteButton');
    var deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var id = button.getAttribute('data-id');
            confirmDeleteButton.setAttribute('data-id', id);
        });
    });

    confirmDeleteButton.addEventListener('click', function() {
        var id = confirmDeleteButton.getAttribute('data-id');
        window.location.href = "delete_script.php?id=" + id;
    });
});
    document.addEventListener('DOMContentLoaded', function() {
    var searchInput = document.querySelector('#search');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            var searchValue = this.value;
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Handle response as needed
                    console.log(this.responseText); // Example: Log response to console
                }
            };
            xhttp.open("GET", "search.php?search=" + searchValue, true);
            xhttp.send();
        });
    }
});
</script>
</body>
</html>
