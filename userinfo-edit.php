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
<script src="vonder/jquery/jquery.min.js"></script>
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
        <form action="./php/submit-userinfo.php">
            Full Name: <input type="text" name="fullName" id="fullNameId"><br>
            Email: <input type="text" name="email" id="emailId"><br>
            Enter password only if you wish to change it<br>
            Password: <input type="password" name="password" id="passwordId"><br>
            Confirm Password: <input type="password" name="cpassword" id="cpasswordId"><br>
            <input type="submit" value="Submit">
        </form>
        <p>
        <a href="./user-panel.php"><input type="button" class="panel-button" value="Home" /></a>
        </p>
        <p>
        <a href="./logout.php"><input type="button" class="panel-button" value="Log out" /></a>
        </p>
    </div>     
</body>
<script>
    $( document ).ready(function() {
        $.ajax({
            cache: false,
            type: "GET",
            url: "php/retrieve-userinfo.php",
            data: {},
            success: function(response) {
                var response2 = JSON.parse(response);
                $('#fullNameId').val(response2['FullName']);
                $('#emailId').val(response2['Email']);
            }
        });
    });
</script>