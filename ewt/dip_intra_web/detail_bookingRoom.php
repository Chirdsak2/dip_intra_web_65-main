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
if(!$_GET["Page"]){
	$_GET["Page"] = 1;
}
$data_request = array(
						// "per_id" => '6848',
						"username" => $_SESSION['EWT_USERNAME'],
						"trip_start" => $_GET["trip-start"],
						"trip_end" => $_GET["trip-end"],
						"system" => 1,
						"status" => $_GET["STATUS"],
						"Per_Page" => 10,
						"Page" => $_GET["Page"],
						"Num_Rows" => $_GET["Num_Rows"],
						"GetAll" => 'detail_Booking',
						"meeting_id" => $_GET["meeting_id"]
					);
$getRequestBookingAllList = callAPI('getRequestBookingAllList', $data_request);

$data_request2 = array(
	"type_from_calender" => 'only_id_name',
);
$getRoomList = callAPI('getRoomList',$data_request2);
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
</style>


<!-- แถบสีน้ำเงินหัวข้อข่าวสาร -->
<div class="container-fluid mar-spacehead  shadow-sm" style="background-color:rgba(241, 237, 234, 0.8) ;">
    <!--<form id="contact-form" action="#" method="post" role="form">-->
        <div class="row  w-100 d-flex justify-content-center">
            <img src="images/2meet.png" class="img rounded icon-tabhead" alt="BG-BookingCar"><span>
                <h1 class="col-12 txt-gradient-purple font-h-search  pt-4 pb-4 ">
                    จองห้องประชุม
                </h1>
            </span>
        </div>
    <!--</form>-->
	
</div>


<div class="container pb-3 ">
	
 <h2 class="h2-color pt-4">
            ประวัติการจองห้องประชุม
        </h2>
        <h5 class="h2-color"><a href="info_bookingRoom.php">รายละเอียดห้องประชุม > </a> <span> ประวัติการจองห้องประชุม</span></h5>
        <hr class="hr_news mt-3">
<form id="form_wf" action="detail_bookingRoom.php" method="get" role="form">

    <div class="row mb-3" >
        <div class="col-lg-4 col-md-6 col-sm-12 col-12 mb-2 ">
            <div class=" Datepick-start-stop">
                <div class="row" style="  border: 1px solid #981c9d;  border-radius: 5px;">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-6 ">
                        <h5 class="ml-2 mb-0"><i class="fa fa-calendar"></i> วันเริ่มต้น</h5>
                        <input class="mt-0 ml-2 pb-1 border-0" type="date" id="trip-start" name="trip-start" value="<?php echo $_GET["trip-start"];?>" >
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-6 ">
                        <h5 class="ml-2 mb-0"><i class="fa fa-calendar"></i> วันที่สิ้นสุด</h5>
                        <input class="mt-0 ml-2 pb-1 border-0" type="date" id="trip-end" name="trip-end" value="<?php echo $_GET["trip-end"];?>" >
                    </div>
                </div>

            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
			<div id="STATUS_BSF_AREA" class=" ">
			<select style="height:55px;" name="meeting_id" id="meeting_id" class="form-control  " required="" aria-required="true" placeholder="เลือก" tabindex="-1" aria-hidden="true">
			<option value="">แสดงการจองห้องประชุมทั้งหมด</option>
					<?php
					foreach($getRoomList["Data"] as $key => $val){
					?>
						<option <?php echo ($_GET["meeting_id"] == $key ? "selected":"" );?> value="<?php echo $key;?>"><?php echo $val['ROOM_NAME'];?></option>
					<?php	
					}
					?>
			</select>
			</div>

        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
			<div id="STATUS_BSF_AREA" class=" ">
			<select style="height:55px;" name="STATUS" id="STATUS" class="form-control  " required="" aria-required="true" placeholder="เลือก" tabindex="-1" aria-hidden="true">
			<option value="99"  >แสดงสถานะทั้งหมด</option>
			<option value="1" <?php  echo ($_GET["STATUS"]==1 ? "selected":"");?>>ดำเนินการเสร็จสิ้น</option>
			<option value="2" <?php  echo ($_GET["STATUS"]==2 ? "selected":"");?>>อยู่ระหว่างดำเนินการ</option>
			<option value="3" <?php  echo ($_GET["STATUS"]==3 ? "selected":"");?>>ไม่ผ่านการอนุมัติ	/ ยกเลิกเสร็จสิ้น</option>
			</select>
			</div>

        </div>
        <div class="col-lg-2 col-md-6 col-sm-12 col-12 p">
            <!--<button type="submit" class="btn-search btn Gradient-Color shadow-sm btn-sm mt-2"><i class="fa fa-search"></i> ค้นหาประวัติ</button>-->
			 <a onclick="search_data()" class="btn-search btn Gradient-Color shadow-sm btn-sm mt-2" role="button" aria-pressed="true">ค้นหาประวัติ</a>
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
                    <th scope="col">เลขที่คำขอ</th>
                    <th scope="col">หัวข้อคำขอ</th>
                    <th scope="col">ลงวันที่</th>
                    <th scope="col">สถานที่</th>
                    <th scope="col">สถานะ</th>
                    <th scope="col">รายละเอียด</th>
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
					
					$p10 .= '<a style="width:80px;text-align:center;" type="button" class=" " onclick="window.open('."'".'FILE_PDF/booking_room_report_pdf.php?CB_PER_ID='.$value['REQ_NAME'].'&CB_AREA='.$value['ROOM_NAME'].'&CB_MEMBER='.$value['MEETING_NUM_PP'].'&CB_OBJ='.$value['MEETING_TOPIC'].'&MEETING_DATE='.$value['MEETING_DATE2'].'&MEETING_EDATE='.$value['MEETING_EDATE2'].'&STIME='.$value['STIME'].'&ETIME='.$value['ETIME'].'&REQ_TEL='.$value['REQ_TEL'].'&CAR_REGISTER='.$get_CAR_REGISTER.'&DEP_NAME1='.$chk['DEP_NAME1'].'&POS_NAME='.$chk['POS_NAME'].'&APP_1='.$app_room_1.'&APP_1_NAME='.$app1_dep_room_name.'&APP_2_NAME='.$short_dep[$value["DEP_KEEPER_SSO"]].'&APP_2='.$app_room_2.'&MEETINH_CHAIRMAN='.$value['MEETINH_CHAIRMAN'].'&WFR_ID='.$value["WFR_ID"].' '."'".', '."'".'_blank'."'".',);" > download</a>';
					
					$img2 = '<img src="images/'.$get_ROOM_PIC_NAME.'" class="d-block w-100" alt="...">';
					
					
					$data_request1_2 = array(
						"wfr_id" => $value["WFR_ID"]
					);
					$getMeetingToolAdd = callAPI('getMeetingToolAdd', $data_request1_2);
					
					if($value['APPROVE_STATUS1'] == 1 && $value['APPROVE_STATUS2'] == 1 && $value['APPROVE_STATUS3'] == 1){
						$status = "<font color='green'>อนุมัติห้องประชุมเรียบร้อยแล้ว</font>";
					}else if ($value['APPROVE_STATUS1'] == 1 && $value['APPROVE_STATUS2'] == 1 && $value['APPROVE_STATUS3'] == 0){
						$status = "<font color='orange'>รอการอนุมัติ/อนุญาต</font>";
					}else if ($value['APPROVE_STATUS1'] == 1 && $value['APPROVE_STATUS2'] == 0 && $value['APPROVE_STATUS3'] == 0){
						$status = "<font color='orange'>อยู่ระหว่างพิจารณาเงื่อนไข</font>";
					}else if ($value['APPROVE_STATUS1'] == 0 && $value['APPROVE_STATUS2'] == 0 && $value['APPROVE_STATUS3'] == 0){
						$status = "<font color='orange'>รอการผ่านความเห็นชอบ</font>";
					} 
					if ($value['WF_DET_STEP'] == 2475){
						$status = "<font color='red'>ไม่ผ่านการอนุมัติ</font>";
					}else if ($value['WF_DET_STEP'] == 2481){
						$status = "<font color='red'>ยกเลิกเสร็จสิ้น<br></font>
								   <font hidden id='room_font".$value['WFR_ID']."' color='red'>".$value['CANCEL_NOTE']."</font>
						";
					}
				}else{
					$hid = "hidden";
				}
				
			?>
				<tr <?php echo $hid  ;?>>
                    <td><?php echo $value['REQ_NO'];?></td>
                    <td><?php echo $topic;//$value['MEETING_TOPIC']?></td>
					<td><?php echo $value['REQ_DATE'];?></td>
                    <!-- วันที่ใช้รถ, ห้อง<td><?php echo ($value['MEETING_DATE'] == $value['MEETING_EDATE'] ? $value['MEETING_DATE']:$value['MEETING_DATE']."<br>- ".$value['MEETING_EDATE']);?></td>-->
                    <td><?php echo $value['ROOM_NAME'];?></td>
                    <td><?php echo $status;?></td>
					<td><a href="#" data-toggle="modal" data-target=".bd-example-modal-lg<?php echo $value['TYPE']."_".$value['WFR_ID'];?>" role="button" aria-pressed="true">ดูรายละเอียด </a></td>
					
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
							
						}
						?>
                            
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-6 col-md-12 col-sm-12 col-12 ">
                           
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-12 ">
                            <h4 class="h2-color">สถานะการดำเนินการ</h4>
							<?php 
							foreach($getWFSTEP['Data'][$value['WFR_ID']] as $key => $value){
								echo '<font size="4px" color="'.$value['STATUS_COLOR'].'">'.$value['STATUS_TEXT'].($value['WFD_ID'] == 2484 || $value['WFD_ID'] == 2481 ? "<br>".$value['CANCEL_NOTE']:"").'</font><br><font size="2.5px">'.$value['WF_DATE_SAVE']." ".$value['WF_TIME_SAVE'].'</font><br>';
							}
							?>
                        </div>
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
				<a class="page-link" href="detail_bookingRoom.php?Page=<?php echo 1;?>&Per_Page=<?php echo $Per_Page;?>&Num_Rows=<?php echo $Num_Rows;?>&SYSTEM=<?php echo $_GET["SYSTEM"];?>&STATUS=<?php echo $_GET["STATUS"];?>"><i class="fa fa-angle-double-left icon_fa_left"></i></a>
			</li>
			<li class="page-item">
				<a class="page-link" href="detail_bookingRoom.php?Page=<?php echo $Prev_Page;?>&Per_Page=<?php echo $Per_Page;?>&Num_Rows=<?php echo $Num_Rows;?>&SYSTEM=<?php echo $_GET["SYSTEM"];?>&STATUS=<?php echo $_GET["STATUS"];?>"><i class="fa fa-caret-left icon_fa_left"></i></a>
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
				<a class="page-link" href="detail_bookingRoom.php?Page=<?php echo $i;?>&Per_Page=<?php echo $Per_Page;?>&Num_Rows=<?php echo $Num_Rows;?>&SYSTEM=<?php echo $_GET["SYSTEM"];?>&STATUS=<?php echo $_GET["STATUS"];?>"><?php echo $i;?></a>
			</li>
			<?php }?>
			<?php if($Page!=$Num_Pages){?> 
			<li class="page-item">
				<a class="page-link" href="detail_bookingRoom.php?Page=<?php echo $Next_Page;?>&Per_Page=<?php echo $Per_Page;?>&Num_Rows=<?php echo $Num_Rows;?>&SYSTEM=<?php echo $_GET["SYSTEM"];?>&STATUS=<?php echo $_GET["STATUS"];?>"><i class="fa fa-caret-right icon_fa_right"></i></a>
			</li>
			<li class="page-item">
				<a class="page-link" href="detail_bookingRoom.php?Page=<?php echo $i-1;?>&Per_Page=<?php echo $Per_Page;?>&Num_Rows=<?php echo $Num_Rows;?>&SYSTEM=<?php echo $_GET["SYSTEM"];?>&STATUS=<?php echo $_GET["STATUS"];?>"><i class="fa fa-angle-double-right icon_fa_right"></i></a>
			</li>
			<?php }?>
		</ul>
	</nav>
</div>



</div>



<?php include('footer.php'); ?>

<!-- Footer Website -->
<?php include('combottom.php'); ?>

<!-- Include file js and properties -->

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script language="JavaScript">


function search_data() {
		var data = $('#form_wf').serialize();
		window.location = "detail_bookingRoom.php?"+data;
	}
</script>