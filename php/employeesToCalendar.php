<?php
	if (!session_id()) {
        session_start();
    }
    
    if ($_SESSION['username'] == null) {
        header("Location:../schedule.php");
        die();
    }
    include 'mysql-credentials.php';
    
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