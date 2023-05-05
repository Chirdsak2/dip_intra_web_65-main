<?php
include('../callservice.php');

/* function callAPI( $service_name, $data = array()){
 $dataString = json_encode($data);
 $curl = curl_init();
	
curl_setopt_array($curl, array(
  // เครื่อง PRODUCTION
  // CURLOPT_URL => 'https://e-doc.diprom.go.th/dip_smartoffice_erp/service/'.$service_name.'.php', 
  // เครื่อง บริษัท
  CURLOPT_URL => 'http://203.151.166.132/dip_smartoffice_erp/service/'.$service_name.'.php',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>$dataString,
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json'
  ),
));
$response = curl_exec($curl);

curl_close($curl);
return json_decode($response,true);
} */

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
			
 $getCarList = callAPI('insertCarBookingFile', $data_request);
 // echo '<pre>';
 // print_r($data_request);
 // echo '</pre>'; 
// echo  count($_FILES['FILEUPLOAD']['name']);
// echo $i;
?>