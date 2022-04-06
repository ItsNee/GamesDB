<!DOCTYPE html>
<html lang="en">
    <?php
    include "head.inc.php";
    ?>
    <style>
        .cart-price{
            padding-top:.5rem;
        }
        .update-button{
            margin-top: .5em;
        }
    </style>
    <body id="page-top">
        <?php
        include "navPostLogin.inc.php";
        ?>

        <?php
        include "db.inc.php";
        $orderid = sanitize_input($_POST['orderid']);
        $orderid = (int)$orderid;
        if ($orderid == NULL){
            header('Location: index.php');
        }
        echo $orderid;
        $stmt = $conn->prepare("SELECT * FROM orderDetails WHERE orderid=?");
        $stmt->bind_param("s", $orderid);
        $stmt->execute();
        $result = $stmt->get_result();
        $totalValue = 0;    
        if ($result->num_rows > 0) {
            echo '<section class="h-100">';
            echo '<div class="container h-100 py-5">';
            echo '<div class="row d-flex justify-content-center align-items-center h-100">';
            echo '<div class="col-10">';
            echo '<div class="d-flex justify-content-between align-items-center mb-4">';
            echo '<h3 class="fw-normal mb-0 text-black">Order #'.$orderid.'</h3>';
            echo '</div>';
            while ($row = $result->fetch_assoc()) {
                $appid = $row["appid"];
                $qty = $row["qty"];

                $stmt2 = $conn->prepare("SELECT * FROM games WHERE appid=?");
                $stmt2->bind_param("s", $appid);
                $stmt2->execute();
                $result2 = $stmt2->get_result();
                $row2 = $result2->fetch_assoc();

                $gameGenre = $row2["gameGenre"];
                $name = $row2["name"];
                $developer = $row2["developer"];
                $price = $row2["price"] * $qty;
                $gameImage = $row2["gameImage"];
                $totalValue = $totalValue + $price;

                echo '<div class="card rounded-3 mb-4">';
                echo '<div class="card-body p-4">';
                echo '<div class="row d-flex justify-content-between align-items-center">';
                echo '<div class="col-md-2 col-lg-2 col-xl-2">';
                echo '<img src="' . $gameImage . '"';
                echo 'class="img-fluid rounded-3" alt="' . $name . '">';
                echo '</div>';
                echo '<div class="col-md-3 col-lg-3 col-xl-3">';
                //echo '<form id="indivGamesForm" name="indivGamesForm" action="individualGames.php" method="POST" enctype="multipart/form-data">';
                //echo '<input type="hidden" name="appId" value="' . $appid . '" />';
               // echo '<button class = "btn"><p class="lead fw-normal mb-2">' . $name . '</p></button';
                //echo '</form>';
                echo '<p class="lead fw-normal mb-2">'.$name.'</p>';
                echo '<p><span class="text-muted">Genre: </span>' . $gameGenre . '</p>';
                echo '</div>';

                //Update Button
                echo '<div class="col-md-3 col-lg-3 col-xl-2 d-flex">';
                echo '<h5 class="mb-0">Quantity: ' . $qty . '</h5>';
                echo '</div>';

                //Game Price
                if ($price != 0) {
                    echo '<div class="col-md-3 col-lg-3 col-xl-2 offset-lg-1">';
                    echo '<h5 class="mb-0 cart-price">$' . $price . '</h5>';
                    echo '</div>';
                } else {
                    echo '<div class="col-md-3 col-lg-3 col-xl-2 offset-lg-1">';
                    echo '<h5 class="mb-0 cart-price">Free To Play</h5>';
                    echo '</div>';
                }


                echo '</div>';
                echo '</div>';
                echo '</div>';
            }

            //Total Value
            echo '<div class="card rounded-3 mb-4">';
            echo '<div class="card-body p-4">';
            echo '<div class="row d-flex justify-content-between align-items-center">';
            echo '<div class="col-md-2 col-lg-2 col-xl-2">';
            echo '<p class="lead fw-normal mb-2">Total:</p>';
            echo '</div>';
            echo '<div class="col-md-3 col-lg-3 col-xl-3">';
            echo '</div>';
            echo '<div class="col-md-3 col-lg-3 col-xl-2 d-flex">';
            echo '</div>';
            echo '<div class="col-md-3 col-lg-3 col-xl-2 offset-lg-1">';
            echo '<h5 class="mb-0 cart-price">$' . $totalValue . '</h5>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            
            echo '</section>';

        } else {
            header('Location: orders.php');
        }
        
        function sanitize_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
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
