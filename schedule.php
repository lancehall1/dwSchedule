<?php
   if ($_SERVER['HTTP_HOST'] == "devilwindbrewing.com/schedule.php")
   {
      $url = "http://www." . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
      header("Location: $url");
   }   
   ob_start();
   session_start();	 
?>

<?
   // error_reporting(E_ALL);
   // ini_set("display_errors", 1);
?>

<html lang = "en">
   
   <head>
      <title>Tutorialspoint.com</title>
      <link href = "css/bootstrap.min.css" rel = "stylesheet">
      <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.js"></script>
      
      <style>
         body {
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #ADABAB;
         }
         
         .form-signin {
            max-width: 330px;
            padding: 15px;
            margin: 0 auto;
            color: #017572;
         }
         
         .form-signin .form-signin-heading,
         .form-signin .checkbox {
            margin-bottom: 10px;
         }
         
         .form-signin .checkbox {
            font-weight: normal;
         }
         
         .form-signin .form-control {
            position: relative;
            height: auto;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            padding: 10px;
            font-size: 16px;
         }
         
         .form-signin .form-control:focus {
            z-index: 2;
         }
         
         .form-signin input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
            border-color:#017572;
         }
         
         .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
            border-color:#017572;
         }
         
         h2{
            text-align: center;
            color: #017572;
         }
      </style>
      
   </head>
	
   <body>
      
      <h2>Enter Username and Password</h2> 
      <div class = "container form-signin">
         
         <?php
            $msg = '';
            include 'php/check-login.php';
            if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password'])) 
            {				
               if ($_POST['username'] == 'admin' && $_POST['password'] == 'password') 
               {
                  $_SESSION['valid'] = true;
                  $_SESSION['timeout'] = time();
                  $_SESSION['username'] = 'tutorialspoint';
                  $_SESSION['role'] = 1;
                  //echo "<script>console.log( 'Debug Objects: " . $_SESSION['username'] . "' );</script>";
                  header('Location: schedule-admin.php');
               }
               else 
               {
                  //lookup in userlogin table for passed in username and password. If they exist, redirect to schedule-employee.php else error msg: $msg = 'Wrong username or password';
                  $loginStatus = check_login($_POST['username'], $_POST['password']);
                  echo $loginStatus;
                  if ($loginStatus >= 0) {
                        $_SESSION['valid'] = true;
                        $_SESSION['timeout'] = time();
                        $_SESSION['username'] = $_POST['username'];
                        $_SESSION['role'] = $loginStatus;
                        //echo "<script>console.log( 'Debug Objects: " . $_SESSION['username'] . "' );</script>";
                        header('Location: user-panel.php');
                  }
               }
            }
         ?>
      </div> <!-- /container -->
      
      <div class = "container">
      
         <form class = "form-signin" role = "form" 
            action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); 
            ?>" method = "post">
            <h4 class = "form-signin-heading"><?php echo $msg; ?></h4>
            <input type = "text" class = "form-control" 
               name = "username" placeholder = "username = tutorialspoint" 
               required autofocus></br>
            <input type = "password" class = "form-control"
               name = "password" placeholder = "password = 1234" required>
            <button class = "btn btn-lg btn-primary btn-block" type = "submit" 
               name = "login">Login</button>
         </form>
          
         <button onClick="displaySignUpDiv()">Sign Up</button>
         <form role = "form" action = "php/insertNewUser.php">
         <div id="signUpDiv" style="display:none;">
            <div><label for="name">Full Name</label><input type="text" class="form-control" name="name" id="name" required></div>
            <div><label for="email">Email</label><input type="email" class="form-control" name="email" id="email" required></div>
            <div><label for="phone">Phone</label><input type="tel" class="form-control" name="phone" id="phone" required></div>
            <div><label for="code">Registration Code</label><input type="text" class="form-control" name="code" id="code" required></div>
            <div><label for="password">Password</label><input type="password" class="form-control" name="password" id="password" required></div>
            <div><label for="confirm">Confirm Password</label><input type="password" class="form-control" name="confirm" id="confirm" required></div>
            <button class = "btn btn-lg btn-primary btn-block" type="submit" name = "signUp">Sign Up</button>
         </div>
      </form>
         <!--Click here to clean <a href = "logout.php" tite = "Logout">Session.-->
         
      </div> 
      
      <script>
            $( document ).ready(function() {
                  alert('test2');
                  var urlParams = new URLSearchParams(window.location.search);
                  if(urlParams.get('success') == 'true'){
                        alert('New user account created');
                        window.history.replaceState("", "Title", "schedule.php");
                  }
            });
            function displaySignUpDiv(){
                  $("#signUpDiv").css("display","block");
            }
      </script>
   </body>
</html>