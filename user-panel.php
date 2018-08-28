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
        <?php
            echo '<a href="./userinfo-edit.php"><input type="button" class="panel-button" value="Edit your info" /></a>';
            //we add a button leading to schedule administration panel if the user logged in is an administrator
            if ($_SESSION['role'] == 1) {
                echo '<a href="./schedule-admin.php"><input type="button" class="panel-button" value="Scheduling Administration" /></a>';
            }
            echo '<a href="./view-schedule.php"><input type="button" class="panel-button" value="View Schedule" /></a>';
        ?>
        <p>
            <a href="./logout.php"><input type="button" class="panel-button" value="Log out" /></a>
        </p>
    </div>     
</body>

