<?php

include "db.inc.php";
$gameName = $_POST['gameName'];
$developer = $_POST['developer'];
$price = $_POST['price'];
$gameGenre = "";
if (is_array($_POST['gameGenre'])) {
    foreach ($_POST['gameGenre'] as $value) {
        $gameGenre .= $value . " ";
        //echo $value;
    }
} else {
    $gameGenre = $_POST['gameGenre'];
    echo $gameGenre;
}

$positiveVotes = "0";
$negativeVotes = "0";
$gameInfo = $_POST['gameInfo'];
$gameImage = $_POST['gameImage'];

$stmt = $conn->prepare("SELECT appid from games ORDER BY appid DESC LIMIT 1;");
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $appID = $row["appid"] + 1;
}

$stmt = $conn->prepare("INSERT INTO games (appid, name, developer, positiveVotes, negativeVotes, price, gameImage, gameGenre, gameInfo) VALUES (?,?,?,?,?,?,?,?,?)");
$stmt->bind_param("issssssss", $appID, $gameName, $developer, $positiveVotes, $negativeVotes, $price, $gameImage, $gameGenre, $gameInfo);

if (!$stmt->execute()) {
    $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    $success = false;
    echo $errorMsg;
} else {
    echo 'Game has successfully been added';
    echo '<div class = "text-center"><a href="adminPage.php">'
    . '<button class = "btn btn-outline-secondary mt-auto" style= "background-color: rgb(255, 153, 0);">Return to Admin Page</button></a></div>';
    //$statusMsg = 'Game has successfully been updated';
}
    