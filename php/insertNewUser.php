<?php
    $name = $_GET['name'];
    $email = $_GET['email'];
    $phone = $_GET['phone'];
    $userPassword = $_GET['password'];
    $code = $_GET['code'];
    $role = 0;
    $servername = "sql13.bravehost.com";
    $username = "lhall";
    $password = "Lolipop0";
    $dbname = "dwDatabase_2820268";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql2 = "SELECT * FROM Employees WHERE Employees.Email = '$email'";
    $result = $conn->query($sql2);

    if ($result->num_rows == 0) {
        $sql = "INSERT INTO Employees (FullName, Email, Phone, UserPassword)
        VALUES ('$name', '$email', '$phone', '$userPassword')";

        $conn->query($sql);
        echo($name . ' + ' . $email . ' + ' . $phone . ' + ' . $userPassword );
        header('Location: ../schedule.php?success=true');
    }
    else{
       echo('FAIL');
       header('Location: ../schedule.php');
    } 
    $conn->close();

?>