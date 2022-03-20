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
        $query = $conn->prepare("SELECT * FROM cart WHERE appid=?"); 
        $query->bind_param("s", $appId); 
        $query->execute();         
        $select = $query->get_result();     
        
        if ($select->num_rows > 0) {
            $row = $select->fetch_assoc(); 
            $newQty = $row["qty"] + 1;
            
            $sql = "UPDATE cart SET qty=".$newQty." WHERE appid=".$appId;
            $conn->query($sql);
            
        } 
        else {
            $one = 1;
            $stmt = $conn->prepare("INSERT INTO cart (username, appid ,qty) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $appId, $one);
            $stmt->execute();
            
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
