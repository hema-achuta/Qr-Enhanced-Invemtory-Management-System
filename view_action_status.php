<?php
session_start();
require 'connection.php';
$conn = Connect();

// Check if the user has a session or cookie indicating they're logged in
if(!isset($_SESSION['login_user2']) && !isset($_COOKIE['user_token'])){
    header("location: customerlogin.php"); 
    exit(); // Exit to avoid execution if not logged in
}

// Check if the user has a session, if not but has a cookie, try to log in with the cookie
if(!isset($_SESSION['login_user2']) && isset($_COOKIE['user_token'])){
    $user_token = $_COOKIE['user_token'];
    // Perform a check to see if the token is valid and log in the user accordingly
    // You'd need to implement this part based on your specific authentication mechanism
}

// Fetch the orders list for the logged-in customer
$user_check = isset($_SESSION['login_user2']) ? $_SESSION['login_user2'] : $_COOKIE['user_token'];
$sql = "SELECT o.foodname, o.action_status FROM orders o
        INNER JOIN customer c ON o.username = c.username
        WHERE c.username='$user_check'";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>

<head>
    <title>Action Status Display</title>
</head>

<body>
    <h1>Action Status Display</h1>
    <?php if ($result && mysqli_num_rows($result) > 0) : ?>
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <?php
            // Check action status and set image accordingly
            $food_name = $row['foodname'];
            $action_status = $row['action_status'];
            $image_path = '';

            switch ($action_status) {
                case 1:
                    $image_path = 'img0.jpg';
                    break;
                case 2:
                    $image_path = 'img2.jpg';
                    break;
                case 3:
                    $image_path = 'img3.jpg';
                    break;
                default:
                    $image_path = 'img1.jpg';
                    break;
            }
            ?>
            <div>
                <p>Product Name: <?php echo $food_name; ?></p>
                <p>Action Status: <?php echo $action_status; ?></p>
                <img src="<?php echo $image_path; ?>" alt="Action Status Image">
            </div>
        <?php endwhile; ?>
    <?php else : ?>
        <p>No action status found.</p>
    <?php endif; ?>
</body>

</html>
