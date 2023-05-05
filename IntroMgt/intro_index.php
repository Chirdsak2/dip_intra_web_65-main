<?php
include("../EWT_ADMIN/comtop.php");
?>  

<!-- START CONTAINER  -->
<div class="container-fluid" >
<?php
if(!in_array($_GET["flag"],array("intro_page","popup"))){
	$_GET["flag"] = "intro_page";
}

$flag = $_GET["flag"];

if($db->check_permission("intro","w","")){
	$has_pass_w='Y';	
}
if($db->check_permission("intro","a","")){
	$has_pass_a='Y';	
}


$module_data = $db->query("SELECT m_image 
                           FROM   $EWT_DB_USER.web_module_ewt
                           WHERE  m_code = 'intro'");
$module_info = $db->db_fetch_array($module_data);

$EWT_module_name      = "Intro Management";
$EWT_module_icon      = $module_info["m_image"];
$EWT_module_subarray  = array(array("name"=>"บริหาร Intro Page","url"=>"../IntroMgt/intro_index.php?flag=intro_page"),
							  array("name"=>"บริหาร Pop-Up","url"=>"../IntroMgt/intro_index.php?flag=popup"));


include("../include/module_header.php");

$perpage = 10;
$page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);
if($page <= 0) $page = 1;
$start = ($page * $perpage) - $perpage;
##=============================================================================================================##
$where = " WHERE 1=1 ";
$search_pagin = "";

if($flag=="intro_page"){
	$where .= " AND intro_type LIKE 'page' ";
	$search_pagin .= "flag=intro_page&";
}
else if($flag=="popup"){
	$where .= " AND intro_type LIKE 'popup' ";
	$search_pagin .= "flag=popup&";
}

if($_GET["search"]=="Y"){
	
	$search_pagin .= "search=Y&";

	$intro_name = trim($_GET['intro_name']);
	$search_pagin .= "intro_name=".ready($_GET["intro_name"])."&";

	if($intro_name != ""){
		$find = ready($intro_name);
		$where .= " AND intro_name LIKE '%$find%' ";
	}
}
else{
	$search_pagin = "&";
}

##=============================================================================================================##

## >> Get Intro List - Total
$statement    = "SELECT COUNT(intro_id) AS b  FROM intro_list $where";
$intro_data   = $db->query($statement);
$intro_info   = $db->db_fetch_array($intro_data);
$total_result = $intro_info["b"];

## >> Get Intro List - Total
$intro_data   = $db->query("SELECT * FROM intro_list 
							$where
							ORDER BY intro_show_start DESC, intro_show_end DESC LIMIT $start,$perpage");

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
								if($flag=="intro_page"){
									echo "บริหาร Intro Page";	
								} 
								else if($flag=="popup"){
									echo "บริหาร Pop-Up";
								}
								?>
							</h4>
							<p></p> 

						</div>

						<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm" >

							<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs"  >
								<?php
								if($flag=="intro_page"){
								?>
								<a href="intro_manage.php?flag=add&type=intro_page" target="_self">  
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
								<a href="intro_manage.php?flag=add&type=popup" target="_self">  
									<button type="button" class="btn btn-info  btn-sm"    title="เพิ่ม Intro"  >
									<i class="fas fa-plus-circle"></i>&nbsp;เพิ่ม Pop-Up
									</button>
								</a>	
								<button type="button" class="btn btn-primary btn-sm search_module_button">
									<i class="fas fa-search"></i>&nbsp;ค้นหา Pop-Up
								</button>
								<?php
								}
								?>
							</div>

							<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs"  >
								<div class="btn-group">
									<button type="button" data-toggle="dropdown" class="btn btn-info   btn-sm dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span></button>
									<ul class="dropdown-menu dropdown-menu-right">
										
										<?php
										if($flag=="intro_page"){
										?>
										<li><a href="intro_manage.php?flag=add&type=intro_page" target="_self"> <i class="fas fa-plus-circle"></i>&nbsp;เพิ่ม Intro Page</a></li>
										<li><a href="javascript:void(0);" class="search_module_button"><i class="fas fa-search"></i>&nbsp;ค้นหา Intro</a></li>
										<?php
										}
										else if($flag=="popup"){
										?>
										<li><a href="intro_manage.php?flag=add&type=popup" target="_self"> <i class="fas fa-plus-circle"></i>&nbsp;เพิ่ม Pop-Up</a></li>
										<li><a href="javascript:void(0);" class="search_module_button"><i class="fas fa-search"></i>&nbsp;ค้นหา Pop-Up</a></li>
										<?php
										}
										?>
									</ul>
								</div>
							</div>	

						</div>
						
					</div>
				</div>
				<!--END card-header -->
				<form action="intro_function.php" method="post" id="intro_form">
					<input type="hidden" id="intro_flag" name="flag" value="">
					<input type="hidden" id="intro_type" name="type" value="<?php echo $flag; ?>"> 

					<div class="card-body">
						<div id="nav" style="position:absolute;width:400px;  z-index:1;display:none" ></div>
							<div class="row ">

							<!--<div class="clearfix">&nbsp;</div>-->
							<div class="col-md-12 col-sm-12 col-xs-12" id="table-view" >

								<div class="table-responsive"	style="overflow: visible;">	  
									<table width="100%" border="0"  align="center" class="table table-bordered " id="sortableLv1">
										<thead>
											<tr class="success">
												<th width="10%" class="text-center"></th>
												<th width="40%" class="text-center">
													<?php
													if($flag=="intro_page"){
														echo "ชื่อ Intro Page";	
													} 
													else if($flag=="popup"){
														echo "ชื่อ Pop-Up";
													}
													?>
												</th>
												<th width="10%" class="text-center">เริ่มต้น</th>
												<th width="10%" class="text-center">สิ้นสุด</th>
												<th width="10%" class="text-center">ใช้งาน</th>
												<th width="10%" class="text-center">ลบ</th>
											</tr>
										</thead>

										<?php
										if($total_result>0){
										?>
										<tbody>
											<?php
											$count_approvable = 0;
											$count_delete     = 0;

											while($intro_info = $db->db_fetch_array($intro_data)){

												if($has_pass_w=="Y"){
													$pass_w = "Y";
												}
												if($has_pass_a=="Y"){
													$pass_a = "Y";
												}

												## >> Only super admin and intro owner can edit the intro
												if($pass_w == "Y" AND $intro_info['intro_owner'] != $_SESSION['EWT_SMID']){
													$pass_w='';
												}
												if($_SESSION['EWT_SMTYPE'] == "Y"){
													$pass_w = "Y";
												}

												## >> Only super admin and intro owner can approve the intro
												if($pass_a == "Y" AND $intro_info['intro_owner'] != $_SESSION['EWT_SMID']){
													$pass_a='';
												}
												if($_SESSION['EWT_SMTYPE'] == "Y"){
													$pass_a = "Y";
												}
												
												if($intro_info["intro_show_start"]=="0000-00-00"){
													$intro_info["intro_show_start"]="-";
												}
												else if($intro_info["intro_show_start"]!="" && filter_date("-",$intro_info["intro_show_start"])!=""){
													$show_start = explode("-",$intro_info["intro_show_start"]);
													$intro_info["intro_show_start"] = $show_start[2]."/".$show_start[1]."/".$show_start[0];
												}

												if($intro_info["intro_show_end"]=="0000-00-00"){
													$intro_info["intro_show_end"]="-";
												}
												else if($intro_info["intro_show_end"]!="" && filter_date("-",$intro_info["intro_show_end"])!=""){
													$show_end   = explode("-",$intro_info["intro_show_end"]);
													$intro_info["intro_show_end"]   = $show_end[2]."/".$show_end[1]."/".$show_end[0];
												}

												$intro_use = "";
												if($intro_info["intro_use"]=="Y"){
													$intro_use = "checked";
												}
											?>
											<tr class="productCategoryLevel1-td"> 
												<td class="text-center">
													<nobr>
														<a href="#view" onclick="window.open('../ewt/<?php echo $EWT_FOLDER_USER; ?>/intro-views-backend.php?intro_id=<?php echo $intro_info["intro_id"]; ?>');">
															<button type="button" class="btn btn-success  btn-circle  btn-xs " data-toggle="tooltip" data-placement="top" title="" data-original-title="ดูข้อมูล">
															<i class="fas fa-search" aria-hidden="true"></i>
															</button>
														</a>

														<?php
														if($pass_w=="Y"){
															if($flag=="intro_page"){
																$text_edit = "แก้ไข Intro Page";	
															} 
															else if($flag=="popup"){
																$text_edit = "แก้ไข Pop-Up";
															}
														?>

															<a href="intro_manage.php?flag=edit&intro_id=<?php echo $intro_info["intro_id"]; ?>" >
																<button type="button" class="btn btn-warning  btn-circle  btn-xs " 
																		data-toggle="tooltip" data-placement="top" title="<?php echo $text_edit; ?>" >
																<i class="fa fa-edit" aria-hidden="true"></i>
																</button>
															</a> 

														<?php
														}
														?>
													</nobr>
												</td>

												<td class="text-left"> 
													<h5>
														<?php 
														echo $intro_info["intro_name"]; 
														?> 
													</h5> 
												</td>

												<td class="text-center"> 
													<?php echo $intro_info["intro_show_start"]; ?>
												</td>
												<td class="text-center"> 
													<?php echo $intro_info["intro_show_end"]; ?>
												</td>

												<td class="text-center"> 
													<?php
													if($pass_a=="Y"){
														$count_approvable++;

														if($flag=="intro_page"){
													?>
														<div class="radio">
															<label>
																<input class="introtype_option" type="radio" name="intro_use" value="<?php echo $intro_info["intro_id"]; ?>" <?php echo $intro_use; ?>>
																<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
															</label>
														</div>
														<?php
														}
														else if($flag="popup"){
														?>
														
														<div class="checkbox">
															<label>
																<input name="intro_use[]" type="checkbox" value="<?php echo $intro_info["intro_id"]; ?>" <?php echo $intro_use; ?>> 
																<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
															</label>
															<input name="intro_notuse[]" type="hidden" value="<?php echo $intro_info["intro_id"]; ?>"> 
														</div>
														<?php
														}
														?>

													<input name="chkrssH<?php echo $i;?>" type="hidden" id="chkrssH<?php echo $i;?>" value="<?php echo $G['c_id']; ?>" /> 
													<?php
													}
													else{
														if($intro_info["intro_use"]=="Y"){
														?><img src="../theme/main_theme/g_approve.gif" border="0" align="absmiddle" alt="อนุมัติแล้ว"><?php
														}
													}
													?>
												</td>
												<td class="text-center" <?php echo $disabled1;?>>
													<?php
													if($pass_w=="Y"){
														$count_delete++;
													?>
													<div class="checkbox">
														<label>
															<input name="intro_delete[]" type="checkbox" value="<?php echo $intro_info["intro_id"]; ?>"> 
															<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
														</label>
													</div>
													<?php
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
													<td colspan="4" valign="top">&nbsp;<a id="#bottom"></a></td>

													<td class="text-center" <?php echo $disabled1;?>>
														<?php if($count_approvable>0){ ?>
														<button type="button" class="btn btn-success  btn-ml" id="intro_approve_button">
														<i class="fas fa-cog"></i>&nbsp;อนุมัติ
														</button>
														<?php } ?>
													</td>
													<td class="text-center" <?php echo $disabled1;?>>

														<?php if($count_delete>0){ ?>
														<button type="button" class="btn btn-danger  btn-ml " id="intro_delete_button">
														<i class="far fa-trash-alt"></i>&nbsp; ลบ Intro
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
												<td colspan="5" class="text-center">
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
	$("#intro_approve_button").click(function(){
		$("#intro_flag").val("approve");
		$("#intro_form").submit();
	})

	$("#intro_delete_button").click(function(){
		$("#intro_flag").val("delete");
		$("#intro_form").submit();
	})
</script>

<?php
## >> Include search modal

if($flag=="intro_page"){
	$search_button_class = "search_module_button";
	$search_title        = "ค้นหา Intro Page";
	$search_action       = "../IntroMgt/intro_index.php";
	$search_parameter    = array(array("name"=>"flag",
									   "type"=>"hidden",
									   "label"=>""),
								 array("name"=>"intro_name",
									   "type"=>"text",
									   "label"=>"ชื่อ Intro Page"));
}
else if($flag=="popup"){
	$search_button_class = "search_module_button";
	$search_title        = "ค้นหา Pop-Up";
	$search_action       = "../IntroMgt/intro_index.php";
	$search_parameter    = array(array("name"=>"flag",
									   "type"=>"hidden",
									   "label"=>""),
								 array("name"=>"intro_name",
									   "type"=>"text",
									   "label"=>"ชื่อ Pop-Up"));
}

include "../include/module_search.php";
?>