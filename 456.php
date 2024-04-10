<?php

require 'connection.php';

// Function to generate a random string
function generateRandomCode($length) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomIndex = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$randomIndex];
    }

    return $randomString;
}

// Function to generate QR code from username and password and return the random string
function generateAndSaveQRCode($username, $password, $conn) {
    // Construct the content for the QR code
    $content = "Username: $username\nPassword: $password";

    // Generate a random string as the QR code
    $randomString = generateRandomCode(10);

    // Update the generated_code column in the customer table
    $updateQuery = "UPDATE customer SET generated_code = '$randomString' WHERE username = '$username'";
    $conn->query($updateQuery);

    // Return the random string
    return $randomString;
}

// Establish database connection
$conn = Connect();

// Check if username and password are provided via POST method
if(isset($_POST['username']) && isset($_POST['password'])) {
    // Get username and password from POST data
    $fullname = $conn->real_escape_string($_POST['fullname']);
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $contact = $conn->real_escape_string($_POST['contact']);
    $address = $conn->real_escape_string($_POST['address']);
    $password = $conn->real_escape_string($_POST['password']);

    // Generate and save QR code using provided username and password
    $randomString = generateAndSaveQRCode($username, $password, $conn);

    // Insert customer data into the database
    $query = "INSERT INTO customer (fullname, username, email, contact, address, password, generated_code) VALUES ('$fullname', '$username', '$email', '$contact', '$address', '$password', '$randomString')";
    $success = $conn->query($query);

    if (!$success){
        die("Couldn't enter data: " . $conn->error);
    }
} else {
    // If username and/or password are not provided, display an error message
    echo "Error: Username and password are required.";
}

// Close database connection
$conn->close();

?>

<html>
<head>
    <title>Manager Login | IMS with QR</title>
    <link rel="stylesheet" type="text/css" href="css/manager_registered_success.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
</head>
<body>
    <button onclick="topFunction()" id="myBtn" title="Go to top">
        <span class="glyphicon glyphicon-chevron-up"></span>
    </button>

    <nav class="navbar navbar-inverse navbar-fixed-top navigation-clean-search" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#myNavbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">IMS</a>
            </div>

            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="index.php">Home</a></li>
                    <li><a href="aboutus.php">About</a></li>
                    <li><a href="contactus.php">Contact Us</a></li>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up </a></li>
                    <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login </a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="jumbotron" style="text-align: center;">
            <h2><?php echo "Welcome $fullname!" ?></h2>
            <h1>Your account has been created.</h1> 
            <p>Login Now from <a href="customerlogin.php">HERE</a></p>
        </div>
    </div>
</body>
</html>
