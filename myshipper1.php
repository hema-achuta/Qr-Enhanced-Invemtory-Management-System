<?php

include('session_s.php');

if(!isset($login_session)){
header('Location: shipperlogin.php'); 
}



$state = $conn->real_escape_string($_POST['state']);
$district = $conn->real_escape_string($_POST['district']);
$pincode = $conn->real_escape_string($_POST['pincode']);


// Storing Session
$user_check=$_SESSION['login_user3'];
$R_IDsql = "SELECT AGENCY.A_ID FROM AGENCY, MANAGER WHERE AGENCY.S_ID='$user_check'";
$R_IDresult = mysqli_query($conn,$R_IDsql);
$R_IDrs = mysqli_fetch_array($R_IDresult, MYSQLI_BOTH);
$R_ID = $R_IDrs['A_ID'];

$S_IDsql = "SELECT S_ID FROM AGENCY WHERE A_ID='$R_ID'";
$S_IDresult = mysqli_query($conn, $S_IDsql);
$S_IDrs = mysqli_fetch_array($S_IDresult, MYSQLI_ASSOC);
$S_ID = $S_IDrs['S_ID'];

// Insert new location into the LOCATION table with the fetched S_ID
$query = "INSERT INTO LOCATION(state, district, pincode, A_ID, S_ID) VALUES ('$state', '$district', '$pincode', '$R_ID', '$S_ID')";
$success = $conn->query($query);

if (!$success){

	?>

	<!DOCTYPE html>
	<html>
	<head>
		<title>IMS with QR</title>
	<link rel="stylesheet" type = "text/css" href ="css/add_food_items.css">
  <link rel="stylesheet" type = "text/css" href ="css/bootstrap.min.css">
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
	</head>
	<body>
	
    <button onclick="topFunction()" id="myBtn" title="Go to top">
      <span class="glyphicon glyphicon-chevron-up"></span>
    </button>
  
    <script type="text/javascript">
      window.onscroll = function()
      {
        scrollFunction()
      };

      function scrollFunction(){
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
            <li class="active"> <a href="managerlogin.php">MANAGER CONTROL PANEL</a></li>
            <li><a href="logout_s.php"><span class="glyphicon glyphicon-log-out"></span> Log Out </a></li>
          </ul>
        </div>

      </div>
    </nav>


	<div class="container">
    <div class="jumbotron">
     <h1>Oops...!!! </h1>
     <p>Kindly enter your Business details before products.</p>
     <p><a href="myshipper.php"> Click Me </a></p>

    </div>
    </div>
    <br><br><br><br><br><br><br><br><br><br><br><br>
	</body>
	
	</html>

	<?php
	
}
else {
	echo "SUCCESS";
	header('Location: add_shipper.php');
}

$conn->close();


?>