<?php include('comtop.php'); ?>
<?php include('navigation.php'); ?>
<?php include('menu.php'); ?>
<?php include('component/captcha_webboard_answer.php'); ?>
<?php
$webboard_config = webboard::getConfig();
$webboard_question = webboard::getWQuestion($t_id, $c_id);
$webboard_answer = webboard::getWAnswer($a_id, $t_id);
$webboard_request_chk = webboard::getWQuestionStsRequest(null, $t_id, $a_id, "T")["count"];
$webboard_emotion = webboard::getEmotion();
$webboard_vulgar = webboard::getVulgar()["vulgar_text"];
$webboard_q = $webboard_question["data"][0]; //เรียกข้อมูลกระทู้
$webboard_c = webboard::getWCate($webboard_q["c_id"])["data"][0]; //เรียกข้อมูลหมวดกระทู้
$webboard_a = $webboard_answer["data"]; //เรียกข้อมูลตอบคำถาม
$gen_user = webboard::getUser($webboard_q["user_id"]); //เรียกข้อมูลผู้ตั้งกระทู้
//$user = $sso->getUser($gen_user["gen_user"])["data"];
$user = user::chkUser(array("gen_user_id" => $webboard_q["user_id"]))[0];
$user_name = '';
switch ($webboard_config["c_show_question"]) {
    case 'Y':
        if ($webboard_q["user_id"] == 0) {
            $user_name .= "แอดมิน";
        } else {
            if ($webboard_q["t_web_name"] == 1) {
                $user_name .= !empty($user["web_name"]) ? $user["web_name"] : $user["name_thai"] . ' ' . $user["surname_thai"];
            } else {
                $user_name .= $user["name_thai"] . ' ' . $user["surname_thai"];
            }
        }
        break;
}
?>
<!-- Style CSS Template 3 -->
<link rel="stylesheet" href="assets/css/article.css">
<link rel="stylesheet" href="assets/css/webboard.css">

<div class="container-fluid header--bg text-center">
    <div class="container py-4 ">
        <div class="article--topic">
            <h1><?php echo cutWords($webboard_vulgar, trim($webboard_q["t_name"])); ?> </h1>
        </div>
        <div>
            <a class="link-text-white" href="index.php" title="กลับหน้าหลัก">หน้าหลัก</a>&nbsp;/&nbsp;<a class="link-text-white" href="webboard.php" title="กระดานถามตอบ">กระดานถามตอบ </a>&nbsp;/&nbsp;<a class="link-text-white" href="more_webboard.php?c_id<?php echo $webboard_c["c_id"]; ?>" title="<?php echo cutWords($webboard_vulgar, trim($webboard_c["c_name"])); ?>"> <?php echo cutWords($webboard_vulgar, trim($webboard_c["c_name"])); ?> </a>
        </div>
    </div>
</div>

<section id="article-sec bg--white">
    <div class="container mt-3">
        <!-- start breadcrumb -->
        <!-- <p>
            <a href="index.php" title="กลับหน้าหลัก">หน้าหลัก</a>&nbsp;/&nbsp;<a href="webboard.php" title="กระดานถามตอบ">กระดานถามตอบ </a>&nbsp;/&nbsp;<a href="more_webboard.php?c_id<?php echo $webboard_c["c_id"]; ?>" title="<?php echo cutWords($webboard_vulgar, trim($webboard_c["c_name"])); ?>"> <?php echo cutWords($webboard_vulgar, trim($webboard_c["c_name"])); ?> </a>
        </p> -->
        <!-- start breadcrumb -->
        <hr>
    </div>

    <div class="container mb-4">

        <!-- Open Accordions -->
        <div class="contianer mt-5">
            <!-- Open Topic -->

            <!-- Close Topic -->

            <!-- Open Comment -->
            <div class="row mt-3 font18px">
                <div class="col-12 mb-3">
                    <div class="mb-4">
                        <blockquote class="blockquote mb-0 mb-4 font18px">
                            <footer class="blockquote-footer">
                                <span class="pr-2">
                                    <em class="fa fa-user-circle"></em> <?php echo $user_name; ?>
                                </span>
                                <span class="pr-2">
                                    <em class="fa fa-calendar"></em>
                                    <?php echo convDateThai($webboard_q["t_date"])["Date"]; ?> |
                                    <?php echo date("H:i:s", strtotime($webboard_q["t_time"])); ?>
                                </span>
                                <?php if ($webboard_request_chk > 0) { ?>
                                <?php } else { ?>
                                    <span class="pr-2">
                                        <a href="#" data-toggle="modal" data-target="#deletepost">
                                            <em class="fa fa-trash"></em> แจ้งลบกระทู้
                                        </a>
                                    </span>
                                <?php } ?>
                            </footer>
                        </blockquote>

                        <p class="font20px line-h-comment">
                            <!-- Open delete class="d-flex"  17/05/2565 -->
                        <div class="border-l-comment">
                            <!-- Close delete class="d-flex"  17/05/2565 -->
                            <!-- <?php echo ($webboard_request_chk > 0 ? "color:red" : null) ?> -->
                            <!-- <?php echo ($webboard_request_chk > 0 ? "กระทู้นี้ถูกแจ้งลบ โปรดรอดำเนินการจากแอดมิน" : $webboard_q["t_detail"]); ?> -->
                            <?php echo cutWords($webboard_vulgar, trim($webboard_q["t_detail"])); ?>
                        </div>
                        </p>
                    </div>
                </div>

                <?php
                if (!empty($t_id)) {
                    if ($webboard_request_chk == 0) {
                        foreach ($webboard_a as $key => $value) { ?>
                            <?php
                            $webboard_chk = webboard::getWQuestionStsRequest(null, $t_id, $value["a_id"], "A")["count"];
                            $gen_user = webboard::getUser($value["user_id"]);
                            //$user = $sso->getUser($gen_user["gen_user"])["data"];
                            $user = user::chkUser(array("gen_user_id" => $value["user_id"]))[0]; //ข้อมูล EWT
                            $user_name = '';
                            switch ($webboard_config["c_show_answer"]) {
                                case 'Y':
                                    if ($webboard_q["user_id"] == 0) {
                                        $user_name .= "แอดมิน";
                                    } else {
                                        if ($webboard_q["t_web_name"] == 1) {
                                            $user_name .= !empty($user["webb_name"]) ? $user["webb_name"] : $user["name_thai"] . ' ' . $user["surname_thai"];
                                        } else {
                                            $user_name .= $user["name_thai"] . ' ' . $user["surname_thai"];
                                        }
                                    }
                                    break;
                            }
                            $num_a = $webboard_answer["count"] - $key;
                            $a_text = cutWords($webboard_vulgar, trim($value["a_detail"]));
                            ?>
                            <div class="col-12 <?php echo $key > 0 ? "mt-3" : null; ?>">
                                <div class="card">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item answer-webboard font22px bg-comment">
                                            ความคิดเห็นที่ <?php echo $num_a; ?>
                                            <input type="hidden" name="request_num" id="request_num" value="<?php echo $num_a; ?>">
                                        </li>
                                        <li class="list-group-item">
                                            <blockquote class="blockquote mb-0 font18px">
                                                <!-- Open delete class="d-flex"  17/05/2565 -->
                                                <div class="container">
                                                    <div class="mt-3">
                                                        <?php echo $a_text; ?>
                                                    </div>
                                                </div>
                                                <footer class="blockquote-footer mt-4">
                                                    <span class="pr-2">
                                                        <em class="fa fa-user-circle"></em>
                                                        <?php echo $user_name; ?>
                                                    </span>

                                                    <span class="pr-2">
                                                        <em class="fa fa-calendar"></em>
                                                        <?php echo convDateThai($value["a_date"])["Date"]; ?> |
                                                        <?php echo date("H:i:s", strtotime($value["a_time"])); ?>
                                                    </span>

                                                    <!-- <span class="pr-2">
                                                    <a onclick="setEventWebboardId(null,null,<?php echo $value['a_id'] ?>, <?php echo $num_a ?>,'answer','list_answer_ea')" href="#" data-toggle="modal" data-target="#editpost">
                                                        <em class="fa fa-pencil"></em> แก้ไขความคิดเห็น
                                                    </a>
                                                </span> -->

                                                    <span class="pr-2">
                                                        <a onclick="setEventWebboardId(null,null,<?php echo $value['a_id'] ?>, <?php echo $num_a ?>,'answer','list_answer_a')" href="#" data-toggle="modal" data-target="#deletecomment">
                                                            <em class="fa fa-trash"></em> แจ้งลบความคิดเห็น
                                                        </a>
                                                    </span>
                                                </footer>
                                            </blockquote>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                <?php }
                    }
                } ?>
            </div>
            <!-- Close Comment -->

            <!-- Open box comment -->
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item answer-webboard font22px bg-insert">
                                # ร่วมแสดงความคิดเห็น
                            </li>
                            <li class="list-group-item font1-3em">
                                <form class="mt-3 font20px webboard" id="list_webboard_answer">
                                    <div class="form-group row">
                                        <label for="" class="col-sm-3 col-form-label font18px"><span class="red">*</span> ชื่อของคุณ </label>
                                        <div class="col-sm-9">
                                            <input type="text" name="a_name" id="a_name" class="form-control font18px" value="<?php echo !empty($webb_name) ? $webb_name : $full_name; ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputdetial" class="col-sm-3 col-form-label font18px"><span class="red">*</span> ความคิดเห็น </label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control ckeditor font18px" name="a_detail" id="a_detail" rows="3" placeholder="กรอกความคิดเห็น"></textarea>
                                            <!-- <div class="text_wrapper text_emotion" contentEditable="true" hidefocus="true"></div> -->
                                            <div class="dis-flex p-2">
                                                <?php foreach ($webboard_emotion["data"] as $key => $value) { ?>
                                                    <img src="<?php echo $value["emotion_img"]; ?>" class="width-emotion" style="cursor:pointer;" onClick="setsmile('<?php echo $value["emotion_img"]; ?>')">
                                                <?php } ?>
                                            </div>

                                            <!-- <div class="dis-flex p-2 text-primary">
                                                *เพิ่มอิโมจิโดยคลิกเลือกลางวางที่กล่องข้อความ
                                            </div> -->
                                        </div>
                                    </div>

                                    <!-- <?php gen_pic('webboard_answer'); ?> -->

                                    <div class="form-group row">
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-9 text-left">
                                            <input type="hidden" name="type_post" id="type_post" value="weboard_answer">
                                            <input type="hidden" name="a_picture" id="a_picture" value="<?php echo $user_sso["USR_PICTURE"]; ?>">
                                            <input type="hidden" name="a_email" id="a_email" value="<?php echo $email_person; ?>">
                                            <button type="submit" class="btn btn-success font18px border-ra-30px px-3">ตอบกระทู้</button>
                                        </div>
                                    </div>
                                </form>

                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="alert alert-warning line-h-comment font18px" role="alert">
                กรุณาแสดงความคิดเห็นอย่างสร้างสรรค์ หน่วยงานจะไม่รับผิดชอบต่อความคิดเห็นใดๆ ทั้งสิ้น เพราะไม่สามารถระบุได้ว่าเป็นความจริง ผู้อ่านจึงควรใช้วิจารณญาณในการกลั่นกรอง หรือถ้าท่านพบเห็นข้อความใดที่ขัดต่อกฎหมายและศีลธรรม หรือเป็นการกลั่นแกล้งเพื่อให้เกิดความเสียหาย ต่อบุคคล หรือหน่วยงานใด สามารถแจ้งลบความคิดเห็นหรือลบกระทู้ได้ที่ระบบเว็บบอร์ด เพื่อให้ผู้ดูแลระบบทราบและทำการพิจารณาลบข้อความนั้น ขอขอบพระคุณล่วงหน้า มา ณ โอกาสนี้
            </div>
            <!-- Close box comment -->
        </div>
        <!-- Close Accordions -->
    </div>
</section>

<!-- Modal delete post -->
<div class="modal fade" id="deletepost" tabindex="-1" aria-labelledby="newpost" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font20px" id="newpost"> แจ้งลบกระทู้ หัวข้อ "<?php echo $webboard_q["t_name"]; ?>" </h5>
                <button type="button" class="close btn_close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form class="webboard" id="list_webboard_answer_q">
                <div class="modal-body">
                    <div class="form-group row font18px">
                        <label for="inputtopic-w" class="col-sm-2 col-form-label font18px"><span class="red">*</span> โดย </label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control font18px" value="<?php echo !empty($webb_name) ? $webb_name : $full_name; ?>" disabled>
                        </div>
                    </div>
                    <div class="form-group row font18px">
                        <label for="request_reason" class="col-sm-2 col-form-label font16px"><span class="red">*</span> ความคิดเห็น </label>
                        <div class="col-sm-10">
                            <textarea class="form-control font18px" name="request_reason" id="request_reason" rows="3" placeholder="กรอกความคิดเห็น" required></textarea>
                            <!-- <div class="dis-flex p-2">
                                <?php foreach ($webboard_emotion["data"] as $key => $value) { ?>
                                    <img src="<?php echo $value["emotion_img"]; ?>" class="width-emotion" style="cursor:pointer;">
                                <?php } ?>
                            </div>
                            <div class="dis-flex p-2 text-primary">
                                *เพิ่มอิโมจิโดยคลิกเลือกลางวางที่กล่องข้อความ
                            </div> -->
                        </div>
                    </div>
                    <!-- <?php gen_pic2('webboard_answer_q'); ?> -->
                </div>

                <div class="modal-footer">
                    <input type="hidden" name="type_post" id="type_post" value="weboard_answer_q">
                    <input type="hidden" name="approve_sts" id="approve_sts" value="<?php echo $webboard_q["s_id"]; ?>">
                    <input type="hidden" name="request_type" id="request_type" value="T">
                    <input type="hidden" name="request_email" id="reauest_email" value="<?php echo $email_person; ?>">
                    <button type="button" class="btn btn-danger font18px border-ra-30px px-3 btn_close" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-success font18px border-ra-30px px-3"> แจ้งลบกระทู้ </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal delete comment -->
<div class="modal fade" id="deletecomment" tabindex="-1" aria-labelledby="deletecomment" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font20px" id="deletecomment"> แจ้งลบความคิดเห็น หัวข้อ "<?php echo $webboard_q["t_name"]; ?>" </h5>
                <button type="button" class="close btn_close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form class="webboard" id="list_webboard_answer_a">
                <div class="modal-body">
                    <div class="alert alert-secondary line-h-comment font18px" id="list_answer_a" role="alert"></div>

                    <div class="form-group row">
                        <label for="inputtopic-w" class="col-sm-2 col-form-label font16px"><span class="red">*</span> โดย
                        </label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control font18px" value="<?php echo !empty($webb_name) ? $webb_name : $full_name; ?>" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputdetial" class="col-sm-2 col-form-label font16px"><span class="red">*</span> ความคิดเห็น
                        </label>
                        <div class="col-sm-10">
                            <textarea class="form-control font18px" name="request_reason" id="request_reason" rows="3" placeholder="กรอกความคิดเห็น" required></textarea>
                            <!-- <div class="dis-flex p-2">
                                <?php foreach ($webboard_emotion["data"] as $key => $value) { ?>
                                    <img src="<?php echo $value["emotion_img"]; ?>" class="width-emotion" style="cursor:pointer;">
                                <?php } ?>
                            </div>
                            <div class="dis-flex p-2 text-primary">
                                *เพิ่มอิโมจิโดยคลิกเลือกลางวางที่กล่องข้อความ
                            </div> -->
                        </div>
                    </div>
                    <!-- <?php gen_pic2('webboard_answer_a'); ?> -->
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="type_post" id="type_post" value="weboard_answer_a">
                    <input type="hidden" name="request_type" id="request_type" value="A">
                    <input type="hidden" name="request_email" id="reauest_email" value="<?php echo $email_person; ?>">
                    <button type="button" class="btn btn-danger font18px border-ra-30px px-3 btn_close" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-success font18px border-ra-30px px-3"> แจ้งลบความคิดเห็น </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editpost" tabindex="-1" aria-labelledby="newpost" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font20px" id="newpost"> แก้ไขความคิดเห็น ห้วข้อ"<?php echo $webboard_q["t_name"]; ?>" </h5>
                <button type="button" class="close btn_close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form class="webboard" id="list_webboard_answer_ea">
                <div class="modal-body">
                    <div class="alert alert-secondary line-h-comment font18px" id="list_answer_ea" role="alert"></div>

                    <div class="form-group row">
                        <label for="inputtopic-w" class="col-sm-2 col-form-label font16px"><span class="red">*</span> โดย
                        </label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control font18px" value="<?php echo !empty($webb_name) ? $webb_name : $full_name; ?>" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputdetial" class="col-sm-2 col-form-label font16px"><span class="red">*</span> ความคิดเห็น
                        </label>
                        <div class="col-sm-10">
                            <textarea class="form-control font18px" name="request_reason" id="request_reason" rows="3" placeholder="กรอกความคิดเห็น"></textarea>
                            <!-- <div class="dis-flex p-2">
                                <?php foreach ($webboard_emotion["data"] as $key => $value) { ?>
                                    <img src="<?php echo $value["emotion_img"]; ?>" class="width-emotion" style="cursor:pointer;">
                                <?php } ?>
                            </div>
                            <div class="dis-flex p-2 text-primary">
                                *เพิ่มอิโมจิโดยคลิกเลือกลางวางที่กล่องข้อความ
                            </div> -->
                        </div>
                    </div>
                    <!-- <?php gen_pic2('webboard_answer_a'); ?> -->
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="type_post" id="type_post" value="weboard_answer_ea">
                    <button type="button" class="btn btn-danger font18px border-ra-30px px-3 btn_close" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-success font18px border-ra-30px px-3"> แก้ไขความคิดเห็น </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/JavaScript">
    function setsmile(what) {
    CKEDITOR.instances["a_detail"].insertHtml('<img src =' +what+ ' width="30" >');
  }
</script>

<style type="text/css">
    p {
        display: flex;
    }
</style>
<?php include 'component/webboard_modal.php'; ?>
<?php include('footer.php'); ?>
<?php include('combottom.php'); ?>