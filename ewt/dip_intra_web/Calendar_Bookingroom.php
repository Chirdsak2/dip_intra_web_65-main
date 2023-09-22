<?php include('comtop.php'); ?>
<?php include('header.php'); ?>
<?php include('callservice.php'); ?>

<!-- CALL SERVICE -->
<!-- <br><br><br><br><br>
<img src="img/icon1.png" alt="">
<i class="fa fa-user" aria-hidden="true"></i>
<svg class="svg-inline--fa fa-user fa-w-14 h2-color pb-0" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="user" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
  <path fill="currentColor" d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z"></path>
</svg> -->
<?php
$data_request_room_id = array(
  "meeting_id" => $_GET["meeting_id"],
);
$getRoomApproved = callAPI('getRoomApproved', $data_request_room_id); //รายการประชุมที่ผ่านการอนุมัติลำดับที่ 2 แล้ว
$data_request = array(
  "type_from_calender" => 'only_id_name',
);
$getRoomList = callAPI('getRoomList', $data_request);
// echo '<br><br><br><pre>';
// print_r($getRoomApproved);
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
      //     events: 'https://fullcalendar.io/api/demo-feeds/events.json?overload-day'
      events: [
        <?php
        $n2 = 0;
        foreach ($getRoomApproved['Data'] as $key => $val) {
          if ($val['APPROVE_STATUS1'] != 2 && $val['APPROVE_STATUS2'] != 2 && $val['APPROVE_STATUS3'] != 2) { //2 คือการการที่ถูกยกเลิก

        ?>
            <?php if ($n2 > 0) {
              echo ",";
            } ?> {
              id: '<?php echo $val["WFR_ID"]; ?>',
              title: '<?php echo (in_array($val['ZOOM_STATUS'], ["Y", "Y3", "Y4"]) ? "🎦" : "")."| " . $val["STIME"] . " น. - " . $val["ETIME"] . " น.\\n" . $val["ROOM_NAME"]; ?>',//🎦โดย SG
              // icon: '\uf030',
              start: '<?php echo $val["MEETING_DATE"]; ?>',
              end: '<?php $holiday_date = $val["MEETING_EDATE"];
                    echo date("Y-m-d", strtotime("+1 day", strtotime($holiday_date))); ?>',
              <?php echo ($val['APPROVE_STATUS1'] == 1 && $val['APPROVE_STATUS2'] == 1 && $val['APPROVE_STATUS3'] == 1 ? "color: '#32CD32', " : "color: '#FF9900', ") ?>
              // description: 'รายละเอียดการขออนุญาติใช้ห้องประชุม',
              /* backgroundColor: '#FF9900', 
              textColor: '#FFFFFF',  */
              // allDay: false,
            }
        <?php
            $n2++;
          }
        }
        ?>

      ],
      eventClick: function(info) {
        // info.jsEvent.preventDefault(); // don't let the browser navigate

        // if (info.event.url) {
        // window.open(info.event.url);
        // }
        $('#modalBody > #title').text(info.event.title);
        // $('#modalWhen').text(info.event.start);
        // $('.modal-content > #eventID').val(info.event.defId);
        $('#calendarModal' + info.event.id).modal();
      },
      dateClick: function(info) {
        // console.log(info.dateStr);
        // alert(info.dateStr);
        var selectedDate = info.dateStr; // ดึงวันที่ที่คลิกเลือก
        var url = 'Booking_room.php?trip-start=' + selectedDate + '&trip-end=' + selectedDate; // สร้าง URL ด้วยวันที่ที่เลือก
        // window.location.href = url; // เปลี่ยนไปยังหน้า Booking_room.php พร้อมส่งค่าวันที่
        window.open(url, '_blank'); // เปิดหน้าใหม่
      }
      // eventRender: function(eventObj, $el) {
      //   console.log(eventObj,$el);
      //       $el.popover({
      //         html : true,
      //         content: eventObj.description,
      //         trigger: 'hover',
      //         placement: 'top',
      //         container: 'body'
      //       });
      //   }

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
  .logo_meet {
    width: 50px;
  }

  .H_meet {
    color: #82288C;
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
<form id="myform" action="Calendar_Bookingroom.php" method="get" role="form" novalidate="novalidate">

  <div class="container-fluid mar-spacehead" style="background-color: #F1EDEA">
    <div class="container ">
      <!--<form id="contact-form" action="#" method="post" role="form" novalidate="novalidate">-->
      <div class="error-container"></div>
      <div class="row">
        <h4 class="col-12 text-center  font-h-search  pt-4 pb-4 H_meet">
          <img class="logo_meet" src="images/2meet.png" alt=""> จองห้องประชุม
        </h4>
      </div>
      <!--</form>-->
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-xl-12">
        <h1 class="h2-color pt-4">ปฏิทินการจองห้องประชุม</h1>
      </div>
    </div>
    <div class="row">
      <div class="col-xl-12">
        <ul id="sub_menu">
          <li>
            <a href="Booking_room.php">จองห้องประชุม</a>
          </li>
          <li>
            &gt;
          </li>
          <li>
            <a href="#"> ปฏิทินจองห้องประชุม</a>
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
          <select id="meeting_id" name="meeting_id" class="form-control col-xl-4 m-3">
            <option value="">แสดงการจองห้องประชุมทั้งหมด</option>
            <?php
            foreach ($getRoomList["Data"] as $key => $val) {

            ?>
              <option <?php echo ($_GET["meeting_id"] == $key ? "selected" : ""); ?> value="<?php echo $key; ?>"><?php echo $val['ROOM_NAME']; ?></option>
            <?php
            }
            ?>

          </select>
        </div>

      </div>
    </div>

    <div class="row">
      <div class="col-xl-12 col-sm-12 col-12">
        <div id='calendar' class="mb-3"></div>
      </div>
    </div>
  </div>
</form>

<?php
foreach ($getRoomApproved['Data'] as $key => $val) {
  if ($val['APPROVE_STATUS1'] != 2 && $val['APPROVE_STATUS2'] != 2 && $val['APPROVE_STATUS3'] != 2) {
?>
    <div id="calendarModal<?php echo $val['WFR_ID']; ?>" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="container ">
            <h2 class="h2-color pt-4">
              รายละเอียดการขออนุญาตใช้ห้องประชุม<?php echo (in_array($val['ZOOM_STATUS'], ["Y", "Y3", "Y4"]) ? " <text style='color: blue;'>( <i class='fa fa-desktop'></i> ZOOM )</text>" : ""); ?><?php //echo $value['WFR_ID'];
                                                                                                                                                                            ?>
            </h2>
            <hr class="hr_news mt-3">
            <div class="container">
              <div class="row mb-3">
                <div class="col-lg-6 col-md-12 col-sm-12 col-12 pb-4">
                  <img src="images/<?php echo $val['FILE_NAME']; ?>" class="d-block w-100" alt="...">
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12 col-12 ">
                  <!--<h4 class="h2-color">รายละเอียดการขออนุญาตใช้ห้องประชุม</h4>-->
                  <h4 class="h2-color">หัวข้อประชุม : <?php echo $val['MEETING_TOPIC']; ?></h4>
                  <p class="mb-2"><i class='fa fa-user-tie h2-color pb-0'></i> ผู้จอง : <?php echo $val['REQ_NAME']; ?></p>
                  <?php //if($val['DEP_EXTERNAL']){
                  ?><p class="mb-2"><i class='fa fa-briefcase h2-color  pb-0'></i> หน่วยงานภายนอก : <?php echo $val['DEP_EXTERNAL']; ?></p><?php //}
                                                                                                                                                                            ?>
                  <p class="mb-2"><i class='fa fa-user h2-color  pb-0'></i> ผู้เข้าร่วม : <?php echo $val['MEETING_NUM_PP']; ?> คน</p>
                  <p class="mb-2"><i class='fa fa-door-open h2-color  pb-0'></i> <?php echo $val['ROOM_NAME'] . " เลขที่ห้อง " . $val['ROOM_NUMBER']; ?></p>
                  <p class="mb-2"><i class='fa fa-phone h2-color  pb-0'></i> เบอร์ผู้จอง : <?php echo $val['REQ_TEL']; ?></p>
                  <!--<p class="mb-2"><i class=" fa fa-road h2-color  pb-0"></i> <?php echo $val['CAR_MILEAGE']; ?> กิโลเมตร</p>-->
                  <p class="mb-2"><i class='fa fa-calendar h2-color  pb-0'></i> <?php echo $val['FULL_DATE'] . " เวลา " . $val['FULL_TIME'] . " น."; ?></p>

                  <?php if ($value['TYPE'] == 1) { ?>
                    <h4 class="h2-color">
                      รายการยืมอุปกรณ์
                    </h4>
                    <?php foreach ($getMeetingToolAdd['Data'] as $key => $value) { ?>
                      <p class="mb-2"><i class="fa fa-desktop h2-color  pb-0"></i> <?php echo $value['TOOL_NAME'] . " จำนวน " . $value['TOOL_AMOUNT']; ?></p>
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
  $(document).ready(function() {

    $("#meeting_id").change(function() {
      // document.getElementById("myform").submit();
      var data = $('#myform').serialize();
      window.location = "Calendar_Bookingroom.php?" + data;
    });

  });
</script>