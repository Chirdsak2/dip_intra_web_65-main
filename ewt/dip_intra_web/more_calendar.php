<?php include('comtop.php'); ?>
<?php include('header.php'); ?>
<?php
$more_calendar_type = calendar::getTypeCalendar(1);
$more_calendar = calendar::getMoreCalendar($start, $per_page, $cat_id, $event_date_start, $event_date_end, $s_search);
//$total_page_mc = ceil($more_calendar["countAll"] / $per_page);
?>

<!-- Style CSS Template 3 -->
<link rel="stylesheet" href="assets/css/article.css">
<link rel="stylesheet" href="assets/css/calendar.css">

<div class="container-fluid mar-t-90px header--bg">
    <div class="container py-5 text-center">
        <h3> ปฏิทินกิจกรรม </h3>
    </div>
</div>

<section class="search-sec header--bg">

    <div class="container">
        <form action="#" method="post" novalidate="novalidate">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12 p-0">
                            <input type="text" name="s_search" id="s_search" class="form-control search-slt" placeholder="กรอกคำค้น" onclick="clearText('s_search');" value="<?php echo $s_search; ?>">
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12 p-0">
                            <select class="form-control search-slt search-select" id="cat_id">
                                <option value="">...</option>
                                <?php foreach ($more_calendar_type as $key => $value) { ?>
                                    <option value="<?php echo $value["cat_id"]; ?>" <?php echo ($cat_id == $value["cat_id"] ? "selected" : null); ?>>
                                        <?php echo $value["cat_name"]; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12 p-0">
                            <!-- <input type="text" name="event_date_start" id="event_date_start" placeholder="วันเริ่มต้น" class="form-control search-slt search-select" onfocus="(this.type='date')" onblur="(this.type='text')" value="<?php echo $event_date_start; ?>" /> -->
                            <input type="date" name="event_date_start" id="event_date_start" placeholder="วันเริ่มต้น" class="form-control search-slt search-select" onclick="clearText('event_date_start');" value="<?php echo $event_date_start; ?>" />
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12 p-0">
                            <!-- <input type="text" name="event_date_end" id="event_date_end" placeholder="วันสิ้นสุด" class="form-control search-slt search-select" onfocus="(this.type='date')" onblur="(this.type='text')" value="<?php echo $event_date_end; ?>" /> -->
                            <input type="date" name="event_date_end" id="event_date_end" placeholder="วันสิ้นสุด" class="form-control search-slt search-select" onclick="clearText('event_date_end');" value="<?php echo $event_date_end; ?>" />
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12 p-0">
                            <button type="button" id="btn_search" class="btn btn--search wrn-btn"> ค้นหา </button>
                        </div>
                    </div>
                    <div class="text-center mt-5 text-red">
                        <?php if (!empty($s_search)) { ?>
                            ผลการค้นหา <?php echo (!empty($s_search) ? '"' . $s_search . '"' : null) . ' พบทั้งหมด ' . $more_calendar['countAll']; ?> รายการ
                        <?php } ?>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<div class="container-fluid bg--purple padding--50">
    <div class="container">
        <div class="row">
            <?php foreach ($more_calendar["data"] as $key => $value) { ?>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="calendar--card">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="calendar--title">
                                    <a onclick="calendarCount(<?php echo $value['event_id']; ?>);" href="calendar_view.php?event_id=<?php echo $value['event_id']; ?>" title="<?php echo $value['event_title']; ?>" target="_black"> <?php echo mb_strimwidth($value['event_title'], 0, 80, '...'); ?> </a>
                                </div>
                                <div class="calendar-date-time">
                                    <i class="far fa-calendar-alt"></i> <?php echo convDateThai($value['event_date_start'])['DateTH']; ?> - <?php echo convDateThai($value['event_date_end'])['DateTH']; ?> เวลา <?php echo date('H:i', strtotime($value['event_time_start'])) ?> - <?php echo date('H:i', strtotime($value['event_time_end'])) ?> น.
                                    <!-- <i id="list_count<?php echo $value['event_id']; ?>"> <?php echo $value['view_count']; ?></i> -->
                                    <br>
                                    <div class="mt-1">
                                        <a href="calendar_view.php?event_id=<?php echo $value['event_id']; ?>" title="<?php echo $value['event_detail']; ?>">
                                            <i class="fa fa-book"></i> <?php echo mb_strimwidth($value['event_detail'], 0, 80, '...'); ?>
                                        </a>
                                    </div>
                                    <div class="mt-1">
                                        <i class="fas fa-map-marker-alt"></i> <?php echo $value['event_location']; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <!-- Start แสดงการตัดหน้าเพจ -->
        <!-- <? //php echo pagination('more_calendar.php', 'cat_id=' . $cat_id . '&event_date_start=' . $event_date_start . '&event_date_end=' . $event_date_end . '&s_search' . $s_search, $page, $per_page, $more_calendar["countAll"]); ?> -->
        <?php echo pagination_ewt('more_calendar.php', 'cat_id=' . $cat_id . '&event_date_start=' . $event_date_start . '&event_date_end=' . $event_date_end . '&s_search' . $s_search, $page, $per_page, $more_calendar["countAll"]); ?>
        <!-- End แสดงการตัดหน้าเพจ-->
    </div>
</div>
</div>

<script>
    function clearText(text) {
        $('#' + text).val('');
    }
</script>

<script type="text/javascript">
    $("#btn_search").click(function() {
        window.location.href = 'more_calendar.php?page=' + <?php echo $page; ?> +
            '&cat_id=' + $('#cat_id').val() +
            '&event_date_start=' + $('#event_date_start').val() +
            '&event_date_end=' + $('#event_date_end').val() +
            '&s_search=' + $('#s_search').val();
    });
</script>

<script type="text/javascript">
    function calendarCount(event_id) {
        $.ajax({
            type: 'POST',
            url: 'ajax/more_calendar.ajax.php',
            data: {
                event_id: event_id
            },
            datatype: "text",
            success: function(data) {
                let object = JSON.parse(data, true);
                $('#list_count' + object.event_id).html(object.calendar_count);
            },
            error: function() {
                console.log('Error');
            }
        });
    }
</script>

<?php include('footer.php'); ?>
<?php include('combottom.php'); ?>