<?php include('comtop.php'); ?>
<!-- Include file css and properties -->
<?php include('header.php'); ?>
<!-- Menu and Logo -->
<?php include('callservice.php'); ?>
<!-- CALL SERVICE -->


<?php

$data_request = array(
						"wfr_id" => $_GET["wfr_id"]
					);
$getRequestBookingRoomDetail = callAPI('getRequestBookingRoomDetail', $data_request);

// echo '<pre>';
// print_r($getRequestBookingRoomDetail);
// echo '</pre>';

$get_rbrd = $getRequestBookingRoomDetail['Data'][0];

// echo '<br><br><br><br><pre>';
// print_r($data_request);
// echo '</pre>';


$day = date("d");
$month = date("m");
$year = date("Y")+543;

$date_now = $day."/".$month."/".$year;
?>



<style>
    .icon_fa_left:hover{
     color:#82288c;
}
.icon_fa_right{
     color:#82288c;
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


form{
	font-size:20px;
}
p{
	font-size:20px;
	color:#b610c9;
}
</style>

<div class="container mar-spacehead mb-5">

<form method="post" enctype="multipart/form-data"  id="form_wf">
	<input type="hidden" id="wfr_id" name="wfr_id" value="<?php echo $_GET['wfr_id'];?>">
	<input type="hidden" id="per_id" name="per_id" value="994">
    <!-- ส่วนของข้อมูลผู้ใช้ -->
    <h2 class="h2-color pt-4">
        <i class="fa-solid fa-circle-check"></i> แบบประเมินความพึงพอใจในการใช้ห้องประชุม
    </h2>
    <hr class="hr_news mt-0">
	
	<div id="wf_space" class="card-block">
	
	<div class="form-group row">
		<input type="hidden" name="F_TEMP_ID" id="F_TEMP_ID" value="8">
	</div>
	
	<br>
	
	<div class="form-group row">
		<div class="col-md-2 ">วันที่จองห้องประชุม</div>
		<div class="col-md-8 wf-left"><p><?php echo $get_rbrd['MEETING_DATE'];?></p></div>
	</div>
	<div class="form-group row">
		<div class="col-md-2 ">เวลาตั้งแต่</div>
		<div class="col-md-3 wf-left"><p><?php echo $get_rbrd['STIME'];?></p></div>
		<div class="col-md-2 ">ถึงเวลา</div>
		<div class="col-md-3 wf-left"><p><?php echo $get_rbrd['ETIME'];?></p></div>
	</div>
	<div class="form-group row">
		<div class="col-md-2 ">ห้องประชุม</div>
		<div class="col-md-10 wf-left"><p><?php echo $get_rbrd['ROOM_NAME'];?></p></div>
	</div>
	<div class="form-group row">
		<div class="col-md-2 ">หัวข้อเรื่องประชุม</div>
		<div class="col-md-8 wf-left"><p><?php echo $get_rbrd['MEETING_TOPIC'];?></p></div>
	</div>
	<div class="form-group row">
		<div class="col-md-2 ">ผู้จองห้องประชุม</div>
		<div class="col-md-5 wf-left"><p><?php echo $get_rbrd['REQ_USR_NAME'];?></p></div>
		<!--<div class="col-md-2 ">ตำแหน่งผู้จอง</div>
		<div class="col-md-3 wf-left">เลขานุการ</div>-->
	</div>
	<!--<div class="form-group row">
		<div class="col-md-2 ">หน่วยงานผู้จอง</div>
		<div class="col-md-3 wf-left">ศูนย์เทคโนโลยีสารสนเทศและการสื่อสาร</div>
		<div id="REQ_USR_ID_BSF_AREA" style="display:none" class="col-md-2 ">ผู้จองห้อง</div>
		<div id="REQ_USR_ID_BSF_AREA" style="display:none" class="col-md-1 wf-left"><input type="text" name="REQ_USR_ID" id="REQ_USR_ID" class="form-control" value="994"><small id="DUP_REQ_USR_ID_ALERT" class="form-text text-danger" style="display:none"></small></div>
		<div id="REQ_NAME_BSF_AREA" style="display:none" class="col-md-2 ">ผู้จองห้องประชุม</div>
		<div id="REQ_NAME_BSF_AREA" style="display:none" class="col-md-1 wf-left"><input type="text" name="REQ_NAME" id="REQ_NAME" class="form-control" value="เชิดศักดิ์(ทดสอบ) คำม่วง"><small id="DUP_REQ_NAME_ALERT" class="form-text text-danger" style="display:none"></small></div>
	</div>-->
	
	<h2 class="h2-color pt-4">
			หัวข้อประเมิน
    </h2>
	<br>
	
	<div class="form-group row">
		<div class="col-md-12 wf-left ">1. ความพึงพอใจต่อเจ้าหน้าที่หรือบุคคลผู้ให้บริการ (ความสุภาพ, การแต่งกาย, การเตรียมพร้อม)</div>
	</div>
	<div class="form-group row">
		<div id="ANS_01_BSF_AREA" class="col-md-3 ">ระดับความพึงพอใจ<span class="text-danger">*</span></div>
		<div id="ANS_01_BSF_AREA" class="col-md-9 wf-left">
		<div class="form-radio">
			<div class="radio radio-inline"><input type="radio" name="ANS_01" id="ANS_01" value="5" required="" aria-required="true">ดีมาก</div>
			<div class="radio radio-inline"><input type="radio" name="ANS_01" id="ANS_01" value="4" required="" aria-required="true">ดี</div>
			<div class="radio radio-inline"><input type="radio" name="ANS_01" id="ANS_01" value="3" required="" aria-required="true">ปานกลาง</div>
			<div class="radio radio-inline"><input type="radio" name="ANS_01" id="ANS_01" value="2" required="" aria-required="true">พอใช้</div>
			<div class="radio radio-inline"><input type="radio" name="ANS_01" id="ANS_01" value="1" required="" aria-required="true">ปรับปรุง</div>
		</div>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-md-12 wf-left ">2. ความพึงพอใจต่อสถานที่ (ความสะอาดเรียบร้อย, ความเหมาะสมของห้อง)</div>
	</div>
	<div class="form-group row">
		<div id="ANS_02_BSF_AREA" class="col-md-3 ">ระดับความพึงพอใจ<span class="text-danger">*</span></div>
		<div id="ANS_02_BSF_AREA" class="col-md-9 wf-left">
		<div class="form-radio">
			<div class="radio radio-inline"><input type="radio" name="ANS_02" id="ANS_02" value="5" required="" aria-required="true">ดีมาก</div>
			<div class="radio radio-inline"><input type="radio" name="ANS_02" id="ANS_02" value="4" required="" aria-required="true">ดี</div>
			<div class="radio radio-inline"><input type="radio" name="ANS_02" id="ANS_02" value="3" required="" aria-required="true">ปานกลาง</div>
			<div class="radio radio-inline"><input type="radio" name="ANS_02" id="ANS_02" value="2" required="" aria-required="true">พอใช้</div>
			<div class="radio radio-inline"><input type="radio" name="ANS_02" id="ANS_02" value="1" required="" aria-required="true">ปรับปรุง</div>
		</div>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-md-12 wf-left ">3. ความพึงพอใจต่อสิ่งอำนวยความสะดวก (สิ่งอำนวยความสะดวกครบถ้วนสมบูรณ์ )</div>
	</div>
	<div class="form-group row">
		<div id="ANS_03_BSF_AREA" class="col-md-3 ">ระดับความพึงพอใจ<span class="text-danger">*</span></div>
		<div id="ANS_03_BSF_AREA" class="col-md-9 wf-left">
		<div class="form-radio">
			<div class="radio radio-inline"><input type="radio" name="ANS_03" id="ANS_03" value="5" required="" aria-required="true">ดีมาก</div>
			<div class="radio radio-inline"><input type="radio" name="ANS_03" id="ANS_03" value="4" required="" aria-required="true">ดี</div>
			<div class="radio radio-inline"><input type="radio" name="ANS_03" id="ANS_03" value="3" required="" aria-required="true">ปานกลาง</div>
			<div class="radio radio-inline"><input type="radio" name="ANS_03" id="ANS_03" value="2" required="" aria-required="true">พอใช้</div>
			<div class="radio radio-inline"><input type="radio" name="ANS_03" id="ANS_03" value="1" required="" aria-required="true">ปรับปรุง</div>
		</div>
		</div>
	</div>
	<!--<div class="form-group row">
		<div id="ANS_01_BSF_AREA" class="col-md-2 ">ระดับความพึงพอใจ<span class="text-danger">*</span></div>
		<div id="ANS_01_BSF_AREA" class="col-md-8 wf-left">
		<div class="form-radio">
			<div class="radio radio-inline"><input type="radio" name="ANS_01" id="ANS_01" value="5" required="" aria-required="true"><i class="helper"></i> ดีมาก</div>
			<div class="radio radio-inline"><input type="radio" name="ANS_01" id="ANS_01" value="4" required="" aria-required="true"><i class="helper"></i> ดี</div>
			<div class="radio radio-inline"><input type="radio" name="ANS_01" id="ANS_01" value="3" required="" aria-required="true"><i class="helper"></i> ปานกลาง</div>
			<div class="radio radio-inline"><input type="radio" name="ANS_01" id="ANS_01" value="2" required="" aria-required="true"><i class="helper"></i> พอใช้</div>
			<div class="radio radio-inline"><input type="radio" name="ANS_01" id="ANS_01" value="1" required="" aria-required="true"><i class="helper"></i> ปรับปรุง</div>
		</div>
		</div>
	</div>-->
	
	<div class="form-group row">
		<div id="ANS_MORE_BSF_AREA" class="col-md-2 ">ข้อเสนอเพิ่มเติม</div>
		<div id="ANS_MORE_BSF_AREA" class="col-md-8 wf-left"><textarea name="ANS_MORE" id="ANS_MORE" class="form-control  max-textarea" maxlength="500" style="overflow: hidden; overflow-wrap: break-word; resize: none; height: 80px;"></textarea></div>
	</div>
	<div class="form-group row">
		<div id="MAF_DATE_BSF_AREA" class="col-md-2 ">วันที่ทำแบบประเมิน<span class="text-danger">*</span></div>
		<div id="MAF_DATE_BSF_AREA" class="col-md-3 wf-left"><input name="MAF_DATE" id="MAF_DATE" value="<?php echo $date_now;?>" required="" aria-required="true" readonly="true" class="form-control datepicker" placeholder=""><span class="input-group-addon bg-primary"><span class="icofont icofont-ui-calendar"></span></span></div>
		<div id="MAF_PER_ID_BSF_AREA" style="display:none" class="col-md-2 "><label for="MAF_PER_ID" class="form-control-label wf-right">รหัสผู้ทำแบบประเมิน</label></div>
		<div id="MAF_PER_ID_BSF_AREA" style="display:none" class="col-md-3 wf-left"><input type="text" name="MAF_PER_ID" id="MAF_PER_ID" class="form-control" value="994"><small id="DUP_MAF_PER_ID_ALERT" class="form-text text-danger" style="display:none"></small></div>
	</div>
	<div class="form-group row">
		<div id="MAF_PER_NAME_BSF_AREA" class="col-md-2 ">ผู้ทำแบบประเมิน</div>
		<div id="MAF_PER_NAME_BSF_AREA" class="col-md-3 wf-left"><p><?php echo $_SESSION['EWT_NAME']." ".$_SESSION['EWT_SURNAME'];?></p><small id="DUP_MAF_PER_NAME_ALERT" class="form-text text-danger" style="display:none"></small></div>
		<!--<div id="MAF_POS_NAME_BSF_AREA" class="col-md-2 ">ตำแหน่งผู้ทำแบบประเมิน</div>
		<div id="MAF_POS_NAME_BSF_AREA" class="col-md-3 wf-left"><input type="text" name="MAF_POS_NAME" id="MAF_POS_NAME" class="form-control" value="เลขานุการ" readonly="true"><small id="DUP_MAF_POS_NAME_ALERT" class="form-text text-danger" style="display:none"></small></div>-->
	</div>
	<!--<div class="form-group row">
		<div id="MAF_DEP_NAME_BSF_AREA" class="col-md-2 ">สำนัก/ฝ่ายผู้ทำแบบประเมิน</div>
		<div id="MAF_DEP_NAME_BSF_AREA" class="col-md-3 wf-left"><input type="text" name="MAF_DEP_NAME" id="MAF_DEP_NAME" class="form-control" value="ศูนย์เทคโนโลยีสารสนเทศและการสื่อสาร" readonly="true"><small id="DUP_MAF_DEP_NAME_ALERT" class="form-text text-danger" style="display:none"></small></div>
		<div id="MAF_DEP_ID_BSF_AREA" style="display:none" class="col-md-2 "><label for="MAF_DEP_ID" class="form-control-label wf-right">รหัสสำนัก/ฝ่ายผู้ทำแบบประเมิน</label></div>
		<div id="MAF_DEP_ID_BSF_AREA" style="display:none" class="col-md-3 wf-left"><input type="text" name="MAF_DEP_ID" id="MAF_DEP_ID" class="form-control" value="734"><small id="DUP_MAF_DEP_ID_ALERT" class="form-text text-danger" style="display:none"></small></div> 
	</div>-->
	
	</div>
	<br>
	<div class="row d-flex justify-content-center mt-4 mb-3">
		
		<div class=" col-lg-4 col-md-4 col-sm-12 col-12">
			<button id="submit" type="submit" data-toggle="modal" class="mt-2 mb-6 px-3 btn d-flex 
			justify-content-center  border-ra-15px btn-success btn-sm" style="width:100%;font-size:20px;">ส่งแบบประเมิน</button>
			<!--<a href="#" data-toggle="modal" data-target=".bd-example-modal-lg " class="mt-2 mb-3 px-3 btn d-flex 
	justify-content-center  border-ra-15px btn-success btn-sm">ส่งคำขอจองห้องประชุม</a>-->
		</div>
	</div>

</form>






    






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
$(document).ready(function() {
	$('#form_wf').submit(function(e) {
				Swal.fire({
                title: 'ยืนยันการส่งแบบประเมิน ? ',
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
							url: 'save/insert_estimate_room.php',
							type: 'POST',
							data: $('#form_wf').serialize() ,
							success: function(data) {
								console.log(data);

								if (data == 1) {
									Swal.fire(
										'ส่งแบบประเมินสำเร็จ',
										' ',
										'success'
										
									).then(function() {
										window.location = "Booking_status.php";
										// window.close();
									});
								} else {
									Swal.fire(
										'ส่งแบบประเมินไม่สำเร็จ',
										' ',
										'error'
									)
								}

							}
						});
					}
				})
			e.preventDefault();
		})

});
</script>