<?php
include("../EWT_ADMIN/comtop.php");
?>  

<!-- START CONTAINER  -->
<div class="container-fluid" >
<?php
if($db->check_permission("layout","w","")){
	$has_pass_w='Y';	
}

if($db->check_permission("layout","a","")){
	$has_pass_a='Y';	
}

$module_data = $db->query("SELECT m_image FROM $EWT_DB_USER.web_module_ewt WHERE m_code = 'layout'");
$module_info = $db->db_fetch_array($module_data);

$EWT_module_name      = "Site Layout Management";
$EWT_module_icon      = $module_info["m_image"];
$EWT_module_subarray  = array(array("name"=>"ตั้งค่าเทมเพลต","url"=>"../SiteLayoutMgt/layout_index.php"));

include("../include/module_header.php");

$perpage = 10;
$page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);
if($page <= 0) $page = 1;
$start = ($page * $perpage) - $perpage;
##=============================================================================================================##
$where = " WHERE template_use = 'Y'";
$search_pagin = "";
/*
if($_GET["search"]=="Y"){
	
	$search_pagin .= "search=Y&";

	$template_name = trim($_GET['template_name']);
	$search_pagin .= "template_name=".ready($_GET["template_name"])."&";

	if($template_name != ""){
		$find = ready($template_name);
		$where .= " AND template_name LIKE '%$find%' ";
	}
}
else{
	$search_pagin = "&";
}*/

##=============================================================================================================##

## >> Get Template List - Total
$statement    = "SELECT COUNT(template_id) AS b  FROM site_management_template $where";
$template_data   = $db->query($statement);
$template_info   = $db->db_fetch_array($template_data);
$total_result = $template_info["b"];

## >> Get Template List
$template_data   = $db->query("SELECT * FROM site_management_template $where ORDER BY template_name ASC LIMIT $start,$perpage");

## >> Lang list
$template_lang_array = array();
$template_lang_data  = $db->query("SELECT lang_id,template_id FROM site_management");
while($template_lang_info = $db->db_fetch_array($template_lang_data)){
	if(!is_array($template_lang_array[$template_lang_info["template_id"]])){
		$template_lang_array[$template_lang_info["template_id"]] = array();
	}
	array_push($template_lang_array[$template_lang_info["template_id"]],$template_lang_info["lang_id"]);
}

## >> Lang
$s_lang_array = array();
$s_lang_array["list"] = array();
$s_lang_config = $db->query("SELECT lang_config_id,lang_config_name,lang_config_id,lang_config_suffix,lang_config_img FROM lang_config ORDER BY lang_config_id ASC");
while($s_lang_info = $db->db_fetch_array($s_lang_config)){
	$s_lang_array[$s_lang_info["lang_config_id"]]=$s_lang_info;
	array_push($s_lang_array["list"],$s_lang_info["lang_config_id"]);
}
?>

<div id="nav" style="position:absolute;width:400px;  z-index:1;display:none"></div>
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
								echo "ตั้งค่าเทมเพลต";
								?>
							</h4>
							<p></p> 
						</div>

						<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >

							<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  >
								<?php
								/*if($flag=="template_page"){
								?>
								<a href="template_manage.php?flag=add&type=template_page" target="_self">  
									<button type="button" class="btn btn-info  btn-sm"    title="เพิ่ม Intro"  >
									<i class="fas fa-plus-circle"></i>&nbsp;เพิ่ม Intro Page
									</button>
								</a>	
								<button type="button" class="btn btn-primary btn-sm search_module_button">
									<i class="fas fa-search"></i>&nbsp;ค้นหา Intro
								</button>
								<?php
								}
								else if($flag=="popup"){
								?>
								<a href="template_manage.php?flag=add&type=popup" target="_self">  
									<button type="button" class="btn btn-info  btn-sm"    title="เพิ่ม Intro"  >
									<i class="fas fa-plus-circle"></i>&nbsp;เพิ่ม Pop-Up
									</button>
								</a>	
								<button type="button" class="btn btn-primary btn-sm search_module_button">
									<i class="fas fa-search"></i>&nbsp;ค้นหา Pop-Up
								</button>
								<?php
								}*/
								?>
							</div>

							<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs"  >
								<div class="btn-group">
									<button type="button" data-toggle="dropdown" class="btn btn-info   btn-sm dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span></button>
									<ul class="dropdown-menu dropdown-menu-right">
										
										<?php
										/*if($flag=="template_page"){
										?>
										<li><a href="template_manage.php?flag=add&type=template_page" target="_self"> <i class="fas fa-plus-circle"></i>&nbsp;เพิ่ม Intro Page</a></li>
										<li><a href="javascript:void(0);" class="search_module_button"><i class="fas fa-search"></i>&nbsp;ค้นหา Intro</a></li>
										<?php
										}
										else if($flag=="popup"){
										?>
										<li><a href="template_manage.php?flag=add&type=popup" target="_self"> <i class="fas fa-plus-circle"></i>&nbsp;เพิ่ม Pop-Up</a></li>
										<li><a href="javascript:void(0);" class="search_module_button"><i class="fas fa-search"></i>&nbsp;ค้นหา Pop-Up</a></li>
										<?php
										}*/
										?>
									</ul>
								</div>
							</div>	

						</div>
						
					</div>
				</div>
				<!--END card-header -->
				<form action="layout_function.php" method="post" id="template_form">
					<input type="hidden" id="template_flag" name="flag" value="">

					<div class="card-body">
						<div id="nav" style="position:absolute;width:400px;  z-index:1;display:none" ></div>
							<div class="row ">

							<!--<div class="clearfix">&nbsp;</div>-->
							<div class="col-md-12 col-sm-12 col-xs-12" id="table-view" >

								<div class="table-responsive"	style="overflow: visible;">	  
									<table width="100%" border="0"  align="center" class="table table-bordered " id="sortableLv1">
										<thead>
											<tr class="success">
												<!-- <th width="10%" class="text-center"></th> -->
												<th width="40%" class="text-center">
													<?php
														echo "ชื่อ Template";	
													?>
												</th>
												<th width="10%" class="text-center">ตั้งค่าเทมเพลต</th>
												<th width="10%" class="text-center">ใช้งาน</th>
											</tr>
										</thead>

										<?php
										if($total_result>0){
										?>
										<tbody>
											<?php
											$count_approvable = 0;
											$count_delete     = 0;

											while($template_info = $db->db_fetch_array($template_data)){

												if($has_pass_w=="Y"){
													$pass_w = "Y";
												}
												if($has_pass_a=="Y"){
													$pass_a = "Y";
												}
												
												$template_use = "";
												if($template_info["template_use"]=="Y"){
													$template_use = "checked";
												}
											?>
											<tr class="productCategoryLevel1-td"> 
												<!-- <td class="text-center">
													<nobr>

														<?php
														if($pass_w=="Y"){
														?>

														<a onClick="txt_data3('<?php echo $template_info["template_id"]; ?>','')" >
															<button type="button" class="btn btn-info  btn-circle  btn-xs " id="lang<?php echo $N['n_id'];?>" data-toggle="tooltip" data-placement="top" title="<?php echo $txt_ewt_create_multilang?>" >
															<i class="fa fa-language" aria-hidden="true"></i>
															</button>
														</a>

														<?php /*<a href="layout_edit.php?template_id=<?php echo $template_info["template_id"]; ?>" >
															<button type="button" class="btn btn-warning  btn-circle  btn-xs " 
																	data-toggle="tooltip" data-placement="top" title="<?php echo "แก้ไข Layout"; ?>" >
															<i class="fa fa-edit" aria-hidden="true"></i>
															</button>
														</a> */ ?>

														<?php
														}
														?>
													</nobr>
												</td> -->

												<td class="text-center"> 
													<h5>
														<div style="margin-bottom:15px;"><img src="template_image/<?php echo $template_info["template_image"]; ?>" style="width:150px;"></div>
														<div><?php echo $template_info["template_name"]; ?></div> 
													</h5> 
												</td>

												<td class="text-center"> 
													<!-- <?php
													if($pass_w=="Y"){
													?>
														<?php 
														foreach($template_lang_array[$template_info["template_id"]] AS $template_lang){
															if(in_array($template_lang,$s_lang_array["list"])){
															$lang = $s_lang_array[$template_lang];
															?>
																<a href="#" data-toggle="tooltip" data-placement="top" title="" 
																onclick="txt_data_edit('<?php echo $template_info["template_id"]; ?>','<?php echo $lang["lang_config_id"]; ?>','<?php echo $lang["lang_config_suffix"]; ?>')" data-original-title="<?php echo $lang["lang_config_name"]; ?>">
																<img src="../ewt/gistda_web/language/<?php echo $lang["lang_config_img"]; ?>" border="0" 
																		width="22px" height="18px" alt="<?php echo $lang["lang_config_suffix"]; ?>">
																</a>
															<?php
															}
														}
														?>
														
													<?php
													}
													?> -->
													<a href="layout_edit.php?template_id=<?php echo $template_info["template_id"]; ?>">
														<i class="fa fa-cog fa-2x" aria-hidden="true"></i>
													</a>
												</td>

												<td class="text-center"> 
													<?php
													if($pass_a=="Y"){
														$count_approvable++;
													?>
														<div class="radio">
															<label>
																<input class="introtype_option" type="radio" name="template_use" value="<?php echo $template_info["template_id"]; ?>" <?php echo $template_use; ?>>
																<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
															</label>
														</div>

														
													<?php
													}
													else{
														if($template_info["template_use"]=="Y"){
														?><img src="../theme/main_theme/g_approve.gif" border="0" align="absmiddle" alt="อนุมัติแล้ว"><?php
														}
													}
													?>
												</td>
											</tr>
											<?php
											}
											?>

											</tbody>
											<tfoot>
												<tr class="ui-state-default" > 
													<td colspan="2" valign="top">&nbsp;<a id="#bottom"></a></td>

													<td class="text-center" <?php echo $disabled1;?>>
														<?php if($count_approvable>0){ ?>
														<button type="button" class="btn btn-success  btn-ml" id="template_approve_button">
														<i class="fas fa-cog"></i>&nbsp;อนุมัติ
														</button>
														<?php } ?>
													</td>
												</tr>
											</tfoot>

											<?php 
											}
											else{
											?>

											<tr class="ui-state-default" > 
												<td colspan="4" class="text-center">
												<h4 >
												<p class="text-danger"><?php echo $txt_ewt_data_not_found;?></p>
												</h4>
												</td>
											</tr>
											<?php
											}
											?>

										</tbody>
									</table>
								</div>
							</div>
						</div>
						
						<?php echo pagination_ewt($statement,$perpage,$page,'?'.$search_pagin);?>	
					</div>
				</form>
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
<script>
	$("#template_approve_button").click(function(){
		$("#template_flag").val("approve");
		$("#template_form").submit();
	})

	/*$("#template_delete_button").click(function(){
		$("#template_flag").val("delete");
		$("#template_form").submit();
	})*/

	function txt_data3(w,g) {	
		$.ajax({
		type: 'GET',
		url: 'pop_set_lang_list.php?id='+g+'&id='+w,
		beforeSend: function() {
			$('#box_popup').html('');
		},
			success: function (data) {
				$('#box_popup').html(data);
			}
			
		}); 
		
		$('#box_popup').fadeIn();	
	}

	
	function txt_data2(w,g,lang) {

		$('#box_popup').fadeOut();	
		location.href='layout_add.php?template_id='+w+'&lang_id='+g;
	}

	function txt_data_edit(w,g,lang) {
		location.href='layout_edit.php?template_id='+w+'&lang_id='+g;
	}
</script>

<?php
## >> Include search modal
/*
if($flag=="template_page"){
	$search_button_class = "search_module_button";
	$search_title        = "ค้นหา Intro Page";
	$search_action       = "../IntroMgt/template_index.php";
	$search_parameter    = array(array("name"=>"flag",
									   "type"=>"hidden",
									   "label"=>""),
								 array("name"=>"template_name",
									   "type"=>"text",
									   "label"=>"ชื่อ Intro Page"));
}
else if($flag=="popup"){
	$search_button_class = "search_module_button";
	$search_title        = "ค้นหา Pop-Up";
	$search_action       = "../IntroMgt/template_index.php";
	$search_parameter    = array(array("name"=>"flag",
									   "type"=>"hidden",
									   "label"=>""),
								 array("name"=>"template_name",
									   "type"=>"text",
									   "label"=>"ชื่อ Pop-Up"));
}

include "../include/module_search.php";*/
?>