<?php
include ('../conn/conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $qrCode = $_POST['qr-code'];

    $stmt = $conn->prepare("SELECT `generated_code`, `name`, `tbl_user_id` FROM `tbl_user` WHERE `generated_code` = :generated_code");
    $stmt->bindParam(':generated_code', $qrCode);
    $stmt->execute();

    $accountExist =  $stmt->fetch(PDO::FETCH_ASSOC);

    if ($accountExist) {
        session_start();
        $_SESSION['user_id'] = $accountExist['tbl_user_id'];

        $name = $accountExist['name'];
        $user_id = $accountExist['tbl_user_id'];

        echo "
        <script>
            alert('Login Successfully!');
            window.location.href = 'http://localhost/qr-code-login-system/home.php';
        </script>
        "; 
    } else {
        echo "
        <script>
            alert('QR Code account doesn\'t exist!'); // Escaped single quote
            window.location.href = 'http://localhost/qr-code-login-system/';
        </script>
        "; 
    }
}

?>
