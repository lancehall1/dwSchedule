<?php
  if (!session_id()) {
      session_start();
  }
  if ($_SESSION['role'] != 1) {
	  header("Location:../schedule.php");
	  die();
  }
    $servername = "sql13.bravehost.com";
    $username = "lhall";
    $password = "Lolipop0";
    $dbname = "dwDatabase_2820268";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql2 = "SELECT * FROM  DefaultTimes";
    $result = $conn->query($sql2);
    $results = array();
    //while($row = mysql_fetch_assoc($result))
    while($row = $result->fetch_assoc())
    {
        $results[] = $row;
    }

    echo json_encode($results);
?>