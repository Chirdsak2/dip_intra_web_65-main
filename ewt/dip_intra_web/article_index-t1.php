<?php
$article_group = article::getArticleGroup($article_md);
$article_list_t1[0] = article::getSubArticleList('0', '5', $article_md[0]);
$article_list_t1[1] = article::getSubArticleList('0', '5', $article_md[1]);
$article_list_t1[2] = article::getSubArticleList('0', '5', $article_md[2]);
?>
<div class="container py-2">
    <div class="row">
        
        <?php
        foreach ($article_group as $key => $value) {
            if ($value['c_show_document'] == 'Y') { ?>
                <div class="col-lg-4 col-md-6 col-sm-12 col-12 py-3 line-dashed-right">

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12 text-center">
                            <div class="h-news-col"> <?php echo $value["c_name"]; ?> </div>
                        </div>
                    </div>

                    <div class="row">
                        <?php foreach ($article_list_t1[$key] as $val) { ?>
                            <?php
                            //$n_owner = $sso->getOrg($val['n_owner_org'])['name'];
                            $c_group = article::getArticleFirstGroup(null, $val["n_id"]);
                            ?>
                            <div class="col-12 border-b-list line-dashed-bottom">
                                <div class="h-news-list mt-2">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-8">

                                            <?php
                                            if (!empty($val['picture']) && $c_group['c_show_pic'] == "Y") {
                                                echo '<div class="row no-gutters">';
                                            } elseif ($c_group['c_show_pic'] != "Y" && $c_group['c_show_pic'] != "N") {
                                                echo '<div class="row no-gutters">';
                                            } else {
                                                echo '<div class="dis-inline-flex-news">';
                                            } ?>

                                            <?php if (!empty($val['picture']) && $c_group['c_show_pic'] == "Y") { ?>
                                                <div class="<?php echo (!empty($val['picture']) && $c_group['c_show_pic'] == "Y" ? "col-lg-3 col-md-3 col-sm-3 col-12" : "dis-inline-flex max-width-left-pic"); ?>">
                                                    <img src="<?php echo 'images/article/news' . $val['n_id'] . '/', $val['picture']; ?>" class="w-100 p-2 border-ra-15px" alt="<?php echo $val['picture']; ?>" title="<?php echo $val['picture']; ?>">
                                                </div>
                                            <?php } elseif ($c_group['c_show_pic'] != "Y" && $c_group['c_show_pic'] != "N") { ?>
                                                <div class="icon__block">
                                                    <a href="<?php echo ($val['news_use'] == 1 ? $val['link_html'] : "news_view.php?n_id=" . $val['n_id'] . " "); ?>" target="<?php echo $val['target']; ?>" title="<?php echo $c_group['c_name']; ?>">
                                                        <img src="<?php echo $c_group['c_show_pic']; ?>" style="padding:3px 10px; width:50px;">
                                                    </a>
                                                </div>
                                            <?php } ?>

                                            <?php
                                            if (!empty($val['picture']) == 'Y' && $c_group['c_show_pic'] == "Y") {
                                                echo '<div class="col-lg-9 col-md-9 col-sm-9 col-12">';
                                            } elseif ($c_group['c_show_pic'] != "Y" && $c_group['c_show_pic'] != "N") {
                                                echo '<div class="col-10 detail__block">';
                                            } else {
                                                echo '<div class="dis-inline-flex">';
                                            } ?>

                                            <div class="card-body p-2">
                                                <div class="detial-news-tab">
                                                    <?php if ($val['show_date'] == 1) { ?>
                                                        <em class="far fa-calendar"></em>
                                                        <?php echo convDateThai($val['n_date'])['DateTH']; ?>
                                                        <?php echo convDateThai($val['n_timestamp'])['TimeTH']; ?>
                                                    <?php } ?>
                                                </div>

                                                <a onclick="newsCount(<?php echo $val['c_id']; ?>,<?php echo $val['n_id']; ?>,'news_tab_index');" href="<?php echo ($val['news_use'] == 1 ? $val['link_html'] : "news_view.php?c_id=" . $val['c_id'] . "&n_id=" . $val['n_id'] . " "); ?>" target="<?php echo $val['target']; ?>" title="<?php echo $val['n_topic']; ?>">
                                                    <div class="h-news-tab text-short">
                                                        <?php if ($val["pinned"] == 'Y') { ?>
                                                            <img src="assets/img/pin-webboard.png" title="ปักหมุด" alt="ปักหมุด" class="max-w-20px dis-inline">
                                                        <?php } ?>
                                                        <!-- <?php echo (!empty($val['picture']) && $value["c_show_pic"] == 'Y' ? mb_strimwidth($val['n_topic'], 0, 30, '...') : mb_strimwidth($val['n_topic'], 0, 80, '...')); ?> -->
                                                        <?php echo $val['n_topic']; ?>
                                                    </div>
                                                </a>

                                                <a href="<?php echo (file_exists($val['link_html']) ? $val['link_html'] : "#"); ?>" class="txt-department">
                                                    <span class="mr-2" id="list_count<?php echo $val['n_id']; ?>">
                                                        <em class="far fa-eye"></em>
                                                        <?php echo $val['view_count']; ?>
                                                    </span>
                                                    <em class="far fa-user"></em> <?php //echo $n_owner; ?>
                                                </a>

                                                <a href="more_news.php?c_id=<?php echo $c_group["c_id"]; ?>">
                                                    <em class="fas fa-book"></em> <?php echo $c_group["c_name"]; ?>
                                                </a>
                                            </div>
                                            <?php echo '</div>'; ?>
                                            <?php echo '</div>'; ?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                    <?php if (!empty($article_list_t1[$key])) { ?>
                        <div class="p-2 txt-right">
                            <a href="more_news.php?c_id=<?php echo $value["c_id"]; ?>" class="more-api" target="_black">
                                อ่านทั้งหมด
                            </a>
                        </div>
                    <?php } ?>
                </div>
        <?php }
        } ?>

    </div>
</div>

<?php include('component/news_count.php'); ?>