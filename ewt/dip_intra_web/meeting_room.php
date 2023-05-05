<?php
include('callservice.php');

$data_request = array(
						"INS_ID" => $_POST["INS_ID"],//meeting_id
						"MEETING_DATE" => $_POST["MEETING_DATE"],//DATE_START
						"MEETING_EDATE" => $_POST["MEETING_EDATE"],//DATE_END
						"STIME" => $_POST["STIME"],//TIME_START
						"ETIME" => $_POST["ETIME"],//TIME_END
						"SEAT_AMOUNT" => $_POST["GUEST"]//TIME_END
					);
$chkBookingRoom = callAPI('chkBookingRoom', $data_request);
 // echo '<pre>';
 // print_r($chkBookingRoom['Data']);
 // echo '</pre>';
 // echo '<pre>';
 // print_r($_POST);
 // echo '</pre>';
echo json_encode($chkBookingRoom['Data']);


?>