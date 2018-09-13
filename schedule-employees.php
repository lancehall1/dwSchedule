<?php
if (!session_id()) {
    session_start();
}
if ($_SESSION['role'] != 1) {
    header("Location:schedule.php");
    die();
}
?>

<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Devil Wind Brewing</title>
  <link rel="stylesheet" href="css/styles.css?v=1.0">
  <style>
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
    }
    th, td {
        padding: 15px;
    }
    th {
        text-align: left;
    }
    table {
        border-spacing: 5px;
    }
    #table_container {
        width:75%;
        text-align:left;
    }
  </style>
</head>

<body>
<a href="user-panel.php">Home</a>
<a href="schedule-admin.php">Back to schedule administration</a>
<a href="logout.php">Log out</a>
<p>
<button onclick="showEmployeeInfo()">Add Employee</button>
<div style="display:none" id="employeeInfo">
    <form id="cp-newsletter" action="php/submitEmployee.php" method="post">
        <label>Name: </label>
        <input type="text" name="Name"/>
        <label>Phone: </label>
        <input type="text" name="Phone"/>
        <label>Email: </label>
        <input type="text" name="Email"/>
        <input type="submit" value="Submit">
    </form>
</div>

<p></p>

<?php

include 'php/mysql-credentials.php';

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$results = $conn->query("SELECT * FROM Employees") or die(mysqli_error($conn));
//start building a table
echo '<div id=table_container>';
echo '<table style="width:100%">';
echo '<tr>
            <th>Full Name</th>
            <th>Phone</th>
            <th>E-Mail</th>
        </tr>';
while ($result = mysqli_fetch_array($results)) {
    echo '<tr><td>' . $result["FullName"] . '</td><td>' . $result["Phone"] . '</td><td>' . $result["Email"] . '</td>
            <td><button onClick="removeEmployee(this.id)" class="remove_employee_button" id=' . '"' . $result["ID"] . '"' . '>Delete</button></td></tr>';
}
echo '</table>';
echo '</div>';
//echo "]";
$conn->close();
?>
<script src="vonder/jquery/jquery.min.js"></script>
<script>
    function showEmployeeInfo(){
        document.getElementById('employeeInfo').style.display = 'inline-block';
    }
    function removeEmployee(e) {
        //var target = (e.target) ? e.target : e.srcElement;
        // fetch where we want to submit the form to
        var url = 'php/removeEmployee.php';

        // setup the ajax request
        request = $.ajax({
            cache: false,
            type: "POST",
            url: 'php/removeEmployee.php',
            data: {data:e}
        });   
  
  		//request.done(function (response, textStatus, jqXHR){
        // Log a message to the console
        //confirm("Employee Deleted!");
    	//});
  		
  		setTimeout('location.reload();', 100);

    }
</script>
</body>
</html>
