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

        $sql = "DELETE FROM favourites WHERE users_username = '$username' AND games_appid = " . $appId;
        
        if (mysqli_query($conn, $sql)) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
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
