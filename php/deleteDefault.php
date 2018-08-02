<?php
    if (!session_id()) session_start();
    if ($_SESSION['role'] != 1){ 
        header("Location:schedule.php");
        die();
    }
    $ID = $_POST['ID'];
<<<<<<< HEAD
    $servername = "us-cdbr-iron-east-01.cleardb.net";
        $username = "lancehall1";
        $password = "Lolipop0";
        $dbname = "heroku_01b86a6647f084a";
=======
    include 'mysql-credentials.php';
>>>>>>> 6223a4eb52221572413e3813402862c119b84adc

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