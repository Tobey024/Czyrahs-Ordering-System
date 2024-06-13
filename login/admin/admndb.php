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

// Query to get total number of records from the "menu1" table
$sql_menu1 = "SELECT COUNT(*) AS total_menu1 FROM menu1";
$result_menu1 = $conn->query($sql_menu1);

if ($result_orderhandler->num_rows > 0) {
    // Fetch the total number of records from the "menu1" table
    $row_menu1 = $result_menu1->fetch_assoc();
    $totalMenu1 = $row_menu1["total_menu1"];
} else {
    $totalMenu1 = 0;
}

// Query to get the last 5 records from the "accounts" table
$sql = "SELECT username, email, contact FROM accounts ORDER BY id DESC LIMIT 5";
$result = $conn->query($sql);

// Query to get the total amount from orderhandler table for orders with "Finish Process" status
$sql = "SELECT SUM(Price * Quantity) AS totalAmount FROM orderhandler WHERE OrderStatus = 'Finish Process'";
$result = $conn->query($sql);

$totalAmount = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalAmount = $row['totalAmount'];
}

// Query to get the total price of orders with status "Finish Process" from the "pos" table
$sql_total_price_pos = "SELECT SUM(price * quantity) AS total_price_pos FROM pos WHERE orderstatus = 'Finish Process'";
$result_total_price_pos = $conn->query($sql_total_price_pos);

if ($result_total_price_pos->num_rows > 0) {
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
    <title>Admin Panel</title>
    <link rel="icon" type="image/png" href="pizzatitle.png">
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
    background: green;
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

.side-menu li:hover {
    background: darkgreen;
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

.container .content .content-2{
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
        background: darkgreen;
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
        <div class="loading-text">Admin</div>
        <div class="spinner"></div>
    </div>
    <div class="side-menu">
        <div class="brand-name">
        </div>
        <ul>
        <li><a href="admndb.php"><img src="images/dashboard (2).png" alt="">&nbsp; <span style="color:white;">Dashboard</span></a></li>
            <li><a href="admnusermanage.php"><img src="images/reading-book (1).png" alt="">&nbsp;<span style="color:white;">Users</span> </a></li>
            <li><a href="menumanage.php"><img src="images/menu2.png" alt="">&nbsp;<span style="color:white;">Menu</span> </a></li>
            <li><a href="webincome.php"><img src="images/info2.png" alt="">&nbsp;<span style="color:white;">Recent</span> </a></li>
            <li><a href="Income.php"><img src="images/payment.png" alt="">&nbsp;<span style="color:white;">Income</span> </a></li>
            <li><a href="feedbacks.php"><img src="images/feedbacc2.png" alt="">&nbsp;<span style="color:white;">Feedbacks</span> </a></li>
            <li><a href="logout.php"><img src="images/logout.png" alt="">&nbsp;<span style="color:white;">Logout</span></a> </li>
        </ul>
    </div>
    <div class="container">
        <div class="header">
            <div class="nav">
                <h1>Admin Dashboard</h1>
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
                    <img src="images/students1.png" alt="">
                    </div>
                    <button class="button1" style="vertical-align:middle" onclick="window.location.href = 'admnusermanage.php';"><span>Edit</span></button>
                </div>
                <div class="card">
                    <div class="box">
                    <h1><?php echo $totalOrderhandler; ?></h1>
                        <h3>Orders</h3>
                    </div>
                    <div class="icon-case">
                    <img src="images/teachers1.png" alt="">
                    </div>
<button class="button1" style="vertical-align:middle" onclick="window.location.href = 'orderspendingadmin.php';"><span>Edit</span></button>
                </div>
                
                <div class="card">
                    <div class="box">
                    <h1><?php echo $totalMenu1; ?></h1>
                        <h3>Menu</h3>
                    </div>
                    <div class="icon-case">
                    <img src="images/menu.png" alt="">
                    </div>
                    <button class="button1" style="vertical-align:middle" onclick="window.location.href = '../userinterface/menumanage.php';"><span>Edit</span></button>
                </div>

                <div class="card">
                    <div class="box">
                    <h1>₱<?php echo $totalAmount; ?></h1>
                        <h3>Web Income</h3>
                    </div>
                    <div class="icon-case">
                    <img src="images/income1.png" alt="">
                    </div>
                    <button class="button1" style="vertical-align:middle" onclick="window.location.href = 'webincome.php';"><span>Edit</span></button>
                </div>
                
                <div class="card">
                    <div class="box">
                    <h1>₱<?php echo $totalPricePos; ?></h1>
                        <h3>Income</h3>
                    </div>
                    <div class="icon-case">
                    <img src="images/income1.png" alt="">
                    </div>
                    <button class="button1" style="vertical-align:middle" onclick="window.location.href = 'Income.php';"><span>Edit</span></button>
                </div>
</div>
<div class="recent-payments">
    <div class="title">
        <h2>Most Ordered Pizza</h2>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="chart-container">
                <canvas id="pieChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<?php
// Query to get the pizza names and total quantities
$sql = "SELECT pizzaname, SUM(quantity) AS total_quantity FROM orderhandler GROUP BY pizzaname";
$result = $conn->query($sql);

// Store the data in an array
$data = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = array(
            'label' => $row["pizzaname"],
            'value' => $row["total_quantity"]
        );
    }
}

// Convert the data array to JSON format for JavaScript
$jsonData = json_encode($data);
?>

<script>
// Get the JSON data from PHP
var jsonData = <?php echo $jsonData; ?>;

// Create the pie chart
var ctx = document.getElementById('pieChart').getContext('2d');
var pieChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: jsonData.map(function(item) { return item.label; }),
        datasets: [{
            data: jsonData.map(function(item) { return item.value; }),
            backgroundColor: [
                '#FF6384',
                '#36A2EB',
                '#FFCE56',
                '#7F8C8D',
                '#E74C3C',
                '#9B59B6'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});
</script>

<style>
    .chart-container {
        position: relative;
        width: 100%;
        max-width: 1000px;
        margin: 0 auto;
    }

    .chart-container > canvas {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }

    @media only screen and (max-width: 600px) {
        .chart-container > canvas {
            width: 90%;
            height: 90%;
        }
    }

    @media only screen and (max-width: 400px) {
        .chart-container > canvas {
            width: 80%;
            height: 80%;
        }
    }

    @media only screen and (max-width: 300px) {
        .chart-container > canvas {
            width: 70%;
            height: 70%;
        }
    }
</style>


            
            
            
            
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
