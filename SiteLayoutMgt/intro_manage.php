<?php
include("../EWT_ADMIN/comtop.php");

$pass_w = "";
if($db->check_permission("intro","w","")){
	$pass_w = "Y";	
}
else{
	$is_not_owner = "Y";
}

##=============================================================================================================##
## >> Filter input
$flag     = $_GET["flag"];
$intro_id = filter_number($_GET["intro_id"]);

if(!in_array($flag,array("add","edit"))){
	?>
	<script type="text/javascript">
		location.href='intro_manage.php?flag=add';
	</script>
	<?php
	exit();
}

if($flag=="edit"){
	$intro_data   = $db->query("SELECT * 
								FROM intro_list 
								WHERE intro_id = '$intro_id'");
	$total_result = $db->db_num_rows($intro_data);
	if($total_result==0){
		?>
		<script type="text/javascript">
			location.href='intro_manage.php?flag=add';
		</script>
		<?php
		exit();
	}
	else{
		$intro_info = $db->db_fetch_array($intro_data);

											
		if($intro_info["intro_show_start"]=="0000-00-00"){
			$intro_info["intro_show_start"]="-";
		}
		else if($intro_info["intro_show_start"]!="" && filter_date("-",$intro_info["intro_show_start"])!=""){
			$show_start = explode("-",$intro_info["intro_show_start"]);
			$show_start = $show_start[2]."/".$show_start[1]."/".$show_start[0];
		}
		if($intro_info["intro_show_end"]=="0000-00-00"){
			$intro_info["intro_show_end"]="-";
		}
		else if($intro_info["intro_show_end"]!="" && filter_date("-",$intro_info["intro_show_end"])!=""){
			$show_end   = explode("-",$intro_info["intro_show_end"]);
			$show_end   = $show_end[2]."/".$show_end[1]."/".$show_end[0];
		}
		/*echo "<pre>";
		print_r($intro_info);
		echo "</pre>";*/

		if($intro_info["intro_type"]=="page"){
			$introtype_page_hidden  = "";
			$introtype_popup_hidden = "hidden";
		}
		else{
			$introtype_page_hidden  = "hidden";
			$introtype_popup_hidden = "";
		}

		## >> Only super admin and intro owner can edit the intro
		if($pass_w == "Y" AND $intro_info['intro_owner'] != $_SESSION['EWT_SMID']){
			$is_not_owner = "Y";
		}
		if($_SESSION['EWT_SMTYPE'] == "Y"){
			$is_not_owner = "N";
		}
	}
}
else{
	$introtype_page_hidden  = "hidden";
	$introtype_popup_hidden = "hidden";
}

##========================================================================================================##
## >> Select all Banner group
$bannergroup_array = array();

$banner_data = $db->query("SELECT * FROM banner_group ORDER BY banner_cate_order ASC");
while($banner_info = $db->db_fetch_array($banner_data)){
	array_push($bannergroup_array,$banner_info);
}

##========================================================================================================##
## >> Select all Banner
$bannerlist_array = array();
$bannerlist1_array = array();

$bannerlist_data  = $db->query("SELECT * FROM banner ORDER BY banner_gid ASC, banner_position ASC");
while($bannerlist_info = $db->db_fetch_array($bannerlist_data)){
	if(!is_array($bannerlist_array[$bannerlist_info["banner_gid"]])){
		$bannerlist_array[$bannerlist_info["banner_gid"]] = array();
	}
	
	array_push($bannerlist_array[$bannerlist_info["banner_gid"]],$bannerlist_info);
	$bannerlist1_array[$bannerlist_info["banner_id"]]=$bannerlist_info;
}

##========================================================================================================##
## >> Select all Banner in use
$bannerlistuse_array = array();
$bannerlist_data  = $db->query("SELECT banner_id FROM intro_banner_list WHERE intro_id = '$intro_id' ORDER BY banner_order ASC");
while($bannerlist_info = $db->db_fetch_array($bannerlist_data)){
	array_push($bannerlistuse_array,$bannerlist_info["banner_id"]);
}

?>  

<!-- START CONTAINER  -->
<div class="container-fluid" >
<?php

$module_data = $db->query("SELECT m_image 
                           FROM   $EWT_DB_USER.web_module_ewt
                           WHERE  m_code = 'intro'");
$module_info = $db->db_fetch_array($module_data);

$EWT_module_name      = "Intro Management";
$EWT_module_icon      = $module_info["m_image"];
$EWT_module_subarray  = array(array("name"=>"บริหาร Intro Page","url"=>"../IntroMgt/intro_index.php?flag=intro_page"),
							  array("name"=>"บริหาร Pop-Up","url"=>"../IntroMgt/intro_index.php?flag=popup"));


include("../include/module_header.php");
?>


<div id="nav" style="position:absolute;width:400px;  z-index:1;display:none" ></div>

	<div class="row m-b-sm">
		<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >	
			<!--start card -->
			<div class="card">
				<!--start card-header -->
				<div class="card-header">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >

							<h4>
							<?php
							if($flag=="add"){
								echo "เพิ่ม Intro Page/Pop-Up";
							}
							else if($flag=="edit"){
								if($intro_info["intro_type"]=="page"){
									echo "แก้ไข Intro Page";
								}
								else if($intro_info["intro_type"]=="popup"){
									echo "แก้ไข Pop-Up";
								}
							}
							?>
							</h4>
							<p></p> 

						</div>
					</div>
				</div>
				<!--END card-header -->

				<div class="card-body">
					<div id="nav" style="position:absolute;width:400px;  z-index:1;display:none" ></div>
						<div class="row ">
							<?php
							if($is_not_owner=="Y"){
							
								if($type=="intro_page"){
									echo "ท่านไม่มีสิทธิ์ในการแก้ไข Intro Page นี้";
								}
								else if($type=="popup"){
									echo "ท่านไม่มีสิทธิ์ในการแก้ไข Pop-Up นี้";
								}
							
							}
							else{
							?>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="card ">
									<div class="card-header ewt-bg-success m-b-sm">
										<div class="card-title text-left"></div>
									</div>

									<div class="card-body">
									
										<form action="intro_function.php" method="post" id="intro_form" name="intro_form">
											<div class="form-group row">
												<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12">
													<div>
														<label for="intro_name"><b>ชื่อ <span class="text-danger"><code>*</code></span> : </b></label>        
													</div>
													<div class="col-xl-10 col-lg-10 col-md-12 col-sm-12 col-xs-12">    
														<input type="text" class="form-control" placeholder="" id="intro_name" name="intro_name" value="<?php echo $intro_info["intro_name"];?>">
													</div>
												</div>
											</div>

											<?php
											if($flag=="add"){
											?>
											<div class="form-group row">
												<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12">
													<div>
														<label for="intro_name"><b>ประเภท <span class="text-danger"><code>*</code></span> : </b></label>        
													</div>
													<div class="col-xl-10 col-lg-10 col-md-12 col-sm-12 col-xs-12">    
														<div class="radio">
															<label for="intro_type_1">
																<input class="introtype_option" type="radio" id="intro_type_1" name="intro_type" value="page" <?php if($type=="intro_page"){echo "checked";} ?>>
																Intro Page     
																<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
															</label>
														</div>   
														<div class="radio">
															<label for="intro_type_2">
																<input class="introtype_option" type="radio" id="intro_type_2" name="intro_type" value="popup" <?php if($type=="popup"){echo "checked";} ?>>
																Pop-Up     
																<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
															</label>
														</div>
													</div>
												</div>
											</div>
											<?php
											}
											?>

											<?php
											if($flag=="add" || ($flag=="edit" && $intro_info["intro_type"]=="page")){
												if($type=="intro_page"){
													$introtype_page_hidden = "";
												}
											?>
											<div id="introtype_page_section" <?php echo $introtype_page_hidden; ?>>
												<div class="form-group row">
													<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12">
														<div>
															<label for="intro_image"><b>ภาพ Intro <span class="text-danger"><code>*</code></span> : </b></label>   
														</div>
														<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-8">     
															<input type="text" class="form-control" placeholder="" id="intro_image" name="intro_image" value="<?php echo $intro_info["intro_image"];?>">
														</div>
														<div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-xs-4">     
															<a href="#browse" onclick="win2 = window.open('../FileMgt/gallery_main.php?stype=link&amp;Flag=Link&amp;o_value=window.opener.document.intro_form.intro_image.value','Gallery Image','top=100,left=100,width=800,height=600,resizable=1,status=0');document.intro_form.browsefile[0].checked=true;win2.focus();">
																<button type="button" class="btn btn-info  btn-sm" style="width:100%;">
																<i class="fas fa-folder-open"></i>&nbsp;เลือกไฟล์
																</button>
															</a>
														</div>
														<?php
														if($intro_info["intro_image"]!=""){
														?>
														<div class="col-xl-10 col-lg-10 col-md-12 col-sm-12 col-xs-12" id="intro_image_sample" align="center" style="margin-top:20px;margin-bottom:20px;">
															<img src="<?php echo "../ewt/".$_SESSION["EWT_SUSER"]."/".$intro_info["intro_image"];?>" style="max-height:200px;">
														</div>
														<?php
														}
														?>
													</div>
												</div>

												<div class="form-group row">
													<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12">
														<div>
															<label for="intro_background"><b>ภาพพื้นหลัง <span class="text-danger"><code>*</code></span> : </b></label>      
														</div>
														<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-8">     
															<input type="text" class="form-control" placeholder="" id="intro_background" name="intro_background" value="<?php echo $intro_info["intro_background"];?>">
														</div>
														<div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-xs-4">     
															<a href="#browse" onclick="win2 = window.open('../FileMgt/gallery_main.php?stype=link&amp;Flag=Link&amp;o_value=window.opener.document.intro_form.intro_background.value','Gallery Image','top=100,left=100,width=800,height=600,resizable=1,status=0');document.intro_form.browsefile[0].checked=true;win2.focus();">
																<button type="button" class="btn btn-info  btn-sm" style="width:100%;">
																<i class="fas fa-folder-open"></i>&nbsp;เลือกไฟล์
																</button>
															</a>
														</div>
														<?php
														if($intro_info["intro_background"]!=""){
														?>
														<div class="col-xl-10 col-lg-10 col-md-12 col-sm-12 col-xs-12" id="intro_background_sample" align="center" style="margin-top:20px;margin-bottom:20px;">
															<img src="<?php echo "../ewt/".$_SESSION["EWT_SUSER"]."/".$intro_info["intro_background"];?>" style="max-height:200px;">
														</div>
														<?php
														}
														?>
													</div>
												</div>

												<hr></hr>
												
												<div class="form-group row">
													<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12">
														<div class="table-responsive"	style="overflow: visible;">	  
															<table width="100%" border="0"  align="center" class="table table-bordered ">
																<thead>
																	<tr class="success">
																		<th width="5%" class="text-center">ลำดับ</th>
																		<th width="95%" class="text-center">รายละเอียด</th>
																	</tr>
																</thead>

																<?php
																$button_array = array();
																$i = 1;
																if($flag=="edit"){
																	$button_data  = $db->query("SELECT * FROM intro_button_list WHERE intro_id = '$intro_id'");
																	$total_button = $db->db_num_rows($button_data); 
																
																	if($total_button>0){
																		while($button_info  = $db->db_fetch_array($button_data)){
																			$button_info["no"] = $i;
																			array_push($button_array,$button_info);
																			$i++;
																		}

																	}
																	else{
																		$button_info["no"] = $i;
																		array_push($button_array,$button_info);
																	}
																}
																else{
																	$button_info["no"] = $i;
																	array_push($button_array,$button_info);
																}
																?>

																<tbody id="button_set_area">
																	<?php
																	foreach($button_array AS $button_e){
																	?>
																	<tr class="productCategoryLevel1-td" id="buttonset_row_<?php echo $button_e["no"]; ?>"> 
																		<td class="text-center">
																			<span class="buttonset_no"><?php echo $button_e["no"]; ?></span>.
																		</td>

																		<td class="text-left"> 
																			<div class="form-group row">
																				<div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom:20px;">    
																					<div>
																						<label for="link_button_<?php echo $button_e["no"]; ?>"><b>ปุ่ม <span class="text-danger"><code>*</code></span> : </b></label>      
																					</div>
																					<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-8">     
																						<input type="text" class="form-control" placeholder="" id="link_button_<?php echo $button_e["no"]; ?>" name="link_button_<?php echo $button_e["no"]; ?>" value="<?php echo $button_e["intro_button"]; ?>">
																					</div>
																					<div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-xs-4">     
																						<a href="#browse" onclick="win2 = window.open('../FileMgt/gallery_main.php?stype=link&amp;Flag=Link&amp;o_value=window.opener.document.intro_form.link_button_<?php echo $button_e["no"]; ?>.value','Gallery Image','top=100,left=100,width=800,height=600,resizable=1,status=0');document.intro_form.browsefile[0].checked=true;win2.focus();">
																							<button type="button" class="btn btn-info  btn-sm" style="width:100%;">
																							<i class="fas fa-folder-open"></i>&nbsp;เลือกไฟล์
																							</button>
																						</a>
																					</div>
																					<?php
																					if(trim($button_e["intro_button"])!=""){
																					?>
																					<div class="col-xl-10 col-lg-10 col-md-12 col-sm-12 col-xs-12" id="intro_background_sample" align="center" style="margin-top:20px;margin-bottom:20px;">
																						<img src="<?php echo "../ewt/".$_SESSION["EWT_SUSER"]."/".$button_e["intro_button"];?>" style="max-height:100px;">
																					</div>
																					<?php
																					}
																					?>
																				</div>
																				<div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom:20px;">
																							
																					<div>
																						<label for="link_url_<?php echo $button_e["no"]; ?>"><b>Link URL <span class="text-danger"><code>*</code></span> : </b></label>      
																					</div>
																					<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-8">     
																						<input type="text" class="form-control" placeholder="" id="link_url_<?php echo $button_e["no"]; ?>" name="link_url_<?php echo $button_e["no"]; ?>" value="<?php echo $button_e["intro_link"]; ?>">
																					</div>
																					<div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-xs-4">     
																						<a href="#browse" onclick="win2 = window.open('../FileMgt/article_main.php?stype=link&amp;Flag=Link&amp;o_value=window.opener.document.intro_form.link_url_<?php echo $button_e["no"]; ?>.value','Link','top=100,left=100,width=800,height=600,resizable=1,status=0');document.intro_form.browsefile[0].checked=true;win2.focus();">
																							<button type="button" class="btn btn-info  btn-sm" style="width:100%;">
																							<i class="fas fa-folder-open"></i>&nbsp;เลือก url
																							</button>
																						</a>
																					</div>
																				</div>
																				<div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom:20px;">
																							
																					<div>
																						<label for="link_target_<?php echo $button_e["no"]; ?>"><b> Target <span class="text-danger"></span> : </b></label>    
																					</div>
																					<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-8">   
																						<select class="form-control" id="link_target_<?php echo $button_e["no"]; ?>" name="link_target_<?php echo $button_e["no"]; ?>">
																							<option value="">ไม่ใช้งาน</option>
																							<option value="_self" <?php if($button_e["intro_target"]=="_self"){echo "selected";} ?>>_self</option>
																							<option value="_blank" <?php if($button_e["intro_target"]=="_blank"){echo "selected";} ?>>_blank</option>
																						</select>
																					</div>
																				</div>
																				<div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom:20px;">
																							
																					<div>
																						<label for="link_alt_<?php echo $button_e["no"]; ?>"><b> Alt <span class="text-danger"></span> : </b></label>    
																					</div>
																					<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-8">     
																						<input type="text" class="form-control" placeholder="" id="link_alt_<?php echo $button_e["no"]; ?>" name="link_alt_<?php echo $button_e["no"]; ?>" value="<?php echo $button_e["intro_alt"]; ?>">
																					</div>
																				</div>
																				<div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom:20px;">
																							
																					<div>
																						<label for="link_language_<?php echo $button_e["no"]; ?>"><b> Language <span class="text-danger"><code>*</code></span> : </b></label>    
																					</div>
																					<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-8">   
																						<select class="form-control" id="link_language_<?php echo $button_e["no"]; ?>" name="link_language_<?php echo $button_e["no"]; ?>">
																							<option value="TH" <?php if($button_e["intro_language"]=="TH"){echo "selected";} ?>>TH</option>
																							<option value="EN" <?php if($button_e["intro_language"]=="EN"){echo "selected";} ?>>EN</option>
																						</select>
																					</div>
																				</div>

																				<?php if($button_e["no"]>1){ ?>															
																				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12" align="right" style="margin-top:20px;">
																					<button type="button" class="btn btn-danger btn-sm" onclick="remove_buttonset('buttonset_row_<?php echo $button_e["no"]; ?>');">
																						ลบปุ่ม
																					</button>
																				</div>
																				<?php
																				}
																				?>
																				
																			</div>
																			
																		</td>
																	</tr>
																	<?php
																	}
																	?>
																</tbody>
																<?php
																
																?>
																<tfooter>
																	<tr class="productCategoryLevel1-td"> 
																		<td colspan="2" class="text-right">
																			<input type="hidden" id="current_button" name="current_button" value="<?php echo $i; ?>">
																			<button type="button" class="btn btn-primary btn-sm" onclick="add_buttonset();">
																				เพิ่มปุ่ม
																			</button>
																		</td>
																	</tr>
																</tfooter>
															</table>
														</div>
													</div>
												</div>

												<hr></hr>

											</div>
											<?php
											}
											
											if($flag=="add" || ($flag=="edit" && $intro_info["intro_type"]=="popup")){
												if($type=="popup"){
													$introtype_popup_hidden = "";
												}
											?>

											<div id="introtype_popup_section" <?php echo $introtype_popup_hidden; ?>>
												
												<div class="form-group row">
													<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
														<div>
															<label><b>เลือก Banner ที่ใช้ใน Pop-Up <?php echo $text_genGallery_module; ?><span class="text-danger"><code>*</code></span> : </b></label>        
														</div>

														<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">

															<div class="panel-group" id="accordion_banner">
																
																<?php
																$u = 1;
																foreach($bannergroup_array AS $banner_info){

																	## >> Check select all
																	$check_all = "Y";
																	foreach($bannerlist_array[$banner_info["banner_gid"]] AS $bannerlist){
																		if(!in_array($bannerlist["banner_id"],$bannerlistuse_array)){
																			$check_all = "N";
																		}
																	}

																?>
																<div class="panel panel-default ">
																	<div class="panel-heading ewt-bg-success">
																		<span style="font-size: 12px;">
																			<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion_banner" href="#collapse_banner_<?php echo $u; ?>">
																				<img src="../EWT_ADMIN/images/grabme.svg"> 
																				<b style="word-break: break-all;"><?php echo $banner_info["banner_name"]; ?> </b>		
																			</a>					
																		</span>
																	</div>
																	
																	<div id="collapse_banner_<?php echo $u; ?>" class="panel-collapse collapse">
																		<div class="panel-body">
																			<div class="text-right">
																				<div class="checkbox" align="right">
																					<label style="color:red;">
																						<input class="banner_groupall" id="groupall_<?php echo $banner_info["banner_gid"]; ?>" type="checkbox" <?php if($check_all=="Y"){echo "checked";} ?>> 
																						เลือกทั้งหมด
																						<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
																					</label>
																				</div>
																			</div>

																			<div class="col-md-12 col-sm-12 col-xs-12" id="table-view">

																				<div class="col-md-12 d-flex flex-center flex-wrap">
																				<?php
																				foreach($bannerlist_array[$banner_info["banner_gid"]] AS $bannerlist){
																				?>
																					<div class="col-md-2 col-sm-2 col-xs-6 m-b-sm">
																						<div class="card m-b-sm DivCategoryLevel1" style="width:100%;height:240px;max-height:240px;">
																							<div class="card-body">
																							<img src="../ewt/<?php echo $EWT_FOLDER_USER; ?>/<?php echo $bannerlist["banner_pic"]; ?>" style="width:100%;height:auto;max-height:160px;background-color:#b4b4b4;" class=" m-b-sm">
																								
																								<div class="checkbox" align="center">
																									<label>
																										<input class="banner_group_<?php echo $banner_info["banner_gid"]; ?> banner_append" type="checkbox" 
																											   id="banner_append_<?php echo $bannerlist["banner_id"]; ?>"
																										       value="<?php echo $bannerlist["banner_id"]; ?>" 
																											   <?php if(in_array($bannerlist["banner_id"],$bannerlistuse_array)){echo "checked";} ?>> 
																										<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
																									</label>
																								</div>
																							</div>
																						</div>
																					</div>
																				<?php
																				}
																				?>
																				</div>

																			</div>
																		</div>
																	</div>
																</div>
																<?php
																	$u++;
																}
																?>

															</div>
															
															
														</div>
													</div>
												</div>

												<div class="form-group row">
													<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
														<div>
															<label ><b>กำหนดลำดับ Banner <span class="text-danger"><code>*</code></span> : </b></label>        
														</div>
														<div class="col-md-12 col-sm-12 col-xs-12" id="table-view">

															<div id="remove_all_bannerorder" class="text-right" style="margin-bottom:10px;" <?php if(count($bannerlistuse_array)==0){echo "hidden";} ?>>
																<button type="button" class="btn btn-danger" onclick="remove_allusebanner();">ลบทั้งหมด</button>
															</div>

															<div id="sort_bannerorder" class="col-md-12 d-flex flex-center flex-wrap ui-sortable">
																
																<?php
																$n_order = 1;
																foreach($bannerlistuse_array AS $bannerlistuse){
																	$this_banner = $bannerlist1_array[$bannerlistuse];
																?>
																	<div class="col-md-2 col-sm-2 col-xs-6 m-b-sm move ui-sortable-handle" id="banner_use_<?php echo $bannerlistuse; ?>" >
																		<div class="card m-b-sm DivBannerUse" id="<?php echo $bannerlistuse; ?>" style="width:100%;height:240px;max-height:240px;">
																			<div class="card-body" style="height:200px;max-height:200px;">
																				<img src="../ewt/<?php echo $EWT_FOLDER_USER; ?>/<?php echo $this_banner["banner_pic"]; ?>" style="width:100%;height:auto;max-height:160px;background-color:#b4b4b4;" class=" m-b-sm">
																			</div>
																			<div align="center">
																				<input class="banner_order input-inline-sm text-center" name="banner_order[]" type="text" value="<?php echo $n_order; ?>"="">
																				<input type="hidden" name="banner_use[]" value="<?php echo $bannerlistuse; ?>">
																				<nobr>
																					<button type="button" class="btn btn-danger  btn-circle  btn-xs " onclick="remove_usebanner('<?php echo $bannerlistuse; ?>');">
																					<i class="far fa-trash-alt" aria-hidden="true"></i>
																					</button>
																				</nobr>
																			</div>
																		</div>
																	</div>
																<?php
																	$n_order++;
																}
																?>
															</div>

														</div>

													</div>
												</div>

											</div>
											<?php
											}
											?>

											<hr></hr>

											<div class="form-group row">
												<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12" style="margin-bottom:30px;">
													<label for="date_start"><b>วันเริ่มต้น  <span class="text-danger"><code>*</code></span> : </b></label>        
													<div class="input-group date datepicker" id="datetimepicker2">
														<input name="date_start" id="date_start" type="text" placeholder="__/__/____" class="form-control form-control-sm " value="<?php echo $show_start;?>">
														<span class="input-group-addon">
															<a href="#date" onclick="return show_calendar('intro_form.date_start');">
															<i class="far fa-calendar-alt"></i>
															</a>
														</span>
													</div>
												</div>
												<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12" style="margin-bottom:30px;">
													<label for="date_end"><b>วันสิ้นสุด  <span class="text-danger"><code>*</code></span> : </b></label>           
													<div class="input-group date datepicker" id="datetimepicker2">
														<input name="date_end" id="date_end" type="text" placeholder="__/__/____" class="form-control form-control-sm " value="<?php echo $show_end;?>">
														<span class="input-group-addon">
															<a href="#date" onclick="return show_calendar('intro_form.date_end');">
															<i class="far fa-calendar-alt"></i>
															</a>
														</span>
													</div>
												</div>
											</div>
											<div id="date_check_interval"></div>

											<hr></hr>

											<div class="form-group row">
												<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center;">
													<button type="button" id="intro_submit" class="btn btn-success">บันทึก</button>
													<input name="intro_id" type="hidden" value="<?php echo $intro_id; ?>">
													<input name="flag" type="hidden" value="<?php echo $flag; ?>">
												</div>	 
											</div>
										</form>

									</div>
								</div>
							</div>
							<?php
							}
							?>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>



<!-- END CONTAINER  -->
<?php
include("../EWT_ADMIN/combottom.php");
?>                                                                                                                                                                                    <script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui-touch-punch.min.js"></script>

<script >


$(function  () {
	$("#sort_bannerorder").sortable({
		placeholder: 'col-md-2 col-sm-2 col-xs-6 m-b-sm drop-placeholder-banner',
		update: function (event, ui) {		
			$('.banner_order').each(function(i, obj) {
				$('.banner_order').eq(i).val(i+1);
			});
		}
	});
});	

$(document).ready(function() {
	var today = new Date();
	$('.datepicker')		
			.datepicker({
				format: 'dd/mm/yyyy',
				language: 'th-th',
				//thaiyear: true,
				leftArrow: '<i class="fas fa-angle-double-left"></i>',
				rightArrow: '<i class="fas fa-angle-double-right"></i>',
			})
			//.datepicker("setDate", "0"); 
			//.datepicker("setDate", today.toLocaleDateString());  	

	
	/*$('input[name="intro_type"]').change(function(){
		check_date();
	})
	$("#date_start").change(function(){
		check_date();
	})
	$("#date_end").change(function(){
		check_date();
	})*/

	$("#intro_submit").click(function(){
		$("#date_check_interval").html("");
		//$("#intro_submit").prop("disabled",true);
		var formData = new FormData($("#intro_form")[0]);
		$.ajax({  
			url:"intro_function.php",  
			method:"post",  
			data: formData,
			processData: false,
			contentType: false,
			success:function(data){
				//console.log(data);
				if(data[0].flag=="error"){
					$.alert({
						title: data[0].data_array.title,
						content: data[0].data_array.content,
						icon: 'fa fa-exclamation-circle',
						theme: 'modern',                          
						type: 'orange',
						closeIcon: false,						
						buttons: {
							close: {
								text: 'ปิด',
								btnClass: 'btn-orange',
							}
						},						
					});	
					
					//focus on specific input
					//alert(data[0].data_array.focus);

					$("#intro_submit").on("focusin", function() {
						if(data[0].data_array.focus!=""){
							$("#"+data[0].data_array.focus).focus();
						}
						$("#intro_submit").off("focusin");
					});
					
					//$("#intro_submit").prop("disabled",false);
					//$("#intro_submit").focus();
					
				}
				else if(data[0].flag=="interval_error"){
					$.alert({
						title: data[0].data_array.title,
						content: data[0].data_array.content,
						icon: 'fa fa-exclamation-circle',
						theme: 'modern',                          
						type: 'orange',
						closeIcon: false,						
						buttons: {
							close: {
								text: 'ปิด',
								btnClass: 'btn-orange',
							}
						},						
					});	

					$("#date_check_interval").html(data[0].data_array.list);
				}
				else if(data[0].flag=="success"){
					location.href=data[0].data_array.return;
				}
			}
		})
	})
});

	$(".introtype_option").click(function(){
		var introtype = $(this).val();
		if(introtype=="page"){
			$("#introtype_page_section").prop("hidden",false);
			$("#introtype_popup_section").prop("hidden",true);
		}
		else if(introtype=="popup"){
			$("#introtype_page_section").prop("hidden",true);
			$("#introtype_popup_section").prop("hidden",false);
		}
	})
	
	function add_buttonset(){
		var current = parseInt($("#current_button").val())+1;
		$("#current_button").val(current);
		$.ajax({  
			url:"intro_function.php",  
			method:"post",  
			data: {flag:"add_button",current:current},
			success:function(data){
				$("#button_set_area").append(data);
				$('.buttonset_no').each(function(i, obj) {
					$('.buttonset_no').eq(i).html(i+1);
				});
			}
		})

	}

	function remove_buttonset(set_id){
		$("#"+set_id).remove();
		$('.buttonset_no').each(function(i, obj) {
			$('.buttonset_no').eq(i).html(i+1);
		});
	}

	function remove_usebanner(banner_id){
		$("#banner_use_"+banner_id).remove();
		$('.banner_order').each(function(i, obj) {
			$('.banner_order').eq(i).val(i+1);
		});
		$("#banner_append_"+banner_id).prop("checked",false);
	}

	function remove_allusebanner(){
		$("#remove_all_bannerorder").prop("hidden",true);
		$("#sort_bannerorder").html("");
		$(".banner_append").prop("checked",false);
		$(".banner_groupall").prop("checked",false);
	}

	/*function check_date(){
		$("#date_check_interval").html("");
		var date_start = $("#date_start").val();
		var date_end   = $("#date_end").val();
		var intro_type = $('input[name="intro_type"]:checked').val();
		var intro_id  = "<?php //echo $intro_id; ?>";

		$.ajax({  
			url:"intro_function.php",  
			method:"post",  
			data: {flag:"check_date",date_start:date_start,date_end:date_end,intro_type:intro_type,intro_id:intro_id},
			success:function(data){

				if(data[0].flag=="date_error"){
					$.alert({
						title: data[0].data_array.title,
						content: data[0].data_array.content,
						icon: 'fa fa-exclamation-circle',
						theme: 'modern',                          
						type: 'orange',
						closeIcon: false,						
						buttons: {
							close: {
								text: 'ปิด',
								btnClass: 'btn-orange',
							}
						},						
					});	
				}
				else if(data[0].flag=="interval_error"){
					$.alert({
						title: data[0].data_array.title,
						content: data[0].data_array.content,
						icon: 'fa fa-exclamation-circle',
						theme: 'modern',                          
						type: 'orange',
						closeIcon: false,						
						buttons: {
							close: {
								text: 'ปิด',
								btnClass: 'btn-orange',
							}
						},						
					});	

					$("#date_check_interval").html(data[0].data_array.list);
				}
			}
		})
	}*/

	$(".banner_groupall").click(function(){
		var banner_gid = $(this).attr("id").replace("groupall_","");
		if($(this).is(':checked')){
			
			$(".banner_group_"+banner_gid).each(function(i, obj) {
				var banner_id = $(".banner_group_"+banner_gid).eq(i).val();
				
				//append all selected
				if(!$(".banner_group_"+banner_gid).eq(i).is(':checked')){
					$(".banner_group_"+banner_gid).eq(i).prop("checked",true);
					$.ajax({  
						url:"intro_function.php",  
						method:"post",  
						data: {flag:"add_banneruse",banner_id:banner_id},
						success:function(data){
							$("#sort_bannerorder").append(data);
							$('.banner_order').each(function(i, obj) {
								$('.banner_order').eq(i).val(i+1);
							});
							$("#remove_all_bannerorder").prop("hidden",false);
						}
					})
				}
			});
		}
		else{
			
			$(".banner_group_"+banner_gid).each(function(i, obj) {
				var banner_id = $(".banner_group_"+banner_gid).eq(i).val();
				//remove all deselected
				$("#banner_use_"+banner_id).remove();
				$(".banner_group_"+banner_gid).eq(i).prop("checked",false);
			});
			$('.banner_order').each(function(i, obj) {
				$('.banner_order').eq(i).val(i+1);
			});
		}
	})

	$(".banner_append").click(function(){
		var banner_id = $(this).val();
		
		if($(this).is(':checked')){
			$.ajax({  
				url:"intro_function.php",  
				method:"post",  
				data: {flag:"add_banneruse",banner_id:banner_id},
				success:function(data){
					$("#sort_bannerorder").append(data);
					$('.banner_order').each(function(i, obj) {
						$('.banner_order').eq(i).val(i+1);
					});
					$("#remove_all_bannerorder").prop("hidden",false);
				}
			})
		}
		else{
			//$(".banner_group_"+banner_gid).prop("checked",false);
			$("#banner_use_"+banner_id).remove();
			$('.banner_order').each(function(i, obj) {
				$('.banner_order').eq(i).val(i+1);
			});
		}
	})
</script>


<style>

.panel-default > .panel-heading {
    /*color: #FFFFFF;*/
    /*background-color: #FFC153 ;*/
	background-color: #FFFFFF ;
    border-color: #ddd;
}
    .faqHeader {
        font-size: 27px;
        margin: 20px;
    }
    .panel-heading [data-toggle="collapse"]:after {
		font-family: 'Font Awesome 5 Free';
		font-weight: 900;
        content: "\f105"; /* "play" icon */
        float: right;
        color: #FFC153;
        font-size: 24px;
        line-height: 22px;
        /* rotate "play" icon from > (right arrow) to down arrow */
        -webkit-transform: rotate(-90deg);
        -moz-transform: rotate(-90deg);
        -ms-transform: rotate(-90deg);
        -o-transform: rotate(-90deg);
        transform: rotate(-90deg);
	
    }
    .panel-heading [data-toggle="collapse"].collapsed:after {
        /* rotate "play" icon from > (right arrow) to ^ (up arrow) */
        -webkit-transform: rotate(90deg);
        -moz-transform: rotate(90deg);
        -ms-transform: rotate(90deg);
        -o-transform: rotate(90deg);
        transform: rotate(90deg);
        color: #454444;
    }
	
.ewt-icon-wrap {
	margin: 0 auto;
}
.ewt-icon {
	display: inline-block;
	font-size: 0px;
	cursor: pointer;
	_margin: 15px 15px;
	width: 30px;
	height: 30px;
	border-radius: 50%;
	text-align: center;
	position: relative;
	z-index: 1;
	color: #fff;
}

.ewt-icon:after {
	pointer-events: none;
	position: absolute;
	width: 100%;
	height: 100%;
	border-radius: 50%;
	content: '';
	-webkit-box-sizing: content-box; 
	-moz-box-sizing: content-box; 
	box-sizing: content-box;
}
.ewt-icon:before {
	font-family: 'Font Awesome 5 Free';
	font-weight: 900;
	speak: none;
	font-size: 18px;
	line-height: 30px;
	font-style: normal;
	_font-weight: normal;
	font-variant: normal;
	text-transform: none;
	display: block;
	-webkit-font-smoothing: antialiased;
}
.ewt-icon-edit:before {
	content: "\f044";
}
.ewt-icon-del:before {
	content: "\f2ed";
}
.ewt-icon-view:before {
	content: "\f06e";
}
.ewt-icon-print:before {
	content: "\f02f";
}
/* Effect 1 */
.ewt-icon-effect-1 .ewt-icon {
	background: rgba(255,255,255,0.1);
	-webkit-transition: background 0.2s, color 0.2s;
	-moz-transition: background 0.2s, color 0.2s;
	transition: background 0.2s, color 0.2s;
}
.ewt-icon-effect-1 .ewt-icon:after {
	top: -7px;
	left: -7px;
	padding: 7px;
	box-shadow: 0 0 0 4px #fff;
	-webkit-transition: -webkit-transform 0.2s, opacity 0.2s;
	-webkit-transform: scale(.8);
	-moz-transition: -moz-transform 0.2s, opacity 0.2s;
	-moz-transform: scale(.8);
	-ms-transform: scale(.8);
	transition: transform 0.2s, opacity 0.2s;
	transform: scale(.8);
	opacity: 0;
}
/* Effect 1a */
.ewt-icon-effect-1a .ewt-icon:hover {
	background: rgba(255,255,255,1);
	color: #41ab6b;
}
.ewt-icon-effect-1a .ewt-icon:hover:after {
	-webkit-transform: scale(1);
	-moz-transform: scale(1);
	-ms-transform: scale(1);
	transform: scale(1);
	opacity: 1;
}
/* Effect 1b */
.ewt-icon-effect-1b .ewt-icon:hover{
	background: rgba(255,255,255,1);
	color: #41ab6b;
}
.ewt-icon-effect-1b .ewt-icon:after {
	-webkit-transform: scale(1.2);
	-moz-transform: scale(1.2);
	-ms-transform: scale(1.2);
	transform: scale(1.2);
}
.ewt-icon-effect-1b .ewt-icon:hover:after {
	-webkit-transform: scale(1);
	-moz-transform: scale(1);
	-ms-transform: scale(1);
	transform: scale(1);
	opacity: 1;
}
.drop-placeholder {
	background-color: #f6f3f3 !important;
	height: 3.5em;
	padding-top: 12px;
	padding-bottom: 12px;
	line-height: 1.2em;
	border: 3px dotted #cccccc !important;
}

</style>

