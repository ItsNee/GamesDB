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
        <?php
        include "db.inc.php";
        $appID = $_POST["appId"];
        $stmt = $conn->prepare("SELECT * FROM games WHERE appid=?");
        $stmt->bind_param("s", $appID);
        $stmt->execute();
        $result = $stmt->get_result();
        //$result = mysqli_query($conn, $query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $gameGenre = $row["gameGenre"];
            $name = $row["name"];
            $developer = $row["developer"];
            //$positiveVotes = $row["positiveVotes"];
            //$negativeVotes = $row["negativeVotes"];
            $price = $row["price"];
            $gameImage = $row["gameImage"];
            $gameInfo = $row["gameInfo"];
        }
        ?>

        <section class = "py-5">
            <div class="row align-items-center">
                <div class="col-xs-4 col-lg-6">
                    <div class="modal-body border-0 p-4">
                        <form id="signInForm" action="processUpdateGame.php" method="POST" enctype="multipart/form-data">

                            <input type="hidden" name="appId" id="appId" value="<?php echo $appID; ?>" />
                            Game Name:

                            <div class="form-floating mb-3">
                                <input class="form-control" name="gameName" id="gameName" type="text" placeholder="Update Game Name" 
                                       value="<?php echo $name; ?>" required/>
                            </div>

                            Developer:
                            <div class="form-floating mb-3">
                                <input class="form-control" name="developer" id="developer" type="text" placeholder="Update Game Developer" 
                                       value="<?php echo $developer; ?>" required/>
                            </div>

                            Genre:
                            <div class="form-floating mb-3">
                                <input class="form-control" name="genre" id="genre" type="text" placeholder="Update Game Genre" 
                                       value="<?php echo $gameGenre; ?>"  required/>
                            </div>


                            Price:
                            <div class="form-floating mb-3">
                                <input class="form-control" name="price" id="price" type="text" placeholder="Update Game Price" 
                                       value="<?php echo $price; ?>"  required/>
                            </div>

                            Game Info:
                            <div class="form-floating mb-3">
                                <input class="form-control" name="gameInfo" id="gameInfo" type="text" placeholder="Update Game Info" 
                                       value="<?php echo $gameInfo; ?>" required/>
                            </div> 


                            Image:
                            <div class="form-floating mb-3">
                                <input class="form-control" name="gameImage" id="gameImage" type="text" placeholder="Update Game Image" 
                                       value="<?php echo $gameImage; ?>" required/>

                            </div>
                    </div>
                </div>

                <div class="col-xs-4 col-lg-5">
                    <?php echo '<img class = "card-img-top" src="' . $gameImage . '" alt="Image of ' . $name . '" />'; ?>
                </div>

            </div>
            <div class = "text-center"><button class = "btn btn-outline-secondary mt-auto" type="submit">Update Game</button></div>


        </form>

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
