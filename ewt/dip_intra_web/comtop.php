<?php DEFINE('path', 'assets/');
include path . 'config/config.inc.php';
include path . 'class/db/dbdpis.class.php';

// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);

if (!user::chkLogin()) {
    //redirect('login.php');
    header("location: login.php");
}

//Check Url Template
$template_id = sitelayout::getTemplate()["template_id"];
switch ($template_id) {
    case 1:
        $t_header = "header.php";
        $t_article_index = null;
        $t_main_top_index = "main_top_index.php";
        $t_execucive_calendar = "execucive_calendar.php";
        $t_slide_footer_index = "slide_footer_index.php";
        $t_news_tab_index = "news_tab_index.php";
        $t_today = null;
        $t_footer = "footer.php";
        $style = "";
        break;
}

//Method GET
$page = getParam("page", 1);
$s_search = getParam('s_search');
$s_time = getParam('s_time');
//All Page
$per_page = 10;
$start = ($page - 1) * $per_page;
//Faq Page
$per_page_faq = 20;
$start_faq = ($page - 1) * $per_page_faq;
//Contact Page
$per_page_contact = 20;
$start_contact = ($page - 1) * $per_page_contact;
//Webboard Page
$per_page_webboard = 10;
$start_webboard = ($page - 1) * $per_page_webboard;
//Poll Page
$per_page_poll = 20;
$start_poll = ($page - 1) * $per_page_poll;
//Search Page
$per_page_search = 50;
$start_search = ($page - 1) * $per_page_search;

$per_page_vdo = 9;
$start_vdo = ($page - 1) * $per_page_vdo;
//Prev, Next Page
$prev = $page - 1;
$next = $page + 1;
//GET more_news, news_view
$c_org = getParam("c_org");
$c_id = getParam("c_id");
$cid = getParam("cid");
$n_id = getParam("n_id");
$nid = getParam("nid");
$n_date_start = getParam("n_date_start");
$n_date_end = getParam("n_date_end");
//GET calendar, more_calendar
$m_id = getParam('m_id');
$cat_id = getParam('cat_id');
$event_id = getParam('event_id');
$event_at_id = getParam('event_at_id');
$event_date_start = getParam('event_date_start');
$event_date_end = getParam('event_date_end');
//GET webboard / webboard_answer /more_webboard
$a_id = getParam("a_id");
$t_id = getParam("t_id");
$emotion_id = getParam("emotion_id");
//GET faq / more_faq
$faq_cate_id = getParam("faq_cate_id");
$faq_type = getParam("faq_type");
$fa_id = getParam("fa_id");
$faq_id = getParam("faq_id");
//GET RSS
$rss_id = getParam("rss_id");
//GET contact
$org_id = getParam("org_id");
$org_name = getParam("org_name");
$gen_user_id = getParam("gen_user_id");
$s_name = getParam("s_name");
$pertype_id = getParam("pertype_id");
$dep_id = getParam('dep_id');
$dvs_id = getParam('dvs_id');
$emp_type_id = getParam("emp_type_id");
//GET Search
$s_tid = getParam("s_tid");
$date_start = getParam("date_start");
$date_end = getParam("date_end");
$search_type = getParam("search_type", 1);
//GET receive_card_hbd
$ech_date = getParam("ech_date");
$ech_date_year = getParam("ech_date_year");
//GET notify_warn
$noti_search = getParam("noti_search");
//GET chat_messages
$chat_id = getParam("chat_id");
$chat_from_id = getParam("chat_from_id");
$chat_to_id = getParam("chat_to_id");
$chat_from_fullname = getParam("chat_from_fullname");
//GET contact_form
$com_cid = getParam("com_cid");
//-------------------------------------------------SiteLayout Setting------------------------------------------------------//
$meta = sitelayout::getMeta();
//header_index-t1.php / footer-t1.php / header_index-t2.php / footer-t2.php / header.php / footer.php
$template_management = sitelayout::getSiteLayout("site_management");
$template_position = sitelayout::getSiteLayout("site_position");
//-------------------------------------------------SiteLayout Setting------------------------------------------------------//
$template_article = sitelayout::getSiteLayout("site_management_section", "article");
$article_md = explode(',', $template_article["section_data"]);
//-------------------------------------------------------------------------------------------------------------------------//
//org_page.php
$org_page = org::getArticleOrg((!empty($c_org) ? $c_org : $c_id));
//visitors
// $visitors = main::getVisitors();
//setting_profile.php
$user_ewt = user::chkUser(array("gen_user_id" => $_SESSION["EWT_MID"]))[0]; //ข้อมูล EWT
//$user_sso = $sso->getUser($_SESSION["EWT_USERNAME"])["data"]; //ข้อมูล SSO
$user_title = org::getTitle(); //คำนำหน้า
$title_name = $user_ewt["title_thai"];
$full_name = $user_ewt["name_thai"] . ' ' . $user_ewt["surname_thai"]; //ชื่อ-นามสกุลภาษาไทย
$name_thai = $user_ewt["name_thai"]; //ชื่อภาษาไทย
$surname_thai = $user_ewt["surname_thai"]; //นามสกุลภาษาไทย
$name_eng = $user_ewt["name_eng"]; //ชื่อภาษาอังกฤษ
$surname_eng = $user_ewt["surname_eng"]; //นามสกุลภาษาอังกฤษ
$webb_name = $user_ewt["webb_name"]; //นามสมมุติผู้ใช้งาน

// ตรวจสอบว่ามีการเข้าสู่ระบบแล้วหรือไม่
if(isset($_SESSION['EWT_MID'])) {
    // ตรวจสอบเวลาที่เริ่มต้นการใช้งาน
    if(!isset($_SESSION['start_time'])) {
        $_SESSION['start_time'] = time();
    }

    // ตรวจสอบว่าเวลาที่ผ่านมาถึง 1 ชั่วโมงหรือไม่
    if((time() - $_SESSION['start_time']) > 3600) {
        // บังคับให้ผู้ใช้งานออกจากระบบ
        unset($_SESSION['EWT_MID']);
        session_destroy();
        header('Location: login.php');
        exit;
    }

    // ตรวจสอบว่ามีการเคลื่อนไหวหน้าเว็บหรือไม่
    if(isset($_SESSION['last_active_time']) && (time() - $_SESSION['last_active_time']) > 60) {
        $_SESSION['last_active_time'] = time();
        $_SESSION['start_time'] = time();
    } else if(!isset($_SESSION['last_active_time'])) {
        $_SESSION['last_active_time'] = time();
    }
}



if (!empty($user_ewt["webb_pic"])) { //เช็คฟิลด์รูปภาพ
    if (file_exists("profile/" . $user_ewt["webb_pic"])) { //เช็คไฟล์รูปภาพ
        $webb_image = "profile/" . $user_ewt["webb_pic"]; //รูปประจำตัว
    } else {
        $webb_image = "images/profile.jpg"; //"images/user_profile_empty.png"; //รูปประจำตัวที่ตั้งไว้
    }
} else {
    $webb_image = "images/profile.jpg"; //"images/user_profile_empty.png"; //รูปประจำตัวที่ตั้งไว้
}

// if (!empty($user_ewt["path_image"])) { //เช็คฟิลด์รูปภาพ1
//     if (file_exists("./ewtadmin/ewt/pic_upload/" . $user_ewt["path_image"])) { //เช็คไฟล์รูปภาพ1
//         $path_image = "./ewtadmin/ewt/pic_upload/" . $user_ewt["path_image"]; //รูปประจำตัว1
//     } else {
//         $path_image = "images/profile.jpg"; //"images/user_profile_empty.png"; //รูปประจำตัวที่ตั้งไว้1
//     }
// } else {
//     $path_image = "images/profile.jpg"; //"images/user_profile_empty.png"; //รูปประจำตัวที่ตั้งไว้1
// }


$birth_day = $user_ewt["birth_date"]; //วันเกิด
$birth_status = $user_ewt["birth_status"]; //สถาณะส่งการ์ดวันเกิด
$email_person = $user_ewt["email_person"]; //อีเมล์
$tel_in = $user_ewt["tel_in"]; //เบอร์โทรศัพท์

if (strpos($_SERVER["URL"], "more_news") !== false) {
} else {
    unset($_SESSION["EWT_ARTICLE_TAP_ACTIVE"]);
}

?>

<!doctype html>
<html lang="en">

<head>
<link rel="shortcut icon" href="assets/img/favicon.png" type="image/png">
    <!--<link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon" />-->
    <title> <?php echo $meta['site_info_title'] ?> </title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?php echo $meta['site_info_description'] ?>">
    <meta name="keywords" content="<?php echo $meta['site_info_keyword'] ?>">
    <meta name="author" content="<?php echo $meta['site_info_title'] ?>">
    <!-- Bootstrap CSS  v4.6.1 -->
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <!-- Style CSS Template 3 -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Stylesheet Demo -->
    <link rel="stylesheet" href="css/style_purple.css">

    <?php if ($template_id == 1 || $template_id == 2) { ?>
        <link rel="stylesheet" href="assets/css/<?php echo $style; ?>">
    <?php } ?>
    <?php if ($template_id == 1) { ?>
        <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <?php } ?>
    <!-- Font Awesome Free 5.15.4 -->
    <link rel="stylesheet" href="assets/css/all.css">
    <!-- Font Awesome Free 5.15.4 -->
    <link rel="stylesheet" href="assets/css/all2.css">
    <!-- Font on Website -->
    <link rel="stylesheet" href="assets/css/prompt.css">
    <!-- fa fa icon -->
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <!-- fullcalendar -->
    <link rel="stylesheet" href="assets/lib/jquery.fancybox.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="assets/fullcalendar/fullcalendar.css" />
    <link rel="stylesheet" href="assets/fullcalendar/fullcalendar.print.css" media="print" />

    <link href='Calendar_new/fullCalendar/lib/main.css' rel='stylesheet' />
    <!-- datepicker -->
    <link href="assets/datepicker/css/datepicker.css" rel="stylesheet">
    <!-- timepicker -->
    <!-- <link href="assets/css/timepicker.min.css" rel="stylesheet" /> -->
    <!-- select2 -->
    <link href="assets/css/select2.min.css" rel="stylesheet" />
    <!-- jquery-confirm -->
    <link rel="stylesheet" href="assets/css/jquery-confirm.min.css">
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

    .text-short-more-rss {
        white-space: nowrap;
        overflow: hidden;
        box-sizing: border-box;
        text-overflow: ellipsis;
        width: 395px;
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

    .fix-captcha {
        color: #fff;
        text-align: center;
        padding: 5px 10px;
        border-radius: 15px 15px 0px 0px;
    }

    .card-img-top-fix {
        width: 100%;
        height: 15vw;
        object-fit: cover;
    }

    .border-t-calendar-b {
        border-bottom: 1px solid #000;
        min-height: 8rem;
    }

    .bx {
        font-family: boxicons !important;
        font-weight: 400;
        font-style: normal;
        font-variant: normal;
        line-height: 1;
        text-rendering: auto;
        display: inline-block;
        text-transform: none;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    span.elipsis {
        display: none;
    }

    ._jw-tpk-container {
        position: absolute;
        width: 250px;
        height: 180px;
        padding: 0;
        background: #fff;
        font-family: inherit;
        font-weight: 400;
        overflow: hidden;
        border-radius: 3px;
        box-sizing: border-box;
        max-width: 250px;
        margin-left: auto;
        margin-right: auto;
        line-height: 1rem;
        font-size: 1rem;
    }

    .jconfirm-closeIcon {
        display: none;
    }

    .jconfirm.jconfirm-modern .jconfirm-box div.jconfirm-title-c {
        color: rgba(0, 0, 0, 0.87);
        font-size: 15px;
        font-weight: bold;
        text-align: center;
        margin-bottom: 10px;
    }

    .pe-2 {
        padding-right: 0.5rem !important;
        margin-left: 0px;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 60px !important;
    }

    .select2-container .select2-selection--single {
        height: 60px !important;
    }

    .select2-selection--single .select2-selection__arrow {
        height: 60px !important;
    }

    .article_nvt {
        color: #fff;
    }
</style>

<body>
    <!-- Optional JavaScript; choose one of the two! -->
    <!-- jquery -->
    <!-- <script src="assets/js/jquery-2.1.1.js" type="text/javascript"></script> -->
    <script src="assets/js/jquery.js"></script>
    <!-- Ck Ediror 4.18.0 --> 
    <!-- <script src="assets/js/basic/ckeditor.js"></script> -->
    <!-- <script src="assets/js/standard/ckeditor.js"></script> -->
    <!-- <script src="assets/js/full/ckeditor.js"></script> -->
    <!-- <script src="<?php echo HOST_PATH; ?>js/ckeditor/ckeditor.js"></script> -->
    <!-- <script src='assets/js/ckeditor/ckeditor.js'></script> -->
    <!-- fullcalendar -->
    <script src='assets/lib/moment.min.js'></script>
    <script src='assets/fullcalendar/fullcalendar.min.js'></script>
    <script src='assets/lib/lang/th.js'></script>
    <script src="assets/lib/jquery.fancybox.pack.js"></script>
    <!-- FullCalendar -->
    <!--<script src="calendar/fullCalendar/lib/main.js"></script> 
    <script src="calendar/fullCalendar/lib/locales/th.js"></script>-->

    <!-- datepicker -->
    <script src="assets/datepicker/js/bootstrap-datepicker.js"></script>
    <script src="assets/datepicker/js/bootstrap-datepicker-thai.js"></script>
    <script src="assets/datepicker/js/locales/bootstrap-datepicker.th.js"></script>
    <script src="assets/js/sortable/jquery-ui.min.js"></script>
    <!-- timepicker -->
    <!-- <script src="assets/js/timepicker.min.js"></script> -->
    <!-- select2 -->
    <script src="assets/js/select2.min.js"></script>
    <!-- jquery-confirm -->
    <script src="assets/js/jquery-confirm.min.js"></script>
    <!-- Bootstrap v4.6.1 -->
    <script src="assets/js/bootstrap.js"></script>
    <!-- Popper version 1.16.1 -->
    <script src="assets/js/popper.js"></script>
    <!-- Font Awesome Free 5.15.4 -->
    <script src="assets/js/all.js"></script>
    <!-- FontSize JS -->
    <script src="assets/js/fontsize.js"></script>
    <!-- Search header JS -->
    <script src="assets/js/search_header.js"></script>

    <div id="Gototop"></div>
    <button onclick="topFunction()" id="myBtn" title="Go to top">
        <img src="assets/img/arrow_top.png" title="go to top" alt="go to top" class="">
    </button>

    <?php include 'popup-contact.php'; ?>