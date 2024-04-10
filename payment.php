<!DOCTYPE html>
<html>

<head>
    <title>IMS | Inventory Management with QR <i class="fa fa-qrcode" aria-hidden="true"></i> </title>
    <link rel="stylesheet" type="text/css" href="css/payment.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik+Vinyl&display=swap" rel="stylesheet">
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
                <a class="navbar-brand" href="index.php" style="font-size:;">IMS</a>
            </div>

            <div class="collapse navbar-collapse " id="myNavbar">
                <ul class="nav navbar-nav">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="aboutus.php">About</a></li>
                    <li><a href="contactus.php">Contact Us</a></li>
                </ul>

                <!-- Your PHP code for user authentication -->

            </div>
        </div>
    </nav>

    <div class="container">
        <div class="jumbotron">
            <h1>Enter Location Details</h1>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="state">State:</label>
                    <input type="text" class="form-control" id="state" name="state" required>
                </div>
                <div class="form-group">
                    <label for="district">District:</label>
                    <input type="text" class="form-control" id="district" name="district" required>
                </div>
                <div class="form-group">
                    <label for="pincode">Pincode:</label>
                    <input type="text" class="form-control" id="pincode" name="pincode" required>
                </div>
                <div class="form-group">
                    <label for="dno">Door Number:</label>
                    <input type="text" class="form-control" id="dno" name="dno" required>
                </div>
                <button type="submit" class="btn btn-primary" name="submit_location">Submit Location Details</button>
            </form>
        </div>
    </div>

    <?php
    session_start();
    require 'connection.php';
    $conn = Connect();
    if (!isset($_SESSION['login_user2'])) {
        header("location: customerlogin.php");
    }
    $gtotal = 0;
    foreach ($_SESSION["cart"] as $keys => $values) {
        $F_ID = $values["food_id"];
        $foodname = $values["food_name"];
        $quantity = $values["food_quantity"];
        $price =  $values["food_price"];
        $total = ($values["food_quantity"] * $values["food_price"]);
        $R_ID = $values["R_ID"];
        $username = $_SESSION["login_user2"];
        $order_date = date('Y-m-d');

        $gtotal = $gtotal + $total;

    // Check if the location details form is submitted
    if (isset($_POST['submit_location'])) {
        // Retrieve location details from the form
        $state = $_POST['state'];
        $district = $_POST['district'];
        $pincode = $_POST['pincode'];

        // Store location details in the session for further processing
        $_SESSION['location_details'] = array(
            'state' => $state,
            'district' => $district,
            'pincode' => $pincode,
        );

     

            $query = "INSERT INTO ORDERS (F_ID, foodname, price, quantity, order_date, username, R_ID, state, district, pincode) 
                    VALUES ('$F_ID', '$foodname', '$price', '$quantity', '$order_date', '$username', '$R_ID', '$state', '$district', '$pincode')";

            $success = $conn->query($query);

            if (!$success) {
    ?>
                <div class="container">
                    <div class="jumbotron">
                        <h1>Something went wrong!</h1>
                        <p>Try again later.</p>
                    </div>
                </div>
    <?php
            }
        }
    }
    ?>

    <!-- Your HTML code for displaying payment options -->
    <!-- Payment options -->


    <div class="container">
        <div class="jumbotron">
            <h1>Choose your payment option</h1>
        </div>
    </div>
    <br>
    <h1 class="text-center">Grand Total: &#8377;<?php echo "$gtotal"; ?>/-</h1>
    <h5 class="text-center">including all service charges. (no delivery charges applied)</h5>
    <br>
    <h1 class="text-center">
        <a href="cart.php"><button class="btn btn-warning"><span class="glyphicon glyphicon-circle-arrow-left"></span> Go back to cart</button></a>
        <a href="onlinepay.php"><button class="btn btn-success"><span class="glyphicon glyphicon-credit-card"></span> Pay Online</button></a>
        <a href="789.php"><button class="btn btn-success"><span class="glyphicon glyphicon-"></span> Cash On Delivery</button></a>
    </h1>



    <br><br><br><br><br><br>
</body>

</html>


    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
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
</body>

</html>
