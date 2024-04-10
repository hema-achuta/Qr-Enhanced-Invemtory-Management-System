<?php
include('session_m.php');

if (!isset($login_session)) {
    header('Location: managerlogin.php'); // Redirecting To Home Page
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Most Sold Products | MIS</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>

<body>

    <div class="container">
        <div class="jumbotron">
            <h1>Hello Manager, <?php echo $login_session; ?>!</h1>
            <p>View Most Sold Products</p>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="form-area" style="padding: 0px 100px 100px 100px;">
                    <h3 style="margin-bottom: 25px; text-align: center; font-size: 30px;">Most Sold Products</h3>
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Product ID</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                          

                            $sql = "SELECT F_ID, name, price, description FROM food 
                                    WHERE R_ID IN (SELECT R_ID FROM restaurants WHERE M_ID = '$login_session') 
                                    ORDER BY F_ID";
                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                $count = 1;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>{$count}</td>";
                                    echo "<td>{$row['F_ID']}</td>";
                                    echo "<td>{$row['name']}</td>";
                                    echo "<td>{$row['price']}</td>";
                                    echo "<td>{$row['description']}</td>";
                                    echo "</tr>";
                                    $count++;
                                }
                            } else {
                                echo "<tr><td colspan='5'>No products found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
