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
                            <form id="filterGamesForm" action="" method="POST" enctype="multipart/form-data"> 
                                <div id="filterGames">
                                    <select class="btn dropdown-toggle" name="filter" id="filter" style="border-color: #2937f0;">
                                        <?php
                                        include './db.inc.php';
                                        echo '<option value="">All games</option>';

                                        $query = "SELECT DISTINCT gameGenre FROM games";
                                        $result = mysqli_query($conn, $query);
                                        if ($result->num_rows > 0) {
                                            // output data of each row
                                            while ($row = $result->fetch_assoc()) { // $row = array $results[x] where x is loop counter
                                                $gameGenre = $row["gameGenre"];
                                                echo '<option value="' . $gameGenre . '">' . ucfirst($gameGenre) . '</option>';
                                            }
                                        } else {
                                            echo "0 results";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div id="searchGames">
                                    <div class="form-outline">
                                        <input type="search" name="searchTerm" class="form-control" placeholder="Search for games here!"/>                                        
                                    </div>        
                                    <button id="submitBtn" type="submit" name="searchQuery" class="btn btn-primary">
                                        <i class="bi bi-search"></i>
                                    </button>        
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php
        // if search term is entered and filter is selected
        if (isset($_POST['searchQuery']) && isset($_POST['filter'])) {
            $searchTerm = $_POST['searchTerm'];
            $filter = $_POST['filter'];
            displayGames($searchTerm, $filter);
        }
        // if search term is entered and filter is not selected
        elseif (isset($_POST['searchQuery']) && !isset($_POST['filter'])) {
            $searchTerm = $_POST['searchTerm'];
            displayGames($searchTerm, "");
        }
        // if search term is not entered and filter is selected
        elseif (!isset($_POST['searchQuery']) && isset($_POST['filter'])) {
            $filter = $_POST['filter'];
            displayGames("", $filter);
        }
        // if search term is not entered and filter is not selected
        else {
            displayGames("", "");
        }

        function displayGames($search, $filter) {
            include "db.inc.php";

            //query the DB
            if ($search == "" && $filter == "") { // show everything
                $query = 'SELECT * FROM games';
            } elseif ($search != "" && $filter == "") { // search all possible columns
                $query = 'SELECT * FROM games where name LIKE "%' . $search . '%" OR developer LIKE "%' . $search . '%" OR price LIKE "%' . $search . '%" OR gameGenre LIKE "%' . $search . '%";';
            } elseif ($search == "" && $filter != "") { // show games with selected game genre
                $query = 'SELECT * FROM games where gameGenre LIKE "%' . $filter . '%";';
            } else { // show games given selected game genre and other search terms
                $query = 'SELECT * FROM games where (name LIKE "%' . $search . '%" OR developer LIKE "%' . $search . '%" OR price LIKE "%' . $search . '%") AND gameGenre LIKE "%' . $filter . '%";';
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
                    echo '<div class = "text-center"><button class = "btn btn-outline-primary mt-auto" name="viewMore" type="submit">View more!</button></div>';
                    echo '</form>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "<div class='text-center'><h5>No results found!</h5></div>";
            }

            echo '</div>';
            echo '</div>';
            echo '</section>';
        }
        ?>


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
