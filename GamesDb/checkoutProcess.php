
<?php

include "navPostLogin.inc.php";
include "db.inc.php";
$creditCard = $_POST['creditCard'];
$expiry = $_POST['expiryDate'];
$cvc = $_POST['cvc'];

//check if credit card valid if valid
if (true) {
    $result2 = getCart($username, $conn);
    echo $result2->num_rows;
    if ($result2->num_rows > 0) {

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
} 
else {
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
?>