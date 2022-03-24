<?php

include "db.inc.php";
$appID = $_POST['appId'];
$gameName = $_POST['gameName'];
$developer = $_POST['developer'];
$price = $_POST['price'];
$gameInfo = $_POST['gameInfo'];
$gameImage = $_POST['gameImage'];

$stmt = $conn->prepare("UPDATE games set name=?, developer=?, price=?, gameInfo=?, gameImage=? WHERE appid=?");
$stmt->bind_param("sssssi",$gameName, $developer, $price, $gameInfo, $gameImage, $appID);
if (!$stmt->execute()) {
    $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    $success = false;
    echo $errorMsg;
} else {
    echo 'Game has successfully been updated';
    echo '<div class = "text-center"><a href="adminPage.php">'
    . '<button class = "btn btn-outline-secondary mt-auto" style= "background-color: rgb(255, 153, 0);">Return to Admin Page</button></a></div>';
    //$statusMsg = 'Game has successfully been updated';
}
    

