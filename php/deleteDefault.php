<?php
    if (!session_id()) session_start();
    if ($_SESSION['role'] != 1){ 
        header("Location:schedule.php");
        die();
    }
    $ID = $_POST['ID'];
    $servername = "sql13.bravehost.com";
    $username = "lhall";
    $password = "Lolipop0";
    $dbname = "dwDatabase_2820268";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql2 = "DELETE FROM DefaultTimes WHERE DefaultTimes.ID = $ID";
    $conn->query($sql2);

    $conn->close();
    header("Location:../schedule-defaults.php");
    die();
?>