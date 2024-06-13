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

// Query to get total number of records from the "accounts" table
$sql_accounts = "SELECT COUNT(*) AS total_accounts FROM accounts";
$result_accounts = $conn->query($sql_accounts);

$totalAccounts = 0;
if ($result_accounts && $result_accounts->num_rows > 0) {
    // Fetch the total number of records from the "accounts" table
    $row_accounts = $result_accounts->fetch_assoc();
    $totalAccounts = $row_accounts["total_accounts"];
}

// Query to get total number of records from the "orderhandler" table with specific statuses
$sql_orderhandler = "SELECT COUNT(*) AS total_orderhandler FROM orderhandler WHERE orderstatus IN ('On Checking', 'Accept Order', 'Preparing Order', 'Delivery')";
$result_orderhandler = $conn->query($sql_orderhandler);

$totalOrderhandler = 0;
if ($result_orderhandler && $result_orderhandler->num_rows > 0) {
    // Fetch the total number of records from the "orderhandler" table
    $row_orderhandler = $result_orderhandler->fetch_assoc();
    $totalOrderhandler = $row_orderhandler["total_orderhandler"];
}

// Query to get total number of records from the "menu1" table
$sql_menu1 = "SELECT COUNT(*) AS total_menu1 FROM menu1";
$result_menu1 = $conn->query($sql_menu1);

$totalMenu1 = 0;
if ($result_menu1 && $result_menu1->num_rows > 0) {
    // Fetch the total number of records from the "menu1" table
    $row_menu1 = $result_menu1->fetch_assoc();
    $totalMenu1 = $row_menu1["total_menu1"];
}

// Query to get the last 5 records from the "accounts" table
$sql = "SELECT username, email, contact FROM accounts ORDER BY id DESC LIMIT 5";
$result = $conn->query($sql);

// Query to get the total price of orders with status "Finish Process"
$sql_total_price = "SELECT SUM(totalprice) AS total_price FROM orderhandler WHERE orderstatus = 'Finish Process'";
$result_total_price = $conn->query($sql_total_price);

$totalPrice = 0;
if ($result_total_price && $result_total_price->num_rows > 0) {
    // Fetch the total price
    $row_total_price = $result_total_price->fetch_assoc();
    $totalPrice = $row_total_price["total_price"];
}

// Query to get the count of 'Pending' and 'Cooking' orders from the 'pos' table
$sql_pos = "SELECT COUNT(*) AS total_pos FROM pos WHERE orderstatus IN ('Pending', 'Cooking')";
$result_pos = $conn->query($sql_pos);

$totalPos = 0;
if ($result_pos && $result_pos->num_rows > 0) {
    // Fetch the total count of 'Pending' and 'Cooking' orders from the 'pos' table
    $row_pos = $result_pos->fetch_assoc();
    $totalPos = $row_pos["total_pos"];
}

$username = $_SESSION['username']; // Assuming $_SESSION['username'] contains the username of the logged-in user
$sql_total_price_pos = "SELECT SUM(price * quantity) AS total_price_pos FROM pos WHERE orderstatus = 'Finish Process' AND user = '$username'";
$result_total_price_pos = $conn->query($sql_total_price_pos);

if ($result_total_price_pos && $result_total_price_pos->num_rows > 0) {
    // Fetch the total price from the "pos" table
    $row_total_price_pos = $result_total_price_pos->fetch_assoc();
    $totalPricePos = $row_total_price_pos["total_price_pos"];
} else {
    $totalPricePos = 0;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Panel</title>
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
    color: #444;
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
    background: #212529;
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
.side-menu li:hover {
    background: #373d45;
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

.container .header .nav h1{
    width: 100%;
    display: flex;
    align-items: center;
}

.container .header .nav .search h1{
    flex: 3;
    display: flex;
    justify-content: center;
}

.container .header .nav .search input[type=text] h1{
    border: none;
    background: #f1f1f1;
    padding: 10px;
    width: 50%;
}

.container .header .nav .search button h1{
    width: 40px;
    height: 40px;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
}

.container .header .nav .search button img h1{
    width: 30px;
    height: 30px;
}

.container .header .nav .user h1{
    flex: 1;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.container .header .nav .user img h1{
    width: 40px;
    height: 40px;
}

.container .header .nav .user .img-case h1{
    position: relative;
    width: 50px;
    height: 50px;
}

.container .header .nav .user .img-case img h1{
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
    min-height: 50vh;
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
        background: #373d45;
        padding: 8px 38px;
        border: 2px solid white;
    }
}

@media screen and (max-width:536px) {
    .brand-name h1 {
        font-size: 16px;
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
    background-color: #1c1f23;
    text-align:center;
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
            border-top: 5px solid black;
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
        <div class="loading-text">Employee...</div>
        <div class="spinner"></div>
    </div>
    <div class="side-menu">
        <div class="brand-name">
        </div>
        <ul>
            <li><a href="#"><img src="images/dashboard (2).png" alt="">&nbsp; <span>Dashboard</span></a></li>
            <li><a href="posinterface.php"><img src="images/pos.png" alt="">&nbsp;<span>P.O.S</span> </a></li>
            <li><a href="employee_view_data.php"><img src="images/payment.png" alt="">&nbsp;<span>History</span> </a></li>
            <li><a href="logout.php"><img src="images/logout.png" alt="">&nbsp;<span>Logout</span></a> </li>
        </ul>
    </div>
    <div class="container">
        <div class="header">
        <center><h2>Employee Dashboard</h2>
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
                        <h3>Orders</h3>
                    </div>
                    <div class="icon-case">
                        <img src="images/teachers.png" alt="">
                    </div>

                </div>
                <div class="card">
                    <div class="box">
                    <h1><?php echo $totalPos; ?></h1>

                        <h3>P.O.S</h3>
                    </div>
                    <div class="icon-case">
                        <img src="images/schools.png" alt="">
                    </div>
                    <button class="button1" style="vertical-align:middle" onclick="window.location.href = 'posinterface.php';"><span>View</span></button>
                </div>
                <div class="card">
                    <div class="box">
                    <h1>₱<?php echo $totalPricePos; ?>.00</h1>
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
                        <button class="button1" style="vertical-align:middle" onclick="window.location.href = 'employee_view_data.php';"><span>View</span></button>
                    </div>
                    <table>
                        <tr>
                            <th>Username</th>
                            <th>Pizza Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Order Status</th>
                        </tr>
                        <?php
            // Query to get all data from the "pos" table excluding 'Pending' and 'Cooking' statuses
            $sql_pos_data = "SELECT * FROM pos WHERE orderstatus NOT IN ('Pending', 'Cooking') LIMIT 8";

            $result_pos_data = $conn->query($sql_pos_data);

            if ($result_pos_data->num_rows > 0) {
                while ($row_pos_data = $result_pos_data->fetch_assoc()) {
                    // Output the data in table rows
                    echo "<tr>";
                    echo "<td>" . $row_pos_data["user"] . "</td>";
                    echo "<td>" . $row_pos_data["pizzaname"] . "</td>";
                    echo "<td>" . $row_pos_data["price"] . "</td>";
                    echo "<td>" . $row_pos_data["quantity"] . "</td>";
                    echo "<td class='finish-process-text'>" . $row_pos_data["orderstatus"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No data found.</td></tr>";
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
</html>