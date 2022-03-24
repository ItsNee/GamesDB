<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/ClientSide/html.html to edit this template
-->
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Add Games</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Google fonts-->
        <link rel="preconnect" href="https://fonts.gstatic.com" />
        <link href="https://fonts.googleapis.com/css2?family=Newsreader:ital,wght@0,600;1,600&amp;display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,300;0,500;0,600;0,700;1,300;1,500;1,600;1,700&amp;display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,400;1,400&amp;display=swap" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body>
        <section class = "py-5">

            <div class="modal-body border-0 p-4">
                <form id="signInForm" action="processAddGame.php" method="POST" enctype="multipart/form-data">

                    Game Name:
                    <div class="form-floating mb-3">
                        <input class="form-control" name="gameName" id="gameName" type="text" placeholder="Enter Game Name" data-sb-validations="required" />
                        <div class="invalid-feedback" data-sb-feedback="username:required">A username is required.</div>
                    </div>

                    Developer:
                    <div class="form-floating mb-3">
                        <input class="form-control" name="developer" id="developer" type="text" placeholder="Enter Game Developer" data-sb-validations="required" />
                        <div class="invalid-feedback" data-sb-feedback="username:required">A username is required.</div>
                    </div>

                    Price:
                    <div class="form-floating mb-3">
                        <input class="form-control" name="price" id="price" type="text" placeholder="Enter Game Price" data-sb-validations="required" />
                        <div class="invalid-feedback" data-sb-feedback="username:required">A username is required.</div>
                    </div>
                    
                    Game Genre:
                    <div class="form-floating mb-3">
                        Strategy<input type="checkbox" name="gameGenre[]" id="gameGenre" value="strategy">
                        Indie<input type="checkbox" name="gameGenre[]" id="gameGenre" value="indie">
                        Racing<input type="checkbox" name="gameGenre[]" id="gameGenre" value="racing">
                        Adventure<input type="checkbox" name="gameGenre[]" id="gameGenre" value="adventure">
                        <!--<input class="form-control" name="gameGenre" id="gameGenre" type="text" placeholder="Enter Game Genre(s)" data-sb-validations="required" />-->
                        <div class="invalid-feedback" data-sb-feedback="username:required">A username is required.</div>
                    </div> 
                    
                    Game Info:
                    <div class="form-floating mb-3">
                        <input class="form-control" name="gameInfo" id="gameInfo" type="text" placeholder="Enter Game Info" data-sb-validations="required" />
                        <div class="invalid-feedback" data-sb-feedback="username:required">A username is required.</div>
                    </div> 

                    Image:
                    <div class="form-floating mb-3">
                        <input class="form-control" name="gameImage" id="gameImage" type="text" placeholder="Enter Game Image" data-sb-validations="required" />

                        <div class="invalid-feedback" data-sb-feedback="username:required">A username is required.</div>
                    </div>

                    <div class = "text-center"><button class = "btn btn-outline-secondary mt-auto" type="submit">Add Game</button></div>

                    <?php echo '<img class = "card-img-top" src="' . $gameImage . '" alt="Image of ' . $name . '" />'; ?>
                </form>
            </div>
        </section>
    </body>
</html>
