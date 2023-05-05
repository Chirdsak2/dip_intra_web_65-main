<?php
DEFINE('path', 'assets/');
include path . 'config/config.inc.php';
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);
// $sso = new sso();
$n_id = $_GET['n_id'];
$news_data = article::getArticle($n_id);
$news_detail = article::getArticleListDetail($n_id, null);
$news_attach = article::genArticleAttach($n_id);
$news_tag_list = article::getArticleTag($n_id);
$news_comment = article::getArticleComment($n_id);
$news_group = article::getArticleFirstGroup(null, $n_id);
$c_name = article::getArticleFirstGroup($c_id)['c_name'];

$visitors = main::getVisitors();
//header.php
$template_management = sitelayout::getSiteLayout('site_management');
$template_position = sitelayout::getSiteLayout('site_position');
$menu_view3 = menu::genMenuView3($template_management["site_mainmenu"], 3);
//footer.php
$menu_footer_t3 = menu::getMenuFooter3($template_management["site_sitemap"]);

// $user_profile = user::chkUser(array("gen_user_id" => $_SESSION["EWT_MID"]))[0];
// $gen_user = $_SESSION["EWT_USERNAME"]; 
// $user_sso = $sso->getUser($gen_user)["data"]; 
// $full_name = $user_sso["USR_FNAME"] . ' ' . $user_sso["USR_LNAME"]; 
// $webb_image = getImgbase64("profile/" . $user_profile["webb_pic"], "images/user_profile_empty.png"); 
?>

<!doctype html>
<html lang="en">

<head>
  <link rel="shortcut icon" href="assets/img/favicon.png" />
  <title> DIP INTRANET </title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Bootstrap CSS  v4.6.1 -->
  <link rel="stylesheet" href="assets/css/bootstrap.css">
  <!-- Style CSS Template 3 -->
  <link rel="stylesheet" href="assets/css/style.css">
  <!-- Font Awesome Free 5.15.4 -->
  <link rel="stylesheet" href="assets/css/all.css">
  <!-- Font on Website -->
  <link rel="stylesheet" href="assets/css/prompt.css">
  <!-- fa fa icon -->
  <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
  <!-- article -->
  <link rel="stylesheet" href="assets/css/article.css">
  <!-- jquery -->
  <script src="assets/js/jquery-2.1.1.js" type="text/javascript"></script>
</head>

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
    background-color: rgb(0, 0, 0);
    background-color: rgba(0, 0, 0, 0.9);
  }

  .modal-content {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
  }

  #caption {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
    text-align: center;
    color: #ccc;
    padding: 10px 0;
    height: 150px;
  }

  .modal-content,
  #caption {
    -webkit-animation-name: zoom;
    -webkit-animation-duration: 0.6s;
    animation-name: zoom;
    animation-duration: 0.6s;
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

  .article_nvt{
    color: #fff;
  }
</style>

<body>

  <div id="Gototop"></div>
  <button onclick="topFunction()" id="myBtn" title="Go to top">
    <img src="assets/img/arrow_top.png" title="go to top" alt="go to top" class="">
  </button>
  <?php  //include('header.php'); ?>
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
      <div class="article--topic-name">
        <?php echo trim($news_data[0]['n_topic']); ?>
      </div>
      <div class="article-date-time">
        <!-- วันที่ -->
        <?php if ($news_data[0]["show_date"] == 1) { ?>
          <i class="fa fa-calendar-alt"></i> <?php echo convDateThai($news_data[0]['n_date'])['DateTH']; ?>
        <?php } ?>
        <!-- จำนวนการเข้าอ่านครั้ง -->
        <?php if ($news_data[0]["show_count"] == 1) { ?>
          <i class="fa fa-eye"></i> <?php echo $news_data[0]['view_count']; ?>
        <?php } ?>
        <!-- แสดงหน่วยงาน -->
       
      </div>
      <!-- แสดงรายละเอียดข้อมูล -->
      <p><?php echo $news_detail['txt_detail']; ?></p>
    </div>
    <?php } ?>
  </section>

  <!-- แสดงภาพประกอบข่าวตรงนี้ -->
  <?php echo $news_detail['txt_image']; ?>

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

  
  <?php include('footer.php'); ?>
</body>
</html>

<script>
  function getModalImageNew(key) {
    var modal = document.getElementById("modal_image_news_view");
    var img = document.getElementById("article_image" + key);
    var modalImg = document.getElementById("img_modal_new");
    var captionText = document.getElementById("caption");

    img.onclick = function() {
      modal.style.display = "block";
      modalImg.src = this.src;
      captionText.innerHTML = document.getElementById("article_text" + key).innerHTML;
    }

    var span = document.getElementById("btn_close");

    span.onclick = function() {
      modal.style.display = "none";
    }
  }
</script>
<?php db::db_close(); ?>