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
                        
                        $success = True;
                        function specialChar($data) {
                            $signs = "/([<>])/";
                            if (preg_match($signs, $data)) {
                                $success = false;
                                return $success;
                            } else {
                                return $data;
                            }
                        }

                        $gameName = specialChar($_POST['gameName']);
                        $developer = specialChar($_POST['developer']);
                        $price = specialChar($_POST['price']);

                        $gameGenre = "";
                        if (is_array($_POST['gameGenre'])) {
                            foreach ($_POST['gameGenre'] as $value) {
                                $gameGenre .= $value . " ";
                            }
                        } else {
                            $gameGenre = $_POST['gameGenre'];
                            echo $gameGenre;
                        }

                        $positiveVotes = "0";
                        $negativeVotes = "0";
                        $gameInfo = specialChar($_POST['gameInfo']);
                        $gameImage = specialChar($_POST['gameImage']);
                        
                        
                        if (empty($gameName) || empty($developer) || empty($gameInfo)) {
                            $success = false;
                        }
                        if (empty($price)) {
                            $price = "0";
                        }

                        if ($success) {
                            $stmt = $conn->prepare("SELECT appid from games ORDER BY appid DESC LIMIT 1;");
                            $stmt->execute();
                            $result = $stmt->get_result();
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $appID = $row["appid"] + 1;
                            }

                            $stmt = $conn->prepare("INSERT INTO games (appid, name, developer, positiveVotes, negativeVotes, price, gameImage, gameGenre, gameInfo) VALUES (?,?,?,?,?,?,?,?,?)");
                            $stmt->bind_param("issssssss", $appID, $gameName, $developer, $positiveVotes, $negativeVotes, $price, $gameImage, $gameGenre, $gameInfo);

                            if (!$stmt->execute()) {
                                $errorMsg = "Something went wrong. Please try again";
                                echo $errorMsg;
                                echo '<div class = "text-center"><a href="admin.php">'
                                . '<button class = "btn btn-outline-secondary mt-auto" style= "background-color: rgb(255, 153, 0);">Return to Admin Page</button></a></div>';
                                
                                echo '<div class = "text-center"><a href="addGames.php">'
                                . '<button class = "btn btn-outline-secondary mt-auto" style= "background-color: rgb(255, 153, 0);">Return to Add Game Page</button></a></div>';
                            } else {
                                echo 'Game has successfully been added';
                                echo '<div class = "text-center"><a href="admin.php">'
                                . '<button class = "btn btn-outline-secondary mt-auto" style= "background-color: rgb(255, 153, 0);">Return to Admin Page</button></a></div>';
                                
                                echo '<div class = "text-center"><a href="addGames.php">'
                                . '<button class = "btn btn-outline-secondary mt-auto" style= "background-color: rgb(255, 153, 0);">Return to Add Game Page</button></a></div>';
                            
                            }
                        } else {
                            $errorMsg = "Something went wrong. Please try again";
                            echo $errorMsg;
                            echo '<div class = "text-center"><a href="admin.php">'
                            . '<button class = "btn btn-outline-secondary mt-auto" style= "background-color: rgb(255, 153, 0);">Return to Admin Page</button></a></div>';
                            
                            echo '<div class = "text-center"><a href="addGames.php">'
                                . '<button class = "btn btn-outline-secondary mt-auto" style= "background-color: rgb(255, 153, 0);">Return to Add Game Page</button></a></div>';
                            
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