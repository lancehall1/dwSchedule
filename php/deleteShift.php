<?php
    if (!session_id()) session_start();
    if ($_SESSION['role'] != 1){ 
        header("Location:schedule.php");
        die();
    }
    $ID = $_POST['ID'];
    include 'mysql-credentials.php';

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql2 = "DELETE FROM Schedule WHERE Schedule.ID = $ID";
    $conn->query($sql2);

    $conn->close();
    header("Location:../schedule-admin.php");
    die();
?>