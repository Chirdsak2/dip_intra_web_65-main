<?php include('comtop.php'); ?>
<?php include('header.php'); ?>
<?php 
$search_title_list = main::getTitleTag();
$search_tag = main::getTagSearch($start_search, $per_page_search, $s_search, $date_start, $date_end, $search_type);
// echo "<pre>";
// print_r($search_tag);
// echo "</pre>";
// exit();
//$total_page_search = ceil($search_tag["countAll"] / $per_page_search);
$search_hashtag = main::getTagList($search_type);
?>

<!-- Style CSS Template 3 -->
<link rel="stylesheet" href="assets/css/article.css">
<link rel="stylesheet" href="assets/css/search.css">

<style>
      .badge-search {
    padding: 5px 15px;
    font-size: 12px;
    border: 1px solid #5b5aa8;
    color: #5b5aa8;
    box-shadow: 0px 0px 20px 2px #cccccc;
    margin-bottom: 10px;
    margin-left: 3px;
    margin-right: 3px;
  }
  
  .badge1 {
    /* display: inline-block; */
    padding: 0.25em 0.4em;
    font-size: 75%;
    font-weight: 700;
    line-height: 1;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: 0.25rem;
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.badge1 {
    /* position: absolute; */
    top: 282px;
    right: 571px;
    /* display: inline-block; */
    width: 16px;
    height: 16px;
    /* border-radius: 50%; */
    /* background-color: #f00202; */
}

.badge1 {
    /* position: absolute; */
    top: 29px;
    right: 408px;
    width: 16px;
    height: 16px;
    color: blue;
}

    .chk_img img {
        display: none;
    }
</style>

<div class="container-fluid mt-3 header--bg">
    <div class="container py-5 text-center">
        <h3 class="article--topic">ค้นหา</h3>
        <small class="article_nvt">การคำค้นด้วย: คำค้น,ชื่อเรื่อง, รายละเอียด</small>
    </div>
</div>

<section class="search-sec">
    <div class="container">
        <form action="#" method="post" novalidate="novalidate">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12 p-0 mt-3 pt-2">
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
                            <p class="p-0 m-0">วันที่เริ่มต้น</p>
                            <input type="date" name="date_start" id="date_start" placeholder="วันเริ่มต้น" class="form-control search-sltc" onclick="clearText('date_start');" value="<?php echo $date_start; ?>" />
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12 p-0">
                            <!-- <input type="text" name="date_end" id="date_end" placeholder="วันสิ้นสุด" class="search-sltc" onfocus="(this.type='date')" onblur="(this.type='text')" value="<?php echo $date_end; ?>" /> -->
                            <p class="p-0 m-0">วันที่สิ้นสุด</p>
                            <input type="date" name="date_end" id="date_end" placeholder="วันสิ้นสุด" class="form-control search-sltc" onclick="clearText('date_end');" value="<?php echo $date_end; ?>" />
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12 p-0 mt-3 pt-2">
                            <select class="form-control search-slt search-select" name="search_type" id="search_type">
                                <?php foreach ($search_title_list as $key => $title) { ?>
                                    <option value="<?php echo $key; ?>" <?php echo $key == $search_type ? "selected" : null ?>>
                                        <?php echo $title; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-lg-2 col-md-2 col-sm-12 p-0 mt-3 pt-2">
                            <button type="button" name="btn_search" id="btn_search" class="btn btn--search wrn-btn">ค้นหา</button>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        10 คำค้นหายอดนิยม:<br>
                        <?php foreach ($search_hashtag as $value) { ?>
                            <span class="badge1 badge-search">
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