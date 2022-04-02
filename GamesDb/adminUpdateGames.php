<?php
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
                    <!-- Three charts -->
                    <!-- ============================================================== -->
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-12">
                            <div class="white-box analytics-info">
                                <h3 class="box-title">Total Visit</h3>
                                <ul class="list-inline two-part d-flex align-items-center mb-0">
                                    <li>
                                        <div id="sparklinedash"><canvas width="67" height="30"
                                                                        style="display: inline-block; width: 67px; height: 30px; vertical-align: top;"></canvas>
                                        </div>
                                    </li>
                                    <li class="ms-auto"><span class="counter text-success">659</span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="white-box analytics-info">
                                <h3 class="box-title">Total Page Views</h3>
                                <ul class="list-inline two-part d-flex align-items-center mb-0">
                                    <li>
                                        <div id="sparklinedash2"><canvas width="67" height="30"
                                                                         style="display: inline-block; width: 67px; height: 30px; vertical-align: top;"></canvas>
                                        </div>
                                    </li>
                                    <li class="ms-auto"><span class="counter text-purple">869</span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="white-box analytics-info">
                                <h3 class="box-title">Unique Visitor</h3>
                                <ul class="list-inline two-part d-flex align-items-center mb-0">
                                    <li>
                                        <div id="sparklinedash3"><canvas width="67" height="30"
                                                                         style="display: inline-block; width: 67px; height: 30px; vertical-align: top;"></canvas>
                                        </div>
                                    </li>
                                    <li class="ms-auto"><span class="counter text-info">911</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- RECENT SALES -->
                    <!-- ============================================================== -->
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-12">
                            <div class="white-box">
                                <div class="d-md-flex mb-3">
                                    <h3 class="box-title mb-0">Games Table</h3>
<!--                                    <div class="col-md-3 col-sm-4 col-xs-6 ms-auto">
                                        <select class="form-select shadow-none row border-top">
                                            <option>March 2021</option>
                                            <option>April 2021</option>
                                            <option>May 2021</option>
                                            <option>June 2021</option>
                                            <option>July 2021</option>
                                        </select>
                                    </div>-->
                                </div>
                                <div class="table-responsive">
                                    <table class="table no-wrap">
                                        <thead>
                                            <tr>
                                                <th class="border-top-0">AppID</th>
                                                <th class="border-top-0">Game Name</th>
                                                <th class="border-top-0">Developer</th>
                                                <th class="border-top-0">Genre</th>
                                                <th class="border-top-0">Price</th>
                                                <th class="border-top-0">Update</th>
                                                <th class="border-top-0">Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = "SELECT * FROM games";
                                            $result = mysqli_query($conn, $query);
                                            if ($result->num_rows > 0) {
                                                // output data of each row
                                                $counter = 1;
                                                while ($row = $result->fetch_assoc()) {
                                                    $gameGenre = $row["gameGenre"];
                                                    $appId = $row["appid"];
                                                    $name = $row["name"];
                                                    $developer = $row["developer"];
                                                    $price = $row["price"];
                                                    $gameImage = $row["gameImage"];
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $appId;  ?></td>
                                                        <td class="txt-oflo"><input class="form-control" id="inputUsername" type="text" value="<?php echo $name; ?>" readonly></td>
                                                        <td class="txt-oflo"><input class="form-control" id="inputUsername" type="text" value="<?php echo $developer; ?>" readonly></td>
                                                        <td class="txt-oflo"><input class="form-control" id="inputUsername" type="text"  value="<?php echo $gameGenre; ?>" readonly></td>
                                                        <td class="txt-oflo"><input class="form-control" id="inputUsername" type="text" value="<?php echo $price; ?>" readonly></td>
                                                <form id="indivGamesForm" name="indivGamesForm" action="adminUpIndiGame.php" method="POST" enctype="multipart/form-data">
                                                    <input type="hidden" name="appId" value='<?php echo $appId; ?>' />
                                                    <td> <button class="btn btn-success" name="adminUpdateAccount" type="submit">Update</button></td>
                                                </form>
                                                <form id="indivGamesForm" name="indivGamesForm" action="processDeleteGame.php" method="POST" enctype="multipart/form-data">
                                                    <input type="hidden" name="appId" value="<?php echo $appId; ?>" />
                                                    <td> <button class="btn btn-outline-danger" name="adminUpdateAccount" type="submit">Delete</button></td>
                                                </form>
                                                    </tr>
                                                    <?php
                                                }
                                            } else {
                                                echo "0 results";
                                                //header('Location: ../cdenoexst');
                                            }
                                            ?>
                                            </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- Recent Comments -->
                    <!-- ============================================================== -->
                    <div class="row">
                        <!-- .col -->
                        <div class="col-md-12 col-lg-8 col-sm-12">
                            <div class="card white-box p-0">
                                <div class="card-body">
                                    <h3 class="box-title mb-0">Recent Comments</h3>
                                </div>
                                <div class="comment-widgets">
                                    <!-- Comment Row -->
                                    <div class="d-flex flex-row comment-row p-3 mt-0">
                                        <div class="p-2"><img src="plugins/images/users/varun.jpg" alt="user" width="50" class="rounded-circle"></div>
                                        <div class="comment-text ps-2 ps-md-3 w-100">
                                            <h5 class="font-medium">James Anderson</h5>
                                            <span class="mb-3 d-block">Lorem Ipsum is simply dummy text of the printing and type setting industry.It has survived not only five centuries. </span>
                                            <div class="comment-footer d-md-flex align-items-center">
                                                <span class="badge bg-primary rounded">Pending</span>

                                                <div class="text-muted fs-2 ms-auto mt-2 mt-md-0">April 14, 2021</div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Comment Row -->
                                    <div class="d-flex flex-row comment-row p-3">
                                        <div class="p-2"><img src="plugins/images/users/genu.jpg" alt="user" width="50" class="rounded-circle"></div>
                                        <div class="comment-text ps-2 ps-md-3 active w-100">
                                            <h5 class="font-medium">Michael Jorden</h5>
                                            <span class="mb-3 d-block">Lorem Ipsum is simply dummy text of the printing and type setting industry.It has survived not only five centuries. </span>
                                            <div class="comment-footer d-md-flex align-items-center">

                                                <span class="badge bg-success rounded">Approved</span>

                                                <div class="text-muted fs-2 ms-auto mt-2 mt-md-0">April 14, 2021</div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Comment Row -->
                                    <div class="d-flex flex-row comment-row p-3">
                                        <div class="p-2"><img src="plugins/images/users/ritesh.jpg" alt="user" width="50" class="rounded-circle"></div>
                                        <div class="comment-text ps-2 ps-md-3 w-100">
                                            <h5 class="font-medium">Johnathan Doeting</h5>
                                            <span class="mb-3 d-block">Lorem Ipsum is simply dummy text of the printing and type setting industry.It has survived not only five centuries. </span>
                                            <div class="comment-footer d-md-flex align-items-center">

                                                <span class="badge rounded bg-danger">Rejected</span>

                                                <div class="text-muted fs-2 ms-auto mt-2 mt-md-0">April 14, 2021</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <div class="card white-box p-0">
                                <div class="card-heading">
                                    <h3 class="box-title mb-0">Chat Listing</h3>
                                </div>
                                <div class="card-body">
                                    <ul class="chatonline">
                                        <li>
                                            <div class="call-chat">
                                                <button class="btn btn-success text-white btn-circle btn" type="button">
                                                    <i class="fas fa-phone"></i>
                                                </button>
                                                <button class="btn btn-info btn-circle btn" type="button">
                                                    <i class="far fa-comments text-white"></i>
                                                </button>
                                            </div>
                                            <a href="javascript:void(0)" class="d-flex align-items-center"><img
                                                    src="plugins/images/users/varun.jpg" alt="user-img" class="img-circle">
                                                <div class="ms-2">
                                                    <span class="text-dark">Varun Dhavan <small
                                                            class="d-block text-success d-block">online</small></span>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <div class="call-chat">
                                                <button class="btn btn-success text-white btn-circle btn" type="button">
                                                    <i class="fas fa-phone"></i>
                                                </button>
                                                <button class="btn btn-info btn-circle btn" type="button">
                                                    <i class="far fa-comments text-white"></i>
                                                </button>
                                            </div>
                                            <a href="javascript:void(0)" class="d-flex align-items-center"><img
                                                    src="plugins/images/users/genu.jpg" alt="user-img" class="img-circle">
                                                <div class="ms-2">
                                                    <span class="text-dark">Genelia
                                                        Deshmukh <small class="d-block text-warning">Away</small></span>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <div class="call-chat">
                                                <button class="btn btn-success text-white btn-circle btn" type="button">
                                                    <i class="fas fa-phone"></i>
                                                </button>
                                                <button class="btn btn-info btn-circle btn" type="button">
                                                    <i class="far fa-comments text-white"></i>
                                                </button>
                                            </div>
                                            <a href="javascript:void(0)" class="d-flex align-items-center"><img
                                                    src="plugins/images/users/ritesh.jpg" alt="user-img" class="img-circle">
                                                <div class="ms-2">
                                                    <span class="text-dark">Ritesh
                                                        Deshmukh <small class="d-block text-danger">Busy</small></span>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <div class="call-chat">
                                                <button class="btn btn-success text-white btn-circle btn" type="button">
                                                    <i class="fas fa-phone"></i>
                                                </button>
                                                <button class="btn btn-info btn-circle btn" type="button">
                                                    <i class="far fa-comments text-white"></i>
                                                </button>
                                            </div>
                                            <a href="javascript:void(0)" class="d-flex align-items-center"><img
                                                    src="plugins/images/users/arijit.jpg" alt="user-img" class="img-circle">
                                                <div class="ms-2">
                                                    <span class="text-dark">Arijit
                                                        Sinh <small class="d-block text-muted">Offline</small></span>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <div class="call-chat">
                                                <button class="btn btn-success text-white btn-circle btn" type="button">
                                                    <i class="fas fa-phone"></i>
                                                </button>
                                                <button class="btn btn-info btn-circle btn" type="button">
                                                    <i class="far fa-comments text-white"></i>
                                                </button>
                                            </div>
                                            <a href="javascript:void(0)" class="d-flex align-items-center"><img
                                                    src="plugins/images/users/govinda.jpg" alt="user-img"
                                                    class="img-circle">
                                                <div class="ms-2">
                                                    <span class="text-dark">Govinda
                                                        Star <small class="d-block text-success">online</small></span>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <div class="call-chat">
                                                <button class="btn btn-success text-white btn-circle btn" type="button">
                                                    <i class="fas fa-phone"></i>
                                                </button>
                                                <button class="btn btn-info btn-circle btn" type="button">
                                                    <i class="far fa-comments text-white"></i>
                                                </button>
                                            </div>
                                            <a href="javascript:void(0)" class="d-flex align-items-center"><img
                                                    src="plugins/images/users/hritik.jpg" alt="user-img" class="img-circle">
                                                <div class="ms-2">
                                                    <span class="text-dark">John
                                                        Abraham<small class="d-block text-success">online</small></span>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- /.col -->
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