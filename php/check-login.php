<?php
    function check_login ($_email, $_userPassword) {
<<<<<<< HEAD
        $servername = "us-cdbr-iron-east-01.cleardb.net";
        $username = "lancehall1";
        $password = "Lolipop0";
        $dbname = "heroku_01b86a6647f084a";
        
=======
        include 'mysql-credentials.php';
                
>>>>>>> 6223a4eb52221572413e3813402862c119b84adc
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