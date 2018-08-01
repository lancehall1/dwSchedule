<?php

	$minAge = 21;
	$cookie_name = "DWAgeVerify";
	$cookie_value = "set";
	
	if(isset($_POST['submit'])){
		
		if(strlen($_POST['mm'])==1)
		$month = '0'.$_POST['mm'];
		else 
		$month = $_POST['mm'];
		$agevar = $_POST['yy'].'/'.$month.'/'.$_POST['dd'];
		
	  $age = strtotime($agevar);

	  $eightteen = strtotime("-" . $minAge . " years");

	  if($age && $eightteen && $age <= $eightteen){
		  setcookie($cookie_name, $cookie_value, time() + (86400 * 60), "/"); // 86400 = 1 day 
	  	header('Location: ../home.html');
	  }

	  else{
	    header('Location: ../error.html');
	  }
	}
	?>