<?php
include('session_s.php');

if(!isset($login_session)){
    header('Location: shipperlogin.php'); 
    exit(); // Stop further execution
}

?>
<!DOCTYPE html>
<html>

<head>
    <title> Shipper Login | IMS </title>
</head>

<link rel="stylesheet" type="text/css" href="css/delete_food_items.css">
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
                <a class="navbar-brand" href="index.php">MIS</a>
            </div>

            <div class="collapse navbar-collapse " id="myNavbar">
                <ul class="nav navbar-nav">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="aboutus.php">About</a></li>
                    <li><a href="contactus.php">Contact Us</a></li>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $login_session; ?> </a></li>
                    <li class="active"> <a href="shipperlogin.php">MANAGER CONTROL PANEL</a></li>
                    <li><a href="logout_m.php"><span class="glyphicon glyphicon-log-out"></span> Log Out </a></li>
                </ul>
            </div>

        </div>
    </nav>

    <div class="container">
        <div class="jumbotron">
            <h1>Hello Manager! </h1>
            <p>Manage all your products from here</p>
        </div>
    </div>

    <div class="container">
        <div class="container">
            <div class="col">
            </div>
        </div>

        <div class="col-xs-3" style="text-align: center;">
            <div class="list-group">
                <a href="myshipper.php" class="list-group-item ">MIS</a>
                <a href="view_shippers.php" class="list-group-item ">View  Items</a>
                <a href="add_shipper.php" class="list-group-item ">Add Items</a>
                <a href="delete_locations.php" class="list-group-item active">Delete Locations</a>
                <a href="view_action_status1.php" class="list-group-item ">View Order Details</a>
            </div>
        </div>

        <div class="col-xs-9">
            <div class="form-area" style="padding: 0px 100px 100px 100px;">
                <form action="delete_locations.php" method="POST">
                    <br style="clear: both">
                    <h3 style="margin-bottom: 25px; text-align: center; font-size: 30px;"> DELETE YOUR LOCATIONS FROM HERE </h3>

                    <?php
                    // Storing Session
                    $user_check=$_SESSION['login_user3'];
                    $sql = "SELECT * FROM location WHERE S_ID='$user_check' ORDER BY location_id";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                    ?>

                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th> # </th>
                                <th> Location ID </th>
                                <th> Location Name </th>
                                <th> Address </th>
                                <th> City </th>
                            </tr>
                        </thead>

                        <?php
                        //OUTPUT DATA OF EACH ROW
                        while($row = mysqli_fetch_assoc($result)) {
                        ?>

                        <tbody>
                            <tr>
                                <td> <input name="checkbox[]" type="checkbox" value="<?php echo $row['location_id']; ?>"/> </td>
                                <td><?php echo $row["location_id"]; ?></td>
                                <td><?php echo $row["state"]; ?></td>
                                <td><?php echo $row["district"]; ?></td>
                                <td><?php echo $row["pincode"]; ?></td>
                            </tr>
                        </tbody>

                        <?php } ?>
                    </table>
                    <br>
                    <div class="form-group">
                        <button type="submit" id="submit" name="delete" value="Delete" class="btn btn-danger pull-right"> DELETE</button>    
                    </div>

                    <?php } else { ?>

                    <h4><center>0 RESULTS</center> </h4>

                    <?php } ?>

                </form>
            </div>
        </div>
    </div>

</body>

</html>
