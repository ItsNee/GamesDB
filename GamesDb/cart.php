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
        $stmt = $conn->prepare("SELECT * FROM cart WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $totalValue = 0;
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
                $price = $row2["price"];
                $gameImage = $row2["gameImage"];
                $totalValue = $totalValue + $price;
                
            echo '<div class="card rounded-3 mb-4">';
            echo '<div class="card-body p-4">';
            echo '<div class="row d-flex justify-content-between align-items-center">';
            echo '<div class="col-md-2 col-lg-2 col-xl-2">';
            echo '<img src="'.$gameImage.'"';
            echo 'class="img-fluid rounded-3" alt="'.$name.'">';
            echo '</div>';
            echo '<div class="col-md-3 col-lg-3 col-xl-3">';
            echo '<p class="lead fw-normal mb-2">'.$name.'</p>';
            echo '<p><span class="text-muted">Genre: </span>'.$gameGenre.'</p>';
            echo '</div>';
            echo '<div class="col-md-3 col-lg-3 col-xl-2 d-flex">';
            echo '<input id="form1" min="0" name="quantity" value="'.$qty.'" type="number"';
            echo 'class="form-control form-control-sm" />';
            echo '';
            echo '<button class="btn btn-link px-2">';
            echo 'Update';
            echo '</button>';
            echo '</div>';
            echo '<div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">';
            echo '<h5 class="mb-0">$'.$price.'</h5>';
            echo '</div>';
            echo '<div class="col-md-1 col-lg-1 col-xl-1 text-end">';
            echo '<a href="#!" class="text-danger"><i class="fas fa-trash fa-lg"></i></a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';

            }
            
            echo '<div class="card">';
            echo '<div class="card-body">';
            echo '<button type="button" class="btn btn-warning btn-block btn-lg">Proceed to Pay</button>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</section>';
        } else {
            echo '<header style ="height:100%;" class="masthead">';
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






        <!--        <header style ="height:100%;" class="masthead">
                    <div class="container px-5 text-center">
                        <div class="row gx-14 align-items-center">
                            <div class="col-lg-14">
                                <div class="mb-5 mb-lg-0 text-center text-lg-start">
                                    <h1 class="display-4 lh-1 mb-3 text-center">Your cart is empty!</h1>
                                    <p class="lead fw-normal text-muted mb-5 text-center"><a href="games.php"> Browse games here </a></p>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </header>-->
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
