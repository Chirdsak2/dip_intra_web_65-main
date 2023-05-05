<?php include 'comtop.php'; ?>
<?php include 'header.php'; ?>

<!-- Style CSS Template 3 -->
<link rel="stylesheet" href="assets/css/article.css">

<div class="container-fluid mar-t-90px header--bg text-center">
    <div class="container py-5">
        <h3><?php echo $c_name; ?></h3>
    </div>
</div>

<section class="search-sec header--bg">

    <div class="container">
        <form action="#" id="list_more_news" method="post" novalidate="novalidate">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-5 col-md-5 col-sm-12 p-0">
                            <input type="text" class="form-control search-slt" name="search_more_news" id="search_more_news" placeholder="กรอกคำค้น" list="datalistOptions">

                            <datalist id="datalistOptions">
                                <div id="list_search">
                                    <?php foreach ($article_limit as $key => $value) { ?>
                                        <option value="<?php echo $value['n_topic']; ?>"></option>
                                    <?php } ?>
                                </div>
                            </datalist>
                        </div>

                        <div class="col-lg-5 col-md-5 col-sm-12 p-0">
                            <select class="form-control search-slt search-select" id="list_category">
                                <option>แหล่งข้อมูล</option>
                                <option><?php echo $c_name; ?></option>
                                <?php foreach ($article_sub_group as $key => $value) { ?>
                                    <option id="<?php echo $c_id; ?>"><?php echo $value['c_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12 p-0">
                            <button type="button" id="btn_search" class="btn btn--search wrn-btn">Search</button>
                        </div>
                    </div>
                    <div class="text-center mt-5 text-red text-short-more-news" id="list_row">ผลการคันหา พบทั้งหมด
                        <?php echo $total; ?> รายการ</div>
                </div>

            </div>
        </form>
    </div>
</section>

<?php if (!empty($article_limit)) { ?>
    <div class="container-fluid bg--purple padding--50">
        <div class="container">
            <div class="row" id="list_search_more">
                <?php foreach ($article_limit as $key => $value) { ?>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="aritcle--card">
                            <div class="row">
                                <?php if (!empty($value['picture'])) { ?>
                                    <div class="col-lg-4">
                                        <a href="<?php echo ($value['news_use'] == 1 ? $value['link_html'] : "news_view.php?c_id=" . $value['c_id'] . "&n_id=" . $value['n_id'] . " "); ?>" target="<?php echo $value['target']; ?>" title="<?php echo $value['c_name'] ?>" title="<?php echo $value['c_name'] ?>">
                                            <img src="<?php echo HOST_NAME; ?>images/article/news<?php echo $value['n_id'] . '/', $value['picture']; ?>" class="article--pic">
                                        </a>
                                    </div>
                                <?php } ?>
                                <div class="col-lg-<?php echo (empty($value['picture']) ? "12" : "8"); ?>">
                                    <div class="article--title">
                                        <a onclick="newsCount(<?php echo $value['c_id']; ?>,<?php echo $value['n_id']; ?>);" href="<?php echo ($value['news_use'] == 1 ? $value['link_html'] : "news_view.php?c_id=" . $value['c_id'] . "&n_id=" . $value['n_id'] . " "); ?>" target="<?php echo $value["target"]; ?>" title="<?php echo $value['c_name'] ?>" data-toggle="popover" data-trigger="hover" data-content="<?php echo $value['n_topic']; ?>">
                                            <?php echo (empty($value['picture']) ? mb_strimwidth($value['n_topic'], 0, 80, '...') : mb_strimwidth($value['n_topic'], 0, 50, '...')); ?>
                                        </a>
                                    </div>
                                    <div class="article-date-time" id="list_count<?php echo $value['n_id']; ?>">
                                        <i class="far fa-calendar-alt"></i>
                                        <?php echo ($value['show_date'] == 1 ? convDateThai($value['n_timestamp'])['DateTH'] : null); ?>
                                        <i class="fa fa-eye"></i> <?php echo $value['view_count']; ?>
                                        <a href="#" title="<?php echo article::getOrg($value['n_owner'])['short_name']; ?>">
                                            <i class="fa fa-user"></i>
                                            <?php echo article::getOrg($value['n_owner'])['short_name']; ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <!-- Start แสดงการตัดหน้าเพจ -->
            <div class="text-center" id="list_pagination">
                <div class="pagination p6">
                    <ul>
                        <?php echo pagination('more_news.php', '&c_id=' . $c_id . '&s_search=' . $s_search . '', $page, $per_page, $total_page); ?>
                    </ul>
                </div>
            </div>
            <!-- End แสดงการตัดหน้าเพจ-->
        </div>
    </div>
<?php } ?>

<?php if (!empty($article_sub_group) && $article_check_group > 0) { ?>
    <section id="article-sec">
        <div class="container">
            <div class="article--subcat">รายการหมวดย่อยภายใต้ "<?php echo $c_name; ?>"</div>
            <div class="row">
                <?php foreach ($article_sub_group as $key => $value) { ?>
                    <?php ?>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="article--subcate-block">
                            <div class="article--subcate-block-left">
                                <a href="more_news.php?&c_id=<?php echo $value['c_id']; ?>" title="<?php echo $value['c_name']; ?>"><?php echo $value['c_name']; ?></a>
                            </div>
                            <div class="article--subcate-block-right">
                                <img src="assets/img/icon/file.svg" class="icon-file" title="<?php echo $value['c_name']; ?>" alt="<?php echo $value['c_name']; ?>">
                                <div class="article--countlist"><?php echo count($article_count[$value['c_id']]); ?></div>
                                <div class="article--countlist-item">รายการ</div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
<?php } ?>

<!-- ค้นหาด้วยการพิมพ์ข้อมูลแสดงรายการล่าสุด 10 รายการ ที่ช่องค้นหา -->
<script type="text/javascript">
    $("#search_more_news").keyup(function() {
        let s_search = document.getElementById('search_more_news').value;

        $.ajax({
            type: 'GET',
            url: 'ajax/more_news.ajax.php',
            data: {
                c_id: <?php echo $c_id; ?>,
                c_name: null,
                s_search: s_search,
                total_page: <?php echo $total_page; ?>,
                s_page: 0,
                s_limit: 10
            },
            datatype: "text",
            success: function(data) {
                let object = JSON.parse(data, true);
                $('#list_search').html(object.more_news);
                $('#list_row').html(object.list_row);
            },
            error: function() {
                console.log('Error');
            }
        });
    });
</script>

<!-- ค้นหาด้วยการคลิกปุ่มแสดงรายการที่ค้นหา ที่กล่องข้อมูล -->
<script type="text/javascript">
    $("#btn_search").click(function() {
        let data = document.getElementById('search_more_news').value;
        let c_name = document.getElementById('list_category').value;
        window.location.href = 'more_news.php?page=' + <?php echo $page; ?> + '&c_id=' + <?php echo $c_id; ?> +
            '&s_search=' + data;
    });
</script>

<!-- นับจำนวนการเปิดดูข่าวหรือเปิดไฟล์เอกสาร -->
<script type="text/javascript">
    function newsCount(c_id, n_id) {
        $.ajax({
            type: 'GET',
            url: 'ajax/news_tab_index.ajax.php',
            data: {
                c_id: c_id,
                n_id: n_id,
                page: 'more_news'
            },
            datatype: "text",
            success: function(data) {
                let object = JSON.parse(data, true);
                $('#list_count' + object.n_id).html(object.view_count);
                //console.log(object);
            },
            error: function() {
                console.log('Error');
            }
        });
    }
</script>

<?php include 'footer.php'; ?>
<?php include 'combottom.php'; ?>