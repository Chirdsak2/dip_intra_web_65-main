<?php include 'comtop.php'; ?>
<?php include 'header.php'; ?>
<?php
function chkDetailImage($news_list_detail)
{
  if ($news_list_detail[0]['ad_pic_b'] != "" or $news_list_detail[0]['ad_des'] != "" and $news_list_detail[0]['at_type_row'] != "11") {
    return true;
  } else {
    return false;
  }
}

$news_group = article::getArticleFirstGroup(null, $n_id);
$news_data = article::getArticle($n_id);
$news_detail = article::getArticleListDetail($n_id, null);
$news_attach = article::genArticleAttach($n_id);
$news_comment = article::getArticleComment($n_id);
$news_tag_list = article::getArticleTag($n_id);
$news_list_detail = article::getNewArticleListDetail($n_id);

$n_topic = $news_data[0]['n_topic'];
$show_date = $news_data[0]["show_date"];
$show_count = $news_data[0]["show_count"];
$view_count = $news_data[0]['view_count'];
$n_date = $news_data[0]['n_date'];
$n_owner_org = $news_data[0]['n_owner_org'];
$n_time = $news_data[0]['n_time'];
$n_owner = user::chkUser(array("gen_user_id" => $news_data[0]["n_owner"]))[0];

$news_tag_list_article = array_chunk($news_tag_list, 3);
$news_tag_list_article_count = count($news_tag_list_article);
?>

<style>
  .badge-search {
    padding: 5px 15px;
    font-size: 12px;
    border: 1px solid #5b5aa8;
    color: #5b5aa8;
    box-shadow: 0px 0px 20px 2px #cccccc;
    margin-bottom: 10px;
  }

  #articl_image {
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
  }

  #articl_image:hover {
    opacity: 0.7;
  }

  .modal {
    display: none;
    position: fixed;
    z-index: 1;
    padding-top: 100px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: black;
  }

  .modal-content {
    position: relative;
    background-color: #fefefe;
    margin: auto;
    padding: 0;
    width: 100%;
    max-width: 1200px;
  }

  .close {
    float: right;
    font-size: 5.5rem;
    font-weight: 700;
    line-height: 1;
    color: #fff;
    text-shadow: 0 1px 0 #fff;
    opacity: 5;
    cursor: pointer;
  }

  .close:hover,
  .close:focus {
    color: #999;
    text-decoration: none;
    cursor: pointer;
  }

  .mySlides {
    max-width: 1000px;
    position: relative;
    margin: auto;
    z-index: 99999;
  }

  .cursor {
    cursor: pointer;
  }

  .prev,
  .next {
    cursor: pointer;
    position: absolute;
    top: 50%;
    width: auto;
    padding: 16px;
    margin-top: -50px;
    color: white;
    font-weight: bold;
    font-size: 20px;
    transition: 0.6s ease;
    border-radius: 0 3px 3px 0;
    user-select: none;
    -webkit-user-select: none;
  }

  .next {
    right: 0;
    border-radius: 3px 0 0 3px;
  }

  .prev:hover,
  .next:hover {
    background-color: rgba(0, 0, 0, 0.8);
  }

  .numbertext {
    color: #f2f2f2;
    font-size: 12px;
    padding: 8px 12px;
    position: absolute;
    top: 0;
  }

  img {
    margin-bottom: -4px;
  }

  .caption-container {
    text-align: center;
    background-color: black;
    padding: 2px 16px;
    color: white;
  }

  .demo {
    opacity: 0.6;
  }

  .active,
  .demo:hover {
    opacity: 1;
  }

  img.hover-shadow {
    transition: 0.3s;
  }

  .hover-shadow:hover {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
  }

  @-webkit-keyframes zoom {
    from {
      -webkit-transform: scale(0)
    }

    to {
      -webkit-transform: scale(1)
    }
  }

  @keyframes zoom {
    from {
      transform: scale(0)
    }

    to {
      transform: scale(1)
    }
  }

  @media only screen and (max-width: 700px) {
    .modal-content {
      width: 100%;
    }
  }

  .article_nvt {
    color: #fff;
  }

  #playerimg {
    width: 100%;
    border-radius: 10px;
    background-color: beige;
    height: 180px;
  }

  .pic-mini-cora_1 {
    height: 50px;
    border-radius: 5px;
  }

  .carousel-indicators {
    position: absolute;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 15;
    display: -ms-flexbox;
    top: 120%;
    display: flex;
    -ms-flex-pack: center;
    justify-content: center;
    padding-left: 0;
    margin-right: 15%;
    margin-left: 15%;
    list-style: none;
  }

  @media (min-width: 768px) {
    #playerimg {
      width: 100%;
      border-radius: 10px;
      background-color: beige;
      height: 300px;
    }

    .pic-mini-cora_1 {
      height: 100px;
      border-radius: 5px;
    }
  }

  @media (min-width: 1024px) {
    .pic-mini-cora_1 {
      height: 80px;
      border-radius: 5px;
    }
  }
  .icon_left{
    color:#9c038b;
    font-size:26px;
  }
  .icon_rigth{
    color:#9c038b;
    font-size:26px;
  }
</style>

<!-- Style CSS Template 3 -->
<link rel="stylesheet" href="assets/css/article.css">

<div class="container-fluid mar-t-90px bg--purple text-center">
  <div class="container py-5">
    <div class="article--topic"><?php echo $news_group['c_name']; ?></div>
    <small style="color: #fff;">
      <a href="index.php" title="หน้าหลัก" class="article_nvt">หน้าหลัก </a>
      <?php echo article::article_group_parent($news_group['c_id']); ?>
    </small>
  </div>
</div>

<section id="article-sec bg--white">
  <?php if (!empty($news_data) && $news_group['c_show_document'] == 'Y') { ?>
    <div class="container mt-3">
      <!-- start breadcrumb -->
      <!-- <p><a href="index.php" title="กลับหน้าหลัก">หน้าหลัก</a> / <a href="more_news.php?c_id=<?php echo $news_group['c_id']; ?>" title="<?php echo $news_group['c_name']; ?>"><?php echo $news_group['c_name']; ?></a> </p> -->
      <!-- start breadcrumb -->
      <!-- <hr> -->
      <!-- แสดงเนื้อหาข่าวตรงนี้ -->
      <div class="article--topic-name">
        <?php echo trim($n_topic); ?>
      </div>

      <div class="article-date-time">
        <!-- วันที่ -->
        <?php if ($show_date == 1) { ?>
          <i class="fa fa-calendar-alt"></i> <?php echo convDateThai($n_date)['DateTH']; ?>
        <?php } ?>
        <!-- จำนวนการเข้าอ่านครั้ง -->
        <?php if ($show_count == 1) { ?>
          <i class="fa fa-eye"></i> <?php echo $view_count; ?>
        <?php } ?>
        <!-- แสดงหน่วยงาน -->
        <a href="#" title="<?php echo $n_owner_org; ?>">
          <i class="fa fa-user"></i>
          <?php echo $n_owner_org; ?>
        </a>
      </div>
      <!-- แสดงรายละเอียดข้อมูล -->

      <!------------------ Code Demo แสดงรายละเอียดข่าว -------------------->

      <!-- Open Code Demo รายละเอียดข่าว -->
      <div class="row my-4">
        <?php if ($news_list_detail) { ?>
          <div class="col-lg-6 col-md-12 col-sm-12 col-12">
            <div class="img-fluid w-100 mb-2" id="playerbox">
              <?php if ($news_list_detail[0]['ad_pic_b'] != "" or $news_list_detail[0]['ad_des'] != "" and $news_list_detail[0]['at_type_row'] != "11") {
                if ($news_list_detail[0]['ad_pic_s'] != "") {
                  $ad_pic_s = HTTP_HOST . "images/article/news" . $n_id . "/" . $news_list_detail[0]['ad_pic_b'];
                } else {
                  $ad_pic_s = HTTP_HOST . "images/news/1-1.jpg";
                }
              ?>
                <img id="playerimg" src="<?php echo $ad_pic_s; ?>">
              <?php } ?>
            </div>

            <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
              <!-- <ol class="carousel-indicators">
                <?php
                foreach ($news_list_detail as $key => $_itemDetail) {
                  if ($_itemDetail['ad_pic_b'] != "" or $_itemDetail['ad_des'] != "" and $_itemDetail['at_type_row'] != "11") {
                ?>
                    <li data-target="#carouselExampleCaptions" data-slide-to="<?php echo $key; ?>" class="<?php echo ($key == 0 ? "active" : ""); ?>"></li>
                <?php }
                } ?>
              </ol> -->

              <div class="carousel-inner">
                <?php
                foreach ($news_list_detail as $key => $_itemDetail) {
                  if ($_itemDetail['ad_pic_b'] != "" or $_itemDetail['ad_des'] != "" and $_itemDetail['at_type_row'] != "11") {
                    if ($_itemDetail['ad_pic_s'] != "") {
                      $ad_pic_s = HTTP_HOST . "images/article/news" . $n_id . "/" . $_itemDetail['ad_pic_b'];
                    } else {
                      $ad_pic_s = HTTP_HOST . "images/news/1-1.jpg";
                    }
                ?>
                    <div class="carousel-item <?php echo ($key == 0 ? "active" : ""); ?>">
                      <div class="row">
                        <div class="user"></div>

                        <div class="col-lg-3 col-md-3 col-sm-3 col-3">
                          <div class="item">
                            <img class="myclass d-block w-100 pic-mini-cora_1" src="<?php echo $ad_pic_s; ?>" />
                          </div>
                        </div>

                      </div>
                    </div>
                <?php }
                } ?>
              </div>


              <button class="carousel-control-prev" type="button" data-target="#carouselExampleCaptions" data-slide="prev">
                <i class="fa fa-chevron-left icon_left" aria-hidden="true" data-target="#carouselExampleCaptions"></i>
              </button>

              <button class="carousel-control-next" type="button" data-target="#carouselExampleCaptions" data-slide="next">
                   <i class="fa fa-chevron-right icon_rigth" aria-hidden="true"></i>
              </button>
            </div>
          </div>
        <?php } ?>

        <!-- text paragraph -->
        <div class="col-lg-<?php echo chkDetailImage($news_list_detail) == true ? "6" : "12"; ?> col-md-12 col-sm-12 col-12 mt-5">

          <?php echo $news_detail['txt_detail']; ?>

          <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mt-2">
              <!-- shadow-sm -->
              <div class="shadow-sm border-ra-15px">
                <!-- ภายในกล่องชื่อผู้รับผิดชอบ -->
                <div class="row">
                  <!-- รูปภาพผู้รับผิดชอบ -->
                  <div class="col-lg-5 col-md-4 col-sm-3 col-4 ">
                    <img src="images/user.jpg" class="d-block w-100 p-2 border-ra-15px" alt="...">
                  </div>
                  <!-- ชื่อ/วันที่/เวลา -->
                  <div class="col-lg-7 col-md-8 col-sm-9 col-8 pl-0 mb-2">
                    <h4 class="mt-2 h2-color mb-0 pr-1" style="font-weight: bold;"><?php echo $n_owner["name_thai"] . ' ' . $n_owner["surname_thai"]; ?></h4>
                    <p class="h2-color mt-1 mb-0 pr-1"><i class="fa fa-calendar h2-color"></i> <?php echo convDateThai($n_date)['DateTH']; ?></p>
                    <p class="h2-color mb-2 pr-1"><i class="fa fa-clock h2-color"></i> <?php echo convDateThai($n_time)['TimeTH']; ?></p>
                  </div>
                </div>
              </div>
            </div>
            <!-- แฟ้มเก็บข้อมูล -->
            <div class="col-lg-3 col-md-3 col-sm-6 col-6 mt-2 px-1">
              <a class="btn shadow-sm border-ra-15px bg-color-purple w-100 white-text fontAw-position" href="update_news.php?id=<?php echo $n_id?>" role="button">
                <i class="fa fa-folder"></i>
                <p class="font-boxfloder white-text">เก็บใส่แฟ้ม</p>
              </a>
            </div>
            <!-- ข้อมูลเข้าชม -->
            <div class="col-lg-3 col-md-3 col-sm-6 col-6 mt-2 px-1">
              <div class="shadow-sm border-ra-15px txt-purple w-100 fontAw-position">
                <i class="fa fa-eye"></i>
                <h3 class="font-boxfloder mt-1 txt-purple pb-4 "><?php echo $view_count; ?></h3>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Open เรื่องอื่นในหมวด -->
      <hr class="hr_news mt-5">

      <?php if ($news_tag_list_article) { ?>
        <h2 class="h2-color mt-4">
          <i class="fa fa-link"></i> เรื่องอื่นในหมวด
        </h2>

        <div id="carouselExampleFade" class="carousel slide carousel-fade mb-5" data-ride="carousel">
          <div class="carousel-inner">
            <?php for ($i = 0; $i < $news_tag_list_article_count; $i++) { ?>
              <div class="carousel-item <?php echo ($i == 0 ? 'active' : null); ?>">
                <div class="row">
                  <?php
                  foreach ($news_tag_list_article[$i] as $key => $value) {
                    $news_group = article::getArticleFirstGroup(null, $value["n_id"]);
                    $news_data = article::getArticle($value["n_id"])[0];
                    $n_owner = user::chkUser(array("gen_user_id" => $news_data["n_owner"]))[0];
                    $full_name = $n_owner["name_thai"] . ' ' . $n_owner["surname_thai"];
                    $webb_pic = getImage("profile/", $n_owner['webb_pic'], "images/user.jpg");
                    $picture = getImage('images/article/news' . $value['n_id'] . '/', $value['picture'], "images/photo2.jpg");
                  ?>
                    <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                      <div class="item">
                        <!-- card news update -->
                        <div class="latest-post box-shadow-news border-ra-15px">
                          <div class="latest-post-media">
                            <a href="<?php echo ($news_data['news_use'] == 1 ? $news_data['link_html'] : "news_view.php?n_id=" . $news_data['n_id'] . " "); ?>" class="latest-post-img">
                              <div class="tag-bg-event position-tag-bg">
                                <?php echo $news_group["c_name"]; ?>
                              </div>
                              <img class="img-fluid border-ra-15px max-h-highligh-news w-100" src="<?php echo $picture; ?>" alt="img">
                            </a>
                          </div>
                          <div class="post-body px-3 pt-1 news-hilight border-ra-bottom-15px">
                            <h4 class="post-title">
                              <a href="<?php echo ($val['news_use'] == 1 ? $val['link_html'] : "news_view.php?n_id=" . $val['n_id'] . " "); ?>" class="d-inline-block ">
                                <p class="color-news-hilight mb-0">
                                  <?php echo $news_data["n_topic"]; ?>
                                </p>
                              </a>
                            </h4>
                            <div class="latest-post-meta ">
                              <div class="row">
                                <div class="col-lg-7 col-md-7 col-sm-12 col-12 pr-0  mt-2">
                                  <img class="img-fluid img-user-news" src="<?php echo $webb_pic; ?>" alt="img"><span class="ml-3 color-news-header"><?php echo $full_name; ?></span>
                                </div>
                                <div class="col-lg-5 col-md-5 col-sm-12 col-12 p-0 mt-2">
                                  <i class="fa-solid fa-calendar-days color-news-header"></i><span class="ml-1 color-news-header"> <?php echo convDateThai($news_data['n_date'])['DateTH']; ?></span>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div><!-- Latest post end -->
                      </div>
                    </div>
                  <?php } ?>
                </div>
              </div>
            <?php } ?>
          </div>

          <button class="carousel-control-prev  " type="button" data-target="#carouselExampleFade" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </button>

          <button class="carousel-control-next " type="button" data-target="#carouselExampleFade" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </button>
        </div>
      <?php } ?>

      <!-- Code ดึงรายละเอียดข่าว -->
      <p><?php //echo $news_detail['txt_detail']; 
          ?></p>
    </div>

    <!-- แสดงภาพประกอบข่าวตรงนี้ -->
    <?php //echo $news_detail['txt_image']; 
    ?>

    <!-- แสดงไฟล์แนบประกอบข่าวตรงนี้ -->
    <?php if (!empty($news_attach)) { ?>
      <div class="container">
        <h6 class="article-header mb-3">รายการเอกสารแนบ <?php echo $news_attach["count"]; ?> รายการ</h6>
        <?php foreach ($news_attach["data"] as $key => $value) { ?>
          <div class="article-attach-file-block">
            <div class="row">
              <div class="col-lg-9 col-md-9 col-sm-9 col-9">
                <div class="article-attach-list">
                  <a href="article_attach/<?php echo $value["fileattach_path"]; ?>" target="_blank" title="<?php echo $value["fileattach_name"]; ?>">
                    <?php echo $value["fileattach_name"]; ?>
                  </a>
                </div>
              </div>
              <div class="col-lg-3 col-md-3 col-sm-3 col-3 text-center">
                <div class="article-attach-view">
                  <a href="article_attach/<?php echo $value["fileattach_path"]; ?>" target="_blank" title="<?php echo $value["fileattach_name"]; ?>">
                    <i class="fa fa-download"></i> <span id="article_count<?php echo $key; ?>">
                    </span>
                  </a>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    <?php } ?>

    <?php if (!empty($news_tag_list) && !empty($n_id)) { ?>
      <div class="container">
        <h6 class="article-header mb-3">TAG</h6>
        <div class="article-attach-file-block">
          <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
              <div class="article-attach-view">
                <?php foreach ($news_tag_list as $value) { ?>
                  <span class="badge badge-search">
                    <a href="search.php?s_search=<?php echo $value["tag_name"]; ?>&search_type=1" title="<?php echo $value["tag_name"]; ?>" target="_blank">
                      <?php echo $value["tag_name"]; ?>
                    </a>
                  </span>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php } ?>

    <!-- แสดงความคิดเห็นข่าวตรงนี้ -->
    <!-- <?php if ($news_data[0]["show_comment"] == 1) { ?>
      <div class="container article-bg-comment artice-comment-block ">
        <div class="row">
          <div class="col-lg-6 mt-3 mb-3">
            <div class="text-center mt-3 mb-5">
              <h6 class="article-header">แสดงความคิดเห็น <?php echo $news_comment["count"]; ?> รายการ</h6>
            </div>
            <?php foreach ($news_comment["data"] as $key => $value) { ?>
              <?php
              $user_ewt = user::chkUser(["gen_user_id" => $value["id_member"]])[0];
              if (!empty($user_ewt["webb_pic"])) {
                if (file_exists("profile/" . $user_ewt["webb_pic"])) {
                  $user_image = "profile/" . $user_ewt["webb_pic"];
                } else {
                  $user_image = "images/user_profile_empty.png";
                }
              } else {
                $user_image = "images/user_profile_empty.png";
              }
              ?>
              <div class="media">
                <img src="<?php echo $user_image; ?>" class="mr-3 img-comment-avatar" alt="<?php echo $user_ewt["name_thai"] . ' ' . $user_ewt["surname_thai"]; ?>">
                <div class="media-body">
                  <div class="title-article"><?php echo $value['comment']; ?></div>
                  <small> <?php echo $user_ewt["name_thai"] . ' ' . $user_ewt["surname_thai"]; ?> , <?php echo convDateThai($value['timestamp'])['Date']; ?> , <?php echo convDateThai($value['timestamp'])['Time']; ?> น.</small>
                </div>
              </div>
            <?php } ?> 
          </div>

          <div class="col-lg-6 mt-3 mb-3">
            <div class="text-center mt-3 mb-5">
              <h6 class="article-header">ร่วมแสดงความคิดเห็น</h6>
            </div>
            <form id="comment_form">

              <div class="media">
                <img src="<?php echo $webb_image; ?>" class="align-self-center mr-3 img-comment-avatar" alt="<?php echo $full_name; ?>" title="<?php echo $full_name; ?>">
                <div class="media-body">
                  <div class="title-article"><?php echo $full_name; ?></div>

                  <small><?php echo convDateThai(date('Y-m-d'))['Date']; ?> , <?php echo date('H:i'); ?> น.</small>
                </div>
              </div>

              <div class="form-group mt-3">
                <input type="hidden" naem="c_id" id="c_id" value="<?php echo $c_id; ?>">
                <input type="hidden" name="n_id" id="n_id" value="<?php echo $n_id; ?>">
                <input type="hidden" naem="name_comment" id="name_comment" value="<?php echo $full_name; ?>">
                <input type="hidden" naem="id_member" id="id_member" value="<?php echo $_SESSION["EWT_MID"]; ?>">
                <textarea class="form-control shadow" name="comment" id="comment" rows="5" placeholder="ร่วมแสดงความคิดเห็นร่วมกันค่ะ"></textarea>
              </div>
              <button type="submit" class="btn btn-submit-comment btn-block mb-2">ส่งความคิดเห็น</button>
            </form>
          </div> -->
    </div>
    </div>
  <?php } ?>
<?php } ?>
</section>

<!--------------------------------- Modal Image ------------------------------------------>
<div id="myModal" class="modal">
  <span class="close cursor" onclick="closeModal()">&times;</span>

  <?php foreach ($news_detail["data"] as $key => $value) { ?>
    <?php if ($value['ad_pic_b'] != "" or $value['ad_des'] != "" and $value['at_type_row'] != "11") { ?>
      <?php if ($value['ad_pic_s'] != "") {
        $ad_pic_s = "images/article/news" . $n_id . "/" . $value['ad_pic_b'];
      } else {
        $ad_pic_s = "images/news/1-1.jpg";
      } ?>
      <div class="mySlides"><br><br>
        <center><img src="<?php echo $ad_pic_s; ?>" /></center>
        <div class="caption-container">
          <p id="caption"><?php echo $value["ad_des"]; ?></p>
        </div>
      </div>
    <?php } ?>
  <?php } ?>

  <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
  <a class="next" onclick="plusSlides(1)">&#10095;</a>
</div>

<?php include 'footer.php'; ?>
<?php include 'combottom.php'; ?>

<!------------------------- script modal --------------------------------------------------->
<script>
  function openModal() {
    document.getElementById("myModal").style.display = "block";
  }

  function closeModal() {
    document.getElementById("myModal").style.display = "none";
  }

  var slideIndex = 1;
  showSlides(slideIndex);

  function plusSlides(n) {
    showSlides(slideIndex += n);
  }

  function currentSlide(n) {
    showSlides(slideIndex = n);
  }

  function showSlides(n) {
    var i;
    var slides = document.getElementsByClassName("mySlides");

    var captionText = document.getElementById("caption");
    if (n > slides.length) {
      slideIndex = 1
    }
    if (n < 1) {
      slideIndex = slides.length
    }
    for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
    }

    slides[slideIndex - 1].style.display = "block";

  }
</script>

<!-- จัดการคอมเมนต์ -->
<script>
  $(document).ready(function() {
    $("#comment_form").on("submit", function(event) {
      event.preventDefault();

      let formData = new FormData($(this)[0]);
      formData.append('name_comment', $('#name_comment').val());
      formData.append('id_member', $('#id_member').val());

      $.ajax({
        url: "ajax/news_view.ajax.php",
        data: formData,
        processData: false,
        contentType: false,
        type: "POST",
        success: function(data) {
          let object = JSON.parse(data, true);
          if (object.status == "success") {
            window.location.reload();
          } else {
            console.log('Error');
          }
        },
        error: function(data) {
          console.log('Error');
        }
      });
    });
  });
</script>

<!-- คลิกภาพ -->
<script>
  function playerImg() {
    let playerImg = document.getElementById('playerimg');
    if (!playerImg) {
      playerImg = document.createElement('img');
      playerImg.id = 'playerimg';
      document.getElementById('playerbox').appendChild(playerImg);
    }
    return playerImg;
  }

  // set the source attribute of the playerImg
  function setPlayerImg(src) {
    playerImg().setAttribute('src', src);
  }

  // get the rock, paper, scissors elements with their common class
  const imgs = document.getElementsByClassName("myclass");

  // for each, add a click handler that calls our src setting function
  for (let i = 0; i < imgs.length; i++) {
    const el = imgs[i];
    el.addEventListener('click', () => setPlayerImg(el.src), false);
  }
</script>