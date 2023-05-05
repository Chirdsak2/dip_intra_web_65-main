<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
	<?php
	$a_funame = $_POST["fullname"];
	$a_username = $_POST["username"];
	$a_ip = $_POST["IP"];
	$a_datetime = $_POST["datetime"];
	$a_dateday = $_POST["dateday"];
	$a_detail = $_POST["detail"];
	$i = 0;
	while($i < sizeof($a_detail) ){
	print($a_funame[$i])."<br>";
	print($a_username[$i])."<br>";
	print($a_ip[$i])."<br>";
	print($a_datetime [$i])."<br>";
	print($a_dateday[$i])."<br>";
	print($a_detail[$i])."<br>";
	print("<hr><br>");
	$i++;
	}
	
	
	?>
	
</body>
</html>