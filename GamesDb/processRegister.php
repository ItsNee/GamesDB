<?php
include "db.inc.php";
require "authenticator.inc.php";


$inputSuccess=true; //specify a variable which will initially be true, and set to false if the input fails the validation checks
$username = $_POST['username'];
if(!preg_match("/^[a-zA-Z0-9]{1,255}$/",$username)){ //this regex will validate if the username only has alphanumeric chars
    echo "<script type='text/javascript'>alert('ERROR. Check your username format and try again. It should only contain alphanumeric characters');</script>";
     //set the following the false so that the user inputs will not be added to database should it not meet the formatting requirements.
   $inputSuccess=false;
 }
$email = $_POST['email'];
if(!preg_match("/[a-zA-Z0-9_\-]+@([a-zA-Z_\-])+[.]+[a-zA-Z]{2,4}/",$email)){ //this regex will validate if the user email matches the format of an email i.e example@email.com
    echo "<script type='text/javascript'>alert('ERROR. Check your email format and try again');</script>";
    $inputSuccess=false;
}
$password = $_POST['password'];
if(!preg_match("/[a-zA-Z0-9!@#$ ]{8,255}/",$password)){ //this regex will validate if the user password contains at least 8 chars, and only contains alphanumeric chars, spaces and some symbols
    echo "<script type='text/javascript'>alert('ERROR. Passwords must be of minimum length 8 characters. We only accept alphanumeric characters, spaces and select symbols: @,# and $.');</script>";
    $inputSuccess=false;
}
$confirmPassword = $_POST['confirmPassword'];
if(!preg_match("/[a-zA-Z0-9!@#$ ]{8,255}/",$password)){ //this regex will validate if the user password contains at least 8 chars, and only contains alphanumeric chars, spaces and some symbols
    echo "<script type='text/javascript'>alert('ERROR. Passwords must be of minimum length 8 characters. We only accept alphanumeric characters, spaces and select symbols: @,# and $.');</script>";
    $inputSuccess=false;
}

if($inputSuccess){ //if the variable $inputSuccess created is true, it will go through and run the following statements:

$username = mysqli_real_escape_string($conn, $username); //escape strings
$email = mysqli_real_escape_string($conn, $email); //escape strings
$password = mysqli_real_escape_string($conn, $password); //escape strings
$confirmPassword = mysqli_real_escape_string($conn, $confirmPassword); //escape strings
//----------------------------------------------------------------------------------------------------------------------------------------

$Authenticator = new Authenticator();
$secret = $Authenticator->generateRandomSecret();
echo $secret;
//----------------------------------------------------------------------------------------------------------------------------------------
if ($password == $confirmPassword){
    $hash = password_hash($password, PASSWORD_BCRYPT);
}

session_start();
$_SESSION['email'] = $email;
$_SESSION['username'] = $username;
//Check extension
$isAdmin=0;
$isActivated=0;
$target_file = "lmao";
$query= $conn->prepare("INSERT INTO users VALUES (?,?,?,?,?,?,?)"); //prepared statement
$query->bind_param("sssssii", $username, $email, $hash, $secret, $target_file, $isAdmin, $isActivated); //bind the parameters
//$query->execute();
if (!$query->execute())
{
$errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
$success = false;
echo $errorMsg;
}
else{
    $statusMsg = '';

// File upload path
$targetDir = "uploads/";
$fileName = basename($_FILES["file"]["name"]);
$targetFilePath = $targetDir . $fileName;
$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

if(!empty($_FILES["file"]["name"])){
    // Allow certain file formats
    $allowTypes = array('jpg','png','jpeg','gif','pdf');
    if(in_array($fileType, $allowTypes)){
        // Upload file to server
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
            // Insert image file name into database
            echo $targetFilePath;
            $query= $conn->prepare("UPDATE users SET profilePic=? WHERE username=?"); //prepared statement
            $query->bind_param("ss", $targetFilePath, $_SESSION['username']); //bind the parameters
            //$query->execute();
//            session_start();
//            $_SESSION['email'] = $email1;
//            $_SESSION['username'] = $username;
            if (!$query->execute())
            {
            $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            $success = false;
            echo $errorMsg;
            $statusMsg = "File upload failed, please try again.";
            }
        }else{
            $statusMsg = "Sorry, there was an error uploading your file.";
        }
    }else{
        $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
    }
}else{
    $statusMsg = 'Please select a file to upload.';
}

// Display status message
echo $statusMsg;
}
header("location: sendEmail.php");
}else{
    header("location: index.php");
}
?>