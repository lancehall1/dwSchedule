<?php
    if (!session_id()) session_start();
    if ($_SESSION['username'] == null) {
        header("Location:schedule.php");
        die();
    }

    $ID = $_POST['ID'];
    include 'mysql-credentials.php';

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql1 = "SELECT * FROM Schedule WHERE Schedule.ID = $ID";
    
    $conn->query($sql1);
    if($sql1->EmployeeId == $_SESSION['employeeId'] || $_SESSION['role'] == 1)
    {
        $sql2 = "UPDATE Schedule SET Released = 1 WHERE ID = $ID";
        $conn->query($sql2);
    }

    $conn->close();
    header("Location:../view-schedule.php");
    die();
?>