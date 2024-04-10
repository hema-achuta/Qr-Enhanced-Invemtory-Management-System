<?php
require 'connection.php'; // Include the database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $generated_code = $_POST['qr-code']; // Get the generated code from the scanned QR code

    // Prepare SQL query to select the username and password from the CUSTOMER table where generated_code matches
    $query = "SELECT username, password FROM CUSTOMER WHERE generated_code=? LIMIT 1";

    // Establish database connection
    $conn = Connect();

    // Prepare the SQL statement
    $stmt = $conn->prepare($query);

    // Bind the generated code parameter
    $stmt->bind_param("s", $generated_code);

    // Execute the query
    $stmt->execute();

    // Bind the result variables
    $stmt->bind_result($username, $password);

    // Store the result
    $stmt->store_result();

    // Check if a row is fetched (if the generated code is found)
    if ($stmt->fetch()) {
        session_start();
        $_SESSION['login_user2'] = $username; // Initialize Session with the username
        header("location: view_action_status.php"); // Redirect to the desired page after successful login
    } else {
        $error = "Generated code is invalid"; // Set error message if the generated code is not found in the database
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
