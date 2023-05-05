<?php include 'comtop.php'; ?>
<?php include 'header.php'; ?>
<!-- <style>
    .pagina_active{
        background-color: #fb6f92;
        color: #fff;
    }
</style> -->


<?php
$article_group = article::getArticleGroup($article_md);
$article_group_first = article::getArticleFirstGroup($c_id, $c_org, $lang);
$article_group_parent = article::getArticleFirstGroup($article_group_first['c_parent'], $c_org, $lang);
$article_check_search = article::getCheckSearch($c_id);
$article_check_group = article::getCheckGroup($c_id);
$article_sub_group = article::getArticleSubGroup($c_id);
$article_sub_group_list = article::getArticleSubGroupList($c_id);
$article_limit = article::getArticleLimit($start, $per_page, $c_id, $s_search, $n_date_start, $n_date_end);
$article_count = article::getCountArticleSubGroup($c_id);
$total_page_more_news = ceil($article_limit["countAll"] / $per_page);

$lang_new_group = "SELECT * FROM " . E_DB_NAME . ".lang_article_group WHERE c_id = " . $article_group_first['c_id'] . "";
$a_data_lang = db::getFetch($lang_new_group);
?>

<?php
if ($org_page[0]["c_show_org_chk"] == "Y" && empty($c_org)) {
    echo '<script type="text/javascript">
    location.replace("org_page.php?c_id=' . $c_id . '"); </script>';
    exit;
}
?>

<!-- Style CSS Template 3 -->
<link rel="stylesheet" href="assets/css/article.css">
<div id="main" style="<?php echo $org_page[0]["c_show_org_chk"] == "Y" ? "margin-left: 300px;" : null; ?>">
    <button class="openbtn" onclick="openNav()"><?= ($lang == 'EN' ? "Menu" : "เมนู")  ?> <i class="fas fa-bars"></i></button>
    <div class="container-fluid header--bg text-center ">
        <div class="container py-4">
            <!-- <h4 class="setfont">
                ข่าวทั้งหมด
            </h4> -->
            <small class="article--topic">
                <!-- <?php //if ($lang == "EN") { 
                        ?>
                    <a href="index.php" title="Main Page">Main Page </a>
                <?php //} else { 
                ?>
                    <a href="index.php" title="หน้าหลัก">หน้าหลัก </a>
                <?php // } 
                ?>
                <?php //echo article::article_group_parent($c_id, $c_org, $lang); 
                ?> -->
                ข่าวสารและความรู้ทั้งหมด
            </small>
        </div>
    </div>

    <section class="search-sec">
        <div class="container">
            <form id="list_more_news" method="post" novalidate="novalidate">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12 p-0">
                                <?php if ($lang == "EN") { ?>
                                    <input type="text" class="form-control search-slt" name="s_search" id="s_search" placeholder="Enter Search Term" list="datalistOptions" onclick="clearText('s_search');" value="<?php echo $s_search; ?>">
                                <?php } else { ?>
                                    <input type="text" class="form-control search-slt" name="s_search" id="s_search" placeholder="กรอกคำค้น" list="datalistOptions" onclick="clearText('s_search');" value="<?php echo $s_search; ?>">
                                <?php } ?>
                                <datalist id="datalistOptions">
                                    <div id="list_search">
                                        <?php foreach ($article_limit['data'] as $key => $value) { ?>
                                            <option value="<?php echo $value['n_topic']; ?>"></option>
                                        <?php } ?>
                                    </div>
                                </datalist>
                            </div>
                            <?php if ($lang == "EN") { ?>
                                <div class="col-lg-2 col-md-2 col-sm-12 p-0">
                                    <input type="date" name="n_date_start" id="n_date_start" placeholder="Start day" class="form-control search-slt search-select" onclick="clearText('n_date_start');" value="<?php echo $n_date_start; ?>" />
                                </div>

                                <div class="col-lg-2 col-md-2 col-sm-12 p-0">
                                    <input type="date" name="n_date_end" id="n_date_end" placeholder="End day" class="form-control search-slt search-select" onclick="clearText('n_date_end');" value="<?php echo $n_date_end; ?>" />
                                </div>
                            <?php } else { ?>
                                <div class="col-lg-2 col-md-2 col-sm-12 p-0">
                                    
                                    <input type="date" name="n_date_start" id="n_date_start" placeholder="วันเริ่มต้น" class="form-control search-slt search-select" onclick="clearText('n_date_start');" value="<?php echo $n_date_start; ?>" />
                                </div>

                                <div class="col-lg-2 col-md-2 col-sm-12 p-0">
                                   
                                    <input type="date" name="n_date_end" id="n_date_end" placeholder="วันสิ้นสุด" class="form-control search-slt search-select" onclick="clearText('n_date_end');" value="<?php echo $n_date_end; ?>" />
                                </div>
                            <?php } ?>
                            

                            <div class="col-lg-2 col-md-2 col-sm-12 p-0">
                                <select class="form-control search-slt search-select" name="c_id" id="c_id">
                                    
                                    <?php if ($lang == "EN") { ?>
                                        <option value=""> All Categories Within </option>
                                    <?php } else { ?>
                                        <option value=""> ทุกหมวดภายใน </option>
                                    <?php } ?>
                                    <?php foreach ($article_sub_group as $key => $value) { ?>
                                        <option value="<?php echo $value["c_id"]; ?>"> >> <?php echo $value['c_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-12 p-0">
                                <?php if ($lang == "EN") { ?>
                                    <button type="button" id="btn_search" class="btn btn--search wrn-btn">Search</button>
                                <?php } else { ?>
                                    <button type="button" id="btn_search" class="btn btn--search wrn-btn">ค้นหา</button>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="row text-center mt-5 text-red text-short-more-news" id="list_row">
                            <?php if (!empty($s_search) || !empty($n_date_start) || !empty($n_date_end) || !empty($c_id) || empty($c_id)) { ?>
                                <?= $text_search_results; ?> <?php echo !empty($s_search) ? '"' . $s_search . '"' : null; ?> ผลการค้นหาทั้งหมด <?php echo number_format($article_limit['countAll']); ?> <?= "รายการ"; ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <?php if (!empty($article_limit['data']) && $article_group_first['c_show_document'] == 'Y') { ?>
        <div class="container-fluid">
            <div class="container">
                <div class="row" id="list_search_more">
                    <?php foreach ($article_limit['data'] as $key => $value) { ?>
                        <?php
                        $c_group = article::getArticleFirstGroup(null, $value["n_id"]);
                        $n_org = user::orgName($value["n_org"])[0]["short_name"];
                        $n_owner = user::chkUser(array("gen_user_id" => $value["n_owner"]))[0];
                        $lang_new_list = "SELECT * FROM " . E_DB_NAME . ".lang_article_list WHERE c_id = " . $value['n_id'] . "";
                        $a_data_list = db::getFetch($lang_new_list);

                        $full_name = $n_owner["name_thai"] . ' ' . $n_owner["surname_thai"];
                        $webb_pic = getImage("profile/", $n_owner['webb_pic'], "images/user.jpg");
                        $picture = getImage('images/article/news' . $value['n_id'] . '/', $value['picture'], "images/photo1.jpg");

                        ?>

                        <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                            <div class="aritcle--card min-h-box-index">
                                <div class="row">
                                    <?php if (!empty($value["picture"]) && $c_group['c_show_pic'] == "Y") { ?>
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-12">
                                            <a href="<?php echo ($value['news_use'] == 1 ? $value['link_html'] : "news_view.php?n_id=" . $value['n_id']  . " "); ?>" target="<?php echo $value['target']; ?>" title="<?php echo $c_group['c_name']; ?>">
                                                <img src="images/article/news<?php echo $value['n_id'] . '/', $value['picture']; ?>" class="article--pic">
                                            </a>
                                        </div>
                                    <?php } ?>

                                    <?php if ($c_group['c_show_pic'] != "Y" && $c_group['c_show_pic'] != "N") { ?>
                                        <div class="icon__block">
                                            <a href="<?php echo ($value['news_use'] == 1 ? $value['link_html'] : "news_view.php?n_id=" . $value['n_id'] . " "); ?>" target="<?php echo $value['target']; ?>" title="<?php echo $c_group['c_name']; ?>">
                                                <img src="<?php echo $article_group_first["c_show_pic"]; ?>" style="padding:3px 10px; width:50px;">
                                            </a>
                                        </div>
                                    <?php } ?>

                                    <div class="col-lg-10 col-md-10 col-sm-10 col-12 <?php echo ($c_group['c_show_pic'] != "Y" && $c_group['c_show_pic'] != "N" ? "detail__block" : null); ?>">
                                        <div class="article--title">
                                            <?php if ($value["pinned"] == 'Y') { ?>
                                                <img src="assets/img/pin-webboard.png" title="ปักหมุด" alt="ปักหมุด" class="max-w-20px dis-inline">
                                            <?php } ?>
                                            <?php if ($lang == "EN" && !empty($a_data_list)) { ?>
                                                <a onclick="newsCount(<?php echo $value['c_id']; ?>,<?php echo $value['n_id']; ?>,'more_news');" href="<?php echo ($value['news_use'] == 1 ? $value['link_html'] : "news_view.php?n_id=" . $value['n_id'] . " "); ?>" target="<?php echo $value["target"]; ?>" title="<?php echo $a_data_lang['lang_detail']; ?>" data-toggle="popover" data-trigger="hover" data-content="<?php echo $a_data_list['lang_detail']; ?>">
                                                    <?php echo $a_data_list['lang_detail']; ?>
                                                </a>
                                            <?php } else { ?>
                                                <a onclick="newsCount(<?php echo $value['c_id']; ?>,<?php echo $value['n_id']; ?>,'more_news');" href="<?php echo ($value['news_use'] == 1 ? $value['link_html'] : "news_view.php?n_id=" . $value['n_id'] . " "); ?>" target="<?php echo $value["target"]; ?>" title="<?php echo $c_group['c_name']; ?>" data-toggle="popover" data-trigger="hover" data-content="<?php echo $value['n_topic']; ?>">
                                                    <!-- (!empty($value['picture']) == "Y" && $c_group['c_show_pic'] == "Y" ? mb_strimwidth($value['n_topic'], 0, 50, '...') : mb_strimwidth($value['n_topic'], 0, 80, '...')); -->
                                                    <?php echo $value['n_topic']; ?>
                                                </a>
                                            <?php } ?>
                                        </div>
                                        <div class="article-date-time d-flex">
                                            <?php if ($c_group['c_show_date'] == 'Y') { ?>
                                                <i class="far fa-calendar-alt"></i>&nbsp;

                                                <?php
                                                // var_dump($lang_new_list);
                                                if ($lang == "EN") {
                                                    echo date_format(new DateTime($value['n_date']), "j M Y");
                                                    echo " : ";
                                                    echo date('H:i:s', strtotime($value['n_timestamp']));
                                                } else {
                                                    $new_startDate = date("Y-m-d", strtotime($value['n_timestamp'])); //วันที่
                                                    $new_startTime = date("H:i:s", strtotime($value['n_timestamp']));
                                                    echo convDateThai($value['n_date'])['DateTH'];
                                                    echo convDateThai($new_startTime)['TimeTH']; ?>
                                                    <?php }
                                            } ?>&nbsp;
                                                    <i class="fa fa-eye"></i>&nbsp;<p id="list_count<?php echo $value['n_id']; ?>"><?php echo $value['view_count']; ?></p>&nbsp;
                                                    <a href="#" title="<?php echo $n_org; ?>">
                                                        <i class="fa fa-user"></i>&nbsp;
                                                        <?php echo $n_org; ?>
                                                    </a>&nbsp;
                                                    <a href="more_news.php?c_id=<?php echo $c_group["c_id"]; ?>">
                                                        <i class="fa fa-book"></i> <?php if ($lang == "EN" && !empty($a_data_lang)) {
                                                                                        echo $a_data_lang['lang_detail'];
                                                                                    } else {
                                                                                        echo $c_group["c_name"];
                                                                                    }
                                                                                    ?>
                                                    </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <!-- Start แสดงการตัดหน้าเพจ -->
                <?php echo pagination_ewt('more_news_list.php', 'c_id=' . $c_id . '&s_search=' . $s_search . '&n_date_start=' . $n_date_start . '&n_date_end=' . $n_date_end . '&org_id=' .$c_id, $page, $per_page, $article_limit["countAll"]); ?>
                <!-- End แสดงการตัดหน้าเพจ-->
            </div>
        </div>
    <?php } ?>

    <?php // if ($article_check_group > 0 && !empty($article_sub_group)) { ?>
        <!-- <section id="article-sec">
            <div class="container">
                <div class="article--subcat"><?php ($lang == 'EN' ? "List of Subcategories Under" : "รายการหมวดย่อยภายใต้")  ?> "<?php echo $article_group_first['c_name']; ?>"</div>
                <div class="row">
                    <?php foreach ($article_sub_group as $key => $value) {
                        if ($value["c_show_document"] == "Y") {
                            $total_allnews = article::getCoutSubArticleList($value["c_id"]); ?>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="article--subcate-block">
                                    <div class="article--subcate-block-left">
                                        <a href="more_news.php?c_id=<?php echo $value['c_id']; ?>" title="<?php echo $value['c_name']; ?>"><?php echo $value['c_name']; ?></a>
                                    </div>
                                    <div class="article--subcate-block-right">
                                        <img src="assets/img/icon/file.svg" class="icon-file" title="<?php echo $value['c_name']; ?>" alt="<?php echo $value['c_name']; ?>">
                                        <div class="article--countlist"><?php echo number_format($total_allnews); ?></div>
                                        <div class="article--countlist-item"><?php ($lang == 'EN' ? "List" : "รายการ")  ?></div>
                                    </div>
                                </div>
                            </div>
                    <?php }
                    } ?>
                </div>
            </div>
        </section> -->
    <?php // } ?>
</div>

<script type="text/javascript">
    function clearText(text) {
        $('#' + text).val('');
    }

    $("#btn_search").click(function() {
        window.location.href = 'more_news_list.php?c_id=' + $('#c_id').val() +
            '&s_search=' + $('#s_search').val() +
            '&n_date_start=' + $('#n_date_start').val() +
            '&n_date_end=' + $('#n_date_end').val();
    });
</script>

<?php include('component/news_count.php'); ?>
<?php include 'footer.php'; ?>
<?php include 'combottom.php'; ?>