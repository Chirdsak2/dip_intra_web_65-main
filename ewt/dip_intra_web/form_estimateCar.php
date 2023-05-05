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
$getRequestBookingCarDetail = callAPI('getRequestBookingCarDetail', $data_request);

// echo '<pre>';
// print_r($getRequestBookingCarDetail);
// echo '</pre>';

$get_rbrd = $getRequestBookingCarDetail['Data'][0];

// echo '<br><br><br><br><pre>';
// print_r($data_request);
// echo '</pre>';


$day = date("d");
$month = date("m");
$year = date("Y")+543;

$date_now = $day."/".$month."/".$year;
// print_pre($_SESSION);
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
<?php
// echo "<pre>";
// print_r($_SESSION);
// echo "</pre>";
?>
<form method="post" enctype="multipart/form-data"  id="form_wf">
	<input type="hidden" id="wfr_id" name="wfr_id" value="<?php echo $_GET['wfr_id'];?>">
	<input type="hidden" id="per_id" name="per_id" value="994">
	<input type="hidden" id="usr_username" name="usr_username" value="<?php echo $_SESSION['EWT_USERNAME'];?>">
	
    <!-- ส่วนของข้อมูลผู้ใช้ -->
    <h2 class="h2-color pt-4">
        <i class="fa-solid fa-circle-check"></i> แบบประเมินความพึงพอใจในการใช้บริการยานพาหนะ
    </h2>
    <hr class="hr_news mt-0">
	
	<div id="wf_space" class="card-block">
	
	<br>
	
	<div class="form-group row">
		<div class="col-md-2 ">วันที่ใช้บริการ</div>
		<div class="col-md-8 wf-left"><p><?php echo $get_rbrd['CB_SDATE'];?></p></div>
	</div>
	<div class="form-group row">
		<div class="col-md-2 ">เวลาตั้งแต่</div>
		<div class="col-md-3 wf-left"><p><?php echo $get_rbrd['CB_STIME'];?></p></div>
		<div class="col-md-2 ">ถึงเวลา</div>
		<div class="col-md-3 wf-left"><p><?php echo $get_rbrd['CB_ETIME'];?></p></div>
	</div>
	<div class="form-group row">
		<div class="col-md-2 ">รถที่ใช้บริการ</div>
		<div class="col-md-10 wf-left"><p><?php echo $get_rbrd['CAR_DETAIL'];?></p></div>
	</div>
	<div class="form-group row">
		<div class="col-md-2 ">ชื่อพนักงานขับรถ</div>
		<div class="col-md-8 wf-left"><p><?php echo $get_rbrd['STAFF_NAME']." ".$get_rbrd['STAFF_LNAME'];?></p></div>
	</div>
	<div class="form-group row">
		<div class="col-md-2 ">สถานที่เดินทางไป</div>
		<div class="col-md-8 wf-left"><p><?php echo $get_rbrd['CB_AREA'];?></p></div>
	</div>
	<div class="form-group row">
		<div class="col-md-2 ">ผู้จองยานพาหนะ</div>
		<div class="col-md-5 wf-left"><p><?php echo $get_rbrd['CB_PER_ID'];?></p></div>
	</div>
	
	
	
	<h2 class="h2-color pt-4">
			หัวข้อประเมิน
    </h2>
	<br>
	
	<div class="form-group row">
		<div class="col-md-12 wf-left ">1. ความพึงพอใจต่อพนักงานขับรถ (ความสุภาพ, รู้สึกปลอดภัย, กระตือรือร้น, เตรียมพร้อม)</div>
	</div>
	<div class="form-group row">
		<div id="CAF_NUM1_BSF_AREA" class="col-md-3 ">ระดับความพึงพอใจ<span class="text-danger">*</span></div>
		<div id="CAF_NUM1_BSF_AREA" class="col-md-9 wf-left">
		<div class="form-radio">
			<div class="radio radio-inline"><input type="radio" name="CAF_NUM1" id="CAF_NUM1" value="5" required="" aria-required="true">ดีมาก</div>
			<div class="radio radio-inline"><input type="radio" name="CAF_NUM1" id="CAF_NUM1" value="4" required="" aria-required="true">ดี</div>
			<div class="radio radio-inline"><input type="radio" name="CAF_NUM1" id="CAF_NUM1" value="3" required="" aria-required="true">ปานกลาง</div>
			<div class="radio radio-inline"><input type="radio" name="CAF_NUM1" id="CAF_NUM1" value="2" required="" aria-required="true">พอใช้</div>
			<div class="radio radio-inline"><input type="radio" name="CAF_NUM1" id="CAF_NUM1" value="1" required="" aria-required="true">ปรับปรุง</div>
		</div>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-md-12 wf-left ">2. ความพึงพอใจต่อยานพาหนะ (ความพร้อมใช้งานของรถ, ความสะอาดเรียบร้อยของรถ)</div>
	</div>
	<div class="form-group row">
		<div id="CAF_NUM1_BSF_AREA" class="col-md-3 ">ระดับความพึงพอใจ<span class="text-danger">*</span></div>
		<div id="CAF_NUM1_BSF_AREA" class="col-md-9 wf-left">
		<div class="form-radio">
			<div class="radio radio-inline"><input type="radio" name="CAF_NUM2" id="CAF_NUM2" value="5" required="" aria-required="true">ดีมาก</div>
			<div class="radio radio-inline"><input type="radio" name="CAF_NUM2" id="CAF_NUM2" value="4" required="" aria-required="true">ดี</div>
			<div class="radio radio-inline"><input type="radio" name="CAF_NUM2" id="CAF_NUM2" value="3" required="" aria-required="true">ปานกลาง</div>
			<div class="radio radio-inline"><input type="radio" name="CAF_NUM2" id="CAF_NUM2" value="2" required="" aria-required="true">พอใช้</div>
			<div class="radio radio-inline"><input type="radio" name="CAF_NUM2" id="CAF_NUM2" value="1" required="" aria-required="true">ปรับปรุง</div>
		</div>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-md-12 wf-left ">3. ความพึงพอใจด้านความปลอดภัย (ถึงที่หมายตรงเวลาด้วยความปลอดภัย)</div>
	</div>
	<div class="form-group row">
		<div id="CAF_NUM1_BSF_AREA" class="col-md-3 ">ระดับความพึงพอใจ<span class="text-danger">*</span></div>
		<div id="CAF_NUM1_BSF_AREA" class="col-md-9 wf-left">
		<div class="form-radio">
			<div class="radio radio-inline"><input type="radio" name="CAF_NUM3" id="CAF_NUM3" value="5" required="" aria-required="true">ดีมาก</div>
			<div class="radio radio-inline"><input type="radio" name="CAF_NUM3" id="CAF_NUM3" value="4" required="" aria-required="true">ดี</div>
			<div class="radio radio-inline"><input type="radio" name="CAF_NUM3" id="CAF_NUM3" value="3" required="" aria-required="true">ปานกลาง</div>
			<div class="radio radio-inline"><input type="radio" name="CAF_NUM3" id="CAF_NUM3" value="2" required="" aria-required="true">พอใช้</div>
			<div class="radio radio-inline"><input type="radio" name="CAF_NUM3" id="CAF_NUM3" value="1" required="" aria-required="true">ปรับปรุง</div>
		</div>
		</div>
	</div>
	
	<div class="form-group row">
		<div id="ANS_MORE_BSF_AREA" class="col-md-2 ">ข้อเสนอเพิ่มเติม</div>
		<div id="ANS_MORE_BSF_AREA" class="col-md-8 wf-left"><textarea name="CAF_COUNSEL" id="CAF_COUNSEL" class="form-control  max-textarea" maxlength="500" style="overflow: hidden; overflow-wrap: break-word; resize: none; height: 80px;"></textarea></div>
	</div>
	<div class="form-group row">
		<div id="MAF_DATE_BSF_AREA" class="col-md-2 ">วันที่ทำแบบประเมิน<span class="text-danger">*</span></div>
		<div id="MAF_DATE_BSF_AREA" class="col-md-3 wf-left"><input name="MAF_DATE" id="MAF_DATE" value="<?php echo $date_now;?>" required="" aria-required="true" readonly="true" class="form-control datepicker" placeholder=""><span class="input-group-addon bg-primary"><span class="icofont icofont-ui-calendar"></span></span></div>
		<div id="MAF_PER_ID_BSF_AREA" style="display:none" class="col-md-2 "><label for="MAF_PER_ID" class="form-control-label wf-right">รหัสผู้ทำแบบประเมิน</label></div>
		<div id="MAF_PER_ID_BSF_AREA" style="display:none" class="col-md-3 wf-left"><input type="text" name="MAF_PER_ID" id="MAF_PER_ID" class="form-control" value="<?php echo $_SESSION['EWT_USERNAME'];?>"><small id="DUP_MAF_PER_ID_ALERT" class="form-text text-danger" style="display:none"></small></div>
	</div>
	<div class="form-group row">
		<div id="MAF_PER_NAME_BSF_AREA" class="col-md-2 ">ผู้ทำแบบประเมิน</div>
		<div id="MAF_PER_NAME_BSF_AREA" class="col-md-3 wf-left"><p><?php echo $_SESSION['EWT_NAME']." ".$_SESSION['EWT_SURNAME'];?></p><small id="DUP_MAF_PER_NAME_ALERT" class="form-text text-danger" style="display:none"></small></div>
	</div>
	
	</div>
	<br>
	<div class="row d-flex justify-content-center mt-4 mb-3">
		
		<div class=" col-lg-4 col-md-4 col-sm-12 col-12">
			<button id="submit" type="submit" data-toggle="modal" class="mt-2 mb-6 px-3 btn d-flex 
			justify-content-center  border-ra-15px btn-success btn-sm" style="width:100%;font-size:20px;">ส่งแบบประเมิน</button>
		</div>
	</div>

</form>


</div>


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
							url: 'save/insert_estimate_car.php',
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