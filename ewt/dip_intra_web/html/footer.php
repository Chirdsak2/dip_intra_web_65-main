<footer class="mt-5 py-4 border-top bg-footer txt-white">
    <div class="container">
        <div class="row mr-0 ml-0">
            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="font25px mb-3"> ข้อมูลติดต่อ </div>
                    </div>
                    <div class="col-6 col-md">
                        <ul class="list-unstyled text-small">
							<li> <?php echo $contact_inform['site_address']; ?> </li>
                            <!-- <li> กรมประชาสัมพันธ์ </li>
                            <li> เลขที่ 9 ซ.อารีย์สัมพันธ์ ถ.พระราม 6 </li>
                            <li> แขวงพญาไท เขตพญาไท กรุงเทพฯ 10400 </li> -->
                        </ul>
                    </div>
                    <div class="col-6 col-md">
                        <ul class="list-unstyled text-small">
						<li> โทรศัพท์ : <a class="text-muted" href="#"><?php echo $contact_inform['site_tel']; ?></a></li>
                            <li> โทรสาร : <a class="text-muted" href="#"> <?php echo $contact_inform['site_fax']; ?></a></li>
                            <li> อีเมล : <a class="text-muted" href="#"><?php echo $contact_inform['site_email']; ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="font25px mb-3"> แผนผังเว็บไซต์ </div>
                    </div>

					<?php echo $menu_footer; ?>

                </div>
            </div>
            
        </div>
    </div>
</footer>
<div class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-12 txt-color-purple">
                <img src="assets/img/logo_intranet.png" title="logo" alt="logo"
                    class="max-width-logo-footer dis-inline mr-4">
                ลิขสิทธิ์ กรมประชาสัมพันธ์
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-12 txt-color-purple">
                <div class="float-left mt-3 mr-5"> จำนวนผู้เข้าชม : 2,125,465 </div>
                <div class="float-left mt-3"> จำนวน Online : 3 </div>
            </div>
        </div>
    </div>
</div>