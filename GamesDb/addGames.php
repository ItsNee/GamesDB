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

            <div class="row align-items-center">
                <div class="col-xs-4 col-lg-6">
                    <div class="modal-body border-0 p-4">
                        <form id="signInForm" action="processAddGame.php" method="POST" enctype="multipart/form-data">
                            Game Name:
                            <div class="form-floating mb-3">
                                <input class="form-control" name="gameName" id="gameName" type="text" placeholder="Enter Game Name" required />
                            </div>

                            Developer:
                            <div class="form-floating mb-3">
                                <input class="form-control" name="developer" id="developer" type="text" placeholder="Enter Game Developer" required />
                            </div>

                            Price:
                            <div class="form-floating mb-3">
                                <input class="form-control" name="price" id="price" type="text" placeholder="Enter Game Price"/>
                            </div>

                            Game Genre:
                            <div class="form-floating mb-3">
                                Strategy<input type="checkbox" name="gameGenre[]" id="gameGenre" value="strategy">
                                Indie<input type="checkbox" name="gameGenre[]" id="gameGenre" value="indie">
                                Racing<input type="checkbox" name="gameGenre[]" id="gameGenre" value="racing">
                                Adventure<input type="checkbox" name="gameGenre[]" id="gameGenre" value="adventure">
                                <!--<input class="form-control" name="gameGenre" id="gameGenre" type="text" placeholder="Enter Game Genre(s)" data-sb-validations="required" />-->
                            </div> 

                            Game Info:
                            <div class="form-floating mb-3">
                                <input class="form-control" name="gameInfo" id="gameInfo" type="text" placeholder="Enter Game Info" required />
                            </div> 

                            Image:
                            <div class="form-floating mb-3">
                                <input class="form-control" name="gameImage" id="gameImage" type="text" placeholder="Enter Game Image"/>

                            </div>

                    </div>
                </div>
            </div>
            <div class = "text-center"><button class = "btn btn-outline-secondary mt-auto" type="submit">Add Game</button></div>
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
