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

        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
        require 'PHPMailer-master/src/PHPMailer.php';
        require 'PHPMailer-master/src/SMTP.php';
        $creditCard = sanitize_input($_POST['creditCard']);
        $expiry = sanitize_input($_POST['expiryDate']);
        $cvc = sanitize_input($_POST['cvc']);
        $CvcChecker = checkCVC($cvc);
        $CCchecker = CCValidate($creditCard);
        $ExpiryChecker = checkerExpiry($expiry);
        //check if credit card valid if valid
        if ($CCchecker == 1 && $ExpiryChecker == 1 && $CvcChecker == 1) {
            $result2 = getCart($username, $conn);
            $coder = '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous"><table class="table"><thead><tr><th scope="col">#</th><th scope="col">Game Name</th><th scope="col">Price</th></tr></thead><tbody>';
            $counter = 1;
            if ($result2->num_rows > 0) {
                $query = "SELECT * FROM cart WHERE username='$username'";
                $result = mysqli_query($conn, $query);
                if ($result->num_rows > 0) {
                    // output data of each row
                    while ($row = $result->fetch_assoc()) {
                        $appid = $row["appid"];
                        $query2 = "SELECT * FROM games WHERE appid='$appid'";
                        $result2 = mysqli_query($conn, $query2);
                        if ($result2->num_rows > 0) {
                            // output data of each row
                            while ($row2 = $result2->fetch_assoc()) {
                                $name = $row2["name"];
                                $price = $row2["price"];
                                $coder .= '<tr><th scope="row">' . $counter . '</th><td>' . $name . '</td><td>' . $price . '</td><td>' . generateRandomString() . '</td></tr>';
                                $counter = $counter + 1;
                            }
                        }
                    }
                }
                $coder .= '</tbody></table>';
                //echo $coder;
                $mail = new PHPMailer();
                $mail->IsSMTP();
                $mail->Mailer = "smtp";
                $mail->SMTPDebug = 0;
                $mail->SMTPAuth = TRUE;
                $mail->SMTPSecure = "tls";
                $mail->Port = 587;
                $mail->Host = "smtp.gmail.com";
                $mail->Username = "GamesDB.ICT1004@gmail.com";
                $mail->Password = "HC1ge@rV^jKU";
                $mail->IsHTML(true);
                $mail->AddAddress($email, "Customer");
                $mail->SetFrom("Accounts@GamesDb.com", "GamesDb Accounts Department");
                $mail->Subject = "GamesDb Order Confirmation";
                $content = $coder;
                $mail->MsgHTML($content);
                if (!$mail->Send()) {
                    echo "Error while sending Email.";
                    //var_dump($mail);
                } else {
                    echo "Email sent successfully";
                }


                $stmt = $conn->prepare("SELECT * FROM orders");
                $stmt->execute();
                $resultOrders = $stmt->get_result();
                //To check if the orders table is empty
                //If not empty update with latest orderid
                if ($resultOrders->num_rows > 0) {
                    //Add to order DB
                    $stmt = $conn->prepare("SELECT MAX(orderid) AS orderid FROM orders");
                    $stmt->execute();

                    $orderidRow = $stmt->get_result();
                    $orderidRow2 = $orderidRow->fetch_assoc();
                    $largestInt = (int) $orderidRow2['orderid'];
                    $largestOrder = $largestInt + 1;
                    $purchasedDate = date('Y-m-d');
                    $stmt2 = $conn->prepare("INSERT INTO orders (orderid, username, orderdate) VALUES (?, ?, ?)");
                    $stmt2->bind_param("sss", $largestOrder, $username, $purchasedDate);
                    $stmt2->execute();
                    $counter = 0;
                    $result3 = getCart($username, $conn);
                    while ($row = $result3->fetch_assoc()) {
                        $stmt = $conn->prepare("INSERT INTO orderDetails (orderid, appid, qty) VALUES (?, ?, ?)");
                        $appid = (int) $row['appid'];
                        $qty = (int) $row['qty'];
                        $stmt->bind_param("sss", $largestOrder, $appid, $qty);
                        $stmt->execute();
                        $counter = counter + 1;
                    }
                    deleteCart($username, $conn);
                    echoText();
                } else {
                    //Add to order DB for first entry into db
                    $one = 1;
                    $purchasedDate = date('Y-m-d');
                    echo $purchasedDate;
                    $stmt2 = $conn->prepare("INSERT INTO orders (orderid, username, orderdate) VALUES (?, ?, ?)");
                    $stmt2->bind_param("sss", $one, $username, $purchasedDate);
                    $stmt2->execute();
                    $result3 = getCart($username, $conn);
                    while ($row = $result3->fetch_assoc()) {
                        $stmt = $conn->prepare("INSERT INTO orderDetails (orderid, appid, qty) VALUES (?, ?, ?)");
                        $appid = (int) $row['appid'];
                        $qty = (int) $row['qty'];
                        $stmt->bind_param("sss", $one, $appid, $qty);
                        $stmt->execute();
                    }
                    deleteCart($username, $conn);

                    echoText();
                }
            } else {
                header('Location: cart.php');
            }
        } else {
            header("refresh:3; url=checkout.php");
            echo '<header style ="height:100%; background-color: white;" class="masthead">';
            echo '<div class="container px-5 text-center">';
            echo '<div class="row gx-14 align-items-center">';
            echo '<div class="col-lg-14">';
            echo '<div class="mb-5 mb-lg-0 text-center text-lg-start">';
            echo "<h1 class=\"display-4 lh-1 mb-3 text-center\">Credit Card is invalid!</h1>";
            echo "<h1 class=\"display-4 lh-1 mb-3 text-center\">Please try again!</h1>";
            echo "<p class=\"lead fw-normal text-muted mb-5 text-center\"><a href=\"checkout.php\"> Click here if you are not redirected back after awhile... </a></p>";
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</header>';
        }

        function getCart($username, $conn) {
            $stmt = $conn->prepare("SELECT * FROM cart WHERE username=?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        }

        function deleteCart($username, $conn) {
            $stmt = $conn->prepare("DELETE FROM cart WHERE username=?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
        }

        function CCValidate($num) {
            $patternMaster = "/^5[1-5]\\d{14}$/"; //Mastercard
            $patternVisa = "/^4\\d{12}(\\d{3})?$/"; //Visa
            if (preg_match($patternMaster, $num) || preg_match($patternVisa, $num)) {
                if (LuhnCheck($num)) {
                    return 1;
                } else {
                    return 0;
                }
            } else {
                return 0;
            }
        }

        function LuhnCheck($strDigits) {
            $sum = 0;
            $alt = false;
            for ($i = strlen($strDigits) - 1; $i >= 0; $i--) {
                if ($alt) {
                    $temp = $strDigits[$i];
                    $temp *= 2;
                    $strDigits[$i] = ($temp > 9) ? $temp = $temp - 9 : $temp;
                }
                $sum += $strDigits[$i];
                $alt = !$alt;
            }
            return $sum % 10 == 0;
        }

        function echoText() {
            echo '<header style ="height:100%; background-color: white;" class="masthead">';
            echo '<div class="container px-5 text-center">';
            echo '<div class="row gx-14 align-items-center">';
            echo '<div class="col-lg-14">';
            echo '<div class="mb-5 mb-lg-0 text-center text-lg-start">';
            echo "<h1 class=\"display-4 lh-1 mb-3 text-center\">Order has been received!</h1>";
            echo "<h1 class=\"display-4 lh-1 mb-3 text-center\">Check your email for confirmation!</h1>";
            echo "<p class=\"lead fw-normal text-muted mb-5 text-center\"><a href=\"orders.php\"> Check your orders here </a></p>";
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</header>';
        }

        use DateTime;

        function checkerExpiry($expiry) {
            $expires = DateTime::createFromFormat('my', $expiry);
            $now = new DateTime();

            if ($expires < $now) {
                return 0;
            } else {
                return 1;
            }
        }
        
        function checkCVC($cvc){
            if (strlen($cvc)!=3){
                return 0;
            }
            else{
                return 1;
            }
                
        }
        
        function sanitize_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }

        function generateRandomString($length = 10) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
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
