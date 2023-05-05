<?php
header('Content-Type: text/html; charset=utf-8');
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

// echo '<pre>';
 // print_r( $_POST);
 // echo '</pre>';
 // exit;
	// $data_request['TOOL_ID'] 		= $_POST['TOOL_ID'];
	// $data_request['TOOL_AMOUNT']	= $_POST['TOOL_AMOUNT'];
	// $data_request['TOOL_NAME']		= $_POST['TOOL_NAME'];
	// $data_request['TOOL_DETAIL']	= $_POST['TOOL_DETAIL'];
	
 $travelRoomBooking = callAPI('travelRoomBooking', $_POST);
 echo "1"; 

?>