<?php
session_start(); // Start the session

// Check if the user is not logged in or does not have the 'User', 'Admin', 'Employee', or 'Rider' type
if (!isset($_SESSION['username']) || ($_SESSION['type'] == 'User')) {
    // Redirect to the login page
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

// Query to get total number of records from the "orderhandler" table with specific statuses
$sql_orderhandler = "SELECT COUNT(*) AS total_orderhandler FROM orderhandler WHERE orderstatus = 'On Checking'";
$result_orderhandler = $conn->query($sql_orderhandler);

if ($result_orderhandler->num_rows > 0) {
    // Fetch the total number of records from the "orderhandler" table
    $row_orderhandler = $result_orderhandler->fetch_assoc();
    $totalOrderhandler = $row_orderhandler["total_orderhandler"];
} else {
    $totalOrderhandler = 0;
}


// Set the specificUsername to the username from the session
$specificUsername = $_SESSION['username'];

$sql_rider_count = "SELECT COUNT(*) AS total_rider_orders FROM orderhandler WHERE rider = '$specificUsername' AND orderstatus != 'Finish Process'";
$result_rider_count = $conn->query($sql_rider_count);

if ($result_rider_count->num_rows > 0) {
    // Fetch the total number of records with the same username in the rider column
    $row_rider_count = $result_rider_count->fetch_assoc();
    $totalRiderOrders = $row_rider_count["total_rider_orders"];
} else {
    $totalRiderOrders = 0;
}


// Query to get the last 5 records from the "accounts" table
$sql = "SELECT username, email, contact FROM accounts ORDER BY id DESC LIMIT 5";
$result = $conn->query($sql);

// Query to get the total price of orders with status "Finish Process"
$sql_total_price = "SELECT SUM(totalprice) AS total_price FROM orderhandler WHERE orderstatus = 'Finish Process'";
$result_total_price = $conn->query($sql_total_price);

if ($result_total_price->num_rows > 0) {
    // Fetch the total price
    $row_total_price = $result_total_price->fetch_assoc();
    $totalPrice = $row_total_price["total_price"];
} else {
    $totalPrice = 0;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Rider Panel</title>
</head>
<style>
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    min-height: 100vh;
}
a {
    text-decoration: none;
}
li {
    list-style: none;
}
h1,
h2 {
    color: black;
}
h3 {
    color: #999;
}
.btn {
    background: #f05462;
    color: white;
    padding: 5px 10px;
    text-align: center;
}
.btn:hover {
    transition: .3s;
    color: #f05462;
    background: white;
    padding: 3px 8px;
    border: 2px solid #f05462;
}
.title {
    display: flex;
    align-items: center;
    justify-content: space-around;
    padding: 15px 10px;
    border-bottom: 2px solid #999;
}
table {
    padding: 10px;
}
th,
td {
    text-align: left;
    padding: 8px;
}
.side-menu {
    position: fixed;
    background: #0d6efd;
    width: 20vw;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}
.side-menu .brand-name {
    height: 10vh;
    display: flex;
    align-items: center;
    justify-content: center;
}
.side-menu li {
    font-size: 24px;
    padding: 10px 40px;
    color: white;
    display: flex;
    align-items: center;
}
.side-menu a {
    font-size: 24px;
    padding: 10px 40px;
    color: white;
    display: flex;
    align-items: center;
}
.side-menu a:hover {
    background: transparent;
    color: #f05462;
}
.container {
    position: absolute;
    right: 0;
    width: 80vw;
    height: 100vh;
    background: #f1f1f1;
}
.container .header {
    position: fixed;
    top: 0;
    right: 0;
    width: 80vw;
    height: 10vh;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    z-index: 1;
}
.container .header .nav {
    width: 90%;
    display: flex;
    align-items: center;
}
.container .header .nav .search {
    flex: 3;
    display: flex;
    justify-content: center;
}
.container .header .nav .search input[type=text] {
    border: none;
    background: #f1f1f1;
    padding: 10px;
    width: 50%;
}
.container .header .nav .search button {
    width: 40px;
    height: 40px;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
}
.container .header .nav .search button img {
    width: 30px;
    height: 30px;
}
.container .header .nav .user {
    flex: 1;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.container .header .nav .user img {
    width: 40px;
    height: 40px;
}
.container .header .nav .user .img-case {
    position: relative;
    width: 50px;
    height: 50px;
}
.container .header .nav .user .img-case img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}
.container .content {
    position: relative;
    margin-top: 10vh;
    min-height: 90vh;
    background: #f1f1f1;
}
.container .content .cards {
    padding: 20px 15px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
}
.container .content .cards .card {
    width: 250px;
    height: 150px;
    background: white;
    margin: 20px 10px;
    display: flex;
    align-items: center;
    justify-content: space-around;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
.container .content .content-2 {
    min-height: 60vh;
    display: flex;
    justify-content: space-around;
    align-items: flex-start;
    flex-wrap: wrap;
}
.container .content .content-2 .recent-payments {
    overflow-x: auto;
    min-height: 50vh;
    flex: 5;
    background: white;
    margin: 0 25px 25px 25px;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    display: flex;
    flex-direction: column;
}
.container .content .content-2 .new-students {
    flex: 2;
    background: white;
    min-height: 35vh;
    margin: 0 25px;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    display: flex;
    flex-direction: column;
}
.container .content .content-2 .new-students table td:nth-child(1) img {
    height: 40px;
    width: 40px;
}
@media screen and (max-width: 1050px) {
    .side-menu li {
        font-size: 18px;
    }
}
@media screen and (max-width: 940px) {
    .side-menu li span {
        display: none;
    }
    .side-menu {
        align-items: center;
    }
    .side-menu li img {
        width: 40px;
        height: 40px;
    }
    .side-menu li:hover {
        background: #f05462;
        padding: 8px 38px;
        border: 2px solid white;
    }
}
@media screen and (max-width:536px) {
    .brand-name h1 {
        font-size: 10px;
    }
    .container .content .cards {
        justify-content: center;
    }
    .side-menu li img {
        width: 30px;
        height: 30px;
    }
    .container .content .content-2 .recent-payments table th:nth-child(2),
    .container .content .content-2 .recent-payments table td:nth-child(2) {
        display: none;
    }
}
.new-students {
        flex: 2;
        background: white;
        margin: 0 25px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        display: flex;
        flex-direction: column;
    }
    .new-students .title {
        padding: 15px;
        border-bottom: 1px solid #ccc;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .new-students .title h2 {
        margin: 0;
    }
    .new-students .title .btn {
        padding: 5px 10px;
        background-color: #f05462;
        color: white;
        border: none;
        border-radius: 3px;
        text-decoration: none;
    }
    .new-students .table-wrapper {
        flex: 1;
        overflow-y: auto;
    }
    .new-students table {
        width: 100%;
        border-collapse: collapse;
    }
    .new-students th, .new-students td {
        border: 1px solid #ccc;
        padding: 8px;
        text-align: left;
    }
    .new-students th {
        background-color: #f1f1f1;
    }
    

    
    .button1 {
    display: inline-block;
    border-radius: 4px;
    background-color: #04AA6D;
    border: none;
    color: #FFFFFF;
    text-align: center;
    font-size: 15px;
    padding: 5px;
    width: 50;
    transition: all 0.5s;
    cursor: pointer;
    margin: 5px;
    }

    .button1 span {
    cursor: pointer;
    display: inline-block;
    position: relative;
    transition: 0.5s;
    }

    .button1 span:after {
    content: '\00bb';
    position: absolute;
    opacity: 0;
    top: 0;
    right: -20px;
    transition: 0.5s;
    }

    .button1:hover span {
    padding-right: 25px;
    }

    .button1:hover span:after {
    opacity: 1;
    right: 0;
    }
    .finish-process-text {
    background-color: #198754; /* Light blue background */
    color: #fff; /* Text color */
    padding: 2px 5px; /* Optional: Add padding to the highlighted text */
    border-radius: 3px; /* Optional: Add rounded corners to the highlighted text */
}
.recent-payments td {
  border:1px solid black;
  text-align:center;
}
.recent-payments th{
    color:white;
    background-color: #0d6efd;
    text-align:center;
}
/* Scrollbar Track */
::-webkit-scrollbar {
  width: 10px; /* Width of the scrollbar */
}

/* Scrollbar Handle */
::-webkit-scrollbar-thumb {
  background: #888; /* Color of the scrollbar handle */
  border-radius: 5px; /* Rounded corners */
}

/* Hover effect on scrollbar handle */
::-webkit-scrollbar-thumb:hover {
  background: #555;
}

/* Scrollbar Track */
::-webkit-scrollbar-track {
  background: #f1f1f1; /* Color of the scrollbar track */
  border-radius: 5px; /* Rounded corners */
}

/* Handle on the scrollbar while scrolling */
::-webkit-scrollbar-thumb:active {
  background: #333;
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
            border-top: 5px solid #0d6efd;
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
        <div class="loading-text">Rider...</div>
        <div class="spinner"></div>
    </div>
    <div class="side-menu">
        <div class="brand-name">
        </div>
        <ul>
            <li><a href="#"><img src="images/dashboard (2).png" alt="">&nbsp; <span>Dashboard</span></a></li>
            <li><a href="riderorderview.php"><img src="images/teacher2.png" alt="">&nbsp;<span>Orders</span> </a></li>
            <li><a href="rider_recent_transaction.php"><img src="images/payment.png" alt="">&nbsp;<span>History</span> </a></li>
            <li><a href="logout.php"><img src="images/logout.png" alt="">&nbsp;<span>Logout</span></a> </li>
        </ul>
    </div>
    <div class="container">
        <div class="header">
        <center><h2>Rider Dashboard</h2>
            <div class="nav">
                
                <div class="search">
                    
                </div>
                <div class="user">
                    
                </div>
            </div>
        </div>
        <div class="content">
            <div class="cards">
                <div class="card">
                    <div class="box">
                        <center>
                    <h1><?php echo $totalAccounts; ?></h1>
                        <h3>Users</h3>
                    </div>
                    <div class="icon-case">
                        <br>
                        <img src="images/students.png" alt="">
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                    <h1><?php echo $totalOrderhandler; ?></h1>
                        <h3>Pendings</h3>
                    </div>
                    <div class="icon-case">
                        <img src="images/teachers.png" alt="">
                    </div>
                    <button class="button1" style="vertical-align:middle" onclick="window.location.href = 'riderpendings.php';"><span>View</span></button>
                </div>
                <div class="card">
                    <div class="box">
                        <h1><?php echo $totalRiderOrders; ?></h1>
                        <h3>Orders</h3>
                    </div>
                    <div class="icon-case">
                        <img src="images/schools.png" alt="">
                    </div>
                    <button class="button1" style="vertical-align:middle" onclick="window.location.href = 'riderorderview.php';"><span>View</span></button>
                </div>
                <div class="card">
                    <div class="box">
                    <h1><?php echo $totalPrice; ?>.00</h1>
                        <center><h3>Income</h3></center>
                    </div>
                    <div class="icon-case">
                        <img src="images/income.png" alt="">
                    </div>
                </div>
            </div>
            <div class="content-2">
                <div class="recent-payments">
                    <div class="title">
                        <h2>Recent Transactions</h2>
                        <button class="button1" style="vertical-align:middle" onclick="window.location.href = 'rider_recent_transaction.php';"><span>View</span></button>
                    </div>
                    <table>
                        <tr>
                            <th>Username</th>
                            <th>Pizza Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Order Locator</th>
                            <th>Order Status</th>
                        </tr>
                        <?php
    // Query to get orders with status "Finish Process"
    $sql_orders = "SELECT username, pizzaname, price, quantity, orderlocator, orderstatus FROM orderhandler WHERE orderstatus = 'Finish Process'";
    $result_orders = $conn->query($sql_orders);

    $counter = 0; // Initialize counter

    if ($result_orders->num_rows > 0) {
        // Output data of each row
        while ($row_orders = $result_orders->fetch_assoc()) {
            // Limit the display to the first 8 rows
            if ($counter >= 8) {
                break; // Exit the loop
            }

            echo "<tr>";
            echo "<td>" . $row_orders["username"] . "</td>";
            echo "<td>" . $row_orders["pizzaname"] . "</td>";
            echo "<td>" . $row_orders["price"] . "</td>";
            echo "<td>" . $row_orders["quantity"] . "</td>";
            echo "<td>" . $row_orders["orderlocator"] . "</td>";
            // Apply the style to the order status text
            echo "<td class='finish-process-text'>" . $row_orders["orderstatus"] . "</td>";
            echo "</tr>";

            $counter++; // Increment counter
        }
    } else {
        echo "<tr><td colspan='6'>No orders found.</td></tr>";
    }
?>
                    </table>
                </div>
                
    
</body>
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
                    </script>
                    <script>document.addEventListener('DOMContentLoaded', () => {
  var disclaimer =  document.querySelector("img[alt='www.000webhost.com']");
   if(disclaimer){
       disclaimer.remove();
   }  
 });
</script>
</html>