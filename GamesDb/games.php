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

                                        echo '<a class="dropdown-item" value="all">All Games</a>';

                                        $query = "SELECT DISTINCT gameGenre FROM games";
                                        $result = mysqli_query($conn, $query);
                                        if ($result->num_rows > 0) {
                                            // output data of each row
                                            while ($row = $result->fetch_assoc()) { // $row = array $results[x] where x is loop counter
                                                $gameGenre = $row["gameGenre"];
                                                echo '<a class="dropdown-item" value="' . $gameGenre . '">' . ucfirst($gameGenre) . '</a>';
                                            }
                                        } else {
                                            echo "0 results";
                                        }
                                        ?>                                        
                                    </div>
                                </div>
                                <form id="searchGamesForm" class="input-group justify-content-end" action="" method="POST" enctype="multipart/form-data">
                                    <div class="form-outline">
                                        <input type="search" name="searchTerm" class="form-control form-control-lg" placeholder="Search for games here!"/>                                        
                                    </div>        
                                    <button id="submitBtn" type="submit" name="searchQuery" class="btn btn-primary">
                                        <i class="bi bi-search"></i>
                                    </button>                                    
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php
        if (isset($_POST['searchQuery'])) {
            $searchTerm = $_POST['searchTerm'];
            displayGames($searchTerm);
        } else {
            displayGames("");
        }

        function displayGames($search) {
            include "db.inc.php";

            //query the DB
            if ($search == "") {
                $query = 'SELECT * FROM games';
            } else {
                $query = 'SELECT * FROM games where name LIKE "%' . $search . '%" OR developer LIKE "%' . $search . '%" OR price LIKE "%' . $search . '%" OR gameGenre LIKE "%' . $search . '%";';
            }

            $result = mysqli_query($conn, $query);
            echo '<section class = "py-5">';
            echo '<div class = "container px-4 px-lg-5 mt-5">';
            echo '<div class = "row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">';

            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) { // $row = array $results[x] where x is loop counter
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
                    echo '<img class = "card-img-top" src="' . $gameImage . '" alt="Image of ' . ucfirst($name) . '" />';
                    echo '<!--Product details-->';
                    echo '<div class = "card-body p-4">';
                    echo '<div class = "text-center">';
                    echo '<!--Product name-->';
                    echo '<h5 class = "fw-bolder">' . ucfirst($name) . '</h5>';
                    echo '<p class = "card-text">' . ucfirst($gameGenre) . '</p>';
                    echo '<!--Product price-->';
                    // if price == 0, display 'Free to play!' instead of $0
                    if ($price == '0') {
                        echo '<p class = "card-text">Free to play!</p>';
                    } else {
                        echo '<p class = "card-text">$' . $price . '</p>';
                    }
                    echo '</div>';
                    echo '</div>';
                    echo '<!--Product actions-->';
                    // form button brings appId of selected game to individual games page
                    echo '<div class = "card-footer p-4 pt-0 border-top-0 bg-transparent">';
                    echo '<form id="indivGamesForm" name="indivGamesForm" action="individualGames.php" method="POST" enctype="multipart/form-data">';
                    echo '<input type="hidden" name="appId" value="' . $appId . '" />';
                    echo '<div class = "text-center"><button class = "btn btn-outline-primary mt-auto" type="submit">View more!</button></div>';
                    echo '</form>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "0 results";
            }

            echo '</div>';
            echo '</div>';
            echo '</section>';
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
