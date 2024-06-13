<?php
session_start(); // Start the session

// Check if the user is not logged in or does not have the 'User', 'Admin', or 'Employee' type
if (!isset($_SESSION['username']) || ($_SESSION['type'] != 'User' && $_SESSION['type'] != 'Admin')) {
    // Redirect to the login page
    header("Location: ../logout.php");
    exit();
}
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

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

.line {
    border-bottom: 1px solid black; /* Set the line color to black */
    width: 100%; /* Make the line span the width of the container */
    margin-bottom: 0; /* Add some spacing below the line */
}

</style>
<body>
<!-- The Modal -->
<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Alert</h4>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        Pizza is already in the cart.
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<!-- The Success Modal -->
<div class="modal fade" id="successModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Success</h4>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        Item added to cart successfully.
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="reloadPageBtn" data-bs-dismiss="modal">Okay</button>
      </div>

    </div>
  </div>
</div>


<div class="loader-container">
        <div class="loading-text">Opening Menu!</div>
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
                    <a href="menu.php" class="nav-item nav-link active">Menu</a>
                    <a href="usercart.php" class="nav-item nav-link">Cart</a>
                    <a href="userordering.php" class="nav-item nav-link">Orders</a>
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
                    <h2>Menu</h2>
                </div>
                <div class="col-12">
                    <a href="usercart.php">Cart</a>
                    <a href="userordering.php">Orders</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Menu Start -->
    <div class="menu">
    <div class="container">
        <div class="row menu-row" id="menuItems">
            <!-- Menu items will be dynamically loaded here -->
        </div>
    </div>
</div>
    <!-- Menu End -->

    <!-- Footer Start -->
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <p class="company-name">All Rights Reserved. &copy; 2023 <a href="#">Czyrah's Pizza</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>


    <script>
    $(document).ready(function () {
    // Load menu items
    $.ajax({
        url: 'get_menu_items.php',
        type: 'GET',
        success: function (data) {
            $('#menuItems').html(data);
            $('.loader-container').fadeOut();
        },
        error: function () {
            alert('Error loading menu items.');
        }
    });

    // Add to cart button click event
    $('#menuItems').on('click', '.add-to-cart-btn', function (e) {
        e.preventDefault();
        var form = $(this).closest('form');
        var formData = form.serialize();

        $.ajax({
            url: 'add_to_cart.php',
            type: 'POST',
            data: formData,
            success: function (response) {
                if (response === 'exists') {
                    // Show modal if pizza is already in cart
                    $('#myModal').modal('show');
                } else if (response === 'success') {
                    // Show success modal if item is added to cart successfully
                    $('#successModal').modal('show');
                } else if (response === 'limit') {
                    // Handle the case where the user has reached the order limit
                    alert('You have reached the order limit.');
                } else {
                    // Handle other errors
                    alert('Error adding item to cart.');
                }
            },
            error: function () {
                alert('Error adding item to cart.');
            }
        });
    });


});

    
</script>
</body>

</html>
