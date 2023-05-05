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


$data_request = array(
						"CHECK_SALARY" 	=> $_POST['CHECK_SALARY'],//ไอดีรถที่เลือกมาจาก portal
						"CHECK_WORK" 	=> $_POST['CHECK_WORK'],//รายละเอียกรถที่เลือกมาจาก portal
						"CHECK_TH" 		=> $_POST['CHECK_TH'],
						"CHECK_EN" 		=> $_POST['CHECK_EN'],
						"COUNT" 		=> $_POST['COUNT'],
						
						"LOCATION" 		=> $_POST['LOCATION'],
						"TELEPHONE" 		=> $_POST['TELEPHONE'],
						"PHONE" 		=> $_POST['PHONE'],
						"OBJECTIVE"		=> $_POST['OBJECTIVE'],
						"REQ_DATE" 		=> date('Y-m-d'),
						
						"COUNT_NO" 		=> $_POST['COUNT_NO'],
						"REQ_NO" 		=> $_POST['REQ_NO'],
						"YEAR" 			=> $_POST['YEAR'],
						
						"USR_USERNAME"		=> $_POST['USR_USERNAME'],
						"FULL_NAME"			=> $_POST['FULL_NAME'],
						"POS_NAME" 			=> $_POST['POS_NAME'],
						"DEP_NAME" 			=> $_POST['DEP_NAME'],
						"DEP_NAME2"			=> $_POST['DEP_NAME2'],
						"PER_TYPE_NAME"		=> $_POST['PER_TYPE_NAME'],
						"POS_LEVEL_NAME"	=> $_POST['POS_LEVEL_NAME'],
						
						"FULL_NAME_EN"		=> $_POST['FULL_NAME_EN'],
						
						"INCOME_MONEY"		=> $_POST['INCOME_MONEY'],
						"PAYROLL_MONEY"		=> $_POST['PAYROLL_MONEY'],
					);
	
 $getCarList = callAPI('insertRequestCertificate', $data_request);
 echo "1"; 
 // echo '<pre>';
 // print_r($data_request);
 // echo '</pre>';  
?>
