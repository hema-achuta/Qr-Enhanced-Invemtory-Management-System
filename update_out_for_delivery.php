<?php
include('session_m.php');

if (!isset($login_session)) {
    header('Location: managerlogin.php');
    exit(); // Exit to avoid execution if not logged in
}

if (isset($_POST['order_ID']) && !empty($_POST['order_ID'])) {
    $order_ID = mysqli_real_escape_string($conn, $_POST['order_ID']);

    // Update the action_status in the database to 3 (Out for Delivery)
    $update_sql = "UPDATE orders SET action_status = 3 WHERE order_ID = '$order_ID'";
    if (mysqli_query($conn, $update_sql)) {
        header('Location: view_order_details.php'); // Redirect back to order details page
        exit();
    } else {
        echo "Error updating order status: " . mysqli_error($conn);
    }
} else {
    header('Location: view_order_details.php');
    exit();
}
?>
