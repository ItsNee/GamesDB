<!DOCTYPE html>
<html lang="en">
    <?php
    include "head.inc.php";
    ?>
    <body id="page-top">
        <?php
        include "navPostLogin.inc.php";
        ?>

        <!-- Masthead header-->
        <header class="masthead">
            <div class="container px-5">
                <div class="row gx-5 align-items-center">
                    <div class="col-lg-6">
                        <!-- Mashead text and app badges-->
                        <div class="mb-5 mb-lg-0 text-center text-lg-start">
                            <h5 class="display-1 lh-1 mb-3">Favourite Games</h5>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        
        <!--function to check unique app id for modal cos need unique attr for it/cannot put in while loop-->
       
        
        <?php
        displayFavourites();

        function displayFavourites() {
            include "db.inc.php";
            //CheckValidUser
            session_start();
            $username = $_SESSION['username'];
            //
            //query the DB
            $query = "select * from games inner join favourites on games.appid = favourites.games_appid inner join users on favourites.users_username = users.username where users.username = '$username'";
            $result = mysqli_query($conn, $query);
            echo '<section class = "py-5">';
            echo '<div class = "container px-4 px-lg-5 mt-5">';
            echo '<div class = "row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">';

            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) { // $row = array $results[x] where x is loop counter
                    $appId = $row["appid"];
                    $name = $row["name"];
                    $gameImage = $row["gameImage"];

                    echo '<div class = "col mb-5">';
                    echo '<div class = "card h-100">';
                    echo '<!--Product image-->';
                    echo '<img class = "card-img-top" src="' . $gameImage . '" alt="Image of ' . $name. '" />';
                    echo '<!--Product details-->';
                    echo '<div class = "card-body p-4">';
                    echo '<div class = "text-center">';
                    echo '<!--Product name-->';
                    echo '<h5 class = "fw-bolder">' . $name . '</h5>';
                    echo '</div>';
                    echo '</div>';
                    echo '<!--Product actions-->';
                    echo '<div class = "card-footer p-4 pt-0 border-top-0 bg-transparent">';
                    //echo '<form id="removeFavForm" name="removeFavForm" action="removeFavourites.php" method="POST" enctype="multipart/form-data">';
                    //echo '<input type="hidden" name="appId" value="' . $appId . '" />';
                    //echo '<div class = "text-center"><button class = "btn btn-outline-primary mt-auto" name="removeFav" type="submit">Remove</button></div>';
                    //echo '</form>';
                    
                    //remove button
                    echo '<div class = "text-center"><button type="button" class="btn btn-outline-primary mt-auto" data-bs-toggle="modal" data-bs-target="#removeFavModal" data-bs-appid="' . $appId . '" data-bs-gamename = "' . $name . '">Remove</button></div>';
                    //modal
                    echo '<div class="modal fade" id="removeFavModal" tabindex="-1" aria-labelledby="removeFavModalLabel" aria-hidden="true">';
                      echo '<div class="modal-dialog">';
                        echo '<div class="modal-content">';
                          echo '<div class="modal-header">';
                            echo '<h5 class="modal-title" id="removeFavModalLabel">Remove</h5>';
                            echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
                          echo '</div>';
                          echo '<div class="modal-body">';
                          echo 'Are you sure you want to remove this game from Favourites?';
                          echo '</div>';
                          echo '<div class="modal-footer">';
                            echo '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>';
                           
                            echo '<form id="remFavForm" name="remFavForm" action="removeFavourites.php" method="POST" enctype="multipart/form-data">';
                            echo '<input type="hidden" class="form-control" name="appId" id="appid-name" value="appid-name" />';
                            echo '<button type="submit" class="btn btn-primary"">Confirm</button>';
                            echo '</form>';
                    
                          echo '</div>';
                        echo '</div>';
                      echo '</div>';
                    echo '</div>';
                    
                    //additional function needed to show modal as need to retrieve unique appids 
                    echo"<script language='javascript'>
                        
                    var removeFavModal = document.getElementById('removeFavModal')
                    removeFavModal.addEventListener('show.bs.modal', function (event) {
                    
                      // Button that triggered the modal
                      var button = event.relatedTarget
                      
                      // Extract info from data-bs-* attributes
                      var appid = button.getAttribute('data-bs-appid')
                      var gamename = button.getAttribute('data-bs-gamename')
                      
                      // Update the modal's content.
                      var modalTitle = removeFavModal.querySelector('.modal-title')
                      var modalBodyFooter = removeFavModal.querySelector('.modal-footer input')

                      modalTitle.textContent = 'Remove ' + gamename + ' from Favourites'
                      modalBodyFooter.value = appid
                    })
                    </script>
                    ";
                    
                    echo '<div style="padding: 0.5rem" class="text-center">';
                    echo '<a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-show-count="false">Tweet</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>';
                    echo '</div>';
                    
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "No favourite games.";
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
