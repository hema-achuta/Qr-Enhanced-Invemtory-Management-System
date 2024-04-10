<?php
session_start(); 
$error=''; 

if (isset($_POST['submit'])) {
    if (empty($_POST['username']) || empty($_POST['password'])) {
        $error = "Username or Password is invalid";
    } else {
        // Define $username and $password
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        require 'connection.php';
        $conn = Connect();

        // SQL query to fetch information of registered shippers and finds user match.
        $query = "SELECT username, password FROM shippers WHERE username=? AND password=? LIMIT 1";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $stmt->bind_result($username, $password);
        $stmt->store_result();

        if ($stmt->fetch()) {
            $_SESSION['login_user3'] = $username; // Initializing Session
            header("location: myshipper.php"); // Redirecting To Shipper Page
        } else {
            $error = "Username or Password is invalid";
        }

        mysqli_close($conn); // Closing Connection
    }
}
?>
