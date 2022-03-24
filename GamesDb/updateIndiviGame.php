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
        <title>Update/Delete Games</title>
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
        
        <div class="modal-body border-0 p-4">
            <form id="signInForm" action="processUpdateGame.php" method="POST" enctype="multipart/form-data">
                
                <input type="hidden" name="appId" id="appId" value="<?php echo $appID; ?>" />
        Game Name:
        <div class="form-floating mb-3">
            <input class="form-control" name="gameName" id="gameName" type="text" placeholder="Update Game Name" 
                   value="<?php echo $name; ?>" data-sb-validations="required" />
            <div class="invalid-feedback" data-sb-feedback="username:required">A username is required.</div>
        </div>
        
        Developer:
        <div class="form-floating mb-3">
            <input class="form-control" name="developer" id="developer" type="text" placeholder="Update Game Developer" 
                   value="<?php echo $developer; ?>" data-sb-validations="required" />
            <div class="invalid-feedback" data-sb-feedback="username:required">A username is required.</div>
        </div>
        
        Price:
        <div class="form-floating mb-3">
            <input class="form-control" name="price" id="price" type="text" placeholder="Update Game Price" 
                   value="<?php echo $price; ?>" data-sb-validations="required" />
            <div class="invalid-feedback" data-sb-feedback="username:required">A username is required.</div>
        </div>
        
        Game Info:
        <div class="form-floating mb-3">
            <input class="form-control" name="gameInfo" id="gameInfo" type="text" placeholder="Update Game Info" 
                   value="<?php echo $gameInfo; ?>" data-sb-validations="required" />
            <div class="invalid-feedback" data-sb-feedback="username:required">A username is required.</div>
        </div> 

        Image:
        <div class="form-floating mb-3">
            <input class="form-control" name="gameImage" id="gameImage" type="text" placeholder="Update Game Image" 
                   value="<?php echo $gameImage; ?>"data-sb-validations="required" />
            
            <div class="invalid-feedback" data-sb-feedback="username:required">A username is required.</div>
        </div>
        
        <div class = "text-center"><button class = "btn btn-outline-secondary mt-auto" type="submit">Update Game</button></div>
        
        <?php echo '<img class = "card-img-top" src="' . $gameImage . '" alt="Image of ' . $name . '" />'; ?>
            </form>
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
