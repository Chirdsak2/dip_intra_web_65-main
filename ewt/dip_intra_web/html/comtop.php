<?php DEFINE('path', 'assets/');
include path . 'config/config.inc.php';
session_start();
//ข้อมูลล็อกอินเทสระบบ
$_SESSION["image_member"] = "assets/img/user-pic.jpg";
$_SESSION["name_comment"] = "ลลิษา มโนบาล";
$_SESSION["status_comment"] = "1";
$_SESSION["id_ans"] = "0";
$_SESSION["id_member"] = "0";
//Method GET
$c_id = $_GET['c_id'];
$n_id = $_GET['n_id'];
$s_search = $_GET['s_search'];
$page = isset($_GET["page"]) ? $_GET["page"] : 1;
$per_page = 12;
$start_from = ($page - 1) * $per_page;
//popup-home.php
$banner = banner::getBanner('39');
//header.php
$menu_view3 = menu::genMenuView3('0037');
$logo = sitelayout::getLogo();
//main_top_index.php
$vdo = banner::getBanner('37');
//news_tab_index.php
$article_group = article::getArticleGroup();
$article_list = array(
    "0" => article::getArticleArray('1','1','9'),
    "1" => article::getArticleArray('2','1','9'),
    "2" => article::getArticleArray('4','1','9')
);
//slide_footer_index.php
$slide_footer = banner::getSlideFooter('38');
$count_footer = banner::getBanner('38');
//footer.php
$menu_footer = menu::getMenuFooter('0038');
$contact_inform = sitelayout::getContact();
//popup-contact.php
$contact = banner::getBanner('40');
//execucive_calendar.php
$calendar_event = calendar::getEventCalendar();
$calendar_manager = calendar::getManagerCalendar();
//more_news.php
$c_name = article::getArticleFirstGroup($c_id)['c_name'];
$article_sub_group = article::getArticleSubGroup($c_id);
$article_check_group = article::getCheckGroup($c_id);
$total = article::getCountArticleLimit($c_id, $s_search);
$total_page = ceil($total / $per_page);
$prev = $page - 1;
$next = $page + 1;
$article_limit = article::getArticleLimit($c_id, $page, $per_page, $s_search);
$article_count = article::getCountArticleSubGroup($c_id); 
//news_view.php
$data = article::getArticle($n_id);
$news_detail = article::getArticleListDetail($n_id, null);
$news_attach = article::genArticleAttach($n_id);
$news_comment = article::getArticleComment($n_id,1,3);
$news_first_comment = article::getArticleFirstComment($n_id);
$news_list_comment = article::getArticleListComment($c_id,$n_id);
$news_date = article::getArticleDate($c_id, $n_id);
// var_dump($news_comment); exit();
?>

<!doctype html>
<html lang="en">

<head>
    <link rel="shortcut icon" href="assets/img/favicon.png" />
    <title> PRD INTRANET </title>
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css"
        integrity="sha384-jLKHWM3JRmfMU0A5x5AkjWkw/EYfGUAGagvnfryNV3F9VqM98XiIH7VBGVoxVSc7" crossorigin="anonymous">
</head>

<style>
.txt-short {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    width: 400px;
}

.text-short {
    white-space: nowrap;
    overflow: hidden;
    box-sizing: border-box;
    text-overflow: ellipsis;
    width: 400px;
}

.text-short-more-news {
    white-space: nowrap;
    overflow: hidden;
    box-sizing: border-box;
    text-overflow: ellipsis;
}

.position-pic-list-manager {
    margin: 5px 0 0 5px;
    height: 65px;
    width: 70px;
    z-index: 1;
    left: 0px;
    top: -13px;
    position: absolute;
    align-items: center;
    justify-content: center;
    display: flex;
    font-size: xx-large;
    border-radius: 50%;
}

.text-manager {
    font-size: 15px;
}
</style>

<body>
    <div id="Gototop"></div>
    <button onclick="topFunction()" id="myBtn" title="Go to top">
        <img src="assets/img/arrow_top.png" title="go to top" alt="go to top" class="">
    </button>

    <?php include 'popup-contact.php';?>

    <script src="assets/js/jquery-2.1.1.js" type="text/javascript"></script>
    </script>
