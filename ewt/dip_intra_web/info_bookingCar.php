<?php include('comtop.php'); ?>
<!-- Include file css and properties -->
<?php include('header.php'); ?>
<!-- Menu and Logo -->
<?php include('callservice.php'); ?>
<!-- CALL SERVICE -->

<?php

$data_request = array(
						"car_id" => $_GET["car_id"]
					);
$getCarDetail = callAPI('getCarDetail', $data_request);
 // echo '<pre>';
 // print_r($getCarDetail['Data']['FILE_SAVE_NAME']);
 // echo '</pre>';
if($getCarDetail['ResponseCode']['ResCode'] == '000'){
	$CAR_ID 			= $getCarDetail['Data']['CAR_ID'];
	$NATURE_ID 			= $getCarDetail['Data']['NATURE_ID'];
	$CAR_REGISTER 		= $getCarDetail['Data']['CAR_REGISTER'];
	$CAR_REMARK 		= $getCarDetail['Data']['CAR_REMARK'];
	$CAR_MILEAGE 		= $getCarDetail['Data']['CAR_MILEAGE'];
	$CAR_AMOUNT_SEAT 	= $getCarDetail['Data']['CAR_AMOUNT_SEAT'];
	$CAR_KEEPER 		= $getCarDetail['Data']['CAR_KEEPER'];
	$CAR_IMAGE_NAME 	= $getCarDetail['Data']['CAR_IMAGE_NAME'];
}

$data_request2 = array(
						"car_id" => $_GET["car_id"],
						"limit" => 10,
					);
$getRequestBookingCarDetail = callAPI('getRequestBookingCarDetail', $data_request2);
 // echo '<pre>';
 // print_r($getRequestBookingCarDetail);
 // echo '</pre>';
?>
<style>
.carousel {
  position: relative;
}
.carousel-item img {
  object-fit: cover;
}
#carousel-thumbs {
  background: rgba(255,255,255,.3);
  bottom: 0;
  left: 0;
  padding: 0 50px;
  right: 0;
}
#carousel-thumbs img {
  border: 5px solid transparent;
  cursor: pointer;
}
#carousel-thumbs img:hover {
  border-color: rgba(255,255,255,.3);
}
#carousel-thumbs .selected img {
  border-color: #fff;
}
.carousel-control-prev,
.carousel-control-next {
  width: 50px;
}
@media all and (max-width: 767px) {
  .carousel-container #carousel-thumbs img {
    border-width: 3px;
  }
}
@media all and (min-width: 576px) {
  .carousel-container #carousel-thumbs {
    position: absolute;
  }
}
@media all and (max-width: 576px) {
  .carousel-container #carousel-thumbs {
    background: #ccccce;
  }
}
</style>
<!-- แถบสีน้ำเงินหัวข้อข่าวสาร -->
<div class="container-fluid mar-spacehead bg-tabhead shadow-sm">
    <form id="contact-form" action="#" method="post" role="form">
        <div class="row  w-100 d-flex justify-content-center">
            <img src="images/2car.png" class="img rounded icon-tabhead" alt="BG-BookingCar">
			<span>
                <h1 class="col-12 txt-gradient-purple font-h-search  pt-4 pb-4 ">
					จองยานพาหนะ
                </h1>
            </span>
        </div>
    </form>
</div>

<!-- News index page -->
<div class="shadow-sm container-fluid Knowledge-bg-head ">
    <div class="container pb-3 ">
        <h2 class="h2-color pt-4">
            <?php echo $NATURE_ID;?> ทะเบียน <?php echo $CAR_REGISTER;?>
        </h2>
        <h5 class="h2-color"><a href="Booking_car.php">จองยานพาหนะ > </a> <span> รายละเอียดยานพาหนะ</span></h5>
        <hr class="hr_news mt-3">

        <div class="row">
			<div class="col-lg-6 col-md-12 col-sm-12 col-12 mt-3">
			<div class="container ">
				<div class="carousel-container position-relative row">
				
				<div id="myCarousel" class="carousel slide" data-ride="carousel">
					<div class="carousel-inner">
					<?php 
					$i = 0;
					foreach($getCarDetail['Data']['FILE_SAVE_NAME'] as $k => $v){
					?>
						<div class="carousel-item <?php echo($i == 0 ? "active":"");?>" data-slide-number="<?php echo $i;?>">
							<img style="border-radius: 15px;height:410px;" src="images/<?php echo $v;?>" class="d-block w-100 " alt="..." data-remote="https://source.unsplash.com/Pn6iimgM-wo/" data-type="image" data-toggle="lightbox" data-gallery="example-gallery" >
						</div>
					<?php 
					$i++;
					}
					?>
					</div>
				</div>

				<!-- Carousel Navigation -->
				<div id="carousel-thumbs" class="carousel slide" data-ride="carousel">
					<div class="carousel-inner">
					<?php
					$getCarDetail2 = array_chunk($getCarDetail['Data']['FILE_SAVE_NAME'], 4);
					$c_getCarDetail2 = count($getCarDetail2);
					$x = 0;
					$y = 0;
					while($x < $c_getCarDetail2){
					?>
						<div class="carousel-item <?php echo($x == 0 ? "active":"");?>">
							<div class="row mx-0">
							<?php 
							$i = 0;
							foreach($getCarDetail2[$x] as $k => $v){
							?>
							<div id="carousel-selector-<?php echo $y;?>" class="thumb col-4 col-sm-3 px-1 py-1 selected" data-target="#myCarousel" data-slide-to="<?php echo $y;?>">
								<img src="images/<?php echo $v;?>" class="img-fluid  pic-mini-cora" alt="...">
							</div>
							<?php 
							$i++;
							$y++;
							}
							?>
							</div>
						</div>
					<?php 
					$x++;
					}
					?>
					</div>
				<a class="carousel-control-prev" href="#carousel-thumbs" role="button" data-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="carousel-control-next" href="#carousel-thumbs" role="button" data-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
				</div>

				</div> <!-- /row -->
			</div> <!-- /container -->
			</div>
            
			
			
            <!-- text paragraph -->
            <div class="col-lg-6 col-md-12 col-sm-12 col-12 mt-3">
                <h3 class="h2-color">รายละเอียดรถ</h3>
                <p class="paragraph-news"><?php echo $CAR_REMARK;?></p>
                <h4><img class="symbolgrov" src="images/speed.png" alt="img"><span class="ml-2 "><?php echo $CAR_MILEAGE;?> กิโลเมตร</span></h4>
                <h3 class="h2-color mt-3">สิ่งอำนวยความสะดวก</h3>
                <div class="row mb-3">
                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                        <h4><i class="h2-color fa fa-tv"></i> หน้าจอโทรทัศน์ </h4>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                        <h4><i class="h2-color fa fa-volume-up"></i> เครื่องเสียง </h4>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                        <h4><i class="h2-color fa fa-battery-three-quarters"></i> อุปกรณ์ชาร์จไฟ </h4>
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
                                    <img src="images/professor4-1.png" class="h-100 d-block w-100 p-2 border-ra-15px" alt="...">
                                </div>
                                <!-- ชื่อ/วันที่/เวลา -->
                                <div class="col-xl-6 col-lg-7 col-md-8 col-sm-9 col-8 pl-0 mb-2">
                                    
                                    <h4 class=" mt-1 h2-color mt-3 mb-1 pr-1" style="font-weight: bold;"><?php echo $CAR_KEEPER;?></h4>
                                    <!--<p class="pb-2">ศส.</p>-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- จำนวนคน -->
                    <div class="col-lx-3 col-lg-3 col-md-3 col-sm-6 col-6 mt-3 px-1 ">
                        <div class="shadow-sm border-ra-15px txt-purple w-100 fontAw-position">
                            <h3 class="font-boxfloder mt-1 mb-0 txt-purple pt-1"> จำนวนคน</h3>
                            <h2 class="font-boxfloder txt-purple mt-1 pt-1 pb-3 "><?php echo $CAR_AMOUNT_SEAT;?></h2>
                        </div>
                    </div>
                    <!-- เลขทะเบียน -->
                    <div class="col-lx-3 col-lg-3 col-md-3 col-sm-6 col-6 mt-3 px-1 ">
                        <div class="shadow-sm border-ra-15px txt-purple w-100 fontAw-position">
                            <h3 class="font-boxfloder mt-1 mb-0 txt-purple pt-1"> เลขทะเบียน</h3>
                            <h2 class="font-boxfloder txt-purple mt-1 pt-1 pb-3 "><?php echo $CAR_REGISTER;?></h2>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-2">
                    <a href="detail_bookingCar.php?<?php echo "car_id=".$CAR_ID;?>" class="btn btn-outline-purple btn-lg  border-ra-30px px-3" role="button" aria-pressed="true">ประวัติการจองยานพาหนะ</a>
                    <a href="form_bookingCar.php?<?php echo "car_id=".$CAR_ID;?>" class="btn gradient-purple active text-white btn-lg active border-ra-30px px-5 mx-2" role="button" aria-pressed="true">จองยานพาหนะ</a>
                </div>
            </div>
        </div>
		
		
		<!--<div class="row">
		<div class="col-lg-6 col-md-12 col-sm-12 col-12 mt-3">

                <img class="img-fluid h-pic-news w-100 mb-2" src="images/<?php echo $CAR_IMAGE_NAME;?>" alt="img">
				<div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
					<?php 
					$getCarDetail2 = array_chunk($getCarDetail['Data']['FILE_SAVE_NAME'], 4);
					$c_getCarDetail2 = count($getCarDetail2);
					if($getCarDetail['Data']['FILE_SAVE_NAME']){
					?>
					<ol class="carousel-indicators ">  
						<?php 
						if($c_getCarDetail2 > 0){
							$x = 0;
							while($x < $c_getCarDetail2){
							?>
							<li data-target="#carouselExampleCaptions" data-slide-to="<?php echo $x; ?>" class="<?php echo($x == 0 ? "active":"");?>" ></li>
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
						while($x < $c_getCarDetail2){
						?>
						<div class="carousel-item <?php echo($x == 0 ? "active":"");?>">
                            <div class="row">
                                <?php 
								foreach($getCarDetail2[$x] as $k => $v){
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
                    <button class="carousel-control-next " type="button" data-target="#carouselExampleCaptions" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </button>

                </div>


            </div>
		</div>-->

        <hr class="hr_news mt-5">
        <h2 class="h2-color mt-4">ประวัติการจองยานพาหนะล่าสุด</h2>
        <div class="table-responsive-sm">
        <table class="table table-sm">
            <thead class="white-text bg-color-purple ta-fontmini">
                <tr>
                    <th scope="col">วันที่</th>
                    <th scope="col">เวลา</th>
                    <th scope="col">วัตถุประสงค์</th>
                    <th scope="col">รายละเอียด</th>
                </tr>
            </thead>
            <tbody>
			<?php 
			if($getRequestBookingCarDetail['ResponseCode']['ResCode'] == '000'){
				foreach($getRequestBookingCarDetail['Data'] as $key => $value){
			?>
                <tr>
                    <td><?php echo ($value['CB_SDATE']==$value['CB_EDATE'] ? $value['CB_SDATE']:$value['CB_SDATE']." - ".$value['CB_EDATE']);?></th>
                    <td><?php echo $value['CB_STIME']." - ".$value['CB_ETIME']." น.";?></td>
                    <td><?php echo $value['CB_OBJECTIVE_TYPE'];?></td>
                    <td><a href="#" data-toggle="modal" data-target=".bd-example-modal-lg<?php echo $value['WFR_ID'];?>" role="button" aria-pressed="true">ดูรายละเอียด</a></td>
                </tr>
			<?php 
				}
			}
			?>
				<!--<tr>
                    <td>5  ก.ย.  2564 (test)</th>
                    <td>08:30 - 16:30 น.</td>
                    <td>สำรวจสถานที่</td>
                    <td><a href="#" data-toggle="modal" data-target=".bd-example-modal-lg " role="button" aria-pressed="true">ดูรายละเอียด</a></td>
                </tr>
                <tr>
                    <td>4  ก.ย  2564(test)</th>
                    <td>08:30 - 16:30 น.</td>
                    <td>เดินทางไปต่างจังหวัด</td>
                    <td><a href="#" role="button" aria-pressed="true">ดูรายละเอียด</a></td>
                </tr>
                <tr>
                    <td>3  ก.ย  2564(test)</th>
                    <td>08:30 - 16:30 น.</td>
                    <td>เข้าร่วมประชุม</td>
                    <td><a href="#" role="button" aria-pressed="true">ดูรายละเอียด</a></td>
                </tr>-->

            </tbody>
        </table>
    </div>


    </div>

</div>


<!-- Large modal -->
<?php
if($getRequestBookingCarDetail['ResponseCode']['ResCode'] == '000'){
	foreach($getRequestBookingCarDetail['Data'] as $key => $value){
?>
<div class="modal fade bd-example-modal-lg<?php echo $value['WFR_ID'];?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="container ">
                <h2 class="h2-color pt-4">
					ประวัติการจองยานพาหนะ
                </h2>
                <hr class="hr_news mt-3">
                <div class="container">
                    <h3 class="h2-color pt-4">
						<?php echo $value['CB_OBJECTIVE_TYPE'];?> <!-- วัตถุประสงค์ -->
                    </h3>
                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-sm-12 col-12 pb-4">
                            <img src="images/car1.jpg" class="d-block w-100" alt="...">
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-12 ">
                            <h4 class="h2-color">รายละเอียดยานพาหนะ</h4>
                            <!--<p class="mb-2"><i class="fa-solid fa-user h2-color  pb-0"> </i> ผู้รับผิดชอบ :  <?php echo $CAR_KEEPER;?></p>-->
                            <!--<p class="mb-2"><i class="fa-solid fa-user-tie h2-color  pb-0"></i> ผู้ผ่านการเห็นชอบ : <?php echo $value['CS_APPROVE_PER_NAME'];?></p>-->
                            <p class="mb-2"><i class="fa fa-user h2-color  pb-0"> </i> ผู้เดินทาง : <?php echo $value['CB_MEMBER'];?></p>
                            <p class="mb-2"><i class="fa fa-car h2-color  pb-0"></i> <?php echo $value['CAR_DETAIL'];?></p>
                            <p class="mb-2"><i class='fa fa-user h2-color  pb-0'></i> พนักงานขับรถ :<?php echo $value['STAFF_FULL_NAME'];?></p>
                            <p class="mb-2"><i class='fa fa-phone h2-color  pb-0'></i> เบอร์พนักงานขับรถ : <?php echo $value['STAFF_TALAPHONE'];?></p>
                            <!--<p class="mb-2"><i class="fa-solid fa-gauge-simple-high h2-color  pb-0"></i> <?php echo $CAR_MILEAGE;?> กิโลเมตร</p>-->
                            <p class="mb-2"><i class="fa fa-calendar h2-color  pb-0"></i> <?php echo ($value['CB_SDATE']==$value['CB_EDATE'] ? "วันที่ ".$value['CB_SDATE']:"วันที่ ".$value['CB_SDATE']." - ".$value['CB_EDATE'])."<BR> เวลา ".$value['CB_STIME']." น. -  ".$value['CB_ETIME']." น."?> </p>
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

<script >
$('[id^=carousel-selector-]').removeClass('selected');
$('[id=carousel-selector-0]').addClass('selected');
// $('#myCarousel').carousel({
  // interval: false //เลื่อน
// });
$('#carousel-thumbs').carousel({
  interval: false //เลื่อน
});

// handles the carousel thumbnails
// https://stackoverflow.com/questions/25752187/bootstrap-carousel-with-thumbnails-multiple-carousel
$('[id^=carousel-selector-]').click(function() {
  var id_selector = $(this).attr('id');
  var id = parseInt( id_selector.substr(id_selector.lastIndexOf('-') + 1) );
  $('#myCarousel').carousel(id);
});
// Only display 3 items in nav on mobile.
if ($(window).width() < 575) {
  $('#carousel-thumbs .row div:nth-child(4)').each(function() {
    var rowBoundary = $(this);
    $('<div class="row mx-0">').insertAfter(rowBoundary.parent()).append(rowBoundary.nextAll().addBack());
  });
  $('#carousel-thumbs .carousel-item .row:nth-child(even)').each(function() {
    var boundary = $(this);
    $('<div class="carousel-item">').insertAfter(boundary.parent()).append(boundary.nextAll().addBack());
  });
}
// Hide slide arrows if too few items.
if ($('#carousel-thumbs .carousel-item').length < 2) {
  $('#carousel-thumbs [class^=carousel-control-]').remove();
  $('.machine-carousel-container #carousel-thumbs').css('padding','0 5px');
}
// when the carousel slides, auto update
$('#myCarousel').on('slide.bs.carousel', function(e) {
  var id = parseInt( $(e.relatedTarget).attr('data-slide-number') );
  $('[id^=carousel-selector-]').removeClass('selected');
  $('[id=carousel-selector-'+id+']').addClass('selected');
});
// when user swipes, go next or previous
$('#myCarousel').swipe({
  fallbackToMouseEvents: true,
  swipeLeft: function(e) {
    $('#myCarousel').carousel('next');
  },
  swipeRight: function(e) {
    $('#myCarousel').carousel('prev');
  },
  allowPageScroll: 'vertical',
  preventDefaultEvents: false,
  threshold: 75
});
/*
$(document).on('click', '[data-toggle="lightbox"]', function(event) {
  event.preventDefault();
  $(this).ekkoLightbox();
});
*/

$('#myCarousel .carousel-item img').on('click', function(e) {
  var src = $(e.target).attr('data-remote');
  if (src) $(this).ekkoLightbox();
});
</script >