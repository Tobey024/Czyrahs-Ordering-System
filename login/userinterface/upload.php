<?php
$conn = mysqli_connect("localhost", "u471532386_czyrahs", "24Starexified!", "u471532386_czyrahs_os");

if (isset($_POST["submit"])) {
    $target_dir = "uploads/";

    // Create the "uploads" directory if it doesn't exist
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a valid image
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";

        // Move the uploaded file to the "uploads" directory
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";

            // Retrieve other form data
            $pizzaName = $_POST["pizzaName"];
            $description = $_POST["description"];
            $price = $_POST["price"];

            // Use prepared statements to avoid SQL injection
            $stmt = $conn->prepare("INSERT INTO menu1 (image, PizzaName, Description, Price) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sssd", $target_file, $pizzaName, $description, $price);

            if ($stmt->execute()) {
                // Redirect to display.php
                echo "<script>alert('Record Added successfully'); window.location = 'menuadd.php';</script>";
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "File is not an image.";
    }
}

mysqli_close($conn);
?>