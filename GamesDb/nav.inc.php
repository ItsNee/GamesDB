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
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="bi-list"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto me-4 my-3 my-lg-0">
                    </ul>
                    <button class="btn btn-primary rounded-pill px-3 mb-2 mb-lg-0" data-bs-toggle="modal" data-bs-target="#signInModal">
                        <span class="d-flex align-items-center">
                            <i class="bi bi-box-arrow-in-right me-2"></i>
                            <span class="small">Sign in</span>
                        </span>
                    </button>
                    &nbsp;&nbsp;
                    <button class="btn btn-primary rounded-pill px-3 mb-2 mb-lg-0" data-bs-toggle="modal" data-bs-target="#registerModal">
                        <span class="d-flex align-items-center">
                            <i class="bi bi-person-plus me-2"></i>
                            <span class="small">Register</span>
                        </span>
                    </button>
                </div>
            </div>
        </nav>