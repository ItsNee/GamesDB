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
        // if user clicked on submit review btn, update relevant votes and reviews and refresh page
        if (isset($_POST['submitReview'])) {
            $appId = $_REQUEST['appId2'];
            if (isset($_POST['thumbs_up'])) {
                //get positive votes 
                $query3 = "SELECT positiveVotes FROM games where appid = " . $appId;
                $result3 = mysqli_query($conn, $query3);
                if ($result3->num_rows > 0) {
                    while ($row3 = $result3->fetch_assoc()) {
                        $rating = (int) $row3['positiveVotes'];
                        $rating++;
                    }
                }
                // update positive votes
                $query4 = $conn->prepare("UPDATE games SET positiveVotes=? WHERE appid=?"); //prepared statement
                $query4->bind_param("ss", $rating, $appId); //bind the parameters
                if (!$query4->execute()) {
                    $errorMsg = "Execute failed: (" . $query4->errno . ") " . $query4->error;
                    $success = false;
                    echo $errorMsg;
                } else {
                    $success = true;
                }
            } elseif (isset($_POST['thumbs_down'])) {
                //get negative votes 
                $query3 = "SELECT negativeVotes FROM games where appid = " . $appId;
                $result3 = mysqli_query($conn, $query3);
                if ($result3->num_rows > 0) {
                    while ($row3 = $result3->fetch_assoc()) {
                        $rating = (int) $row3['negativeVotes'];
                        $rating++;
                    }
                }
                // update negative votes
                $query4 = $conn->prepare("UPDATE games SET negativeVotes=? WHERE appid=?"); //prepared statement
                $query4->bind_param("ss", $rating, $appId); //bind the parameters
                if (!$query4->execute()) {
                    $errorMsg = "Execute failed: (" . $query4->errno . ") " . $query4->error;
                    $success = false;
                } else {
                    $success = true;
                }
            }
            // if user click on submit review btn but never check thumbs up/down btn
            else {
                $success = false;
                $errorMsg = "Please indicate how you feel about the game via the thumbs up or down button before submitting your review!";
                // show modal/popup showing error msg 
                ?>

                <!--         review error Modal
                <div class="modal fade" id="reviewErrorModal" role="dialog" tabindex="-1" aria-labelledby="reviewErrorModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-gradient-primary-to-secondary p-4">
                                <h5 class="modal-title font-alt text-white" id="reviewErrorModalLabel">Error submitting reviews!</h5>
                                <button class="btn-close btn-close-white" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body border-0 p-4">
                                <p>Please indicate how you feel about the game via the thumbs up or down button before submitting your review!"</p>                        
                                 Close Button
                                <div class="d-grid"><button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button></div>                       
                            </div>
                        </div>
                    </div>
                </div>-->

                <?php
//                echo '<script type="text/javascript"> showReviewErrorMessage(); </script>';        
                echo '<script type="text/javascript"> alert("' . $errorMsg . '") </script>';
            }

            if ($success == true) {
                // get user reviews if they wrote something
                $reviews = htmlspecialchars($_REQUEST['usrReviews']);
                if (!$reviews == "") {
                    $query5 = $conn->prepare("INSERT INTO reviews (users_username, games_appid, review) VALUES (?, ?, ?)"); //prepared statement
                    $query5->bind_param("sis", $username, $appId, $reviews); //bind the parameters
                    if (!$query5->execute()) {
                        $errorMsg = "Execute failed: (" . $query5->errno . ") " . $query5->error;
                        echo $errorMsg;
                        $success = false;
                        echo $errorMsg;
                    } else {
                        $success = true;
                    }
                }
            }


            // show individual game data
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

                    echo '<div class="d-flex justify-content-center">';
                    echo '<div style="display:block;padding: 0.375rem 0.75rem;">';

                    
                    // if user havent buy, show add to cart button
                    $getPurchasedGamesQuery = "SELECT distinct appid FROM orderDetails where orderid in (select orderid from orders where username = '" . $username . "');";
                    $purchasedGames = mysqli_query($conn, $getPurchasedGamesQuery);
                    $purchased = false; // a default boolean var to check if user have bought the game
                    if ($purchasedGames->num_rows > 0) {
                        while ($pGamesRow = $purchasedGames->fetch_assoc()) {
                            $purchasedAppId = $pGamesRow['appid'];
                            if ($purchasedAppId == $appId) {
                                $purchased = true;
                                break;
                            } else {
                                $purchased = false;
                            }
                        }
                    }
                    
                    // if user never buy, show add to cart button
                    if ($purchased == false) {
                        echo '<form id = "addToCartForm" name = "addToCartForm" action = "addToCart.php" method = "POST" enctype = "multipart/form-data">';
                        echo '<input type = "hidden" name = "appId" value = "' . $appId . '" />';
                        // if price == 0, display 'Free to play!' instead of $0
                        if ($price == '0') {
                            echo 'Free to play!';
                        } else {
                            echo '$' . $price;
                        }
                        echo '</div>';
                        echo '<button class = "btn btn-outline-success " type = "submit">Add to Cart!</button>';
                        echo '</form>';
                        // price to be side by side with add to cart button
                    }
                     

                    echo '&nbsp;';
                    // add favourites
                    echo '<div style="padding: 0.375rem">';
                    echo '<input type = "hidden" name = "appId" value = "' . $appId . '" />';
                    echo '<button type="submit" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addFavModal">';
                    echo '<i class="bi bi-star"></i>';
                    echo '</button>';
                    echo '</div>';

                    // add favourites modal popup
                    echo '<div class="modal fade" id="addFavModal" tabindex="-1" aria-labelledby="addFavModalLabel" aria-hidden="true">';
                    echo '<div class="modal-dialog">';
                    echo '<div class="modal-content">';
                    echo '<div class="modal-header">';
                    echo '<h5 class="modal-title" id="addFavModalLabel">Add to Favourites</h5>';
                    echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
                    echo '</div>';
                    echo '<div class="modal-body">';
                    echo 'Are you sure you want to add ' . $name . ' to Favourites?';
                    echo '</div>';
                    echo '<div class="modal-footer">';
                    echo '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>';
                    echo '<form id="addFavForm" name="addFavForm" action="addFavourites.php" method="POST" enctype="multipart/form-data">';
                    echo '<input type="hidden" name="appId" value="' . $appId . '" />';
                    echo '<button type="submit" class="btn btn-primary"">Confirm</button>';
                    echo '</form>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';

                    echo '</div>';
                    echo '</div>';
                    echo '</div>'; // closing tag for col-md-8
                    echo '</div>'; // closing tag for row
                    
                    // show current reviews
                    echo '<div class="row">';
                    echo '<h3 class="my-3">Reviews</h3>';
                    $query2 = "SELECT * FROM reviews where games_appid = " . $appId . " AND review != ''";
                    $result2 = mysqli_query($conn, $query2);
                    if ($result2->num_rows > 0) {
                        while ($row2 = $result2->fetch_assoc()) {
                            $user = ucfirst($row2['users_username']);
                            $review = $row2['review'];

                            echo '<div class="row">';
                            echo '<p style="border-top: 2px solid #e2e2e2; padding: 2px;"></p>';
                            echo '<h5 class = "my-3">' . $user . '</h5>';
                            echo '<p>' . $review . '</p>';
                            echo '<p></p>';
                            echo '</div>';
                        }
                    } else {
                        echo "<div class='text-center'><h5>No reviews!</h5></div>";
                    }
                    echo '</div>';
                }
            } else {
                echo "0 results";
            }
            //
        }
        // if user never click on submit review btn (i.e. just come to indiv games page)
        else {
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

                    echo '<div class="d-flex justify-content-center">';
                    echo '<div style="display:block;padding: 0.375rem 0.75rem;">';
                                        
                    // if user havent buy, show add to cart button
                    $getPurchasedGamesQuery = "SELECT distinct appid FROM orderDetails where orderid in (select orderid from orders where username = '" . $username . "');";
                    $purchasedGames = mysqli_query($conn, $getPurchasedGamesQuery);
                    $purchased = false; // a default boolean var to check if user have bought the game
                    if ($purchasedGames->num_rows > 0) {
                        while ($pGamesRow = $purchasedGames->fetch_assoc()) {
                            $purchasedAppId = $pGamesRow['appid'];
                            if ($purchasedAppId == $appId) {
                                $purchased = true;
                                break;
                            } else {
                                $purchased = false;
                            }
                        }
                    }
                    
                    // if user never buy, show add to cart button
                    if ($purchased == false) {
                        echo '<form id = "addToCartForm" name = "addToCartForm" action = "addToCart.php" method = "POST" enctype = "multipart/form-data">';
                        echo '<input type = "hidden" name = "appId" value = "' . $appId . '" />';
                        // if price == 0, display 'Free to play!' instead of $0
                        if ($price == '0') {
                            echo 'Free to play!';
                        } else {
                            echo '$' . $price;
                        }
                        echo '</div>';
                        echo '<button class = "btn btn-outline-success " type = "submit">Add to Cart!</button>';
                        echo '</form>';
                        // price to be side by side with add to cart button
                    }
                    
                    
                    echo '&nbsp;';
                    // add favourites
                    echo '<div style="padding: 0.375rem">';
                    echo '<input type = "hidden" name = "appId" value = "' . $appId . '" />';
                    echo '<button type="submit" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addFavModal">';
                    echo '<i class="bi bi-star"></i>';
                    echo '</button>';
                    echo '</div>';

                    // add favourites modal popup
                    echo '<div class="modal fade" id="addFavModal" tabindex="-1" aria-labelledby="addFavModalLabel" aria-hidden="true">';
                    echo '<div class="modal-dialog">';
                    echo '<div class="modal-content">';
                    echo '<div class="modal-header">';
                    echo '<h5 class="modal-title" id="addFavModalLabel">Add to Favourites</h5>';
                    echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
                    echo '</div>';
                    echo '<div class="modal-body">';
                    echo 'Are you sure you want to add ' . $name . ' to Favourites?';
                    echo '</div>';
                    echo '<div class="modal-footer">';
                    echo '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>';
                    echo '<form id="addFavForm" name="addFavForm" action="addFavourites.php" method="POST" enctype="multipart/form-data">';
                    echo '<input type="hidden" name="appId" value="' . $appId . '" />';
                    echo '<button type="submit" class="btn btn-primary"">Confirm</button>';
                    echo '</form>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';

                    echo '</div>';
                    echo '</div>';
                    echo '</div>'; // closing tag for col-md-8
                    echo '</div>'; // closing tag for row
                    
                    // show current reviews
                    echo '<div class="row">';
                    echo '<h3 class="my-3">Reviews</h3>';
                    $query2 = "SELECT * FROM reviews where games_appid = " . $appId . " AND review != ''";
                    $result2 = mysqli_query($conn, $query2);
                    if ($result2->num_rows > 0) {
                        while ($row2 = $result2->fetch_assoc()) {
                            $user = ucfirst($row2['users_username']);
                            $review = $row2['review'];

                            echo '<div class="row">';
                            echo '<p style="border-top: 2px solid #e2e2e2; padding: 2px;"></p>';
                            echo '<h5 class = "my-3">' . $user . '</h5>';
                            echo '<p>' . $review . '</p>';
                            echo '<p></p>';
                            echo '</div>';
                        }
                    } else {
                        echo "<div class='text-center'><h5>No reviews!</h5></div>";
                    }
                    echo '</div>';
                }
            } else {
                echo "3: 0 results";
            }
        }
        ?>

        <!--reviews form-->
        <!--to be shown only when user purchased the game and haven't provided a review-->
<?php
// check if user purchased game
$getPurchasedGamesQuery = "SELECT distinct appid FROM orderDetails where orderid in (select orderid from orders where username = '" . $username . "');";
$purchasedGames = mysqli_query($conn, $getPurchasedGamesQuery);
$purchased = false; // a default boolean var to check if user have bought the game
if ($purchasedGames->num_rows > 0) {
    while ($pGamesRow = $purchasedGames->fetch_assoc()) {
        $purchasedAppId = $pGamesRow['appid'];
        if ($purchasedAppId == $appId) {
            $purchased = true;
            break;
        } else {
            $purchased = false;
        }
    }
}

// if user bought the game, check if he/she has submitted a review
if ($purchased == true){    
    $query6 = "SELECT * FROM reviews where games_appid = " . $appId . " AND users_username = '" . $username . "';";
    $result6 = mysqli_query($conn, $query6);
    if ($result6->num_rows == 0) {
        // if there is no result, user have not submitted a review, display submit review section
        ?>
            <div class="row">
                <form action="" method="POST" enctype = "multipart/form-data">
                    <h4 class = "my-3">Please tell us your experience with the game!</h4>                        
                    <div class="row">
                        <div class="btn-group-toggle" data-toggle="buttons">  
                            <label class="btn btn-outline-success">
                                <input type="checkbox" name="thumbs_up">
                                <i class="bi bi-hand-thumbs-up"></i>
                            </label>
                            <label class="btn btn-outline-danger">
                                <input type="checkbox" name="thumbs_down" autocomplete="off">
                                <i class="bi bi-hand-thumbs-down"></i>
                            </label>
                        </div>                       
                    </div>
                    <div class="row">	
                        <input class="form-input" type="text" style="height:200px; margin: 11px;" name="usrReviews" placeholder="Your reviews">
                        <input type="hidden" name="appId2" value="<?php print_r($appId) ?>" />
                    </div>                    
                    <button class = "btn btn-outline-primary" name="submitReview" type="submit">Submit Review!</button>
                </form>
            </div>

    <?php
    } // closing tag for if statement
}
?>


    </div>
</div>
</div>
</header>

<!--not working :(-->
<!--review error Modal-->
<!--<div class="modal fade" id="reviewErrorModal" role="dialog" tabindex="-1" aria-labelledby="reviewErrorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary-to-secondary p-4">
                <h5 class="modal-title font-alt text-white" id="reviewErrorModalLabel">Error submitting reviews!</h5>
                <button class="btn-close btn-close-white" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body border-0 p-4">
                <p>Please indicate how you feel about the game via the thumbs up or down button before submitting your review!"</p>                        
                Close Button
                <div class="d-grid"><button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button></div>                       
            </div>
        </div>
    </div>
</div>-->

<?php
include "footer.inc.php";
?>



<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS-->
<script src="js/scripts.js"></script>
<script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
<script type="text/javascript">
    function showReviewErrorMessage() {
        $('#reviewErrorModal').modal('show');
    }
</script>
</body>
</html>
