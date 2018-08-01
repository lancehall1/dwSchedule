<?php
    function check_login ($_email, $_userPassword) {
        $servername = "sql13.bravehost.com";
        $username = "lhall";
        $password = "Lolipop0";
        $dbname = "dwDatabase_2820268";
        
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
            return $result->fetch_assoc()['UserRole'];
        } else
        {
            return -1;
        }
    }
?>