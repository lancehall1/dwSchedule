<?php
//Still in development
	if (!session_id()) {
        session_start();
    }
    
    if ($_SESSION['username'] == '') {
        header("Location:../schedule.php");
        die();
    }

    include 'mysql-credentials.php';
    //$email = $_GET['email'];
    $employeeId = $_SESSION['employeeId'];

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql2 = "SELECT * FROM  Employees WHERE ID = '$employeeId'";
    $result = $conn->query($sql2);
    $row = $result->fetch_assoc();
    echo json_encode($row);
?>