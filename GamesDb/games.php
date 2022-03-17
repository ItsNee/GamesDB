<!DOCTYPE html>
<html lang="en">
    <?php
    //nee test edit
    include "head.inc.php";
    ?>
    <body id="page-top">
        <?php
        include "navPostLogin.inc.php";
        ?>

        <section id="searchBar_and_filter" class="intro">
            <div class="d-flex h-50">
                <div class="container">                    
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="d-flex ">                                
                                <div class="input-group justify-content-start dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-target="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Filter by Genre
                                    </button>
                                    <div class="dropdown-menu" id="dropdownMenuButton">
                                        <!--get distinct genres-->
                                        <!--find ways to select data based on selected genre-->
                                        <?php
                                        include "db.inc.php";

                                        $query = "SELECT DISTINCT gameGenre FROM games";
                                        $result = mysqli_query($conn, $query);
                                        if ($result->num_rows > 0) {
                                            // output data of each row
                                            while ($row = $result->fetch_assoc()) {
                                                $gameGenre = $row["gameGenre"];
                                                echo '<a class="dropdown-item" href="#">' . ucfirst($gameGenre) . '</a>';
                                            }
                                        } else {
                                            echo "0 results";
                                        }
                                        ?>                                        
                                    </div>
                                </div>
                                <div class="input-group justify-content-end">
                                    <div class="form-outline">
                                        <input type="search" id="form1" class="form-control form-control-lg" placeholder="Search for games here!"/>                                        
                                    </div>        
                                    <button type="button" class="btn btn-primary">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <?php
        //sleep
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
                echo '<form id="indivGamesForm" name="indivGamesForm" action="individualGames.php" method="POST" enctype="multipart/form-data">';
                echo '<input type="hidden" name="appId" value="' . $appId . '" />';
                echo '<div class = "text-center"><button class = "btn btn-outline-secondary mt-auto" type="submit">View more!</button></div>';
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
