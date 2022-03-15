<?php
include "db.inc.php";
require "authenticator.inc.php";
if (isset($_GET['code'])) {
    echo $_GET['code'];
    $f2asecret = $_GET['code'];
    $query = "SELECT * FROM users WHERE 2faSecret = '$f2asecret'";
    $result = mysqli_query($conn, $query);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $password = $row["password"];
            $profilePic = $row["profilePic"];
            $f2asecret = $row["2faSecret"];
            $isAdmin = $row["isAdmin"];
            $email = $row["email"];
        }
        $query= $conn->prepare("UPDATE users SET isActivated=1 WHERE 2faSecret=?"); //prepared statement
        $query->bind_param("s", $f2asecret); //bind the parameters
        //$query->execute();
        if (!$query->execute())
        {
        $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        $success = false;
        echo $errorMsg;
        $statusMsg = "File upload failed, please try again.";
        }else{
            $Authenticator = new Authenticator();
            $qrCodeUrl = $Authenticator->getQR($email, $f2asecret);
        }
    } else {
        echo "0 results";
        header('Location: index.php');
    }
} else {
    echo "rip";
}

?>

<!DOCTYPE html>
<html lang="en">
<?php
include "head.inc.php";
?>
    <body id="page-top">
    <?php
    include "nav.inc.php";
    ?>
        <!-- Masthead header-->
        <header class="masthead">
            <div class="container px-5">
                <div class="row gx-5 align-items-center">
                    <div class="col-lg-6">
                        <!-- Mashead text and app badges-->
                        <div class="mb-5 mb-lg-0 text-center text-lg-start">
                            <h1 class="display-1 lh-1 mb-3">Here's your TOTP activation QR.</h1>
                            <p class="lead fw-normal text-muted mb-5">Scan this with any totp authenticator app and you're good to go!</p>
                            <!--                            <div class="d-flex flex-column flex-lg-row align-items-center">
                                                            <a class="me-lg-3 mb-4 mb-lg-0" href="#!"><img class="app-badge" src="assets/img/google-play-badge.svg" alt="..." /></a>
                                                            <a href="#!"><img class="app-badge" src="assets/img/app-store-badge.svg" alt="..." /></a>
                                                        </div>-->
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <!-- Masthead device mockup feature-->
                        <div class="masthead-device-mockup">
                            <svg class="circle" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                            <linearGradient id="circleGradient" gradientTransform="rotate(45)">
                            <stop class="gradient-start-color" offset="0%"></stop>
                            <stop class="gradient-end-color" offset="100%"></stop>
                            </linearGradient>
                            </defs>
                            <circle cx="50" cy="50" r="50"></circle></svg
                            ><svg class="shape-1 d-none d-sm-block" viewBox="0 0 240.83 240.83" xmlns="http://www.w3.org/2000/svg">
                            <rect x="-32.54" y="78.39" width="305.92" height="84.05" rx="42.03" transform="translate(120.42 -49.88) rotate(45)"></rect>
                            <rect x="-32.54" y="78.39" width="305.92" height="84.05" rx="42.03" transform="translate(-49.88 120.42) rotate(-45)"></rect></svg
                            ><svg class="shape-2 d-none d-sm-block" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="50"></circle></svg>
                            <img class="floatAboveEverything" src='<?php print_r($qrCodeUrl) ?>' width="80%" alt="Gaming Setup">
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Quote/testimonial aside-->
        <aside class="text-center bg-gradient-primary-to-secondary">
            <div class="container px-5">
                <div class="row gx-5 justify-content-center">
                    <div class="col-xl-8">
                        <div class="h2 fs-1 text-white mb-4">"Thanks for signing up!"</div>
                    </div>
                </div>
            </div>
        </aside>
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
