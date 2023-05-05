<?php include 'comtop.php'; ?>
<?php include 'header.php'; ?>
<?php include('org_menu.php'); ?>
<?php

// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);

$vdo_group=$_GET['id'];
$wh = "";
if ($vdo_group) {
    $wh .= " AND vdo_group = '{$vdo_group}'";
}
$per_page ='9'; 
$_sql = "SELECT a.*, b.vdog_id FROM " . E_DB_NAME . ".vdo_list a
    INNER JOIN " . E_DB_NAME . ".vdo_group b ON (a.vdo_group = b.vdog_id) 
    WHERE  1=1 {$wh}
    ORDER BY a.vdo_createdate DESC 
    LIMIT {$start_vdo},{$per_page_vdo}";

$a_row = db::getRowCount($_sql);
$a_data = db::getFetchAll($_sql);

//นับจำนวนข่าวทั้งหมด
$_sql_all = "SELECT a.vdo_id FROM " . E_DB_NAME . ".vdo_list a
INNER JOIN " . E_DB_NAME . ".vdo_group b ON (a.vdo_group = b.vdog_id) 
WHERE  1=1 {$wh}";

$a_row_all = db::getRowCount($_sql_all);

$total_page = ceil($a_row_all / $per_page);

//var_dump($_sql);

?>




<!-- Style CSS Template 3 -->
<link rel="stylesheet" href="assets/css/article.css">
<div id="main" style="<?php echo $org_page[0]["c_show_org_chk"] == "Y" ? "margin-left: 300px;" : null; ?>">


    <div class="container-fluid header--bg text-center mt-3">
        <div class="container py-5">
            <h3 class="article--topic">วีดีโอแนะนำ</h3>
            <small class="article_nvt">
                <a href="index.php" title="หน้าหลัก" class="article_nvt">หน้าหลัก </a>
                &gt;&gt; <a href="#" class="article_nvt"> วีดีโอแนะนำ</a>
            </small>
        </div>
    </div>

    <!-- 1. แสดง 3  รายการต่อ 1 แถว  2. แสดงหน้าละ 9 รายการ -->
    <div class="container">
        <div class="row">
        <?php foreach ($a_data as $key => $value) { ?>
            <div class="col-xl-4">
                <div class="shadow-sm  mt-2 mb-2 bg-whtie rounded" style="height: 400px;">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="embed-responsive embed-responsive-4by3">
                            <?php
                                if ($value['vdo_filename'] != "") {
                                    $type = "mp4";
                                } else {
                                    $type = "youtube";
                                }

                                $vdo_fileyoutube = str_replace('https://www.youtube.com/watch?v=', '', $value['vdo_fileyoutube']);

                                if ($value['vdo_filename'] != "") {
                                    echo "<video class=\"embed-responsive-item\" onclick=\"Func_Vdocount(" . $value["vdo_id"] . ")\" data-vdo=\"" . $value["vdo_id"] . "\" id=\"vplayer\" src=\"download/file_vdo/" . $value['vdo_filename'] . "\" poster=\"" . $vdo_image . "\"  type=\"video/mp4\" controls=\"controls\" preload=\"none\"></video>";
                                } else {
                                    echo "<iframe class=\"embed-responsive-item\" onclick=\"Func_Vdocount(" . $value["vdo_id"] . ")\"  data-vdo=\"" . $value["vdo_id"] . "\"  allow=\"autoplay\" src=\"https://www.youtube.com/embed/" . $vdo_fileyoutube . "\"></iframe>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="p-3">
                                <a href="#">
                                    <h4><?php echo $value["vdo_name"]; ?></h4>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
            <!-- <div class="col-xl-4">
                <div class="shadow-sm  mt-2 mb-2 bg-whtie rounded">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="embed-responsive embed-responsive-4by3">
                                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/tr6uGU9U3aY"></iframe>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="p-3">
                                <a href="#">
                                    <h4>การปฏิบัติราชการให้สอดคล้องกับ PDPA l 17 มิ.ย. 65</h4>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="shadow-sm  mt-2 mb-2 bg-whtie rounded">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="embed-responsive embed-responsive-4by3">
                                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/tr6uGU9U3aY"></iframe>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="p-3">
                                <a href="#">
                                    <h4>การปฏิบัติราชการให้สอดคล้องกับ PDPA l 17 มิ.ย. 65</h4>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
        <!--         
        <div class="row">
            <div class="col-xl-4">
                <div class="shadow-sm  mt-2 mb-2 bg-whtie rounded">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="embed-responsive embed-responsive-4by3">
                                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/tr6uGU9U3aY"></iframe>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="p-3">
                                <a href="#">
                                    <h4>การปฏิบัติราชการให้สอดคล้องกับ PDPA l 17 มิ.ย. 65</h4>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
            <div class="col-xl-4">
                <div class="shadow-sm  mt-2 mb-2 bg-whtie rounded">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="embed-responsive embed-responsive-4by3">
                                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/tr6uGU9U3aY"></iframe>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="p-3">
                                <a href="#">
                                    <h4>การปฏิบัติราชการให้สอดคล้องกับ PDPA l 17 มิ.ย. 65</h4>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="shadow-sm  mt-2 mb-2 bg-whtie rounded">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="embed-responsive embed-responsive-4by3">
                                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/tr6uGU9U3aY"></iframe>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="p-3">
                                <a href="#">
                                    <h4>การปฏิบัติราชการให้สอดคล้องกับ PDPA l 17 มิ.ย. 65</h4>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-4">
                <div class="shadow-sm  mt-2 mb-2 bg-whtie rounded">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="embed-responsive embed-responsive-4by3">
                                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/tr6uGU9U3aY"></iframe>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="p-3">
                                <a href="#">
                                    <h4>การปฏิบัติราชการให้สอดคล้องกับ PDPA l 17 มิ.ย. 65</h4>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
            <div class="col-xl-4">
                <div class="shadow-sm  mt-2 mb-2 bg-whtie rounded">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="embed-responsive embed-responsive-4by3">
                                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/tr6uGU9U3aY"></iframe>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="p-3">
                                <a href="#">
                                    <h4>การปฏิบัติราชการให้สอดคล้องกับ PDPA l 17 มิ.ย. 65</h4>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="shadow-sm  mt-2 mb-2 bg-whtie rounded">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="embed-responsive embed-responsive-4by3">
                                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/tr6uGU9U3aY"></iframe>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="p-3">
                                <a href="#">
                                    <h4>การปฏิบัติราชการให้สอดคล้องกับ PDPA l 17 มิ.ย. 65</h4>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->

        <!-- <div class="row">
            <div class="col-xl-12">
                <div class="row">
                    <div class="pagination p6">
                        <ul class="pagination">
                            <a class="current"><li>1</li></a><a href="#"><li>2</li></a>
                            <a href="#"><li>หน้าถัดไป ›</li></a><a href="#"><li>หน้าสุดท้าย ››</li></a>
                        </ul>
                   </div>
            </div>
        </div> -->
        <!-- Start แสดงการตัดหน้าเพจ -->
        <?php echo pagination_ewt('more_vdo.php', '' , $page, $per_page_vdo,$a_row_all); ?>
        <!-- End แสดงการตัดหน้าเพจ-->
    </div>
</div>





<script type="text/javascript">
    function clearText(text) {
        $('#' + text).val('');
    }

    function tabActive(key, c_id) {
        $.post("ajax/tab_article_active.ajax.php", {
            key: key,
            c_id: c_id
        });
    }

    $("#btn_search").click(function() {
        window.location.href = 'more_news.php?c_id=' + <?php echo $c_id; ?> +
            '&s_search=' + $('#s_search').val() +
            '&n_date_start=' + $('#n_date_start').val() +
            '&n_date_end=' + $('#n_date_end').val() +
            '&org_name=' + $('#org_name').val();
        '&c_org=' + '<?php echo $c_org; ?>';
    });
</script>

<?php include('component/news_count.php'); ?>
<?php include 'footer.php'; ?>
<?php include 'combottom.php'; ?>