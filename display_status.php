<?php
include('session_m.php');

if (!isset($login_session)) {
    header('Location: managerlogin.php');
    exit(); // Exit to avoid execution if not logged in
}

// Fetch the action status from the database
$user_check = $_SESSION['login_user1'];
$sql = "SELECT action_status FROM orders o WHERE o.R_ID IN (SELECT r.R_ID FROM RESTAURANTS r WHERE r.M_ID='$user_check')";
$result = mysqli_query($conn, $sql);

// Check if query executed successfully and fetch the action status
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $action_status = $row['action_status'];
} else {
    $action_status = 0; // Default value if no records found
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Action Status Display</title>
</head>

<body>
    <h1>Action Status Display</h1>
    <?php if ($action_status == 1) : ?>
        <img src="img1.jpg" alt="Image 1">
    <?php elseif ($action_status == 2) : ?>
        <img src="img2.jpg" alt="Image 2">
    <?php elseif ($action_status == 3) : ?>
        <img src="img3.jpg" alt="Image 3">
    <?php else : ?>
        <p>No action status found or invalid status.</p>
    <?php endif; ?>
</body>

</html>
