<?php
$config = parse_ini_file('../../private/db-config-project.ini');
    //echo $config['servername'], $config['username'],$config['password'], $config['dbname'];
    $conn = new mysqli($config['servername'], $config['username'],$config['password'], $config['dbname']);
    // Check connection
    if ($conn->connect_error)
    {
        $errorMsg = "Connection failed: " . $conn->connect_error;
        $success = false;
        echo $errorMsg;
    }
 else {
        echo "done";
}
?>