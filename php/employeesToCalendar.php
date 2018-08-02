<?php
	if (!session_id()) {
        session_start();
    }
    
    if ($_SESSION['username'] == null) {
        header("Location:../schedule.php");
        die();
    }
    $servername = "us-cdbr-iron-east-01.cleardb.net";
    $username = "lancehall1";
    $password = "Lolipop0";
    $dbname = "heroku_01b86a6647f084a";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql2 = "SELECT * FROM  Employees";
    $result = $conn->query($sql2);
    $results = array();
    //while($row = mysql_fetch_assoc($result))
    while($row = $result->fetch_assoc())
    {
        $results[] = $row;
    }
    echo json_encode($results);
?>