<?php
include("../EWT_ADMIN/comtop.php");
?>

<!-- START CONTAINER  -->
<div class="container-fluid">
	<?php

	$template_id = ready($_GET["template_id"]);
	$lang_id     = ready($_GET["lang_id"]);

	if (trim($lang_id) == "") {
		$lang_id = 1;
	}

	if ($db->check_permission("intro", "layout", "")) {
		$has_pass_w = 'Y';
	}

	$module_data = $db->query("SELECT m_image FROM $EWT_DB_USER.web_module_ewt WHERE m_code = 'layout'");
	$module_info = $db->db_fetch_array($module_data);

	$EWT_module_name      = "Site Layout Management";
	$EWT_module_icon      = $module_info["m_image"];
	$EWT_module_subarray  = array(array("name" => "ตั้งค่าเทมเพลต", "url" => "../SiteLayoutMgt/layout_index.php"));


	include("../include/module_header.php");

	##=============================================================================================================##
	## >> Get Template + Language
	$template_data   = $db->query("SELECT * FROM site_management_template WHERE template_id = '$template_id'");
	$template_info   = $db->db_fetch_array($template_data);

	$s_lang_config = $db->query("SELECT lang_config_id,lang_config_name,lang_config_id,lang_config_suffix,lang_config_img FROM lang_config WHERE lang_config_id = '$lang_id'");
	$s_lang_info = $db->db_fetch_array($s_lang_config);

	## >> Get Manage
	$manage_data  = $db->query("SELECT * FROM site_management WHERE template_id = '$template_id' AND lang_id = '$lang_id'");
	$manage_info  = $db->db_fetch_array($manage_data);

	## >> Get Section
	$section_array = array();
	$section_data  = $db->query("SELECT * FROM site_management_section 
                             WHERE template_id = '$template_id' AND lang_id = '$lang_id' 
							 AND section_use = 'Y' AND module_name != 'background_index'
							 GROUP BY template_id, lang_id, section_order
							 ORDER BY section_order,section_id ASC");
	while ($section_info = $db->db_fetch_array($section_data)) {
		if ($section_info["section_no"] != "") {
			$section_info["section_title"] = $section_info["section_no"] . " - " . $section_info["section_title"];
		}

		array_push($section_array, $section_info);
	}

	## >> Get Menu 
	$menu_array = array();
	$menu_data  = $db->query("SELECT * FROM menu_list WHERE m_show = 'Y' ORDER BY m_name ASC");
	while ($menu_info = $db->db_fetch_array($menu_data)) {
		array_push($menu_array, $menu_info);
	}

	## >> Get Bannergroup
	$bannergroup_array = array();
	$bannergroup_data  = $db->query("SELECT * FROM banner_group ORDER BY banner_name ASC");
	while ($bannergroup_info = $db->db_fetch_array($bannergroup_data)) {
		array_push($bannergroup_array, $bannergroup_info);
	}
	?>

	<div id="nav" style="position:absolute;width:400px;  z-index:1;display:none"></div>
	<form action="layout_function.php" method="post" id="layout_form" name="layout_form" enctype="multipart/form-data">
		<div class="row m-b-sm">
			<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">
				<!--start card -->
				<div class="card">
					<!--start card-header -->
					<div class="card-header">
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">
								<h4>
									<?php
									$lang_suffix = "";
									if ($s_lang_info["lang_config_suffix"] != "") {
										$lang_suffix = " [" . $s_lang_info["lang_config_suffix"] . "]";
									}

									echo "แก้ไข " . $template_info["template_name"] . $lang_suffix;
									?>
								</h4>
							</div>
						</div>
					</div>

					<div class="card-body">
						<div class="row ">
							<div class="col-md-12 col-sm-12 col-xs-12" id="table-view">
								<div class="card ">
									<div class="card-header ewt-bg-color m-b-sm b-t-l-3 b-t-r-3">
										<div class="card-title text-left">
											<div class="title"><i class="fas fa-cogs" aria-hidden="true"></i> Header</div>
										</div>
									</div>
									<div class="card-body">
										<div class="form-group row">
											<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12">
												<div>
													<label for="site_logo"><b>Logo</b></label>
													<!--span class="text-danger"><code>*</code></span--> :
												</div>
												<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-8">
													<input type="file" class="form-control" name="site_logo" id="site_logo" value="<?php echo $manage_info["site_logo"]; ?>">
												</div>
												<!--<div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-xs-4">
													 <a href="#browse" onclick="win2 = window.open('../FileMgt/gallery_main.php?stype=link&amp;Flag=Link&amp;o_value=window.opener.document.layout_form.site_logo.value','Gallery Image','top=100,left=100,width=800,height=600,resizable=1,status=0');document.layout_form.browsefile[0].checked=true;win2.focus();">
														<button type="button" class="btn btn-info  btn-sm" style="width:100%;">
															<i class="fas fa-folder-open"></i>&nbsp;เลือกไฟล์
														</button>
													</a> 
												</div>-->
												<?php
												if ($manage_info["site_logo"] != "") {
												?>
													<div class="col-xl-10 col-lg-10 col-md-12 col-sm-12 col-xs-12" id="site_logo_sample" align="center" style="margin-top:20px;margin-bottom:20px;cursor:pointer;">
														<img src="<?php echo "../ewt/" . $_SESSION["EWT_SUSER"] . "/" . $manage_info["site_logo"]; ?>" title="<?php echo $manage_info["site_logo"]; ?>" alt="<?php echo $manage_info["site_logo"]; ?>" style="max-height:200px;background-color:#9f9e9e;">
													</div>
												<?php
												}
												?>
											</div>
										</div>

										<div class="form-group row">
											<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12">
												<div>
													<label for="site_mainmenu"><b>เมนูหลัก :</b></label>
												</div>
												<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-8">
													<select class="form-control" id="site_mainmenu" name="site_mainmenu">
														<option value="">เลือกเมนู</option>
														<?php
														foreach ($menu_array as $menu) {
														?>
															<option value="<?php echo $menu["m_id"]; ?>" <?php echo ($manage_info["site_mainmenu"] == $menu["m_id"]) ? "selected" : null; ?>>
																<?php echo $menu["m_name"]; ?>
															</option>
														<?php
														}
														?>
													</select>
												</div>
											</div>
										</div>

										<?php if ($template_id == 2) { ?>
											<div class="form-group row">
												<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12">
													<div>
														<label for="site_submenu"><b>เมนูย่อย :</b></label>
													</div>
													<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-8">
														<select class="form-control" id="site_submenu" name="site_submenu">
															<option value="">เลือกเมนู</option>
															<?php
															foreach ($menu_array as $menu) {
															?>
																<option value="<?php echo $menu["m_id"]; ?>" <?php echo ($manage_info["site_mainmenu"] == $menu["m_id"]) ? "selected" : null; ?>>
																	<?php echo $menu["m_name"]; ?>
																</option>
															<?php
															}
															?>
														</select>
													</div>
												</div>
											</div>
										<?php } ?>

										<div class="form-group row">
											<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12">
												<div>
													<label for=""><b>แบนเนอร์หลัก :</b></label>
												</div>
												<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-8">
													<select class="form-control" id="site_mainbanner" name="site_mainbanner">
														<option value="">เลือกแบนเนอร์</option>
														<?php
														foreach ($bannergroup_array as $bannergroup) {
														?>
															<option value="<?php echo $bannergroup["banner_gid"]; ?>" <?php echo ($manage_info["site_mainbanner"] == $bannergroup["banner_gid"]) ? "selected" : null; ?>>
																<?php echo $bannergroup["banner_name"]; ?>
															</option>
														<?php
														}
														?>
													</select>
												</div>
											</div>
										</div>
										<!--Comment
										<div class="form-group row">
											<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12">
												<div>
													<label for="site_mainmenu"><b>พื้นหลัง Header</b></label>
												</div>
												<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-8">
													Comment-->
													<!--Comment
													<?php if (strstr($manage_info["site_header"], '#')) { ?>
														<input type="text" class="form-control" name="site_header" id="site_header" value="<?php echo $manage_info["site_header"]; ?>">
													<?php } else { ?>Comment-->


														<!-- <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-8"> -->
															<!-- Comment
														<input type="file" class="form-control" name="site_header" id="site_header" value="<?php echo $manage_info["site_header"]; ?>">
													Comment-->
														<!-- </div> -->
														<!-- <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-xs-4">
															<a href="#browse" onclick="win2 = window.open('../FileMgt/gallery_main.php?stype=link&amp;Flag=Link&amp;o_value=window.opener.document.layout_form.site_header.value','Gallery Image','top=100,left=100,width=800,height=600,resizable=1,status=0');document.layout_form.browsefile[0].checked=true;win2.focus();">
																<button type="button" class="btn btn-info  btn-sm" style="width:100%;">
																	<i class="fas fa-folder-open"></i>&nbsp;เลือกไฟล์
																</button>
															</a>
														</div> -->
													<!--Comment
														<div class="col-xl-10 col-lg-10 col-md-12 col-sm-12 col-xs-12" id="site_header_sample" align="center" style="margin-top:20px;margin-bottom:20px;cursor:pointer;">
															<img src="<?php echo "../ewt/" . $_SESSION["EWT_SUSER"] . "/" . $manage_info["site_header"]; ?>" title="<?php echo $manage_info["site_header"]; ?>" alt="<?php echo $manage_info["site_header"]; ?>" style="max-height:200px;background-color:#9f9e9e;">
														</div>
													Comment-->
													<?php } ?>
													<!-- </div> -->
												<!--Comment</div>
											</div>

										</div>
										Comment-->
									</div>
								</div>
							</div>
						</div>

						<div class="card-body">
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12" id="table-view">

									<div class="card ">
										<div class="card-header ewt-bg-color m-b-sm b-t-l-3 b-t-r-3">
											<div class="card-title text-left">
												<div class="title"><i class="fas fa-cogs" aria-hidden="true"></i> Home</div>
											</div>
										</div>
										<div class="card-body">
											<ul id="sortableLv1" class="sortableLv1" style="width: 100%;">
												<?php
												$order = 1;
												foreach ($section_array as $section) {
												?>
													<li class="productCategoryLevel1 move" id="<?php echo $section['section_id']; ?>">
														&nbsp;
														<span class="">
															<i class="fa fa-ellipsis-v text-medium text-dark"></i>
														</span>

														<input class="input-inline-sm text-center section_order" name="section_order[]" id="section_order<?php echo $order; ?>" type="text" value="<?php echo $order; ?>" readonly />

														<b style="word-break: break-all;"><?php echo $section['section_title']; ?> </b>
														<span class="iconAction">
															<a onClick="boxPopup('<?php echo linkboxPopup(); ?>pop_edit_layoutsection.php?section_id=<?php echo $section['section_id']; ?>');" data-toggle="tooltip" data-placement="right" title="แก้ไข">
																<i class="fa fa-edit  text-medium text-dark pointer" aria-hidden="true"></i>
															</a>
														</span>
													</li>
												<?php
													$order++;
												}
												?>
											</ul>
											<!-- Comment
											<hr>
											<div class="form-group row">
												<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12"> Comment -->
													<!-- <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-8"> -->
														<!-- Comment
														<input type="file" class="form-control" id="site_calendar" name="site_calendar" value="<?php echo $manage_info["site_calendar"]; ?>">
											Comment-->
													<!-- </div> -->
													<!-- <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-xs-4">
														<a href="#browse" onclick="win2 = window.open('../FileMgt/gallery_main.php?stype=link&amp;Flag=Link&amp;o_value=window.opener.document.layout_form.site_calendar.value','Gallery Image','top=100,left=100,width=800,height=600,resizable=1,status=0');document.layout_form.browsefile[0].checked=true;win2.focus();">
															<button type="button" class="btn btn-info  btn-sm" style="width:100%;">
																<i class="fas fa-folder-open"></i>&nbsp;เลือกไฟล์
															</button>
														</a>
													</div> -->
													<!-- Comment
													<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12" id="site_calendar_sample" align="center" style="margin-top:20px;margin-bottom:20px;cursor:pointer;">
														<img src="<?php echo "../../" . $manage_info["site_calendar"]; ?>" title="<?php echo $manage_info["site_calendar"]; ?>" alt="<?php echo $manage_info["site_calendar"]; ?>" style="max-height:200px;background-color:#9f9e9e;">
													</div>
												</div>
											</div>
											-->
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="card-body">
							<div class="row ">
								<div class="col-md-12 col-sm-12 col-xs-12" id="table-view">

									<div class="card ">
										<div class="card-header ewt-bg-color m-b-sm b-t-l-3 b-t-r-3">
											<div class="card-title text-left">
												<div class="title"><i class="fas fa-cogs" aria-hidden="true"></i> Footer</div>
											</div>
										</div>
										<div class="card-body">

											<div class="form-group row">
												<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12">
													<div>
														<label for="site_address"><b>Address : </b></label>
													</div>
													<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-8">
														<textarea class="form-control" name="site_address" id="site_address" rows="4" cols="50"><?php echo $manage_info["site_address"]; ?></textarea>
													</div>
												</div>
											</div>

											<div class="form-group row">
												<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12">
													<div>
														<label for="site_tel"><b>Tel : </b></label>
													</div>
													<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-8">
														<input type="text" class="form-control" placeholder="" id="site_tel" name="site_tel" value="<?php echo $manage_info["site_tel"]; ?>">
													</div>
												</div>
											</div>

											<div class="form-group row">
												<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12">
													<div>
														<label for="site_fax"><b>Fax : </b></label>
													</div>
													<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-8">
														<input type="text" class="form-control" placeholder="" id="site_fax" name="site_fax" value="<?php echo $manage_info["site_fax"]; ?>">
													</div>
												</div>
											</div>

											<div class="form-group row">
												<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12">
													<div>
														<label for="site_email"><b>Email : </b></label>
													</div>
													<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-8">
														<input type="text" class="form-control" placeholder="" id="site_email" name="site_email" value="<?php echo $manage_info["site_email"]; ?>">
													</div>
												</div>
											</div>

											<!-- <div class="form-group row">
													<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12">
														<div>
															<label for="site_twitter"><b>Twitter : </b></label>   
														</div>
														<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-8">     
															<input type="text" class="form-control" placeholder="" id="site_twitter" name="site_twitter" value="<?php echo $manage_info["site_twitter"]; ?>">
														</div>
													</div>
												</div> -->

												<!-- <div class="form-group row">
													<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12">
														<div>
															<label for="site_facebook"><b>Facebook : </b></label>   
														</div>
														<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-8">     
															<input type="text" class="form-control" placeholder="" id="site_facebook" name="site_facebook" value="<?php echo $manage_info["site_facebook"]; ?>">
														</div>
													</div>
												</div> -->

												<!-- <div class="form-group row">
													<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12">
														<div>
															<label for="site_instagram"><b>Instagram : </b></label>   
														</div>
														<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-8">     
															<input type="text" class="form-control" placeholder="" id="site_instagram" name="site_instagram" value="<?php echo $manage_info["site_instagram"]; ?>">
														</div>
													</div>
												</div> -->

												<!-- <div class="form-group row">
												<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12">
													<div>
														<label for="site_youtube"><b>Youtube : </b></label>   
													</div>
													<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-8">     
														<input type="text" class="form-control" placeholder="" id="site_youtube" name="site_youtube" value="<?php echo $manage_info["site_youtube"]; ?>">
													</div>
												</div>
											</div> -->

											<div class="form-group row">
												<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12">
													<div>
														<label for=""><b>Sitemap :</b></label>
													</div>
													<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-8">
														<select class="form-control" id="site_sitemap" name="site_sitemap">
															<option value="">เลือกเมนู</option>
															<?php
															foreach ($menu_array as $menu) {
															?>
																<option value="<?php echo $menu["m_id"]; ?>" <?php echo ($manage_info["site_sitemap"] == $menu["m_id"]) ? "selected" : null; ?>>
																	<?php echo $menu["m_name"]; ?>
																</option>
															<?php
															}
															?>
														</select>
													</div>
												</div>
											</div>

											<!-- <div class="form-group row">
												<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12">
													<div>
														<label for=""><b>Contact Icon:</b></label>
													</div>
													<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-8">
														<select class="form-control" id="site_icon" name="site_icon">
															<option value="">เลือกรูปภาพไอคอน</option>
															<?php
															//foreach ($bannergroup_array as $bannergroup) {
															?>
																<option value="<?php // echo $bannergroup["banner_gid"]; ?>" <?php// echo ($manage_info["site_icon"] == $bannergroup["banner_gid"]) ? "selected" : null; ?>>
																	<?php //echo $bannergroup["banner_name"]; ?>
																</option>
															<?php
															 // }
															?>
														</select>
													</div>
												</div>
											</div> -->

											<div class="form-group row">
												<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12">
													<div>
														<label for="site_email"><b>พื้นหลัง Footer : </b></label>
														<!-- <<<a href="http://www.w3big.com/th/cssref/css-colors.html" target="_blank">สีพื้นหลัง</a>>>  -->
													</div>
													<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-8">
														<input type="text" class="form-control" id="site_footer" name="site_footer" value="<?php echo $manage_info["site_footer"]; ?>">
													</div>
												</div>
											</div>

											<!-- <div class="form-group row">
													<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12">
													<div>
														<label for=""><b>Banner ประชาสัมพันธ์ภายนอก :</b></label>
													</div>
													<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-8">     
														<select class="form-control" id="site_infobanner" name="site_infobanner">
															<option value="">เลือกเมนู</option>
															<?php
															foreach ($bannergroup_array as $bannergroup) {
															?>
															<option value="<?php echo $bannergroup["banner_gid"]; ?>" 
																<?php if ($manage_info["site_infobanner"] == $bannergroup["banner_gid"]) {
																	echo "selected";
																} ?>>
																<?php echo $bannergroup["banner_name"]; ?>
															</option>
															<?php
															}
															?>
														</select>
													</div>
												</div>
											</div> -->

											<!-- <div class="form-group row">
												<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12">
													<div>
														<label for=""><b>Policy :</b></label>
													</div>
													<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-8">     
														<select class="form-control" id="site_policy" name="site_policy">
															<option value="">เลือกเมนู</option>
															<?php
															foreach ($menu_array as $menu) {
															?>
															<option value="<?php echo $menu["m_id"]; ?>"
																<?php if ($manage_info["site_policy"] == $menu["m_id"]) {
																	echo "selected";
																} ?>>
																<?php echo $menu["m_name"]; ?>
															</option>
															<?php
															}
															?>
														</select>
													</div>
												</div>
											</div> -->

											<div align="center">
												<button class="btn btn-success btn-ml " type="submit">บันทึก</button>
												<input type="hidden" name="flag" value="edit">
												<input type="hidden" name="template_id" value="<?php echo $template_id; ?>">
												<input type="hidden" name="lang_id" value="<?php echo $lang_id; ?>">
											</div>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	</form>
</div>

<!-- END CONTAINER  -->
<?php
include("../EWT_ADMIN/combottom.php");
?> 
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui-touch-punch.min.js"></script>

<script>
	$(function() {
		$("#sortableLv1").sortable({
			placeholder: 'drop-placeholder',
			update: function(event, ui) {
				var page_id_array = new Array();
				$('#sortableLv1 li').each(function() {
					page_id_array.push($(this).attr("id"));
				});
				//console.log(page_id_array);			
				$.ajax({
					type: 'POST',
					url: 'layout_function.php',
					data: {
						flag: 'section_reorder',
						page_id_array: page_id_array,
						lang_id: '<?php echo $lang_id; ?>',
						template_id: '<?php echo $template_id; ?>'
					},
					success: function(data) {
						//console.log(data);	
						//location.reload(true);
						$('.section_order').each(function(i, obj) {
							$('.section_order').eq(i).val(i + 1);
						});
					}
				});
			}
		});
	});
</script>