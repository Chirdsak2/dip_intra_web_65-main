<!-- Open Top -->
<?php include('comtop.php'); ?>
<?php include('header.php'); ?>
<!-- Close Top -->

<?php
$ecard_user_birthdate = ecard::getEcardHistory($_SESSION["EWT_MID"], $ech_date, $ech_date_year);
$birth_date = date("m-d", strtotime($birth_day)); //วันเกิด User
$birth_date_cy = date("Y") . '-' . $birth_date; //วันเกิด User ปีปัจจุบัน
$birth_date_bfy = date("Y", strtotime(" - 1 years")) . '-' . $birth_date; //วันเกิด User ปีก่อน
?>

<!-- Font on Website -->
<link rel="stylesheet" href="assets/css/profile.css">
<style>
    .max-width50px {
        max-width: 50px;
    }

    .img-fluid1 {
        height: 80px;
    }
</style>

<div class="container-fluid b__profile mar-t-90px">
    <div class="container py-5 text-center">
        <h3> <i class="fas fa-birthday-cake"></i> การ์ดอวยพรวันเกิดที่ได้จากครอบครัวกรมประชาสัมพันธ์ </h3>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-12">
                <?php include 'profile_menu.php'; ?>
            </div>
            <div class="col-lg-9 col-md-9 col-12">

                <!-- HBD card List per year just show only last month -->
                <div class="bg--white shadow">
                    <div class="mt-3 mb-5">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                            </div>

                            <div class="col-12">
                                <div class="col-12">
                                    <div class="row mb-4">
                                        <h3 class="col-lg-6 col-md-6 col-sm-12 col-12">
                                            <?php if (empty($ech_date_year) || $ech_date_year == date('Y')) { ?>
                                                ปี <?php echo date('Y') + 543; ?>
                                            <?php } else { ?>
                                                ปี <?php echo $ech_date_year + 543; ?>
                                            <?php } ?>
                                        </h3>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="row">
                                                <div class="col-lg-10 col-md-10 col-sm-12 col-12">
                                                    <select class="form-control" name="ech_date_year" id="ech_date_year">
                                                        <option value=""> -- เลือกปีเพื่อดูข้อมูลการ์ด -- </option>
                                                        <?php for ($i = 0; $i < 50; $i++) { ?>
                                                            <option value="<?php echo date('Y') - $i; ?>" <?php echo ($ech_date_year == date('Y') - $i ? "selected" : null); ?>><?php echo date('Y') - $i + 543; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-12 col-12">
                                                    <button type="button" class="btn btn-search-hbd mb-2" id="btn_search"> ค้นหา </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-4 w-100">
                                            <?php foreach ($ecard_user_birthdate['data'] as $key => $value) { ?>
                                                <?php
                                                $ecard_list = ecard::getEcardList($value['ech_ecardid'])[0]; //ภาพการ์ดวันเกิด
                                                $ecard_greeting = ecard::getEcardGreeting($value['ech_cid'])[0]; //ข้อความการ์ดวันเกิด
                                                $user_wet = user::chkUser(array("gen_user_id" => $value['ech_from_userid']))[0]; //ข้อมูลผู้ใช้ EWT
                                                //$user_sso = $sso->getUser($user["gen_user"])["data"]; //ข้อมูลผู้ใช้ SSO
                                                $full_name = $user_wet["name_thai"] . ' ' . $user_wet["surname_thai"]; //ชื่อ-นามสกุลผู้ส่งการ์ดวันเกิด
                                                $user_image = getImage("profile/", $user_wet["webb_pic"], "images/user_profile_empty.png"); //รูปผู้ส่งการ์ดวันเกิด
                                                ?>
                                                <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                                    <a href="#" data-toggle="modal" data-target="#cardhbdpopup" id="<?php echo $value['ech_ecardid'] ?>" data-id="<?php echo $key; ?>">
                                                        <div class="profile__card__block shadow">
                                                            <div class="row">
                                                                <div class="col-lg-4 col-md-12 col-sm-4 col-4">
                                                                    <img src="<?php echo 'assets/images/ecard/' . (empty($ecard_list['ec_filename']) ? 'no_image.jpg' : $ecard_list['ec_filename']); ?> " class="card-hbd-fixsize" alt="<?php echo empty($ecard_list['ec_filename']) ? 'การ์ดอวยพรถูกนำออกจากระบบ' : $ecard_greeting['c_detail']; ?>" title="<?php echo empty($ecard_list['ec_filename']) ? 'การ์ดอวยพรถูกนำออกจากระบบ' : $ecard_greeting['c_detail']; ?>" id="ecard_image<?php echo $key; ?>">
                                                                    <input type="hidden" id="ecard_text<?php echo $key; ?>" value="<?php echo $ecard_greeting['c_detail']; ?>">
                                                                </div>
                                                                <div class="col-lg-6 col-md-12 col-sm-6 col-6">
                                                                    <div class="bd--title"><?php echo mb_strimwidth($ecard_greeting['c_detail'], 0, 35, '...'); ?></div>
                                                                </div>
                                                                <div class="col-lg-2 col-md-12 col-sm-2 col-2">
                                                                    <img src="<?php echo $user_image; ?>" class="profile--img--block" data-toggle="tooltip" id="ecard_user<?php echo $key; ?>" alt="<?php echo $full_name; ?>" title="<?php echo $full_name; ?>" width="40" height="40">
                                                                    <input type="hidden" id="ecard_name<?php echo $key; ?>" value="<?php echo $full_name ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            <?php } ?>
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

<!-- Modal -->
<div class="modal fade" id="cardhbdpopup" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header border-b-0">
                <h5 class="modal-title" id="staticBackdropLabel">
                    <i class="fas fa-birthday-cake"></i> การ์ดอวยพรวันเกิดของคุณ
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="profile__card__block shadow">

                            <div class="row">
                                <div class="col-12 text-center p-4">
                                    <div id="img_modal_new">
                                        <img src="<?php echo 'assets/images/ecard/' . (empty($ecard_list['ec_filename']) ? 'no_image.jpg' : $ecard_list['ec_filename']); ?>" class="card-img-top-fix" alt="<?php echo empty($ecard_list['ec_filename']) ? 'การ์ดอวยพรถูกนำออกจากระบบ' : $ecard_greeting['c_detail']; ?>" title="<?php echo empty($ecard_list['ec_filename']) ? 'การ์ดอวยพรถูกนำออกจากระบบ' : $ecard_greeting['c_detail']; ?>">
                                    </div>
                                </div>
                                <div class="col-12 px-5 pt-3">
                                    <blockquote class="blockquote px-3">
                                        <div id="caption">
                                            <p class="mb-0 px-5">
                                                <?php echo empty($ecard_greeting['c_detail']) ? null : $ecard_greeting['c_detail']; ?>
                                            </p>
                                        </div>
                                        <div style="font-family: Georgia, serif;position: absolute;bottom: -30px;line-height: 100px;right: 90px;font-size: 19em;color: rgba(238, 238, 238, 0.8);font-weight: normal;opacity: 0.5;">
                                        </div>
                                        <footer class="blockquote-footer pt-3 px-5">
                                            <div class="dis-inline" id="img_modal_user">
                                                <img src="<?php echo $user_image; ?>" class="rounded-circle max-width50px shadow-user" alt="<?php echo $full_name; ?>" title="<?php echo $full_name; ?>">
                                            </div>
                                            <div class="dis-inline" id="fullname">
                                                คุณ<?php echo $full_name; ?>
                                            </div>
                                        </footer>
                                    </blockquote>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $("[data-toggle='modal']").on("click", function(event) {
        // alert(<?php echo $value['ech_ecardid'] ?>);   
        var ImgId = this.id;
        var Id = $(this).attr("data-id");
        var img = document.getElementById("ecard_image" + Id);
        var modalImg = document.getElementById("img_modal_new");

        var imguser = document.getElementById("ecard_user" + Id);
        var modaluser = document.getElementById("img_modal_user");

        var captionText = document.getElementById("caption");
        var text = document.getElementById("ecard_text" + Id).value;
        // alert(text);

        var name = document.getElementById("fullname");
        var nametext = document.getElementById("ecard_name" + Id).value;
        // alert(nametext);
        modalImg.src = this.src;
        modalImg.innerHTML = '<img src="' + img.src + '"  class="img-fluid">';
        modaluser.innerHTML = '<img src="' + imguser.src + '" class="rounded-circle max-width50px shadow-user">';
        captionText.innerHTML = text;
        name.innerHTML = nametext;

    });
</script>

<script type="text/javascript">
    $("#btn_search").click(function() {
        window.location.href = 'receive_card_hbd.php?ech_date_year=' + $('#ech_date_year').val();
    });
</script>

<!-- Open Footer -->
<?php include('footer.php'); ?>
<?php include('combottom.php'); ?>
<!-- Close Footer -->