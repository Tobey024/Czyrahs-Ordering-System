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
$sql = "SELECT * FROM accounts WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

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

        .add-to-cart-form {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: auto; /* Push the form to the bottom */
        }

        .add-to-cart-btn {
            width: 100%; /* Full width */
        }

        .menu-row {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 20px;
        }
        .page-header2 {
    position: relative;
    margin-bottom: 45px;
    padding: 150px 0 90px 0;
    text-align: center;
    background: linear-gradient(rgba(0, 0, 0, .5), rgba(0, 0, 0, .5)), url(img/pizza-header.jpg);
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}

.page-header2 h2 {
    position: relative;
    color: #4fd845;
    font-size: 60px;
    font-weight: 700;
}

.page-header2 a {
    position: relative;
    padding: 0 12px;
    font-size: 20px;
    text-transform: uppercase;
    color: #ffffff;
}

.page-header2 a:hover {
    color: #ffffff;
}

.page-header2 a::after {
    position: absolute;
    content: "/";
    width: 8px;
    height: 8px;
    top: -1px;
    right: -7px;
    text-align: center;
    color: #fbaf32;
}

.page-header2 a:last-child::after {
    display: none;
}

@media (max-width: 767.98px) {
    .page-header2 h2 {
        font-size: 35px;
    }
    
    .page-header2 a {
        font-size: 18px;
    }
}
.box {
    position: relative;
    margin: 10px;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    color: #333;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-family: 'Arial', sans-serif;
}

.box-content {
    display: flex;
    align-items: center;
}

.box-content img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 50%;
    margin-right: 20px;
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
}

.btn-primary:hover {
    background-color: #0056b3;
    border-color: #0056b3;
}
.modal-dialog {
    max-width: 800px; /* Set the max-width of the modal */
}

.modal-content {
    padding: 20px; /* Add padding inside the modal content */
}

.modal-body {
    display: flex;
    flex-direction: column;
}

.modal-label {
    text-align: left; /* Align the label text to the left */
    margin-bottom: 5px; /* Add some space between labels */
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
        <div class="loading-text">Setting Up!</div>
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
                    <a href="userordering.php" class="nav-item nav-link">Orders</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle active" data-toggle="dropdown">Profile</a>
                        <div class="dropdown-menu">
                            <a href="userprofile.php" class="dropdown-item active">Settings</a>
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
    <div class="page-header2 mb-0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2>Profile</h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- User Profile Start -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3><center>User Profile</center></h3>
                    <hr>
                    <div class="form-group">
                        <label for="fname">First Name</label>
                        <input type="text" class="form-control" id="fname" value="<?php echo $row['fname']; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="mname">Middle Name</label>
                        <input type="text" class="form-control" id="mname" value="<?php echo $row['mname']; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="lname">Last Name</label>
                        <input type="text" class="form-control" id="lname" value="<?php echo $row['lname']; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" value="<?php echo $row['username']; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" value="<?php echo $row['email']; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="birthday">Birthday</label>
                        <input type="text" class="form-control" id="birthday" value="<?php echo $row['birthday']; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" value="<?php echo $row['address']; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="contact">Contact</label>
                        <input type="text" class="form-control" id="contact" value="<?php echo $row['contact']; ?>" readonly>
                    </div>
                    <button class="btn btn-primary btn-block" onclick="openEditProfileModal()">Edit Profile</button>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- User Profile End -->



           

    <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>


<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editProfileForm">
                    <input type="hidden" id="userId" value="<?php echo $row['id']; ?>">
                    <div class="form-group">
                        <label for="editFname">First Name</label>
                        <input type="text" class="form-control" id="editFname" value="<?php echo $row['fname']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="editMname">Middle Name</label>
                        <input type="text" class="form-control" id="editMname" value="<?php echo $row['mname']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="editLname">Last Name</label>
                        <input type="text" class="form-control" id="editLname" value="<?php echo $row['lname']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="editEmail">Email</label>
                        <input type="email" class="form-control" id="editEmail" value="<?php echo $row['email']; ?>">
                    </div>
                    <div class="form-group">
                     <label for="editPassword">New Password</label>
                     <input type="password" class="form-control" id="editPassword">
                    </div>

                    <div class="form-group">
                        <label for="editBirthday">Birthday</label>
                        <input type="date" class="form-control" id="editBirthday" value="<?php echo $row['birthday']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="editAddress">Address</label>
                        <input type="text" class="form-control" id="editAddress" value="<?php echo $row['address']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="editContact">Contact</label>
                        <input type="text" class="form-control" id="editContact" value="<?php echo $row['contact']; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Success</h5>
            </div>
            <div class="modal-body">
                <!-- Modal body content will be dynamically updated -->
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>





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
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <script>
$(document).ready(function() {
    $('#editProfileForm').on('submit', function(e) {
        e.preventDefault();
        var userId = $('#userId').val();
        var fname = $('#editFname').val();
        var mname = $('#editMname').val();
        var lname = $('#editLname').val();
        var email = $('#editEmail').val();
        var password = $('#editPassword').val(); // Add this line to capture the password field
        var birthday = $('#editBirthday').val();
        var address = $('#editAddress').val();
        var contact = $('#editContact').val();

        $.ajax({
            url: 'update_profile.php',
            type: 'POST',
            data: {
                id: userId,
                fname: fname,
                mname: mname,
                lname: lname,
                email: email,
                password: password, // Add the password field to the data
                birthday: birthday,
                address: address,
                contact: contact
            },
success: function(response) {
    if (response.trim() === "Success") {
        $('#editProfileModal').modal('hide');
        $('#successModal .modal-header h5').html('Success'); // Update modal header
        $('#successModal .modal-body').html('Successfully edited Profile'); // Update modal body
        $('#successModal').modal('show'); // Display success modal
        // You can update the data on the page without reloading it
    } else {
        $('#editProfileModal').modal('hide');
        $('#successModal .modal-header h5').html('Failed'); // Update modal header
        $('#successModal .modal-body').html(response); // Update modal body with error message
        $('#successModal').modal('show'); // Display success modal
    }
},


        });
    });
});
    function openEditProfileModal() {
    $('#editProfileModal').modal('show');
}
$(document).ready(function() {
    // Your existing code

    $('#successModal').on('hidden.bs.modal', function (e) {
        location.reload(); // Reload the page after the success modal is hidden
    });
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
        
</script>
<script>document.addEventListener('DOMContentLoaded', () => {
  var disclaimer =  document.querySelector("img[alt='www.000webhost.com']");
   if(disclaimer){
       disclaimer.remove();
   }  
 });
</script>
</body>

</html>
