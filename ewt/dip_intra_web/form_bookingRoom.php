<?php include('comtop.php'); ?>
<!-- Include file css and properties -->
<?php include('header.php'); ?>
<!-- Menu and Logo -->
<?php include('callservice.php'); ?>
<!-- CALL SERVICE -->

<style>
	::placeholder {
    font-weight: bold;
}


@media (min-width: 320px) { 
       .text_tag{
		font-size: 13px;
    		line-height: inherit;
	  }
	}

	@media (min-width: 1440px) { 
       .text_tag{
		font-size: 25px;
    		line-height: inherit;
	  }
	}
 



.form-control{
    border: 1px solid #981c9d !important;
    border-radius: 5px !important;
}
</style>

<?php

dbdpis::ConnectDB(SSO_DB_NAME, SSO_DB_TYPE, SSO_ROOT_HOST, SSO_ROOT_USER, SSO_ROOT_PASSWORD, SSO_DB_NAME, SSO_CHAR_SET);
// GET DEP_LV1_ID, DEP_LV2_ID
$chk_per_type = "SELECT B.*, B.DEP_LV1_ID, C.DEP_NAME AS DEP_NAME1, B.DEP_LV2_ID, D.DEP_NAME AS DEP_NAME2
				FROM USR_MAIN A
				LEFT JOIN M_PER_PROFILE B ON B.PER_IDCARD = A.USR_OPTION3
				LEFT JOIN USR_DEPARTMENT C ON C.DEP_ID = B.DEP_LV1_ID
				LEFT JOIN USR_DEPARTMENT D ON D.DEP_ID = B.DEP_LV2_ID
				WHERE A.USR_USERNAME = '".$_SESSION['EWT_USERNAME']."' ";
$q = dbdpis::execute($chk_per_type);
$chk = dbdpis::Fetch($q);

$data_request_meeting_id = array(
	"meeting_id" => $_GET["meeting_id"]
);
$getMeetingToolAddList = callAPI('getMeetingToolAddList',$data_request_meeting_id);//อุปกรณ์เพิ่มเติม

$data_request_type = array(
	"type" => 'room',
	"username" => $_SESSION['EWT_USERNAME'],
	"DEP_LV1_ID" => $chk['DEP_LV1_ID'],// สำนัก กอง ศูนย์
	"DEP_LV2_ID" => $chk['DEP_LV2_ID']// กลุ่ม
);
$getPersonList = callAPI('getPersonList',$data_request_type);//ข้อมูลผู้ใช้งาน

$data_request_car_id = array(
	"meeting_id" => $_GET["meeting_id"]
);
$getRoomDetail = callAPI('getRoomDetail',$data_request_car_id);//รายละเอียดห้องประชุม

$data_request_room_id = array(
	"meeting_id" => $_GET["meeting_id"]
);
$getMeetingToolAsset = callAPI('getMeetingToolAsset',$data_request_room_id);//รายละเอียดห้องประชุม
// echo '<br><br><br><br><br><pre>';
 // print_r($getMeetingToolAsset['Data']);
 // echo '</pre>';
 // echo '<br><br><br><br><br><pre>';
 // print_r($_SESSION);
 // echo '</pre>';
?>

<!-- แถบสีน้ำเงินหัวข้อข่าวสาร -->
<div class="container-fluid mar-spacehead  shadow-sm" style="background-color:rgba(241, 237, 234, 0.8) ;">
    <form id="contact-form" action="#" method="post" role="form">
        <div class="row  w-100 d-flex justify-content-center">
            <img src="images/2meet.png" class="img rounded icon-tabhead" alt="BG-BookingCar"><span>
                <h1 class="col-12 txt-gradient-purple font-h-search  pt-4 pb-4 ">
                    จองห้องประชุม
                </h1>
            </span>
        </div>
    </form>
</div>
<!-- แถบคลอแล๊บด้านบน -->
<div class="d-flex ">
    <div class="p-2 StepBox-882-car p-3 ">

        <h3 class="mt-2 mb-0"><i class="fa fa-desktop"></i></h3>
        <h4 class="mt-0 text_tag">1. กรอกรายละเอียด</h4>
        <p class="white-text font-small">ให้ผู้จองกรอกรายละเอียดต่างๆอย่างครบถ้วนสมบูรณ์</p>
        <div class="arrow-right-822-car1"></div>
    </div>
    <div class="p-2 StepBox-BE4-car  p-3">
        <h3 class="mt-2 mb-0"><i class="fa fa-user-check"></i></h3>
        <h4 class="mt-0 text_tag">2. ผ่านความเห็นชอบ</h4>
        <p class="white-text font-small">เลือกผู้บังคับบัญชาสำหรับให้ความเห็นชอบใน การขอจองห้องประชุมส่วนกลาง</p>
        <div class="arrow-right-BE4-car2"></div>
    </div>
    <div class="p-2 StepBox-882-car  p-3">
        <h3 class="mt-2 mb-0"><i class="fa fa-check-circle"></i></h3>
        <h4 class="mt-0 text_tag">3. การอนุมัติคำขอ </h4>
        <p class="white-text font-small">คำขอที่ผ่านความเห็นชอบจากผู้บังคับบัญชาจะ ถูกส่งต่อไปยังผู้มีอำนาจอนุมัติ</p>
        <div class="arrow-right-822-car3"></div>
    </div>
    <div class="p-2 StepBox-BE4-car  p-3">
        <h3 class="mt-2 mb-0"><i class="fa fa-list-alt"></i></h3>
        <h4 class="mt-0 text_tag">4. ตรวจสอบสถานะ</h4>
        <p class="white-text font-small">ผู้จองสามารถตรวจสอบขั้นตอนการจองได้จาก"สถานะคำขอ"ซึ่งเป็นหนึ่งในเครื่องมือของผู้ใช้งาน</p>
        <div class="arrow-right-BE4-car4"></div>
    </div>
    <div class="p-2 StepBox-882-car  p-3">
        <h3 class="mt-2 mb-0"><i class="fa fa-door-open"></i></h3>
        <h4 class="mt-0 text_tag">5. เข้าใช้งานห้องประชุม </h4>
        <p class="white-text font-small">ผู้จองจะได้รับแจ้ง วัน เวลา สถานที่ ของห้องประชุมพร้อมใช้งาน </p>
    </div>
</div>


<!-- News index page -->
<div class="shadow-sm container-fluid Knowledge-bg-head ">
    <div class="container pb-3 ">
        <h2 class="h2-color pt-4">
            แบบฟอร์มการจอง <?php echo $getRoomDetail['Data']['ROOM_NAME'];?>
        </h2>
        <h5 class="h2-color"><a href="Booking_room.php">จองห้องประชุม > </a> <span>แบบฟอร์มการจองห้องประชุม</span></h5>
        <hr class="hr_news mt-0">


        <!-- form ห้องประชุม -->
        <form method="post" enctype="multipart/form-data"  id="form_wf">
		<input type="hidden" name="ROOM_ID" value="<?php echo $_GET["meeting_id"];?>">
		<input type="hidden" name="USR_USERNAME" value="<?php echo $_SESSION['EWT_USERNAME'];?>">
		<input type="hidden" name="DEP_NAME1" value="<?php echo $chk['DEP_NAME1'];?>">
			<div class="form-row align-items ">
				<div class="latest-post-media ">
                    <a href="#" class="latest-post-img">
                        <img loading="lazy" class="bor-ra-t15px img-fluid  max-height-news w-100" src="images/<?php echo $getRoomDetail['Data']['ROOM_PIC_NAME'];?>" alt="img">
                    </a>
                </div>
				<!----><div class="col-sm-6 " >
                    <h4 class="h2-color ml-2">อุปกรณ์พื้นฐานประจำห้องประชุม :</h4>
					<table class="table table-sm">
					<?php if(count($getMeetingToolAsset['Data']) > 0){?>	
						<thead class="white-text bg-color-purple ta-fontmini ">
							<tr>
								<th scope="col" width="20%" class="text-center">ลำดับ</th>
								<th scope="col" width="60%" class="text-center">ชื่ออุปกรณ์</th>
								<th scope="col" width="20%" class="text-center">จำนวน</th>
							</tr>
						</thead>
						<tbody>
						<?php 
							$i = 1;
							foreach($getMeetingToolAsset['Data'] as $k => $v ){
							?>
							<tr>
								<td class="text-center"><?php echo $i;?></td>
								<td class="text-left" style="padding-left:50px;"><?php echo $v['ASSET_DESC'];?></td>
								<td class="text-center"><?php echo $v['ASSET_REMARK'];?></td>
							</tr>
							<?php 
							$i++;
							}
						
						?>
						</tbody>
					<?php 
					}else{
						echo "&nbsp&nbsp-- ไม่มีข้อมูล --";
					}
					?>
					</table>
                </div>
			</div><br>
            <div class="form-row align-items-center">
                <div class="col-sm-6 my-1">
                    <h4 class="h2-color ml-2">* หัวข้อการประชุม :</h4>
                    <input required oninvalid="this.setCustomValidity('กรุณากรอกข้อมูล หัวข้อการประชุม')" oninput="this.setCustomValidity('')" id="MEETING_TOPIC" name="MEETING_TOPIC" class="form-control" type="text" placeholder="กรุณากรอกหัวข้อการประชุม">
                </div>
                <div class="col-sm-6 my-1">
                    <h4 class="h2-color ml-2">* ประธานในที่ประชุม :</h4>
                    <input required oninvalid="this.setCustomValidity('กรุณากรอกข้อมูล ประธานในที่ประชุม')" oninput="this.setCustomValidity('')" id="MEETINH_CHAIRMAN" name="MEETINH_CHAIRMAN" class="form-control" type="text" placeholder="กรุณากรอกชื่อประธานในที่ประชุม">
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-6 ">
                    <h5 class="ml-2 mb-0 h2-color"><i class="fa fa-calendar"></i> วันเริ่มต้น</h5>
                    <input required oninvalid="this.setCustomValidity('กรุณากรอกข้อมูล วันเริ่มต้น')" oninput="this.setCustomValidity('')" class="ml-2 pb-1 " type="date" id="DATE_START" name="DATE_START" value="dd/mm/yyy" 
					onChange="check_meet(<?php echo $_GET['meeting_id'];?>,'status');" min="<?php echo date('Y-m-d');?>" >
                </div>
                <div class=" col-lg-3 col-md-3 col-sm-6  col-6 ">
                    <h5 class="ml-2 mb-0 h2-color"><i class="fa fa-calendar"></i> วันที่สิ้นสุด</h5>
                    <input required oninvalid="this.setCustomValidity('กรุณากรอกข้อมูล วันที่สิ้นสุด')" oninput="this.setCustomValidity('')" class=" ml-2 pb-1 " type="date" id="DATE_END" name="DATE_END" value="dd/mm/yyy" 
					onChange="check_meet(<?php echo $_GET['meeting_id'];?>,'status');">
                </div>
                <div class=" col-lg-3 col-md-3 col-sm-6 col-12 ">
                    <h5 class="ml-2 mb-0 h2-color"><i class="fa fa-clock"></i> เวลาเริ่มการประชุม</h5>
					<input required oninvalid="this.setCustomValidity('กรุณากรอกข้อมูล เวลาเริ่มการประชุม')" oninput="this.setCustomValidity('')" type="time" class="form-control timeFormat" id="TIME_START" name="TIME_START" placeholder = "__:__" 
					onChange="check_meet(<?php echo $_GET['meeting_id'];?>,'status');">
                    <!--<input id="TIME_START" name="TIME_START" class="form-control" type="text" placeholder="กรุณากรอกเวลาไป">-->
                </div>
                <div class=" col-lg-3 col-md-3 col-sm-6 col-12 ">
                    <h5 class="ml-2 mb-0 h2-color"><i class="fa fa-clock"></i> เวลาสิ้นสุดการประชุม</h5>
					<input required oninvalid="this.setCustomValidity('กรุณากรอกข้อมูล เวลาสิ้นสุดการประชุม')" oninput="this.setCustomValidity('')" type="time" class="form-control timeFormat" id="TIME_END" name="TIME_END" placeholder = "__:__" 
					onChange="check_meet(<?php echo $_GET['meeting_id'];?>,'status');">
                    <!--<input id="TIME_END" name="TIME_END" class="form-control" type="text" placeholder="กรุณากรอกเวลากลับ">-->
                </div>
                <div class="col-sm-6 my-1">
                    <h4 class="h2-color ml-2">* จำนวนผู้เข้าร่วม :</h4>
                    <input required oninvalid="this.setCustomValidity('กรุณากรอกข้อมูล จำนวนผู้เข้าร่วม')" oninput="this.setCustomValidity('')" id="GUEST" name="GUEST" class="form-control" type="number" placeholder="กรุณากรอกจำนวนผู้เข้าร่วม"
					onChange="check_meet(<?php echo $_GET['meeting_id'];?>,'status');">
                </div>
                <div class="col-sm-6 my-1">
                    <h4 class="h2-color ml-2">* หมายเลขโทรศัพท์ :</h4>
                    <input required oninvalid="this.setCustomValidity('กรุณากรอกข้อมูล หมายเลขโทรศัพท์')" oninput="this.setCustomValidity('')" id="TEL" name="TEL" class="form-control" type="tel" placeholder="XXX-XXX-XXXX" maxlength=""/>
                </div>
                <div class=" col-lg-6 col-md-6 col-sm-6 col-12 ">
                    <h4 class="ml-2 mb-0 h2-color">* ผู้ผ่านความเห็นชอบ</h4>
					<select required oninvalid="this.setCustomValidity('กรุณากรอกข้อมูล ผู้ผ่านความเห็นชอบ')" oninput="this.setCustomValidity('')" id="PER_APPROVE_ID" name="PER_APPROVE_ID" class=" form-control">
                        <option value="" selected>เลือกผู้ผ่านการเห็นชอบ</option>
                        <?php 
						foreach ($getPersonList['Data'] as $key => $value) {
							echo "<option value=" . $key . ">" . $value['FULLNAME'] . "</option>";
						}
						?>
                    </select>
                    <!--<select id="inputState" class="ml-2 form-control">
                        <option selected>เลือกผู้ผ่านการเห็นชอบ</option>
                        <option>...</option>
                    </select>-->
                </div>
                <div class=" col-lg-6 col-md-6 col-sm-6 col-12 ">
                    <h5 class="ml-2 mb-0 h2-color"></h5>
                </div>
                <div class=" col-lg-6 col-md-6 col-sm-6 col-12 ">
                    <h4 class="ml-2 mb-0 h2-color">หมายเหตุ</h4>
                    <input oninput="this.setCustomValidity('')" id="NOTE" name="NOTE" class="form-control" type="text-area" >
                </div>
            </div>
        <!--</form>-->
        <hr>
        <!-- ยืมอุปกรณ์เพิ่มเติม  เช็คบล๊อกก่อนถึงจะเพิ่มจำนวนอุปกรณ์ได้-->
        <h3 class="h2-color">ยืมอุปกรณ์เพิ่มเติม</h3>
        <div class="form-group form-check ">
			<div class="row ">
					<div class="col-lg-4 col-md-4 col-sm-8 col-8 m-2 ">
						<h4 class="h2-color ml-2">รายการ</h4>
					</div>
					<div class="col-lg-2 col-md-2 col-sm-4 col-4 m-2 text-center">
						<h4 class="h2-color ml-2">จำนวนที่มี</h4>
					</div>
					<!--<div class="col-lg-2 col-md-2 col-sm-4 col-4 m-2 text-center">
						<h4 class="h2-color ml-2">จำนวณคงเหลือ</h4>
					</div>-->
					<div class="col-lg-2 col-md-2 col-sm-4 col-4 m-2 text-center">
						<h4 class="h2-color ml-2">จำนวณที่ต้องการ</h4>
					</div>
            </div>
            <div class="row ">
				<?php 
					foreach ($getMeetingToolAddList['Data'] as $key => $value) {
				?>
					<div class="col-lg-4 col-md-4 col-sm-8 col-8 m-2">
						<input type="checkbox" class="form-check-input mt-2" id="TOOLCHECK" rel="<?php echo $key;?>" name="TOOLCHECK[<?php echo $key;?>]" onclick="" >
						<label class="form-check-label" for="exampleCheck1"><?php echo $value['TOOL_NAME'];?></label>
						
					</div>
					<div class="col-lg-2 col-md-2 col-sm-4 col-4 m-2" align="center">
						<?php echo $value['QUANTITY'];?>
					</div>
					<!--<div class="col-lg-2 col-md-2 col-sm-4 col-4 m-2" align="center">
						<input type="text" disabled class="form-control text-center" name="BALANCE" id="BALANCE_<?php echo $key;?>" value="">
					</div>-->
					<div class="col-lg-2 col-md-2 col-sm-4 col-4  m-2" align="center"><!--TOOLAMOUNT_<?php echo $key;?>-->
						<input disabled class="form-control text-center" type="number" placeholder="0" id="TOOLAMOUNT_<?php echo $key;?>" name="TOOLAMOUNT[<?php echo $key;?>]" min="1" onChange="check_meet(<?php echo $_GET['meeting_id'];?>,'status');">
					</div>
				<?php 
					}
				?>
            </div>


        </div>

        <!-- btn ตกลง /ยกเลิก -->
        <div class="row d-flex justify-content-center mt-4 mb-3">
            <div class=" col-lg-4 col-md-4 col-sm-12 col-12">
                <a href="#" data-toggle="modal" data-target=".bd-example-modal-lg " class="mt-2 mb-3 px-3 btn d-flex 
        justify-content-center  border-ra-15px btn-danger text-white btn-sm">ยกเลิก</a>
            </div>
            <div class=" col-lg-4 col-md-4 col-sm-12 col-12">
				<button id="submit" type="submit" data-toggle="modal" class="mt-2 mb-6 px-3 btn d-flex 
				justify-content-center  border-ra-15px btn-success  text-white btn-sm" style="width:100%;">ส่งคำขอจองห้องประชุม</button>
                <!--<a href="#" data-toggle="modal" data-target=".bd-example-modal-lg " class="mt-2 mb-3 px-3 btn d-flex 
        justify-content-center  border-ra-15px btn-success btn-sm">ส่งคำขอจองห้องประชุม</a>-->
            </div>
        </div>
		
		</form>




    </div>

</div>





<?php include('footer.php'); ?>
<!-- Footer Website -->
<?php include('combottom.php'); ?>

<!-- PLUS MINUS BUTTONS JS -->
<script>
    jQuery(document).ready(function() {
		
        // This button will increment the value
        $('[data-quantity="plus"]').click(function(e) {
            // Stop acting like a button
            e.preventDefault();
            // Get the field name
            fieldName = $(this).attr('data-field');
            // Get its current value
            var currentVal = parseInt($('input[name=' + fieldName + ']').val());
            // If is not undefined
            if (!isNaN(currentVal)) {
                // Increment
                $('input[name=' + fieldName + ']').val(currentVal + 1);
            } else {
                // Otherwise put a 0 there
                $('input[name=' + fieldName + ']').val(0);
            }
        });
        // This button will decrement the value till 0
        $('[data-quantity="minus"]').click(function(e) {
            // Stop acting like a button
            e.preventDefault();
            // Get the field name
            fieldName = $(this).attr('data-field');
            // Get its current value
            var currentVal = parseInt($('input[name=' + fieldName + ']').val());
            // If it isn't undefined or its greater than 0
            if (!isNaN(currentVal) && currentVal > 0) {
                // Decrement one
                $('input[name=' + fieldName + ']').val(currentVal - 1);
            } else {
                // Otherwise put a 0 there
                $('input[name=' + fieldName + ']').val(0);
            }
        });
    });
</script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> <!-- script time format -->
<script src="https://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js" type="text/javascript"></script> <!-- script time format -->

<script>
	
$(document).ready(function() {
	$('.timeFormat').mask('00:00');
	
	
	var room_type = "<?php echo $_GET['meeting_id']; ?>";
	if(room_type != ''){
		check_meet(room_type,'status');
	}
		

});	
		$('#form_wf').submit(function(e) {
			 // let x = document.forms["form_wf"]["MEETING_TOPIC"].value;
			  // if (x == "") {
				// form_wf.MEETING_TOPIC.focus();
				// alert("กรุณากรอกหัวข้อการประชุม");
				// return false;
			  // }
				Swal.fire({
                title: 'ยืนยันการส่งข้อมูล ? ',
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
							url: 'save/insert_room_booking.php',
							type: 'POST',
							data: $('#form_wf').serialize() ,
							success: function(data) {
								console.log(data);

								if (data == 1) {
									Swal.fire(
										'ส่งข้อมูลสำเร็จ',
										' ',
										'success'
										
									).then(function() {
										window.location = "Booking_room.php";
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
			e.preventDefault();
		})



	// function chkFunction() {
		// var checkBox = document.getElementById("TOOLCHECK[]");
		// var text = document.getElementById("TOOLAMOUNT[]");
		// if (checkBox.checked == true){
			// text.disabled = false;
		// } else {
			// text.disabled = true;
		// }
		
	// }
	$("#DATE_START").change(function(){
		// $("#DATE_END").val($("#DATE_START").val());
		$("#DATE_END").attr('min',$("#DATE_START").val());
	});
	$("#DATE_END").change(function(){
		if($("#DATE_START").val() == ''){
			alert('กรุณาเลือกวันที่เริ่มต้นก่อน');
			$("#DATE_END").val('');
		}
	});
	$("#TIME_START").change(function(){
		$("#TIME_END").attr('min',$("#TIME_START").val());
	});
	$("#TIME_END").blur(function(){
		if($("#TIME_END").val() != "" && $("#TIME_END").val() < $("#TIME_START").val()){
			alert('กรุณากรอกเวลาสิ้นสุดให้มากกว่าเวลาเริ่มต้น');
		}
	});
	
	$(function(){
		$(':checkbox').click(function(){
			var th=$(this);
			var rel=th.attr('rel');
			if(th.is(':checked')){
				$('#TOOLAMOUNT_'+rel).prop('disabled',false);
				$('#TOOLAMOUNT_'+rel).val('1');
			}else{
				$('#TOOLAMOUNT_'+rel).prop('disabled',true);
				$('#TOOLAMOUNT_'+rel).val('0');
			}
		});
	});


	function check_meet(c,t){
	var num_pp = $('#GUEST').val();
	var get_time = $('#TIME_START').val();
	var dataString ='INS_ID='+c+'&MEETING_DATE='+$('#DATE_START').val()+'&MEETING_EDATE='+$('#DATE_END').val()+'&STIME='+$('#TIME_START').val()+'&ETIME='+$('#TIME_END').val();//+'&WFR_ID='+wfrid

	var date  = $('#DATE_START').val();
	DateParts = date.split('/');
	new Date(+DateParts[2], DateParts[1] - 1, +DateParts[0]).setUTCHours(
      0,
      0,
      0,
      0
    )
	var year  = DateParts[2] - 543;
	var month = DateParts[1] ;
	var day   = DateParts[0];
	date  = new Date(year + 1, month, day);

	var sdate = year + '-' + ('0' + month).slice(-2) + '-' + ('0' + day).slice(-2);
	var starttime = new Date(sdate + " " + $('#TIME_START').val() + ":00");
	var lasttime = new Date(sdate + " " + $('#TIME_END').val() + ":00");
	if($('#TIME_START').val() >= $('#TIME_END').val() && $('#TIME_END').val() != ''){ 
		$('#TIME_END').val('');
		CallAlert("เวลาจองห้องไม่ถูกต้อง");
	}else{ 
		var diffMs = (lasttime.getTime()  - starttime.getTime() );
		var diffMins = (diffMs / (1000*60));
		$.ajax({
			type: "POST",
			dataType:'json', 
			url: "meeting_room.php",
			data: dataString,
			cache: false,
			success: function(html){ 
				if(t == 'status'){
					/* if($('#TIME_END').val() && diffMins < html.room_diff){
						// $('#wf-btn-save').attr('disabled', 'disabled');
						$('#TIME_END').val('');
						CallAlert("กรุณาระบุช่วงเวลาการประชุมอย่างน้อย "+html.room_diff+"นาที");
						// CallAlert("ห้องไม่ว่างในช่วงเวลาที่ท่านเลือก");
					}else{ */
						if(html.equip_main2 == '0'){//ถ้าห้องว่าง
							if(num_pp > 0 && num_pp != '' && $('#TIME_START').val() != '' && $('#TIME_END').val() != '' && $('#REQ_TEL').val() != '' && $('#REQ_TEL_CON').val() != ''){
								$('#wf-btn-save').removeAttr("disabled");
							}else if((num_pp <= 0 || num_pp == '') && $('#TIME_START').val() != '' && $('#TIME_END').val() != '' && $('#REQ_TEL').val() == '' && $('#REQ_TEL_CON').val() == ''){
								CallAlert("กรุณาระบุจำนวนผู้ร่วมประชุม");
								$('#wf-btn-save').attr('disabled', 'disabled');
							}
						}else{ //ถ้าห้องไม่ว่าง
							$('#wf-btn-save').attr('disabled', 'disabled');
							// if(get_time){ //ถ้าไม่ได้กรอกเวลา

							// }else if('<?php echo $_GET['WFR'];?>' ==""){ // ถ้ากรอกเวลา
								$('#TIME_START').val(''); 
							// }
							$('#TIME_END').val('');
							alert("ช่วงเวลานี้ มีผู้ขอใช้ห้องประชุมแล้ว");
						}
					/* } */ 
					
						if(html.seat_amount != '-' && num_pp > parseInt(html.seat_amount)){
						alert("กรุณากรอกจำนวนผู้เข้าร่วมประชุมให้ถูกต้อง");
						$('#GUEST').val('').focus();
						}
						
						$.each(html.arr_tool_all, function( k, v ) {
						  // alert( "Key: " + k + ", Value: " + v );
						  $('#'+k).val(v);
						  // $('#BALANCE_2').val(html.arr_tool_all.sum_tool_2);
						});
						
						
						$.each(html.arr_tool_max, function( k, v ) {
						  // alert( "Key: " + k + ", Value: " + v );
						  // $('#'+k).val('');
						  $('#'+k).attr('max',v);
						  // $('#TOOLAMOUNT_1').attr('max',10);
						if($('#'+k).val() > v ){
							alert("กรุณากรอกจำนวณที่ต้องการให้ถูกต้อง");
							$('#'+k).val('').focus();
						}
						});
				}
				/*if(t == 'ck_number'){ //check_meet($('#ROOM_ID').val(),'ck_number');
					if(html.seat_amount != '-' && num_pp > parseInt(html.seat_amount)){
						alert("กรุณากรอกจำนวนผู้เข้าร่วมประชุมให้ถูกต้อง");
						$('#GUEST').val('').focus();
					}<span style='color:#d9534f;font-size:12pt;'>หมายเหตุ: จำนวนผู้เข้าร่วมประชุมต้องไม่เกินความจุของห้อง</span>
				}*/
			}
		});
	}
	};
</script>

<!-- Include file js and properties -->