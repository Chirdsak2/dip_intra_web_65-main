<?php
include("../EWT_ADMIN/comtop.php");
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);
include("../class/db/dbdpis.class.php");
dbdpis::ConnectDB(SSO_DB_NAME, SSO_DB_TYPE, SSO_ROOT_HOST, SSO_ROOT_USER, SSO_ROOT_PASSWORD, SSO_DB_NAME, SSO_CHAR_SET);


?>
<!-- START CONTAINER  -->
<div class="container-fluid">
	<?php
	include("menu-top.php");
	$db->query("USE " . $EWT_DB_USER);
	?>

	<div class="row m-b-sm">
		<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">
			<!--start card -->
			<div class="card">
				<!--start card-header -->
				<div class="card-header">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">

							<h4><?php echo $txt_org_module; ?></h4>
							<p></p>

						</div>

						<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<ol class="breadcrumb">
									<li><a href="faq_group.php"><?php echo $txt_org_menu_main; ?></a></li>
									<li class=""></li>
								</ol>
							</div>

							<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs">
							</div>

						</div>
					</div>

				</div>
				<!--END card-header -->

				<!--start card-body -->
				<div class="card-body">

					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">

							<div class="" id="frm_edit_s">
								<div id="frm_load">
									<div class="row">
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 m-b-sm">
											<a class="card card-banner card-green-light" onclick="self.location.href='org_list.php'">
												<!--Users Who have initiated at lest one session during the date range.    -->
												<div class="card-body">
													<i class="icon fas fa-users fa-4x"></i>

													<div class="content">
														<div class="title text-dark">
															<h4><?php echo $txt_org_menu_list; ?></h4>
														</div>
														<div class="value"><span class="sign"></span><span class="counter"><?php echo org::getCountUser('1'); ?></span></div>
														<div class="title">
															<h5><?php echo $txt_ewt_list; ?></h5>
														</div>
													</div>
													<div class="content">
														<div class="title">
															<i class="far fa-check-circle text-success"></i>
															<?php echo 'ใช้งาน'; ?> <span class="counter"><span class="sign text-success"> <?php echo org::getCountUser('2'); ?></span></span>
															/
															<i class="far fa-times-circle text-danger"></i>
															<?php echo 'ไม่ใช้งาน'; ?> <span class="counter"><span class="sign text-danger"> <?php echo org::getCountUser('3'); ?></span></span>
														</div>
													</div>
												</div>
											</a>
										</div>
										<!-- <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 m-b-sm">
											<a class="card card-banner card-blue-light" onclick="self.location.href='org_group.php'">
												
												<div class="card-body">
													<i class="icon fas fa-database fa-4x"></i>
													<div class="content">
														<div class="titlev text-dark">
															<h4><?php echo $txt_org_menu_group; ?></h4>
														</div>
														<div class="value"><span class="sign"></span><span class="counter"><?php echo org::getCountOrg('1'); ?></span></div>
														<div class="title">
															<h5><?php echo $txt_ewt_list; ?></h5>
														</div>
													</div>
													<div class="content">
														<div class="title ">
															<i class="far fa-check-circle text-success"></i>
															<?php echo 'ใช้งาน'; ?> <span class="counter"><span class="sign text-success"> <?php echo org::getCountOrg('2'); ?></span></span>
															/
															<i class="far fa-times-circle text-danger"></i>
															<?php echo 'ไม่ใช้งาน'; ?> <span class="counter"><span class="sign text-danger"> <?php echo org::getCountOrg('3'); ?></span></span>
														</div>
													</div>
												</div>
											</a>
										</div>
										<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 m-b-sm">
											<a class="card card-banner card-yellow-light" onclick="self.location.href='org_position.php'">
												
												<div class="card-body">
													<i class="icon far fa-id-card fa-4x"></i>
													<div class="content">
														<div class="title text-dark">
															<h4><?php echo $txt_org_menu_postion; ?></h4>
														</div>
														<div class="value"><span class="sign"></span><span class="counter"><?php echo org::getCountPosition('1'); ?></span></div>
														<div class="title">
															<h5><?php echo $txt_ewt_list; ?></h5>
														</div>
													</div>
													<div class="content">
														<div class="title">
															<i class="far fa-check-circle text-success"></i>
															<?php echo 'ใช้งาน'; ?> <span class="counter"><span class="sign text-success"> <?php echo org::getCountPosition('2'); ?></span></span>
															/
															<i class="far fa-times-circle text-danger"></i>
															<?php echo 'ไม่ใช้งาน'; ?> <span class="counter"><span class="sign text-danger"> <?php echo org::getCountPosition('3'); ?></span></span>
														</div>
													</div>
												</div>
											</a>
										</div> -->
									</div>
									<div class="row">
										<div class="col-gl-12 col-md-12 col-sm-12 col-xs-12 m-b-sm">
											<div class="card ">
												<div class="card-header ewt-bg-color m-b-sm b-t-l-3 b-t-r-3">
													<div class="card-title text-left">
														<div class="title"><i class="fas fa-hashtag"></i> <?php echo $txt_org_latest; ?></div>

													</div>
												</div>
												<div class="card-body" id="tab1">

													<ul class="list-group">
														<?php
														$a_top5 = org::genUserTop5('5');

														foreach ((array)$a_top5 as $_item_top) {
														?>
															<li class="list-group-item "><i class="fas fa-user text-dark "></i> :: <?php echo org::getGenUser($_item_top); ?></li>

														<?php } ?>
													</ul>

													<div class="hi-icon-wrap hi-icon-effect-7 hi-icon-effect-7b  text-right">
														<a href="#View more" class="hi-icon hi-icon-list text-dark" title="View more" onclick="window.location.href='org_list.php'">View more</a>
													</div>
												</div>
											</div>
										</div>

										<!-- <div class="col-gl-6 col-md-6 col-sm-12 col-xs-12 m-b-sm">
											<div class="card ">
												<div class="card-header ewt-bg-color m-b-sm b-t-l-3 b-t-r-3">
													<div class="card-title text-left">
														<div class="title"><i class="fas fa-hashtag"></i> <?php echo $txt_org_group_latest; ?></div>

													</div>
												</div>
												<div class="card-body" id="tab2">
													<ul class="list-group">
														<?php
														$a_OrgGrouptop5 = org::genOrgGroupTop5('5');

														foreach ((array)$a_OrgGrouptop5 as $_item_group) {
														?>
															<li class="list-group-item "><i class="fas fa-database text-dark"></i> :: <?php echo org::getOrg($_item_group); ?></li>

														<?php } ?>
													</ul>


													<div class="hi-icon-wrap hi-icon-effect-7 hi-icon-effect-7b  text-right">
														<a href="#View more" class="hi-icon hi-icon-list text-dark" title="View more" onclick="window.location.href='org_group.php'">View more</a>
													</div>
												</div>
											</div>
										</div> -->
									</div>
								</div>

							</div>
						</div>



					</div>

				</div>
				<!--END card-body -->
			</div>
			<!--END card -->

		</div>
	</div>

</div>
<!-- END CONTAINER  -->
<?php
$db->query("USE " . $EWT_DB_NAME);
include("../EWT_ADMIN/combottom.php");
?>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>