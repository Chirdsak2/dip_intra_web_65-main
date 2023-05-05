<!-- Open Top -->
<?php include('comtop.php'); ?>
<?php include('header.php'); ?>

<?php
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// // error_reporting(E_ALL);
// error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

dbdpis::ConnectDB(SSO_DB_NAME, SSO_DB_TYPE, SSO_ROOT_HOST, SSO_ROOT_USER, SSO_ROOT_PASSWORD, SSO_DB_NAME, SSO_CHAR_SET);

// $modal_user = user::chkUser(array("gen_user_id" => $gen_user_id))[0];
$org_sql = "SELECT  * FROM USR_DEPARTMENT WHERE DEP_STATUS = 'Y' AND USR_DEPARTMENT.DEP_CODE = 'NEW_IMP'
AND ISNULL(
    USR_DEPARTMENT.DEPT_PARENT_ID,
    0
) = 0 ORDER BY DEP_NAME ASC";
$org_name = dbdpis::getFetchAll($org_sql);

$emp_sql = "SELECT * FROM M_PER_TYPE";
$emp_type = dbdpis::getFetchAll($emp_sql);

function getUserSSO($start, $per_page, $s_name = null, $emp_type_id = null, $org_id = null)
{

    $start = $start;
    $per_page = $per_page;
    $s_name = $s_name;
    $emp_type_id = $emp_type_id;
    $org_id = $org_id;

    $wh = "";

    if ($s_name) {
        $name_explode = explode(" ", $s_name);
        if (count($name_explode) > 1) {
            $name_thai = $name_explode[0];
            $surname_thai = $name_explode[1];
        } else {
            $name_thai = $s_name;
            $surname_thai = null;
        }

        if (empty($surname_thai)) {
            $wh .= " AND (  M_PER_PROFILE.PER_NAME_TH LIKE '%" . $s_name . "%'";
            $wh .= "OR M_PER_PROFILE.PER_LASTNAME_TH LIKE '%" . $s_name . "%')";
        } else {
            $wh .= " AND (M_PER_PROFILE.PER_NAME_TH LIKE '%" . $name_thai . "%'";
            $wh .= "OR M_PER_PROFILE.PER_LASTNAME_TH LIKE '%" . $surname_thai . "%')";
        }
    }

    if ($emp_type_id) {
        $wh .= " AND M_PER_PROFILE.PER_TYPE = {$emp_type_id}";
    }

    if ($org_id) {
        $wh .= " AND M_PER_PROFILE.DEP_LV1_ID = {$org_id}";
    }

    // if ($s_name) {
    //     $name_explode = explode(" ", $s_name);
    //     if (count($name_explode) > 1) {
    //         $name_thai = $name_explode[0];
    //         $surname_thai = $name_explode[1];
    //     } else {
    //         $name_thai = $s_name;
    //         $surname_thai = null;
    //     }

    //     if (empty($surname_thai)) {
    //         $wh .= " AND (USR_FNAME LIKE '%" . $s_name . "%'";
    //         $wh .= "OR USR_LNAME LIKE '%" . $s_name . "%')";
    //     } else {
    //         $wh .= " AND (USR_FNAME LIKE '%" . $name_thai . "%'";
    //         $wh .= "OR USR_LNAME LIKE '%" . $surname_thai . "%')";
    //     }
    // }

    // if ($emp_type_id) {
    //     $wh .= " AND USR_MAIN.USR_OPTION4 = {$emp_type_id}";
    // }

    // if ($org_id) {
    //     $wh .= " AND USR_MAIN.DEP_ID = {$org_id}";
    // }

    $all_s = "SELECT * , (select DEP_NAME FROM USR_DEPARTMENT WHERE M_PER_PROFILE.DEP_LV1_ID = USR_DEPARTMENT.DEP_ID) AS DEP_1,
    (select DEP_NAME FROM USR_DEPARTMENT WHERE M_PER_PROFILE.DEP_LV2_ID = USR_DEPARTMENT.DEP_ID) AS DEP_2 FROM M_PER_PROFILE
    LEFT JOIN USR_DEPARTMENT ON M_PER_PROFILE.DEP_LV1_ID = USR_DEPARTMENT.DEP_ID
    LEFT JOIN M_PER_TYPE ON M_PER_PROFILE.PER_TYPE = M_PER_TYPE.PER_TYPE_ID
    LEFT JOIN M_POSITION_LEVEL ON M_PER_PROFILE.PER_POSITION_LVL = M_POSITION_LEVEL.POS_LEVEL_ID
    LEFT JOIN USR_MAIN ON M_PER_PROFILE.PER_IDCARD = USR_MAIN.USR_OPTION3
    LEFT JOIN USR_POSITION ON M_PER_PROFILE.PER_POS_ID = USR_POSITION.POS_ID
    LEFT JOIN M_POSITION_MANAGE ON M_PER_PROFILE.PER_POS_MANAGE_ID = M_POSITION_MANAGE.POS_ADMIN_ID WHERE 1=1 
    {$wh} ORDER BY M_PER_PROFILE.PER_ID DESC OFFSET {$start} ROWS FETCH NEXT {$per_page} ROWS ONLY";
	
	
//      $all_s = "SELECT
//      *, (
//          SELECT
//              DEP_NAME
//          FROM
//              USR_DEPARTMENT
//          WHERE
//              USR_MAIN.DEP_ID = USR_DEPARTMENT.DEP_ID
//      ) AS DEP_1,
//      (
//          SELECT
//              DEP_NAME
//          FROM
//              USR_DEPARTMENT
//          WHERE
//              USR_MAIN.USR_OPTION5 = USR_DEPARTMENT.DEP_ID
//      ) AS DEP_2
//  FROM
//      USR_MAIN
//  LEFT JOIN USR_DEPARTMENT ON USR_MAIN.DEP_ID = USR_DEPARTMENT.DEP_ID
//  LEFT JOIN M_PER_TYPE ON USR_MAIN.USR_OPTION4 = M_PER_TYPE.PER_TYPE_ID
//  LEFT JOIN M_POSITION_LEVEL ON USR_MAIN.USR_OPTION2 = M_POSITION_LEVEL.POS_LEVEL_ID
//  LEFT JOIN USR_POSITION ON USR_MAIN.POS_ID = USR_POSITION.POS_ID
//  LEFT JOIN M_POSITION_MANAGE ON USR_MAIN.USR_OPTION1 = M_POSITION_MANAGE.POS_ADMIN_ID
//  WHERE
//      1 = 1 {$wh}
//  ORDER BY
//      USR_MAIN.USR_ID DESC";

    $a_row    = dbdpis::getRowCount($all_s);
    $a_data =  dbdpis::getFetchAll($all_s);

    // $_sql_all     = "SELECT USR_ID FROM USR_MAIN WHERE 1=1 {$wh}";
    $_sql_all     = "SELECT * FROM M_PER_PROFILE
    LEFT JOIN USR_MAIN ON M_PER_PROFILE.PER_IDCARD = USR_MAIN.USR_OPTION3
 WHERE 1=1 {$wh} ";
    $a_row_all    = dbdpis::getFetchAll($_sql_all); 
    $total_page = ceil(count($a_row_all) / $per_page);
    if ($a_data) {
        return array(
            "data" => $a_data,
            "count" => count($a_data),
            "countAll" => count($a_row_all),
            "sql" => $all_s,
            "sql2" => $_sql_all,
            "total" => $total_page
        );
    }
}

$phone_book = getUserSSO($start_contact, $per_page_contact, $s_name, $emp_type_id, $org_id);
//echo"<pre>";
//print_r($phone_book); 
//echo "</pre>";
//exit();
$type = "SELECT * FROM M_PER_TYPE INNER JOIN WF_FILE ON M_PER_TYPE.PER_TYPE_ID=WF_FILE.WFR_ID WHERE WF_FILE.WF_MAIN_ID = '26' ORDER BY M_PER_TYPE.PER_TYPE_ID ASC";
$datatype =  dbdpis::getFetchAll($type);

// echo "<pre>"; print_r($s_all);echo"</pre>"; exit();
// "SELECT * FROM M_PER_PROFILE
// LEFT JOIN USR_DEPARTMENT ON M_PER_PROFILE.DEP_LV1_ID = USR_DEPARTMENT.DEP_ID
// LEFT JOIN M_PER_TYPE ON M_PER_PROFILE.PER_TYPE = M_PER_TYPE.PER_TYPE_ID
// LEFT JOIN M_POSITION_LEVEL ON M_PER_PROFILE.PER_POSITION_LVL = M_POSITION_LEVEL.POS_LEVEL_ID
// LEFT JOIN USR_MAIN ON M_PER_PROFILE.PER_IDCARD = USR_MAIN.USR_OPTION3
// LEFT JOIN USR_POSITION ON M_PER_PROFILE.PER_POS_ID = USR_POSITION.POS_ID
// LEFT JOIN M_POSITION_MANAGE ON M_PER_PROFILE.PER_POS_MANAGE_ID = M_POSITION_MANAGE.POS_ADMIN_ID
// WHERE M_PER_PROFILE.PER_NAME_TH LIKE '%".$fname."%' AND M_PER_PROFILE.PER_LASTNAME_TH LIKE '%".$lname."%'";
$table = "M_PER_PROFILE a";
// $select = "a.name_thai,a.surname_thai,a.webb_pic,a.email_person,a.mobile,a.position_person,a.line_id,a.officeaddress,b.name_org,c.pos_name,d.level_name";
$select = "*";
$where = " a.PER_NAME_TH LIKE '%" . $fname . "%' AND a.PER_LASTNAME_TH LIKE '%" . $lname . "%'";
$table_join = "";
$table_join .= " LEFT JOIN USR_DEPARTMENT b ON (M_PER_PROFILE.DEP_LV1_ID = USR_DEPARTMENT.DEP_ID)";
$table_join .= " LEFT JOIN M_PER_TYPE c ON (a.PER_TYPE = c.PER_TYPE_ID)";
$table_join .= " LEFT JOIN M_POSITION_LEVEL d ON (a.PER_POSITION_LVL = d.POS_LEVEL_ID)";
$table_join .= " LEFT JOIN USR_MAIN e ON (a.PER_IDCARD = e.USR_OPTION3)";
$table_join .= " LEFT JOIN USR_POSITION f ON (a.PER_POS_ID = f.POS_ID)";
$table_join .= " LEFT JOIN M_POSITION_MANAGE g ON (a.PER_POS_MANAGE_ID = g.POS_ADMIN_ID)";
?>

<!-- Close Top -->
<link rel="stylesheet" href="assets/css/phonebook.css">
<!--
<div class="container-fluid mar-t-90px bg--purple">
	<div class="container py-5 text-center">
		<h3> ติดต่อสอบถาม </h3>
	</div>
</div>
-->

<style>
    /*----------------------*/


    ::placeholder {
        font-weight: bold;
    }

    .search-select {
        border: 1px solid #981c9d !important;
        border-radius: 5px !important;
    }

    .StepBox-882-sm {
        background-color: #82288c;
    }

    .StepBox-BE4-sm {
        background-color: #be4ec3;
    }

    .StepBox-882-sm {
        background-color: #82288c;
    }

    .block {
        position: absolute;
        left: 0;
        top: 0;
    }

    .slidercaptcha {
        margin: 0 auto;
        width: 100%;
        height: 300px;
        border-radius: 4px;
        margin-top: 0;
    }

    .slidercaptcha canvas:first-child {
        border-radius: 5px;
        border: 1px solid #e6e8eb;
    }

    .sliderContainer {
        position: relative;
        text-align: center;
        line-height: 40px;
        background: #f7f9fa;
        color: #45494c;
        border-radius: 2px;
    }

    .sliderbg {
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        background-color: #f7f9fa;
        height: 40px;
        border-radius: 2px;
        border: 1px solid #e6e8eb;
    }

    .sliderContainer_active .slider {
        top: -1px;
        border: 1px solid #1991FA;
    }

    .sliderContainer_active .sliderMask {
        border-width: 1px 0 1px 1px;
    }

    .sliderContainer_success .slider {
        top: -1px;
        border: 1px solid #02c076;
        background-color: #02c076 !important;
        color: #fff;
    }

    .sliderContainer_success .sliderMask {
        border: 1px solid #52CCBA;
        border-width: 1px 0 1px 1px;
        background-color: #D2F4EF;
    }

    .sliderContainer_success .sliderIcon:before {
        content: "\f00c";
    }

    .sliderContainer_fail .slider {
        top: -1px;
        border: 1px solid #f35c59;
        background-color: #f35c59;
        color: #fff;
    }

    .sliderContainer_fail .sliderMask {
        border: 1px solid #f35c59;
        background-color: #f7dcdd;
        border-width: 1px 0 1px 1px;
    }

    .sliderContainer_fail .sliderIcon:before {
        content: "\f00d";
    }

    .sliderContainer_active .sliderText,
    .sliderContainer_success .sliderText,
    .sliderContainer_fail .sliderText {
        display: none;
    }

    .sliderMask {
        position: absolute;
        left: 0;
        top: 0;
        height: 40px;
        border: 0 solid #d1e9fe;
        background: #d1e9fe;
        border-radius: 2px;
    }

    .slider {
        position: absolute;
        top: 0;
        left: 0;
        width: 40px;
        height: 40px;
        background: #fff;
        box-shadow: 0 0 3px rgba(0, 0, 0, 0.3);
        cursor: pointer;
        transition: background .2s linear;
        border-radius: 2px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .slider:hover {
        background: #009efb;
        color: #fff;
        border-color: #009efb;
    }

    .slider:hover .sliderIcon {
        background-position: 0 -13px;
    }

    .sliderText {
        position: relative;
    }

    .refreshIcon {
        position: absolute;
        right: 5px;
        top: 5px;
        cursor: pointer;
        padding: 6px;
        color: #fff;
        background-color: #ff4c4c;
        font-size: 14px;
        border-radius: 50px;
    }

    .refreshIcon:hover {
        color: #fff;
    }

    @media (min-width: 1px) and (max-width: 767px) {
        .dis-mobile {
            display: block;
        }

        .dis-pc {
            display: none;
        }

        .fa-envelope {
            color: #fff;
            font-size: 65px;
        }

        .fa-file-lines {
            color: #fff;
            font-size: 65px;
        }

        .fa-paper-plane {
            color: #fff;
            font-size: 65px;
        }

        .StepBox-882-sm {
            text-align: center;
        }

        .StepBox-BE4-sm {
            text-align: center;
        }

        .StepBox-882-sm {
            text-align: center;
        }
    }

    @media (min-width: 768px) and (max-width: 9999px) {
        .dis-mobile {
            display: none;
        }

        .dis-pc {
            display: block;
        }
    }

    .arrow-right-BE4-sm {
        width: 0;
        height: 0;
        border-right: 30px solid transparent;
        border-top: 30px solid #BE4EC3;
        border-left: 30px solid transparent;

        position: absolute;
        left: 42%;

    }

    .arrow-right-822-sm {
        width: 0;
        height: 0;
        border-right: 30px solid transparent;
        border-top: 30px solid #82288c;
        border-left: 30px solid transparent;

        position: absolute;
        left: 42%;

    }

    select option {
        background-color: #fff;
        color: #55595c;
    }

    select option[value="0"] {
        background-color: #82288c;
        color: #fff;
    }

    .article_nvt {
        color: #fff;
    }


    /* phone book */
    .icon_fa_left:hover {
        color: #82288c;
    }

    .icon_fa_right {
        color: #82288c;
    }

    ul#sub_menu li {
        display: inline;
    }

    .icon_file {
        font-size: 50px;
        margin-left: 124px;
        color: #ccc;
        margin-top: 10px;
    }

    .user_list {
        border-radius: 15px;
        height: 20px;
        width: 20px;
    }

    .page-item.active .page-link {
        z-index: 3;
        color: #fff;
        background-color: #82288c;
        border-color: #82288c;
    }

    .page-link {
        position: relative;
        display: block;
        padding: 0.5rem 0.75rem;
        margin-left: -1px;
        line-height: 1.25;
        color: #82288c;
        /* color: #007bff; */
        background-color: #fff;
        border: 1px solid #dee2e6;
    }

    .page-item {
        margin: 9px;
    }

    .border-b-phonebook {
        border-bottom: 1px dashed #eee;
    }

    .min-h-phonebook{
        min-height: 135px;
    }


    @media (min-width: 320px) { 
        .row_sm{
            display: none;
        }
        .mrgin_from{
            margin-top: 19%;
        }
     }
     @media (min-width: 768px) { 
        .row_sm{
            display: flex;
        }
        .mrgin_from{
            margin-top: 2%;
        }
     }
     @media (min-width: 1024px) { 
        .mrgin_from{
            margin-top: 1%;
        }
     }
</style>

<!-- Style CSS Template 3 -->
<link rel="stylesheet" href="assets/css/article.css">

<div class="dis-pc">
    <div class="container-fluid mar-t-90px bg--purple text-center">
        <div class="container py-5">
            <div class="article--topic"> สมุดโทรศัพท์ </div>
        </div>
    </div>
</div>

<!-- News index page -->
<div class="shadow-sm container-fluid Knowledge-bg-head  mrgin_from">
    <div class="container pb-3 ">

        <!-- Modal เปล่า -->
        <!-- Button trigger modal -->
        <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                Launch demo modal
                </button> -->

        <!-- Modal -->


        <div class="row">

            <div class="col-lg-4 col-md-6 col-sm-6 col-12 p-0">
                <input type="search" class="form-control search-slt search-select" name="s_name" id="s_name" placeholder="กรอกคำค้น" value="<?php echo $s_name; ?>">
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12 p-0">
                <select name="emp_type_id" id="emp_type_id" class="form-control search-slt search-select ">
                    <option value=""> เลือกประเภท </option>
                    <?php foreach ($emp_type as $key => $value) { ?>
                        <option value="<?php echo $value["PER_TYPE_ID"]; ?>" <?php echo $value["PER_TYPE_ID"] == $emp_type_id ? "selected" : null; ?>> <?php echo $value["PER_TYPE_NAME"]; ?> </option>
                    <?php } ?>
                </select>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12 p-0">
                <select name="org_id" id="org_id" class="form-control search-slt search-select ">
                    <option value=""> ทุกหน่วยงานภายใน </option>
                    <?php foreach ($org_name as $key => $value) { ?>
                        <option value="<?php echo $value["DEP_ID"]; ?>" <?php echo $value["DEP_ID"] == $org_id ? "selected" : null; ?>> <?php echo $value["DEP_NAME"]; ?> </option>
                    <?php } ?>
                </select>
            </div>

            <div class="col-lg-2 col-md-2 col-sm-12 p-0">
                <button type="button" id="btn_search" class="btn  wrn-btn Gradient-Color text-white">ค้นหา</button>
            </div>

        </div>

        <br>

        <div class="flex-row row_sm">
            <?php foreach($datatype as $key => $value){ ?>
            <div class="p-2 d-flex">
                <img class="symbolgrov" src="<?php echo SSO_PATH ."attach/w26/".$value["FILE_SAVE_NAME"] ?>" alt="img"><span class="ml-1"><?php echo $value["PER_TYPE_NAME"];?></span>
            </div>
            <?php }?>
            <!-- <div class="p-2">
                <img class="symbolgrov" src="images/employGov.png" alt="img"><span class="ml-1">พนักงานราชการ</span>
            </div>
            <div class="p-2">
                <img class="symbolgrov" src="images/employee.png" alt="img"><span class="ml-1">ลูกจ้าง ฯ</span>
            </div> -->
        </div>
        <hr class="mt-0">

        <div class="row">
            <!-- แบ่งช่องสำหรับกล่อง -->
            <?php
            if (isset($phone_book["data"])) {
                foreach ($phone_book["data"] as $key => $value) {
                    $type = "SELECT * FROM M_PER_TYPE INNER JOIN WF_FILE ON M_PER_TYPE.PER_TYPE_ID=WF_FILE.WFR_ID INNER JOIN USR_MAIN ON  M_PER_TYPE.PER_TYPE_ID = USR_MAIN.USR_OPTION4   WHERE WF_FILE.WF_MAIN_ID = '26' AND  USR_MAIN.USR_OPTION4 = '" . $value["USR_OPTION4"] . "'";
                    $datatype =  dbdpis::getFetch($type);
            ?>

                    <?php
                    $sql_org = "SELECT * FROM USR_DEPARTMENT WHERE DEP_STATUS = 'Y' AND DEP_ID = '" . $value["DEP_ID"] . "'";
                    $org_name = dbdpis::getFetch($sql_org);
                    ?>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12 p-2">
                        <div class="shadow-sm border-ra-15px p-2 bg-gray min-h-phonebook">
                            <div class="row">
                                <!-- รูปภาพ -->
                                <div class="col-lg-3 col-md-3 col-sm-3 col-12">
                                    <!-- <img class="mt-1 ml-1 img-fluid border-ra-15px" src="images/profile.jpg" alt="img"> --> <!-- style="width: 100%; height: 125px;"-->
                                    <img class="mt-1 ml-1 img-fluid border-ra-15px"  src="<?php echo !empty($value["USR_PICTURE"]) ? SSO_PATH ."profile/" . $value["USR_PICTURE"] : "images/user_profile_empty.png"; ?>" alt="img">
                                    <!-- <img class="mt-1 ml-1 img-fluid border-ra-15px" style="width: 132px; height: 85px;" src="../ewt/pic_upload/<?php echo $value["path_image"]; ?>" alt="<?php echo $value["path_image"]; ?>"> -->

                                </div>
                                <!-- Content -->
                                <div class="col-lg-9 col-md-9 col-sm-9 col-12">
                                    <!-- data-target=".bd-example-modal-lg" -->
                                    <a href="#" data-toggle="modal" data-target="#Showdetail<?php echo $value["USR_ID"]; ?>">
                                        <h4 class="h2-color mb-0"><i class="fas fa-user"></i> <span><?php echo $value["USR_FNAME"] . ' ' . $value["USR_LNAME"]; ?></span></h4>
                                        <?php if ($org_name) { ?>
                                            <p class="mb-0"><i class="fas fa-briefcase"></i> <span><?php echo $value["DEP_1"]; ?></span></p>
                                        <?php } ?>
                                        <?php if ($value["USR_TEL_PHONE"]) { ?>
                                            <p class="mb-0"><i class="fas fa-phone"></i> <span><?php echo $value["USR_TEL_PHONE"]; ?></span></p>
                                        <?php } ?>
                                        <?php if ($value["USR_TEL"]) { ?>
                                            <p class="mb-0"><i class="fas fa-phone"></i> <span><?php echo $value["USR_TEL"]; ?></span></p>
                                        <?php } ?>
                                        <?php if ($value["USR_EMAIL"]) { ?>
                                            <p class="mb-0"><i class="fas fa-envelope"></i> <span><?php echo $value["USR_EMAIL"]; ?></span></p>
                                        <?php } ?>
                                    </a>

                                </div>
                                <img class="symbolgrov posi-symbolgrov" src="<?php echo SSO_PATH ."attach/w26/".$datatype["FILE_SAVE_NAME"] ?>" alt="img">
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="Showdetail<?php echo $value["USR_ID"]; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <!--
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                -->
                                <div class="modal-body">
                                    <div class="row d-flex justify-content-center my-4">
                                        <div class="col-lg-2 col-md-4 col-sm-3 col-4">
                                            <img class="symbolgrov posi-symbolgrov-modal  " src="<?php echo SSO_PATH ."attach/w26/".$datatype["FILE_SAVE_NAME"] ?>" alt="img">
                                            <img class="mt-1 ml-1 img-fluid border-ra-15px" src="<?php echo !empty($value["USR_PICTURE"]) ? SSO_PATH . "profile/" . $value["USR_PICTURE"] : "images/user_profile_empty.png"; ?>" alt="img">

                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-9 col-8 mt-3">
                                            <h3 class="h2-color mb-2"><i class="fa fa-user"></i> <?php echo $value["USR_FNAME"] . ' ' . $value["USR_LNAME"]; ?> (<?php echo $value["USR_NICKNAME"] ?>)</h3>
                                            <p class="h2-color my-1"><i class="fa fa-envelope"></i><?php echo $value["USR_EMAIL"]; ?></p>
                                            <p class="h2-color my-1"><i class="fa fa-phone"></i> <?php echo $value["USR_TEL_PHONE"]; ?></p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row d-flex justify-content-center border-b-phonebook">
                                        <div class="col-lg-4 col-md-6 col-sm-12 col-12 py-2">
                                            <h4>ชื่อ(ภาษาไทย)</h4>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 py-2">
                                            <p><?php echo $value["USR_FNAME"] ?></p>
                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-center border-b-phonebook">
                                        <div class="col-lg-4 col-md-6 col-sm-12 col-12 py-2">
                                            <h4>นามสุกล(ภาษาไทย)</h4>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 py-2">
                                            <p><?php echo $value["USR_LNAME"] ?></p>
                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-center border-b-phonebook">
                                        <div class="col-lg-4 col-md-6 col-sm-12 col-12 py-2">
                                            <h4>ชื่อ(ภาษาอังกฤษ)</h4>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 py-2 ">
                                            <p><?php echo $value["USR_FNAME_EN"] ?></p>
                                            
                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-center border-b-phonebook">

                                        <div class="col-lg-4 col-md-6 col-sm-12 col-12 py-2">
                                            <h4>นามสุกล(ภาษาอังกฤษ)</h4>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 py-2">
                                            <p><?php echo $value["USR_LNAME_EN"] ?></p>
                                            
                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-center border-b-phonebook">

                                        <div class="col-lg-4 col-md-6 col-sm-12 col-12 py-2">
                                            <h4>ชื่อเล่น</h4>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 py-2">
                                            <p><?php echo $value["USR_NICKNAME"] ?></p>
                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-center border-b-phonebook">
                                        <div class="col-lg-4 col-md-6 col-sm-12 col-12 py-2">
                                            <h4>ตำแหน่งในสายงาน</h4>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 py-2">
                                            <p><?php echo $value["POS_NAME"]; ?></p>
                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-center border-b-phonebook">
                                        <div class="col-lg-4 col-md-6 col-sm-12 col-12 py-2">
                                            <h4>ระดับตำแหน่ง</h4>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 py-2">
                                            <p><?php echo $value["POS_LEVEL_NAME"]; ?></p>
                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-center border-b-phonebook">
                                        <div class="col-lg-4 col-md-6 col-sm-12 col-12 py-2">
                                            <h4>สังกัด</h4>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 py-2">
                                            <p><?php echo $value["DEP_1"]; ?></p>
                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-center border-b-phonebook">
                                        <div class="col-lg-4 col-md-6 col-sm-12 col-12 py-2">
                                            <h4>หน่วยงานที่ปฏิบัติงานจริง</h4>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 py-2">
                                            <p><?php echo $value["DEP_2"]; ?></p>
                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-center border-b-phonebook">
                                        <div class="col-lg-4 col-md-6 col-sm-12 col-12 py-2">
                                            <h4>หมายเลขโทรศัพท์</h4>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 py-2">
                                            <p><?php echo $value["USR_TEL"]; ?></p>
                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-center border-b-phonebook">

                                        <div class="col-lg-4 col-md-6 col-sm-12 col-12 py-2">
                                            <h4>หมายเลขโทรสาร</h4>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 py-2">
                                            <p><?php echo $value["USR_TEL_FAX"]; ?></p>
                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-center border-b-phonebook">
                                        <div class="col-lg-4 col-md-6 col-sm-12 col-12 py-2">
                                            <h4>หมายเลขมือถือ</h4>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 py-2">
                                            <p><?php echo $value["USR_TEL_PHONE"]; ?></p>
                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-center border-b-phonebook">
                                        <div class="col-lg-4 col-md-6 col-sm-12 col-12 py-2">
                                            <h4>Email :</h4>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 py-2">
                                            <p><?php echo $value["USR_EMAIL"]; ?></p>
                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-center border-b-phonebook">
                                        <div class="col-lg-4 col-md-6 col-sm-12 col-12 py-2">
                                            <h4>ไอดีไลน์ :</h4>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 py-2">
                                            <p><?php echo $value["USR_LINE_ID"]; ?></p>
                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-center border-b-phonebook">
                                        <div class="col-lg-4 col-md-6 col-sm-12 col-12 py-2">
                                            <h4>ที่อยู่</h4>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 py-2">
                                            <p><?php echo $value["USR_ADDRESS"]; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php }
            } else {
                echo "ไม่มีข้อมูล";
            }
            ?>
        </div>
      
    </div>
    <?php
    echo pagination_ewt('phone_book.php', 's_name=' . $s_name . '&emp_type_id=' . $emp_type_id . '&org_id=' . $org_id . '', $page, $per_page_contact, $phone_book["countAll"]);
    ?>

    <!-- <div class="d-flex justify-content-center mb-2">
            <nav aria-label="...">
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link"><i class="fa-solid fa-caret-left icon_fa_left"></i></a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item active" aria-current="page">
                        <a class="page-link" href="#">2</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#"><i class="fa-solid fa-caret-right icon_fa_right"></i></a>
                    </li>
                </ul>
            </nav>
        </div> -->
</div>
</div>

<!-- modal -->
<!-- Large modal -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="container">

                <div class="row d-flex justify-content-center my-4">
                    <div class="col-lg-2 col-md-4 col-sm-3 col-4">
                        <img class="symbolgrov posi-symbolgrov-modal" src="images/Grovern.png" alt="img">
                        <p id="list_webb_pic">
                            <img class="mt-1 ml-1 img-fluid border-ra-15px" src="images/user_profile_empty.png" alt="img">
                        </p>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-9 col-8 mt-3">
                        <h3 class="h2-color mb-2" id="list_name"><i class="fas fa-user"></i>-</h3>
                        <p class="h2-color my-1" id="list_email"><i class="fas fa-envelope"></i>-</p>
                        <p class="h2-color my-1" id="list_tel"><i class="fas fa-phone"></i>-</p>
                    </div>
                </div>

                <hr>

                <div class="row d-flex justify-content-center my-3 px-3">
                    <div class="col-lg-5 col-md-6 col-sm-12 col-12 py-0">
                        <h4>ชื่อ(ภาษาไทย)</h4>
                    </div>
                    <div class="col-lg-5 col-md-6 col-sm-12 col-12 py-0">
                        <p id="list_name_t">-</p>
                    </div>
                    <div class="col-lg-5 col-md-6 col-sm-12 col-12 py-0">
                        <h4>นามสกุล(ภาษาไทย)</h4>
                    </div>
                    <div class="col-lg-5 col-md-6 col-sm-12 col-12 py-0">
                        <p id="list_surname">-</p>
                    </div>
                    <div class="col-lg-5 col-md-6 col-sm-12 col-12 py-0">
                        <h4>ชื่อ(ภาษาอังกฤษ)</h4>
                    </div>
                    <div class="col-lg-5 col-md-6 col-sm-12 col-12 py-0">
                        <p id="list_name_e">-</p>
                    </div>
                    <div class="col-lg-5 col-md-6 col-sm-12 col-12 py-0">
                        <h4>นามสกุล(ภาษาอังกฤษ)</h4>
                    </div>
                    <div class="col-lg-5 col-md-6 col-sm-12 col-12 py-0">
                        <p id="list_surname_e">-</p>
                    </div>
                    <div class="col-lg-5 col-md-6 col-sm-12 col-12 py-0">
                        <h4>ชื่อเล่น</h4>
                    </div>
                    <div class="col-lg-5 col-md-6 col-sm-12 col-12 py-0">
                        <p id="list_nickname">-</p>
                    </div>
                    <div class="col-lg-5 col-md-6 col-sm-12 col-12 py-0">
                        <h4>ตำแหน่งในการบริหารงาน</h4>
                    </div>
                    <div class="col-lg-5 col-md-6 col-sm-12 col-12 py-0">
                        <p id="list_pos_name">-</p>
                    </div>
                    <div class="col-lg-5 col-md-6 col-sm-12 col-12 py-0">
                        <h4>ตำแหน่งในสายงาน</h4>
                    </div>
                    <div class="col-lg-5 col-md-6 col-sm-12 col-12 py-0 ">
                        <p id="list_position_person">-</p>
                    </div>
                    <div class="col-lg-5 col-md-6 col-sm-12 col-12 py-0">
                        <h4>ระดับตำแหน่ง</h4>
                    </div>
                    <div class="col-lg-5 col-md-6 col-sm-12 col-12 py-0">
                        <p id="list_level_name">-</p>
                    </div>
                    <div class="col-lg-5 col-md-6 col-sm-12 col-12 py-0">
                        <h4>สังกัด</h4>
                    </div>
                    <div class="col-lg-5 col-md-6 col-sm-12 col-12 py-0">
                        <p id="list_afft_name">-</p>
                    </div>
                    <div class="col-lg-5 col-md-6 col-sm-12 col-12 py-0">
                        <h4>หน่วยงานที่ปฏิบัติงานจริง</h4>
                    </div>
                    <div class="col-lg-5 col-md-6 col-sm-12 col-12 py-0">
                        <p id="list_name_org">-</p>
                    </div>
                    <div class="col-lg-5 col-md-6 col-sm-12 col-12 py-0">
                        <h4>หมายเลขโทรศัพท์</h4>
                    </div>
                    <div class="col-lg-5 col-md-6 col-sm-12 col-12 py-0">
                        <p id="list_tel_in">-</p>
                    </div>
                    <div class="col-lg-5 col-md-6 col-sm-12 col-12 py-0">
                        <h4>หมายเลขโทรสาร</h4>
                    </div>
                    <div class="col-lg-5 col-md-6 col-sm-12 col-12 py-0">
                        <p id="list_tel_convenient">-</p>
                    </div>
                    <div class="col-lg-5 col-md-6 col-sm-12 col-12 py-0">
                        <h4>หมายเลขมือถือ</h4>
                    </div>
                    <div class="col-lg-5 col-md-6 col-sm-12 col-12 py-0">
                        <p id="list_mobile">-</p>
                    </div>
                    <div class="col-lg-5 col-md-6 col-sm-12 col-12 py-0">
                        <h4>EMAIL</h4>
                    </div>
                    <div class="col-lg-5 col-md-6 col-sm-12 col-12 py-0">
                        <p id="list_email_person">-</p>
                    </div>
                </div>



                <div class="row d-flex justify-content-center my-3 px-3">
                    <div class="col-lg-5 col-md-6 col-sm-12 col-12 py-0">
                        <h4>ไอดีไลน์</h4>
                    </div>
                    <div class="col-lg-5 col-md-6 col-sm-12 col-12 py-0">
                        <p id="list_line_id">-</p>
                    </div>
                    <div class="col-lg-5 col-md-6 col-sm-12 col-12 py-0">
                        <h4>ที่อยู่</h4>
                    </div>
                    <div class="col-lg-5 col-md-6 col-sm-12 col-12 py-0 ">
                        <p id="list_officeaddress">-</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $("#btn_search").click(function() {

        window.location.href = 'phone_book.php?' +
            's_name=' + $('#s_name').val() +
            '&emp_type_id=' + $('#emp_type_id').val() +
            '&org_id=' + $("#org_id").val();
    });

    function setModaldata(table, select, where, table_join, where_id, type) {
        $.ajax({
            type: 'POST',
            url: 'component/modal.php',
            data: {
                table: table,
                select: select,
                where: where,
                table_join: table_join,
                where_id: where_id,
                type: type
            },
            datatype: "text",
            success: function(data) {
                let object = JSON.parse(data, true);
                //console.log(object);
                if (object.status == "success") {
                    if (object.arrayData.path_image !== null) {
                        $('#list_webb_pic').html('<img class="mt-1 ml-1 img-fluid border-ra-15px" src="./ewtadmin/ewt/pic_upload/' + object.arrayData.path_image + '" alt="img">');
                    }

                    if (object.arrayData.name_thai !== null) {
                        $('#list_name').html('<i class="fas fa-user"></i> ' + object.arrayData.name_thai + ' ' + object.arrayData.surname_thai);
                    }

                    if (object.arrayData.email_person !== null) {
                        $('#list_email').html('<i class="fas fa-envelope"></i> ' + object.arrayData.email_person);
                    }

                    if (object.arrayData.mobile !== null) {
                        $('#list_tel').html('<i class="fas fa-phone"></i> ' + object.arrayData.mobile);
                    }
                    if (object.arrayData.name_thai !== null) {
                        $('#list_name_t').text(object.arrayData.name_thai);
                    }
                    if (object.arrayData.surname_thai !== null) {
                        $('#list_surname').text(object.arrayData.surname_thai);
                    }
                    if (object.arrayData.name_eng !== null) {
                        $('#list_name_e').text(object.arrayData.name_eng);
                    }
                    if (object.arrayData.surname_eng !== null) {
                        $('#list_surname_e').text(object.arrayData.surname_eng);
                    }
                    if (object.arrayData.nickname_thai !== null) {
                        $('#list_nickname').text(object.arrayData.nickname_thai);
                    }
                    if (object.arrayData.pos_name !== null) {
                        $('#list_pos_name').text(object.arrayData.pos_name);
                    }
                    if (object.arrayData.email_person !== null) {
                        $('#list_email_person').text(object.arrayData.email_person);
                    }

                    if (object.arrayData.position_person !== null) {
                        $('#list_position_person').text(object.arrayData.position_person);
                    }
                    if (object.arrayData.tel_in !== null) {
                        $('#list_tel_in').text(object.arrayData.tel_in);
                    }

                    if (object.arrayData.tel_convenient !== null) {
                        $('#list_tel_convenient').text(object.arrayData.tel_convenient);
                    }

                    if (object.arrayData.mobile !== null) {
                        $('#list_mobile').text(object.arrayData.mobile);
                    }

                    if (object.arrayData.level_name !== null) {
                        $('#list_level_name').text(object.arrayData.level_name);
                    }

                    if (object.arrayData.afft_name !== null) {
                        $('#list_afft_name').text(object.arrayData.afft_name);
                    }

                    if (object.arrayData.name_org !== null) {
                        $('#list_name_org').text(object.arrayData.name_org);
                    }

                    if (object.arrayData.line_id !== null) {
                        $('#list_line_id').text(object.arrayData.line_id);
                    }

                    if (object.arrayData.officeaddress !== null) {
                        $('#list_officeaddress').text(object.arrayData.officeaddress);
                    }
                }
            },
            error: function() {
                console.log('Error');
            }
        });
    }
</script>

<?php include('footer.php'); ?>
<!-- Footer Website -->
<?php include('combottom.php'); ?>
<!-- Include file js and properties -->