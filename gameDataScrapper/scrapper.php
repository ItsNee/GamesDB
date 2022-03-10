<?php
//https://www.convertcsv.com/json-to-csv.htm
//_key,appid,name,developer,publisher,score_rank,positive,negative,userscore,owners,average_forever,average_2weeks,median_forever,median_2weeks,price,initialprice,discount,ccu
$file = fopen('indie.csv', 'r');
while (($line = fgetcsv($file)) !== FALSE) {
   //$line[0] = '1004000018' in first iteration
   //print_r($line[0]);
    echo $appid = $line[1];
    echo $name = $line[2];
    echo $developer = $line[3];
    echo $positiveVotes = $line[6];
    echo $negativeVotes = $line[7];
    echo $price = $line[14];
    echo $gameImage = "https://steamcdn-a.akamaihd.net/steam/apps/".$appid."/header.jpg";
    echo $gameGenre = "indie";
    
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
    else
    {
        // Prepare the statement:
        $stmt = $conn->prepare("INSERT INTO games (appid, name, developer, positiveVotes, negativeVotes, price, gameImage, gameGenre) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        // Bind & execute the query statement:
        $stmt->bind_param("isssssss", $appid, $name, $developer, $positiveVotes, $negativeVotes, $price, $gameImage, $gameGenre);
        if (!$stmt->execute())
        {
        $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        $success = false;
        echo $errorMsg;
        }
        $stmt->close();
    }
    $conn->close();
    
    
}
fclose($file);



$file = fopen('adventure.csv', 'r');
while (($line = fgetcsv($file)) !== FALSE) {
   //$line[0] = '1004000018' in first iteration
   //print_r($line[0]);
    echo $appid = $line[1];
    echo $name = $line[2];
    echo $developer = $line[3];
    echo $positiveVotes = $line[6];
    echo $negativeVotes = $line[7];
    echo $price = $line[14];
    echo $gameImage = "https://steamcdn-a.akamaihd.net/steam/apps/".$appid."/header.jpg";
    echo $gameGenre = "adventure";
    
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
    else
    {
        // Prepare the statement:
        $stmt = $conn->prepare("INSERT INTO games (appid, name, developer, positiveVotes, negativeVotes, price, gameImage, gameGenre) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        // Bind & execute the query statement:
        $stmt->bind_param("isssssss", $appid, $name, $developer, $positiveVotes, $negativeVotes, $price, $gameImage, $gameGenre);
        if (!$stmt->execute())
        {
        $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        $success = false;
        echo $errorMsg;
        }
        $stmt->close();
    }
    $conn->close();
    
    
}
fclose($file);

$file = fopen('racing.csv', 'r');
while (($line = fgetcsv($file)) !== FALSE) {
   //$line[0] = '1004000018' in first iteration
   //print_r($line[0]);
    echo $appid = $line[1];
    echo $name = $line[2];
    echo $developer = $line[3];
    echo $positiveVotes = $line[6];
    echo $negativeVotes = $line[7];
    echo $price = $line[14];
    echo $gameImage = "https://steamcdn-a.akamaihd.net/steam/apps/".$appid."/header.jpg";
    echo $gameGenre = "racing";
    
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
    else
    {
        // Prepare the statement:
        $stmt = $conn->prepare("INSERT INTO games (appid, name, developer, positiveVotes, negativeVotes, price, gameImage, gameGenre) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        // Bind & execute the query statement:
        $stmt->bind_param("isssssss", $appid, $name, $developer, $positiveVotes, $negativeVotes, $price, $gameImage, $gameGenre);
        if (!$stmt->execute())
        {
        $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        $success = false;
        echo $errorMsg;
        }
        $stmt->close();
    }
    $conn->close();
    
    
}
fclose($file);

$file = fopen('strategy.csv', 'r');
while (($line = fgetcsv($file)) !== FALSE) {
   //$line[0] = '1004000018' in first iteration
   //print_r($line[0]);
    echo $appid = $line[1];
    echo $name = $line[2];
    echo $developer = $line[3];
    echo $positiveVotes = $line[6];
    echo $negativeVotes = $line[7];
    echo $price = $line[14];
    echo $gameImage = "https://steamcdn-a.akamaihd.net/steam/apps/".$appid."/header.jpg";
    echo $gameGenre = "strategy";
    
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
    else
    {
        // Prepare the statement:
        $stmt = $conn->prepare("INSERT INTO games (appid, name, developer, positiveVotes, negativeVotes, price, gameImage, gameGenre) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        // Bind & execute the query statement:
        $stmt->bind_param("isssssss", $appid, $name, $developer, $positiveVotes, $negativeVotes, $price, $gameImage, $gameGenre);
        if (!$stmt->execute())
        {
        $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        $success = false;
        echo $errorMsg;
        }
        $stmt->close();
    }
    $conn->close();
    
    
}
fclose($file);
?>
