<?php include('comtop.php'); ?>
<?php include('header.php'); ?>
<?php
$category_data = faq::getCategory();
$more_faq_title_category = faq::getFaqTitleCategory($faq_cate_id);
$more_faq_category = faq::getFaqCategory($faq_cate_id);
$more_sub_faq_category = faq::getSubFaqCategory($faq_cate_id);
$more_faq = faq::getFaq($start_faq, $per_page_faq, $faq_cate_id);
$total_page_more_faq = ceil($more_faq["countAll"] / $per_page_faq);
$faq_cate_parent = $more_faq_category[0]["faq_cate_parent"];
?>

<!-- Style CSS Template 3 -->
<link rel="stylesheet" href="assets/css/article.css">
<link rel="stylesheet" href="assets/css/faq.css">

<style>
    .faq_icon{
        display: inline-block;
    width: 32px;
    height: 32px;
    line-height: 26px;
    float: left;
    -webkit-border-radius: 100px;
    -moz-border-radius: 100px;
    border-radius: 100px;
    text-align: center;
    background: #5b5aa8;
    color: #fff;
    font-size: 12px;
    margin-right: 20px;
    }
    .text_faq{
        color:#fff;
    }
</style>

<div class="container-fluid mar-t-90px header--bg">
    <div class="container py-5 text-center">
        <h3 class="text-white"><?php echo $more_faq_category[0]["faq_cate_title"]; ?></h3>
        <small class="text-white">
            <em class="fa fa-home"></em> /
            <a href="faq.php" title="คำถามที่พบบ่อย" class="text-white">คำถามที่พบบ่อย </a>

            <?php if ($faq_cate_parent != 0) {
                foreach ($category_data[$faq_cate_parent] as $key => $value) { ?>
                    / <a class="text_faq" href="more_faq.php?faq_cate_id=<?php echo $value["faq_cate_id"]; ?>" title="<?php echo $value["faq_cate_title"]; ?>"><?php echo $value["faq_cate_title"]; ?> </a>
            <?php }
            } ?>

            <?php foreach ($more_faq_title_category as $key => $value) { ?>
                / <a class="text_faq" href="more_faq.php?faq_cate_id=<?php echo $value["faq_cate_id"]; ?>" title="<?php echo $value["faq_cate_title"]; ?>"><?php echo $value["faq_cate_title"]; ?> </a>
            <?php } ?>
        </small>
    </div>
</div>
<div class="container-fluid">
    <div class="container mt-5">

        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-9">

                <!-- ส่วนแสดงรายการ -->
                <p>แสดง <?php echo $more_faq["countAll"]; ?> รายการคำถามที่พบบ่อย</p>
                <div class="mt-3 mb-5">
                    <div class="">
                        <div class="faq" id="accordion">
                            <?php foreach ($more_faq["data"] as $key => $value) { ?>
                                <?php
                                if ($value["fa_user_ask"] === "prd_intra_web") {
                                    $fa_name_ask = "แอดมิน";
                                } else {
                                    //$user_sso = $sso->getUser($value["fa_user_ask"])["data"];
                                    $user_ewt = user::chkUser(array("gen_user" => $value["fa_user_ask"]))[0]; //ข้อมูล EWT
                                    //$fa_name_ask = $user_sso["USR_FNAME"] . ' ' . $user_sso["USR_LNAME"];
                                    $fa_name_ask = $user_ewt["name_thai"] . ' ' . $user_ewt["surname_thai"];
                                }
                                ?>
                                <div class="card">
                                    <div onclick="faqCount(<?php echo $value['fa_id']; ?>);" class="card-header" id="faqHeading-<?php echo $key + 1; ?>">
                                        <div class="mb-0">
                                            <h5 class="faq-title" data-toggle="collapse" data-target="#faqCollapse-<?php echo $key + 1; ?>" data-aria-expanded="true" data-aria-controls="faqCollapse-<?php echo $key + 1; ?>">
                                                <span class="faq_icon" style="background:<?php echo ($value["faq_top"] == "Y" ? "#751b7d" : "#5b5aa8"); ?>">
                                                    <em class="<?php echo ($value["faq_top"] == "Y" ? "fas fa-thumbtack" : "fa fa-question"); ?>"></em>
                                                </span>
                                                <?php echo $value["fa_name"]; ?>
                                                <span class="faq-viewStat" id="list_count_txt<?php echo $value['fa_id']; ?>"><?php echo $value["fa_count"]; ?> วิว</span>
                                            </h5>
                                        </div>
                                    </div>

                                    <div id="faqCollapse-<?php echo $key + 1; ?>" class="collapse" aria-labelledby="faqHeading-<?php echo $key + 1; ?>" data-parent="#accordion">
                                        <div class="card-body">

                                            <?php echo $value["fa_ans"]; ?>

                                            <div class="row mt-3 bt1">
                                                <div class="col-4" id="list_count<?php echo $value['fa_id']; ?>">
                                                    <small class="mb-3">
                                                        <em class="fas fa-thumbtack"></em>
                                                        <em class="fa fa-eye"></em> <?php echo $value["fa_count"]; ?>
                                                    </small>
                                                </div>
                                                <div class="col-8 text-right">
                                                    <small class="mb-3">
                                                        <em class="far fa-user"></em> <?php echo $fa_name_ask; ?>
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <!-- จบส่วนแสดงรายการ -->
                <!-- Start แสดงการตัดหน้าเพจ -->
                <div class="text-center">
                    <div class="pagination p6">
                        <ul>
                            <?php echo pagination('more_faq.php', '&faq_cate_id=' . $faq_cate_id . '&fa_id=' . $fa_id . '&s_search=' . $s_search . '', $page, $per_page_faq, $total_page_more_faq); ?>
                        </ul>
                    </div>
                </div>
                <!-- End แสดงการตัดหน้าเพจ-->
            </div>

            <div class="col-lg-3 col-md-3 col-sm-3 mb-5">
                <div class="article--subcat">หมวดหมู่</div>
                <ul class="list-group shadow">
                    <?php foreach ($more_faq_category as $key => $value) { ?>
                        <li class="list-group-item <?php echo ($faq_cate_id == $value["faq_cate_id"] ? "active" : null); ?>">
                            <a href="more_faq.php?faq_cate_id=<?php echo $value["faq_cate_id"]; ?>">
                                <em class="<?php echo ($value["faq_cate_parent"] == 0 ? "fa fa-folder-open" : "fa fa-arrow-right"); ?>"></em> <?php echo $value["faq_cate_title"]; ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- นับจำนวนการเปิดดูคำถาม -->
<script type="text/javascript">
    function faqCount(fa_id) {
        $.ajax({
            type: 'POST',
            url: 'ajax/faq.ajax.php',
            data: {
                fa_id: fa_id
            },
            datatype: "text",
            success: function(data) {
                let object = JSON.parse(data, true);
                $('#list_count' + object.fa_id).html('<p></p');
                $('#list_count' + object.fa_id).html(object.faq_count);
                $('#list_count_txt' + object.fa_id).html(object.faq_count_txt);
            },
            error: function() {
                console.log('Error');
            }
        });
    }
</script>

<?php include('footer.php'); ?>
<?php include('combottom.php'); ?>