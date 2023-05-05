<?php include('comtop.php'); ?>
<!-- Include file css and properties -->
<?php include('header.php'); ?>
<!-- Menu and Logo -->
<?php include('callservice.php'); ?>
<!-- CALL SERVICE -->

<?php

$data_request2 = array(
						"meeting_id" => $_GET["meeting_id"],
						"sdate" => $_GET["trip-start"],
						"edate" => $_GET["trip-end"]
					);
$getRequestBookingRoomDetail = callAPI('getRequestBookingRoomDetail', $data_request2);
 // echo '<pre>';
 // print_r($getRequestBookingRoomDetail);
 // echo '</pre>';
 

?>





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

<!-- News index page -->
<div class="shadow-sm container-fluid Knowledge-bg-head ">
    <div class="container pb-3 ">
        <h2 class="h2-color pt-4">
            ประวัติการจองห้องประชุม
        </h2>
        <h5 class="h2-color"><a href="info_bookingRoom.php">รายละเอียดห้องประชุม > </a> <span> ประวัติการจองห้องประชุม</span></h5>
        <hr class="hr_news mt-3">
		
<form id="form_wf" action="detail_bookingRoom.php" method="get" role="form">
        <div class="row mb-3 mt-5 d-flex justify-content-center">

            <div class="col-lg-4 col-md-6 col-sm-12 col-12 mb-2 shadow-sm border-ra-15px">
                <div class=" Datepick-start-stop ">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-6 ">
                            <h5 class="ml-2 mb-0"><i class="fa fa-calendar "></i> วันเริ่มต้น</h5>
                            <input class="mt-0 ml-2 pb-0 border-0" type="date" id="trip-start" name="trip-start" value="<?php echo $_GET["trip-start"];?>" min="2022-01-01" max="2030-12-31">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-6 ">
                            <h5 class="ml-2 mb-0"><i class="fa fa-calendar"></i> วันที่สิ้นสุด</h5>
                            <input class="mt-0 ml-2 pb-0 a-black-link border-0" type="date" id="trip-end" name="trip-end" value="<?php echo $_GET["trip-end"];?>" min="2022-01-01" max="2030-12-31">
                        </div>
                    </div>

                </div>
            </div>


            <!--<div class="col-lg-3 col-md-6 col-sm-12 col-12 search-box shadow-sm  pb-1">
                <div class="form-group  ">
                    <div>
                        <input type="input" class="mt-2  border-0 form-control drop-function-search" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="กรอกคำค้นหา">
                    </div>
                </div>
            </div>-->
            <div class="col-lg-3 col-md-6 col-sm-12 col-12 ">
                <!--<button type="button" class="btn-search btn Gradient-Color shadow-sm btn-sm mt-2"><i class="fa fa-search"></i> ค้นหาประวัติ</button>-->
				<a onclick="search_data()" style="width:180px;" class="btn-search btn Gradient-Color shadow-sm btn-sm mt-2" ><i class="fa fa-search"></i> ค้นหาประวัติ</a>
				<a onclick="reset_search_data()" style="width:100px;" class="btn-search btn Gradient-Color shadow-sm btn-sm mt-2" > reset</a>
            </div>
        </div>
</form>


        
        <div class="table-responsive-sm">
            <table class="table table-sm">
                <thead class="white-text bg-color-purple ta-fontmini">
                    <tr>
                        <th scope="col">วันที่</th>
                        <th scope="col">เวลา</th>
                        <th scope="col">หัวข้อการจอง</th>
                        <th scope="col">รายละเอียด</th>


                    </tr>
                </thead>
                <tbody>
				<?php 
				if($getRequestBookingRoomDetail['ResponseCode']['ResCode'] == '000'){
					foreach($getRequestBookingRoomDetail['Data'] as $key => $value){
				?>
				<tr>
					<td><?php echo $value['MEETING_DATE'];?></td>
					<td><?php echo $value['STIME']." - ".$value['ETIME']." น.";?></td>
						<td><?php echo $value['MEETING_TOPIC'];?></td>
						<td><a href="#" data-toggle="modal" data-target=".bd-example-modal-lg<?php echo $value['WFR_ID'];?>" role="button" aria-pressed="true">ดูรายละเอียด</a></td>
				</tr>
				<?php 
					}
				}
				?>
                    <!--<tr>
                        <td>5 ก.ย. 2564</th>
                        <td>08:30 - 16:30 น.</td>
                        <td>ประชุมความคืนหน้าการพัฒนาระบบ Ecoystem ครั้งที่ 7/2564</td>
                        <td><a href="#" data-toggle="modal" data-target=".bd-example-modal-lg " role="button" aria-pressed="true">ดูรายละเอียด</a></td>
                    </tr>
                    <tr>
                        <td>4 ก.ย 2564</th>
                        <td>08:30 - 16:30 น.</td>
                        <td>ประชุมความคืนหน้าการพัฒนาระบบ Ecoystem ครั้งที่ 6/2564</td>
                        <td><a href="#" role="button" aria-pressed="true">ดูรายละเอียด</a></td>
                    </tr>
                    <tr>
                        <td>3 ก.ย 2564</th>
                        <td>08:30 - 16:30 น.</td>
                        <td>ประชุมความคืนหน้าการพัฒนาระบบ Ecoystem ครั้งที่ 5/2564</td>
                        <td><a href="#" role="button" aria-pressed="true">ดูรายละเอียด</a></td>
                    </tr>
                    <tr>
                        <td>2 ก.ย 2564</th>
                        <td>08:30 - 16:30 น.</td>
                        <td>ประชุมความคืนหน้าการพัฒนาระบบ Ecoystem ครั้งที่ 4/2564</td>
                        <td><a href="#" role="button" aria-pressed="true">ดูรายละเอียด</a></td>
                    </tr>
                    <tr>
                        <td>1 ก.ย 2564</th>
                        <td>08:30 - 16:30 น.</td>
                        <td>ประชุมความคืนหน้าการพัฒนาระบบ Ecoystem ครั้งที่ 3/2564</td>
                        <td><a href="#" role="button" aria-pressed="true">ดูรายละเอียด</a></td>
                    </tr>-->

                </tbody>
            </table>
        </div>


    </div>

</div>


<!-- Large modal -->
<?php
if($getRequestBookingRoomDetail['ResponseCode']['ResCode'] == '000'){
	foreach($getRequestBookingRoomDetail['Data'] as $key => $value){ 
$data_request3 = array(
						"wfr_id" => $value["WFR_ID"]
					);
$getMeetingToolAdd = callAPI('getMeetingToolAdd', $data_request3);
 // echo '<pre>';
 // print_r($getMeetingToolAdd['Data'][$value["WFR_ID"]]); 
 // echo '</pre>';		 
?>
<div class="modal fade bd-example-modal-lg<?php echo $value['WFR_ID'];?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="container ">
                <h2 class="h2-color pt-4">
                    รายละเอียดการจองห้องประชุม <?php echo $value['ROOM_NAME'];?><?php //echo $value['WFR_ID'];?>
                </h2>
                <hr class="hr_news mt-3">
                <div class="container">
                    <h3 class="h2-color pt-4">
						<?php echo $value['MEETING_TOPIC'];?> <!-- หัวข้อการจอง	 -->
                    </h3>
                    <div class="row mb-3">
                        <div class="col-lg-6 col-md-12 col-sm-12 col-12 pb-4">
                            <img src="images/room1.jpg" class="d-block w-100" alt="...">
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-12 ">
                            <h4 class="h2-color">รายละเอียดห้องประชุม</h4>
                            <p class="mb-2"><i class="fa fa-user h2-color  pb-0"> </i> ประธานในที่ประชุม : <?php echo $value['MEETINH_CHAIRMAN'];?></p>
                            <p class="mb-2"><i class="fa fa-user-tie h2-color  pb-0"></i> ชื่อผู้จอง : <?php echo $value['REQ_USR_NAME'];?></p>
                            <p class="mb-2"><i class="fa fa-briefcase h2-color  pb-0"></i> หน่วยงานผู้จอง : ศูนย์เทคโนโลยีสารสนเทศและการสื่อสาร<?php //echo $value['REQ_DEP_NAME'];?> </p>
                            <p class="mb-2"><i class="fa fa-phone h2-color  pb-0"></i> <?php echo $value['REQ_TEL'];?></p>
                            <p class="mb-2"><i class="fa fa-user h2-color  pb-0"> </i> ผู้เข้าร่วม <?php echo $value['GUEST'];?> คน</p>
                            <p class="mb-2"><i class="fa fa-door-open h2-color  pb-0"></i> เลขที่ห้อง <?php echo $value['ROOM_NUMBER'];?></p>
                            <p class="mb-2"><i class="fa fa-calendar h2-color  pb-0"></i> <?php echo "วันที่ ".$value['MEETING_DATE_FULL']." - ".$value['MEETING_EDATE_FULL']." เวลา ".$value['STIME']." น. -  ".$value['ETIME']." น."?></p>
                            <h4 class="h2-color">
                                รายการยืมอุปกรณ์
                            </h4>
							<?php
							foreach($getMeetingToolAdd['Data'] as $key => $value){ 
							?>
                            <p class="mb-2"><i class="fa fa-desktop h2-color  pb-0"></i> <?php echo $value['TOOL_NAME']." จำนวน ".$value['TOOL_AMOUNT'];?></p>
							<?php
							}
							?>
                            <!--<p class="mb-2"><i class="fa-solid fa-desktop h2-color  pb-0"></i> เครื่องคอมพิวเตอร์ 1 เครื่อง </p>-->
                            
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






<?php include('footer.php'); ?>
<!-- Footer Website -->
<?php include('combottom.php'); ?>
<!-- Include file js and properties -->


<script>
$(document).ready(function(){
	
  $("#trip-start").change(function(){
    $("#trip-end").val($("#trip-start").val());
  });
  
});


function search_data() {
	var data = $('#form_wf').serialize();
	window.location = "detail_bookingRoom.php?"+data;
}
	function reset_search_data() {
		window.location = "detail_bookingRoom.php";
	}
</script>