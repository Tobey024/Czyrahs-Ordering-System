<?php
session_start(); // Start the session

$servername = "localhost";
$username_db = "u471532386_czyrahs";
$password_db = "24Starexified!";
$dbname = "u471532386_czyrahs_os";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST['id'];
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $birthday = $_POST['birthday'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];

    // Check if email, contact, or username already exist
    $check_query = "SELECT * FROM accounts WHERE (email=? OR contact=?) AND username != ?";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bind_param("sss", $email, $contact, $_SESSION['username']);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        // Send back an error message indicating what already exists
        $existing_data = $result->fetch_assoc();
        $existing_email = $existing_data['email'] == $email ? "Email already exists. " : "";
        $existing_contact = $existing_data['contact'] == $contact ? "Contact already exists. " : "";
        echo $existing_email . $existing_contact;
        exit();
    }

    // Check if the contact number is exactly 11 digits
    if (strlen($contact) !== 11) {
        echo "Contact number should be 11 digits.";
        exit();
    }

    // Check if any data has changed
    $select_query = "SELECT * FROM accounts WHERE id=?";
    $select_stmt = $conn->prepare($select_query);
    $select_stmt->bind_param("i", $userId);
    $select_stmt->execute();
    $result = $select_stmt->get_result();
    $row = $result->fetch_assoc();

    if (
        $fname == $row['fname'] &&
        $mname == $row['mname'] &&
        $lname == $row['lname'] &&
        $email == $row['email'] &&
        $birthday == $row['birthday'] &&
        $address == $row['address'] &&
        $contact == $row['contact'] &&
        empty($password)
    ) {
        echo "Nothing has changed.";
        exit();
    }

    // Update the user profile
    $update_query = "UPDATE accounts SET fname=?, mname=?, lname=?, email=?, password=?, birthday=?, address=?, contact=? WHERE id=?";
    $update_stmt = $conn->prepare($update_query);

    // Check if the password field is empty
    if (empty($password)) {
        // If the password field is empty, do not update the password
        $update_stmt->bind_param("ssssssssi", $fname, $mname, $lname, $email, $row['password'], $birthday, $address, $contact, $userId);
    } else {
        // If the password field is not empty, hash the password and update
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $update_stmt->bind_param("ssssssssi", $fname, $mname, $lname, $email, $hashed_password, $birthday, $address, $contact, $userId);
    }

    $update_stmt->execute();

    if ($update_stmt->affected_rows > 0) {
        echo "Success";
    } else {
        echo "Failed to update profile. Please try again.";
    }
}

$conn->close();
?>
