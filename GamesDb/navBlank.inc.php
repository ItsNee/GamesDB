<?php
include "db.inc.php";
//CheckValidUser
session_start();
if (isset($_SESSION['username']) == true) {
    $username = $_SESSION['username'];
    $email = $_SESSION['email'];
    header("location: home.php");
}
?>
<!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light fixed-top shadow-sm" id="mainNav">
            <div class="container px-5">
                <a class="navbar-brand fw-bold" href="index.php">GamesDB</a>
            </div>
        </nav>