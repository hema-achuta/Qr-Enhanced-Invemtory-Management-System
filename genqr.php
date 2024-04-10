<?php

// Include the qrlib file
include 'phpqrcode/qrlib.php';

// Function to generate QR code from PHP file output
function generateQRCodeFromPHPFile($phpFileName) {
    // Start output buffering
    ob_start();

    // Include the PHP file
    include $phpFileName;

    // Get the captured output
    $phpFileOutput = ob_get_clean();

    // Set the appropriate header for image output
    header('Content-Type: image/png');

    // Generate and output QR code using PHP file output
    QRcode::png($phpFileOutput);
}

// PHP file name
$phpFileName = 'view_action_status.php'; // Change this to your PHP file name

// Generate QR code from PHP file output and display it in the browser
generateQRCodeFromPHPFile($phpFileName);

?>
