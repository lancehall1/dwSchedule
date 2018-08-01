<?php	
        
        $email = $_POST['cpemail'];
        
        $servername = "sql13.bravehost.com";
        $username = "lhall";
        $password = "Lolipop0";
        $dbname = "dwDatabase_2820268";
        $cookie_name = "dwvisited";
	    $cookie_value = "yes";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        $sql2 = "SELECT * FROM newsLetterEmails WHERE newsLetterEmails.Email = '$email'";
        $result = $conn->query($sql2);

        if($result->num_rows == 0)
        {
            $sql = "INSERT INTO newsLetterEmails (Email)
            VALUES ('$email')";

            if ($conn->query($sql) === TRUE) {
                setcookie($cookie_name, $cookie_value, time() + (86400 * 10000), "/"); // 86400 = 1 day 
                echo "<script type='text/javascript'>alert('You have successfully subscribed to our newsletter'); window.location = '../home.html';</script>";         
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
        else
        {
            echo "<script type='text/javascript'>alert('You have already subscribed to our newsletter'); window.location = '../home.html';</script>";
        }

        $conn->close();

?>