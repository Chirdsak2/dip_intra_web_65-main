<?php include('comtop.php'); ?>
<?php include('header.php'); ?>
<?php
$faq_category = faq::getFaqCategory();
$faq = faq::getFaq($start_faq, $per_page_faq, $faq_cate_id, $fa_id, $s_search, $faq_type);
//$total_page_faq = ceil($faq["countAll"] / $per_page_faq);
?>

<!-- Style CSS Template 3 -->
<link rel="stylesheet" href="assets/css/article.css">
<link rel="stylesheet" href="assets/css/faq.css">
<style>
    .faq_icon {
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
</style>
<div class="container-fluid mar-t-90px header--bg">
    <div class="container py-5 text-center">
        <h3 class="text-white">คำถามที่พบบ่อย </h3>
        <small><em class="fa fa-home text-white"></em> <a href="faq.php" class="text-white" title="คำถามที่พบบ่อย"> / คำถามที่พบบ่อย </a></small>
    </div>
</div>

<div class="container-fluid">
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-9">
                <!-- ส่วนการค้นหา -->
                <form>
                    <!-- <div class="input-group mb-4 border p-1">
                        <input type="search" name="search_faq" id="search_faq" placeholder="พิมพ์รายการที่ต้องการค้นหา" aria-describedby="btn_search" class="form-control bg-none border-0" list="datalistOptions" value="<?php echo $s_search; ?>">
                        <datalist id="datalistOptions">
                            <?php //foreach ($faq["data"] as $key => $value) { ?>
                                <option value="<?php //echo $value["faq_name"]; ?>"><?php //echo $value["faq_name"]; ?></option>
                            <?php //} ?>
                        </datalist>
                        <div class="input-group-prepend border-0">
                            <button type="button" name="btn_search" id="btn_search" class="btn btn-link text-info"><em class="fa fa-search"></em></button>
                        </div>
                        <select name="faq_type" id="faq_type" class="form-control bg-none border-0">
                            <option value="">เลือกรายการที่ต้องการค้นหา</option>
                            <option value="1">ยอดวิวสูงสุด</option>
                            <option value="2">รายการล่าสุด</option>
                        </select>
                    </div> -->
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label for="inputCity" style="display:none;">ค้นหา</label>
                            <input type="search" class="form-control" name="search_faq" id="search_faq" placeholder="พิมพ์รายการที่ต้องการค้นหา" aria-describedby="btn_search" list="datalistOptions" value="">
                            <button type="button" name="btn_search" id="btn_search" class="btn btn-link text-info" style="position: absolute; top: 0px; right: 5px;"><em class="fa fa-search fa-w-16"></em>
                                <datalist id="datalistOptions">
                                <?php foreach ($faq["data"] as $key => $value) { ?>
                                <option value="<?php echo $value["faq_name"]; ?>"><?php echo $value["faq_name"]; ?></option>
                                 <?php } ?>
                                </datalist>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputState" style="display:none;">State</label>
                            <select name="faq_type" id="faq_type" class="form-control">
                                <option value="">เลือกรายการที่ต้องการค้นหา</option>
                                <option value="1">ยอดวิวสูงสุด</option>
                                <option value="2">รายการล่าสุด</option>
                            </select>

                        </div>
                    </div>
                </form>

                <!-- จบส่วนการค้นหา -->

                <!-- ส่วนแสดงรายการ -->
                <p>แสดง <?php echo $faq["countAll"]; ?> รายการคำถามที่พบบ่อย <?php if (isset($_GET["faq_type"])) {
                                                                                    echo ($_GET["faq_type"] == 2 ? 'จากรายการล่าสุด' : 'จากยอดวิวสูงสุด');
                                                                                } ?></p>

                <div class="mt-3  mb-5">
                    <div class="">
                        <div class="faq" id="accordion">
                            <?php foreach ($faq["data"] as $key => $value) { ?>
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
                                            <h5 class="faq-title" data-toggle="collapse" data-target="#faqCollapse-<?php echo $key + 1; ?>" data-aria-expanded="true" data-aria-controls="faqCollapse-<?php echo $key  + 1; ?>">
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

                <!-- Start แสดงการตัดหน้าเพจ -->
                <!-- <? //php echo pagination('faq.php', 'faq_cate_id=' . $faq_cate_id . '&fa_id=' . $fa_id . '&s_search=' . $s_search . '&faq_type' . $faq_type, $page, $per_page_faq, $faq["countAll"]); 
                        ?> -->
                <?php echo pagination_ewt('faq.php', 'faq_cate_id=' . $faq_cate_id . '&fa_id=' . $fa_id . '&s_search=' . $s_search . '&faq_type' . $faq_type, $page, $per_page_faq, $faq["countAll"]); ?>
                <!-- End แสดงการตัดหน้าเพจ-->
            </div>

            <div class="col-lg-3 col-md-3 col-sm-3 mb-5">
                <div class="article--subcat">หมวดหมู่</div>
                <ul class="list-group shadow">
                    <?php foreach ($faq_category as $key => $value) { ?>
                        <?php if ($value["faq_cate_parent"] == 0) { ?>
                            <li class="list-group-item ">
                                <a href="more_faq.php?faq_cate_id=<?php echo $value["faq_cate_id"]; ?>">
                                    <em class="fa fa-folder-open"></em> <?php echo $value["faq_cate_title"]; ?>
                                </a>
                            </li>
                        <?php } ?>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- ค้นหาด้วยการคลิกปุ่มหรือ Enter แสดงรายการที่ค้นหา ที่กล่องข้อมูล -->
<script type="text/javascript">
    $('#btn_search').click(function() {
        var s_search = $('#search_faq').val();
        var faq_cate_id = getUrlParameter('faq_cate_id');
        var fa_id = getUrlParameter('fa_id');
        window.location.href = 'faq.php?s_search=' + s_search + '&faq_cate_id=' + faq_cate_id + '&fa_id=' + fa_id;
    });

    $('#faq_type').change(function() {
        var s_search = $('#search_faq').val();
        var faq_cate_id = getUrlParameter('faq_cate_id');
        var fa_id = getUrlParameter('fa_id');
        var faq_type = $(this).val();
        window.location.href = 'faq.php?s_search=' + s_search + '&faq_cate_id=' + faq_cate_id + '&fa_id=' + fa_id + '&faq_type=' + faq_type;
    });

    $('#search_faq').keyup(function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            $('#btn_search').click();
        }
    });

    function getUrlParameter(name) {
        name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
        var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
        var results = regex.exec(location.search);
        return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
    };
</script>






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