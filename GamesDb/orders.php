<!DOCTYPE html>
<html lang="en">
    <?php
    include "head.inc.php";
    ?>
    <body id="page-top">
        <?php
        include "navPostLogin.inc.php";
        ?>

        <?php
        include "db.inc.php";
        $stmt = $conn->prepare("SELECT * FROM orders WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            echo '<section class="h-100">';
            echo '<div class="container h-100 py-5">';
            echo '<div class="row d-flex justify-content-center align-items-center h-100">';
            echo '<div class="col-10">';
            echo '<div class="d-flex justify-content-between align-items-center mb-4">';
            echo '<h3 class="fw-normal mb-0 text-black">Orders</h3>';
            echo '</div>';
            while ($row = $result->fetch_assoc()) {
                $orderid = $row["orderid"];
                $orderdate = $row["orderdate"];
                echo '<div class="card rounded-3 mb-4">';
                echo '<div class="card-body p-4">';
                echo '<div class="row d-flex justify-content-between align-items-center">';
                echo '<div class="col-md-5 col-lg-5 col-xl-5">';
                echo '<p class="lead fw-normal mb-2">Order #' . $orderid . '</p>';
                echo '<span class="text-muted">Games:</span></br>';
                $stmt = $conn->prepare("SELECT * FROM orderDetails WHERE orderid=?");
                $stmt->bind_param("s", $orderid);
                $stmt->execute();
                $result2 = $stmt->get_result();
                while ($row = $result2->fetch_assoc()) {
                    $appid = $row["appid"];
                    $stmt = $conn->prepare("SELECT * FROM games WHERE appid=?");
                    $stmt->bind_param("s", $appid);
                    $stmt->execute();
                    $result3 = $stmt->get_result();
                    while ($row = $result3->fetch_assoc()) {
                        echo '<span class="text-muted">'.$row["name"].'</span></br>';
                    }
                }
                echo '</div>';

                //Order date
                echo '<div class="orderDate col-md-3 col-lg-3 col-xl-3">';
                echo '<p class="lead fw-normal mb-2">Date:</p>';
                echo '<span class="text-muted">'.$orderdate.'</span></br>';
                echo '</div>';

                //Button to check individual order
                echo '<div class="col-md-3 col-lg-3 col-xl-2 offset-lg-1">';
                echo '<h5 class="mb-0">';
                echo '<form action = "individualOrder.php" method = "POST" enctype = "multipart/form-data">';
                echo '<input type = "hidden" name = "orderid" value="' . $orderid . '" />';
                echo '';
                echo '<button class = "btn btn-outline-success " type = "submit">Details</button>';
                echo '</form>';

                echo'</h5>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            echo '</section>';
        } else {
            echo '<header style ="height:100%; background-color: white;" class="masthead">';
            echo '<div class="container px-5 text-center">';
            echo '<div class="row gx-14 align-items-center">';
            echo '<div class="col-lg-14">';
            echo '<div class="mb-5 mb-lg-0 text-center text-lg-start">';
            echo "<h1 class=\"display-4 lh-1 mb-3 text-center\">You have no orders!</h1>";
            echo "<p class=\"lead fw-normal text-muted mb-5 text-center\"><a href=\"games.php\"> Browse games here </a></p>";
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</header>';
        }
        ?>
        <?php
        include "footer.inc.php";
        ?>



        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    </body>
</html>
