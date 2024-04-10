<?php
include('session_s.php');

if(!isset($login_session)){
    header('Location: shipperlogin.php'); // Redirecting To Home Page
}

?>
<!DOCTYPE html>
<html>

<head>
    <title> Shipper Control Panel | IMS</title>
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
            <h1>Hello Agent !</h1>
            <p>Manage all your shipping orders from here</p>
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
                <a href="delete_shipper.php" class="list-group-item ">Delete Shipper</a>
            </div>
        </div>

        <div class="col-xs-9">
            <div class="form-area" style="padding: 0px 100px 100px 100px;">
                <form action="111.php" method="POST">
                    <br style="clear: both">
                    <h3 style="margin-bottom: 25px; text-align: center; font-size: 30px;"> ADD SHIPPING AGENCY</h3>

                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Agency Name" required="">
                    </div>

                    <div class="form-group">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required="">
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" id="contact" name="contact" placeholder=" Contact Number" required="">
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" id="address" name="address" placeholder=" Address" required="">
                    </div>

                    <div class="form-group">
                        <button type="submit" id="submit" name="submit" class="btn btn-primary pull-right"> ADD DETAILS </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>
