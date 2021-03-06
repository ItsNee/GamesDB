<?php
include "db.inc.php";
require "authenticator.inc.php";
session_start();
$Authenticator = new Authenticator();

$username = $_POST['username'];
$password = $_POST['password'];
$email = mysqli_real_escape_string($conn, $email); //escape strings
$password = mysqli_real_escape_string($conn, $password); //escape strings
$f2acode = mysqli_real_escape_string($conn, $_POST['2fa']); //escape strings

//query the DB
$query = "select * from users where username='$username'";
    $result = mysqli_query($conn,$query);
    $row = mysqli_fetch_array($result);
    $count = mysqli_num_rows($result);
    if($count == 1) {
        $passwordInDb = $row['password'];
        $email = $row['email'];
        $secret = $row['2faSecret'];
        $profilePic = $row[profilePic];
        $isAdmin = $row[isAdmin];
        $isActivated = $row[isActivated];
        
        $checkResult = $Authenticator->verifyCode($secret, $f2acode, 2);
        if ($isActivated==1){
            if ($checkResult) {
                if (password_verify($password, $passwordInDb)) {
                    //echo 'Password is valid!';
                    //echo $password1;
                    $_SESSION['email'] = $email;
                    $username = $row['username'];
                    $_SESSION['username'] = $username;
                    $_SESSION['profilePic'] = $profilePic;
                    $_SESSION['isAdmin'] = $isAdmin;
                    header("location: home.php"); 

                    //header("location: plogindex.php");
                }else {
                    $error = "Your Login Name or Password is invalid";
                    header("location: index.php"); 
                }
            }else {
                $error = "Your 2FA code is wrong!";
                header("location: index.php");
            }
        }else{
            $error = "Your Account is unactivated";
        }
        
    }else {
        $error = "Your Login Name or Password is invalid";
        header("location: index.php");
    }
