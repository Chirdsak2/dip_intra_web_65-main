<!-- Open Top -->
<?php include('comtop.php'); ?>
<?php 
$menu_view3 = menu::genMenuView3($template_management["site_mainmenu"], $template_id); ?>
<style>
  .dropdown-menu {
    left: -170px;
  }

  .left_dropdown a {
    color: #82288c;
  }
</style>
<div class="container-fluid pl-0 pr-0 fixed-top">

  <nav class="navbar navbar-expand-lg navbar-light bg-white py-0">
    <div class="container">
      <a class="navbar-brand pb-2" href="index.php">
        <img src="images/logo_intranet.png" title="images/logo_intranet.png" alt="images/logo_intranet.png" class="max-width-logo">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <?php echo $menu_view3; ?>

        <ul class="navbar-nav">
          <li class="nav-item dropdown margin_navbar ml-2">
            <a class="nav-link dropdown-toggle a-black-link p-0 " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <img src="<?php echo $webb_image; ?>" class="pic-user rounded">
            </a>
            <div class="dropdown-menu left_dropdown" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="profile.php"> <i class="fas fa-user"></i> ข้อมูลผู้ใช้งาน </a>
              <a class="dropdown-item" href="tenure_information.php"> <i class="fas fa-briefcase"></i> ข้อมูลการดำรงตำแหน่ง </a>
              <a class="dropdown-item" href="private_floder.php"> <i class="fas fa-folder-open"></i> แฟ้นส่วนตัว </a>
              <a class="dropdown-item" href="Booking_status.php"> <i class="fas fa-check-square"></i> สถานะคำขอ </a>
              <a class="dropdown-item" href="logout.php"> <i class="fas fa-sign-out-alt"></i> ออกจากระบบ </a>
            </div>
          </li>
        </ul>
        <!-- <a href="logout.php">
                    <div class="text-center">
                        <img src="assets/img/icon_logout.png" alt="alert" title="alert" style="width:25px; margin-left: 20px;">
                    </div>
                </a> -->
      </div>
    </div>
  </nav>
</div>

<?php include 'popup-contact.php'; ?>

<?php 
$search_title_list = main::getTitleTag();
$search_tag = main::getTagSearch($start_search, $per_page_search, $s_search, $date_start, $date_end, $search_type);
//$total_page_search = ceil($search_tag["countAll"] / $per_page_search);
$search_hashtag = main::getTagList($search_type);
?>

<!-- Style CSS Template 3 -->
<link rel="stylesheet" href="assets/css/article.css">
<link rel="stylesheet" href="assets/css/search.css">

<style>
    .chk_img img {
        display: none;
    }
</style>

<div class="container-fluid mt-3 header--bg">
    <div class="container py-5 text-center">
        <h3>ค้นหา</h3>
        <small>การคำค้นด้วย: คำค้น,ชื่อเรื่อง, รายละเอียด</small>
    </div>
</div>

<section class="search-sec">
    <div class="container">
        <form action="#" method="post" novalidate="novalidate">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12 p-0">
                            <input type="search" class="form-control search-slt" name="s_search" id="s_search" placeholder="กรอกคำค้น" list="datalistOptions" onclick="clearText('s_search');" value="<?php echo $s_search; ?>">
                            <datalist id="datalistOptions">
                                <?php foreach ($search_hashtag as $value) { ?>
                                    <option value="<?php echo $value["search_word"]; ?>">
                                        <?php echo $value["search_word"]; ?>
                                    </option>
                                <?php } ?>
                            </datalist>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12 p-0">
                            <!-- <input type="text" name="date_start" id="date_start" placeholder="วันเริ่มต้น" class="search-sltc" onfocus="(this.type='date')" onblur="(this.type='text')" value="<?php echo $date_start; ?>" /> -->
                            <input type="date" name="date_start" id="date_start" placeholder="วันเริ่มต้น" class="form-control search-sltc" onclick="clearText('date_start');" value="<?php echo $date_start; ?>" />
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12 p-0">
                            <!-- <input type="text" name="date_end" id="date_end" placeholder="วันสิ้นสุด" class="search-sltc" onfocus="(this.type='date')" onblur="(this.type='text')" value="<?php echo $date_end; ?>" /> -->
                            <input type="date" name="date_end" id="date_end" placeholder="วันสิ้นสุด" class="form-control search-sltc" onclick="clearText('date_end');" value="<?php echo $date_end; ?>" />
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12 p-0">
                            <select class="form-control search-slt search-select" name="search_type" id="search_type">
                                <?php foreach ($search_title_list as $key => $title) { ?>
                                    <option value="<?php echo $key; ?>" <?php echo $key == $search_type ? "selected" : null ?>>
                                        <?php echo $title; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-lg-2 col-md-2 col-sm-12 p-0">
                            <button type="button" name="btn_search" id="btn_search" class="btn btn--search wrn-btn">ค้นหา</button>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        10 คำค้นหายอดนิยม:<br>
                        <?php foreach ($search_hashtag as $value) { ?>
                            <span class="badge badge-search">
                                <a href="search.php?s_search=<?php echo $value["search_word"]; ?>&search_type=<?php echo $search_type; ?>" title="<?php echo $value["search_word"]; ?>">
                                    <?php echo $value["search_word"]; ?>
                                </a>
                            </span>
                        <?php } ?>
                    </div>
                    <?php if(!empty($s_search) || !empty($date_start) || !empty($date_end)){?>
                        <div class="text-center mt-5">
                            ผลการค้นหา <?php echo '"'.$s_search.'"' . ' พบทั้งหมด ' . $search_tag['countAll']; ?> รายการ
                        </div>
                    <?php } ?>
                </div>
            </div>
        </form>
    </div>
</section>

<div class="container-fluid">
    <div class="container">
        <?php foreach ($search_tag["data"] as $value) { ?>
            <div class="block-search">
                <h6>
                    <a href="<?php echo $value["link"]; ?>" target="_blank">
                        <?php echo $value['title']; ?>
                    </a>
                </h6>

                <!-- <small>
                    <a href="<?php echo $value["link"]; ?>" title="<?php echo $value["link"]; ?>" target="_blank">
                        <?php echo $value["link"]; ?>
                    </a>
                </small> -->

                <!-- <?php echo !empty($value['title']) ? "<hr>" : null; ?> -->

                <p class="<?php echo ($search_type == 3 ? "d-flex" : null); ?>">
                    <?php echo $value['detail']; ?>
                </p>

                <!-- <?php echo !empty($value['detail']) ? "<hr>" : null; ?> -->

                <?php echo $value['group']; ?>

                <!-- <?php echo !empty($value['tag']) ? "<hr>" : null; ?> -->

                <!-- <p><?php echo $value["tag"]; ?></p> -->
            </div>
        <?php } ?>

        <!-- Start แสดงการตัดหน้าเพจ -->
        <!-- <?//php echo pagination('search.php', 's_search=' . $s_search . '&date_start=' . $date_start . '&date_end=' . $date_end . '&search_type=' . $search_type . '', $page, $per_page_search, $search_tag["countAll"]); ?> -->
        <?php echo pagination_ewt('search.php', 's_search=' . $s_search . '&date_start=' . $date_start . '&date_end=' . $date_end . '&search_type=' . $search_type . '', $page, $per_page_search, $search_tag["countAll"]); ?>
        <!-- End แสดงการตัดหน้าเพจ-->
    </div>
</div>

<!-- เคลียร์ค่าช่องค้นหา -->
<script>
    function clearText(text){
        $('#' + text).val('');
    }
</script>

<!-- ค้นหาด้วยการคลิกปุ่มแสดงรายการที่ค้นหา ที่กล่องข้อมูล -->
<script type="text/javascript">
    $("#btn_search").click(function() {
        let current_type = <?php echo $search_type; ?>;
        // if (current_type != $('#search_type').val()) {
        //     window.location.href = 'search.php?search_type=' + $('#search_type').val();
        // } else {
            window.location.href = 'search.php?s_search=' + $('#s_search').val() +
                '&date_start=' + $('#date_start').val() +
                '&date_end=' + $('#date_end').val() +
                '&search_type=' + $('#search_type').val()
        //}
    });
</script>
<?php include('footer.php'); ?>
<?php include('combottom.php'); ?>