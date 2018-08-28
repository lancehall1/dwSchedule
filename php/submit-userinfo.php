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
    $email = $_GET['email'];
    $fullName = $_GET['fullName'];
    $userPassword = $_GET['password'];
    $employeeId = $_SESSION['employeeId'];

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql2 = "SELECT * FROM  Employees WHERE EmployeeId == '$employeeId'";
    if ($userPassword == '')
        $sql2 = "UPDATE Employees SET Email = '$email', FullName = '$fullName'";
    else 
        $sql2 = "UPDATE Employees SET Email = '$email', FullName = '$fullName', UserPassword = '$userPassword'";
    $conn->query($sql2);
    $conn->close();
    header("Location:../user-panel.php");
?>