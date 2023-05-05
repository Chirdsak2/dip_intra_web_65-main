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
 // print_r($getCarDetail);
 // echo '</pre>';
  if($getCarDetail['ResponseCode']['ResCode'] == '000'){
	$CAR_REGISTER = $getCarDetail['Data']['CAR_REGISTER'];
	$CAR_MILEAGE = $getCarDetail['Data']['CAR_MILEAGE'];
	$CAR_KEEPER = $getCarDetail['Data']['CAR_KEEPER'];
 }

$data_request2 = array(
						"car_id" => $_GET["car_id"],
						"sdate" => $_GET["trip-start"],
						"edate" => $_GET["trip-end"],
						"objective" => $_GET["objective"]
					);
$getRequestBookingCarDetail = callAPI('getRequestBookingCarDetail', $data_request2);
$getObjectiveCarBooking = callAPI('getObjectiveCarBooking');
 // echo '<pre>';
 // print_r($getRequestBookingCarDetail);
 // echo '</pre>';
?>

<!-- แถบสีน้ำเงินหัวข้อข่าวสาร -->

<div class="container-fluid mar-spacehead bg-tabhead shadow-sm">
    <!--<form id="contact-form" action="#" method="post" role="form">-->
        <div class="row  w-100 d-flex justify-content-center">
            <img src="images/2car.png" class="img rounded icon-tabhead" alt="BG-BookingCar"><span>
                <h1 class="col-12 txt-gradient-purple font-h-search  pt-4 pb-4 ">
                    จองยานพาหนะ
                </h1>
            </span>
        </div>
    <!--</form>-->
</div>


<!-- News index page -->
<div class="shadow-sm container-fluid Knowledge-bg-head ">
    <div class="container pb-3 ">
        <h2 class="h2-color pt-4">
            ประวัติการจองยานพาหนะ
        </h2>
        <h5 class="h2-color"><a href="info_bookingCar.php">รายละเอียดยานพาหนะ > </a> <span> ประวัติการจองยานพาหนะ</span></h5>
        <hr class="hr_news mt-3">
<form id="form_wf" action="detail_bookingCar.php" method="get" role="form">
        <div class="row mb-3 mt-5 d-flex justify-content-center">

            <div class="col-lg-4 col-md-6 col-sm-12 col-12 mb-2 shadow-sm border-ra-15px">
                <div class=" Datepick-start-stop ">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-6 ">
                            <h5 class="ml-2 mb-0"><i class="fa fa-calendar"></i> วันเริ่มต้น</h5>
                            <input class="mt-0 ml-2  border-0" type="date" id="trip-start" name="trip-start" value="<?php echo $_GET["trip-start"];?>" >
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-6 ">
                            <h5 class="ml-2 mb-0"><i class="fa fa-calendar"></i> วันที่สิ้นสุด</h5>
                            <input class="mt-0 ml-2 a-black-link border-0" type="date" id="trip-end" name="trip-end" value="<?php echo $_GET["trip-end"];?>" >
                        </div>
                    </div>

                </div>
            </div>


            <div class="col-lg-3 col-md-6 col-sm-12 col-12  ">
               <select required id="objective" name="objective" class="form-control" style="height:50px;">
					<option  value="" >เลือกวัตถุประสงค์</option>
					<?php 
					foreach ($getObjectiveCarBooking['Data'] as $key => $value) {
						$select = '';
					if($_GET["objective"]==$key){
						$select = 'selected';
					}
						echo "<option " . $select . " value=" . $key . ">" . $value . "</option>";
					}
					?>
				</select>
            </div>
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
                        <td>5 ก.ย. 2564</th>
                        <td>08:30 - 16:30 น.</td>
                        <td>สำรวจสถานที่</td>
                        <td><a href="#" data-toggle="modal" data-target=".bd-example-modal-lg " role="button" aria-pressed="true">ดูรายละเอียด</a></td>
                    </tr>
                    <tr>
                        <td>4 ก.ย 2564</th>
                        <td>08:30 - 16:30 น.</td>
                        <td>เดินทางไปต่างจังหวัด</td>
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
                    ประวัติการจองห้องประชุม
                </h2>
                <hr class="hr_news mt-3">
                <div class="container">
                    <h3 class="h2-color pt-4">
                        <?php echo $value['CB_OBJECTIVE_TYPE'];?>
                    </h3>
                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-sm-12 col-12 pb-4">
                            <img src="images/car1.jpg" class="d-block w-100" alt="...">
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-12 ">
                            <h4 class="h2-color">รายละเอียดยานพาหนะ</h4>
                            <!--<p class="mb-2"><i class="fa fa-user h2-color  pb-0"> </i> ผู้รับผิดชอบ : <?php echo $CAR_KEEPER;?></p>-->
                            <!--<p class="mb-2"><i class="fa fa-user-tie h2-color  pb-0"></i> ผู้ผ่านการเห็นชอบ : <?php echo $value['CS_APPROVE_PER_NAME'];?></p>-->
                            <p class="mb-2"><i class="fa fa-user h2-color  pb-0"> </i> ผู้เดินทาง : <?php echo $value['CB_MEMBER'];?></p>
                            <p class="mb-2"><i class="fa fa-car h2-color  pb-0"></i> <?php echo $value['CAR_DETAIL'];?></p>
                            <p class="mb-2"><i class='fa fa-user h2-color  pb-0'></i> พนักงานขับรถ :<?php echo $value['STAFF_FULL_NAME'];?></p>
                            <p class="mb-2"><i class='fa fa-phone h2-color  pb-0'></i> เบอร์พนักงานขับรถ : <?php echo $value['STAFF_TALAPHONE'];?></p>
                            <!--<p class="mb-2"><i class=" fa fa-road h2-color  pb-0"></i> <?php echo $CAR_MILEAGE;?> กิโลเมตร</p>-->
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


<script>
$(document).ready(function(){
	
  $("#trip-start").change(function(){
    $("#trip-end").val($("#trip-start").val());
  });
  
});


function search_data() {
	var data = $('#form_wf').serialize();
	window.location = "detail_bookingCar.php?"+data;
}
	function reset_search_data() {
		window.location = "detail_bookingCar.php";
	}
</script>