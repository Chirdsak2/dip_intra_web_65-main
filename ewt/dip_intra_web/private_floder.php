<?php include('comtop.php'); ?>
<!-- Include file css and properties -->
<?php include('header.php'); ?>

<?php
$s_nid_array = array();
// $sql_a = "select n_id,fav_id from " . E_DB_NAME . ".article_favorite_log where fav_userid = {$_SESSION['EWT_MID']}";
// $result_a = db::getFetchAll($sql_a);
// $favid = $result_a["fav_id"];

// foreach ($result_a as $value) {
//     array_push($s_nid_array, $value['n_id']);
// }

// $date_now = date("Y-m-d");
// $s_nid = implode(",", array_unique($s_nid_array));

// $wh = "";
// if ($s_nid) {
//     $wh = " AND n_id IN ($s_nid)";
// }


$_sql = "SELECT a.*, b.fav_id,c.* FROM " . E_DB_NAME . ".article_list a
    INNER JOIN " . E_DB_NAME . ".article_favorite_log b ON (a.n_id = b.n_id) 
    INNER JOIN " . E_DB_NAME . ".article_group c ON (a.c_id = c.c_id)
    WHERE a.n_approve = 'Y' 
    AND b.fav_userid = {$_SESSION['EWT_MID']}
    ORDER BY a.n_date DESC, a.n_timestamp DESC 
    LIMIT {$start},{$per_page}";

$a_row = db::getRowCount($_sql);
$a_data = db::getFetchAll($_sql);

//นับจำนวนข่าวทั้งหมด
$_sql_all = "SELECT a.n_id FROM " . E_DB_NAME . ".article_list a
INNER JOIN " . E_DB_NAME . ".article_favorite_log b ON (a.n_id = b.n_id) 
INNER JOIN " . E_DB_NAME . ".article_group c ON (a.c_id = c.c_id)
WHERE a.n_approve = 'Y'
AND b.fav_userid = {$_SESSION['EWT_MID']}";

$a_row_all = db::getRowCount($_sql_all);

$total_page = ceil($a_row_all / $per_page);


// if (!empty($_GET['fav_id'])) {
//     $fav_id = $_GET['fav_id'];
//     $del = db::execute("DELETE FROM " . E_DB_NAME . ".article_favorite_log WHERE fav_id = {$fav_id}");
//     if ($del->rowCount()) {
//         echo '<script> alert("Finished Deleting!");</script>';
//         $del->redirect('private_floder.php');
//     } else {
//         echo '<script> alert("No DATA!");</script>';
//         $del->redirect('private_floder.php');
//     }
// }

?>
<!-- Menu and Logo -->
<style>
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
</style>
<div class="container mar-spacehead mb-5">


    <!-- ส่วนของข้อมูลผู้ใช้ -->
    <h2 class="h2-color pt-4">
        <i class="fa fa-folder" aria-hidden="true"></i> แฟ้มส่วนตัว
    </h2>
    <div class="row">
        <div class="col-lg-6 col-md-4 col-sm-12 col-12">
            <h5 class="h2-color mt-2"><a href="profile.php">ข้อมูลผู้ใช้งาน > </a> <span>แฟ้มส่วนตัว</span></h5>
        </div>
    </div>
    <hr class="hr_news mt-0">
    <div class="row">
        <?php 
        if($a_row > 0){
        foreach ($a_data as $k => $val) { ?>
            <?php
            $n_owner = user::chkUser(array("gen_user_id" => $val["n_owner"]))[0];
            $full_name = $n_owner["name_thai"] . ' ' . $n_owner["surname_thai"];
            $fname = $n_owner["name_thai"];
            $lname = $n_owner["surname_thai"];
            $sql_profile = "SELECT * FROM M_PER_PROFILE
            LEFT JOIN USR_MAIN ON M_PER_PROFILE.PER_IDCARD = USR_MAIN.USR_OPTION3
            WHERE
                M_PER_PROFILE.PER_NAME_TH LIKE '%".$fname."%'
            AND M_PER_PROFILE.PER_LASTNAME_TH LIKE '%".$lname."%'
            ";
            $result = dbdpis::getFetch($sql_profile);

            if (!empty($result['USR_PICTURE'])) {
                $path_image = SSO_PATH . "profile/" . $result['USR_PICTURE'];
            } else {
                $path_image = "./assets/img/avatar-2.png";
            }
            $picture = getImage('images/article/news' . $val['n_id'] . '/', $val['picture'], "images/photo1.jpg");
            ?>
            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-4">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-3 col-4  ">
                        <img class="img-fluid img-news-ra shadow" src="<?php echo $picture; ?>" alt="img">
                    </div>
                    <div class="col-lg-9 col-md-8 col-sm-9 col-8 px-0">
                        <div class=" row">
                            
                            <div class="col-lg-7 col-md-6 col-sm-7 col-6">
                                <div class="tag-bg-<?php echo tagBg($key); ?>">
                                    <?php echo $val["c_name"]; ?>
                                </div>
                            </div>
                          
                            <div class="col-lg-5 col-md-6 col-sm-5 col-6 red-txt mb-1">
                                <a href="#" class="btn_delete_purple font13px" onclick="deleteItem(<?php echo $val['fav_id']; ?>);"> <i class="fa fa-trash" aria-hidden="true"></i> <span class="font13px">หยิบออก</span> </a>
                            </div>
                        </div>

                        <a href="<?php echo ($val['news_use'] == 1 ? $val['link_html'] : "news_view.php?n_id=" . $val['n_id'] . " "); ?>" class="txt-header-news mt-1">
                        <?php echo mb_strimwidth($val["n_topic"], 0, 50, '...'); ?>
                        </a>
                        <div class="row">
                            <div class="col-lg-7 col-md-7 col-sm-6 col-6 pr-0  mt-2">
                                <img class="img-fluid img-user-news  " src="<?php echo $path_image; ?>" alt="img"><span class="ml-1"><?php echo $full_name; ?></span>
                            </div>
                            <div class="col-lg-5 col-md-5 col-sm-6 col-6 p-0 mt-2">
                                <i class="fa fa-calendar" aria-hidden="true"></i><span class="ml-1"> <?php echo convDateThai($val['n_date'])['DateTH']; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php }}else{ ?>
            <div class="col">
                <p class="text-center">ยังไม่มีรายการ</p>
            </div>
            <?php }?>

        <!-- <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-4">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-3 col-4  ">
                    <img class="img-fluid img-news-ra shadow" src="images/photo4.jpg" alt="img">
                </div>
                <div class="col-lg-9 col-md-8 col-sm-9 col-8 px-0">
                    <div class=" row">
                        <div class="col-lg-7 col-md-6 col-sm-7 col-6">
                            <div class="tag-bg-PR">
                                ประชาสัมพันธ์
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-6 col-sm-5 col-6 red-txt">
                        <a href="#">  <i class="fa fa-trash" aria-hidden="true"></i> <span>หยิบออก</span> </a> 
                        </div>
                    </div>

                    <a href="#" class="txt-header-news mt-1">
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                    </a>
                    <div class="row">
                        <div class="col-lg-7 col-md-7 col-sm-6 col-6 pr-0  mt-2">
                            <img class="img-fluid img-user-news  " src="images/user.jpg" alt="img"><span class="ml-1">วสุรัตน์ คนหาญ</span>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-6 col-6 p-0 mt-2">
                        <i class="fa fa-calendar" aria-hidden="true"></i><span class="ml-1"> 26 มิ.ย. 65</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-4">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-3 col-4  ">
                    <img class="img-fluid img-news-ra shadow" src="images/photo4.jpg" alt="img">
                </div>
                <div class="col-lg-9 col-md-8 col-sm-9 col-8 px-0">
                    <div class=" row">
                        <div class="col-lg-7 col-md-6 col-sm-7 col-6">
                            <div class="tag-bg-event">
                                กิจกรรม
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-6 col-sm-5 col-6 red-txt">
                             <a href="#">  <i class="fa fa-trash" aria-hidden="true"></i> <span>หยิบออก</span> </a> 
                        </div>
                    </div>

                    <a href="#" class="txt-header-news mt-1">
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                    </a>
                    <div class="row">
                        <div class="col-lg-7 col-md-7 col-sm-6 col-6 pr-0  mt-2">
                            <img class="img-fluid img-user-news  " src="images/user.jpg" alt="img"><span class="ml-1">วสุรัตน์ คนหาญ</span>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-6 col-6 p-0 mt-2">
                        <i class="fa fa-calendar" aria-hidden="true"></i><span class="ml-1"> 26 มิ.ย. 65</span>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    </div>


    <?php echo pagination_ewt2('private_floder.php', '', $page, $per_page, $a_row_all); ?>


    <!-- <div class="d-flex justify-content-center mb-2">
        <nav aria-label="...">
            <ul class="pagination">
                <li class="page-item">
                    <a class="page-link"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item active" aria-current="page">
                    <a class='page-link' href="#">2</a>
                </li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#"><i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                </li>
            </ul>
        </nav>
    </div> -->
</div>




<?php include('footer.php'); ?>


<!-- Footer Website -->
<?php include('combottom.php'); ?>

<!-- Include file js and properties -->
<script>
    function deleteItem(id) {
        if (confirm('Are you sure, you want to delete this item?') == true) {
            window.location = `del_private_floder.php?fav_id=${id}`;
            // window.location = `?fav_id=${id}`;
            // window.location='delete.php?id='+id;

        }
    };
</script>