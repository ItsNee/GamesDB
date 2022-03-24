<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/ClientSide/html.html to edit this template
-->
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Update/Delete Games</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Google fonts-->
        <link rel="preconnect" href="https://fonts.gstatic.com" />
        <link href="https://fonts.googleapis.com/css2?family=Newsreader:ital,wght@0,600;1,600&amp;display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,300;0,500;0,600;0,700;1,300;1,500;1,600;1,700&amp;display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,400;1,400&amp;display=swap" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light fixed-top shadow-sm" id="mainNav">
            <div class="container px-5">
                <a class="navbar-brand fw-bold" href="#page-top">Start Bootstrap</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="bi-list"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto me-4 my-3 my-lg-0">
                        <li class="nav-item"><a class="nav-link me-lg-3" href="#features">Features</a></li>
                        <li class="nav-item"><a class="nav-link me-lg-3" href="#download">Download</a></li>
                    </ul>
                    <button class="btn btn-primary rounded-pill px-3 mb-2 mb-lg-0" data-bs-toggle="modal" data-bs-target="#feedbackModal">
                        <span class="d-flex align-items-center">
                            <i class="bi-chat-text-fill me-2"></i>
                            <span class="small">Send Feedback</span>
                        </span>
                    </button>
                </div>
            </div>
        </nav>
        
        <?php
        //hihi
        include "db.inc.php";

        $query = "SELECT * FROM games";
        $result = mysqli_query($conn, $query);
        if ($result->num_rows > 0) {

            echo '<section class = "py-5">';
            echo '<div class = "container px-4 px-lg-5 mt-5">';
            echo '<div class = "row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">';

            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $gameGenre = $row["gameGenre"];
                $appId = $row["appid"];
                $name = $row["name"];
                $developer = $row["developer"];
                $positiveVotes = $row["positiveVotes"];
                $negativeVotes = $row["negativeVotes"];
                $price = $row["price"];
                $gameImage = $row["gameImage"];

                echo '<div class = "col mb-5">';
                echo '<div class = "card h-100">';
                echo '<!--Product image-->';
                echo '<img class = "card-img-top" src="' . $gameImage . '" alt="Image of ' . $name . '" />';
                echo '<!--Product details-->';
                echo '<div class = "card-body p-4">';
                echo '<div class = "text-center">';
                echo '<!--Product name-->';
                echo '<h5 class = "fw-bolder">' . $name . '</h5>';
                echo '<p class = "card-text">' . $gameGenre . '</p>';
                echo '<!--Product price-->';
                if ($price == '0'){
                    echo '<p class = "card-text">Free to play!</p>';                    
                }
                else{
                    echo '<p class = "card-text">$' . $price . '</p>';
                }
                echo '</div>';
                echo '</div>';
                echo '<!--Product actions-->';
                echo '<div class = "card-footer p-4 pt-0 border-top-0 bg-transparent">';
                echo '<form id="indivGamesForm" name="indivGamesForm" action="updateIndiviGame.php" method="POST" enctype="multipart/form-data">';
                echo '<input type="hidden" name="appId" value="' . $appId . '" />';
                echo '<div class = "text-center"><button class = "btn btn-outline-secondary mt-auto" type="submit">Update</button></div>';
                echo '</form><br>';
                
                echo '<form id="indivGamesForm" name="indivGamesForm" action="processDeleteGame.php" method="POST" enctype="multipart/form-data">';
                echo '<input type="hidden" name="appId" value="' . $appId . '" />';
                echo '<div class = "text-center"><button class = "btn btn-outline-secondary mt-auto" type="submit">Delete</button></div>';
                echo '</form>';
                
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }

            echo '</div>';
            echo '</div>';
            echo '</section>';
        } else {
            echo "0 results";
        }
        ?>  
    </div>
</div>
        
        
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
