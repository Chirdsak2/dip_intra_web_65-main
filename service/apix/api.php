<?php
	header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json", true);	
    

$servername = "localhost";
$username = "root";
$password = "";
$mydb = "rest_api";

$conn = new mysqli($servername, $username, $password,$mydb);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

    $sql = "SELECT * FROM product";
    $result = $conn->query($sql);
    $json_return = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            array_push($json_return, 
			array(
				"sku" => $row["sku"],
				"barcode" => $row["barcode"],
				"name" => $row["name"],
				"price" => $row["price"]
			)
		);
        }
    }

	echo json_encode($json_return);
?>