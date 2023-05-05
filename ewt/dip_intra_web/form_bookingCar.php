<?php include('comtop.php'); ?>
<!-- Include file css and properties -->
<?php include('header.php'); ?>
<!-- Menu and Logo -->
<?php include('callservice.php'); ?>
<!-- CALL SERVICE -->

<style>
::placeholder {
    font-weight: bold;
    opacity: 0.5;
    color: green;
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

$getObjectiveCarBooking = callAPI('getObjectiveCarBooking');//วัตถุประสงค์ในการใช้ยานพาหนะ
$getProvince = callAPI('getProvince');//จังหวัด

$data_request_type = array(
	"type" => 'car',
	"username" => $_SESSION['EWT_USERNAME'],
	"DEP_LV1_ID" => $chk['DEP_LV1_ID'],// สำนัก กอง ศูนย์
	"DEP_LV2_ID" => $chk['DEP_LV2_ID']// กลุ่ม
);
$getPersonList = callAPI('getPersonList',$data_request_type);//ข้อมูลผู้ใช้งาน
$getRequestBookingCarList = callAPI('getRequestBookingCarList');//ข้อมูลการจอง (จะใช้แค่ COUNT_NO เพื่อเอามาเจนเลขคำขอ) $getPersonList['Data']['COUNT']

$data_request_car_id = array(
	"car_id" => $_GET["car_id"]
);
$getCarList = callAPI('getCarDetail', $data_request_car_id);//รายละเอียดรถ
if($getCarList['ResponseCode']['ResCode'] == '000'){
	$CAR_ID = $getCarList['Data']['CAR_ID'];
	$NATURE_ID = $getCarList['Data']['NATURE_ID'];
	$CAR_REGISTER = $getCarList['Data']['CAR_REGISTER'];
	$CAR_REMARK = $getCarList['Data']['CAR_REMARK'];
	$CAR_MILEAGE = $getCarList['Data']['CAR_MILEAGE'];
	$CAR_AMOUNT_SEAT = $getCarList['Data']['CAR_AMOUNT_SEAT'];
	$CAR_PIC_NAME = $getCarList['Data']['CAR_PIC_NAME'];
}

$getMaxCarBook = callAPI('getMaxCarBook');

// echo '<br><br><br><br><br><br><pre>';
 // print_r($getMaxCarBook['Data']['WFR_MAX']);
 // echo '</pre>';
 // echo '<br><br><br><br><br><pre>';
 // print_r($chk['DEP_LV1_ID']);
 // echo '</pre>';
?>

<!-- แถบสีน้ำเงินหัวข้อข่าวสาร -->
<div class="container-fluid mar-spacehead bg-tabhead shadow-sm">
	<form id="contact-form" action="#" method="post" role="form">
        <div class="row  w-100 d-flex justify-content-center">
            <img src="images/2car.png" class="img rounded icon-tabhead" alt="BG-BookingCar"><span>
                <h1 class="col-12 txt-gradient-purple font-h-search  pt-4 pb-4 ">
                    จองยานพาหนะ 
                </h1>
            </span>
        </div>
    </form>
</div>

<div class="d-flex ">
    <div class="p-2 StepBox-882-car p-3 ">

        <h3 class="mt-2 mb-0"><i class="fa fa-desktop"></i></h3>
        <h4 class="mt-0 text_tag">1. กรอกรายละเอียด</h4>
        <p class="white-text font-small">ให้ผู้จองกรอกรายละเอียดต่างๆ</p>
        <div class="arrow-right-822-car1"></div>
    </div>
    <div class="p-2 StepBox-BE4-car  p-3">
        <h3 class="mt-2 mb-0"><i class="fa fa-user-circle"></i></h3>
        <h4 class="mt-0 text_tag">2. ผ่านความเห็นชอบ</h4>
        <p class="white-text font-small">เลือกผู้บังคับการในการเห็นชอบ
            ขอเพื่อใช้พาหนะ</p>
        <div class="arrow-right-BE4-car2"></div>
    </div>
    <div class="p-2 StepBox-882-car  p-3">
        <h3 class="mt-2 mb-0"><i class="fa fa-check-circle"></i></h3>
        <h4 class="mt-0 text_tag">3. การอนุมัติจ่ายรถ </h4>
        <p class="white-text font-small">คำขอที่ผ่านความเห็นชอบ
            จะถูกส่งไปยังผู้อนุมัติ</p>
        <div class="arrow-right-822-car3"></div>
    </div>
    <div class="p-2 StepBox-BE4-car  p-3">
        <h3 class="mt-2 mb-0"><i class="fa fa-car"></i></h3>
        <h4 class="mt-0 text_tag">4. การจัดคิวรถ</h4>
        <p class="white-text font-small">เมื่อคำขอได้รับอนุมัติ
            ผู้จัดคิวจะจัดสรรพาหนะให้ผู้จอง</p>
        <div class="arrow-right-BE4-car4"></div>
    </div> 
    <div class="p-2 StepBox-882-car  p-3">
        <h3 class="mt-2 mb-0"><i class="fa fa-map"></i></h3>
        <h4 class="mt-0 text_tag">5. ออกเดินทาง </h4>
        <p class="white-text font-small">ผู้จองจะได้รับกยานพาหนะสำหรับการเดินทาง
            กรณีที่ไม่มียานพาหนะว่าง คุณสามารถใช้เอกสาร
            จากระบบ เพื่อแนบในการเบิกค่ายานพาหนะได้</p>
    </div>
</div>


<!-- News index page -->
<div class="shadow-sm container-fluid Knowledge-bg-head ">
    <div class="container pb-3 ">
        <h2 class="h2-color pt-4">
            แบบฟอร์มการจองยานพาหนะ <?php echo $NATURE_ID;?> ทะเบียน <?php echo $CAR_REGISTER;?> 
        </h2>
        <h5 class="h2-color"><a href="Booking_car.php">จองยานพาหนะ > </a> <span>แบบฟอร์มการจองยานพาหนะ</span></h5>
        <hr class="hr_news mt-0">

<form method="post" enctype="multipart/form-data"  id="form_wf">
		<input type="hidden" name="COUNT_NO" value="<?php echo $getRequestBookingCarList['Data']['COUNT'];?>">
		<input type="hidden" name="REQ_NO" value="<?php echo $getRequestBookingCarList['Data']['REQ_NO'];?>">
		<input type="hidden" name="YEAR_BUDGET" value="<?php echo $getRequestBookingCarList['Data']['YEAR_BUDGET'];?>">
		<input type="hidden" name="REQUEST_CAR_ID" value="<?php echo $_GET["car_id"];?>">
		<input type="hidden" name="REQUEST_CAR_DETAIL" value="<?php echo $NATURE_ID." ทะเบียน".$CAR_REGISTER;?>">
		<input type="hidden" name="USR_USERNAME" value="<?php echo $_SESSION['EWT_USERNAME'];?>">
		<input type="hidden" name="DEP_NAME1" value="<?php echo $chk['DEP_NAME1'];?>">
		<input type="hidden" name="WFR_MAX" value="<?php echo $getMaxCarBook['Data']['WFR_MAX'];?>">
			<div class="form-row align-items-center">
				<div class="latest-post-media ">
                    <a href="#" class="latest-post-img">
                        <img loading="lazy" class="bor-ra-t15px img-fluid  max-height-news w-100" src="images/<?php echo $CAR_PIC_NAME;?>" alt="img">
                    </a>
                </div>
			</div><br>
            <h4 class="h2-color">* วัตถุประสงค์ในการใช้ยานพาหนะ :</h4>
            <div class="form-row align-items-center">
                <div class="col-sm-4 my-1">
                    <select required oninvalid="this.setCustomValidity('กรุณากรอกข้อมูล วัตถุประสงค์ในการใช้ยานพาหนะ')" oninput="this.setCustomValidity('')" id="OBJECTIVE" name="OBJECTIVE" class="form-control"  >
                        <option value="" selected>เลือกวัตถุประสงค์</option>
						<?php 
						foreach ($getObjectiveCarBooking['Data'] as $key => $value) {
							echo "<option value=" . $key . ">" . $value . "</option>";
						}
						?>
                    </select>
                </div>
            </div>
            <h4 class="h2-color">* จุดหมายปลายทาง :</h4>
            <div id="inputboxes" class="form-row align-items-center">
                <div class="col-sm-3 my-1">
                    <select required oninvalid="this.setCustomValidity('กรุณากรอกข้อมูล เลือกพื้นที่')" oninput="this.setCustomValidity('')" id="PROVINCE_CODE" name="PROVINCE_CODE[]" class="form-control">
                        <option value="" >เลือกพื้นที่</option>
                        <option value="99" >และจังหวัดใกล้เคียง</option>
                        <?php 
						foreach ($getProvince['Data'] as $key => $value) {
							echo "<option ".($key == 10 ? "":"")." value=" . $key . ">" . $value . "</option>";
						}
						?>
                    </select>
                </div>
                <div class="col-sm-3 my-1">
                    <input required oninvalid="this.setCustomValidity('กรุณากรอกข้อมูล โปรดระบุสถานที่')" oninput="this.setCustomValidity('')" type="text" class="form-control" id="LOCATION" name="LOCATION[]" placeholder="โปรดระบุสถานที่">
                </div>
				<!-- เมื่อกดเพิ่มจุดหมาย จะลบข้อมูลได้ -->
				<div class="col-auto ml-3">
					<button type="button" class="btn btn-success" id="rowAdder" style="width:100px;">เพิ่มข้อมูล</button>
				</div>
				<!--<div class="col-auto ">
					<button type="" class="btn btn-danger" disabled>ลบข้อมูล</button>
				</div>-->
            </div>
			
			<div id="newinput"></div>
			
			
			<!--<div class="form-group"> 
      <?php// echo get_input_file('PIC_FILENAME','105',$rec["PIC_ID"],$proc,'ไฟล์แนบ'); //ชื่อฟิล , WF_MAIN_ID , WFR_ID , proc ?>
     
     </div>-->

            <div class="form-group">
                <h4 class="h2-color">กรณีเดินทางไปต่างจังหวัด :</h4>
                <input required type="file" class="form-control-file" name="FILEUPLOAD[]" id="FILEUPLOAD" accept=".pdf,.png,.jpg,.jpeg,.doc,.docx"><!--multiple-->
                <label class=" font-small" style="color: #ff0000;"> * ไฟล์ที่อนุญาตให้แนบได้ pdf,png,jpg,doc ขนาดไฟล์ไม่เกิน 10 MB.</label>
				<!--<input type="hidden" name="file" value="">
				<input type="hidden" name="filename" value="<?php echo $_FILES['name'];?>">
				<input type="hidden" name="tmp_name" value="<?php echo $_FILES['tmp_name'];?>">-->
            </div>

		<!--</form>-->
        <hr>

        <!--<form>-->
            <div class="form-row align-items-center">
                <div class="col-lg-3 col-md-3 col-sm-6 col-6 ">
                    <h4 class="ml-2 mb-0 h2-color"><i class="fa fa-calendar "></i> วันเริ่มต้น</h4>
                    <input required oninvalid="this.setCustomValidity('กรุณากรอกข้อมูล วันเริ่มต้น')" oninput="this.setCustomValidity('')" class="ml-2 pb-1 " type="date" id="DATE_START" name="DATE_START" value="dd/mm/yyy" min="<?php echo date('Y-m-d');?>" placeholder="dd/mm/yyyy" pattern="\d{1,2}/\d{1,2}/\d{4}">
                </div>
                <div class=" col-lg-3 col-md-3 col-sm-6  col-6 ">
                    <h4 class="ml-2 mb-0 h2-color"><i class="fa fa-calendar"></i> วันที่สิ้นสุด</h4>
                    <input required oninvalid="this.setCustomValidity('กรุณากรอกข้อมูล วันที่สิ้นสุด')" oninput="this.setCustomValidity('')" class=" ml-2 pb-1 " type="date" id="DATE_END" name="DATE_END" value="dd/mm/yyy">
                </div>
                <div class=" col-lg-3 col-md-3 col-sm-6 col-12 ">
                    <h4 class="ml-2 mb-0 h2-color"><i class="fa fa-clock"></i> เวลาเดินทางไป</h4>
					<input required oninvalid="this.setCustomValidity('กรุณากรอกข้อมูล เวลาเดินทางไป')" oninput="this.setCustomValidity('')" type="time" class="form-control timeFormat" id="TIME_START" name="TIME_START" placeholder = "__:__" onChange="check_meet(<?php echo $_GET['car_id'];?>,'status');" />
                    <!--<input required class="form-control" type="text" id="TIME_START" name="TIME_START" placeholder="กรุณากรอกเวลาไป" >-->
                </div>
                <div class=" col-lg-3 col-md-3 col-sm-6 col-12 ">
                    <h4 class="ml-2 mb-0 h2-color"><i class="fa fa-clock"></i> เวลาเดินทางกลับ</h4>
					<input required oninvalid="this.setCustomValidity('กรุณากรอกข้อมูล เวลาเดินทางกลับ')" oninput="this.setCustomValidity('')" type="time" class="form-control timeFormat" id="TIME_END" name="TIME_END" placeholder = "__:__"  onChange="check_meet(<?php echo $_GET['car_id'];?>,'status');" />
                    <!--<input required class="form-control" type="text" id="TIME_END" name="TIME_END" placeholder="กรุณากรอกเวลากลับ">-->
                </div>
                <div class=" col-lg-6 col-md-6 col-sm-6 col-12 ">
                    <h4 class="ml-2 mb-0 h2-color">* จำนวนผู้เดินทาง</h4>
                    <input required oninvalid="this.setCustomValidity('กรุณากรอกข้อมูล จำนวนผู้เดินทาง')" oninput="this.setCustomValidity('')" min="1" max="11" id="GUEST" name="GUEST" class="form-control" type="number" placeholder="กรุณากรอกจำนวนผู้เข้าร่วม">
                </div>
                <div class=" col-lg-6 col-md-6 col-sm-6 col-12 ">
                    <h4 class="ml-2 mb-0 h2-color">* หมายเลขโทรศัพท์</h4>
                    <input required oninvalid="this.setCustomValidity('กรุณากรอกข้อมูล หมายเลขโทรศัพท์')" oninput="this.setCustomValidity('')" id="TEL" name="TEL" class="form-control" type="text" placeholder="XXX-XXX-XXXX" maxlength="">
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

                </div>
                <div class=" col-lg-6 col-md-6 col-sm-6 col-12 ">
                    <h4 class="ml-2 mb-0 h2-color"></h4>
                </div>
                <div class=" col-lg-6 col-md-6 col-sm-6 col-12 ">
                    <h4 class="ml-2 mb-0 h2-color">หมายเหตุ</h4>
                    <input oninput="this.setCustomValidity('')" id="NOTE" name="NOTE" class="form-control" type="text-area" >
                </div>
            </div>
			
			<div class="row d-flex justify-content-center mt-3 mb-3">
            <div class=" col-lg-4 col-md-4 col-sm-12 col-12">
                <a href="#" data-toggle="modal" data-target=".bd-example-modal-lg " class="mt-2 mb-3 px-3 btn d-flex 
				justify-content-center  border-ra-15px btn-danger text-white btn-sm">ยกเลิก</a>
					</div>
					<div class=" col-lg-4 col-md-4 col-sm-12 col-12">
						<button id="submit" type="submit" data-toggle="modal" class="mt-2 mb-6 px-3 btn d-flex 
				justify-content-center  border-ra-15px btn-success text-white btn-sm" style="width:100%;">ส่งคำขอจองยานพาหนะ</button>
					</div>
				</div>
			<!--<button id="submit" type="submit" class="btn btn-success waves-effect waves-light"><i class="icofont icofont-tick-mark" title=""></i> บันทึก</button>-->
</form>
        




    </div>

</div>





<?php include('footer.php'); ?>
<!-- Footer Website -->
<?php include('combottom.php'); ?>

<!--<script src="dist/sweetalert.min.js"></script>
<link rel="stylesheet" type="text/css" href="dist/sweetalert.css">-->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> <!-- script time format -->
<script src="https://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js" type="text/javascript"></script> <!-- script time format -->
<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>-->
<!-- PLUS MINUS BUTTONS JS -->
<script>
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
	$("#GUEST").change(function(){
		if ($("#GUEST").val() > 11) {
	  $("#GUEST").val('');
	  alert("กรุณากรอกจำนวนผู้เดินทางให้ถูกต้อง");
	}
	});

	let i = 1;
	$("#rowAdder").click(function () {
	 i += 1;
			newRowAdd =
			'<div id="row"  class="form-row align-items-center">' +
			'<div class="col-sm-3 my-1">' +
			'<select required id="PROVINCE_CODE'+i+'" name="PROVINCE_CODE[]" class="form-control">' +
			// '<option value="" >เลือกพื้นที่</option> '+
			// $("#PROVINCE_CODE option").each(function() {
				// alert(this.text + ' ' + this.value);
				// '<option value="'+this.value+'" >'+this.text+'</option>'+
			// });
			'</select>' +
			'</div>' +
			'<div class="col-sm-3 my-1">' +
			'<input required type="text" class="form-control" id="LOCATION" name="LOCATION[]" placeholder="โปรดระบุสถานที่"> </div>' +
			'<div class="col-auto ml-3">' +
			'<button class="btn btn-danger" id="DeleteRow" type="button" style="width:100px;">' +
			' ลบข้อมูล</button> </div>' +
			'</div> ';

			$('#newinput').append(newRowAdd);
			
			$("#PROVINCE_CODE option").each(function() { 
			 $('#PROVINCE_CODE'+i+'').append($('<option>',
			 // $("select[id^='PROVINCE_CODE']").append($('<option>',
			 {
				value: this.value,
				text : this.text
			}));
		});
			
	});

		$("body").on("click", "#DeleteRow", function () {
			$(this).parents("#row").remove();
		})
</script> 

<script>
	$(document).ready(function() {
		$('.timeFormat').mask('00:00');

// ดักถ้า ไม่ใช่กรุงเทพ และปริมณฑล จะให้ $('#FILEUPLOAD').prop('required', true);
// ตอนนี้ยังดักได้แค่ listbox แรก อย่างเดียว
$('#PROVINCE_CODE').on('change', function() {
  // ตรวจสอบค่าของ selectbox ว่าเลือก value เป็น 10 หรือไม่
	if ($(this).val() === '10' || $(this).val() === '73'|| $(this).val() === '12' 
	|| $(this).val() === '13' || $(this).val() === '11'|| $(this).val() === '74') {
    // ถ้าไม่เลือก value เป็น 10 ก็ลบ attribute required ออกจาก #FILEUPLOAD
    $('#FILEUPLOAD').prop('required', false);
  } else {
	 // หา element ที่มี id เป็น "FILEUPLOAD" และตั้งให้มี attribute required
    $('#FILEUPLOAD').prop('required', true);
  }
});


			
		$('#form_wf').submit(function(e) {
			/*let objective = document.forms["form_wf"]["OBJECTIVE"].value;
			 if (objective == "") {
				alert("โปรดเลือกวัตถุประสงค์");
				return false;
			} */
				
				
			var myForm = document.getElementById('form_wf');
			var fd = new FormData(myForm);   
			var ins2 = $('#FILEUPLOAD').prop("files").length;
			for (var x = 0; x < ins2; x++) {
			 fd.append('FILEUPLOAD['+x+']',$('#FILEUPLOAD').prop("files")[x]);
			}
			
			 /* $.ajax({
				url:'save/insert_car_booking.php', //ให้ระบุชื่อไฟล์ PHP ที่เราจะส่งค่าไป
				type:'post',
				data:fd, //ข้อมูลจาก input ที่ส่งเข้าไปที่ PHP
				contentType: false,
				processData: false,
				success:function(response){ //หากทำงานสำเร็จ จะรับค่ามาจาก JSON หลังจากนั้นก็ให้ทำงานตามที่เรากำหนดได้
					console.log(response);
					if(response != 0){
						$("#img").attr("src",response);
						$('.preview img').show();
					}else{
						alert('File not uploaded');
					}
				}
			}); */
			
			
			
			
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
							url: 'save/insert_car_booking.php',
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
										// สำหรับส่งไฟล์
												var ins = $('#FILEUPLOAD').prop("files").length;
												if(ins > 0){
												$.ajax({
													url:'save/insert_car_booking_file.php', //ให้ระบุชื่อไฟล์ PHP ที่เราจะส่งค่าไป
													type:'post',
													data:fd, //ข้อมูลจาก input ที่ส่งเข้าไปที่ PHP
													contentType: false,
													processData: false,
													success:function(response){ //หากทำงานสำเร็จ จะรับค่ามาจาก JSON หลังจากนั้นก็ให้ทำงานตามที่เรากำหนดได้
														console.log(response);
														if(response != 0){
															// $("#img").attr("src",response);
															// $('.preview img').show();
														}else{
															// alert('ส่งไฟล์ไม่สำเร็จ');
														}
													}
												});
												}
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
						
						
						/* // สำหรับส่งไฟล์
						var ins = $('#FILEUPLOAD').prop("files").length;
						if(ins > 0){
						$.ajax({
							url:'save/insert_car_booking_file.php', //ให้ระบุชื่อไฟล์ PHP ที่เราจะส่งค่าไป
							type:'post',
							data:fd, //ข้อมูลจาก input ที่ส่งเข้าไปที่ PHP
							contentType: false,
							processData: false,
							success:function(response){ //หากทำงานสำเร็จ จะรับค่ามาจาก JSON หลังจากนั้นก็ให้ทำงานตามที่เรากำหนดได้
								console.log(response);
								if(response != 0){
									// $("#img").attr("src",response);
									// $('.preview img').show();
								}else{
									// alert('ส่งไฟล์ไม่สำเร็จ');
								}
							}
						});
						} */
						
					}
				})
				
			e.preventDefault();
			
			
			
			
			
		})

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
				
			}
		});
	}
	};
</script>
<!-- Include file js and properties -->