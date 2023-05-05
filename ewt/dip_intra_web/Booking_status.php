<?php include('comtop.php'); ?>
<!-- Include file css and properties -->
<?php include('header.php'); ?>
<!-- Menu and Logo -->
<?php include('callservice.php'); ?>
<!-- CALL SERVICE -->


<?php
$short_dep = array (
//สำนักงานเลขานุการกรม
244 => "ลสล.กสอ.", 363 => "หฝบท.สล.กสอ.", 413 => "ผกค.สล.กสอ.", 364 => "ผกบ.สล.กสอ.", 365 => "ผกส.สล.กสอ.", 
366 => "ผกพ.สล.กสอ.", 414 => "ผกง.สล.กสอ.", // มีเพิ่ม 1 กลุ่ม อย่าลืมมาเพิ่ม
//กองพัฒนาขีดความสามารถธุรกิจอุตสาหกรรม
298 => "ผอ.กข.กสอ.", 415 => "หฝบท.กข.กสอ.", 416 => "ผกจ.กข.กสอ.", 417 => "ผกร.กข.กสอ.", 418 => "ผกบ.กข.กสอ.", 
419 => "ผกผ.กข.กสอ.", 420 => "ผกอ.กข.กสอ.", 
//กองพัฒนาดิจิทัลอุตสาหกรรม
305 => "ผอ.กท.กสอ.", 421 => "หฝบท.กท.กสอ.", 422 => "ผกช.กท.กสอ.", 423 => "ผกบ.กท.กสอ.", 424 => "ผกพ.กท.กสอ.", 
//กองยุทธศาสตร์และแผนงาน
265 => "ผอ.กง.กสอ.", 384 => "หฝบท.กง.กสอ.", 427 => "ผกร.กง.กสอ.", 428 => "ผกต.กง.กสอ.", 429 => "ผกผ.กง.กสอ.",
430 => "ผกพ.กง.กสอ.",  431 => "ผกย.กง.กสอ.",  432 => "ผกศ.กง.กสอ.", 
//กองโลจิสติกส์
322 => "ผอ.กล.กสอ.", 433 => "หฝบท.กล.กสอ.", 434 => "ผกน.กล.กสอ.", 435 => "ผกพ.กล.กสอ.", 436 => "ผกม.กล.กสอ.", 
437 => "ผกอ.กล.กสอ.", 439 => "ผกส.กล.กสอ.", 
//กองส่งเสริมผู้ประกอบการและธุรกิจใหม่
266 => "ผอ.กม.กสอ.", 385 => "หฝบท.กม.กสอ.", 386 => "ผกจ.กม.กสอ.", 440 => "ผกพ.กม.กสอ.", 387 => "ผกส.กม.กสอ.", 
//ศูนย์เทคโนโลยีสารสนเทศและการสื่อสาร
328 => "ผอ.ศส.กสอ.", 441 => "ผกบ.ศส.กสอ.", 442 => "ผกง.ศส.กสอ.", 443 => "ผกท.ศส.กสอ.", 438 => "ผกค.ศส.กสอ.",
//กองพัฒนาเกษตรอุตสาหกรรม
267 => "ผกธ.กอ.กสอ.", 268 => "ผกผ.กอ.กสอ.", 262 => "หฝบท.กอ.กสอ.", 263 => "ผกจ.กอ.กสอ.", 264 => "ผกน.กอ.กสอ.",
//กลุ่มตรวจสอบภายใน
362 => "ผอ.ตสน.กสอ.", 
);

dbdpis::ConnectDB(SSO_DB_NAME, SSO_DB_TYPE, SSO_ROOT_HOST, SSO_ROOT_USER, SSO_ROOT_PASSWORD, SSO_DB_NAME, SSO_CHAR_SET);

// GET DEP_LV1_ID, DEP_LV2_ID, POS_NAME
$chk_per_type = "SELECT B.*, C.DEP_NAME AS DEP_NAME1, D.DEP_NAME AS DEP_NAME2, E.POS_NAME
				FROM USR_MAIN A
				LEFT JOIN M_PER_PROFILE B ON B.PER_IDCARD = A.USR_OPTION3
				LEFT JOIN USR_DEPARTMENT C ON C.DEP_ID = B.DEP_LV1_ID
				LEFT JOIN USR_DEPARTMENT D ON D.DEP_ID = B.DEP_LV2_ID
				LEFT JOIN USR_POSITION E ON E.POS_ID = B.PER_POS_ID
				WHERE A.USR_USERNAME = '".$_SESSION['EWT_USERNAME']."' ";
$q = dbdpis::execute($chk_per_type);
$chk = dbdpis::Fetch($q);
// GET POS_LEVEL_NAME
// ERROR ???
// $chk_pos_level_name = "SELECT C.POS_LEVEL_NAME
				// FROM USR_MAIN A
				// LEFT JOIN M_PER_PROFILE B ON B.PER_IDCARD = A.USR_OPTION3
				// LEFT JOIN M_POSITION_LEVEL C ON B.PER_POSITION_LVL = C.POS_LEVEL_ID
				// WHERE A.USR_USERNAME = '".$_SESSION['EWT_USERNAME']."' ";
// $q2 = dbdpis::execute($chk_pos_level_name);
// $chk2 = dbdpis::Fetch($q2);
//per_id fix ไว้ก่อน
if(!$_GET["Page"]){
	$_GET["Page"] = 1;
}
$data_request = array(
						// "per_id" => '6848',
						"username" => $_SESSION['EWT_USERNAME'],
						"trip_start" => $_GET["trip-start"],
						"trip_end" => $_GET["trip-end"],
						"system" => $_GET["SYSTEM"],
						"status" => $_GET["STATUS"],
						"Per_Page" => 10,
						"Page" => $_GET["Page"],
						"Num_Rows" => $_GET["Num_Rows"],
					);
$getRequestBookingAllList = callAPI('getRequestBookingAllList', $data_request);


// echo '<br><br><br><br><pre>';
// print_r($data_request);
// echo '</pre>';

// echo '<br><br><br><br><pre>';
// print_r($short_dep[443]);
// echo '</pre>';

// echo '<br><br><br><br><pre>';
// print_r($chk);
// echo '</pre>';

?>



<style>
    .icon_fa_left:hover{
     color:#82288c;
}
.icon_fa_right{
     color:#82288c;
}
.form-control{
    border: 1px solid #981c9d !important;
    border-radius: 5px !important;
}

     ul#sub_menu li {
          display: inline;
     }
     .icon_file{
          font-size: 50px;
    margin-left: 124px;
    color:#ccc;
    margin-top:10px;
}
.user_list{
     border-radius: 15px;
    height: 20px;
    width: 20px;
}
.page-item.active .page-link {
    z-index: 3;
    color: #fff;
    background-color: #82288c;
    border-color: #82288c;
}
.page-link {
    position: relative;
    display: block;
    padding: 0.5rem 0.75rem;
    margin-left: -1px;
    line-height: 1.25;
    color:#82288c;
    /* color: #007bff; */
    background-color: #fff;
    border: 1px solid #dee2e6;
}
.page-item{
     margin:9px;
}

@media (min-width: 320px) { 
	.SYSTEM{
		margin-top: 8%;
	}
	.but_Booking_staus{

	}
}

@media (min-width: 768px) { 
	.SYSTEM{
		margin-top: 8%;
	}
}

@media (min-width: 1024px) { 
	.SYSTEM{
		margin-top: 10%;
	}
	.STATUS{
		margin-top: 10%;
	}
	.but_Booking_staus{
		margin-top: 17%;
	}
}


@media (min-width: 1440px) { 
	.SYSTEM{
		margin-top: 8%;
	}
	.STATUS{
		margin-top: 8s%;
	}
	.but_Booking_staus{
		margin-top: 13%;
	}
}


</style>

<div class="container mar-spacehead mb-5">

<form id="form_wf" action="Booking_status.php" method="get" role="form">
    <!-- ส่วนของข้อมูลผู้ใช้ -->
    <h2 class="h2-color pt-4">
        <i class="fa fa-check-circle"></i> สถานะคำขอ
    </h2>
    <div class="row">
        <div class="col-lg-6 col-md-4 col-sm-12 col-12">
            <h5 class="h2-color mt-2"><a href="profile.php">ข้อมูลผู้ใช้งาน > </a> <span>สถานะคำขอ</span></h5>
        </div>
        <!-- แบ่งส่วนไอคอนหน้าการจอง ห้องประชุม / หนังสือรับรอง / ยานพาหนะ -->
        <div class="col-lg-6 col-md-8 col-sm-12 col-12  ">
            <div class="row">
                <!-- ห้องประชุม -->
                <div class="col-lg-4 col-md-4 col-sm-4 col-12 ">
                    <img src="images/2meet.png" class="thumnal-iconfunction" alt="Meetingroom"><span class="ml-1 h2-color"> ห้องประชุม</span>
                </div>
                <!-- ยานพาหนะ -->
                <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                    <img src="images/2car.png" class="thumnal-iconfunction" alt="car"><span class="ml-1 h2-color"> ยานพาหนะ</span>
                </div>
                <!-- หนังสือรับรอง -->
                <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                    <img src="images/2certificate.png" class="thumnal-iconfunction" alt="certificate"><span class="ml-1 h2-color"> หนังสือรับรอง</span>
                </div>
            </div>
        </div>
    </div>
    <hr class="hr_news mt-0">

    <div class="row mb-3" >
        <div class="col-lg-4 col-md-12 col-sm-12 col-12">
		<div class="row">
			<div class="col-xl-6">
				<h5 class="mb-0 Datepick-start-stop"><i class="fa fa-calendar"></i> วันเริ่มต้น</h5>
				<input class="mt-0  pb-1 border-0 form-control" type="date" id="trip-start" name="trip-start" value="<?php echo $_GET["trip-start"];?>" >
			</div>
			<div class="col-xl-6">
				<h5 class="mb-0 Datepick-start-stop"><i class="fa fa-calendar"></i> วันที่สิ้นสุด</h5>
				<input class="mt-0  pb-1 border-0 form-control" type="date" id="trip-end" name="trip-end" value="<?php echo $_GET["trip-end"];?>" >
			</div>
		</div>
          <div class=" Datepick-start-stop">
                <div class="row" style="  border: 1px solid #981c9d;  border-radius: 5px;">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-12 ">
                        <h5 class=" mb-0"><i class="fa fa-calendar"></i> วันเริ่มต้น</h5>
                        <input class="mt-0  pb-1 border-0" type="date" id="trip-start" name="trip-start" value="<?php echo $_GET["trip-start"];?>" >
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                        <h5 class=" mb-0"><i class="fa fa-calendar"></i> วันที่สิ้นสุด</h5>
                        <input class="mt-0  pb-1 border-0" type="date" id="trip-end" name="trip-end" value="<?php echo $_GET["trip-end"];?>" >
                    </div>
                </div>
            </div> 
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-2">
			<div class="row">
				<div class="col-xl-12 ">
					<div id="SYSTEM_BSF_AREA" class=" ">
						<select style="height: 38px;" name="SYSTEM" id="SYSTEM" class="form-control SYSTEM" required="" aria-required="true" placeholder="เลือก" tabindex="-1" aria-hidden="true">
							<option value="99"  >แสดงประเภทคำขอทั้งหมด</option>
							<option value="1" <?php  echo ($_GET["SYSTEM"]==1 ? "selected":"");?> >จองห้องประชุม</option>
							<option value="2" <?php  echo ($_GET["SYSTEM"]==2 ? "selected":"");?>>จองยานพาหนะ</option>
							<option value="3" <?php  echo ($_GET["SYSTEM"]==3 ? "selected":"");?>>ขอหนังสือรับรับรอง</option>
						</select>
					</div>
				</div>
			</div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-2">
			<div class="row">
				<div class="col-xl-12">
					<div id="STATUS_BSF_AREA" class=" ">
						<select style="height: 38px;" name="STATUS" id="STATUS" class="form-control STATUS" required="" aria-required="true" placeholder="เลือก" tabindex="-1" aria-hidden="true">
							<option value="99"  >แสดงสถานะทั้งหมด</option>
							<option value="1" <?php  echo ($_GET["STATUS"]==1 ? "selected":"");?>>ดำเนินการเสร็จสิ้น</option>
							<option value="2" <?php  echo ($_GET["STATUS"]==2 ? "selected":"");?>>อยู่ระหว่างดำเนินการ</option>
							<option value="3" <?php  echo ($_GET["STATUS"]==3 ? "selected":"");?>>ไม่ผ่านการอนุมัติ	/ ยกเลิกเสร็จสิ้น</option>
						</select>
					</div>
				</div>
			</div>
        </div>
        <div class="col-lg-2 col-md-12 col-sm-12 col-12">
		<div class="row">
			<div class="col-xl-12 text-center">
				 <!--<button type="submit" class="btn-search btn Gradient-Color shadow-sm btn-sm mt-2"><i class="fa fa-search"></i> ค้นหาประวัติ</button>-->
				 <a onclick="search_data()"  class="btn-search btn Gradient-Color shadow-sm btn-sm but_Booking_staus" role="button" aria-pressed="true">ค้นหาประวัติ</a>
			</div>
		</div>
        </div>
    </div>
</form>




<div align="right" hidden>
หมายเหตุ : สามารถ ลบ การจองได้ทันทีหาก ผอ.ของท่าน หรือ ผู้ดูแลห้อง ยังไม่พิจารณา
</div><br>

    <div class="table-responsive-sm">
        <table class="table table-sm">
            <thead class="white-text bg-color-purple ta-fontmini">
                <tr>
                    <th scope="col">Icon</th>
                    <th scope="col">ประเภทคำขอ</th>
                    <th scope="col">เลขที่คำขอ</th>
                    <th scope="col">หัวข้อคำขอ</th>
                    <th scope="col">ลงวันที่</th>
                    <th scope="col">สถานที่</th>
                    <th scope="col">สถานะ</th>
                    <th scope="col">รายละเอียด</th>
                    <th scope="col">จัดการ</th>
                </tr>
            </thead>
            <tbody>
			<?php
			if($getRequestBookingAllList['ResponseCode']['ResCode'] == '000'){
				foreach($getRequestBookingAllList['Data'] as $key => $value){
				$i = 0;
				
				while($i < COUNT($value['FILE_SAVE_NAME'])){
					file_put_contents('file_car/'.$value['FILE_SAVE_NAME'][$i], file_get_contents($value['FILE_SAVE_NAME_DEFULT'][$i]));// บันทึกไฟล์แนบ จาก WF
					$i++;
				}
				$status_request = array(
					"type" => 'CB_FILE',
					"wfr_id" => $value['WFR_ID'],
				);
				$updateStatusPic = callAPI('updateStatusPic',$status_request);
					$p1 = ""; $p2 = ""; $p3 = ""; $p4 = ""; $p5 = ""; $p6 = ""; $p7 = "";
					
######## จองห้องประชุม ########	
				if($value['TYPE']==1){
					$request_type = "จองห้องประชุม";
					// $img = "images/2meet.png";
					$img = "<img src='images/2meet.png' class='thumnal-iconfunction' alt='Meetingroom'>";
					$hid = "";
					
					$data_request1_1 = array(
						"wfr_id" => $value['WFR_ID']
					);
					$getRequestBookingRoomDetail = callAPI('getRequestBookingRoomDetail', $data_request1_1);
					$get_ROOM_PIC_NAME = $getRequestBookingRoomDetail['Data'][0]['ROOM_PIC_NAME'];
					
					$topic = $value['MEETING_TOPIC'];
					$get_CB_OBJECTIVE_TYPE = $value['MEETING_TOPIC'];
					// $btn_del = '';

					$p1 = "<i class='fa fa-user h2-color  pb-0'> </i> ประธานในที่ประชุม : ".$value['MEETINH_CHAIRMAN'];
					$p2 = "<i class='fa fa-user-tie h2-color  pb-0'></i> ชื่อผู้จอง : ".$value['REQ_NAME'];
					$p3 = "<i class='fa fa-briefcase h2-color  pb-0'></i> หน่วยงานผู้จอง : ศูนย์เทคโนโลยีสารสนเทศและการสื่อสาร";
					$p4 = "<i class='fa fa-phone h2-color  pb-0'></i> เบอร์ติดต่อผู้จอง :".$value['REQ_TEL'];
					$p5 = "<i class='fa fa-user h2-color  pb-0'> </i> ผู้เข้าร่วม ".$value['MEETING_NUM_PP']." คน";
					$p6 = "<i class='fa fa-door-open h2-color  pb-0'></i> ".$value['ROOM_NAME'];
					$p7 = "<i class='fa fa-calendar h2-color  pb-0'></i> ".($value['MEETING_DATE'] == $value['MEETING_EDATE'] ? "วันที่ ".$value['MEETING_DATE']:"วันที่ ".$value['MEETING_DATE']." - ".$value['MEETING_EDATE'])." เวลา ".$value['STIME']." น. -  ".$value['ETIME']." น.";
					$p8 = "";
					$p9 = "";
					$p10 = "ใบขออนุญาตใช้ห้องประชุม : ";
					$data_request_room_wfd1 = array(
						"wfr_id" => $value['WFR_ID'],
						"wf_main_id" => '6682',
						"wfd_id" => '2471',
						"req_type" => 'room_app1' //ผู้ผ่านความเห็นชอบ
					);
					$getWFSTEP_room_wfd1 = callAPI('getWFSTEP', $data_request_room_wfd1);
					foreach($getWFSTEP_room_wfd1['Data'][$value['WFR_ID']] as $key => $v1){
						$app_room_1 = $v1['USR_NAME'];
						$app_room_1_username = $v1['USR_USERNAME'];
					}
					$data_request_wfd2 = array(
						"wfr_id" => $value['WFR_ID'],
						"wf_main_id" => '6682',
						"wfd_id" => '2477'
					);
					$getWFSTEP_wfd_room_2 = callAPI('getWFSTEP', $data_request_wfd2);
					foreach($getWFSTEP_wfd_room_2['Data'][$value['WFR_ID']] as $key => $v2){
						$app_room_2 = $v2['USR_NAME'];
					}
					
					$sql_app_room_1 = "SELECT B.DEP_LV2_ID
									FROM USR_MAIN A
									LEFT JOIN M_PER_PROFILE B ON B.PER_IDCARD = A.USR_OPTION3
									WHERE A.USR_USERNAME = '".$app_room_1_username."' ";
					$q_app_room_1 = dbdpis::execute($sql_app_room_1);
					$chk_app_room_1 = dbdpis::Fetch($q_app_room_1);
					$app1_dep_room_name = $short_dep[$chk_app_room_1["DEP_LV2_ID"]];// ผ่าน (ตำแหน่งย่อ) 
					
					// ERROR $value['REQ_DATE_OG']
					/* $p10 .= '<a style="width:80px;text-align:center;" type="button" class=" " onclick="window.open('."'".'FILE_PDF/booking_room_report_pdf.php?CB_PER_ID='.$value['REQ_NAME'].'&CB_AREA='.$value['ROOM_NAME'].'&CB_MEMBER='.$value['MEETING_NUM_PP'].'&CB_OBJ='.$value['MEETING_TOPIC'].'&MEETING_DATE='.$value['MEETING_DATE2'].'&MEETING_EDATE='.$value['MEETING_EDATE2'].'&STIME='.$value['STIME'].'&ETIME='.$value['ETIME'].'&REQ_TEL='.$value['REQ_TEL'].'&CAR_REGISTER='.$get_CAR_REGISTER.'&DEP_NAME1='.$chk['DEP_NAME1'].'&DEP_NAME2='.$chk['DEP_NAME2'].'&POS_NAME='.$chk['POS_NAME'].'&APP_1='.$app_room_1.'&APP_1_NAME='.$app1_dep_room_name.'&APP_2_NAME='.$short_dep[$value["DEP_KEEPER_SSO"]].'&APP_2='.$app_room_2.'&MEETINH_CHAIRMAN='.$value['MEETINH_CHAIRMAN'].'&WFR_ID='.$value["WFR_ID"].'&CB_RECORD='.$value['REQ_DATE_OG'].' '."'".', '."'".'_blank'."'".',);" > download</a>'; */
					$p10 .= '<a style="width:80px;text-align:center;" type="button" class=" " onclick="window.open('."'".'FILE_PDF/booking_room_report_pdf.php?CB_PER_ID='.$value['REQ_NAME'].'&CB_AREA='.$value['ROOM_NAME'].'&CB_MEMBER='.$value['MEETING_NUM_PP'].'&CB_OBJ='.$value['MEETING_TOPIC'].'&MEETING_DATE='.$value['MEETING_DATE2'].'&MEETING_EDATE='.$value['MEETING_EDATE2'].'&STIME='.$value['STIME'].'&ETIME='.$value['ETIME'].'&REQ_TEL='.$value['REQ_TEL'].'&CAR_REGISTER='.$get_CAR_REGISTER.'&DEP_NAME1='.$chk['DEP_NAME1'].'&DEP_NAME2='.$chk['DEP_NAME2'].'&POS_NAME='.$chk['POS_NAME'].'&APP_1='.$app_room_1.'&APP_1_NAME='.$app1_dep_room_name.'&APP_2_NAME='.$short_dep[$value["DEP_KEEPER_SSO"]].'&APP_2='.$app_room_2.'&MEETINH_CHAIRMAN='.$value['MEETINH_CHAIRMAN'].'&WFR_ID='.$value["WFR_ID"].' '."'".', '."'".'_blank'."'".',);" > download</a>';
					
					$img2 = '<img src="images/'.$get_ROOM_PIC_NAME.'" class="d-block w-100" alt="...">';
					
					
					$data_request1_2 = array(
						"wfr_id" => $value["WFR_ID"]
					);
					$getMeetingToolAdd = callAPI('getMeetingToolAdd', $data_request1_2);
					
					if($value['APPROVE_STATUS1'] == 1 && $value['APPROVE_STATUS2'] == 1 && $value['APPROVE_STATUS3'] == 1){
						$status = "<font color='green'>อนุมัติห้องประชุมเรียบร้อยแล้ว</font>";
						$btn_del = '';
						$btn_cancel = '';
						$btn_estimate = '';
						if($value['MEETING_DATE2'] > date('Y-m-d')){ // ยกเลิกได้ก่อนถึงวันที่จองเท่านั้น
							if($value['CANCEL_STATUS1'] == '9' || $value['CANCEL_STATUS1'] == '1'){ // ขอยกเลิกแล้ว
							$btn_cancel = '<p style="color:orange;">รอพิจารณายกเลิก</p>';
							}else{ // ยังไม่ขอยกเลิก
							## ถ้าจะเปิดยกเลิก เปิดตรงนี้ ##
							/* $btn_cancel = "<button  style='height:30px;padding:1px 10px 1px 10px;font-size: 14px;' class='btn btn-warning btn-mini' data-toggle='tooltip' title='ขอยกเลิกการจอง'  id='btn_cancel' name='btn_cancel'  onclick='cancel_list(".$value['WFR_ID'].")'  value='".$value['WFR_ID']."'>ยกเลิก</button>"; */
							$btn_cancel = '';
							}
						}
						
						if($value['MEETING_DATE2'] <= date('Y-m-d')){ // ต้องถึงวันที่ประชุมแล้วถึงจะประเมินได้
							if($value['ANS_01']){ // ประเมินแล้ว
							$btn_estimate = '<p style="color:green;">ประเมินแล้ว</p>';	
							}else { // ยังไม่ได้ประเมิน
							$btn_estimate = '<a style="height:30px;padding:4px 10px 1px 10px;font-size: 14px;" href="form_estimateRoom.php?wfr_id='.$value["WFR_ID"].'" target="_blank" class="btn btn-success btn-mini">ประเมิน</a>';
							}
						}
						
						
					}else if ($value['APPROVE_STATUS1'] == 1 && $value['APPROVE_STATUS2'] == 1 && $value['APPROVE_STATUS3'] == 0){
						$status = "<font color='orange'>รอการอนุมัติ/อนุญาต</font>";
						$btn_del = '';
						$btn_cancel = '';
						$btn_estimate = '';
						
						if($value['MEETING_DATE2'] > date('Y-m-d')){ // ยกเลิกได้ก่อนถึงวันที่จองเท่านั้น
							if($value['CANCEL_STATUS1'] == '9' || $value['CANCEL_STATUS1'] == '1'){ // ขอยกเลิกแล้ว
							$btn_cancel = '<p style="color:orange;">รอพิจารณายกเลิก</p>';
							}else{ // ยังไม่ขอยกเลิก
							## ถ้าจะเปิดยกเลิก เปิดตรงนี้ ##
							/* $btn_cancel = "<button  style='height:30px;padding:1px 10px 1px 10px;font-size: 14px;' class='btn btn-warning btn-mini' data-toggle='tooltip' title='ขอยกเลิกการจอง'  id='btn_cancel' name='btn_cancel'  onclick='cancel_list(".$value['WFR_ID'].")'  value='".$value['WFR_ID']."'>ยกเลิก</button>"; */
							$btn_cancel = '';
							}
						}
					}else if ($value['APPROVE_STATUS1'] == 1 && $value['APPROVE_STATUS2'] == 0 && $value['APPROVE_STATUS3'] == 0){
						$status = "<font color='orange'>อยู่ระหว่างพิจารณาเงื่อนไข</font>";
						$btn_del = '';
						$btn_cancel = '';
						$btn_estimate = '';
						$btn_del = "<button style='height:30px;padding:1px 10px 1px 10px;font-size: 14px;' class='btn btn-danger btn-mini' data-toggle='tooltip' title='สามารถลบได้ทันที หากผู้ดูแลห้องยังไม่ได้พิจารณา'  id='btn_del' name='btn_del' onclick='del_list(".$value['WFR_ID'].",6682)' value='".$value['WFR_ID']."'>ลบ</button>";
						// $btn_cancel = "<button  style='height:30px;padding:1px 10px 1px 10px;' class='btn btn-warning btn-mini' data-toggle='tooltip' title='ขอยกเลิกการจอง'  id='btn_cancel' name='btn_cancel' value='".$value['WFR_ID']."'>ยกเลิก</button>";
					}else if ($value['APPROVE_STATUS1'] == 0 && $value['APPROVE_STATUS2'] == 0 && $value['APPROVE_STATUS3'] == 0){
						$status = "<font color='orange'>รอการผ่านความเห็นชอบ</font>";
						$btn_del = "<button  style='height:30px;padding:1px 10px 1px 10px;font-size: 14px;' class='btn btn-danger btn-mini' data-toggle='tooltip' title='สามารถลบได้ทันที หากผอ.ของท่านยังไม่ได้พิจารณา'  id='btn_del' name='btn_del'  onclick='del_list(".$value['WFR_ID'].",6682)' value='".$value['WFR_ID']."'>ลบ</button>";
						$btn_cancel = '';
						$btn_estimate = '';
					} 
					if ($value['WF_DET_STEP'] == 2475){
						$status = "<font color='red'>ไม่ผ่านการอนุมัติ</font>";$btn_del = '';$btn_cancel = '';
						$btn_estimate = '';
					}else if ($value['WF_DET_STEP'] == 2481){
						$status = "<font color='red'>ยกเลิกเสร็จสิ้น<br></font>
								   <font hidden id='room_font".$value['WFR_ID']."' color='red'>".$value['CANCEL_NOTE']."</font>
						";
						$btn_del = '';$btn_cancel = '';
						$btn_estimate = '';
					}
					
######## จองยานพาหนะ ########	
				}else if($value['TYPE']==2){
					$request_type = "จองยานพาหนะ";
					// $img = "images/2car.png";
					$img = "<img src='images/2car.png' class='thumnal-iconfunction' alt='Meetingroom'>";
					$hid = "";
					
					$data_request2 = array(
						"wfr_id" => $value['WFR_ID']
					);
					$getRequestBookingCarDetail = callAPI('getRequestBookingCarDetail', $data_request2);
					// echo "<pre>";
					// echo print_r($getRequestBookingCarDetail['Data']);
					// echo "</pre>";
					$get_CB_OBJECTIVE_TYPE = $getRequestBookingCarDetail['Data'][0]['CB_OBJECTIVE_TYPE'];
					$get_CAR_KEEPER = $getRequestBookingCarDetail['Data'][0]['CAR_KEEPER'];
					$get_CB_PER_ID = $getRequestBookingCarDetail['Data'][0]['CB_PER_ID'];
					$get_CAR_ID = $getRequestBookingCarDetail['Data'][0]['CAR_ID'];
					$get_CAR_REGISTER = $getRequestBookingCarDetail['Data'][0]['CAR_DETAIL'];
					$get_CAR_REGISTER2 = $getRequestBookingCarDetail['Data'][0]['CAR_REGISTER'];
					$get_CAR_MILEAGE = $getRequestBookingCarDetail['Data'][0]['CAR_MILEAGE'];
					$get_CAR_PIC_NAME = $getRequestBookingCarDetail['Data'][0]['CAR_PIC_NAME'];
					$get_STAFF_NAME = $getRequestBookingCarDetail['Data'][0]['STAFF_FULL_NAME'];
					$get_STAFF_TALAPHONE = $getRequestBookingCarDetail['Data'][0]['STAFF_TALAPHONE'];
					$get_DEP_ID_SSO = $getRequestBookingCarDetail['Data'][0]['DEP_ID_SSO'];
					$topic = $get_CB_OBJECTIVE_TYPE;
					
					$btn_del = '';
					$btn_cancel = '';
					$btn_estimate = '';
					
					// $p1 = "<i class='fa fa-user h2-color  pb-0'></i> ผู้รับผิดชอบ :  ".$get_CAR_KEEPER;
					// $p2 = "<i class='fa fa-user-tie h2-color  pb-0'></i> ผู้ผ่านการเห็นชอบ :  ".$value['CS_APPROVE_PER_ID'];
					$p3 = "<i class='fa fa-user h2-color  pb-0'></i> ผู้เดินทาง : ".$value['MEETING_NUM_PP']." คน";
					$p4 = "<i class='fa fa-car h2-color  pb-0'></i> ".($get_CAR_REGISTER ? $get_CAR_REGISTER:"--  ยังไม่จัดสรรยานพาหนะ -- ");
					$p5 = "<i class='fa fa-user h2-color  pb-0'></i> พนักงานขับรถ :  ".$get_STAFF_NAME;
					$p6 = "<i class='fa fa-phone h2-color  pb-0'></i> เบอร์พนักงานขับรถ :  ".$get_STAFF_TALAPHONE;
					// $p7 = "<img width='16' src='images/speed.png' alt='img'> เลขไมล์ : ".$get_CAR_MILEAGE;
					$p8 = "<i class='fa fa-calendar h2-color  pb-0'></i> ".($value['MEETING_DATE'] == $value['MEETING_EDATE'] ? "วันที่ ".$value['MEETING_DATE']:"วันที่ ".$value['MEETING_DATE']." - ".$value['MEETING_EDATE'])." เวลา ".$value['STIME']." น. -  ".$value['ETIME']." น.";
					$p9 = "เอกสารแนบ : ";
					$p10 = "ใบขออนุญาตใช้รถยนต์ส่วนกลาง : ";
					$x = 0;
				while($x < COUNT($value['FILE_SAVE_NAME'])){
					$p9 .= "<a href='file_car/".$value['FILE_SAVE_NAME'][$x]."' download>".$value['FILE_NAME'][$x]."</a><br>";
					$x++;
				}
					$data_request_wfd1 = array(
						"wfr_id" => $value['WFR_ID'],
						"wf_main_id" => '7047',
						"wfd_id" => '2472',
						"req_type" => 'car_app1' //ผู้ผ่านความเห็นชอบ
					);
					$getWFSTEP_wfd1 = callAPI('getWFSTEP', $data_request_wfd1);
					foreach($getWFSTEP_wfd1['Data'][$value['WFR_ID']] as $key => $v1){
						$app_1 = $v1['USR_NAME'];// ผ่าน (ชื่อ)
						$app_1_username= $v1['USR_USERNAME'];
					}
					$data_request_wfd2 = array(
						"wfr_id" => $value['WFR_ID'],
						"wf_main_id" => '7047',
						"wfd_id" => '1652'
					);
					$getWFSTEP_wfd2 = callAPI('getWFSTEP', $data_request_wfd2);
					foreach($getWFSTEP_wfd2['Data'][$value['WFR_ID']] as $key => $v2){
						$app_2 = $v2['USR_NAME']; //เรียน (ชื่อ)
					}
					
					$sql_app_1 = "SELECT B.DEP_LV2_ID
									FROM USR_MAIN A
									LEFT JOIN M_PER_PROFILE B ON B.PER_IDCARD = A.USR_OPTION3
									WHERE A.USR_USERNAME = '".$app_1_username."' ";
					$q_app_1 = dbdpis::execute($sql_app_1);
					$chk_app_1 = dbdpis::Fetch($q_app_1);
					
					$app1_dep_name = $short_dep[$chk_app_1["DEP_LV2_ID"]];// ผ่าน (ตำแหน่งย่อ)
					
					## ERROR POS_LEVEL_NAME ##
					/* $p10 .= '<a style="width:80px;text-align:center;" type="button" class=" " onclick="window.open('."'".'FILE_PDF/booking_car_report_pdf.php?CB_PER_ID='.$get_CB_PER_ID.'&CB_AREA='.$value['ROOM_NAME'].'&CB_MEMBER='.$value['MEETING_NUM_PP'].'&CB_OBJ='.$value['MEETING_TOPIC'].'&MEETING_DATE='.$value['MEETING_DATE2'].'&MEETING_EDATE='.$value['MEETING_EDATE2'].'&STIME='.$value['STIME'].'&ETIME='.$value['ETIME'].'&REQ_TEL='.$value['REQ_TEL'].'&DEP_NAME1='.$chk['DEP_NAME1'].'&DEP_NAME2='.$chk['DEP_NAME2'].'&POS_NAME='.$chk['POS_NAME'].'&POS_LEVEL_NAME='.$chk2['POS_LEVEL_NAME'].'&APP_1='.$app_1.'&APP_1_NAME='.$app1_dep_name.'&APP_2='.$app_2.'&CAR_REGISTER='.$get_CAR_REGISTER2.'&CB_RECORD='.$getRequestBookingCarDetail['Data'][0]['W_CAR_MILEAGE'].'&W_CAR_MILEAGE='.$getRequestBookingCarDetail['Data'][0]['W_CAR_MILEAGE'].'&R_CAR_MILEAGE='.$getRequestBookingCarDetail['Data'][0]['R_CAR_MILEAGE'].'&CS_PER_NAME='.$getRequestBookingCarDetail['Data'][0]['ALLOCATE_NAME'].' '."'".', '."'".'_blank'."'".',);" > download</a>'; */
					$p10 .= '<a style="width:80px;text-align:center;" type="button" class=" " onclick="window.open('."'".'FILE_PDF/booking_car_report_pdf.php?CB_PER_ID='.$get_CB_PER_ID.'&CB_AREA='.$value['ROOM_NAME'].'&CB_MEMBER='.$value['MEETING_NUM_PP'].'&CB_OBJ='.$value['MEETING_TOPIC'].'&MEETING_DATE='.$value['MEETING_DATE2'].'&MEETING_EDATE='.$value['MEETING_EDATE2'].'&STIME='.$value['STIME'].'&ETIME='.$value['ETIME'].'&REQ_TEL='.$value['REQ_TEL'].'&DEP_NAME1='.$chk['DEP_NAME1'].'&DEP_NAME2='.$chk['DEP_NAME2'].'&POS_NAME='.$chk['POS_NAME'].'&APP_1='.$app_1.'&APP_1_NAME='.$app1_dep_name.'&APP_2='.$app_2.'&CAR_REGISTER='.$get_CAR_REGISTER2.'&W_CAR_MILEAGE='.$getRequestBookingCarDetail['Data'][0]['W_CAR_MILEAGE'].'&R_CAR_MILEAGE='.$getRequestBookingCarDetail['Data'][0]['R_CAR_MILEAGE'].'&CS_PER_NAME='.$getRequestBookingCarDetail['Data'][0]['ALLOCATE_NAME'].' '."'".', '."'".'_blank'."'".',);" > download</a>';
					
					if($get_CAR_PIC_NAME){
						$img2 = '<img src="images/'.$get_CAR_PIC_NAME.'" class="d-block w-100" alt="...">';
					}else{
						$img2 = '-- ยังไม่จัดสรรยานพาหนะ --';
					}
					
					if($value['APPROVE_STATUS3']==5){
						$status = "<font color='green'>จ่ายยานพาหนะแล้ว</font>";//จัดสรรรถเรียบร้อยแล้ว
						/* if($value['ANS_01']){ // ประเมินแล้ว
						$btn_estimate = '<p style="color:green;">ประเมินแล้ว</p>';	
						}else { // ยังไม่ได้ประเมิน
						$btn_estimate = '<a href="form_estimateCar.php?wfr_id='.$value["WFR_ID"].'" target="_blank" class="btn btn-success btn-mini">ประเมิน</a>';
						} */
						
						if($value['TRAVEL_STATUS'] == 1){//เดินทางเสร็จสิ้น
							if($value['ANS_01']){ // ประเมินแล้ว
								$btn_estimate = '<p style="color:green;">ประเมินแล้ว</p>';	
							}else { // ยังไม่ได้ประเมิน
								$btn_estimate = '<a style="height:30px;padding:4px 10px 1px 10px;font-size: 14px;" href="form_estimateCar.php?wfr_id='.$value["WFR_ID"].'" target="_blank" class="btn btn-success btn-mini">ประเมิน</a>';
							}
						}else{
								$btn_estimate = "<button   style='height:30px;padding:1px 10px 1px 10px;font-size: 14px;' class='btn btn-success btn-mini' data-toggle='tooltip' title=''  id='btn_travel' name='btn_travel'  onclick='travel_list(".$value['WFR_ID'].")'  value='".$value['WFR_ID']."'>เดินทางเสร็จสิ้น</button>";
						}
					}else if($value['APPROVE_STATUS1']==1 && $value['APPROVE_STATUS2']==1){
						$status = "<font color='orange'>รอการจัดสรรยานพาหนะ</font>";
					}else if($value['APPROVE_STATUS1']==1 && $value['APPROVE_STATUS2']==0){
						$status = "<font color='orange'>รอการอนุมัติ/อนุญาต</font>";
					}else if($value['APPROVE_STATUS1']==0 && $value['APPROVE_STATUS2']==0){
						$status = "<font color='orange'>รอการผ่านความเห็นชอบ</font>";
						$btn_del = "<button style='height:30px;padding:1px 10px 1px 10px;font-size: 14px;' class='btn btn-danger btn-mini' data-toggle='tooltip' title='สามารถลบได้ทันที หากยังไม่ผ่านความเห็นชอบ'  id='btn_del' name='btn_del' onclick='del_list(".$value['WFR_ID'].",7047)' value='".$value['WFR_ID']."'>ลบ</button>";
					}
					if ($value['WF_DET_STEP'] == 2482){
						$status = "<font color='red'>ไม่ผ่านการอนุมัติ</font>";
					}
					else if ($value['WF_DET_STEP'] == 2484){
						//fa fa-eye , fa fa-ellipsis-h
						$status = "
						<font color='red'>ยกเลิกเสร็จสิ้น</font>
						<!--<i class='fa fa-ellipsis-h'  color='#82288C' OnMouseOver='showFont(".$value['WFR_ID'].",".$value['TYPE'].")' OnMouseOut='hideFont(".$value['WFR_ID'].",".$value['TYPE'].")'></i>--><br>
						<font hidden id='car_font".$value['WFR_ID']."' color='red'>".$value['CANCEL_NOTE']."</font><!-- hidden -->
						";
						$btn_del = '';$btn_cancel = '';
						$btn_estimate = '';
					}
					
######## ขอหนังสือรับรับรอง ########		
				}else if($value['TYPE']==3){
					$request_type = "ขอหนังสือรับรับรอง";
					// $img = "images/2certificate.png";
					$img = "<img src='images/2certificate.png' class='thumnal-iconfunction' alt='Meetingroom'>";
					$hid = "";
					$p8 = ""; 
					$p9 = "";
					$p10 = "";
					
					$img2 = '';
					
					$topic = $value['MEETING_TOPIC'];
					$get_CB_OBJECTIVE_TYPE  = $value['MEETING_TOPIC'];
					
					$btn_del = '';
					$btn_cancel = '';
					$btn_estimate = '';
					$preview = '';
					
					$ap_status = $value['APPROVE_STATUS1'];
					
					if($value['APPROVE_STATUS1']==1){
						$status = "<font color='green'>ดำเนินการแล้วเสร็จ</font>";
						// $preview = "ดูเอกสาร";
					}else{
						$status = "<font color='orange'>รอดำเนินการ</font>";
						// $preview = "ดูตัวอย่าง";
					}
					$preview = "ดูตัวอย่าง";
					
					foreach($value['obj_FILE_SAVE_NAME'] as $key ){
						foreach($key as $k => $v){
							$book_name = "";
							$language = "";
							if ($key['CERTIFICATE_TYPE1'] == 1 && $key['CERTIFICATE_TYPE2'] == 1) {
								$book_name = 'หนังสือรับรองที่มีการระบุเงินเดือนและระยะเวลาทำงาน';
							}else if ($key['CERTIFICATE_TYPE1'] == 1 && $key['CERTIFICATE_TYPE2'] != 1) {
								$book_name = 'หนังสือรับรองที่มีการระบุเฉพาะเงินเดือน';
							}else if ($key['CERTIFICATE_TYPE1'] != 1 && $key['CERTIFICATE_TYPE2'] == 1) {
								$book_name = 'หนังสือรับรองที่มีการระบุเฉพาะระยะเวลาทำงาน';
							}
							if ($key['CERTIFICATE_LANGUAGE1'] == 1 && $key['CERTIFICATE_LANGUAGE2'] == 1) {
								$language = '(ภาษาไทย, ภาษาอังกฤษ)';
							}else if ($key['CERTIFICATE_LANGUAGE1'] == 1 && $key['CERTIFICATE_LANGUAGE2'] != 1) {
								$language = '(ภาษาไทย)';
							}else if ($key['CERTIFICATE_LANGUAGE1'] != 1 && $key['CERTIFICATE_LANGUAGE2'] == 1) {
								$language = '(ภาษาอังกฤษ)';
							} 
							
						}
						
						if($book_name == 'หนังสือรับรองที่มีการระบุเฉพาะระยะเวลาทำงาน' && $language == '(ภาษาไทย)'){
							$data_request_wfr = array(
														"WFR" => $value['WFR_ID'],
												);
							$getCertificateDetail = callAPI('getCertificateDetail',$data_request_wfr);
							// echo '<pre>'; print_r($getCertificateDetail['Data']); echo '</pre>'; 
							
							$f = '<h5 class="h2-color m-0"><a style="width:80px;text-align:center;" type="button" class="border-ra-15px btn-light " onclick="window.open('."'".'FILE_PDF/certificate_work_th_preview_pdf.php?FULL_NAME='.$getCertificateDetail['Data']['FULL_NAME'].'&POS_NAME='.$getCertificateDetail['Data']['POS_NAME'].'&DEP_NAME='.$getCertificateDetail['Data']['DEP_NAME'].'&DEP_NAME2='.$getCertificateDetail['Data']['DEP_NAME2'].'&PER_TYPE_NAME='.$getCertificateDetail['Data']['PER_TYPE_NAME'].'&INCOME_MONEY='.$getCertificateDetail['Data']['INCOME_MONEY'].'&POS_LEVEL_NAME='.$getCertificateDetail['Data']['POS_LEVEL_NAME'].'&DATE_NOW_TH='.$getCertificateDetail['Data']['DATE_NOW_TH'].'&DATE_NOW_EN='.$getCertificateDetail['Data']['DATE_NOW_EN'].'&AP_STATUS='.$ap_status.' '."'".', '."'".'_blank'."'".',);" ><i class="fa fa-eye"></i> '.$preview.'</a></h5>';
						}else if($book_name == 'หนังสือรับรองที่มีการระบุเฉพาะระยะเวลาทำงาน' && $language == '(ภาษาอังกฤษ)'){
							$data_request_wfr = array(
														"WFR" => $value['WFR_ID'],
												);
							$getCertificateDetail = callAPI('getCertificateDetail',$data_request_wfr);
							$f = '<h5 class="h2-color m-0"><a style="width:80px;text-align:center;" type="button" class="border-ra-15px btn-light " onclick="window.open('."'".'FILE_PDF/certificate_work_en_preview_pdf.php?FULL_NAME_EN='.$getCertificateDetail['Data']['FULL_NAME_EN'].'&POS_NAME='.$getCertificateDetail['Data']['POS_NAME_EN'].'&DEP_NAME='.$getCertificateDetail['Data']['DEP_NAME_EN'].'&DEP_NAME2='.$getCertificateDetail['Data']['DEP_NAME2_EN'].'&PER_TYPE_NAME='.$getCertificateDetail['Data']['PER_TYPE_NAME_EN'].'&INCOME_MONEY='.$getCertificateDetail['Data']['INCOME_MONEY'].'&POS_LEVEL_NAME='.$getCertificateDetail['Data']['POS_LEVEL_NAME_EN'].'&DATE_NOW_TH='.$getCertificateDetail['Data']['DATE_NOW_TH'].'&DATE_NOW_EN='.$getCertificateDetail['Data']['DATE_NOW_EN'].'&AP_STATUS='.$ap_status.' '."'".', '."'".'_blank'."'".',);" ><i class="fa fa-eye"></i> '.$preview.'</a></h5>';
						}else if($book_name == 'หนังสือรับรองที่มีการระบุเฉพาะเงินเดือน' && $language == '(ภาษาไทย)'){
							$data_request_wfr = array(
														"WFR" => $value['WFR_ID'],
												);
							$getCertificateDetail = callAPI('getCertificateDetail',$data_request_wfr);
							// echo '<pre>'; print_r($getCertificateDetail['Data']); echo '</pre>'; 
							
							$f = '<h5 class="h2-color m-0"><a style="width:80px;text-align:center;" type="button" class="border-ra-15px btn-light " onclick="window.open('."'".'FILE_PDF/certificate_salary_th_preview_pdf.php?FULL_NAME='.$getCertificateDetail['Data']['FULL_NAME'].'&POS_NAME='.$getCertificateDetail['Data']['POS_NAME'].'&DEP_NAME='.$getCertificateDetail['Data']['DEP_NAME'].'&DEP_NAME2='.$getCertificateDetail['Data']['DEP_NAME2'].'&PER_TYPE_NAME='.$getCertificateDetail['Data']['PER_TYPE_NAME'].'&INCOME_MONEY='.$getCertificateDetail['Data']['INCOME_MONEY'].'&POS_LEVEL_NAME='.$getCertificateDetail['Data']['POS_LEVEL_NAME'].'&DATE_NOW_TH='.$getCertificateDetail['Data']['DATE_NOW_TH'].'&DATE_NOW_EN='.$getCertificateDetail['Data']['DATE_NOW_EN'].'&AP_STATUS='.$ap_status.' '."'".', '."'".'_blank'."'".',);" ><i class="fa fa-eye"></i> '.$preview.'</a></h5>';
						}else if($book_name == 'หนังสือรับรองที่มีการระบุเฉพาะเงินเดือน' && $language == '(ภาษาอังกฤษ)'){
							$data_request_wfr = array(
														"WFR" => $value['WFR_ID'],
												);
							$getCertificateDetail = callAPI('getCertificateDetail',$data_request_wfr);
							
							$f = '<h5 class="h2-color m-0"><a style="width:80px;text-align:center;" type="button" class="border-ra-15px btn-light " onclick="window.open('."'".'FILE_PDF/certificate_salary_en_preview_pdf.php?FULL_NAME_EN='.$getCertificateDetail['Data']['FULL_NAME_EN'].'&POS_NAME='.$getCertificateDetail['Data']['POS_NAME_EN'].'&DEP_NAME='.$getCertificateDetail['Data']['DEP_NAME_EN'].'&DEP_NAME2='.$getCertificateDetail['Data']['DEP_NAME2_EN'].'&PER_TYPE_NAME='.$getCertificateDetail['Data']['PER_TYPE_NAME_EN'].'&INCOME_MONEY='.$getCertificateDetail['Data']['INCOME_MONEY'].'&POS_LEVEL_NAME='.$getCertificateDetail['Data']['POS_LEVEL_NAME_EN'].'&DATE_NOW_TH='.$getCertificateDetail['Data']['DATE_NOW_TH'].'&DATE_NOW_EN='.$getCertificateDetail['Data']['DATE_NOW_EN'].'&AP_STATUS='.$ap_status.' '."'".', '."'".'_blank'."'".',);" ><i class="fa fa-eye"></i> '.$preview.'</a></h5>';
						}else if($book_name == 'หนังสือรับรองที่มีการระบุเงินเดือนและระยะเวลาทำงาน' && $language == '(ภาษาไทย)'){
							$data_request_wfr = array(
														"WFR" => $value['WFR_ID'],
												);
							$getCertificateDetail = callAPI('getCertificateDetail',$data_request_wfr);
							// echo '<pre>'; print_r($getCertificateDetail['Data']); echo '</pre>'; 
							$f = '<h5 class="h2-color m-0"><a style="width:80px;text-align:center;" type="button" class="border-ra-15px btn-light " onclick="window.open('."'".'FILE_PDF/certificate_salary&work_th_preview_pdf.php?FULL_NAME='.$getCertificateDetail['Data']['FULL_NAME'].'&POS_NAME='.$getCertificateDetail['Data']['POS_NAME'].'&DEP_NAME='.$getCertificateDetail['Data']['DEP_NAME'].'&DEP_NAME2='.$getCertificateDetail['Data']['DEP_NAME2'].'&PER_TYPE_NAME='.$getCertificateDetail['Data']['PER_TYPE_NAME'].'&INCOME_MONEY='.$getCertificateDetail['Data']['INCOME_MONEY'].'&POS_LEVEL_NAME='.$getCertificateDetail['Data']['POS_LEVEL_NAME'].'&DATE_NOW_TH='.$getCertificateDetail['Data']['DATE_NOW_TH'].'&DATE_NOW_EN='.$getCertificateDetail['Data']['DATE_NOW_EN'].'&AP_STATUS='.$ap_status.' '."'".', '."'".'_blank'."'".',);" ><i class="fa fa-eye"></i> '.$preview.'</a></h5>';
						}else if($book_name == 'หนังสือรับรองที่มีการระบุเงินเดือนและระยะเวลาทำงาน' && $language == '(ภาษาอังกฤษ)'){
							$data_request_wfr = array(
														"WFR" => $value['WFR_ID'],
												);
							$getCertificateDetail = callAPI('getCertificateDetail',$data_request_wfr);
							$f = '<h5 class="h2-color m-0"><a style="width:80px;text-align:center;" type="button" class="border-ra-15px btn-light " onclick="window.open('."'".'FILE_PDF/certificate_salary&work_en_preview_pdf.php?FULL_NAME_EN='.$getCertificateDetail['Data']['FULL_NAME_EN'].'&POS_NAME='.$getCertificateDetail['Data']['POS_NAME_EN'].'&DEP_NAME='.$getCertificateDetail['Data']['DEP_NAME_EN'].'&DEP_NAME2='.$getCertificateDetail['Data']['DEP_NAME2_EN'].'&PER_TYPE_NAME='.$getCertificateDetail['Data']['PER_TYPE_NAME_EN'].'&INCOME_MONEY='.$getCertificateDetail['Data']['INCOME_MONEY'].'&POS_LEVEL_NAME='.$getCertificateDetail['Data']['POS_LEVEL_NAME_EN'].'&DATE_NOW_TH='.$getCertificateDetail['Data']['DATE_NOW_TH'].'&DATE_NOW_EN='.$getCertificateDetail['Data']['DATE_NOW_EN'].'&AP_STATUS='.$ap_status.' '."'".', '."'".'_blank'."'".',);" ><i class="fa fa-eye"></i> '.$preview.'</a></h5>';
						}
						$p1 .= $book_name." <br>".$language." จำนวน ".$key['QUANTITY_REQUIRED']." ฉบับ ".$f."<br>";
						// $p1 .= "<h5 class='h2-color m-0'><a style='width:80px;text-align:center;' type='button' class='border-ra-15px btn-light ' onclick='window.open('FILE_PDF/certificate_salary&work_th_preview_pdf.php', '_blank',);' ><i class='fa fa-eye'></i> ดูตัวอย่าง</a></h5>";
						// $p1 .= $val;
					}
					
					
				}else{
					$hid = "hidden";
				}
				
			?>
				<tr <?php echo $hid  ;?>>
                    <td><?php echo $img/* .$value['WF_DET_STEP'] */ ;?></td>
                    <td><?php echo $request_type?></td>
                    <td><?php echo $value['REQ_NO'];?></td>
                    <td><?php echo $topic;//$value['MEETING_TOPIC']?></td>
					<td><?php echo $value['REQ_DATE'];?></td>
                    <!-- วันที่ใช้รถ, ห้อง<td><?php echo ($value['MEETING_DATE'] == $value['MEETING_EDATE'] ? $value['MEETING_DATE']:$value['MEETING_DATE']."<br>- ".$value['MEETING_EDATE']);?></td>-->
                    <td><?php echo $value['ROOM_NAME'];?></td>
                    <td><?php echo $status;?></td>
					<td><a href="#" data-toggle="modal" data-target=".bd-example-modal-lg<?php echo $value['TYPE']."_".$value['WFR_ID'];?>" role="button" aria-pressed="true">ดูรายละเอียด </a></td>
					<td><?php echo $btn_del.$btn_cancel.$btn_estimate ;?></td>
					
                </tr>

 <!--  MODAL DETAIL  -->
<div class="modal fade bd-example-modal-lg<?php echo $value['TYPE']."_".$value['WFR_ID'];?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="container ">
                <h2 class="h2-color pt-4">
                    รายละเอียดการ<?php echo $request_type;?><?php //echo $value['WFR_ID'];?>
                </h2>
                <hr class="hr_news mt-3">
                <div class="container">
                    <h3 class="h2-color pt-4">
						<?php echo $get_CB_OBJECTIVE_TYPE;?> <!-- หัวข้อการจอง	 -->
                    </h3>
                    <div class="row mb-3">
                        <div class="col-lg-6 col-md-12 col-sm-12 col-12 pb-4">
						<?php echo $img2 ;?>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-12 ">
                            <h4 class="h2-color">รายละเอียดการ<?php echo $request_type;?></h4>
                            <p class="mb-2"><?php echo $p1;?></p>
                            <p class="mb-2"><?php echo $p2;?></p>
                            <p class="mb-2"><?php echo $p3;?></p><?php //echo $value['REQ_DEP_NAME'];?>
                            <p class="mb-2"><?php echo $p4;?></p>
                            <p class="mb-2"><?php echo $p5;?></p>
                            <p class="mb-2"><?php echo $p6;?></p>
                            <p class="mb-2"><?php echo $p7;?></p>
                            <p class="mb-2"><?php echo $p8;?></p>
                            <p class="mb-2"><?php echo $p9;?></p>
                            <p class="mb-2"><?php echo $p10;?></p>
							
						<?php if ($value['TYPE'] == 1) {?>
                            <h4 class="h2-color">
									รายการยืมอุปกรณ์
                            </h4>
							<?php foreach($getMeetingToolAdd['Data'] as $key => $value2){ ?>
                            <p class="mb-2"><i class="fa fa-desktop h2-color  pb-0"></i> <?php echo $value2['TOOL_NAME']." จำนวน ".$value2['TOOL_AMOUNT'];?></p>
							<?php }
							$data_request3 = array(
							"wfr_id" => $value['WFR_ID'],
							"wf_main_id" => '6682'
							);
							$getWFSTEP = callAPI('getWFSTEP', $data_request3);
							
						}else  if ($value['TYPE'] == 2) {
						$data_request3 = array(
						"wfr_id" => $value['WFR_ID'],
						"wf_main_id" => '7047'
						);
						$getWFSTEP = callAPI('getWFSTEP', $data_request3);
						}
						?>
                            
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-6 col-md-12 col-sm-12 col-12 ">
                           
                        </div>
						<?php if ($value['TYPE'] != 3) {?>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-12 ">
                            <h4 class="h2-color">สถานะการดำเนินการ</h4>
							<?php 
							foreach($getWFSTEP['Data'][$value['WFR_ID']] as $key => $value){
								echo '<font size="4px" color="'.$value['STATUS_COLOR'].'">'.$value['STATUS_TEXT'].($value['WFD_ID'] == 2484 || $value['WFD_ID'] == 2481 ? "<br>".$value['CANCEL_NOTE']:"").'</font><br><font size="2.5px">'.$value['WF_DATE_SAVE']." ".$value['WF_TIME_SAVE'].'</font><br>';
							}
							?>
                        </div>
						<?php }?>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>				
				
				
				
				
				
				
				
				
			<?php
				}
			}
			?>

            </tbody>
        </table>
    </div>

<?php
if(!$_GET['Page']){
	$_GET['Page'] = 1;
}
$Page = $_GET['Page'];
$Prev_Page = $Page-1;
$Next_Page = $Page+1;
$Num_Pages = 3;
$Per_Page = 10;
$Num_Rows = $getRequestBookingAllList['Data']['Num_Rows'];


if($Num_Rows<=$Per_Page)
	{
		$Num_Pages =1;
	}
	else if(($Num_Rows % $Per_Page)==0)
	{
		$Num_Pages =($Num_Rows/$Per_Page) ;
	}
	else
	{
		$Num_Pages =($Num_Rows/$Per_Page)+1;
		$Num_Pages = (int)$Num_Pages;
	}
?>

<div class="d-flex justify-content-center mb-2">
	<nav aria-label="...">
		<ul class="pagination">
			<?php if($Prev_Page){?>
			<li class="page-item">
				<a class="page-link" href="Booking_status.php?Page=<?php echo 1;?>&Per_Page=<?php echo $Per_Page;?>&Num_Rows=<?php echo $Num_Rows;?>&SYSTEM=<?php echo $_GET["SYSTEM"];?>&STATUS=<?php echo $_GET["STATUS"];?>"><i class="fa fa-angle-double-left icon_fa_left"></i></a>
			</li>
			<li class="page-item">
				<a class="page-link" href="Booking_status.php?Page=<?php echo $Prev_Page;?>&Per_Page=<?php echo $Per_Page;?>&Num_Rows=<?php echo $Num_Rows;?>&SYSTEM=<?php echo $_GET["SYSTEM"];?>&STATUS=<?php echo $_GET["STATUS"];?>"><i class="fa fa-caret-left icon_fa_left"></i></a>
			</li>
			<?php }?>
			<?php 
			for($i=1; $i<=$Num_Pages; $i++){
				if($i != $Page){
					$act = "";
				}else{
					$act = "active";
				}
			?>
			<li class="page-item <?php echo $act;?>">
				<a class="page-link" href="Booking_status.php?Page=<?php echo $i;?>&Per_Page=<?php echo $Per_Page;?>&Num_Rows=<?php echo $Num_Rows;?>&SYSTEM=<?php echo $_GET["SYSTEM"];?>&STATUS=<?php echo $_GET["STATUS"];?>"><?php echo $i;?></a>
			</li>
			<?php }?>
			<?php if($Page!=$Num_Pages){?> 
			<li class="page-item">
				<a class="page-link" href="Booking_status.php?Page=<?php echo $Next_Page;?>&Per_Page=<?php echo $Per_Page;?>&Num_Rows=<?php echo $Num_Rows;?>&SYSTEM=<?php echo $_GET["SYSTEM"];?>&STATUS=<?php echo $_GET["STATUS"];?>"><i class="fa fa-caret-right icon_fa_right"></i></a>
			</li>
			<li class="page-item">
				<a class="page-link" href="Booking_status.php?Page=<?php echo $i-1;?>&Per_Page=<?php echo $Per_Page;?>&Num_Rows=<?php echo $Num_Rows;?>&SYSTEM=<?php echo $_GET["SYSTEM"];?>&STATUS=<?php echo $_GET["STATUS"];?>"><i class="fa fa-angle-double-right icon_fa_right"></i></a>
			</li>
			<?php }?>
		</ul>
	</nav>
</div>



</div>



<?php
// if($getRequestBookingRoomDetail['ResponseCode']['ResCode'] == '000'){
	// foreach($getRequestBookingRoomDetail['Data'] as $key => $value){
// $data_request3 = array(
						// "wfr_id" => $value["WFR_ID"]
					// );
?>


<?php include('footer.php'); ?>

<!-- Footer Website -->
<?php include('combottom.php'); ?>

<!-- Include file js and properties -->

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script language="JavaScript">
/* function hideFont(wfr,type) {
	if(type == "1"){
		$( "#room_font"+wfr ).attr("hidden",true);
	}
	if(type == "2"){
		// $( "#car_font"+wfr ).hide();
		$( "#car_font"+wfr ).attr("hidden",true);
	}
	
}
function showFont(wfr,type) {
	if(type == "1"){
		 $( "#room_font"+wfr ).removeAttr('hidden');
	}
	if(type == "2"){
		// $( "#car_font"+wfr ).show();
		 $( "#car_font"+wfr ).removeAttr('hidden');
	}
	
} */

function del_list(wfr_id,wf_main_id) {//delete_room_booking
	
	// var wfr_id
	// wfr_id = $( "#btn_del" ).val();
	// alert( wfr_id );
	Swal.fire({
			title: 'ยืนยันการลบ ? ',
			text: "",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#00ad0d',
			cancelButtonColor: '#d33',
			confirmButtonText: 'ยืนยัน',
			cancelButtonText: 'ยกเลิก'
	}).then((result) => {
				if (result.isConfirmed) {
					// // //ส่วนของการส่งข้อมูล แบบ ajax โดยใช้ jquery
					$.ajax({
						url: 'save/delete_room_booking.php',
						type: 'POST',
						data: {wfr_id:wfr_id,wf_main_id:wf_main_id,proc:'del'} ,
						success: function(data) {
							console.log(data);

							if (data == 1) {
								Swal.fire(
									'ส่งข้อมูลสำเร็จ',
									' ',
									'success'
									
								).then(function() {
									window.location = "Booking_status.php";
								});
							} else {
								Swal.fire(
									'ส่งข้อมูลไม่สำเร็จ',
									' ',
									'error'
								)
							}

						}
					});
				}
			})
};	

function cancel_list(wfr_id) {//cancel_room_booking
	
	// var wfr_id
	// wfr_id = $( "#btn_cancel" ).val();
	// alert( wfr_id );
	Swal.fire({
			title: 'ยืนยันการขอยกเลิก ? ',
			text: "กรุณากรอกเหตุผลที่ขอยกเลิกการจอง",
			input: 'text',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#00ad0d',
			cancelButtonColor: '#d33',
			confirmButtonText: 'ยืนยัน',
			cancelButtonText: 'ยกเลิก'
	}).then((result) => {
		// if (result.isConfirmed) {
		if (result.value) {
			// // //ส่วนของการส่งข้อมูล แบบ ajax โดยใช้ jquery
			$.ajax({
				url: 'save/cancel_room_booking.php',
				type: 'POST',
				data: {wfr_id:wfr_id,wf_main_id:'6682',proc:'cancel',note:result.value} ,
				success: function(data) {
					console.log(data);

					if (data == 1) {
						Swal.fire(
							'ทำรายการสำเร็จ',
							' ',
							'success'
							
						).then(function() {
							window.location = "Booking_status.php";
						});
					} else {
						Swal.fire(
							'ทำรายการไม่สำเร็จ',
							' ',
							'error'
						)
					}

				}
			});
		}
	})
};

function travel_list(wfr_id) {//

	Swal.fire({
			title: 'ยืนยันการทำรายการ ? ',
			text: "",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#00ad0d',
			cancelButtonColor: '#d33',
			confirmButtonText: 'ยืนยัน',
			cancelButtonText: 'ยกเลิก'
	}).then((result) => {
				if (result.isConfirmed) {
					// // //ส่วนของการส่งข้อมูล แบบ ajax โดยใช้ jquery
					$.ajax({
						url: 'save/travel_finished.php',
						type: 'POST',
						data: {wfr_id:wfr_id,wf_main_id:'7047',proc:'travel'} ,
						success: function(data) {
							console.log(data);

							if (data == 1) {
								Swal.fire(
									'ส่งข้อมูลสำเร็จ',
									' ',
									'success'
									
								).then(function() {
									window.location = "Booking_status.php";
								});
							} else {
								Swal.fire(
									'ส่งข้อมูลไม่สำเร็จ',
									' ',
									'error'
								)
							}

						}
					});
				}
			})
};	

$(document).ready(function() {
	
		
	/* $( "#btn_del" ).click(function() {//delete_room_booking
	
		var wfr_id
		wfr_id = $( "#btn_del" ).val();
		// alert( wfr_id );
		Swal.fire({
                title: 'ยืนยันการลบ ? ',
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#00ad0d',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก'
		}).then((result) => {
					if (result.isConfirmed) {
						// // //ส่วนของการส่งข้อมูล แบบ ajax โดยใช้ jquery
						$.ajax({
							url: 'save/delete_room_booking.php',
							type: 'POST',
							data: {wfr_id:wfr_id,wf_main_id:'6682',proc:'del'} ,
							success: function(data) {
								console.log(data);

								if (data == 1) {
									Swal.fire(
										'ส่งข้อมูลสำเร็จ',
										' ',
										'success'
										
									).then(function() {
										window.location = "Booking_status.php";
									});
								} else {
									Swal.fire(
										'ส่งข้อมูลไม่สำเร็จ',
										' ',
										'error'
									)
								}

							}
						});
					}
				})
	});	 */
	
	/* $( "#btn_cancel" ).click(function() {//cancel_room_booking
	
		var wfr_id
		wfr_id = $( "#btn_cancel" ).val();
		// alert( wfr_id );
		Swal.fire({
                title: 'ยืนยันการขอยกเลิก ? ',
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#00ad0d',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก'
		}).then((result) => {
					if (result.isConfirmed) {
						// // //ส่วนของการส่งข้อมูล แบบ ajax โดยใช้ jquery
						$.ajax({
							url: 'save/cancel_room_booking.php',
							type: 'POST',
							data: {wfr_id:wfr_id,wf_main_id:'6682',proc:'cancel'} ,
							success: function(data) {
								console.log(data);

								if (data == 1) {
									Swal.fire(
										'ทำรายการสำเร็จ',
										' ',
										'success'
										
									).then(function() {
										window.location = "Booking_status.php";
									});
								} else {
									Swal.fire(
										'ทำรายการไม่สำเร็จ',
										' ',
										'error'
									)
								}

							}
						});
					}
				})
	}); */

});

function search_data() {
		var data = $('#form_wf').serialize();
		window.location = "Booking_status.php?"+data;
	}
</script>