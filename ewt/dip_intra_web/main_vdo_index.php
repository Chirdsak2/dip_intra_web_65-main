<?php 
$vdo_group = vdo::getVdoGroup('1')["data"];
$vdo_list = vdo::getVdoList(null, "1", null)["dataAll"];
// echo "<pre>";
// print_r($vdo_list);
// echo "</pre>";
// exit();
?>
<!-- ******************************************* Open Zone Content Demo ********************************************* -->

<!---------------------- Zone วิดีโอแนะนำ  ------------------------------>
<style>
    @media (min-width: 320px) {
        .box_vdo{
            height: auto;
        }
     }

</style>
<div class="container mt-2 mb-1">
    <div class="row">
        <div class="col-xl-10 col-lg-10 col-md-8 col-sm-12 col-12">
            <div class="row">
                <div class="col-xl-1 col-lg-1 col-md-2 col-sm-2 col-2">
                    <img class="img-fluid" src="images/2play.png" alt="">
                </div>
                <div class="col-xl-11 col-lg-11 col-md-10 col-sm-10 col-10">
                    <h2 class="text_h_new">วีดีโอแนะนำ</h2>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-lg-2 col-md-4 col-sm-12 col-12 ">
            <a href="more_vdo.php?id=1" type="button" class="btn-search btn Gradient-Color  btn-sm mt-2 mb-3 w-100"> ดูเพิ่มเติม</a>
        </div>
    </div>
    <div class="row">
        <?php foreach ($vdo_list as $key => $value) { ?>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="shadow-sm  mt-2 mb-2 bg-whtie rounded box_vdo">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="embed-responsive embed-responsive-16by9">
                                <?php
                                if ($value['vdo_filename'] != "") {
                                    $type = "mp4";
                                } else {
                                    $type = "youtube";
                                }

                                $vdo_fileyoutube = str_replace('https://www.youtube.com/watch?v=', '', $value['vdo_fileyoutube']);

                                if ($value['vdo_filename'] != "") {
                                    echo "<video class=\"embed-responsive-item\" onclick=\"Func_Vdocount(" . $value["vdo_id"] . ")\" data-vdo=\"" . $value["vdo_id"] . "\" id=\"vplayer\" src=\"download/file_vdo/" . $value['vdo_filename'] . "\" poster=\"download/file_vdo/" . $value['vdo_image'] . "\"  type=\"video/mp4\" controls=\"controls\" preload=\"none\"></video>";
                                } else {
                                    echo "<iframe class=\"embed-responsive-item\" onclick=\"Func_Vdocount(" . $value["vdo_id"] . ")\"  data-vdo=\"" . $value["vdo_id"] . "\"  allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" src=\"https://www.youtube.com/embed/" . $vdo_fileyoutube . "\" 
                                    allowfullscreen></iframe>";
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <div class="p-3">
                                <a href="#">
                                    <h4><?php echo substr($val['vdo_name'],6); ?><?php echo $value["vdo_name"]; ?></h4>
                                </a>
                            </div>
                        </div>
                    </div>
                    <hr class="hr_news">
                </div>
            </div>
        <?php } ?>

        <!-- <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
            <div class="shadow-sm  mt-2 mb-2 bg-whtie rounded">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="embed-responsive embed-responsive-4by3">
                            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/tr6uGU9U3aY"></iframe>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="p-3">
                            <a href="#">
                                <h4>การปฏิบัติราชการให้สอดคล้องกับ PDPA l 17 มิ.ย. 65</h4>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
            <div class="shadow-sm  mt-2 mb-2 bg-whtie rounded">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="embed-responsive embed-responsive-4by3">
                            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/jNawX0uzrZ0"></iframe>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="p-3">
                            <a href="#">
                                <h4> แนะนำระบบโครงสร้าง กสอ. </h4>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
            <div class="shadow-sm  mt-2 mb-2 bg-whtie rounded">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="embed-responsive embed-responsive-4by3">
                            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/Z8xvDAkJ7fs"></iframe>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="p-3">
                            <a href="#">
                                <h4>1 ก.ค. 63 [EP 1/3] แนวทางการปฏิบัติราชการที่ดีเพื่อลดความเสี่ยงในการปฏิบัติงาน</h4>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
</div>

<?php include('component/vdo_count.php'); ?>
<!-- Close Zone Content Demo -->