<?php include('comtop.php'); ?>
<?php include('header.php'); ?>
<?php

//$contact_org = $sso->getContact($start_contact, $per_page_contact, $s_name, $org_name);
//$contact_org_name = $sso->getDepartments()["dataAll"];
// $org_name = $sso->getDepartment(array("DEP_ID" => $org_id));
//$total_page_contact = ceil($contact_org["countAll"] / $per_page_contact);
?>

<!-- Style CSS Template 3 -->
<link rel="stylesheet" href="assets/css/article.css">
<link rel="stylesheet" href="assets/css/contact.css">

<div class="container-fluid mar-t-90px header--bg">
    <div class="container py-5 text-center">
        <h3> รายชื่อบุคลากร </h3>
    </div>
</div>

<section class="search-sec header--bg">
    <div class="container">
        <form action="#" method="post" novalidate="novalidate">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-sm-12 p-0">
                            <input type="text" name="s_name" id="s_name" class="form-control search-slt" placeholder="ชื่อ,นามสกุล" list="datalistOptions" value="<?php echo $s_name; ?>">
                            <datalist id="datalistOptions">
                                <!-- <?php foreach ($contact_org["data_user"] as $key => $value) { ?>
                                    <option value="<?php echo $value["USR_FNAME"] . ' ' . $value["USR_LNAME"]; ?>">
                                        <?php echo $value["USR_PREFIX"] . ' ' . $value["USR_FNAME"] . ' ' . $value["USR_LNAME"]; ?>
                                    </option>
                                <?php } ?> -->
                            </datalist>
                        </div>

                        <div class="col-lg-5 col-md-5 col-sm-12 p-0">
                            <select name="org_name" id="org_name" class="form-control search-slt search-select">
                                <option value=""> ทุกหน่วยงานภายใน </option>
                                <!-- <?php foreach ($contact_org_name as $key => $value) { ?>
                                    <option value="<?php echo $value["DEP_NAME"]; ?>" <?php echo (!empty($org_name) && $org_name == $value["DEP_NAME"] ? "selected" : null); ?>>
                                        <?php echo $value["DEP_NAME"]; ?>
                                    </option>
                                <?php } ?> -->
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12 p-0">
                            <button type="button" class="btn btn--search wrn-btn" name="btn_search" id="btn_search">
                                ค้นหา 
                            </button>
                        </div>
                    </div>

                </div>

            </div>
        </form>
    </div>
</section>
<div class="container-fluid padding--50">
    <div class="container">
        <?php if (!empty($s_name) || !empty($org_name)) { ?>
            <div class="text-center mb-3 text-red"> ผลการค้นหา
                <?php echo (!empty($s_name) ? '"' . $s_name . '' : null) . (empty($s_name) || empty($org_name) ? '"' : ' ') . (!empty($org_name) ? '' . $org_name . '"' : null); ?>
                พบทั้งหมด <?php echo $contact_org["countAll"]; ?> รายการ </div>
        <?php } ?>

        <div class="row">
            <!-- <?php foreach ($contact_org["data"] as $key => $value) { ?>
                <?php
                $position = $sso->getPosition($value["POS_ID"]);
                ?>
                <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                    <div class="block-contact">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-12 col-3">
                                <a style="cursor:pointer" data-toggle="collapse" data-target="#contact<?php echo $key; ?>" aria-expanded="false" aria-controls="contact<?php echo $key; ?>">
                                    <img src="<?php echo !empty($value["USR_PICTURE"]) ? "profile/" . $value["USR_PICTURE"] : "images/user_profile_empty.png"; ?>" class="img-staff">
                                </a>
                            </div>

                            <div class="col-lg-9 col-md-9 col-sm-12 col-9">
                                <div class="contact-title">
                                    <a style="cursor:pointer" data-toggle="collapse" data-target="#contact<?php echo $key; ?>" aria-expanded="false" aria-controls="contact<?php echo $key; ?>">
                                        <?php echo $value["USR_PREFIX"] . ' ' . $value["USR_FNAME"] . ' ' . $value["USR_LNAME"]; ?>
                                    </a>
                                </div>

                                <div class="contact-subtitle1">
                                    <?php if (!empty($position["data"]["POS_NAME"])) {
                                        if ($value["USR_PRE_STATUS"] == 1 || $value["USR_PRE_STATUS"] == 2) {
                                            $USR_LEVEL_NAME = explode("ระดับ", $value["USR_LEVEL_NAME"]);
                                        }

                                        if(!empty($value["USR_MPOSITION"])){
                                            $POS_NAME = $value["USR_MPOSITION"];
                                        }else{
                                            $POS_NAME = $position["data"]["POS_NAME"]. '' . $USR_LEVEL_NAME[1];
                                        }
                                    ?>
                                        ตำแหน่ง : <?php echo $POS_NAME; ?></br>
                                    <?php } ?>
                                    <?php if (!empty($value["USR_DIVISION"])) { ?>
                                        สำนัก/กอง : <?php echo $value["USR_DIVISION"]; ?></br>
                                    <?php } ?>
                                    <?php if ($value["USR_DIVISION"] != $value["USR_DEPARTMENT"]) {
                                        if (!empty($value["USR_DEPARTMENT"])) {
                                    ?>
                                            ส่วน/กลุ่ม/ฝ่าย : <?php echo $value["USR_DEPARTMENT"]; ?></br>
                                    <?php }
                                    } ?>
                                </div>

                                <div class="collapse" id="contact<?php echo $key; ?>">
                                    <?php if (!empty($value["USR_TEL"])) { ?>
                                        <div class="contact-subtilte">
                                            <small>มือถือ</small>
                                            <div>
                                                <a href="tel:<?php echo $value["USR_TEL"]; ?>" title="<?php echo $value["USR_TEL"]; ?>">
                                                    <?php echo $value["USR_TEL"]; ?>
                                                </a>
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <?php if (!empty($value["USR_EMAIL"])) { ?>
                                        <div>
                                            <small>อีเมล</small>
                                            <div>
                                                <a href="mailto:<?php echo $value["USR_EMAIL"]; ?>" title="<?php echo $value["USR_EMAIL"]; ?>">
                                                    <?php echo $value["USR_EMAIL"]; ?>
                                                </a>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?> -->
        </div>

        <!-- Start แสดงการตัดหน้าเพจ -->
        <!-- <?//php echo pagination('contact.php', 's_name=' . $s_name . '&org_name=' . $org_name . '', $page, $per_page_contact, $contact_org["countAll"]); ?> -->
        <?php echo pagination_ewt('contact.php', 's_name=' . $s_name . '&org_name=' . $org_name . '', $page, $per_page_contact, $contact_org["countAll"]); ?>
        <!-- End แสดงการตัดหน้าเพจ-->
    </div>
</div>

<!-- เคลียร์ค่าช่องค้นหา -->
<script>
    $("#s_name").click(function() {
        $('#s_name').val('');
    });
</script>

<!-- ค้นหาด้วยการคลิกปุ่มหรือ Enter แสดงรายการที่ค้นหา ที่กล่องข้อมูล -->
<script type="text/javascript">
    $("#btn_search").click(function() {
        window.location.href = 'contact.php?s_name=' + $('#s_name').val() + '&org_name=' + $('#org_name').val();
    });
</script>

<?php include('footer.php'); ?>
<?php include('combottom.php'); ?>