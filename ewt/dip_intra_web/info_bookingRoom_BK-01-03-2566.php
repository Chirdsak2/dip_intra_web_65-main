<?php include('comtop.php'); ?>
<!-- Include file css and properties -->
<?php include('header.php'); ?>
<!-- Menu and Logo -->
<?php include('callservice.php'); ?>
<!-- CALL SERVICE -->

<?php


$data_request = array(
						"meeting_id" => $_GET["meeting_id"]
					);
$getRoomDetail = callAPI('getRoomDetail', $data_request);
 // echo '<pre>';
 // print_r($getRoomDetail);
 // echo '</pre>';
  if($getRoomDetail['ResponseCode']['ResCode'] == '000'){
	$MEETING_ID = $getRoomDetail['Data']['MEETING_ID'];
	$ROOM_KEEPER = $getRoomDetail['Data']['ROOM_KEEPER'];
	$ROOM_PIC = $getRoomDetail['Data']['ROOM_PIC'];
	$ROOM_NAME = $getRoomDetail['Data']['ROOM_NAME'];
	$ROOM_LOCATION = $getRoomDetail['Data']['ROOM_LOCATION'];
	$ROOM_DETAIL = $getRoomDetail['Data']['ROOM_DETAIL'];
	$SEAT_AMOUNT = $getRoomDetail['Data']['SEAT_AMOUNT'];
	$ROOM_NUMBER = $getRoomDetail['Data']['ROOM_NUMBER'];
	$ROOM_PIC_NAME = $getRoomDetail['Data']['ROOM_PIC_NAME'];
 }

$data_request2 = array(
						"meeting_id" => $_GET["meeting_id"]
					);
$getRequestBookingRoomDetail = callAPI('getRequestBookingRoomDetail', $data_request2);
 // echo '<pre>';
 // print_r($getRequestBookingRoomDetail);
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

<!-- News index page -->
<div class="shadow-sm container-fluid Knowledge-bg-head ">
    <div class="container pb-3 ">
        <h2 class="h2-color pt-4">
            รายละเอียด <?php echo $ROOM_NAME;?>
        </h2>
        <h5 class="h2-color"><a href="Booking_room.php">จองห้องประชุม > </a> <span> รายละเอียดห้องประชุม</span></h5>
        <hr class="hr_news mt-3">

        <div class="row">
            <div class="col-lg-6 col-md-12 col-sm-12 col-12 mt-3">

                <img class="img-fluid h-pic-news w-100 mb-2" src="images/<?php echo $ROOM_PIC_NAME;?>" alt="img">

                <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                    <?php 
					$getRoomDetail2 = array_chunk($getRoomDetail['Data']['FILE_SAVE_NAME'], 4);
					$c_getRoomDetail2 = count($getRoomDetail2);
					if($getRoomDetail['Data']['FILE_SAVE_NAME']){
					?>
					<ol  class="carousel-indicators ">  
						<?php 
						if($c_getRoomDetail2 > 0){
							$x = 0;
							while($x < $c_getRoomDetail2){
							?>
							<li data-target="#carouselExampleCaptions" data-slide-to="<?php echo $x; ?>" class="<?php echo($x == 0 ? "active":"");?> " ></li>
							<?php 
							$x++;
							}
						} 
						?>
                    </ol>
					<?php 
					}
					?>
                    <div class="carousel-inner ">
						<?php
						$x = 0;
						while($x < $c_getRoomDetail2){
						?>
						<div class="carousel-item <?php echo($x == 0 ? "active":"");?>">
                            <div class="row">
                                <?php 
								foreach($getRoomDetail2[$x] as $k => $v){
								?>
								<div class="col-lg-3 col-md-3 col-sm-3 col-3">
									<div class="item">	
										<img src="images/<?php echo $v;?>" class="d-block w-100 pic-mini-cora" alt="...">
									</div>
								</div>
								<?php
								}
								?>
                            </div>
                        </div>
						<?php 
						$x++;
						}
						?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-target="#carouselExampleCaptions" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-target="#carouselExampleCaptions" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </button>

                </div>


            </div>
            <!-- text paragraph -->
            <div class="col-lg-6 col-md-12 col-sm-12 col-12 mt-3">
                <h3 class="h2-color">รายละเอียดสถานที่</h3>
                <p class="paragraph-news"><?php echo $ROOM_DETAIL;?><br>
                    <i class="fa-regular fa-building h2-color"></i> <?php echo $ROOM_LOCATION;?>
                </p>

                <h3 class="h2-color mt-3">สิ่งอำนวยความสะดวก</h3>
                <div class="row mb-3">
                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                        <h4><i class="fa fa-utensils h2-color"></i> อาหารรับรอง </h4>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                        <h4><i class="fa fa-wifi h2-color"></i> wi-fi </h4>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                        <h4><i class="fa fa-window-maximize h2-color"></i> กระดานไวท์บอร์ด </h4>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                        <h4><i class="fa fa-desktop h2-color"></i> โปรเจคเตอร์ </h4>
                    </div>
                </div>

                <!-- ข้อมูลผู้ดูแล -->
                <h3 class="mt-2 h2-color mb-0 mb-0 pr-1 pt-1" style="font-weight: bold;">ผู้รับผิดชอบ</h3>
                <div class="row">
                    <div class="col-lx-6 col-lg-6 col-md-6 col-sm-12 col-12 mt-2">
                        <!-- shadow-sm -->
                        <div class="shadow-sm border-ra-15px">
                            <!-- ภายในกล่องชื่อผู้รับผิดชอบ -->
                            <div class="row">
                                <!-- รูปภาพผู้รับผิดชอบ -->
                                <div class="col-xl-6 col-lg-5 col-md-4 col-sm-3 col-4 d-flex align-items-center">
                                    <img src="images/professor1-1.png" class="้h-100 d-block w-100 p-2 border-ra-15px" alt="...">
                                </div>
                                <!-- ชื่อ/วันที่/เวลา -->
                                <div class="col-xl-6 col-lg-7 col-md-8 col-sm-9 col-8 pl-0 ">

                                    <h4 class=" mt-1 h2-color  mt-3 mb-0 pr-1" style="font-weight: bold;"><?php echo $ROOM_KEEPER;?></h4>
                                    <p class="mb-0">ศส.</p>
                                    <p class="">091-XXX-XXXX</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lx-6 col-lg-6 col-md-6 col-sm-12 col-12 mt-2">
                        <!-- shadow-sm -->
                        <div class="shadow-sm border-ra-15px">
                            <!-- ภายในกล่องชื่อผู้รับผิดชอบ -->
                            <div class="row">
                                <!-- รูปภาพผู้รับผิดชอบ -->
                                <div class="col-xl-6 col-lg-5 col-md-4 col-sm-3 col-4 d-flex align-items-center">
                                    <img src="images/profile.jpg" class="้h-100 d-block w-100 p-2 border-ra-15px " alt="...">
                                </div>
                                <!-- ชื่อ/วันที่/เวลา -->
                                <div class="col-xl-6 col-lg-7 col-md-8 col-sm-9 col-8 pl-0 ">

                                    <h4 class=" mt-1 h2-color mb-0 mt-3  pr-1" style="font-weight: bold;">ไดอิจิ ฮิระตะ</h4>
                                    <p class="mb-0">กม.</p>
                                    <p class="">091-XXX-XXXX</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- จำนวนคน -->
                    <div class="col-lx-3 col-lg-3 col-md-3 col-sm-6 col-6 mt-3 px-1 ">
                        <div class="shadow-sm border-ra-15px txt-purple w-100 fontAw-position">
                            <h3 class="font-boxfloder mt-1 mb-0 txt-purple pt-1"> จำนวนคน</h3>
                            <h2 class="font-boxfloder txt-purple mt-1 pt-1 pb-3 "><?php echo $SEAT_AMOUNT;?></h2>
                        </div>
                    </div>
                    <!-- เลขทะเบียน -->
                    <div class="col-lx-3 col-lg-3 col-md-3 col-sm-6 col-6 mt-3 px-1 ">
                        <div class="shadow-sm border-ra-15px txt-purple w-100 fontAw-position">
                            <h3 class="font-boxfloder mt-1 mb-0 txt-purple pt-1"> เลขที่ห้อง</h3>
                            <h2 class="font-boxfloder txt-purple mt-1 pt-1 pb-3 "><?php echo $ROOM_NUMBER;?></h2>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-2">
                    <a href="detail_bookingRoom.php?<?php echo "meeting_id=".$MEETING_ID;?>" class="btn btn-outline-purple btn-lg  border-ra-30px px-3" role="button" aria-pressed="true">ประวัติการจองห้อง</a>
                    <a href="form_bookingRoom.php?<?php echo "meeting_id=".$MEETING_ID;?>" class="btn gradient-purple active text-white btn-lg active border-ra-30px px-5 mx-2" role="button" aria-pressed="true">จองห้องประชุม</a>

                </div>
            </div>
        </div>

        <hr class="hr_news mt-5">
        <h2 class="h2-color mt-4">ประวัติการจองห้องประชุมล่าสุด</h2>
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
                    รายละเอียดการจองห้องประชุม<?php echo $value['ROOM_NAME'];?><?php //echo $value['WFR_ID'];?>
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
                            <p class="mb-2"><i class="fa-solid fa-user h2-color  pb-0"> </i> ประธานในที่ประชุม : <?php echo $value['MEETINH_CHAIRMAN'];?></p>
                            <p class="mb-2"><i class="fa-solid fa-user-tie h2-color  pb-0"></i> ชื่อผู้จอง : <?php echo $value['REQ_USR_NAME'];?></p>
                            <p class="mb-2"><i class="fa-solid fa-briefcase h2-color  pb-0"></i> หน่วยงานผู้จอง : ศูนย์เทคโนโลยีสารสนเทศและการสื่อสาร<?php //echo $value['REQ_DEP_NAME'];?> </p>
                            <p class="mb-2"><i class="fa-solid fa-phone h2-color  pb-0"></i> <?php echo $value['REQ_TEL'];?></p>
                            <p class="mb-2"><i class="fa-solid fa-user h2-color  pb-0"> </i> ผู้เข้าร่วม <?php echo $value['GUEST'];?> คน</p>
                            <p class="mb-2"><i class="fa-solid fa-door-open h2-color  pb-0"></i> เลขที่ห้อง <?php echo $value['ROOM_NUMBER'];?></p>
                            <p class="mb-2"><i class="fa-solid fa-calendar-days h2-color  pb-0"></i> <?php echo "วันที่ ".$value['MEETING_DATE_FULL']." - ".$value['MEETING_EDATE_FULL']." เวลา ".$value['STIME']." น. -  ".$value['ETIME']." น."?></p>
                            <h4 class="h2-color">
                                รายการยืมอุปกรณ์
                            </h4>
							<?php
							foreach($getMeetingToolAdd['Data'] as $key => $value){ 
							?>
                            <p class="mb-2"><i class="fa-solid fa-desktop h2-color  pb-0"></i> <?php echo $value['TOOL_NAME']." จำนวน ".$value['TOOL_AMOUNT'];?></p>
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