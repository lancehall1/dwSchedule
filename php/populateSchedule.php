<?php
	if (!session_id()) {
        session_start();
    }
    
    if ($_SESSION['username'] == null) {
        header("Location:../schedule.php");
        die();
    }

<<<<<<< HEAD
    $servername = "us-cdbr-iron-east-01.cleardb.net";
    $username = "lancehall1";
    $password = "Lolipop0";
    $dbname = "heroku_01b86a6647f084a";
=======
    include 'mysql-credentials.php';
>>>>>>> 6223a4eb52221572413e3813402862c119b84adc
    $endDate = $_GET['endDate'];
    $startDate = $_GET['startDate'];
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql2 = "SELECT * FROM  Schedule WHERE Schedule.ScheduleDate >= '$startDate' AND Schedule.ScheduleDate <= '$endDate'";
    $result = $conn->query($sql2);
    $results = array();

    while($row = $result->fetch_assoc())
    {
        $results[] = $row;
    }

    echo json_encode($results);
?>