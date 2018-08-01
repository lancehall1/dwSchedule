<?php
    if (!session_id()) {
        session_start();
    }

    if ($_SESSION['username'] == null) {
        header("Location:schedule.php");
        die();
    }
    else {
        echo "<script>console.log( 'Debug Objects: " . $_SESSION['valid'] . "' );</script>";
    }


?>

<head>
    <link href = "css/bootstrap.min.css" rel = "stylesheet">
    <style>
         body {
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #ADABAB;
         }         
         h2{
            text-align: center;
            color: #017572;
         }
      </style>
</head>

<body>
    <div class = "container">
        <!--Click here to clean <a href = "logout.php" tite = "Logout">Session.-->
        <?php
            if ($_SESSION['role'] == 0) {
                echo '<input type="button" class="panel-button" value="Edit Your Info" />';
                echo '<a href="./view-schedule.php"><input type="button" class="panel-button" value="View Schedule" /></a>';
            }
            if ($_SESSION['role'] == 1) {
                echo '<input type="button" class="panel-button" value="Edit Your Info" />';
                echo '<a href="./schedule-admin.php"><input type="button" class="panel-button" value="Scheduling Administration" /></a>';
                echo '<a href="./view-schedule.php"><input type="button" class="panel-button" value="View Schedule" /></a>';
            }
        ?>
        
        <p>
            Click here to clean <a href = "logout.php" title = "Logout">Session.
        </p>
    </div> 
    
</body>

