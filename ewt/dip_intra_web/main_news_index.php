<?php
$article_group = article::getArticleGroup($article_md);
foreach ($article_group as $key => $value) {
    $article_list[$value["c_id"]] = article::getSubArticleList('0', '1', $value["c_id"]);
}
?>


<style>
    .carousel-indicators {
        position: absolute;
        right: 0;
        bottom: -15px;
        left: 0;
        z-index: 15;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-pack: center;
        justify-content: center;
        padding-left: 0;
        margin-right: 15%;
        margin-left: 15%;
        list-style: none;
    }

    /* .carousel_icon li {
    background-color: #751B7D;
    border-radius: 50px;
    width: 10px;
    height: 10px;
    border-top: 0px;
    border-bottom: 0px;
} */
</style>


<?php
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://portal.diprom.go.th/DIP_SSO/api/public/GetSystem',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer ' . $_SESSION['EWT_TOKEN'],
        'Content-Type: application/json',
        'Content-Length: 0'
    ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

echo $err;
curl_close($curl);

$permission = json_decode($response, true);
// echo "<pre>"; print_r($permission); echo "</pre>";
// print_r($permission);
?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="section-header mt-5">
                <h2 class="text_h_new mb-3"> ระบบงาน </h2>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <!-- carousel_icon -->
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="row">
                            <?php
                            foreach ($permission['data']['permission_list'] as $list) {
                            ?>
                                <?php if ($list['MAINTENANCE'] == "Y") { ?>
                                    <div class="col-6 col-sm-12 col-md-3 col-xl-2">
                                        <div class="text-center">
                                            <!-- <span class="noti-num pl-2 pr-2 ml-2 mr-2"> 2 </span> -->
                                            <a href="#" style="pointer-events: none;filter: grayscale(80%);opacity: 0.5;">
                                                <img src="<?php echo SSO_PATH . "attach/w3/" . $list['FILE_SAVENAME']; ?>" alt=" <?php echo $list['SYSTEMS_NAME']; ?>" title=" <?php echo $list['SYSTEMS_NAME']; ?>" class="w-50 text-right">
                                        </div>
                                        <div class="text-center">
                                            <span class="txt-system"> <?php echo $list['SYSTEMS_NAME']; ?><br>(ปิดปรับปรุงระบบ)</span>
                                        </div> </a>
                                    </div>
                                <?php } else { ?>
                                    <div class="col-6 col-sm-12 col-md-3 col-xl-2">
                                        <div class="text-center">
                                            <!-- <span class="noti-num pl-2 pr-2 ml-2 mr-2"> 2 </span> -->
                                            <a href="<?php echo $list['CALL_BACK']; ?>?bfs=<?php echo $permission['data']['user_detail']['USER_TOKEN'] ?>" target="_blank">
                                                <img src="<?php echo SSO_PATH . "attach/w3/" . $list['FILE_SAVENAME']; ?>" alt=" <?php echo $list['SYSTEMS_NAME']; ?>" title=" <?php echo $list['SYSTEMS_NAME']; ?>" class="w-50 text-right">
                                        </div>
                                        <div class="text-center">
                                            <span class="txt-system"> <?php echo $list['SYSTEMS_NAME']; ?></span>
                                        </div> </a>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                         </div>
                         <hr class="hr_news">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<!---------------------- Zone ข่าวสารและความรู้ ------------------------------>
<div class="container">
    <div class="row mt-3">
        <div class="col-xl-10 col-lg-10 col-md-8 col-sm-12 col-12">
            <div class="row">
                <div class="col-xl-1 col-lg-1 col-md-2 col-sm-2 col-2">
                    <img class="img-fluid" src="images/2knowledge.png" alt="">
                </div>
                <div class="col-xl-11 col-lg-11 col-md-10 col-sm-10 col-10">
                    <h2 class="text_h_new">ข่าวสารและความรู้</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <?php foreach ($article_group as $key => $value) { ?>
            <?php foreach ($article_list[$value["c_id"]] as $k => $val) { ?>
                <?php
                $c_group = article::getArticleFirstGroup(null, $val["n_id"]);
                $article_list_sub = article::getSubArticleList('0', '3', $value["c_id"]);

                switch ($key) {
                    case 0:
                        $tag_bg = "know";
                        break;
                    case 1:
                        $tag_bg = "PR";
                        break;
                    case 2:
                        $tag_bg = "event";
                        break;
                    default:
                        $tag_bg = "know";
                        break;
                }

                $n_owner = user::chkUser(array("gen_user_id" => $val["n_owner"]))[0];
                $full_name = $n_owner["name_thai"] . ' ' . $n_owner["surname_thai"];
                dbdpis::ConnectDB(SSO_DB_NAME, SSO_DB_TYPE, SSO_ROOT_HOST, SSO_ROOT_USER, SSO_ROOT_PASSWORD, SSO_DB_NAME, SSO_CHAR_SET);
                $fname = $n_owner["name_thai"];
                $lname = $n_owner["surname_thai"];
                $sql_profile = "SELECT * FROM M_PER_PROFILE
                LEFT JOIN USR_MAIN ON M_PER_PROFILE.PER_IDCARD = USR_MAIN.USR_OPTION3
                WHERE
                    M_PER_PROFILE.PER_NAME_TH LIKE '%" . $fname . "%'
                AND M_PER_PROFILE.PER_LASTNAME_TH LIKE '%" . $lname . "%'
                ";
                $result = dbdpis::getFetch($sql_profile);

                if (!empty($result['USR_PICTURE'])) {
                    $path_image = SSO_PATH . "profile/" . $result['USR_PICTURE'];
                } else {
                    $path_image = "./assets/img/avatar-2.png";
                }

                if (!empty($val['picture'])) {
                    $picture = 'images/article/news' . $val['n_id'] . '/' . $val['picture'];
                } else {
                    $picture = "images/photo1.jpg";
                }
                ?>

                <div class="col-lg-4 col-md-4 col-sm-12 col-12 my-2">

                    <div class="item">
                        <!-- card news update -->
                        <div class="latest-post box-shadow-news border-ra-15px" title="<?php $val['n_topic']; ?>">
                            <div class="latest-post-media">
                                <?php if ($val["pinned"] == "Y") { ?>
                                    <div class="pin-article-web">
                                        <i class="fas fa-thumbtack" alt="ปักหมุด" title="ปักหมุด"></i>
                                    </div>
                                <?php } ?>
                                <a href="<?php echo ($val['news_use'] == 1 ? $val['link_html'] : "news_view.php?n_id=" . $val['n_id'] . ""); ?>" class="latest-post-img">
                                    <div class="tag-bg-<?php echo $tag_bg; ?> position-tag-bg">
                                        <?php echo $value["c_name"]; ?>
                                    </div>

                                    <a href="<?php echo ($val['news_use'] == 1 ? $val['link_html'] : "news_view.php?n_id=" . $val['n_id'] . ""); ?>" target="<?php echo $val['target']; ?>" title="<?php echo $c_group['c_name']; ?>">
                                        <img class="img-fluid border-ra-15px max-h-highligh-news w-100" src="<?php echo $picture; ?>" alt="img">
                                    </a>
                                </a>
                            </div>

                            <div class="post-body px-3 pt-1 news-hilight border-ra-bottom-15px">
                                <h4 class="post-title" title="<?php echo $val['n_topic']; ?>">
                                    <a href="<?php echo ($val['news_use'] == 1 ? $val['link_html'] : "news_view.php?n_id=" . $val['n_id'] . ""); ?>" class="d-inline-block">
                                        <p class="mb-0 color-news-hilight">
                                            <?php echo mb_strimwidth($val['n_topic'], 0, 50, '...'); //substr($val["n_topic"], 0, -150); 
                                            ?>
                                        </p>
                                    </a>
                                </h4>
                                <div class="latest-post-meta ">
                                    <div class="row">
                                        <div class="col-lg-7 col-md-12 col-sm-12 col-12 pr-0  mt-2">
                                            <img class="img-fluid img-user-news " src="<?php echo $path_image; ?>" alt="img"><span class="ml-3 color-news-header"><?php echo $full_name; ?></span>
                                        </div>
                                        <div class="col-lg-5 col-md-12 col-sm-12 col-12 pl-3 mt-2">
                                            <i class="fa fa-calendar color-news-header"></i><span class="ml-1 color-news-header"> <?php echo convDateThai($val['n_date'])['DateTH']; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Latest post end -->
                    </div>

                    <!-- ข่าวเล็ก -->
                    <?php foreach ($article_list_sub as $k_sub => $val) { ?>
                        <?php
                        $c_group = article::getArticleFirstGroup(null, $val["n_id"]);
                        $n_owner = user::chkUser(array("gen_user_id" => $val["n_owner"]))[0];
                        $full_name = $n_owner["name_thai"] . ' ' . $n_owner["surname_thai"];
                        $fname = $n_owner["name_thai"];
                        $lname = $n_owner["surname_thai"];
                        $sql_profile = "SELECT * FROM M_PER_PROFILE
                        LEFT JOIN USR_MAIN ON M_PER_PROFILE.PER_IDCARD = USR_MAIN.USR_OPTION3
                        WHERE
                            M_PER_PROFILE.PER_NAME_TH LIKE '%" . $fname . "%'
                        AND M_PER_PROFILE.PER_LASTNAME_TH LIKE '%" . $lname . "%'
                        ";
                        $result = dbdpis::getFetch($sql_profile);

                        if (!empty($result['USR_PICTURE'])) {
                            $path_image = SSO_PATH . "profile/" . $result['USR_PICTURE'];
                        } else {
                            $path_image = "./assets/img/avatar-2.png";
                        }

                        if (!empty($val['picture'])) {
                            $picture = 'images/article/news' . $val['n_id'] . '/' . $val['picture'];
                        } else {
                            $picture = "images/photo1.jpg";
                        }
                        ?>
                        <?php if ($k_sub > 0) { ?>
                            <div class="row ml-2 mt-3 min-height105">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-3  p-0">
                                
                                    <a href="<?php echo ($val['news_use'] == 1 ? $val['link_html'] : "news_view.php?n_id=" . $val['n_id'] . ""); ?>" target="<?php echo $val['target']; ?>" title="<?php echo $c_group['c_name']; ?>">
                                        <img class="img-fluid img-news-ra shadow" src="<?php echo $picture; ?>" alt="img">
                                    </a>
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-9 col-9">
                                <?php if ($val["pinned"] == "Y") { ?>
                                    <div class="pin-article-web-list">
                                        <i class="fas fa-thumbtack" alt="ปักหมุด" title="ปักหมุด"></i>
                                    </div>
                                    <?php }?>
                                    <div class="mb-1 tag-bg-<?php echo $tag_bg; ?>">
                                        <?php echo $value["c_name"]; ?>
                                    </div>
                                    <a href="<?php echo ($val['news_use'] == 1 ? $val['link_html'] : "news_view.php?n_id=" . $val['n_id'] . ""); ?>" title="<?php echo $val['n_topic']; ?>" class="txt-header-news mt-1">
                                        <?php echo mb_strimwidth($val['n_topic'], 0, 47, '...'); //substr($val["n_topic"], 0, -150); 
                                        ?>
                                    </a>
                                    <div class="row">
                                        <div class="col-lg-7 col-md-12 col-sm-6 col-6 pr-0  mt-2">
                                            <img class="img-fluid img-user-news " src="<?php echo $path_image; ?>" alt="img"><span class="ml-1"><?php echo $full_name; ?></span>
                                        </div>
                                        <div class="col-lg-5 col-md-12 col-sm-6 col-6 p-0 mt-2">
                                            <i class="fa fa-calendar ml-3"></i><span class="ml-1"> <?php echo convDateThai($val['n_date'])['DateTH']; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center w-75">
                            <a href="more_news.php?c_id=<?php echo $value["c_id"]; ?>" type="button" class="btn-search btn Gradient-Color btn-right-sm btn-sm mt-2 mb-3 w-100"> ดูเพิ่มเติม</a>
                        </div>
                    </div>
                </div>

            <?php } ?>
        <?php } ?>
    </div>
    <hr class="hr_news">
</div>

<?php include('component/news_count.php'); ?>

<!-- <script>
    
    // Testimonials carousel สไลด์ของ ระบบที่ดึง Service มา
    $(".testimonials-carousel").owlCarousel({
        autoplay: true,
        /*animateIn: 'slideInDown',
        animateOut: 'slideOutDown',*/
        items: 1,
        smartSpeed: 450,
        dots: true,
        loop: true,
        nav : true,
        navText : [
            '<i class="fa fa-angle-left" aria-hidden="true"></i>',
            '<i class="fa fa-angle-right" aria-hidden="true"></i>'
        ],
        responsive: {
            0:{
                items:1
            },
            576:{
                items:1
            },
            768:{
                items:2
            },
            992:{
                items:4
            }
        }
    });
    
</script> -->