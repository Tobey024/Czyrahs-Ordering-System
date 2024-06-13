<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the content from the POST data
    $content = $_POST['content'];

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
