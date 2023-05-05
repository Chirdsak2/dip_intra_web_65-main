<?php include 'comtop.php'; ?>
<?php include 'header.php'; ?>
<?php $calendar_manager = calendar::getManagerCalendar(); ?>

<!-- Style CSS Template 3 -->
<link rel="stylesheet" href="assets/css/article.css">
<link rel="stylesheet" href="assets/css/calendar.css">
<link rel="stylesheet" href="assets/css/calendar_table.css">

<style>
    .fc-day-grid-event .fc-content {
        /* white-space: nowrap;
        overflow: hidden; */
        margin: 15px;
    }

    .fc-today{
        color: #000;
    }

    .p-5 {
        padding: 4rem !important;
    }

    .fc-row.fc-rigid .fc-content-skeleton {
        color: #fff;
    }

    .fc .fc-row {
        color: #fff;
    }

    .fc-toolbar .fc-center {
        color: #fff;
    }

    .fc-day-grid-event .fc-content {
        margin: 5px;
    }
	
	.fc-scroller {
       overflow-y: hidden !important;
    }
	
    img {
        display: block;
    }

    .fc-time{
        display: none;
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
            <div class="col-12 bg-calendar-table bg-calendar-transparent">
                <div id="carouselcalendar" class="carousel slide" data-bs-interval="false">
                    <ol class="carousel-indicators position-list-carousel-ceo">
                        <?php foreach ($calendar_manager as $key => $value) { ?>
                            <li onclick="getCalendarList(<?php echo $value['cat_id']; ?>,<?php echo $key + 1; ?>);" data-id="<?php echo $value["cat_id"]; ?>" data-target="#carouselcalendar" data-slide-to="<?php echo $key; ?>" class="<?php echo ($key == 0 ? "active" : null); ?>">
                                <img src="assets/images/calendar/<?php echo $value['m_images']; ?>" title="<?php echo $value['m_name'] . ' ' . $value['m_surname']; ?>" alt="<?php echo $value['m_name'] . ' ' . $value['m_surname']; ?>" class="position-pic-list-ceo pic-list<?php echo $key + 1 ?>">
                            </li>
                        <?php } ?>
                    </ol>

                    <div class="carousel-inner">
                        <?php foreach ($calendar_manager as $key => $value) { ?>
                            <div class="carousel-item mt-5 <?php echo ($key == 0 ? "active" : null); ?>">
                            </div>
                        <?php } ?>
                    </div>

                    <?php foreach ($calendar_manager as $key => $value) { ?>
                        <div class="table-responsive">
                            <div class="p-5" id="calendar<?php echo $key + 1; ?>"></div>
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

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
<!-- Font Awesome Free 5.15.4 -->
<script src="assets/js/all.js"></script>
<!-- FontSize JS -->
<script src="assets/js/fontsize.js"></script>
<!-- Search header JS -->
<script src="assets/js/search_header.js"></script>

<script>
 
    $(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();   

        let cat_id = "";
        $(".carousel-indicators li").on("click", function() {
            cat_id = $(this).attr("data-id");
        });

        if (cat_id === "") {
            cat_id = $(".carousel-indicators li").attr("data-id");
        }

        var calendar = $('#calendar1').fullCalendar({
            header: {
                left: 'prevYear,nextYear today',
                center: 'title',
                right: 'prev,month,next'
            },
			height:'auto',
            eventLimit: false,
            defaultDate: new Date(),
            timezone: 'Asia/Bangkok',
            timeFormat: '(HH:mm)',
            eventRender: function(event, element){ 
                //alert(element); 
                //$(element).attr("data-toggle","tooltip");
                //$(element).attr("title",event.title);
                //$(element).attr("data-placement","top"); 
                $(element).tooltip({title: event.title,container: "body"});  

            },    
            events: function(start, end, timezone, callback) {
                $.ajax({
                    url: 'ajax/calendar.ajax.php',
                    type: "POST",
                    data: {
                        cat_id: cat_id,
                    },
                    dataType: "JSON",
                    success: function(events) {
                        callback(events);
                    }
                });
            },
            
            loading: function(bool) {
                $('#loading').toggle(bool);
            },
        });
    });

    function getCalendarList(cat_id, key) {
        for (let i = 1; i <= <?php echo sizeof($calendar_manager); ?>; i++) {
            if (i !== key) {
                $('#calendar' + i).hide();
            } else {
                $('#calendar' + i).show();
            }
        }

        var calendar = $('#calendar' + key).fullCalendar({
            header: {
                left: 'prevYear,nextYear today',
                center: 'title',
                right: 'prev,month,next'
            },
			height:'auto',
            eventLimit: false,
            defaultDate: new Date(),
            //timeFormat: '(HH:mm)',
            businessHours: false,
            eventRender: function(event, element){ 
                //alert(element); 
                //$(element).attr("data-toggle","tooltip");
                //$(element).attr("title",event.title);
                //$(element).attr("data-placement","top"); 
                $(element).tooltip({title: event.title,container: "body"});  

            },    
            events: function(start, end, timezone, callback) {
                $.ajax({
                    url: 'ajax/calendar.ajax.php',
                    type: "POST",
                    data: {
                        cat_id: cat_id,
                    },
                    dataType: "JSON",
                    success: function(events) {
                        callback(events);
                    }
                });
            },
            loading: function(bool) {
                $('#loading').toggle(bool);
            },
        });
    }
</script>

<script>
    //Get the button
    var mybutton = document.getElementById("myBtn");

    // When the user scrolls down 20px from the top of the document, show the button
    window.onscroll = function() {
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