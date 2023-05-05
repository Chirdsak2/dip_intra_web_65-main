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
                                <div class="offset-lg-3 offset-sm-1 col-lg-9 col-md-12 col-sm-11 text-manager">
                                    <?php echo $value['m_name']; ?> <?php echo $value['m_surname']; ?>
                                </div>
                            </div>
                            <?php if (!empty($value['m_images'])) { ?>
                                <img src="<?php echo HOST_NAME; ?>assets/images/calendar/<?php echo $value['m_images']; ?>" title="<?php echo $value['m_pos']; ?>" alt="<?php echo $value['m_pos']; ?>" class="position-pic-list-manager pic-list<?php echo $key + 1 ?>">
                            <?php } ?>
                        </li>

                        <?php foreach ($calendar_event[$value["cat_id"]] as $key => $val) { ?>
                            <li class="list-group-item">
                                <div class="txt-color-purple font15px">
                                    <i class="far fa-calendar"></i> <?php echo date('H:i', strtotime($val['event_time_start'])); ?> น.
                                </div>
                                <span class="font-weight-bold font15px"> <?php echo $val['event_title']; ?> </span>
                                <div class="font13px pt-3"> <?php echo $val['event_location']; ?> </div>
                            </li>
                        <?php } ?>

                    </ul>
                </div>
            <?php } ?>

        </div>

        <div class="row">
            <div class="col-12 text-center">
                <a href="calendar.php">
                    <div class="more-index mx-auto my-3">
                        วาระงานทั้งหมด
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>