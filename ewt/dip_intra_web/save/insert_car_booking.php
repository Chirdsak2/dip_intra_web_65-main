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
						"REQUEST_CAR_ID" => $_POST['REQUEST_CAR_ID'],//ไอดีรถที่เลือกมาจาก portal
						"REQUEST_CAR_DETAIL" => $_POST['REQUEST_CAR_DETAIL'],//รายละเอียกรถที่เลือกมาจาก portal
						"PROVINCE_CODE" => $_POST['PROVINCE_CODE'],
						"WFR_TIMESTAMP" => date('Y-m-d H:i:s'),
						"WF_DET_STEP" => '1645',
						"WF_DET_NEXT" => '0',
						"WFR_UID" => '',
						"CB_RECORD" => date('Y-m-d'),
						"CB_REQ_TO" => '',
						"CB_OBJECTIVE_TYPE" => $_POST['OBJECTIVE'],//วัตถุประสงค์การใช้รถ
						"CB_OBJECTIVE" => '',//ขออนุญาตใช้รถเพื่อ
						"CB_CAR_TYPE" => '1',//ประเภทรถยนต์ 1 = รถยนต์ส่วนกลาง
						"CB_RECEIVE_SEND_TYPE" => '0',//โปรดระบุการรับ-ส่ง 1 = ส่งและรับกลับ
						"CB_PER_ID" => '994',//ไอดีผู้จอง
						"USR_USERNAME" => $_POST['USR_USERNAME'],//username ผู้จอง
						"CB_POS_BOOK" => '',//ตำแหน่ง
						"CB_DEP_NAME_BOOK" => $_POST['DEP_NAME1'],//สำนัก/ฝ่าย
						"CB_DEP_ID_BOOK" => '734',//รหัส สำนัก/ฝ่ายผู้จอง
						"CB_PHONE_BOOK" => $_POST['TEL'],
						"CB_MEMBER" => $_POST['GUEST'],
						"CB_SDATE" => $_POST['DATE_START'],
						"CB_EDATE" => $_POST['DATE_END'],
						"CB_STIME" => $_POST['TIME_START'],
						"CB_ETIME" => $_POST['TIME_END'],
						"CB_AREA" => $_POST['LOCATION'],
						"CB_STATUS" => '2',// 2 = รอจัดสรรรถ
						"REQ_NO" => $_POST['REQ_NO'],
						"CB_STATUS_SEND_DT" => 'Y',// Y= อะไรไม่รู้
						"CB_CC_PER_NAME" => '',
						"CB_PER_MAIL" => '',
						// "CB_FILE" => $_POST['FILEUPLOAD'],
						"CB_CC_NOTE" => $_POST['NOTE'],
						"CB_CC_DATE" => '',
						"CB_CC_TIME" => '',
						"CB_MAIL_STATUS" => '1',//สถานะการส่งเมล
						"CS_APPROVE_PER_ID" => $_POST['PER_APPROVE_ID'],
						"CS_APPROVE_POS_NAME" => '',
						"CS_APPROVE_DEP_NAME" => '',
						"CS_APPROVE_DEP_ID" => '',
						"CS_CHECK_STEP" => '',
						"CB_OBJECTIVE_OTHER" => '',
						"COUNT_NO" => $_POST['COUNT_NO'],
						"YEAR_BUDGET" => $_POST['YEAR_BUDGET'],
					);
	
 $getCarList = callAPI('insertCarBooking', $data_request);
 echo "1"; 
  // echo '<pre>';
 // print_r($_POST);
 // echo '</pre>'; 
 
  // echo '<pre>';
 // print_r($data_request);
 // echo '</pre>'; 

 // echo '<pre>';
 // print_r($_FILE['FILEUPLOAD']);
 // echo '</pre>';

// exit;
?>
