<?php
$calendar_manager = calendar::getManagerCalendar();
$calendar_event = calendar::getEventCalendar();
?>
<style>
    .bg-calendar-index {
        background-image: url(<?php echo !empty($template_management["site_calendar"]) ? $template_management["site_calendar"] : '../img/bg_calendar_index.jpg'; ?>);
    }
</style>
<div class="container-fluid bg-calendar-index p-3">
    <div class="container">

        <div class="w-100 text-center my-4">
            <a class="txt-between-arrow-calendar"> <?php echo convDateThai(date('Y-m-d'))['DateDayThai']; ?> </a>
        </div>

        <div class="row pt-5">
            <?php foreach ($calendar_manager as $key => $value) { ?>
                <div class="col-lg-3 col-md-3 col-sm-12 col-12 mb-5">
                    <ul class="list-group">
                        <li class="list-group-item bg-list1" style="background-color: <?php echo $value['cat_color']; ?> !important; color: #fff;" aria-current="true">
                            <div class="row">
                                <!-- Open Edit class จากเดิม "offset-5 col-7" ปรับใหม่เป็น "offset-3 col-9 "  18/05/2565 -->
                                <div class="offset-lg-4 offset-sm-4 offset-md-5 offset-xl-3 col-xl-9 col-lg-8 col-md-7 col-sm-8 offset-3 col-9 text-manager">
                                    <?php echo $value['m_name']; ?> <?php echo $value['m_surname']; ?>
                                </div>
                                <!-- Close Edit class จากเดิม "offset-5 col-7" ปรับใหม่เป็น "offset-3 col-9 "  18/05/2565 -->
                            </div>
                            <?php if (!empty($value['m_images'])) { ?>
                                <img src="assets/images/calendar/<?php echo $value['m_images']; ?>" title="<?php echo $value['m_pos']; ?>" alt="<?php echo $value['m_pos']; ?>" class="position-pic-list-manager pic-list<?php echo $key + 1 ?>">
                            <?php } ?>
                        </li>

                        <?php if (!empty($calendar_event[$value["cat_id"]])) { ?>
                            <?php foreach ($calendar_event[$value["cat_id"]] as $key => $val) { ?>
                                <li class="list-group-item">
                                    <div class="txt-color-purple font15px">
                                        <i class="far fa-calendar"></i> <?php echo $val['event_time_start']; ?> น.
                                    </div>
                                    <span class="font-weight-bold font15px"> <?php echo $val['event_title']; ?> </span>
                                    <div class="font13px pt-3"> <?php echo $val['event_location']; ?> </div>
                                </li>
                            <?php } ?>
                        <?php } else { ?>
                            <li class="list-group-item">
                                <div class="txt-color-purple font15px">
                                    ไม่พบกิจกรรมวันนี้
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>

        </div>

        <?php if (!empty($calendar_manager)) { ?>
            <div class="row">
                <div class="col-12 text-center">
                    <a href="calendar.php">
                        <div class="more-index mx-auto my-3">
                            วาระงานทั้งหมด
                        </div>
                    </a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>