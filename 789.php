<?php
session_start();
require 'connection.php';
require 'phpqrcode/qrlib.php'; // Include the QR code library

// Check if the user is logged in
if (!isset($_SESSION['login_user2'])) {
    header("location: customerlogin.php");
    exit(); // Exit to avoid execution if not logged in
}

// Establish database connection
$conn = Connect();

// Retrieve the username from session
$username = $_SESSION['login_user2'];

// Fetch the generated_code for the given username
$query = "SELECT generated_code FROM customer WHERE username = '$username'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $generatedCode = $row['generated_code'];

    // Generate QR code using the fetched generated_code
    $qrCodeFilePath = "qrcodes/$username.png"; // File path to save the QR code image
    QRcode::png($generatedCode, $qrCodeFilePath);
} else {
    echo "No QR code found for the specified username.";
}

// Close database connection
$conn->close();
?>

<html>
<head>
    <title>IMS with QR</title>
</head>
<link rel="stylesheet" type="text/css" href="css/COD.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<body>
    <button onclick="topFunction()" id="myBtn" title="Go to top">
        <span class="glyphicon glyphicon-chevron-up"></span>
    </button>

    <script type="text/javascript">
        window.onscroll = function() {
            scrollFunction()
        };

        function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                document.getElementById("myBtn").style.display = "block";
            } else {
                document.getElementById("myBtn").style.display = "none";
            }
        }

        function topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
    </script>

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

            <div class="collapse navbar-collapse " id="myNavbar">
                <ul class="nav navbar-nav">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="aboutus.php">About</a></li>
                    <li><a href="contactus.php">Contact Us</a></li>
                </ul>

                <?php
                if (isset($_SESSION['login_user1'])) {
                ?>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $_SESSION['login_user1']; ?> </a></li>
                        <li><a href="myrestaurant.php">MANAGER CONTROL PANEL</a></li>
                        <li><a href="logout_m.php"><span class="glyphicon glyphicon-log-out"></span> Log Out </a></li>
                    </ul>
                <?php
                } else if (isset($_SESSION['login_user2'])) {
                ?>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $_SESSION['login_user2']; ?> </a></li>
                        <li><a href="foodlist.php"><span class="glyphicon glyphicon-cutlery"></span> Products Zone </a></li>
                        <li><a href="cart.php"><span class="glyphicon glyphicon-shopping-cart"></span> Cart
                                (<?php
                                if (isset($_SESSION["cart"])) {
                                    $count = count($_SESSION["cart"]);
                                    echo "$count";
                                } else
                                    echo "0";
                                ?>)
                            </a></li>
                        <li><a href="logout_u.php"><span class="glyphicon glyphicon-log-out"></span> Log Out </a></li>
                    </ul>
                <?php
                } else {
                ?>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> Sign Up <span class="caret"></span> </a>
                            <ul class="dropdown-menu">
                                <li> <a href="customersignup.php"> User Sign-up</a></li>
                                <li> <a href="managersignup.php"> Manager Sign-up</a></li>
                                <li> <a href="#"> Admin Sign-up</a></li>
                            </ul>
                        </li>
                        <li><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-log-in"></span> Login <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li> <a href="customerlogin.php"> User Login</a></li>
                                <li> <a href="managerlogin.php"> Manager Login</a></li>
                                <li> <a href="#"> Admin Login</a></li>
                            </ul>
                        </li>
                    </ul>
                <?php
                }
                ?>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="jumbotron">
            <h1 class="text-center" style="color: green;"><span class="glyphicon glyphicon-ok-circle"></span> Request Sent Successfully.</h1>
        </div>
    </div>
    <br>

    <h2 class="text-center">Scan the QR below to Track your order details.</h2>

    <?php 
    $num1 = rand(100000,999999); 
    $num2 = rand(100000,999999); 
    $num3 = rand(100000,999999);
    $number = $num1.$num2.$num3;
    ?>

    <h3 class="text-center"> <strong>Your Order Number:</strong> <span style="color: blue;"><?php echo "$number"; ?></span> </h3>
    
    <!-- QR code display -->
    <div class="text-center qr-code-container">
        <?php
        // Display the QR code image if available
        if (isset($qrCodeFilePath)) {
            echo '<img src="' . $qrCodeFilePath . '" id="qrImg" alt="QR Code">';
        }
        ?>
    </div>

    <!-- Add View Status button here -->
    <div class="text-center">
        <form action="view_action_status.php" method="POST">
            <button type="submit" class="btn btn-primary">View Status</button>
        </form>
    </div>
</body>
</html>
