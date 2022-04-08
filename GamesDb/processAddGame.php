<?php
// Session Management
session_start();
if ($_SESSION['isAdmin'] == "1") {
    $l = 1;
} else {
    header("location: index.php");
}
include "db.inc.php";
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="keywords"
              content="GamesDB">
        <meta name="description"
              content="GamesDB Admin Page">
        <meta name="robots" content="noindex,nofollow">
        <title>GamesDB Admin Page</title>
        <!-- Favicon icon -->
        <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon.ico">
        <!-- Custom CSS -->
        <link href="plugins/bower_components/chartist/dist/chartist.min.css" rel="stylesheet">
        <link rel="stylesheet" href="plugins/bower_components/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.css">
        <!-- Custom CSS -->
        <link href="css/style.min.css" rel="stylesheet">
    </head>

    <body>
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Main wrapper - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full"
             data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
            <!-- ============================================================== -->
            <!-- Topbar header - style you can find in pages.scss -->
            <!-- ============================================================== -->
            <header class="topbar" data-navbarbg="skin5">
                <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">

                        <!-- ============================================================== -->
                        <!-- Right side toggle and nav items -->
                        <!-- ============================================================== -->
                        <ul class="navbar-nav ms-auto d-flex align-items-center">
                            <!-- ============================================================== -->
                            <!-- User profile and search -->
                            <!-- ============================================================== -->
                            <li>
                                <a class="profile-pic" href="#">
                                    <!--<img src="plugins/images/users/varun.jpg" alt="user-img" width="36"class="img-circle">-->
                                    <span class="text-white font-medium">Admin</span></a>
                            </li>
                            <!-- ============================================================== -->
                            <!-- User profile and search -->
                            <!-- ============================================================== -->
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- ============================================================== -->
            <!-- End Topbar header -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Left Sidebar - style you can find in sidebar.scss  -->
            <!-- ============================================================== -->
            <aside class="left-sidebar" data-sidebarbg="skin6">
                <!-- Sidebar scroll-->
                <div class="scroll-sidebar">
                    <!-- Sidebar navigation-->
                    <nav class="sidebar-nav">
                        <ul id="sidebarnav">
                            <!-- User Profile-->
                            <li class="sidebar-item">
                                <a class="sidebar-link waves-effect waves-dark sidebar-link" href="admin.php"
                                   aria-expanded="false">
                                    <i class="far fa-clock" aria-hidden="true"></i>
                                    <span class="hide-menu">Dashboard</span>
                                </a>
                            </li>
                            <li class="sidebar-item pt-2">
                                <a class="sidebar-link waves-effect waves-dark sidebar-link" href="adminUsers.php"
                                   aria-expanded="false">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    <span class="hide-menu">Users</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link waves-effect waves-dark sidebar-link" href="adminReviews.php"
                                   aria-expanded="false">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    <span class="hide-menu">Reviews</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link waves-effect waves-dark sidebar-link" href="adminAddGame.php"
                                   aria-expanded="false">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    <span class="hide-menu">Add Games</span>
                                </a>
                            </li>
                            <li class="sidebar-item">
                                <a class="sidebar-link waves-effect waves-dark sidebar-link" href="adminUpdateGames.php"
                                   aria-expanded="false">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    <span class="hide-menu">Update/Delete Games</span>
                                </a>
                            </li>
                        </ul>

                    </nav>
                    <!-- End Sidebar navigation -->
                </div>
                <!-- End Sidebar scroll-->
            </aside>
            <!-- ============================================================== -->
            <!-- End Left Sidebar - style you can find in sidebar.scss  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Page wrapper  -->
            <!-- ============================================================== -->
            <div class="page-wrapper">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="page-breadcrumb bg-white">
                    <div class="row align-items-center">
                        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                            <h4 class="page-title">Dashboard</h4>
                        </div>
                        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                            <div class="d-md-flex">
                                <ol class="breadcrumb ms-auto">
                                    <li><a href="admin.php" class="fw-normal">Dashboard</a></li>
                                </ol>
                                <a href="https://gamesdb.fun/" target="_blank"
                                   class="btn btn-danger  d-none d-md-block pull-right ms-3 hidden-xs hidden-sm waves-effect waves-light text-white">Back to GamesDB</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Container fluid  -->
                <!-- ============================================================== -->
                <div class="container-fluid">

                    <!-- ============================================================== -->
                    <!-- RECENT SALES -->
                    <!-- ============================================================== -->
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-12">
                            <div class="white-box">
                                <?php
                                include "db.inc.php";

                                $success = true;
                                $errorMsg = "";
                                
                                // Check for invalid characters
                                function specialChar($data) {
                                    global $success, $errorMsg;
                                    $signs = "/([<>])/";
                                    if (preg_match($signs, $data) and $success) {
                                        $success = false;
                                        $errorMsg .= "Please remove any invalid characters such as '<>'<br>";
                                        return $data;
                                    } else {

                                        return $data;
                                    }
                                }
                                
                                // Getting post request parameters
                                $gameName = specialChar($_POST['gameName']);
                                $developer = specialChar($_POST['developer']);
                                $price = specialChar($_POST['price']);
                                $gameGenre = specialChar($_POST['gameGenre']);
                                specialChar($_POST['image']);
                                $positiveVotes = "0";
                                $negativeVotes = "0";
                                $gameInfo = specialChar($_POST['gameInfo']);
                                $gameImage = specialChar($_POST['gameImage']);
                                
                                // Check if empty
                                if (empty($gameName) || empty($developer) || empty($gameGenre)  || empty($_POST['image'])) {
                                    $errorMsg .= "Fill up the required fields (e.g. Name, Developer, Genre)<br>";
                                    $success = false;
                                }
                                
                                // If price is empty, set to 0 (Free to Play)
                                if (empty($price)) {
                                    $price = "0";
                                }

                                // Check if price is negative
                                if ($price < 0) {
                                    $success = false;
                                    $errorMsg .= "Price cannot be negative <br>";
                                }

                                // If upload image URL
                                if ($_POST['image'] == 1) {
                                    $gameImage = specialChar($_POST['gameImage1']);
                                    // If image not uploaded, set as default image
                                    if (empty($gameImage)) {
                                        $target_dir = "uploads/";
                                        $filename = "default.JPG";
                                        $imagePath = $target_dir . $filename;
                                    } else {
                                        $imagePath = $gameImage;
                                    }

                                    // If upload image file to backend
                                } else if ($_POST['image'] == 2) {
                                    $gameImage = specialChar($_POST['gameImage2']);
                                    if (($_FILES['gameImage2']['name'] != "")) {
                                        // Where the file is going to be stored
                                        $target_dir = "uploads/";
                                        $file = $_FILES['gameImage2']['name'];
                                        $path = pathinfo($file);
                                        $filename = $path['filename'];
                                        $ext = $path['extension'];
                                        $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'JPG', 'PNG', 'GIF');
                                        $temp_name = $_FILES['gameImage2']['tmp_name'];
                                        $imagePath = $target_dir . $filename . "." . $ext;
                                        if (in_array($ext, $allowTypes)) {
                                            if (file_exists($imagePath)) {
                                                
                                            } else {
                                                move_uploaded_file($temp_name, $imagePath);
                                            }
                                        } else {
                                            $success = false;
                                            $errorMsg .= "Only JPG, JPEG, PNG & GIF files are allowed to upload as the game image.<br>";
                                        }
                                    }  
                                    // If image not uploaded, set as default image
                                    else {
                                        $target_dir = "uploads/";
                                        $filename = "default.JPG";
                                        $imagePath = $target_dir . $filename;
                                    }
                                }
                                // If invalid radio value
                                else {
                                    $success = false;
                                }

                                // Getting largest appID from Games table to increment by 1 can use it as the appID of added game
                                if ($success) {
                                    $stmt = $conn->prepare("SELECT appid from games ORDER BY appid DESC LIMIT 1;");
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    if ($result->num_rows > 0) {
                                        $row = $result->fetch_assoc();
                                        $appID = $row["appid"] + 1;
                                    } 
                                    // If database is empty
                                    else {
                                        $appID = 1;
                                    }

                                    $stmt = $conn->prepare("INSERT INTO games (appid, name, developer, positiveVotes, negativeVotes, price, gameImage, gameGenre, gameInfo) VALUES (?,?,?,?,?,?,?,?,?)");
                                    $stmt->bind_param("issssssss", $appID, $gameName, $developer, $positiveVotes, $negativeVotes, $price, $imagePath, $gameGenre, $gameInfo);

                                    if (!$stmt->execute()) {
                                        $errorMsg = "Something went wrong. Please try again";
                                        echo $errorMsg;
                                        echo '<div class = "text-center"><a href="admin.php">'
                                        . '<button class = "btn btn-outline-secondary mt-auto" style= "background-color: rgb(255, 153, 0);">Return to Admin Page</button></a></div>';

                                        echo '<br><div class = "text-center"><a href="adminAddGame.php">'
                                        . '<button class = "btn btn-outline-secondary mt-auto" style= "background-color: rgb(255, 153, 0);">Return to Add Game Page</button></a></div>';
                                    } else {
                                        echo 'Game has successfully been added';
                                        echo '<div class = "text-center"><a href="admin.php">'
                                        . '<button class = "btn btn-outline-secondary mt-auto" style= "background-color: rgb(255, 153, 0);">Return to Admin Page</button></a></div>';

                                        echo '<br><div class = "text-center"><a href="adminAddGame.php">'
                                        . '<button class = "btn btn-outline-secondary mt-auto" style= "background-color: rgb(255, 153, 0);">Return to Add Game Page</button></a></div>';
                                    }
                                } else {
                                    echo "<h4>The following errors are found:</h4><br>";
                                    echo $errorMsg;
                                    echo '<div class = "text-center"><a href="admin.php">'
                                    . '<button class = "btn btn-outline-secondary mt-auto" style= "background-color: rgb(255, 153, 0);">Return to Admin Page</button></a></div>';

                                    echo '<br><div class = "text-center"><a href="adminAddGame.php">'
                                    . '<button class = "btn btn-outline-secondary mt-auto" style= "background-color: rgb(255, 153, 0);">Return to Add Game Page</button></a></div>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center"> 2022 © <a
                    href="https://gamesdb.fun/">GamesDB</a>
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/app-style-switcher.js"></script>
    <script src="plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js"></script>
    <!--Wave Effects -->
    <script src="js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="js/custom.js"></script>
    <!--This page JavaScript -->
    <!--chartis chart-->
    <script src="plugins/bower_components/chartist/dist/chartist.min.js"></script>
    <script src="plugins/bower_components/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
    <script src="js/pages/dashboards/dashboard1.js"></script>
</body>

</html>