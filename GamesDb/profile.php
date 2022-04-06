<?php ?>

<!DOCTYPE html>
<html lang="en">
    <?php
    include "head.inc.php";
    ?>
    <body id="page-top">
        <?php
        include "navPostLogin.inc.php";
        include "db.inc.php";
        if (isset($_POST['editEmail'])) {
            $inputSuccess = true; //specify a variable which will initially be true, and set to false if the input fails the validation checks
            $email = $_REQUEST['email'];
            $email = mysqli_real_escape_string($conn, $email);
            if (!preg_match("/[a-zA-Z0-9_\-]+@([a-zA-Z_\-])+[.]+[a-zA-Z]{2,4}/", $email)) { //this regex will validate if the user email matches the format of an email i.e example@email.com
                $error = base64_encode("Check your email format and try again");
                header("location: 404.php?error=" . $error);
                $inputSuccess = false;
            } else {
                $query = $conn->prepare("UPDATE users SET email=? WHERE username=?"); //prepared statement
                $query->bind_param("ss", $email, $_SESSION['username']); //bind the parameters
                if (!$query->execute()) {
                    $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                    $success = false;
                    echo $errorMsg;
                    $error = base64_encode("Email change failed, please try again.");
                    header("location: 404.php?error=" . $error);
                } else {
                    $success = true;
                    header("location: processSignOut.php");
                }
            }
        } elseif (isset($_POST['editPassword'])) {
            $query = "select * from users where username='$username'";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_array($result);
            $count = mysqli_num_rows($result);
            if ($count == 1) {
                $passwordInDb = $row['password'];
                $email = $row['email'];
                $secret = $row['2faSecret'];
                $profilePic = $row[profilePic];
                $isAdmin = $row[isAdmin];
                $isActivated = $row[isActivated];
            }


            $inputSuccess = true; //specify a variable which will initially be true, and set to false if the input fails the validation checks

            $currentPassword = $_REQUEST['currentPassword'];
            $newPassword = $_REQUEST['newPassword'];
            $confirmNewPassword = $_REQUEST['confirmPassword'];
            $currentPassword = mysqli_real_escape_string($conn, $currentPassword);
            $newPassword = mysqli_real_escape_string($conn, $newPassword);
            $confirmNewPassword = mysqli_real_escape_string($conn, $confirmNewPassword);
            if (password_verify($currentPassword, $passwordInDb)) {
                if (!preg_match("/[a-zA-Z0-9!@#$ ]{8,255}/", $newPassword)) { //this regex will validate if the user email matches the format of an email i.e example@email.com
                    if (!preg_match("/[a-zA-Z0-9!@#$ ]{8,255}/", $confirmNewPassword)) { //this regex will validate if the user email matches the format of an email i.e example@email.com
                        $error = base64_encode("Passwords must be of minimum length 8 characters. We only accept alphanumeric characters, spaces and select symbols: @,# and $.");
                        header("location: 404.php?error=" . $error);
                        $inputSuccess = false;
                    }
                } else {
                    if ($newPassword == $confirmNewPassword) {
                        $hash = password_hash($newPassword, PASSWORD_BCRYPT);
                    } else {
                        $error = base64_encode("Passwords do not match!");
                        header("location: 404.php?error=" . $error);
                    }
                    $query = $conn->prepare("UPDATE users SET password=? WHERE username=?"); //prepared statement
                    $query->bind_param("ss", $hash, $_SESSION['username']); //bind the parameters
                    if (!$query->execute()) {
                        $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                        $success = false;
                        echo $errorMsg;
                        $error = base64_encode("Password change failed, please try again.");
                        header("location: 404.php?error=" . $error);
                    } else {
                        $success = true;
                        $error = base64_encode("Password Has been successfully changed!");
                        header("location: 404.php?error=" . $error);
                    }
                }
            } else {
                $error = base64_encode("Wrong current password!");
                header("location: 404.php?error=" . $error);
            }
        } elseif (isset($_POST['deleteAccount'])) {
            $query = "DELETE from users where username='$username'";
            $result = mysqli_query($conn, $query);
            header("location: processSignOut.php");
        }
        ?>
        <!-- Masthead header-->
        <header class="masthead">
            <div class="container-xl px-4 mt-4">
                <div class="row">
                    <div class="col-xl-4">
                        <!-- Profile picture card-->
                        <div class="card mb-4 mb-xl-0">
                            <div class="card-header">Profile Picture</div>
                            <div class="card-body text-center">
                                <!-- Profile picture image-->
                                <img class="img-account-profile rounded-circle mb-2" width="50%" src="<?php print_r($profilePic) ?>" alt="">
                                <!--                                 Profile picture help block
                                                                <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                                                                 Profile picture upload button
                                                                <button class="btn btn-primary" type="button">Upload new image</button>-->
                            </div>
                        </div>
                        <!-- Delete acc card-->
                        <div class="card mb-4 mb-xl-0">
                            <div class="card-header">Delete Account</div>
                            <div class="card-body text-center">
                                <p>Deleting your account is a permanent action and cannot be undone. If you are sure you want to delete your account, select the button below.</p>
                                <form action="" method="POST" enctype='multipart/form-data'>
                                    <input type="hidden" name="appId" value="<?php print_r($username) ?>" />
                                    <button class="btn btn-danger" name="deleteAccount" type="submit">I understand, delete my account</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <!-- Account details card-->
                        <div class="card mb-4">
                            <div class="card-header">Account Details</div>
                            <div class="card-body">
                                <form action="" method="POST" enctype='multipart/form-data'>
                                    <!-- Form Group (username)-->
                                    <div class="mb-3">
                                        <label class="small mb-1" for="inputUsername">Username (how your name will appear to other users on the site)</label>
                                        <input class="form-control" id="inputUsername" type="text" placeholder="Enter your username" value="<?php print_r($username) ?>" readonly>
                                    </div>
                                    <!-- Form Group (email address)-->
                                    <div class="mb-3">
                                        <label class="small mb-1" for="inputEmailAddress">Email address</label>
                                        <input class="form-control" id="inputEmailAddress" name="email" type="email" placeholder="Enter your email address" value="<?php print_r($email) ?>">
                                    </div>
                                    <!-- Save changes button-->
                                    <button class="btn btn-primary" name="editEmail" type="submit">Save changes</button>
                                </form>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">Change Password</div>
                            <div class="card-body">
                                <form  action="" method="POST" enctype='multipart/form-data'>
                                    <!-- Form Group (current password)-->
                                    <div class="mb-3">
                                        <label class="small mb-1" for="currentPassword">Current Password</label>
                                        <input class="form-control" id="currentPassword" name="currentPassword" type="password" placeholder="Enter current password">
                                    </div>
                                    <!-- Form Group (new password)-->
                                    <div class="mb-3">
                                        <label class="small mb-1" for="newPassword">New Password</label>
                                        <input class="form-control" id="newPassword" name="newPassword" type="password" placeholder="Enter new password">
                                    </div>
                                    <!-- Form Group (confirm password)-->
                                    <div class="mb-3">
                                        <label class="small mb-1" for="confirmPassword">Confirm Password</label>
                                        <input class="form-control" id="confirmPassword" name="confirmPassword" type="password" placeholder="Confirm new password">
                                    </div>
                                    <button class="btn btn-primary" name="editPassword"  type="submit">Save</button>
                                </form>
                            </div>
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
