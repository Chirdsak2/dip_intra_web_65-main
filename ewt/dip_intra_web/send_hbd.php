<!-- Open Top -->
<?php include('comtop.php'); ?>
<?php include('header.php'); ?>
<!-- Close Top -->
<?php $ecard_user = $sso->getEcardUser(date('Y-m-d')); ?>

<!-- Font on Website -->
<link rel="stylesheet" href="assets/css/profile.css">

<div class="container-fluid b__profile mar-t-90px">
    <div class="container py-5 text-center">
        <h3 class="h-ecard-page">
            <?php echo convDateThai(date("Y-m-d"))["DateThai"]. ' ร่วมส่งการ์ดอวยพรวันเกิด '. $ecard_user["count"]. ' ท่าน'; ?>
            <!-- <div class="my-2">ร่วมส่งการ์ดอวยพรวันเกิด </div>
            <div class="font35px my-2"> <?php echo $ecard_user["count"]; ?> ท่าน </div> -->
        </h3>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <!-- Send HBD -->
                <div class="">
                    <!-- bg--white shadow -->
                    <div class="mt-3 mb-5">
                        <div class="row">
                            <?php foreach ($ecard_user["dataAll"] as $key => $value) { ?>
                                <?php 
                                    $user_image = getImgbase64("profile/" . $value["USR_PICTURE"], "images/user_profile_empty.png"); 
                                    $user_sso_org = $sso->getDepartment(array("DEP_ID" => $value["DEP_ID"]))["data"]; 
                                    $user_sso_pos = $sso->getPosition($value["POS_ID"])["data"]; 
                                    $user_ewt = user::chkUser(array("gen_user" => $value["USR_USERNAME"]));
                                ?>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                                    <a href="#" data-toggle="modal" data-target="#modal_birth_date" onclick="setEventEcardId(<?php echo $value['USR_ID']; ?>,<?php echo $user_ewt[0]['gen_user_id']; ?>)">
                                        <div class="media p-3 mb-4 profile__card__block shadow">
                                            <img src="<?php echo $user_image; ?>" class="mr-3 pic-width-hbd border-ra-10px" alt="ceo1">
                                            <div class="media-body font12px text-left">
                                                <div class="font15px font-weight-bold txt-purple-t3 mb-1"> <?php echo $value['USR_FNAME'] . ' ' . $value['USR_LNAME']; ?> </div>
                                                <div class="font13px txt-purple-t3"><i class="far fa-user font11px"></i> <?php echo $user_sso_pos["POS_NAME"]; ?> </div>
                                                <div class="font13px txt-purple-t3 mb-1"><i class="far fa-folder-open font11px"></i> <?php echo $user_sso_org["DEP_NAME"]; ?> </div>
                                                <a href="#" data-toggle="modal" data-target="#modal_birth_date" onclick="setEventEcardId(<?php echo $value['USR_ID']; ?>,<?php echo $user_ewt[0]['gen_user_id']; ?>)">
                                                    <div class="btn-hbd-gift txt-white">
                                                        <img src="assets/img/icon-gift.png" alt="gift" title="gift" class="" style="width: 25px;">
                                                        ส่งการ์ดอวยพร
                                                    </div>
                                                </a>
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

<!-- Card วันเกิด -->
<?php include('component/ecard_modal.php'); ?>
<!-- Modal -->

<!-- Open Footer -->
<?php include('footer.php'); ?>
<?php include('combottom.php'); ?>
<!-- Close Footer -->