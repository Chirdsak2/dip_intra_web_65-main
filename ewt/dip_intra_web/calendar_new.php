<?php include 'comtop.php'; ?>
<?php include 'header.php'; ?>
<?php 
$calendar_manager = calendar::getManagerCalendar();
?>

<!-- Style CSS Template 3 -->
<link rel="stylesheet" href="assets/css/article.css">
<link rel="stylesheet" href="assets/css/calendar.css">
<link rel="stylesheet" href="assets/css/calendar_table.css">

<style>
    .fc-day-grid-event .fc-content {
        white-space: nowrap;
        overflow: hidden;
        margin: 15px;
    }
</style>

<div class="container-fluid mar-t-90px bg--purple text-center">
    <div class="container py-5">
        <div class="calendar--topic"> วาระงานผู้บริหาร </div>
    </div>
</div>

<section id="article-sec bg--white">
    <div class="container-fluid">
        <div class="form-group row mb-0">
            <div class="col-12">
                <div id="carouselcalendar" class="carousel slide" data-bs-interval="false">
                    <ol class="carousel-indicators position-list-carousel-ceo">
                        <?php foreach ($calendar_manager as $key => $value) { ?>
                        <li onclick="getCalendarList(<?php echo $value['cat_id']; ?>);"
                            data-id="<?php echo $value["cat_id"]; ?>" data-target="#carouselcalendar"
                            data-slide-to="<?php echo $key; ?>"
                            class="<?php echo ($key == 0 ? "active" : null); ?>">
                            <img src="<?php echo HOST_NAME; ?>assets/images/calendar/<?php echo $value['m_images']; ?>"
                                title="<?php echo $value['m_name'] . ' ' . $value['m_surname']; ?>"
                                alt="<?php echo $value['m_name'] . ' ' . $value['m_surname']; ?>"
                                class="position-pic-list-ceo pic-list<?php echo $key + 1 ?>">
                        </li>
                        <?php } ?>
                    </ol>

                    <div class="carousel-inner">
                        <?php foreach ($calendar_manager as $key => $value) { ?>
                        <div
                            class="carousel-item mt-5 <?php echo ($key == 0 ? "active" : null); ?>">
                            <div class="table-responsive">
                                <div class="p-5" id="calendar<?php echo $value["cat_id"]; ?>"></div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>

            </div>
            <!-- Close leftside -->
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
<!-- Bootstrap v4.6.1 -->
<script src="assets/js/bootstrap.js"></script>
<!-- Popper version 1.16.1 -->
<script src="assets/js/popper.js"></script>
<!-- Font Awesome Free 5.15.4 -->
<script src="assets/js/all.js"></script>
<!-- FontSize JS -->
<script src="assets/js/fontsize.js"></script>
<!-- Search header JS -->
<script src="assets/js/search_header.js"></script>

<script>
    $(document).ready(function () {
        let cat_id = "";
        $(".carousel-indicators li").on("click", function() {
            cat_id = $(this).attr("data-id");
        });

        if (cat_id === "") {
            cat_id = $(".carousel-indicators li").attr("data-id");
        }
        getCalendarList(cat_id);
    });

    function getCalendarList(cat_id, key) {
        //window.location.href = 'calendar_new.php?key_val=' + key

        $('#calendar' + cat_id).fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'prevYear,month,agendaWeek,agendaDay,nextYear'
            },
            eventLimit: true,
            defaultDate: new Date(),
            timezone: 'Asia/Bangkok',
            timeFormat: 'H(:mm):mm',
            events: {
                url: 'ajax/calendar.ajax.php',
                type: "POST",
                data: {
                    cat_id: cat_id,
                },
                datatype: "text",
                success: function (data) {
                    // console.log('success');
                },
                error: function () {
                    console.log('error');
                }
            },
        });
    }
</script>

<script>
    //Get the button
    var mybutton = document.getElementById("myBtn");

    // When the user scrolls down 20px from the top of the document, show the button
    window.onscroll = function () {
        scrollFunction()
    };

    function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            mybutton.style.display = "block";
        } else {
            mybutton.style.display = "none";
        }
    }

    // When the user clicks on the button, scroll to the top of the document
    function topFunction() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    }
</script>
</body>
</html>
<?php db::db_close(); ?>