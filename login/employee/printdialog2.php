<?php
// Service fee
$serviceFee = 40;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the content from the POST data
    $content = $_POST['content'];

    // Add the service fee to the total price
    $totalPriceStartPos = strpos($content, '<strong>Total Price:</strong> ₱') + strlen('<strong>Total Price:</strong> ₱');
    $totalPriceEndPos = strpos($content, '</td>', $totalPriceStartPos);
    $totalPrice = substr($content, $totalPriceStartPos, $totalPriceEndPos - $totalPriceStartPos);
    $totalPrice = floatval($totalPrice) + $serviceFee;
    $content = str_replace('<strong>Total Price:</strong> ₱' . substr($content, $totalPriceStartPos, $totalPriceEndPos - $totalPriceStartPos), '<strong>Total Price:</strong> ₱' . $totalPrice, $content); // Update the total price in the content

    // Return the content without the print dialog
    echo '<html><head><title>Order Receipt</title></head><body>' . $content . '</body></html>';
}
?>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        var disclaimer = document.querySelector("img[alt='www.000webhost.com']");
        if (disclaimer) {
            disclaimer.remove();
        }
    });
</script>
