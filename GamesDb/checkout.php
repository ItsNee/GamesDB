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
        $totalValue = 0;
        $numrows = $result->num_rows;
        if ($result->num_rows > 0) {
            echo '<section>';
            echo '<div class="container d-flex justify-content-center mt-5 mb-5">';
            echo '<div class="row g-3">';
            echo '<div class="col-md-6">';
            echo '';
            echo '<!--Paypal-->';
            echo '<div class ="card card-other-option">';
            echo '<div class="card-header">';
            echo 'Express Checkout';
            echo '</div>';
            echo '';
            echo '<div class="card">';
            echo '';
            echo '<div class="box">';
            echo '<form action = "paypal.php" method = "POST" enctype = "multipart/form-data">';
            echo '<button class="paypal-button">';
            echo '<span class="paypal-button-title">';
            echo 'Checkout with ';
            echo '</span>';
            echo '<span class="paypal-logo">';
            echo '<i class = "color1">Pay</i><i class = "color2">Pal</i>';
            echo '</span>';
            echo '</button>';
            echo '</form>';
            echo '</div>';
            echo '';
            echo '</div>';
            echo '</div>';
            echo '<!--Paypal-->';
            echo '';
            echo '<!--Credit Card-->';
            echo '<div class ="card">';
            echo '<div class="card-header">';
            echo 'Credit Card';
            echo '<div class="icons"> <img src="https://i.imgur.com/2ISgYja.png" width="30"> <img src="https://i.imgur.com/W1vtnOV.png" width="30">  </div>';
            echo '</div>';
            echo '<form id="checkoutForm" name="checkoutForm" action="checkoutProcess.php" method="POST" enctype="multipart/form-data">';
            echo '<div class="card">';
            echo '<div class="card-body payment-card-body"> <span class="font-weight-normal card-text">Card Number</span>';
            echo '<div class="input"> <i class="fa fa-credit-card"></i> <input type="text" class="form-control" placeholder="0000000000000000" name="creditCard" minlength="16" maxlength="16" required> </div>';
            
            echo '<div class="row mt-3 mb-3">';
            echo '<div class="col-md-6"> <span class="font-weight-normal card-text">Expiry Date</span>';
            echo '<div class="input"> <i class="fa fa-calendar"></i> <input name="expiryDate" type="text" class="form-control" placeholder="MM/YY" maxlength="4" minlength="4" required> </div>';
            echo '</div>';
            echo '<div class="col-md-6"> <span class="font-weight-normal card-text">CVC/CVV</span>';
            echo '<div class="input"> <i class="fa fa-lock"></i> <input name="cvc" type="text" class="form-control" placeholder="000" minlength="3" maxlength="3" required> </div>';
            echo '</div>';
            echo '</div> <span class="text-muted certificate-text"><i class="fa fa-lock"></i> Your transaction is secured with ssl certificate</span>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '<!--Credit Card-->';
            echo '';
            echo '</div>';
            echo '<div class="col-md-6">';
            echo '<div class="card">';
            echo '<div class="card-header">Summary</div>';
            echo '<div class="p-3">';
            
            while ($row = $result->fetch_assoc()) {
                $appid = $row["appid"];
                $qty = $row["qty"];
                $stmt2 = $conn->prepare("SELECT * FROM games WHERE appid=?");
                $stmt2->bind_param("s", $appid);
                $stmt2->execute();
                $result2 = $stmt2->get_result();
                $row2 = $result2->fetch_assoc();
                $name = $row2["name"];
                $price = $row2["price"] * $qty;
                $totalValue = $totalValue + $price;
                
            echo '<div class="d-flex justify-content-between"> <span>'.$name.'</span> <span>$'.$price.'</span> </div>';
            }
            echo '</div>';
            echo '<hr class="mt-0 line">';
            echo '<div class="d-flex justify-content-between p-3">';
            echo '<div class="d-flex flex-column"> <span>Total :</span></div>';
            echo '<div class="mt-1"> <sup class="super-price">$'.$totalValue.'</sup> </div>';
            echo '</div>';
            
            echo '<div class="p-3 text-center"> <button class="btn btn-primary btn-block free-button">Checkout</button>';
            echo '</form>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</section>';
            echo '';
        } else {

            header("location: home.php");
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
