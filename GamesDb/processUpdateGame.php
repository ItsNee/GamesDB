<?php
session_start();
if ($_SESSION['isAdmin'] == "1") {
    $l = 1;
} else {
    header("location: index.php");
}
?>
<html>
    <?php
    //nee test edit
    include "head.inc.php";
    ?>
    <body>
        <?php
        include "navPostLogin.inc.php";
        ?>
        <section class = "py-5">
            <div class = "container px-4 px-lg-5 mt-5">
                <div class = "row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    <div class="row">
                        <?php
                        include "db.inc.php";

                        function specialChar($data) {
                            $signs = "/([<>])/";
                            if (preg_match($signs, $data)) {
                                $success = false;
                                return $success;
                            } else {
                                return $data;
                            }
                        }

                        $success = true;
                        $appID = specialChar($_POST['appId']);
                        $gameName = specialChar($_POST['gameName']);
                        $developer = specialChar($_POST['developer']);
                        $genre = specialChar($_POST['genre']);
                        $price = specialChar($_POST['price']);
                        $gameInfo = specialChar($_POST['gameInfo']);
                        $gameImage = specialChar($_POST['gameImage']);

                        if (empty($appID) || empty($gameName) || empty($developer) || empty($gameInfo) || empty($genre)) {
                            $success = false;
                        }


                        if ($success) {
                            $stmt = $conn->prepare("UPDATE games set name=?, developer=?, gameGenre=?, price=?, gameInfo=?, gameImage=? WHERE appid=?");
                            $stmt->bind_param("ssssssi", $gameName, $developer, $genre, $price, $gameInfo, $gameImage, $appID);
                            if (!$stmt->execute()) {
                                $errorMsg = "Something went wrong. Please try again";
                                echo $errorMsg;
                                echo '<div class = "text-center"><a href="admin.php">'
                                . '<button class = "btn btn-outline-secondary mt-auto" style= "background-color: rgb(255, 153, 0);">Return to Admin Page</button></a></div>';

                                echo '<div class = "text-center"><a href="updateGames.php">'
                                . '<button class = "btn btn-outline-secondary mt-auto" style= "background-color: rgb(255, 153, 0);">Return to Update Games Page</button></a></div>';
                            } else {
                                echo 'Game has successfully been updated';
                                echo '<div class = "text-center"><a href="admin.php">'
                                . '<button class = "btn btn-outline-secondary mt-auto" style= "background-color: rgb(255, 153, 0);">Return to Admin Page</button></a></div>';
                                echo '<div class = "text-center"><a href="updateGames.php">'
                                . '<button class = "btn btn-outline-secondary mt-auto" style= "background-color: rgb(255, 153, 0);">Return to Update Games Page</button></a></div>';
                            }
                        } else {
                            $errorMsg = "Something went wrong. Please try again";
                            echo $errorMsg;
                            echo '<div class = "text-center"><a href="admin.php">'
                            . '<button class = "btn btn-outline-secondary mt-auto" style= "background-color: rgb(255, 153, 0);">Return to Admin Page</button></a></div>';
                            echo '<div class = "text-center"><a href="updateGames.php">'
                            . '<button class = "btn btn-outline-secondary mt-auto" style= "background-color: rgb(255, 153, 0);">Return to Update Games Page</button></a></div>';
                        }
                        ?> 
                    </div>
                </div>
            </div>   
        </section>

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

