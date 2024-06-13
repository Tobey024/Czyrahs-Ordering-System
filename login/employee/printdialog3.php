<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the content from the POST data
    $content = $_POST['content'];

    // Display the content for printing
    echo '<html><head><title>Print Earnings</title></head><body onload="window.print();">' . $content . '</body></html>';

    // Exit the script to prevent any additional output
    exit();
}
?>
