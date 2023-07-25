<?php
include('../callservice.php');


// file_put_contents('file_attach/'.$value['CAR_IMAGE_NAME'], file_get_contents($value['CAR_IMAGE']));// บันทึกรูปจาก WF

$FILEUPLOAD_BASE64_ENCODE = array();
$i = 0;
while( $i < count($_FILES['FILEUPLOAD']['name']) ){
	array_push($FILEUPLOAD_BASE64_ENCODE , 'data:' . $_FILES['FILEUPLOAD']['type'][$i] . ';base64,' . base64_encode(file_get_contents($_FILES['FILEUPLOAD']['tmp_name'][$i])));	
$i++;
}		

$data_request = array(
						"FILEUPLOAD" => $_FILES['FILEUPLOAD'],
						"FILEUPLOAD_BASE64_ENCODE" => $FILEUPLOAD_BASE64_ENCODE
);
			
 $getCarList = callAPI('insertRoomBookingFile', $data_request);
 // echo '<pre>';
 // print_r($data_request);
 // echo '</pre>'; 
// echo  count($_FILES['FILEUPLOAD']['name']);
// echo $i;
?>