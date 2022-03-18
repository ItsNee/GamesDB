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
        ?>

        <!--obtained from https://startbootstrap.com/snippets/portfolio-item-->
        <header class='masthead'>
            <div class="container">
                <h1 class="my-4">Game title</h1>
                <div class="row">
                    <div class="col-md-8">
                        <img class="img-fluid" src="game image" alt="">
                    </div>

                    <div class="col-md-4">
                        <h3 class="my-3">Description</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod odio, gravida pellentesque urna varius vitae. Sed dui lorem, adipiscing in adipiscing et, interdum nec metus. Mauris ultricies, justo eu convallis placerat, felis enim.</p>
                        <h5 class="my-3">Genre : 'blah blah'</h5>
                        <h5 class="my-3">Positive Votes : 'blah blah'</h5>
                        <h5 class="my-3">Negative Votes : 'blah blah'</h5>
                        <h5 class="my-3">Stars : 'blah blah'</h5>
                        <br>
                        <div class = "card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <form id="addToCartForm" name="addToCartForm" action="cart.php" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="appId" value="' . $appId . '" />
                                <input type="hidden" name="username" value="' . $username . '" />
                                <div class = "text-center"><button class = "btn btn-outline-primary mt-auto" type="submit">Add to Cart!</button></div>
                            </form>
                        </div>
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
