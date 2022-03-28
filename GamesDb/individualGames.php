<!DOCTYPE html>
<html lang="en">
    <?php
    include "head.inc.php";
    ?>
    <body id="page-top">
        <?php
        include "navPostLogin.inc.php";
        ?>

        <?php
        $appId = $_POST['appId'];

        $query = "SELECT * FROM games where appid = " . $appId;
        $result = mysqli_query($conn, $query);
        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {
                echo '<header class="masthead">';
                echo '<div class="container">';

                $gameGenre = $row["gameGenre"];
                $appId = $row["appid"];
                $name = $row["name"];
                $developer = $row["developer"];
                $positiveVotes = $row["positiveVotes"];
                $negativeVotes = $row["negativeVotes"];
                $totalVotes = $positiveVotes + $negativeVotes; // to show ratings upon 5 stars
                $price = $row["price"];
                $gameImage = $row["gameImage"];

                echo '<h1 class="my-4">' . $name . '</h1>';
                echo '<div class="row">';
                echo '<div class = "col-md-8">';
                echo '<img class = "img-fluid" width="100%" src = "' . $gameImage . '" alt = "Image of ' . $name . '">';
                echo '</div>';
                echo '<div class = "col-md-4">';
                echo '<h3 class="my-3">Description</h3>';
                echo '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod odio, gravida pellentesque urna varius vitae. Sed dui lorem, adipiscing in adipiscing et, interdum nec metus. Mauris ultricies, justo eu convallis placerat, felis enim.</p>';
                echo '<h5 class = "my-3">Genre : ' . ucfirst($gameGenre) . '</h5>';
                echo '<h5 class = "my-3">Positive Votes : ' . $positiveVotes . '</h5>';
                echo '<h5 class = "my-3">Negative Votes : ' . $negativeVotes . '</h5>';

                echo '<h5 class = "my-3">Rating : ';
                $rating = ($positiveVotes / $totalVotes) * 5;
                $rating_quotient = intdiv($rating, 1);
                $rating_remainder = $rating / 1;

                $rating_remainder = $rating_remainder - floor($rating_remainder);
                if ($rating_remainder >= 0.5) {
                    $rating_remainder = 1;
                } else {
                    $rating_remainder = 0;
                }

                // full stars
                for ($x = 0; $x < $rating_quotient; $x++) {
                    echo '<i class="bi bi-star-fill"></i>';
                }

                // half stars
                for ($x = 0; $x < $rating_remainder; $x++) {
                    echo '<i class="bi bi-star-half"></i>';
                }

                // empty stars
                for ($x = 0; $x < 5 - ($rating_quotient + $rating_remainder); $x++) {
                    echo '<i class="bi bi-star"></i>';
                }
                echo '</h5>';

                echo '<h5 class = "my-3">Developer : ' . $developer . '</h5>';
                echo '<br>';
                echo '<div class = "card-footer p-4 pt-0 border-top-0 bg-transparent">';

                // IDEA: if user havent buy, show add to cart button
                // can get this data from ORDERS table
                echo '<form id = "addToCartForm" name = "addToCartForm" action = "addToCart.php" method = "POST" enctype = "multipart/form-data">';
                echo '<input type = "hidden" name = "appId" value = "' . $appId . '" />';
                echo '<div class="d-flex justify-content-center">';
                echo '<div style="display:block;padding: 0.375rem 0.75rem;">';
                // if price == 0, display 'Free to play!' instead of $0
                if ($price == '0') {
                    echo 'Free to play!';
                } else {
                    echo '$' . $price;
                }
                echo '</div>'; // price to be side by side with add to cart button
                echo '<button class = "btn btn-outline-success " type = "submit">Add to Cart!</button></div>';
                echo '</form>';
                echo '</div>'; // closing tag for col-md-8
                echo '</div>'; // closing tag for row
//                echo '</div>';
//                echo '</div>';
//                echo '</div>';
//                echo '</header>';
            }
        } else {
            echo "0 results";
        }
        ?>

        <?php
        // show current reviews
        echo '<div class="row">';
        echo '<h3 class="my-3">Reviews</h3>';
        $query2 = "SELECT * FROM reviews where games_appid = " . $appId." AND review != ''";
        $result2 = mysqli_query($conn, $query2);
        if ($result2->num_rows > 0) {
            while ($row2 = $result2->fetch_assoc()) {
                $username = ucfirst($row2['users_username']);
                $review = $row2['review'];              
                
                echo '<div class="row">';
                echo '<p style="border-top: 2px solid #e2e2e2; padding: 2px;"></p>';
                echo '<h5 class = "my-3">' . $username . '</h5>';
                echo '<p>' . $review . '</p>';
                echo '<p></p>';
                echo '</div>';
            }
        }
        else{
            echo "<div class='text-center'><h5>No reviews!</h5></div>";
        }
        echo '</div>';

        // IDEA: if user buy alr, show add review button
        // can get this data from ORDERS table
        echo '<div class="row">';
        echo '<form id = "addRatingsForm" name = "addRatingsForm" action = "processReview.php" method = "POST" enctype = "multipart/form-data">';
        echo '<h4 class = "my-3">Please tell us your experience with the game!</h4>';
        echo '<div class="row>';
        echo '<div class = "col-md-12">';
        echo '<div class = "form-group">';
        echo '<button class="btn btn-outline-success"><i class="bi bi-hand-thumbs-up"></i></button>';
        echo '<button class="btn btn-outline-danger"><i class="bi bi-hand-thumbs-down"></i></button>';
        echo '</div>';
        echo '</div>';
        echo '<div class = "col-md-12">';
        echo '<div class = "form-group">';
        echo '<textarea class = "form-input" required = "" placeholder = "Your text"></textarea>';
        echo '</div>';
        echo '</div>';
        echo '<a class = "btn btn-outline-primary pull-right" type = "submit">Submit Review!</a>';
        echo '</form>';
        echo '</div>';
        echo '</div>';
        ?>

        </div>
        </div>
        </div>
        </header>

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
