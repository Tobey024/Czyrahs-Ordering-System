<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "czyrahs_db";

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

// Query to get total number of records from the "orderhandler" table
$sql_orderhandler = "SELECT COUNT(*) AS total_orderhandler FROM orderhandler";
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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
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
    background: #f05462;
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
    background: white;
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
        background: #f05462;
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
</style>
<body>
    <div class="side-menu">
        <div class="brand-name">
            <h1>Brand</h1>
        </div>
        <ul>
        <li><a href="#"><img src="images/dashboard (2).png" alt="">&nbsp; <span style="color:white;">Dashboard</span></a></li>
            <li><a href="#"><img src="images/reading-book (1).png" alt="">&nbsp;<span style="color:white;">Users</span> </a></li>
            <li><a href="#"><img src="images/teacher2.png" alt="">&nbsp;<span style="color:white;">Orders</span> </a></li>
            <li><a href="#"><img src="images/school.png" alt="">&nbsp;<span style="color:white;">History</span> </a></li>
            <li><a href="#"><img src="images/payment.png" alt="">&nbsp;<span style="color:white;">Income</span> </a></li>
            <li><a href="#"><img src="images/help-web-button.png" alt="">&nbsp; <span style="color:white;">Help</span></a></li>
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
                        <h3>Students</h3>
                    </div>
                    <div class="icon-case">
                    <img src="images/students.png" alt="">
                    </div>
                    <button class="button1" style="vertical-align:middle" onclick="window.location.href = 'admnusermanage.php';"><span>Edit</span></button>
                </div>
                <div class="card">
                    <div class="box">
                    <h1><?php echo $totalOrderhandler; ?></h1>
                        <h3>Teachers</h3>
                    </div>
                    <div class="icon-case">
                    <img src="images/teachers.png" alt="">
                    </div>
                    <button class="button1" style="vertical-align:middle" onclick="window.location.href = '#';"><span>Edit</span></button>
                </div>
                
                <div class="card">
                    <div class="box">
                    <h1><?php echo $totalMenu1; ?></h1>
                        <h3>Menu</h3>
                    </div>
                    <div class="icon-case">
                    <img src="images/schools.png" alt="">
                    </div>
                    <button class="button1" style="vertical-align:middle" onclick="window.location.href = '../userinterface/menumanage.php';"><span>Edit</span></button>
                </div>

                <div class="card">
                    <div class="box">
                        <h1>350000</h1>
                        <h3>Income</h3>
                    </div>
                    <div class="icon-case">
                    <img src="images/income.png" alt="">
                    </div>
                </div>
                
                <div class="card">
                    <div class="box">
                        <h1>350000</h1>
                        <h3>Income</h3>
                    </div>
                    <div class="icon-case">
                    <img src="images/income.png" alt="">
                    </div>
                </div>

                <div class="card">
                    <div class="box">
                        <h1>350000</h1>
                        <h3>Income</h3>
                    </div>
                    <div class="icon-case">
                    <img src="images/income.png" alt="">
                    </div>
                </div>

                <div class="card">
                    <div class="box">
                        <h1>350000</h1>
                        <h3>Income</h3>
                    </div>
                    <div class="icon-case">
                    <img src="images/income.png" alt="">
                    </div>
                </div>
            </div>
            
            
            
            
</body>

</html>
