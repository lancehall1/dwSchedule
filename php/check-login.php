<?php
    function check_login ($_email, $_userPassword) {
        include 'mysql-credentials.php';
                
        $conn = new mysqli($servername, $username, $password, $dbname);

        $email = mysqli_real_escape_string($conn, $_email);
        $userPassword = mysqli_real_escape_string($conn, $_userPassword);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql2 = "SELECT * FROM  Employees WHERE Email = '$email' AND UserPassword = '$userPassword'";
        $result = $conn->query($sql2);
        $conn->close();
        if ($result->num_rows >= 1) {
            $resultArray = array($result->fetch_assoc()['UserRole'], $result->fetch_assoc()['ID']);
            return $resultArray;
        } else
        {
            return array(-1);
        }
    }
?>