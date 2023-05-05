<?php
include("../EWT_ADMIN/comtop.php");
include("../class/module/article.class.php");
include("../class/module/banner.class.php");
include("../class/module/menu.class.php");
include("../class/module/org.class.php");

$article = new article();
$banner = new banner();
$menu = new menu();
$org = new org();

$banner_org = $banner->getBannerGroup();
$image_org = $banner->getBanner('42');
$menu_org = $menu->getMenuList();
$group_org = $article->getAricleSubGroup($_GET['cid']);
?>

<!-- START CONTAINER  -->
<div class="container-fluid">
	<?php
	include("menu-top.php");

	/*if(!(session_is_registered("EWT_OPEN_ARTICLE"))){
	session_register("EWT_OPEN_ARTICLE");
}*/
	$_SESSION["EWT_OPEN_ARTICLE"] = "";
	//$db->write_log("view","article","เข้าสู่ Module Add Article");
	if ($_GET["p"] != "") {
		$sql_article = $db->query("SELECT c_name FROM article_group WHERE c_id = '{$_GET['p']}' ");
		$P = $db->db_fetch_row($sql_article);
		$txt = "ภายใต้ " . $P[0];
	}

	function article_backto($cid)
	{
		global $db;
		$s_group = $db->query("SELECT * FROM article_group WHERE c_id = '{$cid}' ");
		if ($db->db_num_rows($s_group)) {
			$a_data = $db->db_fetch_array($s_group);
			if ($a_data['c_parent'] != "0") {
				$txt = "article_list.php?cid={$a_data['c_parent']}";
			} else {
				$txt = "article_group.php";
			}
		} else {
			$txt = "article_group.php";
		}
		return $txt;
	}
	?>
	<script>
		//self.parent.document.all.backon.style.display = 'none';
		//self.parent.document.all.backoff.style.display = '';
		//self.parent.document.all.folderoff.style.display = 'none';
		//self.parent.document.all.folderon.style.display = '';
		//self.parent.document.all.deloff.style.display = 'none';
		//self.parent.document.all.delon.style.display = '';
		function Chk(c) {
			if (document.form1.gname.value == "") {
				alert("กรุณาใส่ชื่อกลุ่ม");
				document.form1.gname.focus();
				return false;
			}
		}

		function choose_pic(c, d) {
			formPopUpBg.action = "../FileMgt/gallery_insert.php";
			window.open('', 'bg_popup', 'top=60,left=80,width=780,height=480,resizable=1,status=0');
			document.formPopUpBg.o_value.value = c;
			document.formPopUpBg.o_preview.value = d;
			document.formPopUpBg.Flag.value = "SetPic";
			formPopUpBg.submit();
		}
	</script>

	<?php
	$disabled1 = 'style="display:none"';
	$disabled2 = 'style="display:none"';
	if ($db->check_permission('art', 'w', '')) {
		$disabled1 = '';
	}
	if ($db->check_permission('art', 'a', '')) {
		$disabled2 = '';
	}
	$db->query("USE " . $_SESSION["EWT_SDB"]);
	?>

	<div class="row m-b-sm">
		<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">
			<!--start card -->
			<div class="card">
				<!--start card-header -->
				<div class="card-header">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">

							<h4><?= $txt_article_add_group; ?></h4>
							<p></p>

						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<ol class="breadcrumb">
									<li><a href="article_group.php"><?= $txt_article_group; ?></a></li>
									<li class=""><?= $txt_article_add_group; ?></li>
								</ol>
							</div>

							<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs">
								<!--<a href="article_gadd.php?p=0" target="_self">  
								<button type="button" class="btn btn-info  btn-ml"    title="<?= $txt_article_add_group; ?>"  >
								<i class="fas fa-plus-circle"></i>&nbsp;<?= $txt_article_add_group; ?>
								</button>
								</a>-->
								<a href="<?= article_backto($_GET['p']); ?>" target="_self">
									<button type="button" class="btn btn-info  btn-ml ">
										<i class="fas fa-undo-alt"></i>&nbsp;<?= $txt_ewt_back; ?>
									</button>
								</a>
							</div>

							<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs">
								<div class="btn-group ">
									<button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span></button>
									<ul class="dropdown-menu dropdown-menu-right">
										<li><a href="article_gadd.php?p=0" target="_self"> <i class="fas fa-plus-circle"></i>&nbsp;<?= $txt_complain_add_cate; ?></a></li>
										<li><a href="<?= article_backto($_GET['p']); ?>"><i class="fas fa-undo-alt"></i>&nbsp;<?= $txt_ewt_back; ?></a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--END card-header -->

				<div class="card-body">
					<div class="row ">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="card ">
								<div class="card-header ewt-bg-success m-b-sm">
									<div class="card-title text-left"></div>
								</div>
								<div class="card-body">
									<form name="formPopUpBg" method="post" action="" target="bg_popup">
										<input name="o_value" type="hidden" id="o_value" value="">
										<input name="o_preview" type="hidden" id="o_preview" value="">
										<input name="stype" type="hidden" id="stype" value="images">
										<input name="Flag" type="hidden" id="Flag" value="">
									</form>

									<form action="article_function.php" method="post" name="form1" id="form1" enctype="multipart/form-data">
										<div class="form-group row ">
											<label for="gname" class="col-sm-12 control-label"><b><?= $txt_article_group_name; ?> <span class="text-danger"><code>*</code></span> :</b></label>
											<div class="col-md-12 col-sm-12 col-xs-12">
												<textarea class="form-control" placeholder="<?= $txt_article_group_name; ?>" rows="3" id="gname" name="gname" required="required"></textarea>
											</div>
										</div>
										<?php
										$sql_group = $db->query("SELECT * FROM article_group WHERE c_id = '{$_GET['cid']}' ");
										$a_data_group = $db->db_fetch_array($sql_group);
										$gname = $a_data_group['c_name'];
										?>
										<div class="form-group row ">
											<label for="category_sub" class="col-sm-12 control-label"><b><?= "ตั้งค่าเป็นหมวดภายใต้หมวดอื่น"; ?> :</b></label>
											<div class="col-md-12 col-sm-12 col-xs-12">
												<div class="form-inline">
													<span id="txtshow"><?= $gname; ?></span>
													<a href="#browse" onClick="boxPopup('<?= linkboxPopup(); ?>pop_article_select.php?cid=<?= $cid; ?>');">
														<!--<a href="#browse" title="เลือกกลุ่ม" onClick="win2 = window.open('article_select.php?cid=<?= $_GET['cid']; ?>','WebsiteLink','top=100,left=100,width=800,height=600,resizable=1,status=0,scrollbars=1');win2.focus();">-->
														<button type="button" class="btn btn-info  btn-sm ">
															<i class="fas fa-folder-open"></i>&nbsp;เลือกกลุ่มข่าว
														</button>
													</a>
													<input name="c_parent" type="hidden" id="cid" value="<?= $_GET['cid']; ?>">
												</div>

												<?php /*<select name="category_parent" id="category_parent" class="form-control" style="display:none;" >
												<option value=""selected="" disabled="disabled" >เลือกหมวด</option> 
												<?php
												$_sql_faq = $db->query("SELECT faq_cate_id,faq_cate_title,faq_cate_parent FROM faq_category WHERE faq_cate_status = 'Y' ORDER BY faq_cate_order ASC,faq_cate_id ASC ");
												while($a_data_faq = $db->db_fetch_row($_sql_faq)){
													//$sel = ($a_data_faq[0] == trim($a_data['faq_cate_id'])) ? "selected":"";
													if($a_data_faq[2] != '0'){
														$nbsp = "&nbsp;&nbsp;&nbsp;";
													}else{
														$nbsp = "";
													}
												?>
												<option value="<?=$a_data_faq[0];?>" <?=$sel;?> ><?=$nbsp.$a_data_faq[1];?></option>
												<?php
												}
												?>		  
												</select>*/ ?>
											</div>
										</div>

										<!-- <div class="form-group row ">
											<label for="gtype" class="col-sm-12 control-label"><b><?= $txt_article_group_set_viewmore; ?> :</b></label>
											<div class="col-md-12 col-sm-12 col-xs-12"> -->
												<!-- <div class="checkbox">
													<label>
														<input name="gshowsearch" id="gshowsearch" type="checkbox" value="Y" checked/>
														<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span><?= $txt_article_group_show_search; ?>
													</label>
												</div> -->
												<!-- <input type="hidden" name="gshowsearch" id="gshowsearch" value="Y">
												<div class="checkbox">
													<label>
														<input name="gshowsub" id="gshowsub" type="checkbox" value="Y" checked />
														<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span><?= $txt_article_group_show_sub; ?>
													</label>
												</div>
												<div class="checkbox">
													<label>
														<input name="gshowsubnew" id="gshowsubnew" type="checkbox" value="Y" checked />
														<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span><?= $txt_article_group_show_subnew; ?>
													</label>
												</div> -->
												<!-- <div class="checkbox">
													<label>
														<input name="gshowdetail" id="gshowdetail" type="checkbox" value="Y" checked />
														<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span><?= $txt_article_group_show_detail; ?>
													</label>
												</div> -->
											<!-- </div>
										</div>
										<input name="select_template" type="hidden" value="0"> -->

										<!-- <div class="form-group row ">
											<label for="gtype" class="col-sm-12 control-label"><b><?= $txt_article_group_set_image; ?> <span class="text-danger"><code>*</code></span> :</b></label>
											<div class="col-md-12 col-sm-12 col-xs-12">
												<div class="radio">
													<label><input type="radio" name="gshowpic" id="ck_gshowpic1" value="Y" <?php echo 'checked="checked"'; ?> /><?= $txt_article_group_image_yes; ?>
														<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
													</label>
												</div>
												<div class="radio">
													<label><input type="radio" name="gshowpic" id="ck_gshowpic0" value="N" /><?= $txt_article_group_image_no; ?>
														<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
													</label>
												</div> -->
												<!--<div class="radio">
													<label ><input type="radio" name="gshowpic" id="ck_gshowpic2"  value="<?php //if($G['c_show_pic'] != "@detail_news#"){ echo $G['c_show_pic']; } 
																															?>"  <?php //if($G['c_show_pic'] != "@detail_news#" AND $G['c_show_pic'] != ""){ echo "checked"; } 
																																	?> ><? //=$txt_article_group_image_select;
																																		?> 
													<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>		
														<a href="#pop" onClick="choose_pic('window.opener.document.form1.gshowpic[2].value','window.opener.document.all.imgpreview');document.form1.gshowpic[2].checked=true;"><img src="../images/i_folder_on.jpg" width="16" height="16" border="0" align="absmiddle"> 
														
														<img src="<?php //if($G['c_show_pic'] != "@detail_news#" AND $G['c_show_pic'] != ""){ echo "../ewt/".$_SESSION['EWT_SUSER']."/".$G['c_show_pic']; }else{ echo "../images/o.gif"; } 
																	?>" name="imgpreview" width="16" height="16" border="0" align="absmiddle" id="imgpreview"> <?php //if($G["c_show_pic"] != "@detail_news#"){ echo $G["c_show_pic"]; } 
																																								?>
														</a>  
														</label>
													</div>-->
												<!-- <div class="radio">
													<label><input type="radio" name="gshowpic" id="ck_gshowpic2" value="<?php if ($G['c_show_pic'] != "@detail_news#") {
																															echo $G['c_show_pic'];
																														} ?>" <?php if ($G['c_show_pic'] != "@detail_news#" and $G['c_show_pic'] != "") {
																																	echo "checked";
																																} ?>><?= $txt_article_group_image_select; ?>
														<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
														<a href="#pop" onClick="choose_pic('window.opener.document.form1.gshowpic[2].value','window.opener.document.all.imgpreview');document.form1.gshowpic[2].checked=true;">
															<img src="../images/i_folder_on.jpg" width="16" height="16" border="0" align="absmiddle">
															<button type="button" class="btn btn-info  btn-sm ">
																<span class="glyphicon glyphicon-folder-open"></span>&nbsp;เลือกไฟล์
															</button>
															<img src="<?php if ($G['c_show_pic'] != "@detail_news#" and $G['c_show_pic'] != "") {
																			echo "../ewt/" . $_SESSION['EWT_SUSER'] . "/" . $G['c_show_pic'];
																		} else {
																			echo "../images/o.gif";
																		} ?>" name="imgpreview" width="16" height="16" border="0" align="absmiddle" id="imgpreview"> <?php if ($G["c_show_pic"] != "@detail_news#") {
																																											echo $G["c_show_pic"];
																																										} ?>
														</a>
													</label>
												</div> -->
											<!-- </div>
										</div> -->

										<!-- <div class="form-group row">
											<label for="gshowdate" class="col-sm-12 control-label"><b><?= $txt_article_group_set_date; ?> <span class="text-danger"><code>*</code></span> :</b></label>
											<div class="col-md-12 col-sm-12 col-xs-12">
												<div class="radio">
													<label><input type="radio" name="gshowdate" id="ck_gshowdate1" value="Y" checked/>
														
														แสดงวันที่
														<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
													</label>
												</div>
												<div class="radio">
													<label><input type="radio" name="gshowdate" id="ck_gshowdate0" value="N" />
														<?= $txt_article_group_date_no; ?>
														<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
													</label>
												</div> -->
												<!-- <div class="radio">
													<label><input type="radio" name="gshowdate" id="ck_gshowdate1" value="N" /><?= $txt_article_group_date_show2; ?>
														<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
													</label>
												</div> -->
											<!-- </div>
										</div> -->

										<?php /*<div class="form-group row">
											<div class="col-md-8 col-sm-8 col-xs-8">
											<label for="gname"><?="ชื่อกลุ่มข่าว/บทความ";?> : </label>        
												<input class="form-control" name="gname" type="text" id="gname"  value="<?=$rec_user['url'];?>" />	
												</div>
												<div class="col-md-4 col-sm-4 col-xs-12">
												<div class="radio">
												<label><input type="radio" name="gtype"  value="" checked />&nbsp;หมวดข่าวทั่วไป&nbsp;</label>
												</div>
												<div class="radio">
												<label><input type="radio" name="gtype" value="M" />&nbsp;ดึงข้อมูลจากหมวดอื่น&nbsp;</label>    
												</div>
										</div>
										</div>
										<div class="form-group row">
											<div class="col-md-12 col-sm-12 col-xs-12">
											<label for="txt_url"><?="การแสดงผลของหน้าอ่านทั้งหมด";?> : </label>			
												<div class="checkbox">	  
												<label class="checkbox-inline"><input name="gshowsearch" type="checkbox"  id="gshowsearch"  value="Y" <?php if($G["c_show_search"]=='Y'){echo 'checked';} ?>>&nbsp;แสดง "ค้นหาข่าว"&nbsp;</label>
												<label class="checkbox-inline"><input name="gshowsub" type="checkbox" id="gshowsub"  value="Y" <?php if($G["c_show_sub"]=='Y'){echo 'checked';} ?>>&nbsp;แสดงหมวดย่อย&nbsp;</label>
												<label class="checkbox-inline"><input name="gshowsubnew" type="checkbox" id="gshowsubnew"   value="Y" <?php if($G["c_show_subnew"]=='Y'){echo 'checked';} ?>>&nbsp;แสดงข่าวภายใต้หมวดย่อย&nbsp;</label>
												<label class="checkbox-inline"><input name="gshowdetail" type="checkbox" id="gshowdetail"  value="Y" <?php if($G["c_show_detail"]=='Y'){echo 'checked';} ?>>&nbsp;แสดงรายละเอียดข่าว&nbsp;</label>
												<input name="select_template" type="hidden" value="0">
												</div>	
												</div>	 
										</div>

										<div class="form-group row">
											<div class="col-md-12 col-sm-12 col-xs-12">
												<label for="txt_url"><?="การแสดงภาพประกอบข่าว";?> : </label>
												<div class="radio">		
												<label class="radio-inline"><input type="radio" name="gshowpic" value="" <?php if($G['c_show_pic'] == ""){ echo "checked"; } ?>>&nbsp;ไม่ใช้รูปภาพ&nbsp;</label>
												<label class="radio-inline"><input type="radio" name="gshowpic" value="@detail_news#"  <?php if($G['c_show_pic'] == "@detail_news#"){ echo "checked"; } ?>>&nbsp;แสดงรูปประกอบของข่าว&nbsp;</label>
												<label class="radio-inline"><input type="radio" name="gshowpic" value="<?php if($G['c_show_pic'] != "@detail_news#"){ echo $G['c_show_pic']; } ?>"  <?php if($G['c_show_pic'] != "@detail_news#" AND $G['c_show_pic'] != ""){ echo "checked"; } ?> > 
												<a href="#pop" onClick="choose_pic('window.opener.document.form1.gshowpic[2].value','window.opener.document.all.imgpreview');document.form1.gshowpic[2].checked=true;"><img src="../images/i_folder_on.jpg" width="16" height="16" border="0" align="absmiddle"> 
												เลือกจากไฟล์ : 
												<img src="<?php if($G['c_show_pic'] != "@detail_news#" AND $G['c_show_pic'] != ""){ echo "../ewt/".$_SESSION['EWT_SUSER']."/".$G['c_show_pic']; }else{ echo "../images/o.gif"; } ?>" name="imgpreview" width="16" height="16" border="0" align="absmiddle" id="imgpreview"> <?php if($G["c_show_pic"] != "@detail_news#"){ echo $G["c_show_pic"]; } ?>
												</a>  
												</label>
										</div>	
											</div>	 
										</div>

										<div class="form-group row">
											<div class="col-md-12 col-sm-12 col-xs-12">
											<label for="txt_url"><?="การแสดงวันที่ข่าว";?> : </label>        
												<div class="radio">			
												<label class="radio-inline"><input name="gshowdate" type="radio" id="gshowdate"  value="" <?php if($G['c_show_date'] == ""){ echo "checked"; } ?>>&nbsp;ไม่แสดง&nbsp;</label>
												<label class="radio-inline"><input name="gshowdate" checked="checked" type="radio" id="gshowdate"  value="C" <?php if($G['c_show_date'] == "C"){ echo "checked"; } ?>>&nbsp;แสดงต่อจากหัวข้อข่าว&nbsp;</label>
												<label class="radio-inline"><input name="gshowdate" type="radio" id="gshowdate"  value="N" <?php if($G['c_show_date'] == "N"){ echo "checked"; } ?>>&nbsp;แสดงบรรทัดถัดมา&nbsp;</label>	
												</div>	
											</div>	 
										</div>*/ ?>
<!-- 
										 <div class="form-group row">
											<label for="gshowdate" class="col-sm-12 control-label"><b>ตั้งค่ารูปแบบพิเศษ <span class="text-danger"><code>*</code></span> :</b></label>
											<div class="col-md-12 col-sm-12 col-xs-12">
												<div class="radio">
													<label>
														<input type="radio" name="c_show_org_chk" id="c_show_org_chk" value="Y" onclick="displayOrg();">แสดง
														<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
													</label>
												</div>

												<div class="radio">
													<label>
														<input type="radio" name="c_show_org_chk" id="c_show_org_chk" value="N" checked onclick="closeOrg();">ไม่แสดง
														<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
													</label>
												</div>
											</div>
										</div> -->

										<!-- <div class="row" id="list_org" style="display: none;">
											<div class="form-group row">
												<div class="col-md-2 col-sm-2 col-xs-2">
													<label class="col-sm-12 control-label"><b>เมนู</b></label>
												</div>
												<div class="col-md-3 col-sm-3 col-xs-3">
													<select class="form-control select2" name="menu_org" id="menu_org">
														<option value="">เลือกข้อมูล</option>
														<?php foreach ($menu_org["data"] as $key => $value) { ?>
															<option value="<?php echo $value['m_id']; ?>" <?php echo ($chk_menu == $value['m_id'] ? "selected" : null) ?>>
																<?php echo $value['m_name']; ?>
															</option>
														<?php } ?>
													</select>
												</div>
											</div>

											<div class="form-group row">
												<div class="col-md-2 col-sm-2 col-xs-2">
													<label class="col-sm-12 control-label"><b>แบนเนอร์</b></label>
												</div>
												<div class="col-md-3 col-sm-3 col-xs-3">
													<select class="form-control select2" name="banner_org" id="banner_org">
														<option value="">เลือกข้อมูล</option>
														<?php foreach ($banner_org["data"] as $key => $value) { ?>
															<option value="<?php echo $value['banner_gid']; ?>" <?php echo ($value['banner_gid'] == $chk_banner ? "selected" : null); ?>>
																<?php echo $value['banner_name']; ?>
															</option>
														<?php } ?>
													</select>
												</div>
											</div> -->

											<!-- <div class="form-group row">
													<div class="col-md-2 col-sm-2 col-xs-2">
														<label class="col-sm-12 control-label"><b>รูปแบนเนอร์</b></label>
													</div>
													<div class="col-md-3 col-sm-3 col-xs-3">
														<div class="row">
															<div class="column" id="list_banner_org">
																<?php
																if (!$chk_banner != 0) { ?>
																	<img src="<?php echo $Globals_Dir . $banner_org["data"]["banner_pic"]; ?>" style="width: 100%; height: auto; max-height: 160px;">
																<?php } ?>
															</div>
														</div>
													</div>
												</div> -->

											<!-- <div class="form-group row">
												<div class="col-md-2 col-sm-2 col-xs-2">
													<label class="col-sm-12 control-label"><b>รูปภาพ</b></label>
												</div>
												<div class="col-md-3 col-sm-3 col-xs-3"> -->
													<!-- <select class="form-control select2" name="image_org" id="image_org">
														<?php foreach ($image_org["data"] as $key => $value) { ?>
															<option value="<?php echo $value['banner_id']; ?>" <?php echo ($value['banner_id'] == $chk_image ? "selected" : null); ?>>
																<?php echo $value['banner_name']; ?>
															</option>
														<?php } ?>
													</select> -->
													<!-- <input type="file" class="form-control" name="image_org" id="image_org">
												</div>
											</div> -->

											<!-- <div class="form-group row">
													<div class="col-md-2 col-sm-2 col-xs-2">
														<label class="col-sm-12 control-label"><b>รูปภาพ</b></label>
													</div>
													<div class="col-md-3 col-sm-3 col-xs-3">
														<div class="row">
															<div class="column" id="list_banner_org">
																<?php
																if ($chk_image != 0) { ?>
																	<img src="<?php echo $Globals_Dir . $image_org["data"]["banner_pic"]; ?>" style="width: 100%; height: auto; max-height: 160px;">
																<?php } ?>
															</div>
														</div>
													</div>
												</div> -->

											<!-- <div class="form-group row">
												<div class="col-md-2 col-sm-2 col-xs-2">
													<label class="col-sm-12 control-label"><b>ข่าวหมวดที่ 1</b></label>
												</div>
												<div class="col-md-3 col-sm-3 col-xs-3">
													<select class="form-control select2" name="org_group1" id="org_group1">
														<option value="">เลือกข้อมูล</option>
														<?php foreach ($group_org["data"] as $key => $value) { ?>
															<option value="<?php echo $value['c_id']; ?>" <?php echo ($chk_org1 == $value['c_id'] ? "selected" : null) ?>>
																<?php echo $value['c_name']; ?>
															</option>
														<?php } ?>
													</select>
												</div>
											</div>

											<div class="form-group row">
												<div class="col-md-2 col-sm-2 col-xs-2">
													<label class="col-sm-12 control-label"><b>ข่าวหมวดที่ 2</b></label>
												</div>
												<div class="col-md-3 col-sm-3 col-xs-3">
													<select class="form-control select2" name="org_group2" id="org_group2">
														<option value="">เลือกข้อมูล</option>
														<?php foreach ($group_org["data"] as $key => $value) { ?>
															<option value="<?php echo $value['c_id']; ?>" <?php echo ($chk_org2 == $value['c_id'] ? "selected" : null) ?>>
																<?php echo $value['c_name']; ?>
															</option>
														<?php } ?>
													</select>
												</div>
											</div>

											<div class="form-group row">
												<div class="col-md-2 col-sm-2 col-xs-2">
													<label class="col-sm-12 control-label"><b>ข่าวหมวดที่ 3</b></label>
												</div>
												<div class="col-md-3 col-sm-3 col-xs-3">
													<select class="form-control select2" name="org_group3" id="org_group3">
														<option value="">เลือกข้อมูล</option>
														<?php foreach ($group_org["data"] as $key => $value) { ?>
															<option value="<?php echo $value['c_id']; ?>" <?php echo ($chk_org3 == $value['c_id'] ? "selected" : null) ?>>
																<?php echo $value['c_name']; ?>
															</option>
														<?php } ?>
													</select>
												</div>
											</div>
										</div> -->

										<div class="form-group row">
											<div class="col-md-12 col-sm-12 col-xs-12 text-center">
												<button type="submit" class="btn btn-success  btn-ml ">
													<i class="glyphicon glyphicon-floppy-saved"></i>&nbsp;<?= "บันทึก"; ?>
												</button>
												<input type="hidden" name="cid" id="cid" value="<?php echo $cid; ?>">
												<input name="Flag" type="hidden" id="Flag" value="CreateFolder">
												<input name="p" type="hidden" id="p" value="<?= $_GET['p']; ?>">
											</div>
										</div>
									</form>
									<!--<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
									<tr> 
										<td><img src="../theme/main_theme/article_logo.gif" width="32" height="32" align="absmiddle"> 
										<span class="ewtfunction">บริหารกลุ่มข่าว/บทความ</span> </td>
									</tr>
									</table>
									<form name="formPopUpBg" method="post" action="" target="bg_popup">
											<input name="o_value" type="hidden" id="o_value" value="">
											<input name="o_preview" type="hidden" id="o_preview" value="">
											<input name="stype" type="hidden" id="stype" value="images">
											<input name="Flag" type="hidden" id="Flag" value="">
									</form>
									<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
									<tr>
										<td align="right">
										
										<a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode("บริหารกลุ่มข่าว/บทความ" . $txt); ?>&module=article&url=<?php echo urlencode("article_gadd.php?p=" . $_GET["p"]); ?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<a href="article_group.php"><img src="../theme/main_theme/g_mainpage.gif" width="16" height="16" border="0" align="absmiddle"> 
										หน้าหลัก</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="article_new.php"><img src="../theme/main_theme/g_add_document.gif" border="0" width="16" height="16" align="absmiddle"> 
										เพิ่มข่าว/บทความ</a> 
										<hr>
										</td>
									</tr>
									</table>
									<table width="90%" border="0" align="center"  class="table table-bordered">
									<form name="form1" method="post" action="article_function.php" onSubmit="return Chk();"><tr bgcolor="#E7E7E7" > 
										<td height="30" colspan="2" class="ewttablehead">เพิ่มกลุ่มข่าว/บทความ<?php echo $txt; ?>      </td>
									</tr>
									<tr valign="top" bgcolor="#FFFFFF"> 
										<td width="13%">ชื่อกลุ่มข่าว/บทความ</td>
										<td width="87%"><input name="gname" type="text" id="gname" size="40" class="form-control" style="width:40%;" >
										<br>
										<br>
										ตัวอย่างเช่น ข่าวประชาสัมพันธ์, ข่าวการเมือง, บทความเกี่ยวกับสุขภาพ เป็นต้น<br><br>
										<input type="radio" name="gtype"  value=" " checked >หมวดข่าวทั่วไป<br>
										<input type="radio" name="gtype" value="M" >ดึงข้อมูลจากหมวดอื่น</td>
									</tr>
									<tr bgcolor="#E7E7E7" > 
										<td height="30" colspan="2" class="ewttablehead">การแสดงผลในหน้าอ่านข่าวทั้งหมด</td>
									</tr>
									<tr valign="top" bgcolor="#FFFFFF"> 
										<td width="13%">การแสดงผล</td>
										<td width="87%">
										<input name="gshowsearch" type="checkbox"  id="gshowsearch"  value="Y" <?php if ($G["c_show_search"] == 'Y') {
																													echo 'checked';
																												} ?>>
											แสดง "ค้นหาข่าว"<br>
										<input name="gshowsub" type="checkbox" id="gshowsub"  value="Y" <?php if ($G["c_show_sub"] == 'Y') {
																											echo 'checked';
																										} ?>> แสดงหมวดย่อย<br>
										<input name="gshowsubnew" type="checkbox" id="gshowsubnew"   value="Y" <?php if ($G["c_show_subnew"] == 'Y') {
																													echo 'checked';
																												} ?>>
											แสดงข่าวภายใต้หมวดย่อย<br>
										<input name="gshowdetail" type="checkbox" id="gshowdetail"  value="Y" <?php if ($G["c_show_detail"] == 'Y') {
																													echo 'checked';
																												} ?>>
											แสดงรายละเอียดข่าว<input name="select_template" type="hidden" value="0"></td>
									</tr>
									<!--<tr valign="top" bgcolor="#FFFFFF">
										<td >Template</td>
										<td><select name="select_template"  >
										<option value=""></option>
																<?php //save_design_function
																$sql_design = "SELECT d_id,d_name FROM design_list ORDER BY d_name ASC";
																$query = $db->query($sql_design);
																while ($rec_design = $db->db_fetch_array($query)) {
																	$select = '';
																	echo " <option value=\"" . $rec_design['d_id'] . "\"" . $select . ">" . $rec_design['d_name'] . "</option>";
																}
																?>
															</select> <input type="button" name="Submit2" value="Preview" onClick="window.open('../ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/template_preview.php?d_id='+ document.form1.select_template.value +'','','height=600,width=780,scrollbars=1,resizable=1');"></td>
									</tr>
									<tr valign="top" bgcolor="#FFFFFF">
										<td >W3c Template</td>
										<td><select name="select_template_w3c"  >
										<option value=""></option>
																<?php //save_design_function
																$sql_design = "SELECT d_id,d_name FROM design_list ORDER BY d_name ASC";
																$query = $db->query($sql_design);
																while ($rec_design = $db->db_fetch_array($query)) {
																	$select = '';
																	echo " <option value=\"" . $rec_design['d_id'] . "\"" . $select . ">" . $rec_design['d_name'] . "</option>";
																}
																?>
															</select> <input type="button" name="Submit2" value="Preview" onClick="window.open('../ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/template_preview.php?d_id='+ document.form1.select_template_w3c.value +'','','height=600,width=780,scrollbars=1,resizable=1');"></td>
									</tr>->
									<tr valign="top" bgcolor="#FFFFFF"> 
										<td width="13%">การแสดงภาพประกอบข่าว<br></td>
										<td width="87%">
											<input type="radio" name="gshowpic" value="" <?php if ($G["c_show_pic"] == "") {
																								echo "checked";
																							} ?>>
												ไม่ใช้รูปภาพ<br> <input type="radio" name="gshowpic" value="@detail_news#"  <?php if ($G["c_show_pic"] == "@detail_news#") {
																																echo "checked";
																															} ?>>
												แสดงรูปประกอบของข่าว<br> <input type="radio" name="gshowpic" value="<?php if ($G["c_show_pic"] != "@detail_news#") {
																														echo $G["c_show_pic"];
																													} ?>"  <?php if ($G["c_show_pic"] != "@detail_news#" and $G["c_show_pic"] != "") {
																																echo "checked";
																															} ?> > 
												<a href="#pop" onClick="choose_pic('window.opener.document.form1.gshowpic[2].value','window.opener.document.all.imgpreview');document.form1.gshowpic[2].checked=true;"><img src="../images/i_folder_on.jpg" width="16" height="16" border="0" align="absmiddle"> 
												เลือกจากไฟล์ : 
												<img src="<?php if ($G["c_show_pic"] != "@detail_news#" and $G["c_show_pic"] != "") {
																echo "../ewt/" . $_SESSION["EWT_SUSER"] . "/" . $G["c_show_pic"];
															} else {
																echo "../images/o.gif";
															} ?>" name="imgpreview" width="16" height="16" border="0" align="absmiddle" id="imgpreview"> <?php if ($G["c_show_pic"] != "@detail_news#") {
																																								echo $G["c_show_pic"];
																																							} ?>
												</a>      </td>
									</tr>
									<tr valign="top" bgcolor="#FFFFFF"> 
										<td width="13%">การแสดงวันที่ข่าว</td>
										<td width="87%">
										<input name="gshowdate" type="radio" id="gshowdate"  value="" <?php if ($G["c_show_date"] == "") {
																											echo "checked";
																										} ?>> ไม่แสดง<br>
										<input name="gshowdate" checked="checked" type="radio" id="gshowdate"  value="C" <?php if ($G["c_show_date"] == "C") {
																																echo "checked";
																															} ?>> แสดงต่อจากหัวข้อข่าว<br>
										<input name="gshowdate" type="radio" id="gshowdate"  value="N" <?php if ($G["c_show_date"] == "N") {
																											echo "checked";
																										} ?>> แสดงบรรทัดถัดมา	</td>
									</tr>
									<?php
									//กำหนดเรื่องสิทธิ์<br>
									$displ_user = 'none';
									$displ_org = 'none';
									$displ_group = 'none';
									$displ_group_personal = 'none';

									?>
									<tr valign="top" bgcolor="#FFFFFF">
										<td>กำหนดสิทธิ์การมองเห็น</td>
										<td width="87%"><table width="100%" border="0">
										<tr style="display:<?php echo $displ_user; ?>" id="tr_user">
											<td width="11%" height="22">รายบุคคล : 
											<input type="hidden" name="hdd_uid" </td>
											<td width="89%" height="22"><span id="txtshow"><?php echo $G['c_name']; ?></span></td>
										</tr>
										<tr  style="display:<?php echo $displ_org; ?>" id="tr_org">
											<td width="11%" height="22">รายหน่วยงาน : 
											<input type="hidden" name="hdd_uorg" ></td>
											<td height="22"><span id="txtshowuorg"><?php echo $G['c_name']; ?></span></td>
										</tr>
										<tr style="display:<?php echo $displ_group; ?>"  id="tr_group">
											<td width="11%" height="22">รายกลุ่มสิทธิ์ : 
											<input type="hidden" name="hdd_ugroup" ></td>
											<td height="22"><span id="txtshowugroup"><?php echo $G['c_name']; ?></span></td>
										</tr style="display:none">
										<tr  style="display:<?php echo $displ_group_personal; ?>"  id="tr_group_personal">
											<td width="11%" height="22">รายกลุ่มบุคคล : 
											<input type="hidden" name="hdd_ugroup_personal" ></td>
											<td height="22"><span id="txtshowugroup_personal"><?php echo $G['c_name']; ?></span></td>
										</tr>
										<tr>
											<td width="11%"><a href="#G" onClick="window.open('member_list_main.php','','width=900 , height=650, scrollbars=1,resizable = 1');"><img src="../images/bar_user.gif" border="0" alt="กำหนดสิทธิ์" width="20" height="20"></a></td>
											<td>&nbsp;</td>
										</tr>
										</table></td>
									</tr>
									<tr bgcolor="#FFFFFF"> 
										<td>&nbsp;</td>
										<td> <input type="submit" name="Submit2" value="เพิ่ม" class="btn btn-success"><input name="Flag" type="hidden" id="Flag" value="CreateFolder"> <input name="p" type="hidden" id="p" value="<?php echo $_GET["p"]; ?>">     </td>
									</tr>
									</form>
									</table>
									<br>-->

								</div>
							</div>
						</div>

					</div>

				</div>
				<!--END card-body-->
			</div>
			<!--END card-->
		</div>
	</div>

</div>
<!-- END CONTAINER  -->
<?php
include("../EWT_ADMIN/combottom.php");
?>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui-touch-punch.min.js"></script>

<!--<style>
	.panel-default>.panel-heading {
		/*color: #FFFFFF;*/
		/*background-color: #FFC153 ;*/
		background-color: #FFFFFF;
		border-color: #ddd;
	}

	.faqHeader {
		font-size: 27px;
		margin: 20px;
	}

	.panel-heading [data-toggle="collapse"]:after {
		font-family: 'Font Awesome 5 Free';
		font-weight: 900;
		content: "\f105";
		/* "play" icon */
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
		background: rgba(255, 255, 255, 0.1);
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
		background: rgba(255, 255, 255, 1);
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
	.ewt-icon-effect-1b .ewt-icon:hover {
		background: rgba(255, 255, 255, 1);
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
	
</style>-->

<script>
	function displayOrg() {
		$('#list_org').show();
	}

	function closeOrg() {
		$('#list_org').hide();
	}

	function JQCheck_Cate(form) {
		var name = form.attr('name');
		var check = $('input:checkbox[name=' + name + ']:checked').val();
		if (check == 'Y') {
			$('#category_parent').attr("disabled", false);
			$('#category_parent').attr("required", false);
		} else {
			$('#category_parent').attr("disabled", true);
			$('#category_parent').attr("required", true);
		}
		console.log(check);
	}

	function JQDelete_ComplainForm(id) {
		$.confirm({
			title: 'ลบข้อมูล',
			content: 'คุณต้องการลบรายการนี้หรือไม่?',
			//content: 'url:form.html',
			boxWidth: '30%',
			icon: 'fas fa-exclamation-circle',
			theme: 'modern',
			buttons: {
				confirm: {
					text: 'ยืนยันลบข้อมูล',
					btnClass: 'btn-warning',
					action: function() {
						$.ajax({
							type: 'POST',
							url: 'func_delete_complain.php',
							data: {
								'id': id,
								'proc': 'DelComF'
							},
							success: function(data) {
								$.alert({
									title: '',
									content: 'url:text.html',
									boxWidth: '30%',
									buttons: {
										cancel: {
											text: 'ตกลง',
											btnClass: 'btn-blue',
											action: function() {
												location.reload();
											}
										}
									}

								});

							}
						});
						//FuncDelete(id);											
						//$.alert('ทำการลบข้อมูลเรียบร้อยแล้ว');																
					}

				},
				cancel: {
					text: 'ยกเลิก'

				}
			},
			animation: 'scale',
			type: 'orange'

		});

	}

	function JQDelete(id) {
		$.confirm({
			title: 'ลบข้อมูล',
			content: 'คุณต้องการลบรายการนี้หรือไม่?',
			//content: 'url:form.html',
			boxWidth: '30%',
			icon: 'glyphicon glyphicon-exclamation-sign',
			theme: 'modern',
			buttons: {
				confirm: {
					text: 'ยืนยันลบข้อมูล',
					btnClass: 'btn-warning',
					action: function() {
						$.ajax({
							type: 'GET',
							url: 'func_delete_vdo.php',
							data: {
								'id': id,
								'proc': 'DelVdo'
							},
							success: function(data) {
								$.alert({
									title: '',
									content: 'url:text.html',
									boxWidth: '30%',
									buttons: {
										cancel: {
											text: 'ตกลง',
											btnClass: 'btn-blue',
											action: function() {
												location.reload();
											}
										}
									}

								});

							}
						});
						//FuncDelete(id);											
						//$.alert('ทำการลบข้อมูลเรียบร้อยแล้ว');																
					}

				},
				cancel: {
					text: 'ยกเลิก'

				}
			},
			animation: 'scale',
			type: 'orange'

		});
		// });
	}
</script>