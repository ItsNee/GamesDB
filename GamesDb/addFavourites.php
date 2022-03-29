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
        include "db.inc.php";
        $appId = $_POST['appId'];

        $stmt = $conn->prepare("INSERT INTO favourites (users_username, games_appid) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $appId);
            $stmt->execute();
        
        if (mysqli_query($conn, $stmt)) {
            echo "Game added!";
        } else {
            echo "Error adding game: " . mysqli_error($conn);
        }
        mysqli_close($conn);
        
        echo '<script>window.location.href = "favourites.php";</script>';
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
