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

    $sql = "SELECT Released FROM Schedule WHERE ID = $ID";
    $result = $conn->query($sql);

    if ($result->fetch_assoc()['Released'] == 1) {
        $currentEmployee = $_SESSION['employeeId'];
        $sql = "UPDATE Schedule SET Released = 0, EmployeeId = $currentEmployee WHERE ID = $ID";
        $conn->query($sql);
    }
    else {
        error_log("Attempt to claim a shift that has not been released. Claimee: " . $_SESSION['employeeId'] . " Shift: " . $ID);
    }
    $conn->close();
    header("Location:../view-schedule.php");
    die();
?>