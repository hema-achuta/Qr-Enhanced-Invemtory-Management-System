<?php 
include ('../conn/conn.php');

if (isset($_POST['name'], $_POST['contact_number'], $_POST['email'], $_POST['generated_code'])) {
    $name = $_POST['name'];
    $contactNumber = $_POST['contact_number'];
    $email = $_POST['email'];
    $generatedCode = $_POST['generated_code'];
    
    try {
        $stmt = $conn->prepare("SELECT `name` FROM `tbl_user` WHERE `name` =  :name ");
        $stmt->execute(['name' => $name]);

        $nameExist =  $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($nameExist)) {
            $conn->beginTransaction();

            $insertStmt = $conn->prepare("INSERT INTO `tbl_user` (`name`, `contact_number`, `email`, `generated_code`) VALUES (:name, :contact_number, :email, :generated_code)");
            $insertStmt->bindParam('name', $name, PDO::PARAM_STR);
            $insertStmt->bindParam('contact_number', $contactNumber, PDO::PARAM_STR);
            $insertStmt->bindParam('email', $email, PDO::PARAM_STR);
            $insertStmt->bindParam('generated_code', $generatedCode, PDO::PARAM_STR);

            $insertStmt->execute();

            $conn->commit(); 

            echo "
            <script>
                alert('Registered Successfully!');
                window.location.href = 'http://localhost/qr-code-login-system/';
            </script>
            ";
        } else {
            echo "
            <script>
                alert('Account Already Exist!');
                window.location.href = 'http://localhost/qr-code-login-system/';
            </script>
            ";
        }

    }  catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: " . $e->getMessage();
    }

}

?>
