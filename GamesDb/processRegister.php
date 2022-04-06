<?php

include "db.inc.php";
require "authenticator.inc.php";

if (!empty($_POST['g-recaptcha-response'])) {
    $secret = '6LdrwScfAAAAAF_pBBAeC_qSTQ4kzAW_NS7wFw1A';
    $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
    $responseData = json_decode($verifyResponse);
    if ($responseData->success) {
        $message = "g-recaptcha varified successfully";

        $inputSuccess = true; //specify a variable which will initially be true, and set to false if the input fails the validation checks
        $username = $_POST['username'];
        if (!preg_match("/^[a-zA-Z0-9]{1,255}$/", $username)) { //this regex will validate if the username only has alphanumeric chars
            $error = base64_encode("Check your username format and try again. It should only contain alphanumeric characters");
            header("location: 404.php?error=" . $error);
            //set the following the false so that the user inputs will not be added to database should it not meet the formatting requirements.
            $inputSuccess = false;
        }
        $email = $_POST['email'];
        if (!preg_match("/[a-zA-Z0-9_\-]+@([a-zA-Z_\-])+[.]+[a-zA-Z]{2,4}/", $email)) { //this regex will validate if the user email matches the format of an email i.e example@email.com
            echo "<script type='text/javascript'>alert('ERROR. Check your email format and try again');</script>";
            $error = base64_encode("Check your email format and try again");
            header("location: 404.php?error=" . $error);
            $inputSuccess = false;
        }
        $password = $_POST['password'];
        if (!preg_match("/[a-zA-Z0-9!@#$ ]{8,255}/", $password)) { //this regex will validate if the user password contains at least 8 chars, and only contains alphanumeric chars, spaces and some symbols
            $error = base64_encode("Passwords must be of minimum length 8 characters. We only accept alphanumeric characters, spaces and select symbols: @,# and $.");
            header("location: 404.php?error=" . $error);
            $inputSuccess = false;
        }
        $confirmPassword = $_POST['confirmPassword'];
        if (!preg_match("/[a-zA-Z0-9!@#$ ]{8,255}/", $password)) { //this regex will validate if the user password contains at least 8 chars, and only contains alphanumeric chars, spaces and some symbols
            $error = base64_encode("Passwords must be of minimum length 8 characters. We only accept alphanumeric characters, spaces and select symbols: @,# and $.");
            header("location: 404.php?error=" . $error);
            $inputSuccess = false;
        }

        if ($inputSuccess) { //if the variable $inputSuccess created is true, it will go through and run the following statements:
            $username = mysqli_real_escape_string($conn, $username); //escape strings
            $email = mysqli_real_escape_string($conn, $email); //escape strings
            $password = mysqli_real_escape_string($conn, $password); //escape strings
            $confirmPassword = mysqli_real_escape_string($conn, $confirmPassword); //escape strings
//----------------------------------------------------------------------------------------------------------------------------------------

            $Authenticator = new Authenticator();
            $secret = $Authenticator->generateRandomSecret();
            echo $secret;
//----------------------------------------------------------------------------------------------------------------------------------------
            if ($password == $confirmPassword) {
                $hash = password_hash($password, PASSWORD_BCRYPT);
            }

            session_start();
            $_SESSION['email'] = $email;
            $_SESSION['username'] = $username;
//Check extension
            $isAdmin = 0;
            $isActivated = 0;
            $target_file = "uploads/defaultpfp.jpg";
            $query = $conn->prepare("INSERT INTO users VALUES (?,?,?,?,?,?,?)"); //prepared statement
            $query->bind_param("sssssii", $username, $email, $hash, $secret, $target_file, $isAdmin, $isActivated); //bind the parameters
//$query->execute();
            if (!$query->execute()) {
                $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                $success = false;
                echo $errorMsg;
                $error = base64_encode("Sorry, there is already an account with this username/email.");
                header("location: 404.php?error=" . $error);
            } else {
                $statusMsg = '';

// File upload path
                $targetDir = "uploads/";
                $fileName = basename($_FILES["file"]["name"]);
                $targetFilePath = $targetDir . $fileName;
                $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

                if (!empty($_FILES["file"]["name"])) {
                    // Allow certain file formats
                    $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'pdf');
                    if (in_array($fileType, $allowTypes)) {
                        // Upload file to server
                        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
                            // Insert image file name into database
                            echo $targetFilePath;
                            $query = $conn->prepare("UPDATE users SET profilePic=? WHERE username=?"); //prepared statement
                            $query->bind_param("ss", $targetFilePath, $_SESSION['username']); //bind the parameters
                            //$query->execute();
//            session_start();
//            $_SESSION['email'] = $email1;
//            $_SESSION['username'] = $username;
                            if (!$query->execute()) {
                                $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                                $success = false;
                                echo $errorMsg;
                                $error = base64_encode("File upload failed, please try again.");
                                header("location: 404.php?error=" . $error);
                            }
                        } else {
                            $error = base64_encode("Sorry, there was an error uploading your file.");
                            header("location: 404.php?error=" . $error);
                        }
                    } else {
                        $error = base64_encode("Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.");
                        header("location: 404.php?error=" . $error);
                    }
                } else {
                    $error = base64_encode("Please select a file to upload.");
                    header("location: 404.php?error=" . $error);
                }
            }
            header("location: sendEmail.php");
        } else {
            header("location: index.php");
        }
    } else {
        $error = base64_encode("Some error in vrifying g-recaptcha!");
        header("location: 404.php?error=" . $error);
    }
} else {
    $error = base64_encode("Google Captcha Failed!");
    header("location: 404.php?error=" . $error);
}
?>