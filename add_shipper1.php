<?php

include('session_s.php');

if(!isset($login_session)){
header('Location: shipperlogin.php'); 
}

$state = $conn->real_escape_string($_POST['state']);
$district = $conn->real_escape_string($_POST['district']);
$pincode = $conn->real_escape_string($_POST['pincode']);

// Storing Session
$user_check = $_SESSION['login_user3'];

// Query to fetch S_ID directly from SHIPPERS table
$S_ID_query = "SELECT USERNAME FROM SHIPPERS WHERE USERNAME = '$user_check'";
$S_ID_result = mysqli_query($conn, $S_ID_query);

if ($S_ID_result) {
    // Check if the query returned any results
    if (mysqli_num_rows($S_ID_result) > 0) {
        // Fetch the S_ID
        $row = mysqli_fetch_assoc($S_ID_result);
        $S_ID = $row['S_ID'];

        // Insert S_ID into location table
        $query = "INSERT INTO location(state, district, pincode, S_ID) VALUES ('$state', '$district', '$pincode', '$S_ID')";
        $success = $conn->query($query);

        if ($success) {
            echo "Location details inserted successfully!";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "No matching S_ID found in SHIPPERS table.";
    }
} else {
    echo "Error: " . $S_ID_query . "<br>" . mysqli_error($conn);
}


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
            <li><a href="logout_m.php"><span class="glyphicon glyphicon-log-out"></span> Log Out </a></li>
          </ul>
        </div>

      </div>
    </nav>


	<div class="container">
    <div class="jumbotron">
     <h1>Oops...!!! </h1>
     <p>Kindly enter your Business details before products.</p>
     <p><a href="myrestaurant.php"> Click Me </a></p>

    </div>
    </div>
    <br><br><br><br><br><br><br><br><br><br><br><br>
	</body>
	
	</html>

	