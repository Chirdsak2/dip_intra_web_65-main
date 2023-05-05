<?php
$article_group = article::getArticleGroup($article_md);
foreach ($article_group as $key => $value) {
    $article_list[$value["c_id"]] = $article_list[$value["c_id"]] = article::getSubArticleList('0', '8', $value["c_id"]);
}
?>

<style>
    .bg-news-tab-index {
        background-image: url(<?php echo !empty($template_management["site_header"]) ? $template_management["site_header"] : 'images/Template.jpg'; ?>);
    }
</style>

<div class="container-fluid bg-news-tab-index p-3">
    <div class="container">
        <div class="">
            <ul class="nav nav-tabs my-4 ul-li-center" id="myTab" role="tablist" style="border-bottom: 0px;">
                <?php foreach ($article_group as $key => $value) { ?>
                    <li class="nav-item mx-2" role="presentation">
                        <a class="nav-link <?php echo ($key == 0 ? "active" : ""); ?> tab-index font20px" id="button-tap<?php echo $value['c_id']; ?>" data-toggle="tab" href="#button<?php echo $value['c_id']; ?>" role="tab" aria-controls="button<?php echo $value['c_id']; ?>" aria-selected="true">
                            <span class="txt-yellow"> <?php echo $value['c_name']; ?> </span>
                        </a>
                    </li>
                <?php } ?>
            </ul>

            <div class="tab-content" id="myTabContent">
                <?php foreach ($article_group as $key => $value) { ?>
                    <div class="tab-pane fade <?php echo ($key == 0 ? "show active" : ""); ?>" id="button<?php echo $value['c_id']; ?>" role="tabpanel" aria-labelledby="button-tap<?php echo $value['c_id']; ?>">
                        <div class="row">
                            <?php
                            foreach ($article_list[$value["c_id"]] as $val) { ?>
                                <?php
                                //$n_owner = $sso->getOrg($val['n_owner_org'])['name'];
                                $n_owner = user::orgName($val['n_org'])[0]["short_name"];
                                $c_group = article::getArticleFirstGroup(null, $val["n_id"]);
                                ?>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12 px-2">
                                    <div class="card mb-3 min-h-box-index">
                                        <div style="padding:10px;">
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
                                                <div class="card-title font17px">
                                                    <?php if ($val["pinned"] == 'Y') { ?>
                                                        <img src="assets/img/pin-webboard.png" title="ปักหมุด" alt="ปักหมุด" class="max-w-20px dis-inline">
                                                    <?php } ?>

                                                    <a onclick="newsCount(<?php echo $val['c_id']; ?>,<?php echo $val['n_id']; ?>,'news_tab_index');" href="<?php echo ($val['news_use'] == 1 ? $val['link_html'] : "news_view.php?n_id=" . $val['n_id'] . " "); ?>" target="<?php echo $val['target']; ?>" title="<?php echo $val['n_topic']; ?>" class="txt-gray-dark2 font17px">
                                                        <?php echo $val['n_topic']; ?>
                                                    </a>
                                                </div>

                                                <p class="card-text font13px">
                                                    <?php if ($c_group['c_show_date'] == 'Y') { ?>
                                                        <span class="mr-2"> <em class="far fa-calendar"></em>
                                                            <?php echo convDateThai($val['n_date'])['DateTH'] . ' ' . convDateThai($val['n_timestamp'])['TimeTH']; ?>
                                                        </span>
                                                    <?php } ?>

                                                    <span class="mr-2" id="list_count<?php echo $val['n_id']; ?>"> <em class="far fa-eye"></em> <?php echo $val['view_count']; ?> </span>
                                                    <span class="mr-2">
                                                        <a href="<?php echo (file_exists($val['link_html']) ? $val['link_html'] : "#"); ?>">
                                                            <i class="fa fa-user"></i>
                                                            <?php echo $n_owner; ?>
                                                        </a>
                                                    </span>
                                                    <span class="mr-2">
                                                        <a href="more_news.php?c_id=<?php echo $c_group["c_id"]; ?>">
                                                            <i class="fa fa-book"></i> <?php echo $c_group["c_name"]; ?>
                                                        </a>
                                                    </span>
                                                </p>
                                            </div>
                                            <?php echo '</div>'; ?>
                                            <?php echo '</div>'; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                        <?php if (!empty($article_list[$value["c_id"]])) { ?>
                            <div class="row">
                                <div class="col-12 text-center">
                                    <a href="more_news.php?c_id=<?php echo $value['c_id']; ?>" target="_black">
                                        <div class="more-index mx-auto my-3">
                                            อ่านทั้งหมด
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>

            </div>
        </div>
    </div>
</div>

<?php include('component/news_count.php'); ?>