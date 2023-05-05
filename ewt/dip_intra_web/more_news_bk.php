<?php include 'comtop.php'; ?>
<?php include 'header.php'; ?>
<?php include('org_menu.php'); ?>

<?php
$article_group = article::getArticleGroup($article_md);
$article_group_first = article::getArticleFirstGroup($c_id);
$article_group_parent = article::getArticleFirstGroup($article_group_first['c_parent']);
$article_check_search = article::getCheckSearch($c_id);
$article_check_group = article::getCheckGroup($c_id);
$article_sub_group = article::getArticleSubGroup($c_id);
$article_sub_group_list = article::getArticleSubGroupList($c_id);
$article_limit = article::getArticleLimit($start, $per_page, $c_id, $s_search, $n_date_start, $n_date_end, $org_name);
$article_count = article::getCountArticleSubGroup($c_id);
$total_page_more_news = ceil($article_limit["countAll"] / $per_page);

//Carousel เพิ่มเติม
$article_group_main_top = article::getArticleGroup($article_md);
foreach ($article_group_main_top as $key => $value) {
    $article_list_main_top[$value["c_id"]] = article::getSubArticleList('0', '1', $value["c_id"]);
    $article_list_center[$value["c_id"]] = article::getSubArticleList('0', '3', $value["c_id"]);
}

rsort($article_md);
$article_group_main_top_sub = article::getArticleGroup($article_md);
foreach ($article_group_main_top_sub as $key => $value) {
    $article_list_main_top_sub[$value["c_id"]] = article::getSubArticleList('0', '1', $value["c_id"]);
}
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
    <button class="openbtn" onclick="openNav()">เมนู <i class="fas fa-bars"></i></button>
    <div class="container-fluid header--bg text-center mt-3">
        <div class="container py-5">
            <h3>
                <?php if ($article_group_first["c_rss"] == "Y") { ?>
                    <a href="<?php echo $article_limit["url"]; ?>" target="_blank">
                        <img src="assets/img/rssfeed.png" title="rssfeed" alt="rssfeed" class="max-w-30px dis-inline">
                    </a>
                <?php } ?>
                <?php echo $article_group_first["c_name"]; ?>
            </h3>
            <small>
                <a href="index.php" title="หน้าหลัก">หน้าหลัก </a>
                <?php echo article::article_group_parent($c_id); ?>
            </small>
        </div>
    </div>

    <!-- Open Section Demo Code -->
    <!-- อันนี้ Carousel เพิ่มเติม -->
    <div class="container my-4">
        <div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="row">
                        <?php foreach ($article_group_main_top as $key => $value) { ?>
                            <?php foreach ($article_list_main_top[$value["c_id"]] as $k => $val) { ?>
                                <?php
                                $c_group = article::getArticleFirstGroup(null, $val["n_id"]);

                                $n_owner = user::chkUser(array("gen_user_id" => $val["n_owner"]))[0];
                                $full_name = $n_owner["name_thai"] . ' ' . $n_owner["surname_thai"];

                                $webb_pic = getImage("profile/", $n_owner['webb_pic'], "images/user.jpg");
                                $picture = getImage('images/article/news' . $val['n_id'] . '/', $val['picture'], "images/photo1.jpg");
                                ?>

                                <div class="col-lg-4 col-md-4 col-sm-12 col-12 my-2">
                                    <div class="item">
                                        <!-- card news update -->
                                        <div class="latest-post box-shadow-news border-ra-15px">
                                            <div class="latest-post-media">
                                                <a href="#" class="latest-post-img">
                                                    <div class="tag-bg-<?php echo tagBg($key); ?> position-tag-bg">
                                                        <?php echo $value["c_name"]; ?>
                                                    </div>
                                                    <img class="img-fluid border-ra-15px max-h-highligh-news w-100" src="<?php echo $picture; ?>" alt="img">
                                                </a>
                                            </div>
                                            <div class="post-body px-3 pt-1 news-hilight border-ra-bottom-15px">
                                                <h4 class="post-title">
                                                    <a href="#" class="d-inline-block ">
                                                        <p class=" mb-0 color-news-hilight"><?php echo $val["n_topic"]; ?></p>
                                                    </a>
                                                </h4>
                                                <div class="latest-post-meta ">
                                                    <div class="row">
                                                        <div class="col-lg-7 col-md-12 col-sm-12 col-12 pr-0  mt-2">
                                                            <img class="img-fluid img-user-news " src="<?php echo $webb_pic; ?>" alt="img"><span class="ml-3 color-news-header"><?php echo $full_name; ?></span>
                                                        </div>
                                                        <div class="col-lg-5 col-md-12 col-sm-12 col-12 pl-3 mt-2">
                                                            <i class="fa-solid fa fa-calendar color-news-header"></i><span class="ml-1 color-news-header"> <?php echo convDateThai($val['n_date'])['DateTH']; ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- Latest post end -->
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>

                <div class="carousel-item">
                    <div class="item">
                        <div class="row">
                            <?php foreach ($article_group_main_top_sub as $key => $value) { ?>
                                <?php foreach ($article_list_main_top_sub[$value["c_id"]] as $k => $val) { ?>
                                    <?php
                                    $n_owner = user::chkUser(array("gen_user_id" => $val["n_owner"]))[0];
                                    $full_name = $n_owner["name_thai"] . ' ' . $n_owner["surname_thai"];

                                    $webb_pic = getImage("profile/", $n_owner['webb_pic'], "images/user.jpg");
                                    $picture = getImage('images/article/news' . $val['n_id'] . '/', $val['picture'], "images/photo1.jpg");
                                    ?>

                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12 my-2">
                                        <div class="item">
                                            <!-- card news update -->
                                            <div class="latest-post box-shadow-news border-ra-15px">
                                                <div class="latest-post-media">
                                                    <a href="#" class="latest-post-img">
                                                        <div class="tag-bg-<?php echo tagBg($key); ?> position-tag-bg">
                                                            <?php echo $value["c_name"]; ?>
                                                        </div>
                                                        <img class="img-fluid border-ra-15px max-h-highligh-news w-100" src="<?php echo $picture; ?>" alt="img">
                                                    </a>
                                                </div>
                                                <div class="post-body px-3 pt-1 news-hilight border-ra-bottom-15px">
                                                    <h4 class="post-title">
                                                        <a href="#" class="d-inline-block ">
                                                            <p class=" mb-0 color-news-hilight"><?php echo $val["n_topic"]; ?></p>
                                                        </a>
                                                    </h4>
                                                    <div class="latest-post-meta ">
                                                        <div class="row">
                                                            <div class="col-lg-7 col-md-12 col-sm-12 col-12 pr-0  mt-2">
                                                                <img class="img-fluid img-user-news  " src="<?php echo $webb_pic; ?>" alt="img"><span class="ml-3 color-news-header"><?php echo $full_name; ?></span>
                                                            </div>
                                                            <div class="col-lg-5 col-md-12 col-sm-12 col-12 pl-3 mt-2">
                                                                <i class="fa-solid fa fa-calendar color-news-header"></i><span class="ml-1 color-news-header"> <?php echo convDateThai($val['n_date'])['DateTH']; ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- Latest post end -->
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

            <button class="carousel-control-prev hide-prev-Next-box" type="button" data-target="#carouselExampleFade" data-slide="prev">
                <span class="carousel-control-prev-icon " aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </button>

            <button class="carousel-control-next hide-prev-Next-box" type="button" data-target="#carouselExampleFade" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </button>
        </div>
    </div>

    <div class="container">
        <h2 class="h2-color pt-4">
            ข่าวสารทั่วไป
        </h2>

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <?php foreach ($article_group_main_top as $key => $value) { ?>
                <li class="nav-item" role="presentation">
                    <a class="nav-link <?php echo ($key == 0 ? "active" : "") ?>" id="home-tab<?php echo $key; ?>" data-toggle="tab" href="#home<?php echo $key; ?>" role="tab" aria-controls="home<?php echo $key; ?>" aria-selected="true">
                        <img class="icon-nav" src="images/2knowledge.png" alt="img">
                        <?php echo $value["c_name"]; ?>
                    </a>
                </li>
            <?php } ?>
        </ul>

        <!-- เนื่อข่าวเล็ก -->
        <div class="tab-content" id="myTabContent">
            <?php foreach ($article_group_main_top as $key => $value) { ?>
                <div class="tab-pane fade <?php echo ($key == 0 ? "show active" : "") ?>" id="home<?php echo $key; ?>" role="tabpanel" aria-labelledby="home-tab<?php echo $key; ?>">
                    <div class="row m-4">

                        <!-- ช่องแรกเนื้อข่าวเล็ก -->
                        <?php foreach ($article_list_center[$value["c_id"]] as $k => $val) { ?>
                            <?php
                            $n_owner = user::chkUser(array("gen_user_id" => $val["n_owner"]))[0];
                            $full_name = $n_owner["name_thai"] . ' ' . $n_owner["surname_thai"];

                            $webb_pic = getImage("profile/", $n_owner['webb_pic'], "images/user.jpg");
                            $picture = getImage('images/article/news' . $val['n_id'] . '/', $val['picture'], "images/photo1.jpg");
                            ?>
                            <div class="col-lg-4 col-md-6 col-sm-12 col-12 mb-4">
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-3  p-0">
                                        <img class="img-fluid img-news-ra shadow" src="<?php echo $picture; ?>" alt="img">
                                    </div>
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-9">
                                        <div class="tag-bg-<?php echo tagBg($key); ?>">
                                            <?php echo $value["c_name"]; ?>
                                        </div>
                                        <a href="Information_Knowledge.php" class="txt-header-news mt-1">
                                            <?php echo $val["n_topic"]; ?>
                                        </a>
                                        <div class="row">
                                            <div class="col-lg-7 col-md-7 col-sm-6 col-6 pr-0  mt-2">
                                                <img class="img-fluid img-user-news" src="<?php echo $webb_pic; ?>" alt="img"><span class="ml-1"><?php echo $full_name; ?></span>
                                            </div>
                                            <div class="col-lg-5 col-md-5 col-sm-6 col-6 p-0 mt-2">
                                                <i class="fa-solid fa fa-calendar"></i><span class="ml-1"> <?php echo convDateThai($val['n_date'])['DateTH']; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- <hr class="Gradient-Color mt-3"> -->
</div>
<!-- Close Section Demo Code -->

<!-- Section Search -->
<section class="search-sec">
    <div class="container">
        <form id="list_more_news" method="post" novalidate="novalidate">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-sm-12 p-0">
                            <input type="text" class="form-control search-slt" name="s_search" id="s_search" placeholder="กรอกคำค้น" list="datalistOptions" onclick="clearText('s_search');" value="<?php echo $s_search; ?>">
                            <datalist id="datalistOptions">
                                <div id="list_search">
                                    <?php foreach ($article_limit['data'] as $key => $value) { ?>
                                        <option value="<?php echo $value['n_topic']; ?>"></option>
                                    <?php } ?>
                                </div>
                            </datalist>
                        </div>

                        <div class="col-lg-2 col-md-2 col-sm-12 p-0">
                            <!-- <input type="text" name="n_date_start" id="n_date_start" placeholder="วันเริ่มต้น" class="form-control search-slt search-select" onfocus="(this.type='date')" onblur="(this.type='text')" value="<?php echo $n_date_start; ?>" /> -->
                            <input type="date" name="n_date_start" id="n_date_start" placeholder="วันเริ่มต้น" class="form-control search-slt search-select" onclick="clearText('n_date_start');" value="<?php echo $n_date_start; ?>" />
                        </div>

                        <div class="col-lg-2 col-md-2 col-sm-12 p-0">
                            <!-- <input type="text" name="n_date_end" id="n_date_end" placeholder="วันสิ้นสุด" class="form-control search-slt search-select" onfocus="(this.type='date')" onblur="(this.type='text')" value="<?php echo $n_date_end; ?>" /> -->
                            <input type="date" name="n_date_end" id="n_date_end" placeholder="วันสิ้นสุด" class="form-control search-slt search-select" onclick="clearText('n_date_end');" value="<?php echo $n_date_end; ?>" />
                        </div>

                        <div class="col-lg-2 col-md-2 col-sm-12 p-0">
                            <select name="org_name" id="org_name" class="form-control search-slt search-select">
                                <option value=""> ทุกหน่วยงานภายใน </option>
                                <!-- <?php foreach ($contact_org_name["dataAll"] as $key => $value) { ?>
                                        <option value="<?php echo $value["DEP_NAME"]; ?>" <?php echo (!empty($org_name) && $org_name == $value["DEP_name"] ? "selected" : null); ?>>
                                            <?php echo $value["DEP_NAME"]; ?>
                                        </option>
                                    <?php } ?> -->
                            </select>
                        </div>

                        <div class="col-lg-2 col-md-2 col-sm-12 p-0">
                            <select class="form-control search-slt search-select" name="c_id" id="c_id">
                                <!-- <option value="<?php echo $c_id; ?>"><?php echo $article_group_first['c_name']; ?></option> -->
                                <option value="">ทุกหมวดภายใน</option>
                                <?php foreach ($article_sub_group as $key => $value) { ?>
                                    <option value="<?php echo $value["c_id"]; ?>"> >> <?php echo $value['c_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12 p-0">
                            <button type="button" id="btn_search" class="btn btn--search wrn-btn">ค้นหา</button>
                        </div>
                    </div>
                    <div class="text-center mt-5 text-red text-short-more-news" id="list_row">
                        <?php if (!empty($s_search) || !empty($n_date_start) || !empty($n_date_end) || !empty($org_name)) { ?>
                            ผลการค้นหา <?php echo !empty($s_search) ? '"' . $s_search . '"' : null; ?><?php echo !empty($org_name) ? '"' . $org_name . '"' : null; ?> พบทั้งหมด <?php echo $article_limit['countAll']; ?> รายการ
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
                    $n_owner = user::orgName($value['n_org'])[0]["short_name"];
                    $c_group = article::getArticleFirstGroup(null, $value["n_id"]);
                    ?>
                    <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                        <div class="aritcle--card min-h-box-index">
                            <div class="row">
                                <?php if (!empty($value["picture"]) && $c_group['c_show_pic'] == "Y") { ?>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-12">
                                        <a href="<?php echo ($value['news_use'] == 1 ? $value['link_html'] : "news_view.php?n_id=" . $value['n_id'] . " "); ?>" target="<?php echo $value['target']; ?>" title="<?php echo $c_group['c_name']; ?>">
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
                                        <a onclick="newsCount(<?php echo $value['c_id']; ?>,<?php echo $value['n_id']; ?>,'news_tab_index');" href="<?php echo ($value['news_use'] == 1 ? $value['link_html'] : "news_view.php?n_id=" . $value['n_id'] . " "); ?>" target="<?php echo $value["target"]; ?>" title="<?php echo $c_group['c_name']; ?>" data-toggle="popover" data-trigger="hover" data-content="<?php echo $value['n_topic']; ?>">
                                            <?php echo $value['n_topic']; ?>
                                        </a>
                                    </div>
                                    <div class="article-date-time d-flex">
                                        <?php if ($c_group['c_show_date'] == 'Y') { ?>
                                            <i class="far fa-calendar-alt"></i>&nbsp;
                                            <?php echo convDateThai($value['n_date'])['DateTH']; ?>
                                            <?php } ?>&nbsp;
                                            <p id="list_count<?php echo $value['n_id']; ?>"><em class="far fa-eye"></em>&nbsp;<?php echo $value['view_count']; ?></p>&nbsp;
                                            <span class="mr-2">
                                                <a href="<?php echo (file_exists($val['link_html']) ? $val['link_html'] : "#"); ?>">
                                                    <i class="fa fa-user"></i>
                                                    <?php echo $n_owner; ?>
                                                </a>
                                            </span>
                                            <a href="more_news.php?c_id=<?php echo $c_group["c_id"]; ?>">
                                                <i class="fa fa-book"></i> <?php echo $c_group["c_name"]; ?>
                                            </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <!-- Start แสดงการตัดหน้าเพจ -->
            <?php echo pagination_ewt('more_news.php', 'c_id=' . $c_id . '&s_search=' . $s_search . '&n_date_start=' . $n_date_start . '&n_date_end=' . $n_date_end . '&org_name=' . $org_name, $page, $per_page, $article_limit["countAll"]); ?>
            <!-- End แสดงการตัดหน้าเพจ-->
        </div>
    </div>
<?php } ?>

<?php if ($article_check_group > 0 && !empty($article_sub_group)) { ?>
    <section id="article-sec">
        <div class="container">
            <div class="article--subcat">รายการหมวดย่อยภายใต้ "<?php echo $article_group_first['c_name']; ?>"</div>
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
                                    <div class="article--countlist-item">รายการ</div>
                                </div>
                            </div>
                        </div>
                <?php }
                } ?>
            </div>
        </div>
    </section>
<?php } ?>
</div>

<script type="text/javascript">
    function clearText(text) {
        $('#' + text).val('');
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