<?php $menu_footer_t3 = menu::getMenuFooter3($template_management["site_sitemap"]); ?>

<style>
    .bg-footer {
        background-color: <?php echo !empty($template_management["site_footer"]) ? $template_management["site_footer"] : '#525252'; ?>;
    }
</style>

<footer class="py-4 border-top bg-footer txt-white">
    <div class="container">
        <div class="row mr-0 ml-0">
            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="font25px mb-3"> ข้อมูลติดต่อ </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <ul class="list-unstyled text-small">
                            <li> <?php echo $template_management['site_address']; ?> </li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12  col-md-6">
                        <ul class="list-unstyled text-small">
                            <li> โทรศัพท์ : <a class="text-muted" href="#"><?php echo $template_management['site_tel']; ?></a></li>
                            <li> โทรสาร : <a class="text-muted" href="#"><?php echo $template_management['site_fax']; ?></a></li>
                            <li> อีเมล : <a class="text-muted" href="#"><?php echo $template_management['site_email']; ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="col-12">
                    <div class="font25px mb-3"> แผนผังเว็บไซต์ </div>
                    <div class="row">
                        <!-- วนลูปโค้ดนี้แต่ละอันที่ดึง -->
                        <?php echo $menu_footer_t3; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<div class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-6 txt-color-purple">
                <img src="images/logo_intranet.png" title="images/logo_intranet.png" alt="images/logo_intranet.png" class="max-width-logo-footer dis-inline mr-4">
            </div>
            <div class="col-6">
                    <p class="txt-color-purple m-0 mt-3">ลิขสิทธิ์ DIP Portal</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-12 txt-color-purple">
                <div class="float-left mt-3 mr-5" id="list_count_user"> จำนวนผู้เข้าชม : <?php echo visitor::getVisitor(); ?> </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-12 txt-color-purple">
                <div class="float-left mt-3"> จำนวน Online : <?php echo visitor::getVisitorOnline()["count"]; ?> </div>
            </div>
        </div>
    </div>
</div>




