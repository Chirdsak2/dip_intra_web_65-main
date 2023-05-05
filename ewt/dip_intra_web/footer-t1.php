 <?php $menu_footer_t1 = menu::getMenuFooter1($template_management["site_sitemap"]); ?>
 <!-- ======= Footer ======= -->
 <style>
 	#footer .footer-top {
 		background: <?php echo !empty($template_management["site_footer"]) ? $template_management["site_footer"] : '#525252'; ?>;
 	}
 </style>
 <footer id="footer">
 	<div class="footer-top">
 		<div class="container">
 			<div class="row">
 				<div class="col-lg-3 col-md-6 footer-contact">
 					<h4> ข้อมูลติดต่อ </h4>
 					<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d123999.1010658716!2d100.46813815820312!3d13.780567000000024!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30e29c027e08b57d%3A0x24beceae1036c2ad!2z4LiB4Lij4Lih4Lib4Lij4Liw4LiK4Liy4Liq4Lix4Lih4Lie4Lix4LiZ4LiY4LmM!5e0!3m2!1sth!2sth!4v1639473596149!5m2!1sth!2sth" height="100" style="width: 100%; border:0;" allowfullscreen="" loading="lazy"></iframe>
 				</div>

 				<div class="col-lg-3 col-md-6 footer-links">
 					<h4> &nbsp; </h4>
 					<ul>
 						<li> <?php echo $template_management['site_address']; ?> </li>
 					</ul>
 				</div>

 				<div class="col-lg-3 col-md-6 footer-links">
 					<h4> &nbsp; </h4>
 					<ul class="list-unstyled text-small">
 						<li>โทรศัพท์&nbsp;:&nbsp;<a href="tel:<?php echo $template_management['site_tel']; ?>"> <?php echo $template_management['site_tel']; ?></a></li>
 						<li>โทรสาร&nbsp;:&nbsp;<a href="tel:<?php echo $template_management['site_fax']; ?>"> <?php echo $template_management['site_fax']; ?></a></li>
 						<li>อีเมล&nbsp;:&nbsp;<a href="mailto:<?php echo $template_management['site_email']; ?>"><?php echo $template_management['site_email']; ?></a></li>
 					</ul>
 				</div>

 				<div class="col-lg-3 col-md-6 footer-links">
 					<h4> แผนผังเว็บไซต์ </h4>
 					<ul>
 						<?php echo $menu_footer_t1; ?>
 					</ul>
 				</div>

 			</div>
 		</div>
 	</div>

 	<div class="container">
 		<div class="copyright">
 			<div class="row">
 				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 txt-left">
 					&copy; ลิขสิทธิ์ กรมประชาสัมพันธ์
 				</div>
 				<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 txt-right">
 					<span> จำนวนผู้เข้าชม : <span class="stat-num1"> <?php echo visitor::getVisitor(); ?> </span> </span>
 					<span class="ms-3"> จำนวน Online : <span class="stat-num2"> <?php echo visitor::getVisitorOnline()["count"]; ?> </span> </span>
 				</div>
 			</div>
 		</div>
 	</div>
 </footer>
 <!-- End Footer -->