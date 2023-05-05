<?php include('comtop.php'); ?>
<?php include('header.php'); ?>
<?php include('callservice.php'); ?>
<!-- CALL SERVICE -->

<?php
$data_request_car_id = array(
	"car_id" => $_GET["car_id"],
);
$getCarApproved = callAPI('getCarApproved',$data_request_car_id);

$data_request = array(
	"type_from_calender" => 'only_id_name',
);
$getCarList = callAPI('getCarList',$data_request);
// echo '<pre>';
// print_r($getCarList['Data']);
// echo '</pre>';
?>

<!-- ทำให้ \\n เว้นบรรทัดได้ -->
<style>
  .fc-event-title {
    white-space: pre-line;
  }
</style>
<script>
  
     document.addEventListener('DOMContentLoaded', function() {
  var initialLocaleCode = 'th';
  var localeSelectorEl = document.getElementById('locale-selector');
  
  var calendarEl = document.getElementById('calendar');
  
  

  var calendar = new FullCalendar.Calendar(calendarEl, {
    headerToolbar: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
    },
    locale: initialLocaleCode,
    buttonIcons: false, // show the prev/next text
    weekNumbers: true,
    navLinks: true, // can click day/week names to navigate views
    editable: true,
    dayMaxEvents: true, // allow "more" link when too many events
    html: true,
//     events: 'https://fullcalendar.io/api/demo-feeds/events.json?overload-day'
    events: [
	<?php 
	$n2 = 0;
	foreach($getCarApproved['Data'] as $key => $val){
		if($val['CB_STATUS'] == 5 && $val['WF_DET_STEP'] != '2482' && $val['WF_DET_STEP'] != '2484'){
			if($n2>0){echo ",";} 
			
		echo "{
		id:	'" . $val["WFR_ID"] . "'
		,title: '| " . $val["CB_STIME"] ." น. - ".$val["CB_ETIME"] . " น.\\n" . $val["NATURE_ID"]." ทะเบียน ".$val["CAR_REGISTER"] . "'
		,start: '" . $val["CB_SDATE"] . "'
		,end: '" . date("Y-m-d", strtotime("+1 day", strtotime($val["CB_EDATE"]))) . "'
		, color: '#32CD32'  
		, backgroundColor: '#32CD32'  
		}";
	?>
		// {
		// id: '<?php echo $val["WFR_ID"]; ?>',
		// title: '<?php echo $val["CB_STIME"]." - ".$val["CB_ETIME"] . "\\n" . $val["NATURE_ID"]." ".$val["CAR_REGISTER"]?>',
		// title2: 'zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz',
		// start: '<?php echo $val["CB_SDATE"]; ?>',
		// end: '<?php $holiday_date = $val["CB_EDATE"]; echo date("Y-m-d", strtotime("+1 day", strtotime($holiday_date)));?>',
		// color: '#32CD32' 
		/*// url: 'http://google.com/',
		 backgroundColor: '#FF9900', 
		textColor: '#FFFFFF', 
		allDay: false, */
		// }

	<?php 
	$n2++;}}
	?>
    ],
	  eventClick: function(info) {
		// info.jsEvent.preventDefault(); // don't let the browser navigate

		// if (info.event.url) {
		  // window.open(info.event.url);
		// }
		$('#modalBody > #title').text(info.event.title);
		$('#modalBody > #title2').text(info.event.id);
             // $('#modalWhen').text(info.event.start);
             // $('.modal-content > #eventID').val(info.event.defId);
        $('#calendarModal'+info.event.id).modal();
	  } 
  });

  calendar.render();

  // build the locale selector's options
  calendar.getAvailableLocaleCodes().forEach(function(localeCode) {
    var optionEl = document.createElement('option');
    optionEl.value = localeCode;
    optionEl.selected = localeCode == initialLocaleCode;
    optionEl.innerText = localeCode;
    localeSelectorEl.appendChild(optionEl);
  });

  // when the selected option changes, dynamically change the calendar option
  localeSelectorEl.addEventListener('change', function() {
    if (this.value) {
      calendar.setOption('locale', this.value);
    }
  });

});

</script>

<style>
     .logo_meet{
          width: 50px;
     }
     .H_meet{
          color:#82288C;
          font-weight: bold;
     }
     ul#sub_menu li {
          display: inline;
     }
     #calendar {
    max-width: 1100px;
    margin: 0 auto;
  }

</style>

<form id="myform" action="Calendar_Bookingcar.php" method="get" role="form" novalidate="novalidate">
<div class="container-fluid mar-spacehead bg-tabhead" >
    <div class="container ">
        <!--<form id="contact-form" action="#" method="post" role="form" novalidate="novalidate">-->
            <div class="error-container"></div>
            <div class="row">
                <h4 class="col-12 text-center  font-h-search  pt-4 pb-4 H_meet">
                       <img class="logo_meet" src="images/2car.png" alt="">  จองยานพาหนะ
                </h4>
            </div>
        <!--</form>-->
    </div>
</div>
<div class="container">
  <div class="row">
      <div class="col-xl-12">
          <h1 class="h2-color pt-4">ปฏิทินการจองยานพาหนะเดือน มิถุนายน</h1>
      </div>
  </div>
  <div class="row">
      <div class="col-xl-12">
          <ul id="sub_menu">
            <li>
                <a href="Booking_car.php">หน้าแรก</a>
            </li>
            <li>
                &gt; 
            </li>
            <li>
                <a href="#"> ปฏิทินจองยานพาหนะ</a>
            </li>
          </ul>
      </div>
      <hr class="hr_news mt-3">
  </div>
</div>

<div class="container">

  <div class="row">
     <div class="col-xl-12">
          <div class="d-flex justify-content-end">
               <select  id="car_id" name="car_id" class="form-control col-xl-4 m-3">
                    <option value="">แสดงการจองยานพาหนะทั้งหมด</option>
					<?php
					foreach($getCarList["Data"] as $key => $val){
						
					?>
						<option <?php echo ($_GET["car_id"] == $key ? "selected":"" );?> value="<?php echo $key;?>"><?php echo $val['NATURE_ID']." ทะเบียน ".$val['CAR_REGISTER'];?></option>
					<?php	
					}
					?>
                    
               </select>
          </div>
     </div>
  </div>
  <div class="row">
     <div class="col-xl-12 col-sm-12 col-12 ">
          <div id='calendar' class="mb-3"></div>
     </div>
  </div>
</div>
</form>


<!--<div id="calendarModal20" class="modal fade">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
			<h4 class="modal-title">รายละเอียดการขออนุญาตใช้ยานพาหนะ</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div id="modalBody" class="modal-body">
			<div id="title" class=""></div>
			<div id="title2" class=""></div>
			<div id="description" class="modal-title"></div>
			<div id="modalWhen" style="margin-top:5px;"></div>
        </div>
        <input id="eventID"/>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
            <button type="submit" class="btn btn-danger" id="deleteButton">Delete</button>
        </div>
    </div>
</div>
</div>-->


<?php
foreach($getCarApproved['Data'] as $key => $val){
		if($val['CB_STATUS'] == 5){
?>
<div id="calendarModal<?php echo $val['WFR_ID'];?>" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="container ">
                <h2 class="h2-color pt-4">
					รายละเอียดการขออนุญาตใช้ยานพาหนะ<?php echo $request_type;?><?php //echo $value['WFR_ID'];?>
                </h2>
                <hr class="hr_news mt-3">
                <div class="container">
                    <div class="row mb-3">
                        <div class="col-lg-6 col-md-12 col-sm-12 col-12 pb-4 ">
                            <img src="images/<?php echo $val['FILE_NAME'];?>" class="d-block w-100" alt="...">
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-12 ">
                            <h4 class="h2-color">วัตถุประสงค์ : <?php echo $val['CB_OBJECTIVE'];?></h4>
                            <!--<p class="mb-2"><i class='fa fa-user h2-color  pb-0'></i> ผู้รับผิดชอบ : <?php echo $val['CAR_KEEPER'];?></p>-->
                            <p class="mb-2"><i class='fa fa-user-tie h2-color  pb-0'></i> ผู้จอง : <?php echo $val['CB_PER_ID'];?></p>
                            <p class="mb-2"><i class='fa fa-user h2-color  pb-0'></i> ผู้เดินทาง : <?php echo $val['CB_MEMBER'];?> คน</p>
                            <p class="mb-2"><i class='fa fa-car h2-color  pb-0'></i> <?php echo $val['CAR_DETAIL'];?></p>
                            <p class="mb-2"><i class='fa fa-user h2-color  pb-0'></i> พนักงานขับรถ : <?php echo $val['STAFF_FULL_NAME'];?></p>
                            <p class="mb-2"><i class='fa fa-phone h2-color  pb-0'></i> เบอร์พนักงานขับรถ : <?php echo $val['STAFF_TEL'];?></p>
                            <!--<p class="mb-2"><i class=" fa fa-road h2-color  pb-0"></i> <?php echo $val['CAR_MILEAGE'];?> กิโลเมตร</p>-->
                            <p class="mb-2"><i class='fa fa-calendar h2-color  pb-0'></i> <?php echo $val['FULL_DATE']." เวลา ".$val['FULL_TIME']." น.";?></p>
							
						<?php if ($value['TYPE'] == 1) {?>
                            <h4 class="h2-color">
								รายการยืมอุปกรณ์
                            </h4>
							<?php foreach($getMeetingToolAdd['Data'] as $key => $value){ ?>
                            <p class="mb-2"><i class="fa fa-desktop h2-color  pb-0"></i> <?php echo $value['TOOL_NAME']." จำนวน ".$value['TOOL_AMOUNT'];?></p>
							<?php }
						} ?>
                            
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
<?php include('combottom.php'); ?>

<script>
$(document).ready(function(){
	
  $("#car_id").change(function(){
    // document.getElementById("myform").submit();
	// function search_data() {
		var data = $('#myform').serialize();
		window.location = "Calendar_Bookingcar.php?"+data;
	// }
  });
  
});


</script>