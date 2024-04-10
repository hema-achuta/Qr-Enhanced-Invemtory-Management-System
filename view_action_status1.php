<?php
include('session_s.php');

if (!isset($login_session)) {
    header('Location: shipperlogin.php');
}

// Check if the "Shipped" button is clicked
if (isset($_POST['shipped_btn'])) {
    // Get the order ID from the submitted form
    $order_id = $_POST['order_id'];

    // Update the action status to 2 in the orders table
    $update_query = "UPDATE orders SET action_status = 2 WHERE order_ID = '$order_id'";
    $result_update = mysqli_query($conn, $update_query);

    if (!$result_update) {
        echo "Error updating action status: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Shipper Control Panel | IMS</title>
    <link rel="stylesheet" type="text/css" href="css/myrestaurant.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>

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

                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $login_session; ?> </a></li>
                    <li><a href="shipperlogin.php">MANAGER CONTROL PANEL</a></li>
                    <li><a href="logout_s.php"><span class="glyphicon glyphicon-log-out"></span> Log Out </a></li>
                </ul>
            </div>

        </div>
    </nav>

    <div class="container">
        <div class="jumbotron">
            <h1>Hello Shipper!</h1>
            <p>View orders </p>
        </div>
    </div>

    <div class="container">
        <div class="container">
            <div class="col">
            </div>
        </div>

        <div class="col-xs-3" style="text-align: center;">
            <div class="list-group">
                <a href="view_shippers.php" class="list-group-item ">View Shippers</a>
                <a href="add_shipper.php" class="list-group-item ">Add Shipper</a>
                <a href="edit_shipper.php" class="list-group-item ">Edit Shipper</a>
                <a href="delete_shipper.php" class="list-group-item ">Delete Shipper</a>
            </div>
        </div>

        <div class="col-xs-9">
            <div class="form-area" style="padding: 0px 100px 100px 100px;">
                <form action="" method="POST">
                    <br style="clear: both">
                    <h3 style="margin-bottom: 25px; text-align: center; font-size: 30px;">ORDERS</h3>

                    <?php
                    // Retrieve A_ID and S_ID from agency table based on the logged in shipper
                    $shipper_id = $login_session; // Assuming $login_session contains the shipper's ID
                    $query_agency = "SELECT A_ID, S_ID FROM agency WHERE S_ID = '$shipper_id'";
                    $result_agency = mysqli_query($conn, $query_agency);
                    $row_agency = mysqli_fetch_assoc($result_agency);
                    $agency_id = $row_agency['A_ID'];

                    // Retrieve all locations from the location table for the particular agency and shipper ID
                    $query_locations = "SELECT * FROM location WHERE A_ID = '$agency_id' AND S_ID = '$shipper_id'";
                    $result_locations = mysqli_query($conn, $query_locations);

                    // Initialize an empty array to store location details
                    $locations = array();

                    // Fetch all location details and store them in the locations array
                    while ($row_location = mysqli_fetch_assoc($result_locations)) {
                        $locations[] = array(
                            'state' => $row_location['state'],
                            'district' => $row_location['district'],
                            'pincode' => $row_location['pincode']
                        );
                    }

                    // Query to fetch orders for the desired location(s)
                    $query_orders = "SELECT * FROM orders WHERE (";

                    // Construct the WHERE clause to match orders with any of the given locations
                    foreach ($locations as $index => $location) {
                        $state = $location['state'];
                        $district = $location['district'];
                        $pincode = $location['pincode'];
                        $query_orders .= " (state = '$state' AND district = '$district' AND pincode = '$pincode') ";

                        // If it's not the last location, add OR between conditions
                        if ($index < count($locations) - 1) {
                            $query_orders .= " OR ";
                        }
                    }

                    $query_orders .= ") AND action_status = 1";
                    $result_orders = mysqli_query($conn, $query_orders);

                    if (mysqli_num_rows($result_orders) > 0) {
                        ?>
                        <table class="table table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Order ID</th>
                                    <th>Food ID</th>
                                    <th>Order Date</th>
                                    <th>Food Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Customer</th>
                                    <th>Action</th> <!-- Added Action column -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = mysqli_fetch_assoc($result_orders)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $row["order_ID"]; ?></td>
                                        <td><?php echo $row["F_ID"]; ?></td>
                                        <td><?php echo $row["order_date"]; ?></td>
                                        <td><?php echo $row["foodname"]; ?></td>
                                        <td><?php echo $row["price"]; ?></td>
                                        <td><?php echo $row["quantity"]; ?></td>
                                        <td><?php echo $row["username"]; ?></td>
                                        <td>
                                            <form action="" method="POST">
                                                <input type="hidden" name="order_id" value="<?php echo $row["order_ID"]; ?>">
                                                <button type="submit" class="btn btn-primary" name="shipped_btn">Shipped</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                    } else {
                        ?>
                        <h4>No orders found</h4>
                        <?php
                    }
                    ?>
                </form>
            </div>
        </div>
    </div>

</body>

</html>
