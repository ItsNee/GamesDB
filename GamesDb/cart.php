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
        $stmt = $conn->prepare("SELECT * FROM cart WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $totalValue = 0;    
        if ($result->num_rows > 0) {
            echo '<section class="h-100">';
            echo '<div class="container h-100 py-5">';
            echo '<div class="row d-flex justify-content-center align-items-center h-100">';
            echo '<div class="col-10">';
            echo '<div class="d-flex justify-content-between align-items-center mb-4">';
            echo '<h3 class="fw-normal mb-0 text-black">Shopping Cart</h3>';
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
                echo '<p class="lead fw-normal mb-2">'.$name.'</p>';
                echo '<p><span class="text-muted">Genre: </span>' . $gameGenre . '</p>';
                echo '</div>';

                //Update Button
                echo '<div class="col-md-3 col-lg-3 col-xl-2 d-flex">';
                echo '<form action = "updateGame.php" method = "POST" enctype = "multipart/form-data">';
                echo '<input id="gameQty" min="0" name="gameQty" value="' . $qty . '" type="number"';
                echo 'class="form-control form-control-sm" />';
                echo '<input type = "hidden" name = "appId" value="' . $appid . '" />';
                echo '';
                echo '<div class="update-button">';
                echo '<button class = "btn btn-outline-success " type = "submit">Update</button></div>';
                echo '</form>';
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

            //Checkout Button
            echo '<div class="card">';
            echo '<div class="card-body">';
            echo '<a class="btn btn-primary btn-block btn-lg" href="checkout.php">Checkout</a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</section>';
        } else {
            echo '<header style ="height:100%; background-color: white;" class="masthead">';
            echo '<div class="container px-5 text-center">';
            echo '<div class="row gx-14 align-items-center">';
            echo '<div class="col-lg-14">';
            echo '<div class="mb-5 mb-lg-0 text-center text-lg-start">';
            echo "<h1 class=\"display-4 lh-1 mb-3 text-center\">Your cart is empty!</h1>";
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
