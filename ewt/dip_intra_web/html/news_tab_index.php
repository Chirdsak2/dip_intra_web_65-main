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
                            <?php foreach ($article_list[$key] as $val) { ?>
                                <?php $n_owner = article::getOrg($val['n_owner'])['short_name']; ?>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-12 px-2">
                                    <div class="card mb-3">
                                        <div class="<?php echo (empty($val['picture']) ? "dis-inline-flex-news" : "row no-gutters"); ?>">
                                            <!-- เช็คไม่มีรูปภาพให้แสดงเป็นข้อความ -->

                                            <div class="<?php echo (empty($val['picture']) ? "dis-inline-flex max-width-left-pic" : "col-lg-4 col-md-12 col-sm-12 col-12"); ?>">
                                                <?php if (!empty($val['picture'])) { ?>
                                                    <img src="<?php echo HOST_NAME; ?>images/article/news<?php echo $val['n_id'] . '/', $val['picture']; ?>" alt="<?php echo $val['picture']; ?>" class="w-100 p-2 border-ra-15px" title="<?php echo $val['picture']; ?>">
                                                <?php } ?>
                                            </div>

                                            <div class="<?php echo (empty($val['picture']) ? "dis-inline-flex" : "col-lg-8 col-md-12 col-sm-12 col-12"); ?>">
                                                <div class="card-body p-2">
                                                    <div class="card-title font17px">
                                                        <a onclick="newsCount(<?php echo $val['c_id']; ?>,<?php echo $val['n_id']; ?>);" href="<?php echo ($val['news_use'] == 1 ? $val['link_html'] : "news_view.php?c_id=" . $val['c_id'] . "&n_id=" . $val['n_id'] . " "); ?>" target="<?php echo $val['target']; ?>" title="<?php echo $val['n_topic']; ?>" class="font-weight-bold txt-gray-dark2 font17px">
                                                            <?php echo (empty($val['picture']) ? mb_strimwidth($val['n_topic'], 0, 80, '...') : mb_strimwidth($val['n_topic'], 0, 50, '...')); ?>
                                                        </a>
                                                    </div>
                                                    <p class="card-text font13px">
                                                        <span class="mr-2"> <em class="far fa-calendar"></em> <?php echo ($val['show_date'] == 1 ? convDateThai($val['n_timestamp'])['DateTH'] : null); ?> </span>
                                                        <span class="mr-2" id="list_count<?php echo $val['n_id']; ?>"> <em class="far fa-eye"></em> <?php echo $val['view_count']; ?> </span>
                                                        <span class="mr-2 "> <a href="<?php echo (file_exists($val['link_html']) ? $val['link_html'] : "#"); ?>">
                                                                <em class="far fa-folder"></em> <?php echo $n_owner; ?> </a>
                                                        </span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="row">
                            <div class="col-12 text-center">
                                <a href="more_news.php?page=<?php echo $page;?>&c_id=<?php echo $value['c_id']; ?>" target="<?php echo (!empty($check_data) ? "_black" : null); ?>">
                                    <div class="more-index mx-auto my-3">
                                        อ่านทั้งหมด
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php } ?>

            </div>
        </div>
    </div>
</div>

<script>
    function newsCount(c_id, n_id) {
        $.ajax({
            type: 'GET',
            url: 'ajax/news_tab_index.ajax.php',
            data: {
                c_id: c_id,
                n_id: n_id,
                page: 'news_tab_index'
            },
            datatype: "text",
            success: function(data) {
                let object = JSON.parse(data, true);
                $('#list_count' + object.n_id).html(object.view_count);
                console.log(object);
            },
            error: function() {
                console.log('Error');
            }
        });
    }
</script>