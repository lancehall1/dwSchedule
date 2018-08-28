<?php
if (!session_id()) {
    session_start();
}
if ($_SESSION['username'] == '') {
    header("Location:../schedule.php");
    die();
}

include '../php/mysql-credentials.php';
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load composer's autoloader
require '../vonder/autoload.php';

$ID = $_POST['ID'];

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM Schedule WHERE Schedule.ID = $ID";
$result2 = $conn->query($sql);
$scheduleRow = $result2->fetch_assoc();
$employeeId = $scheduleRow['EmployeeId'];
$date = $scheduleRow['ScheduleDate'];
$startTime = $scheduleRow['StartTime'];
$endTime = $scheduleRow['StopTime'];

$sql3 = "SELECT * FROM Employees where Employees.ID = $employeeId";
$result3 = $conn->query($sql3);
$name = $result3->fetch_assoc()['FullName'];

$sql2 = "SELECT * FROM Employees";
$result = $conn->query($sql2);

$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'LanceTestEmailLocal@gmail.com';                 // SMTP username
    $mail->Password = 'Lolipop0';                           // SMTP password
    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 465;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('NoReply@gmail.com', 'Devil Wind Scheduling');
    while($row = $result->fetch_assoc())
    {
        $mail->addAddress($row['Email'], $row['FullName']);
    } 
    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'A shift has been released';
    $mail->Body    = "$name has released a shift on $date from $startTime to $endTime";
    $mail->send();
    error_log(("test"));
    echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}
return true;
?>