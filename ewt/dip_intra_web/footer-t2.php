<?php $menu_footer_t2 = menu::getMenuFooter2($template_management["site_sitemap"]); ?>

<style>
	.bg-footer2 {
		background-color: <?php echo !empty($template_management["site_footer"]) ? $template_management["site_footer"] : '#05408c'; ?>;
	}
</style>

<footer class="py-4 border-top bg-footer2 txt-white">
	<div class="container">
		<div class="row mr-0 ml-0">
			<div class="col-lg-6 col-md-6 col-sm-12 col-12">
				<div class="row">
					<div class="col-12">
						<div class="font25px mb-3"> ข้อมูลติดต่อ </div>
					</div>
					<div class="col-6 col-md">
						<ul class="list-unstyled text-small">
							<li> <?php echo $template_management['site_address']; ?> </li>
						</ul>
					</div>
					<div class="col-6 col-md">
						<ul class="list-unstyled text-small">
							<li>โทรศัพท์&nbsp;:&nbsp;<a class="text-muted" href="tel:<?php echo $template_management['site_tel']; ?>"><?php echo $template_management['site_tel']; ?></a></li>
							<li>โทรสาร&nbsp;:&nbsp;<a class="text-muted" href="tel:<?php echo $template_management['site_fax']; ?>"><?php echo $template_management['site_fax']; ?></a></li>
							<li>อีเมล&nbsp;:&nbsp;<a class="text-muted" href="mailto:<?php echo $template_management['site_email']; ?>"><?php echo $template_management['site_email']; ?></a></li>
						</ul>
					</div>
				</div>
			</div>

			<div class="col-lg-6 col-md-6 col-sm-12 col-12">
				<div class="col-12">
					<div class="font25px mb-3"> แผนผังเว็บไซต์ </div>
					<div class="row">
						<!-- วนลูปโค้ดนี้แต่ละอันที่ดึง -->
						<?php echo $menu_footer_t2; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>
<div class="container-fluid">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-12 col-12 txt-color-purple">
				<img src="images/logo_intranet.png" title="images/logo_intranet.png" alt="images/logo_intranet.png" class="max-width-logo-footer dis-inline mr-4">
				ลิขสิทธิ์ กรมประชาสัมพันธ์
			</div>
			<div class="col-lg-6 col-md-6 col-sm-12 col-12 txt-color-purple">
				<div class="float-left mt-3 mr-5"> จำนวนผู้เข้าชม : <?php echo visitor::getVisitor(); ?> </div>
				<div class="float-left mt-3"> จำนวน Online : <?php echo visitor::getVisitorOnline()["count"]; ?> </div>
			</div>
		</div>
	</div>
</div>