<?php
include('session_m.php');

if (!isset($login_session)) {
    header('Location: managerlogin.php');
    exit(); // Exit to avoid execution if not logged in
}

if (isset($_POST['order_ID']) && !empty($_POST['order_ID'])) {
    $order_ID = mysqli_real_escape_string($conn, $_POST['order_ID']);

    // Update the action_status in the database to 2
    $update_sql = "UPDATE orders SET action_status = 2 WHERE order_ID = '$order_ID'";
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
<?php
include('session_s.php');

if (!isset($login_session)) {
    header('Location: shipperlogin.php');
}

// Check if the "Shipped" button is clicked
if (isset($_POST['shipped_btn'])) {
    // Get the order ID from the submitted form
    $order_id = $_POST['order_id'];

    // Retrieve the email address of the user who placed the order
    $user_email_query = "SELECT c.email FROM orders o JOIN customers c ON o.username = c.username WHERE o.order_ID = '$order_id'";
    $result_user_email = mysqli_query($conn, $user_email_query);
    $row_user_email = mysqli_fetch_assoc($result_user_email);
    $user_email = $row_user_email['email'];

    // Update the action status to 2 in the orders table
    $update_query = "UPDATE orders SET action_status = 2 WHERE order_ID = '$order_id'";
    $result_update = mysqli_query($conn, $update_query);

    if (!$result_update) {
        echo "Error updating action status: " . mysqli_error($conn);
    } else {
        // Send email notification to the user
        $to = $user_email;
        $subject = 'Action Status Updated';
        $message = 'The action status for your order ID ' . $order_id . ' has been updated.';
        $headers = 'From: your_email@example.com' . "\r\n" .
            'Reply-To: your_email@example.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        // Send email
        mail($to, $subject, $message, $headers);
    }
}

?>
