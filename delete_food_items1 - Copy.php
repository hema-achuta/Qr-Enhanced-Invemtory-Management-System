<?php
include('session_s.php');

if(!isset($login_session)){
    header('Location: shipperlogin.php');
    exit(); // Stop further execution
}

if(isset($_POST['checkbox'])) {
    $cheks = implode("','", $_POST['checkbox']);
    $sql = "DELETE FROM location WHERE location_id IN ('$cheks')";
    $result = mysqli_query($conn, $sql);
    if($result) {
        echo "Locations deleted successfully.";
    } else {
        echo "Error deleting locations: " . mysqli_error($conn);
    }
} else {
    echo "No locations selected for deletion.";
}

header('Location: delete_locations.php');
$conn->close();
?>
