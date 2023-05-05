<?php include('comtop.php'); ?>
<!-- Include file css and properties -->
<?php include('header.php'); ?>
<!-- Menu and Logo -->
<?php include('callservice.php'); ?>
<!-- CALL SERVICE -->

<?php
function show_fulldate_my2_th($date){
		$mont_th = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
		if($date){
			list($y,$m,$d) = explode("-",$date);
			return thainumDigit((int)$d)." ".$mont_th[(int)$m]." ".thainumDigit(($y+543));
		}else{
			return ;
		}
	}
function show_fulldate_my2_en($date,$type=""){
		$mont_en = array("","January","February","March","April","May","June","July","August","September","October","November","December");
		if($date){
			list($y,$m,$d) = explode("-",$date);
			return (int)$d." ".$mont_en[(int)$m]." ".$y;
		}else{
			return ;
		}
	}
function thainumDigit($num) {
	return str_replace(array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'),
	array("๐",
		  "๑",
		  "๒",
		  "๓",
		  "๔",
		  "๕",
		  "๖",
		  "๗",
		  "๘",
		  "๙"
	), $num);
}
$EncryptSal = new encrypt_money();

$USR_USERNAME	= $_SESSION['EWT_USERNAME'];
dbdpis::ConnectDB(SSO_DB_NAME, SSO_DB_TYPE, SSO_ROOT_HOST, SSO_ROOT_USER, SSO_ROOT_PASSWORD, SSO_DB_NAME, SSO_CHAR_SET);

##  ต้องดักเพิ่ม ถ้าเป็น พนักงานราชการ AND H.PAY_LIST_ID = 21##
// CHECK ว่า เป็น ข้าราชการ, พนักงานราชการ, ลูกจ้างประจำ
$filter_join = '';
$chk_per_type = "SELECT  A.USR_TEL, A.USR_TEL_PHONE, B.PER_TYPE
				FROM USR_MAIN A
				LEFT JOIN M_PER_PROFILE B ON B.PER_IDCARD = A.USR_OPTION3
				WHERE A.USR_USERNAME = '".$_SESSION['EWT_USERNAME']."' ";
$q = dbdpis::execute($chk_per_type);
$chk = dbdpis::Fetch($q);
$h_1 = "";
// 1 ข้าราชการ , 2 พนักงานราชการ , 3 ลูกจ้างประจำ
if($chk['PER_TYPE'] == 1 || $chk['PER_TYPE'] == 2){ 
	$filter_join = " AND H.PAY_LIST_ID = 1 ";
}else if($chk['PER_TYPE'] == 3){
	$filter_join = " AND H.PAY_LIST_ID = 21 ";
}
$USR_DATA = dbdpis::getFetch("SELECT TOP 1 A.USR_PREFIX, A.USR_FNAME, A.USR_LNAME,
									A.USR_PREFIX_EN, A.USR_FNAME_EN, A.USR_LNAME_EN, 
									B.POS_NAME, C.DEP_NAME, D.DEP_NAME AS DEP_NAME2, E.PER_TYPE_NAME, F.INCOME_MONEY, G.POS_LEVEL_NAME, H.PAYROLL_MONEY
								FROM USR_MAIN A
								LEFT JOIN USR_POSITION B ON B.POS_ID = A.POS_ID
								LEFT JOIN USR_DEPARTMENT C ON C.DEP_ID = A.DEP_ID
								LEFT JOIN USR_DEPARTMENT D ON D.DEP_ID = A.USR_OPTION5
								LEFT JOIN M_PER_TYPE E ON E.PER_TYPE_ID = A.USR_OPTION4
								LEFT JOIN PAYROLL F ON F.PER_IDCARD = A.USR_OPTION3
								LEFT JOIN PAYROLL_LIST H ON H.PAYROLL_ID = F.PAYROLL_ID {$filter_join}
								LEFT JOIN M_POSITION_LEVEL G ON G.POS_LEVEL_ID = A.USR_OPTION2
								WHERE A.USR_USERNAME = '$USR_USERNAME' 
								ORDER BY F.PAYROLL_ID DESC
								");

$FULL_NAME 	= $USR_DATA['USR_PREFIX'].$USR_DATA['USR_FNAME']." ".$USR_DATA['USR_LNAME'];
$POS_NAME 	= $USR_DATA['POS_NAME'];
$DEP_NAME 	= $USR_DATA['DEP_NAME'];
$DEP_NAME2 	= $USR_DATA['DEP_NAME2'];
$PER_TYPE_NAME 	= $USR_DATA['PER_TYPE_NAME'];
$POS_LEVEL_NAME = $USR_DATA['POS_LEVEL_NAME'];

$FULL_NAME_EN 	= $USR_DATA['USR_PREFIX_EN'].$USR_DATA['USR_FNAME_EN']." ".$USR_DATA['USR_LNAME_EN'];
// $POS_NAME_EN 	= $USR_DATA['POS_NAME'];
// $DEP_NAME_EN 	= $USR_DATA['DEP_NAME'];
// $DEP_NAME2_EN 	= $USR_DATA['DEP_NAME2'];
// $PER_TYPE_NAME_EN 	= $USR_DATA['PER_TYPE_NAME'];
// $POS_LEVEL_NAME_EN = $USR_DATA['POS_LEVEL_NAME'];

$INCOME_MONEY = $EncryptSal->decode($USR_DATA['INCOME_MONEY']);
$PAYROLL_MONEY = $EncryptSal->decode($USR_DATA['PAYROLL_MONEY']);

$DATE_NOW_TH = thainumDigit(show_fulldate_my2_th(DATE('Y-m-d')));
$DATE_NOW_EN = show_fulldate_my2_en(DATE('Y-m-d'));
?>

<?php
$getLocationSend = callAPI('getLocationSend');//สถานที่ในการจัดส่ง
$getObjectiveRequestCertificate = callAPI('getObjectiveRequestCertificate');//วัตถุประสงค์การขอหนังสือรับรอง
$getRequestCertificateList = callAPI('getRequestCertificateList');//ข้อมูลการขอ (จะใช้แค่ COUNT_NO เพื่อเอามาเจนเลขคำขอ) $getRequestCertificateList['Data']['COUNT']

// echo '<pre>';
 // print_r($getRequestCertificateList['Data']);
 // echo '</pre>';
 

?>

<style>
    @media (min-width: 1px) and (max-width: 767px){
    .dis-mobile{
        display: block;
    }
    .dis-pc{
        display: none;
    }
    .StepBox-882-sm {
        text-align: center;
    }
    .StepBox-BE4-sm{
        text-align: center;
    }
    .fa-list-check{
        color:#fff;
        font-size: 65px;
    }
    .fa-map-location-dot{
        color:#fff;
        font-size: 65px;
    }
    .fa-paper-plane{
        color:#fff;
        font-size: 65px;
    }
}

@media (min-width: 768px) and (max-width: 9999px){
    .dis-mobile{
        display: none;
    }
    .dis-pc{
        display: block;
    }
   
}

::placeholder {
    font-weight: bold;
}
.arrow-right-BE4-sm {
  width: 0;
  height: 0;
  border-right: 30px solid transparent;
  border-top: 30px solid #BE4EC3;
  border-left: 30px solid transparent;

  position: absolute;
  left: 42%;

}
.arrow-right-822-sm {
  width: 0;
  height: 0;
  border-right: 30px solid transparent;
  border-top: 30px solid #82288c;
  border-left: 30px solid transparent;

  position: absolute;
  left: 42%;
}

.StepBox-882-sm{
 background-color: #82288c;
}
.StepBox-BE4-sm{
 background-color: #be4ec3;
}
.StepBox-882-sm{
 background-color: #82288c;
}

.form-control{
    border: 1px solid #981c9d !important;
    border-radius: 5px !important;
}

</style>

<!-- แถบสีน้ำเงินหัวข้อข่าวสาร PC -->
<div class="dis-pc">
    <div class="container-fluid mar-spacehead" style="background-color: #F1EDEA">
        <div class="container ">
            <form id="contact-form" action="#" method="post" role="form">
                <div class="error-container"></div>
                <div class="row">
                    <h1 class="col-12 text-center h2-color font-h-search  pt-4 pb-4">
                        ขอหนังสือรับรอง
                    </h1>
                </div>
            </form>
        </div>
    </div>

    <div class="d-flex ">
        <div class="p-2 StepBox-882 p-3 ">

            <h3 class="mt-2 mb-0"><i class=" justify-content-center fa fa-bars"></i></h3>
            <h4 class="mt-0">เลือกแบบฟอร์ม</h4>
            <p class="white-text">ระบุจำนวนหนังสือรับรองที่คุณต้องการ จากนั้นกดปุ่ม "เพิ่มรายการ"</p>
            <div class="arrow-right-822"></div>
        </div>
        <div class="p-2 StepBox-BE4  p-3">
            <h3 class="mt-2 mb-0"><i class="fa fa-home"></i></h3>
            <h4 class="mt-0">ระบุสถานที่รับ</h4>
            <p class="white-text">รายการคำขอ จะปรากฏใน “รายการหนังสือที่ร้องขอ”
                จากนั้นเลือกสถานที่จัดส่ง</p>
            <div class="arrow-right-BE4"></div>
        </div>
        <div class="p-2 StepBox-882  p-3">
            <h3 class="mt-2 mb-0"><i class="fa fa-paper-plane"></i></h3>
            <h4 class="mt-0">ส่งคำขอ</h4>
            <p class="white-text">คลิกปุ่มส่งคำขอ โดยคุณสามารถตรวจสอบสถานะคำขอต่างๆได้ใน
                "จัดการภารกิจ"</p>
        </div>
    </div>
</div>

<!-- Mobile -->
<div class="dis-mobile">
    <div class="container-fluid mar-spacehead" style="background-color: #F1EDEA" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
        <div class="container ">
            <form id="contact-form" action="#" method="post" role="form">
                <div class="error-container"></div>
                <div class="row">
                    <h1 class="col-12 text-center h2-color font-h-search  pt-4 pb-4">
                        ขอหนังสือรับรอง
                    </h1>
                </div>
            </form>
        </div>
    </div>
    <div class="collapse" id="collapseExample">
        <div class="d-block ">
            <div class="p-2 StepBox-882-sm p-3 ">

                <h3 class="mt-2 mb-0"><i class=" justify-content-center fa fa-file"></i></h3>
                <h4 class="mt-0 text-white">เลือกแบบฟอร์ม</h4>
                <p class="text-white">ระบุจำนวนหนังสือรับรองที่คุณต้องการ จากนั้นกดปุ่ม "เพิ่มรายการ"</p>
                <div class="arrow-right-822-sm"></div>
            </div>
            <div class="p-2 StepBox-BE4-sm  p-3">
                <h3 class="mt-2 mb-0"><i class="fa-solid fa-map-location-dot"></i></h3>
                <h4 class="mt-0 text-white">ระบุสถานที่รับ</h4>
                <p class="text-white">รายการคำขอ จะปรากฏใน “รายการหนังสือที่ร้องขอ”
                    จากนั้นเลือกสถานที่จัดส่ง</p>
                <div class="arrow-right-BE4-sm"></div>
            </div>
            <div class="p-2 StepBox-882-sm  p-3">
                <h3 class="mt-2 mb-0"><i class="fa-solid fa-paper-plane"></i></h3>
                <h4 class="mt-0 text-white">ส่งคำขอ</h4>
                <p class="text-white">คลิกปุ่มส่งคำขอ โดยคุณสามารถตรวจสอบสถานะคำขอต่างๆได้ใน
                    "จัดการภารกิจ"</p>
            </div>
        </div>
    </div>
</div>


<!-- News index page -->
<form method="post" enctype="multipart/form-data"  id="form_wf">
	<input type="hidden" name="COUNT_NO" value="<?php echo $getRequestCertificateList['Data']['COUNT'];?>">
	<input type="hidden" name="REQ_NO" value="<?php echo $getRequestCertificateList['Data']['REQ_NO'];?>">
	<input type="hidden" name="YEAR" value="<?php echo $getRequestCertificateList['Data']['YEAR'];?>">
	<input type="hidden" name="USR_USERNAME" value="<?php echo $_SESSION['EWT_USERNAME'];?>">
	<input type="hidden" name="FULL_NAME" value="<?php echo $FULL_NAME;?>">
	<input type="hidden" name="FULL_NAME_EN" value="<?php echo $FULL_NAME_EN;?>">
	<input type="hidden" name="POS_NAME" value="<?php echo $POS_NAME;?>">
	<input type="hidden" name="DEP_NAME" value="<?php echo $DEP_NAME;?>">
	<input type="hidden" name="DEP_NAME2" value="<?php echo $DEP_NAME2;?>">
	<input type="hidden" name="PER_TYPE_NAME" value="<?php echo $PER_TYPE_NAME;?>">
	<input type="hidden" name="POS_LEVEL_NAME" value="<?php echo $POS_LEVEL_NAME;?>">
	<input type="hidden" name="INCOME_MONEY" value="<?php echo $INCOME_MONEY;?>">
	<input type="hidden" name="PAYROLL_MONEY" value="<?php echo $PAYROLL_MONEY;?>">
	<input type="hidden" name="DATE_NOW_TH" value="<?php echo $DATE_NOW_TH;?>">
	<input type="hidden" name="DATE_NOW_EN" value="<?php echo $DATE_NOW_EN;?>">
<div class="shadow-sm container-fluid Knowledge-bg-head ">
    <div class="container pb-3 ">
        <h2 class="h2-color pt-4">
            แบบฟอร์มหนังสือรับรอง
        </h2>
        <h5 class="h2-color"><a href="profile.php">ข้อมูลผู้ใช้งาน > </a> <span>กิจกรรม</span></h5>
        <hr class="hr_news mt-0">

        <div class="row">
            <div class="col-lg-7 col-md-12 col-sm-12 col-12 mb-3">
                <h3><i class="fa fa-file"></i> เลือกแบบฟอร์มที่ต้องการร้องขอหนังสือรับรอง</h3>
                <div class="row">
                    <!-- รูปหนังสือรับรอง -->
                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                        <img src="images/imgcer.jpg" class="img-fluid" alt="Responsive image">
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                        <h4 class="mt-3">1. ข้อมูลหนังสือรับรอง</h4>
                        <div class="row">
                            <div class="col-lg-5 col-md-5 col-sm-12 col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheckSalary">
                                    <label class="form-check-label" for="defaultCheckSalary">
                                        เงินเดือน
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-12 col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheckWork">
                                    <label class="form-check-label" for="defaultCheckWork">
                                        ระยะเวลาทำงาน
                                    </label>
                                </div>
                            </div>
                        </div>

                        <h4 class="mt-3">2. ภาษาของหนังสือรับรอง</h4>
                        <div class="row">
                            <div class="col-lg-5 col-md-5 col-sm-12 col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="" id="defaultCheckThai" name="languageCheck">
                                    <label class="form-check-label" for="defaultCheckThai"> ภาษาไทย
                                    </label>
                                </div>
								
								
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-12 col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="" id="defaultCheckEng" name="languageCheck">
                                    <label class="form-check-label" for="defaultCheckEng"> ภาษาอังกฤษ
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!--<h4 class="mt-3">3. จำนวนที่ต้องการ</h4>-->
                        
                        <!-- <div class="input-group plus-minus-input">
                            <div class="input-group-button">
                                <button type="button" class="button hollow circle" data-quantity="minus" data-field="quantity">
                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                </button>
                            </div>
                            <input class="input-group-field plus-minus-style" type="number" id="quantity" name="quantity" value="0">
                            <div class="input-group-button ">
                                <button type="button " class="button hollow circle " data-quantity="plus" data-field="quantity">
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div> -->
						
						<!-- Change the `data-field` of buttons and `name` of input field's for multiple plus minus buttons-->

                        <div class="mt-3">
                            <!--<a href="#" id="rowAdder" class="px-5 btn Gradient-Color border-ra-15px white-text  btn-sm">เพิ่มรายการ</a>-->
							<button type="button" class="btn Gradient-Color border-ra-15px white-text  btn-sm" id="rowAdder" style="width:165px;">เพิ่มรายการ</button>
                        </div>
                    </div>

                </div>
            </div>
			
            <!-- รายการหนังสือที่ร้องขอ -->
            <div class="col-lg-5 col-md-12 col-sm-12 col-12 bg-color-book">
                <h4 class="mt-2 mb-2"><i class="fa fa-file"></i> รายการหนังสือที่ร้องขอ</h4>
				
				<div  id="newinput"></div>
				
                <!--<div class="row" id="Button1">
                    <div class="col-lg-4 col-md-3 col-sm-3 col-4 mb-3">
                        <img src="images/imgcer.jpg" class="img-fluid" alt="Responsive image">
                    </div>
                    <div class="col-lg-8 col-md-9 col-sm-9 col-8" >
                        <h5 class="h2-color m-0">หนังสือรับรองระยะเวลาทำงาน </h5>
                        <h5 class="h2-color m-0">หนังสือรับรองเงินเดือน</h5>
                        <p class=" m-0">(ภาษาไทย, ภาษาอังกฤษ)</p>
                        <p class=" m-0">จำนวน 2 รายการ</p>
                           
                            <button class="mt-2 px-3 btn  border-ra-15px btn-light " onclick="window.open('PDF/demo.pdf', '_blank',);"><i class="fa-solid fa-magnifying-glass"></i> ดูตัวอย่าง</button>                           
                            <span><a href="#" class="mt-2 px-3 btn  border-ra-15px btn-danger btn-sm "  onclick="delname()"><i class="fa-regular fa-trash-can"></i> ลบออก</a></span>

                        </div>
                    <hr>
                </div>
                <div class="row" id="Button2">
                <div class="col-lg-4 col-md-3 col-sm-3 col-4 mb-3">
                        <img src="images/imgcer.jpg" class="img-fluid" alt="Responsive image">
                    </div>
                    <div class="col-lg-8 col-md-9 col-sm-9 col-8 ">
                        <h5 class="h2-color m-0">หนังสือรับรองเงินเดือน</h5>
                        <p class=" m-0">(ภาษาไทย)</p>
                        <p class=" m-0">จำนวน 1 รายการ</p>


                        <button class="mt-2 px-3 btn  border-ra-15px btn-light btn-sm" onclick="window.open('PDF/demo.pdf', '_blank',);"><i class="fa-solid fa-magnifying-glass"></i> ดูตัวอย่าง</button>       
                        <span><a href="#" class="mt-2 px-3 btn  border-ra-15px btn-danger btn-sm" onclick="delname2()"><i class="fa-regular fa-trash-can"></i> ลบออก</a></span>
                    </div>
                    <hr>
                </div>-->

                <div>
                    <h4 class="mt-2 mb-2"><font color="FF0000">*</font> สถานที่ในการจัดส่ง</h4>
					<?php  foreach ($getLocationSend['Data'] as $key => $value) { ?>
						<div class="form-check form-check-inline ml-2">
							<input required class="form-check-input" type="radio" name="LOCATION" id="LOCATION" value="<?php echo $key;?>">
							<label class="form-check-label" for="inlineRadio1"><?php echo $value['LOCATION_NAME'];?></label>
						</div>
					<?php } ?>
                    <!--<div class="form-check form-check-inline ml-2">
                        <input class="form-check-input" type="radio" name="LOCATION" id="LOCATION" value="option1">
                        <label class="form-check-label" for="inlineRadio1">พระราม 4</label>
                    </div>
                    <div class="form-check form-check-inline ml-2">
                        <input class="form-check-input" type="radio" name="LOCATION" id="LOCATION" value="option2">
                        <label class="form-check-label" for="inlineRadio2">พระราม 6</label>
                    </div>
                    <div class="form-check form-check-inline ml-2">
                        <input class="form-check-input" type="radio" name="LOCATION" id="LOCATION" value="option3">
                        <label class="form-check-label" for="inlineRadio3">ศูนย์ภูมิภาค)</label>
                    </div>-->
					
                    <h4 class="mt-2 mb-2"><font color="FF0000">*</font> เบอร์โทรศัพท์</h4>
                    <form>
                        <div class="form-row">
                            <div class="col ">
                                <input required id="TELEPHONE" name="TELEPHONE" type="phone" class="form-control" placeholder="เบอร์ที่สะดวกในการติดต่อ" VALUE="<?php echo $chk['USR_TEL'];?>">
                            </div>
                        </div>
                    <h4 class="mt-2 mb-2"><font color="FF0000">*</font> เบอร์โทรศัพท์มือถือ</h4>
                        <div class="form-row">
                            <div class="col ">
                                <input required id="PHONE" name="PHONE" type="phone" class="form-control" placeholder="เบอร์ที่สะดวกในการติดต่อ" VALUE="<?php echo $chk['USR_TEL_PHONE'];?>">
                            </div>
                        </div>
                    </form>
					
                    <h4 class="mt-2 mb-2"><font color="FF0000">*</font> วัตถุประสงค์</h4>
                    <div class="form-row ">
                        <select required id="OBJECTIVE" name="OBJECTIVE" class="form-control mb-2" placeholder="-- กรุณาเลือก --">
                            <option  value="" selected>-- กรุณาเลือก --</option>
                            <?php 
							foreach ($getObjectiveRequestCertificate['Data'] as $key => $value) {
								echo "<option value=" . $key . ">" . $value['OBJ_NAME'] . "</option>";
							}
							?>
                        </select>
                    </select>
						
						
						
                    </div>
					
					<button id="submit" type="submit" data-toggle="modal" class="mt-2 mb-6 px-3 btn d-flex 
				justify-content-center  border-ra-15px Gradient-Color text-white btn-sm" style="width:100%;">ส่งคำขอ</button>
                </div>

            </div>
			
			

        </div>





    </div>

</div>
</form>


<!-- Large modal -->
<!--
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="container ">
                <h2 class="h2-color pt-4">
                    หนังสือรับรอง
                </h2>
                <hr class="hr_news mt-3">
                <div class="container">
					
					
					
                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-sm-12 col-12 pb-4">
                            <h3 class="h2-color">รายการที่ขอหนังสือรับรอง</h3>
                            <div class="row">
                                <div class="col-lg-4 col-md-3 col-sm-3 col-4 mb-3">
                                    <img src="images/imgcer.jpg" class="img-fluid" alt="Responsive image">
                                </div>
                                <div class="col-lg-8 col-md-9 col-sm-9 col-8 ">
                                    <h5 class="h2-color m-0">หนังสือรับรองระยะเวลาทำงาน </h5>
                                    <h5 class="h2-color m-0">หนังสือรับรองเงินเดือน</h5>
                                    <p class=" m-0">(ภาษาไทย, ภาษาอังกฤษ)</p>
                                    <p class=" m-0">จำนวน 2 รายการ</p>

                                </div>
                                <hr>

                                <div class="col-lg-4 col-md-3 col-sm-3 col-4 mb-3">
                                    <img src="images/imgcer.jpg" class="img-fluid" alt="Responsive image">
                                </div>
                                <div class="col-lg-8 col-md-9 col-sm-9 col-8 ">
                                    <h5 class="h2-color m-0">หนังสือรับรองเงินเดือน</h5>
                                    <p class=" m-0">(ภาษาไทย)</p>
                                    <p class=" m-0">จำนวน 1 รายการ</p>

                                </div>
                                <hr>

                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-12 ">
                            <h3 class="h2-color">ส่งคำขอหนังสือรับรองเรียบร้อยแล้ว</h3>
                            <div class="d-flex justify-content-center">
                                <img src="images/wrong.png" class="d-block w-50 " alt="...">
                            </div>
                            <button type="button" class="btn-search btn Gradient-Color shadow-sm btn-sm mb-3"> เสร็จสิ้น</button>
                        </div>
                    </div>
                </div>


            </div>

        </div>
    </div>
</div>
-->



<?php include('footer.php'); ?>
<!-- Footer Website -->
<?php include('combottom.php'); ?>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> <!-- script time format -->
<script src="https://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js" type="text/javascript"></script> <!-- script time format -->

<!-- PLUS MINUS BUTTONS JS -->
<script>
jQuery(document).ready(function() {
	let x = 0;
	// $('#rowAdder').attr('disabled', 'disabled');
	
        // This button will increment the value
        $('[data-quantity="plus"]').click(function(e) {
		x += 1;
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
			// if(x > 0){
				// $('#rowAdder').removeAttr("disabled");
			// }
	
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
				x -= 1;
            } else {
                // Otherwise put a 0 there
                $('input[name=' + fieldName + ']').val(0);
            }
			if(x == 0){
				$('#rowAdder').attr('disabled', 'disabled');
			}
        });
		
		
	
	let i = 0;
	// var quantity  = $('#quantity').val();
	$("#rowAdder").click(function () {
	i += 1;
	var chk_salary = '0';
	var chk_work = '0';
	var chk_th = '0';
	var chk_en = '0';
	var text_salary = '';
	var text_work = '';
	var text_th = '';
	var text_en = '';
	var text_salary_th = '';
	var text_salary_en = '';
	var text_work_th = '';
	var text_work_en = '';
	var cer_preview = '';//certificate_salary_th_preview.pdf
	var text = " ' ";
	
	// ADD VALUE
	/* if (document.getElementById('defaultCheckSalary').checked == true) {
		chk_salary = '1';
		// text_salary = '<h5 class="h2-color m-0">หนังสือรับรองเงินเดือน</h5>';
			if (document.getElementById('defaultCheckThai').checked == true) {
				chk_th = '1';
				text_salary_th = '<h5 class="h2-color m-0">หนังสือรับรองที่มีการระบุเฉพาะเงินเดือน (ภาษาไทย) <a style="width:80px;text-align:center;" type="button" class="border-ra-15px btn-light " onclick="window.open('+text+'FILE_PDF/certificate_salary_th_preview_pdf.php'+text+', '+text+'_blank'+text+',);" ><i class="fa fa-eye"></i> ดูตัวอย่าง</a></h5>';//<i class="fa-solid fa-magnifying-glass"></i>
			}
			if (document.getElementById('defaultCheckEng').checked == true) {
				chk_en = '1';
				text_salary_en = '<h5 class="h2-color m-0">หนังสือรับรองที่มีการระบุเฉพาะเงินเดือน (ภาษาอังกฤษ) <a style="width:80px;text-align:center;" type="button" class="border-ra-15px btn-light " onclick="window.open('+text+'FILE_PDF/certificate_salary_en_preview_pdf.php'+text+', '+text+'_blank'+text+',);" ><i class="fa fa-eye"></i> ดูตัวอย่าง</a></h5>';
			}
	} 
	if (document.getElementById('defaultCheckWork').checked == true) {
		chk_work = '1';
			if (document.getElementById('defaultCheckThai').checked == true) {
				chk_th = '1';
				text_work_th = '<h5 class="h2-color m-0">หนังสือรับรองที่มีการระบุเฉพาะระยะเวลาทำงาน (ภาษาไทย) <a style="width:80px;text-align:center;" type="button" class="border-ra-15px btn-light " onclick="window.open('+text+'FILE_PDF/certificate_work_th_preview_pdf.php'+text+', '+text+'_blank'+text+',);" ><i class="fa fa-eye"></i> ดูตัวอย่าง</a></h5>';//<i class="fa-solid fa-magnifying-glass"></i>
			} 
			if (document.getElementById('defaultCheckEng').checked == true) {
				chk_en = '1';
				text_work_en = '<h5 class="h2-color m-0">หนังสือรับรองที่มีการระบุเฉพาะระยะเวลาทำงาน (ภาษาอังกฤษ) <a style="width:80px;text-align:center;" type="button" class="border-ra-15px btn-light " onclick="window.open('+text+'FILE_PDF/certificate_work_en_preview_pdf.php'+text+', '+text+'_blank'+text+',);" ><i class="fa fa-eye"></i> ดูตัวอย่าง</a></h5>';
			}
	}  */
	
	// CHECK ทั้ง เงินเดือน กับ ระยะเวลาทำงาน
	if (document.getElementById('defaultCheckSalary').checked == true && document.getElementById('defaultCheckWork').checked == true) {
		chk_salary = '1';
		chk_work = '1';
		// text_salary = '<h5 class="h2-color m-0">หนังสือรับรองเงินเดือน</h5>';
			if (document.getElementById('defaultCheckThai').checked == true) {
				chk_th = '1';
				text_salary_th = '<h5 class="h2-color m-0">หนังสือรับรองที่มีการระบุเงินเดือนและระยะเวลาทำงาน (ภาษาไทย) <a style="width:80px;text-align:center;" type="button" class="border-ra-15px btn-light " onclick="window.open('+text+'FILE_PDF/certificate_salary&work_th_preview_pdf.php?FULL_NAME='+$('input[name=FULL_NAME]').val()+'&FULL_NAME_EN='+$('input[name=FULL_NAME_EN]').val()+'&POS_NAME='+$('input[name=POS_NAME]').val()+'&DEP_NAME='+$('input[name=DEP_NAME]').val()+'&DEP_NAME2='+$('input[name=DEP_NAME2]').val()+'&PER_TYPE_NAME='+$('input[name=PER_TYPE_NAME]').val()+'&INCOME_MONEY='+$('input[name=INCOME_MONEY]').val()+'&PAYROLL_MONEY='+$('input[name=PAYROLL_MONEY]').val()+'&POS_LEVEL_NAME='+$('input[name=POS_LEVEL_NAME]').val()+'&DATE_NOW_TH='+$('input[name=DATE_NOW_TH]').val()+''+text+', '+text+'_blank'+text+',);" ><i class="fa fa-eye"></i> ดูตัวอย่าง</a></h5>';//<i class="fa-solid fa-magnifying-glass"></i>
			}
			if (document.getElementById('defaultCheckEng').checked == true) {
				chk_en = '1';
				text_salary_en = '<h5 class="h2-color m-0">หนังสือรับรองที่มีการระบุเงินเดือนและระยะเวลาทำงาน (ภาษาอังกฤษ) <a style="width:80px;text-align:center;" type="button" class="border-ra-15px btn-light " onclick="window.open('+text+'FILE_PDF/certificate_salary&work_en_preview_pdf.php?FULL_NAME_EN='+$('input[name=FULL_NAME_EN]').val()+'&POS_NAME='+$('input[name=POS_NAME]').val()+'&DEP_NAME='+$('input[name=DEP_NAME]').val()+'&DEP_NAME2='+$('input[name=DEP_NAME2]').val()+'&PER_TYPE_NAME='+$('input[name=PER_TYPE_NAME]').val()+'&INCOME_MONEY='+$('input[name=INCOME_MONEY]').val()+'&PAYROLL_MONEY='+$('input[name=PAYROLL_MONEY]').val()+'&POS_LEVEL_NAME='+$('input[name=POS_LEVEL_NAME]').val()+'&DATE_NOW_EN='+$('input[name=DATE_NOW_EN]').val()+''+text+', '+text+'_blank'+text+',);" ><i class="fa fa-eye"></i> ดูตัวอย่าง</a></h5>';
			}
	// CHECK เงินเดือน แต่ไม่ CHECK ระยะเวลาทำงาน
	}else if (document.getElementById('defaultCheckSalary').checked == true && document.getElementById('defaultCheckWork').checked == false) {
		chk_salary = '1';
		// text_salary = '<h5 class="h2-color m-0">หนังสือรับรองเงินเดือน</h5>';
			if (document.getElementById('defaultCheckThai').checked == true) {
				chk_th = '1';
				text_salary_th = '<h5 class="h2-color m-0">หนังสือรับรองที่มีการระบุเฉพาะเงินเดือน (ภาษาไทย) <a style="width:80px;text-align:center;" type="button" class="border-ra-15px btn-light " onclick="window.open('+text+'FILE_PDF/certificate_salary_th_preview_pdf.php?FULL_NAME='+$('input[name=FULL_NAME]').val()+'&POS_NAME='+$('input[name=POS_NAME]').val()+'&DEP_NAME='+$('input[name=DEP_NAME]').val()+'&DEP_NAME2='+$('input[name=DEP_NAME2]').val()+'&PER_TYPE_NAME='+$('input[name=PER_TYPE_NAME]').val()+'&INCOME_MONEY='+$('input[name=INCOME_MONEY]').val()+'&PAYROLL_MONEY='+$('input[name=PAYROLL_MONEY]').val()+'&POS_LEVEL_NAME='+$('input[name=POS_LEVEL_NAME]').val()+'&DATE_NOW_TH='+$('input[name=DATE_NOW_TH]').val()+''+text+', '+text+'_blank'+text+',);" ><i class="fa fa-eye"></i> ดูตัวอย่าง</a></h5>';//<i class="fa-solid fa-magnifying-glass"></i>
			}
			if (document.getElementById('defaultCheckEng').checked == true) {
				chk_en = '1';
				text_salary_en = '<h5 class="h2-color m-0">หนังสือรับรองที่มีการระบุเฉพาะเงินเดือน (ภาษาอังกฤษ) <a style="width:80px;text-align:center;" type="button" class="border-ra-15px btn-light " onclick="window.open('+text+'FILE_PDF/certificate_salary_en_preview_pdf.php?FULL_NAME_EN='+$('input[name=FULL_NAME_EN]').val()+'&POS_NAME='+$('input[name=POS_NAME]').val()+'&DEP_NAME='+$('input[name=DEP_NAME]').val()+'&DEP_NAME2='+$('input[name=DEP_NAME2]').val()+'&PER_TYPE_NAME='+$('input[name=PER_TYPE_NAME]').val()+'&INCOME_MONEY='+$('input[name=INCOME_MONEY]').val()+'&PAYROLL_MONEY='+$('input[name=PAYROLL_MONEY]').val()+'&POS_LEVEL_NAME='+$('input[name=POS_LEVEL_NAME]').val()+'&DATE_NOW_EN='+$('input[name=DATE_NOW_EN]').val()+''+text+', '+text+'_blank'+text+',);" ><i class="fa fa-eye"></i> ดูตัวอย่าง</a></h5>';
			}
	// CHECK ระยะเวลาทำงาน แต่ไม่ CHECK เงินเดือน
	}else if (document.getElementById('defaultCheckWork').checked == true && document.getElementById('defaultCheckSalary').checked == false) {
		chk_work = '1';
		// text_salary = '<h5 class="h2-color m-0">หนังสือรับรองเงินเดือน</h5>';
			if (document.getElementById('defaultCheckThai').checked == true) {
				chk_th = '1';
				text_salary_th = '<h5 class="h2-color m-0">หนังสือรับรองที่มีการระบุเฉพาะระยะเวลาทำงาน (ภาษาไทย) <a style="width:80px;text-align:center;" type="button" class="border-ra-15px btn-light " onclick="window.open('+text+'FILE_PDF/certificate_work_th_preview_pdf.php?FULL_NAME='+$('input[name=FULL_NAME]').val()+'&POS_NAME='+$('input[name=POS_NAME]').val()+'&DEP_NAME='+$('input[name=DEP_NAME]').val()+'&DEP_NAME2='+$('input[name=DEP_NAME2]').val()+'&PER_TYPE_NAME='+$('input[name=PER_TYPE_NAME]').val()+'&INCOME_MONEY='+$('input[name=INCOME_MONEY]').val()+'&PAYROLL_MONEY='+$('input[name=PAYROLL_MONEY]').val()+'&POS_LEVEL_NAME='+$('input[name=POS_LEVEL_NAME]').val()+'&DATE_NOW_TH='+$('input[name=DATE_NOW_TH]').val()+''+text+', '+text+'_blank'+text+',);" ><i class="fa fa-eye"></i> ดูตัวอย่าง</a></h5>';//<i class="fa-solid fa-magnifying-glass"></i>
			}
			if (document.getElementById('defaultCheckEng').checked == true) {
				chk_en = '1';
				text_salary_en = '<h5 class="h2-color m-0">หนังสือรับรองที่มีการระบุเฉพาะระยะเวลาทำงาน (ภาษาอังกฤษ) <a style="width:80px;text-align:center;" type="button" class="border-ra-15px btn-light " onclick="window.open('+text+'FILE_PDF/certificate_work_en_preview_pdf.php?FULL_NAME_EN='+$('input[name=FULL_NAME_EN]').val()+'&POS_NAME='+$('input[name=POS_NAME]').val()+'&DEP_NAME='+$('input[name=DEP_NAME]').val()+'&DEP_NAME2='+$('input[name=DEP_NAME2]').val()+'&PER_TYPE_NAME='+$('input[name=PER_TYPE_NAME]').val()+'&INCOME_MONEY='+$('input[name=INCOME_MONEY]').val()+'&PAYROLL_MONEY='+$('input[name=PAYROLL_MONEY]').val()+'&POS_LEVEL_NAME='+$('input[name=POS_LEVEL_NAME]').val()+'&DATE_NOW_TH='+$('input[name=DATE_NOW_TH]').val()+''+text+', '+text+'_blank'+text+',);" ><i class="fa fa-eye"></i> ดูตัวอย่าง</a></h5>';
			}
	} 
	
	
	
	
	// CHECK
	if(chk_work != '1' && chk_salary != '1'){
		alert('กรุณาเลือก 1. ข้อมูลหนังสือรับรอง');
		return false;
	}
	if(chk_th != '1' && chk_en != '1'){
		alert('กรุณาเลือก 2. ภาษาของหนังสือรับรอง');
		return false;
	}
		
	document.getElementById("defaultCheckSalary").checked = false;
	document.getElementById("defaultCheckWork").checked = false;
	document.getElementById("defaultCheckThai").checked = false;
	document.getElementById("defaultCheckEng").checked = false;
	
		newRowAdd =
		'<div id="row"  class="form-row align-items-center">' +
		'<div class="col-lg-4 col-md-3 col-sm-3 col-4 mb-3">' +
			' <img src="images/imgcer.jpg" class="img-fluid" alt="Responsive image">' +
		'</div>' +
		'<div class="col-lg-8 col-md-9 col-sm-9 col-8" >' +
			text_salary_th +
			text_salary_en +
			text_work_th +
			text_work_en +
			'<input type="hidden" id="CHECK_SALARY" name="CHECK_SALARY[]" value="'+chk_salary+'">' +
			'<input type="hidden" id="CHECK_WORK" name="CHECK_WORK[]" value="'+chk_work+'">' +
			'<input type="hidden" id="CHECK_TH" name="CHECK_TH[]" value="'+chk_th+'">' +
			'<input type="hidden" id="CHECK_EN" name="CHECK_EN[]" value="'+chk_en+'">' +
			// '<p class=" m-0" id="COUNT_TOTAL">จำนวน '+ '<input type="number" id="COUNT" name="COUNT[]" min="1" value="'+x+'" style="width: 80px">' +' รายการ</p>' +
			'<p class=" m-0" id="COUNT_TOTAL">จำนวน '+ '<input type="number" id="COUNT" name="COUNT[]" min="1" value="1" style="width: 80px">' +' รายการ</p>' +
			
			// '<a class="mt-2 px-3 btn  border-ra-15px btn-light " onclick="window.open('+text+'PDF/demo.pdf'+text+', '+text+'_blank'+text+',);"><i class="fa-solid fa-magnifying-glass"></i> ดูตัวอย่าง</a>' + 

			'<span><a style="margin-left:10px;" class="mt-2 px-3 btn  border-ra-15px btn-danger btn-sm "  id="DeleteRow"><i class="fa-regular fa-trash-can"></i> ลบออก</a></span>' +
		'</div>';
		
		$('#newinput').append(newRowAdd);
		// alert($('#CHECK_SALARY').length);
	});
	
	$("body").on("click", "#DeleteRow", function () {
		i -= 1;
		$(this).parents("#row").remove();
	})
		
		
		
   });
</script>

<script>
	$(document).ready(function() {
		$('#form_wf').submit(function(e) {
			
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
							url: 'save/insert_request_certificate.php',
							type: 'POST',
							data: $('#form_wf').serialize() ,
							success: function(data) {
								if (data == 1) {
									Swal.fire(
										'ส่งข้อมูลสำเร็จ',
										' ',
										'success'
										
									).then(function() {
										window.location = "Request_Certificate.php";
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

	});
</script>

<!-- Include file js and properties -->