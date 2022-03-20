<!DOCTYPE html>
<html lang="en">
    <?php
    //nee test edit
    include "head.inc.php";
    ?>
    <body id="page-top">
        <?php
        include "navPostLogin.inc.php";
        ?>
        <?php
        include "db.inc.php";
        $appId = (int) $_POST['appId'];
        $gameQty = (int) $_POST['gameQty'];
        if ($gameQty == 0) {
            $sql = "DELETE FROM cart WHERE appid=". $appId;
            $conn->query($sql);
        } else {
            $sql = "UPDATE cart SET qty=" . $gameQty . " WHERE appid=" . $appId;
            $conn->query($sql);
        }

        header("location: cart.php");
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
