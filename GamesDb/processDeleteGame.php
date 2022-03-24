<?php

include "db.inc.php";
$appID = $_POST['appId'];

$stmt = $conn->prepare("DELETE FROM games WHERE appid=?");
$stmt->bind_param("i", $appID);
if (!$stmt->execute()) {
    $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    $success = false;
    echo $errorMsg;
} else {
    echo 'Game has successfully been deleted';
    echo '<div class = "text-center"><a href="adminPage.php">'
    . '<button class = "btn btn-outline-secondary mt-auto" style= "background-color: rgb(255, 153, 0);">Return to Admin Page</button></a></div>';
    //$statusMsg = 'Game has successfully been updated';
}
