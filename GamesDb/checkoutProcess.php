
<?php

include "navPostLogin.inc.php";
include "db.inc.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();
if (isset($_SESSION['username']) == true) {
    $username = $_SESSION['username'];
    $email = $_SESSION['email'];
} else {
    header("location: index.php");
}

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
$creditCard = $_POST['creditCard'];
$expiry = $_POST['expiryDate'];
$cvc = $_POST['cvc'];
$CCchecker = CCValidate($creditCard);

//check if credit card valid if valid
if ($CCchecker == 1) {
    $result2 = getCart($username, $conn);
    echo $result2->num_rows;
    $coder = '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous"><table class="table"><thead><tr><th scope="col">#</th><th scope="col">Game Name</th><th scope="col">Price</th></tr></thead><tbody>';
    $counter = 1;
    if ($result2->num_rows > 0) {
        $query = "SELECT * FROM cart WHERE username='$username'";
        echo $query;
        $result = mysqli_query($conn, $query);
        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $appid = $row["appid"];
                $query2 = "SELECT * FROM games WHERE appid='$appid'" ;
                echo $appid;
                $result2 = mysqli_query($conn, $query2);
                if ($result2->num_rows > 0) {
                    // output data of each row
                    while ($row2 = $result2->fetch_assoc()) {
                        $name = $row2["name"];
                        echo $name;
                        $price = $row2["price"];
                        $coder .= '<tr><th scope="row">' . $counter . '</th><td>' . $name . '</td><td>' . $price . '</td></tr>';
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
        echo $resultOrders->num_rows;
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
            $stmt2 = $conn->prepare("INSERT INTO orders (orderid, username) VALUES (?, ?)");
            $stmt2->bind_param("ss", $largestOrder, $username);
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
            header('Location: cart.php');
        } else {
            //Add to order DB for first entry into db
            $one = 1;
            $stmt2 = $conn->prepare("INSERT INTO orders (orderid, username) VALUES (?, ?)");
            $stmt2->bind_param("ss", $one, $username);
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
            header('Location: cart.php');
        }
    } else {
        header('Location: cart.php');
    }
} else {
    echo "credit card wrong";
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
?>