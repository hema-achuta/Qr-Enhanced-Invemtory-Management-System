<?php

require 'connection.php';
include 'phpqrcode/qrlib.php';

// Establish database connection
$conn = Connect();

// Check if username is provided via GET method
if(isset($_GET['username'])) {
    // Get username from URL query parameters
    $username = $conn->real_escape_string($_GET['username']);

    // Fetch the generated_code for the given username
    $query = "SELECT generated_code FROM customer WHERE username = '$username'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $generatedCode = $row['generated_code'];

        // Generate QR code using the fetched generated_code
        $qrCodeContent = "Generated Code: $generatedCode";
        QRcode::png($qrCodeContent);
        exit; // Exit to prevent HTML output
    } else {
        echo "No QR code found for the specified username.";
    }
} else {
    echo "Error: Username is required.";
}

// Close database connection
$conn->close();

?>
