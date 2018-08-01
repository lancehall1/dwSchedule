<?php
$user = $_POST['user'];
$pass = $_POST['pass'];
$servername = "sql13.bravehost.com";
$username = "lhall";
$password = "Lolipop0";
$dbname = "dwDatabase_2820268";

if($user == "devilwind"
&& $pass == "dwBrewing0814")
{
    $conn = new mysqli($servername, $username, $password, $dbname);

    //run the query
    $loop = mysqli_query($conn, "SELECT * FROM newsLetterEmails")
       or die (mysqli_error($conn));
    
    while ($row = mysqli_fetch_array($loop))
    {
         echo $row['Email'] . ";";
    }
}
else
{
    if(isset($_POST))
    {?>

            <form method="POST" action="mailinglist.php">
            User <input type="text" name="user"></input><br/>
            Pass <input type="password" name="pass"></input><br/>
            <input type="submit" name="submit" value="Go"></input>
            </form>
    <?}
}
?>