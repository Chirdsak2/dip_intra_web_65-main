<div class="container mar-t-90px">
    <div class="">
        <div class="row">
            <!-- Open Banner Slide -->
            <div class="col-lg-7 col-md-12 col-sm-12 col-12 order-2 order-sm-2 order-lg-1">
                <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <?php foreach ($vdo as $key => $value) { ?>
                            <li data-target="#carouselExampleCaptions" data-slide-to="<?php echo $key?>" class="<?php echo ($key == 0 ? "active" : "");?>"></li>
                        <?php } ?>
                    </ol>
                    <div class="carousel-inner">
                        <?php foreach ($vdo as $key => $value) { ?>
                            
                        <?php $vdo = end(explode(".", trim($value['banner_pic'])));?>

                        <div class="carousel-item <?php echo ($key == 0 ? "active" : "");?>">
                            <?php if ($vdo == "mp4" || $vdo == "wmv") {?>
                            <a href="<?php echo trim($value['banner_link']); ?>" target="_blank">
                                <video autoplay="" muted="" loop="" id="bg-video" style="width: 100%;" controls>
                                    <source type="video/mp4" src="<?php echo trim($value['banner_pic']);?>"
                                        class="d-block w-100">
                                </video>
                            </a>
                            <?php } else { ?>
                            <a href="<?php echo trim($value['banner_link']); ?>" target="_blank">
                                <img src="<?php echo trim($value['banner_pic']);?>" class="d-block w-100"
                                    alt="<?php echo trim($value['banner_name'])?>">
                            </a>
                            <?php } ?>
                        </div>
                        <?php } ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-target="#carouselExampleCaptions"
                        data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-target="#carouselExampleCaptions"
                        data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </button>
                </div>
            </div>
            <!-- Close Banner Slide -->

            <!-- Open Content aleart -->
            <div class="col-lg-5 col-md-12 col-sm-12 col-12 pl-0 order-1 order-sm-1 order-lg-2">
                <div class="row height31per">
                    <div class="col-lg-7 col-md-7 col-sm-12 col-12">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12 pr-0 pl-0 txt-center-sm">
                                <img src="assets/img/user-pic.jpg" alt="user" title="user"
                                    class="rounded-circle max-width-user m-3 shadow-user">
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-6 col-12 txt-center-sm">
                                <div class="mt-4 name-user-login">
                                    สวัสดี! <br>
                                    คุณลลิษา มโนบาล
                                </div>
                                <div class="day-user mt-1">
                                    วันจันทร์ 23 ธ.ค. 2564 , 13.30 น.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-12 col-12 px-0">
                        <div class="row mx-0">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-4 px-0">
                                <div class="border-l-gray aleart-color-r mt-4 font12px px-1 py-3 text-center">
                                    <a data-toggle="collapse" href="#collapsealert" role="button" aria-expanded="false"
                                        aria-controls="collapsealert">
                                        <div class="text-center">
                                            <img src="assets/img/icon_alert.png" alt="alert" title="alert">
                                        </div>
                                        แจ้งเตือน
                                        <div class="alert-num-bell"> 3 </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-4 px-0">
                                <div class="border-l-gray aleart-color-r mt-4 font12px px-1 py-3 text-center">
                                    <a data-toggle="collapse" href="#collapseuser" role="button" aria-expanded="false"
                                        aria-controls="collapseuser">
                                        <div class="text-center">
                                            <img src="assets/img/icon_user.png" alt="alert" title="alert">
                                        </div>
                                        ข้อมูลส่วนตัว
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-4 px-0">
                                <div class="border-l-gray aleart-color-r mt-4 font12px px-1 py-3 text-center">
                                    <a href="index.php">
                                        <div class="text-center">
                                            <img src="assets/img/icon_logout.png" alt="alert" title="alert">
                                        </div>
                                        ออกจากระบบ
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="collapse alert-top-system-index border-alert" id="collapsealert">
                            <div
                                class="card card-body min-width-250px border-ra-15px border-ra-15-footer-0 max-width-top-collapes">
                                <h5 class="card-title txt-color-purple"> 3 รายการแจ้งเตือนสำหรับคุณ </h5>
                                <ul class="mar-l--40px list-alert-system-top">
                                    <li><a href="#"> แจ้งลางานออนไลน์ </a></li>
                                    <li><a href="#"> เอกสารรอการอนุมัติ </a></li>
                                    <li><a href="#"> แจ้งประเมินพนักงานประจำปี 64 </a></li>
                                    <li><a href="#"> ได้เวลาอัพเดทข้อมูลส่วนตัวแล้วนะคะ </a></li>
                                </ul>
                            </div>
                            <div class="card-footer footer-alert">
                                <a href="#" class="txt-white-hover-gray">
                                    รายการแจ้งเตือนทั้งหมด.. <img src="assets/img/arrow-list-white.png" alt="arrow"
                                        title="arrow">
                                </a>
                            </div>
                        </div>

                        <div class="collapse alert-top-index border-alert" id="collapseuser">
                            <div class="card card-body min-width-250px border-ra-15px max-width-top-collapes">
                                <h5 class="card-title txt-color-purple"> รายการข้อมูลส่วนตัว </h5>
                                <ul class="mar-l--40px list-alert-top">
                                    <li><a href="setting_profile.php"> แก้ไขข้อมูลส่วนตัว </a></li>
                                    <li><a href="setting_system.php"> ตั้งค่าระบบงาน </a></li>
                                    <li><a href="setting_password.php"> เปลี่ยนรหัสผ่าน </a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Open Alert Today -->
                <div class="row height33per">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12 bg-today">
                        <div class="txt-h-today pl-2"> วันนี้มีอะไร </div>
                        <div class="">
                            <div class="container text-center mt-2">
                                <div class="row mx-auto my-auto">
                                    <div id="myCarousel" class="carousel slide w-100" data-ride="carousel"
                                        data-interval="false">
                                        <ol class="carousel-indicators position-bullet1">
                                            <li data-target="#myCarousel" data-slide-to="0"
                                                class="active color-bullet1"></li>
                                            <li data-target="#myCarousel" data-slide-to="1" class="color-bullet1"></li>
                                        </ol>
                                        <div class="carousel-inner" role="listbox">
                                            <div class="carousel-item py-1 active">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                                                        <div class="media mb-2">
                                                            <img src="assets/img/hbd1.jpg"
                                                                class="mr-3 max-width-pic-today border-ra-10px"
                                                                alt="ceo1">
                                                            <div class="media-body font12px text-left">
                                                                <div> สุขสันต์วันเกิด </div>
                                                                <div> คุณมีนา มีตา </div>
                                                                <a href="#" data-toggle="modal"
                                                                    data-target="#staticBackdrop">
                                                                    <div class="btn-hbd-gift txt-white"> ส่งการ์ดอวยพร
                                                                    </div>
                                                                    <img src="assets/img/icon-gift.png" alt="gift"
                                                                        title="gift" class="position-gift">
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                                                        <div class="media mb-2">
                                                            <img src="assets/img/ceo/team1.jpg"
                                                                class="mr-3 max-width-pic-today border-ra-10px"
                                                                alt="ceo1">
                                                            <div class="media-body font12px text-left">
                                                                <div> อธิบดี </div>
                                                                <div> 08.30-12.00 </div>
                                                                <div> ประชม ครม. </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                                                        <div class="media mb-2">
                                                            <!--
															<a onclick="playSound('assets/sound/sound_1.mp3')">
																<img src="assets/img/en_chitchat.jpg" class="mr-3 max-width-pic-today border-ra-10px" alt="ceo1">
															</a>
															-->
                                                            <input type="image" src="assets/img/en_chitchat.jpg"
                                                                onclick="audio.play ( )"
                                                                class="mr-3 max-width-pic-today border-ra-10px">


                                                            <div class="media-body font12px text-left">
                                                                <div> Freak out </div>
                                                                <div> สติแตก </div>
                                                                <div class="btn-en-chitchat"> <a
                                                                        href="http://intranet.prd.go.th/vocab_prd/vocabulary.php"
                                                                        target="_blank">English Chitchat </a></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="carousel-item py-1">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                                                        <div class="media mb-2">
                                                            <img src="assets/img/ceo/team1.jpg"
                                                                class="mr-3 max-width-pic-today border-ra-10px"
                                                                alt="ceo1">
                                                            <div class="media-body font12px text-left">
                                                                <div> อธิบดี </div>
                                                                <div> 08.30-12.00 </div>
                                                                <div> ประชม ครม. </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                                                        <div class="media mb-2">
                                                            <img src="assets/img/ceo/team2.jpg"
                                                                class="mr-3 max-width-pic-today border-ra-10px"
                                                                alt="ceo1">
                                                            <div class="media-body font12px text-left">
                                                                <div> รองอธิบดี </div>
                                                                <div> 08.30-10.00 </div>
                                                                <div> ประชุมตรวจรับระบบ... </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                                                        <div class="media mb-2">
                                                            <img src="assets/img/ceo/team3.jpg"
                                                                class="mr-3 max-width-pic-today border-ra-10px"
                                                                alt="ceo1">
                                                            <div class="media-body font12px text-left">
                                                                <div> รองอธิบดี </div>
                                                                <div> 08.30-10.00 </div>
                                                                <div> ประชุมตรวจรับระบบ... </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Close Alert Today -->


                <!-- Open Systems -->
                <div class="row height36per">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12 pb-0 bg-system">
                        <div class="pl-2"> ระบบงานของคุณ </div>
                        <div class="">
                            <div class="container text-center mt-2">
                                <div class="row mx-auto my-auto">
                                    <div id="myCarousel2" class="carousel slide w-100" data-ride="carousel"
                                        data-interval="false">
                                        <ol class="carousel-indicators position-bullet1">
                                            <li data-target="#myCarousel2" data-slide-to="0"
                                                class="active color-bullet1"></li>
                                            <li data-target="#myCarousel2" data-slide-to="1" class="color-bullet1"></li>
                                            <li data-target="#myCarousel2" data-slide-to="2" class="color-bullet1"></li>
                                        </ol>
                                        <div class="carousel-inner" role="listbox">
                                            <div class="carousel-item py-1 active">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-6 col-sm-6 col-6 mt-2">
                                                        <a href="#">
                                                            <div class="text-center bg-system-icon">
                                                                <img src="assets/img/system/system_01.png"
                                                                    class="max-width-pic-today " alt="ceo1">
                                                            </div>
                                                            <div>
                                                                <div class="media-body font12px text-center">
                                                                    <div class="mt-1 txt-white"> ระบบประเมิน </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-6 col-6 mt-2">
                                                        <a href="#">
                                                            <div class="text-center bg-system-icon">
                                                                <img src="assets/img/system/system_02.png"
                                                                    class="max-width-pic-today " alt="ceo1">
                                                            </div>
                                                            <div>
                                                                <div class="media-body font12px text-center">
                                                                    <div class="mt-1 txt-white"> รวมสื่อประชาสัมพันธ์
                                                                        2565 </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-6 col-6 mt-2">
                                                        <a href="#">
                                                            <div class="text-center bg-system-icon">
                                                                <img src="assets/img/system/system_03.png"
                                                                    class="max-width-pic-today " alt="ceo1">
                                                            </div>
                                                            <div>
                                                                <div class="media-body font12px text-center">
                                                                    <div class="mt-1 txt-white"> สารบรรณอิเล็กทรอนิกส์
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-6 col-6 mt-2">
                                                        <a href="#">
                                                            <div class="text-center bg-system-icon">
                                                                <img src="assets/img/system/system_04.png"
                                                                    class="max-width-pic-today " alt="ceo1">
                                                            </div>
                                                            <div>
                                                                <div class="media-body font12px text-center">
                                                                    <div class="mt-1 txt-white"> อีเมล กปส. </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="carousel-item py-1">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-6 col-sm-6 col-6 mt-2">
                                                        <a href="#">
                                                            <div class="text-center bg-system-icon">
                                                                <img src="assets/img/system/system_05.png"
                                                                    class="max-width-pic-today " alt="ceo1">
                                                            </div>
                                                            <div>
                                                                <div class="media-body font12px text-center">
                                                                    <div class="mt-1 txt-white"> BIG DATA </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-6 col-6 mt-2">
                                                        <a href="#">
                                                            <div class="text-center bg-system-icon">
                                                                <img src="assets/img/system/system_06.png"
                                                                    class="max-width-pic-today " alt="ceo1">
                                                            </div>
                                                            <div>
                                                                <div class="media-body font12px text-center">
                                                                    <div class="mt-1 txt-white"> คลังภาพและเสียง </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-6 col-6 mt-2">
                                                        <a href="#">
                                                            <div class="text-center bg-system-icon">
                                                                <img src="assets/img/system/system_07.png"
                                                                    class="max-width-pic-today " alt="ceo1">
                                                            </div>
                                                            <div>
                                                                <div class="media-body font12px text-center">
                                                                    <div class="mt-1 txt-white"> E-DOCUMENT </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-6 col-6 mt-2">
                                                        <a href="#">
                                                            <div class="text-center bg-system-icon">
                                                                <img src="assets/img/system/system_08.png"
                                                                    class="max-width-pic-today " alt="ceo1">
                                                            </div>
                                                            <div>
                                                                <div class="media-body font12px text-center">
                                                                    <div class="mt-1 txt-white"> SMART CARD </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="carousel-item py-1">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-6 col-sm-6 col-6 mt-2">
                                                        <a href="#">
                                                            <div class="text-center bg-system-icon">
                                                                <img src="assets/img/system/system_09.png"
                                                                    class="max-width-pic-today " alt="ceo1">
                                                            </div>
                                                            <div>
                                                                <div class="media-body font12px text-center">
                                                                    <div class="mt-1 txt-white"> Intranet WebPortal
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-6 col-6 mt-2">
                                                        <a href="#">
                                                            <div class="text-center bg-system-icon">
                                                                <img src="assets/img/system/system_10.png"
                                                                    class="max-width-pic-today " alt="ceo1">
                                                            </div>
                                                            <div>
                                                                <div class="media-body font12px text-center">
                                                                    <div class="mt-1 txt-white"> PBMS </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-6 col-6 mt-2">
                                                        <a href="#">
                                                            <div class="text-center bg-system-icon">
                                                                <img src="assets/img/system/system_11.png"
                                                                    class="max-width-pic-today " alt="ceo1">
                                                            </div>
                                                            <div>
                                                                <div class="media-body font12px text-center">
                                                                    <div class="mt-1 txt-white"> ติดตามเงินรายได้ </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="col-lg-3 col-md-6 col-sm-6 col-6 mt-2">
                                                        <a href="#">
                                                            <div class="text-center bg-system-icon">
                                                                <img src="assets/img/system/system_12.png"
                                                                    class="max-width-pic-today " alt="ceo1">
                                                            </div>
                                                            <div>
                                                                <div class="media-body font12px text-center">
                                                                    <div class="mt-1 txt-white"> ระบบเงินเดือน </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Close Systems -->
            </div>
            <!-- Close Content aleart -->
        </div>
    </div>
</div>


<!-- Card วันเกิด -->
<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header border-b-0">
                <h5 class="modal-title" id="staticBackdropLabel"> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                        <div class="media mb-2">
                            <img src="assets/img/hbd1.jpg" class="mx-3 border-ra-10px pic-card-wish" alt="ceo1">
                            <div class="media-body font12px text-left">
                                <div class="txt-color-purple font20px font-weight-bold"> วันนี้วันเกิด </div>
                                <div class="txt-color-purple font30px font-weight-bold"> คุณมีนา มีตา </div>
                                <div class="txt-color-purple font20px font-weight-bold"> 28 ม.ค. 2565 </div>
                            </div>
                        </div>
                        <div class="txt-color-purple2 font20px my-4 pl-4 font-weight-bold">
                            เลือกคำอวยพร
                        </div>
                        <div class="pl-4 mb-5 font20px">
                            <div class="custom-control custom-radio py-2">
                                <input type="radio" id="customRadio1" name="customRadio" class="custom-control-input">
                                <label class="custom-control-label" for="customRadio1"> ขอให้มีความสุขมากๆ </label>
                            </div>
                            <div class="custom-control custom-radio py-2">
                                <input type="radio" id="customRadio2" name="customRadio" class="custom-control-input">
                                <label class="custom-control-label" for="customRadio2"> สุขภาพแข็งแรง รวยๆ ตลอดไป
                                </label>
                            </div>
                            <div class="custom-control custom-radio py-2">
                                <input type="radio" id="customRadio3" name="customRadio" class="custom-control-input">
                                <label class="custom-control-label" for="customRadio3"> สุข สมหวังในทุกสิ่งที่ปรารถนา
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                        <div class="txt-color-purple font25px font-weight-bold mb-4">
                            <img src="assets/img/pick_gift_card.png" title="pick gift card" alt="pick gift card"
                                class="mr-3">เลือกรูปแบบการ์ดอวยพร
                        </div>
                        <div class="row">
                            <div class="form-check mb-5 text-center px-0 mx-2">
                                <div class="w-100">
                                    <label class="form-check-label" for="inlineRadio1">
                                        <img src="assets/img/hbd/hbd1.png" title="HappyBirthDay" alt="HappyBirthDay"
                                            class="pic-hbd">
                                    </label>
                                </div>
                                <div class="w-100 mx-auto">
                                    <input class="form-check-input ml-0" type="radio" name="inlineRadioOptions"
                                        id="inlineRadio1" value="option1">
                                </div>
                            </div>

                            <div class="form-check mb-5 text-center px-0 mx-2">
                                <label class="form-check-label" for="inlineRadio2">
                                    <img src="assets/img/hbd/hbd2.png" title="HappyBirthDay" alt="HappyBirthDay"
                                        class="pic-hbd">
                                </label>
                                <div class="w-100 mx-auto">
                                    <input class="form-check-input ml-0" type="radio" name="inlineRadioOptions"
                                        id="inlineRadio2" value="option2">
                                </div>
                            </div>

                            <div class="form-check mb-5 text-center px-0 mx-2">
                                <label class="form-check-label" for="inlineRadio3">
                                    <img src="assets/img/hbd/hbd3.png" title="HappyBirthDay" alt="HappyBirthDay"
                                        class="pic-hbd">
                                </label>
                                <div class="w-100 mx-auto">
                                    <input class="form-check-input ml-0" type="radio" name="inlineRadioOptions"
                                        id="inlineRadio3" value="option3">
                                </div>
                            </div>

                            <div class="form-check mb-5 text-center px-0 mx-2">
                                <label class="form-check-label" for="inlineRadio4">
                                    <img src="assets/img/hbd/hbd4.png" title="HappyBirthDay" alt="HappyBirthDay"
                                        class="pic-hbd">
                                </label>
                                <div class="w-100 mx-auto">
                                    <input class="form-check-input ml-0" type="radio" name="inlineRadioOptions"
                                        id="inlineRadio4" value="option4">
                                </div>
                            </div>

                            <div class="form-check mb-5 text-center px-0 mx-2">
                                <label class="form-check-label" for="inlineRadio5">
                                    <img src="assets/img/hbd/hbd5.png" title="HappyBirthDay" alt="HappyBirthDay"
                                        class="pic-hbd">
                                </label>
                                <div class="w-100 mx-auto">
                                    <input class="form-check-input ml-0" type="radio" name="inlineRadioOptions"
                                        id="inlineRadio5" value="option5">
                                </div>
                            </div>

                            <div class="form-check mb-5 text-center px-0 mx-2">
                                <label class="form-check-label" for="inlineRadio6">
                                    <img src="assets/img/hbd/hbd6.png" title="HappyBirthDay" alt="HappyBirthDay"
                                        class="pic-hbd">
                                </label>
                                <div class="w-100 mx-auto">
                                    <input class="form-check-input ml-0" type="radio" name="inlineRadioOptions"
                                        id="inlineRadio6" value="option6">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-t-0 mx-auto">
                <button type="button" class="send-index"> ส่งการ์ดอวยพร </button>
            </div>
        </div>
    </div>
</div>

<script>
var audio = new Audio("assets/sound/sound_1.mp3");
audio.oncanplaythrough = function() {}
audio.onended = function() {}
</script>