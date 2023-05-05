<?php include('comtop.php'); ?>
<!-- Include file css and properties -->
<?php include('header.php'); ?>
<!-- Menu and Logo -->
<?php include('callservice.php'); ?>
<!-- CALL SERVICE -->

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
</style>

<?php
$today = "";
if($_GET["trip-start"] == '' || ($_GET["trip-start"] == '' && $_GET["trip-end"] == '') ){
	$today = date('Y-m-d');
}
$data_request = array(
						// "today" => '2023-01-12',
						// "today" => $today, 
						"amount" => $_GET["tentacles"],
						"trip_start" => $_GET["trip-start"],
						"trip_end" => $_GET["trip-end"],
						"time_start" => $_GET["time-start"],
						"time_end" => $_GET["time-end"],
						// "time_end" => '09:04',
					);
$getRoomList = callAPI('getRoomList',$data_request);

dbdpis::ConnectDB(SSO_DB_NAME, SSO_DB_TYPE, SSO_ROOT_HOST, SSO_ROOT_USER, SSO_ROOT_PASSWORD, SSO_DB_NAME, SSO_CHAR_SET);
// GET DEP_LV1_ID, DEP_LV2_ID
		$chk_per_type = "SELECT B.*, C.DEP_NAME AS DEP_NAME1, D.DEP_NAME AS DEP_NAME2
						FROM USR_MAIN A
						LEFT JOIN M_PER_PROFILE B ON B.PER_IDCARD = A.USR_OPTION3
						LEFT JOIN USR_DEPARTMENT C ON C.DEP_ID = B.DEP_LV1_ID
						LEFT JOIN USR_DEPARTMENT D ON D.DEP_ID = B.DEP_LV2_ID
						WHERE A.USR_USERNAME = '".$_SESSION['EWT_USERNAME']."' ";
		$q = dbdpis::execute($chk_per_type);
		$chk = dbdpis::Fetch($q);
$data_session = array(
						"userName" 		=> $_SESSION["EWT_USERNAME"],
						"usrFname" 		=> $_SESSION["EWT_NAME"],
						"usrLname" 		=> $_SESSION["EWT_SURNAME"],
						"dep_lv1_name" 	=> $chk["DEP_NAME1"],
						"dep_lv2_name" 	=> $chk["DEP_NAME2"],
					);
$insertUsrMain = callAPI('insertUsrMain', $data_session);
 // echo '<pre>';
 // print_r($getRoomList);
 // echo '</pre>'; 
/* format date input 2019-11-01 return 1 / ม.ค. / 2500 */

function convert_ex_date($date,$lang="TH"){
	$thai_date = array('','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์','อาทิตย์');
	$thai_month = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
	$sub_thai_month = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");

	if($date != ''){
		$date_start = new DateTime($date);
		$d_date 	= $date_start->format("d"); //เลขวันที่มีเลข 0 เช่น 01
		$j_date 	= $date_start->format("j"); //เลขวันที่ไม่มีเลข 0
		$t_date 	= $date_start->format("N"); //คืนค่าเป็นเลข นำค่าไปเทียบเลขในอาเรย์ ค่าที่คืน 1 - 7 โดยที่ 1 เริ่มที่ Monday
		$month 		= $date_start->format("m");
		$year 		= $date_start->format("Y")+543;
		if($lang == "TH"){
			$return["d_date"]	=	$d_date;
			$return["j_date"]	=	$j_date;
			$return["t_date"] 	= 	$thai_date[$t_date];
			$return["t_month"]	=	$thai_month[($month*1)];
			$return["s_t_month"]=	$sub_thai_month[($month*1)];
			$return["n_month"]	=	$month;
			$return["year"]		=	$year;
		}else if($lang == "EN"){

		}
		return $return;
	}
}
function get_TH_Date2($date){
	$txt_date = convert_ex_date($date,$lang="TH");
	$some_txt_date = $txt_date["j_date"]." ".$txt_date["s_t_month"]." ".$txt_date["year"];
	return $some_txt_date;
}
?>


<!-- แถบค้นหา -->
<form id="form_wf" action="Booking_room.php" method="get" role="form">

<div class="container-fluid meeting-bg px-0 shadow">

    <div class=" mar-spacehead  shadow-sm" style="background-color:rgba(241, 237, 234, 0.8) ;">

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

    <div class="container ">
        <h5 class="h2-color mt-4 "><a href="index.php">หน้าแรก > </a> <span>จองห้องประชุม</span></h5>
        <hr class="hr_news mt-0">
        <div class="row mb-3 ">

            <div class="col-lg-4 col-md-6 col-sm-12 col-12 mb-2  px-2">
                <div class=" Datepick-start-stop ">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-6 ">
                            <h5 class="ml-2 mb-0"><i class="fa fa-calendar"></i> วันเริ่มต้น</h5>
                            <input class="mt-0 ml-2 pb-1 border-0" type="date" id="trip-start" name="trip-start" value="<?php echo $_GET["trip-start"];?>" >
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-6 ">
                            <h5 class="ml-2 mb-0"><i class="fa fa-calendar"></i> วันที่สิ้นสุด</h5>
                            <input class="mt-0 ml-2 pb-1 border-0" type="date" id="trip-end" name="trip-end" value="<?php echo $_GET["trip-end"];?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-2 px-2">
                <div class="Datepick-start-stop px-2">
                    <div class="row  ">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-6 pl-3 px-2">
                            <h5 class="ml-0 mb-0  h2-color "><i class="fa fa-clock"></i> เวลาเริ่มต้น</h5>
							<input class="mt-0 pl-0 ml-0 timeFormat"  type="time"  id="time-start" name="time-start" placeholder = "__:__" value="<?php echo $_GET["time-start"];?>">
							<!--<form><input class="mt-0 pl-0 ml-0 timeFormat" style="width:100px;" type="text" id="time-start" name="time-start" placeholder = "__:__"></form>-->
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-6 px-2" >
                            <h5 class="ml-0 mb-0  h2-color"><i class="fa fa-clock"></i> เวลาสิ้นสุด</h5>
							<input class="mt-0 pl-0 ml-0 timeFormat" type="time" id="time-end" name="time-end"  placeholder = "__:__" value="<?php echo $_GET["time-end"];?>">
							<!-- <form> <input class="mt-0 pl-0 ml-0 timeFormat" style="width:100px;" type="text" id="time-end" name="time-end"  placeholder = "__:__"></form>-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12 px-2">
                <div class="shadow-sm bg-white txt-purple drop-function-search py-2">
                    <div class="row">
                        <div class="col-7">
                            <h5 class="pl-3 pt-2">จำนวนผู้เข้าร่วม</h5>
                        </div>
                        <div class="col-5 ">
                            <input type="number" placeholder="0" id="tentacles" name="tentacles" min="0" max="100" value="<?php echo $_GET["tentacles"];?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-sm-12 col-12 ">
               <!--<button type="submit" class="btn-search btn Gradient-Color shadow-sm btn-lg mt-1"> ค้นหาห้องประชุม</button>-->
               <a onclick="search_data()" class="btn-search btn Gradient-Color shadow-sm btn-lg mt-1" role="button" aria-pressed="true">ค้นหาห้องประชุม</a>
               <a onclick="reset_search_data()" class="btn-search btn Gradient-Color shadow-sm btn-lg mt-1" role="button" aria-pressed="true">ล้างค่าการค้นหา</a>
            </div>
        </div>
        <div class="d-flex justify-content-center  mb-4">
            <a href="Calendar_Bookingroom.php" class="btn txt-purple bg-white btn-sm active px-4 py-2 mt-3 mb-3" role="button" aria-pressed="true">ปฏิทินการจองห้องประชุม</a>
        </div>
    </div>
</div>
</form>

<div class="container mt-4">
    <div>
        <h2 class="h2-color text-center">เลือกดูห้องประชุม</h2>
        <h3 class="h2-color mt-3 mb-2">
		รายการห้องประชุม<?php echo ($_GET["trip-start"] ? "ที่ว่าง วันที่ ".get_TH_Date2($_GET["trip-start"]).($_GET["trip-end"] == $_GET["trip-start"] ? "":" ถึง ".get_TH_Date2($_GET["trip-end"])):"");?>
		<?php echo ($_GET["time-start"] ? "เวลา ".$_GET["time-start"]." น. "."ถึง ".$_GET["time-end"]." น.":"");?>
		</h3>
        <hr class="hr_news mt-0">
    </div>

    <div class="row">
        <!-- ช่องของ รถแต่ละคัน -->
		<?php
		if($getRoomList['ResponseCode']['ResCode'] == '000'){
			foreach($getRoomList['Data'] as $key => $value){
				if($value['STATUS_FILE_PUT'] != 1){// $value['STATUS_FILE_PUT'] != 1 คือ ถ้ายังไม่ไม่บันทึก ถึงจะบันทึก
					file_put_contents('images/'.$value['ROOM_PIC_NAME'], file_get_contents($value['ROOM_PIC']));// บันทึกรูป หลัก จาก WF
				}
				// foreach($value['FILE_SAVE_NAME'] as $key => $value){
					// echo $value;// บันทึกรูปเพิ่มเติมจาก WF
				// }
				$i = 0;
				while($i < COUNT($value['FILE_SAVE_NAME'])){
					file_put_contents('images/'.$value['FILE_SAVE_NAME'][$i], file_get_contents($value['FILE_SAVE_NAME_DEFULT'][$i]));// บันทึกรูป เพิ่มเติม จาก WF
					$i++;
				}
		?>
        <div class="col-lg-4 col-md-6 col-sm-12 col-12 my-3">
            <!-- กล่องยานพาหนะ -->
            <div class="latest-post shadow-lg min-height-news ">
                <div class="latest-post-media ">
                    <a href="info_bookingRoom.php?<?php echo "meeting_id=".$value['MEETING_ID'];?>" class="latest-post-img">
                        <img loading="lazy" class="bor-ra-t15px img-fluid  max-height-news w-100" src="images/<?php echo $value['ROOM_PIC_NAME'];?>" alt="img" style="height:300px;">
                    </a>
                </div>
                <div class="post-body p-3 bg-color-purple bor-ra-b15px">
                    <h4 class="post-title text-white">
                        <a href="info_bookingRoom.php?<?php echo "meeting_id=".$value['MEETING_ID'];?>" class="d-inline-block text-white mr-4" target='_blank'> 
							<?php echo $value['ROOM_NAME'];?>
						</a>
                        <span><i class="fa fa-user"></i> <?php echo $value['SEAT_AMOUNT'];?></span>
                    </h4>
                    <div class="latest-post-meta text-white">
                        <div class="post-item-date color-datetime">
							สถานที่ : <?php echo $value['ROOM_LOCATION'];?>
                        </div>
                        <div class="post-item-date line-height-20px">
							ผู้ดูแล : <?php echo $value['ROOM_KEEPER'];?> 
                        </div>
                    </div>
                    <div class="general-btn text-right mt-1">
                        <a class="btn txt-purple  bg-white border-ra-10px pad-more-btn px-3" href="form_bookingRoom.php?<?php echo "meeting_id=".$value['MEETING_ID'];?>">
						จองห้องประชุม</a>
                    </div>
                </div>
            </div>
        </div>
		<?php
			} 
			$status_request = array(
						"type" => 'ROOM_PIC_FILE',
					);
			$updateStatusPic = callAPI('updateStatusPic',$status_request);
		}
		?>
      
    </div>
</div>
<br>
<br>
<br>
<!--<div class="d-flex justify-content-center mb-2">
<nav aria-label="...">
  <ul class="pagination">
    <li class="page-item">
      <a class="page-link"><i class="fa fa-caret-left icon_fa_left"></i></a>
    </li>
    <li class="page-item"><a class="page-link" href="#">1</a></li>
    <li class="page-item active" aria-current="page">
      <a class="page-link" href="#">2</a>
    </li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>
    <li class="page-item">
      <a class="page-link" href="#"><i class="fa fa-caret-right icon_fa_right"></i></a>
    </li>
  </ul>
</nav>
</div>-->

</div>





<!-- ข้อมูลวันเวลาจำนวน -->







<?php include('footer.php'); ?>
<!-- Footer Website -->
<?php include('combottom.php'); ?>



<!-- Include file js and properties -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> <!-- script time format -->
<script src="https://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js" type="text/javascript"></script> <!-- script time format -->



<script language="javascript">
// กำหนด locale เป็นภาษาไทย


</script>

<script>
$(document).ready(function(){
$("#trip-start").datepicker({ dateFormat: 'dd/mm/yy', isBuddhist: true, defaultDate: toDay });
$('.timeFormat').mask('00:00');
	
  // $("#trip-start").change(function(){
    // $("#trip-end").val($("#trip-start").val());
  // });
  
});

	function search_data() {
		// // //ส่วนของการส่งข้อมูล แบบ ajax โดยใช้ jquery
		// $.ajax({
			// url: 'Booking_room.php',
			// type: 'GET',
			// data: $('#form_wf').serialize() ,
			// success: function(data) {
				// console.log(data);
				

			// }
		// });
		var data = $('#form_wf').serialize();
		window.location = "Booking_room.php?"+data;
	}
	function reset_search_data() {
		window.location = "Booking_room.php";
	}

</script>