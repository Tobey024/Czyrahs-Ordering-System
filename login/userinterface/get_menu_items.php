<?php
session_start(); // Start the session

// Check if the user is not logged in or does not have the 'User', 'Admin', or 'Employee' type
if (!isset($_SESSION['username']) || ($_SESSION['type'] != 'User' && $_SESSION['type'] != 'Admin')) {
    // Redirect to the login page
    header("Location: ../logout.php");
    exit();
}

$servername = "localhost";
$username_db = "u471532386_czyrahs";
$password_db = "24Starexified!";
$dbname = "u471532386_czyrahs_os";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM menu1 ORDER BY id"; // Assuming 'id' is the column for item IDs
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $counter = 0; // Initialize counter
    // Start container
    echo '<div class="container">';
    // Output data of each row
    while ($row = mysqli_fetch_array($result)) {
        if ($counter % 5 == 0) {
            // Start a new row
            echo '<div class="row justify-content-center">';
        }
        echo '<div class="box col-md-2">'; // Assuming each item takes 2 columns on medium devices
        echo '<img src="' . $row['image'] . '" class="img-fluid" alt="Image">';
        echo '<div class="box-content">';
        echo '<h5>' . $row["PizzaName"] . '</h5>';
        echo '<div class="line"></div>'; // Add this line
        echo '<b class="price">Price: ₱' . $row["Price"] . '</b>';
        echo '<div class="line"></div>'; // Add this line
        echo '<p>' . $row["Description"] . '</p>';

        // Add the form and add-to-cart button
        echo '<form method="post" class="add-to-cart-form">';
        echo '<input type="hidden" name="pizza_name" value="' . $row["PizzaName"] . '">';
        echo '<input type="hidden" name="pizza_price" value="' . $row["Price"] . '">';
        echo '<button type="submit" name="add_to_cart" class="btn btn-primary add-to-cart-btn">Add to Cart     <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: white;transform: ;msFilter:;"><path d="M18.5 2h-12C4.57 2 3 3.57 3 5.5V22l7-3.5 7 3.5v-9h5V5.5C22 3.57 20.43 2 18.5 2zM15 18.764l-5-2.5-5 2.5V5.5C5 4.673 5.673 4 6.5 4h8.852A3.451 3.451 0 0 0 15 5.5v13.264zM20 11h-3V5.5c0-.827.673-1.5 1.5-1.5s1.5.673 1.5 1.5V11z"></path><path d="M11 7H9v2H7v2h2v2h2v-2h2V9h-2z"></path></svg></span></button>';
        echo '</form>';

        echo '</div>';
        echo '</div>';

        $counter++; // Increment counter
        if ($counter % 5 == 0) {
            // End the row after 5 items
            echo '</div>';
        }
    }
    if ($counter % 5 != 0) {
        // If there are fewer than 5 items in the last row, close the row
        echo '</div>';
    }
    // End container
    echo '</div>';
} else {
    echo "0 results";
}

$conn->close();
?>
