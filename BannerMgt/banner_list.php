<?php
include("../EWT_ADMIN/comtop.php");
include("../language/banner_language.php");
?>

<!-- START CONTAINER  -->
<div class="container-fluid">
	<?php
	include("menu-top.php");
	$ban_cid = (int)(!isset($_GET['ban_cid']) ? 0 : $_GET['ban_cid']);
	$keyword = $_GET['keyword'];
	
	$wh = "";
	if (!empty($keyword)) {
		$wh .= " AND banner_name LIKE '%{$keyword}%' ";
	}

	function banner_category($ban_cid)
	{
		global $db, $EWT_DB_NAME;
		$s_category = $db->query("SELECT * FROM banner_group WHERE banner_gid = '{$ban_cid}' ");
		if ($db->db_num_rows($s_category)) {
			$a_category = $db->db_fetch_array($s_category);
			$a_data = $a_category['banner_name'];
		}
		return $a_data;
	}

	$s_banner_g = $db->query("SELECT * FROM banner_group WHERE  banner_gid = '{$ban_cid}' ");
	$a_banner_g = $db->db_fetch_array($s_banner_g);

	// $Globals_Dir = "../ewt/" . $_SESSION["EWT_SUSER"] . "/";

	$perpage = 12;
	$page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);
	if ($page <= 0) $page = 1;
	$start = ($page * $perpage) - $perpage;

	$_sql = $db->query("SELECT * FROM banner WHERE banner_gid = '{$ban_cid}' {$wh} ORDER BY banner_position ASC,banner_id DESC LIMIT {$start} , {$perpage} ");
	$statement = "SELECT count(banner_id) AS b FROM banner WHERE banner_gid = '{$ban_cid}' {$wh} ";

	$a_rows = $db->db_num_rows($_sql);
	$s_count = $db->query($statement);
	$a_count = $db->db_fetch_array($s_count);
	$total_record = $a_count['b'];
	$total_page = (int)ceil($total_record / $perpage);
	?>

	<div class="row m-b-sm">
		<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">
			<!--start card -->
			<div class="card">
				<!--start card-header -->
				<div class="card-header">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">

							<h4><?php echo $txt_banner_list; ?></h4>
							<p></p>

						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<ol class="breadcrumb">
									<li><a href="banner_group.php"><?php echo $txt_banner_cate; ?></a></li>
									<li class=""><?php echo banner_category($ban_cid); ?></li>
								</ol>
							</div>

							<!-- <div class="col-md-8 col-sm-8 col-xs-12 text-center hidden-xs">
								<input type="text" class="form-control" name="keyword" id="keyword" placeholder="ค้นหา" value="<?php echo $keyword; ?>">
							</div> -->

							<div class="col-md-4 col-sm-4 col-xs-12 text-center float-right hidden-xs">
								<button type="button" class="btn btn-info  btn-ml" onClick="boxPopup('<?php echo linkboxPopup(); ?>pop_add_banner_group.php?ban_cid=<?php echo $ban_cid; ?>');">
									<i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_banner_add_cate; ?>
								</button>

								<button type="button" class="btn btn-info  btn-ml" onClick="boxPopup('<?php echo linkboxPopup(); ?>pop_add_banner.php?ban_cid=<?php echo $ban_cid; ?>');">
									<i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_banner_add; ?>
								</button>

								<!-- boxPopup('<?php echo linkboxPopup(); ?>pop_search_banner.php'); -->
								<!-- <button type="button" class="btn btn-info  btn-ml " onclick="bannerSearch();">
									<i class="fas fa-search"></i>&nbsp;<?php echo $txt_banner_search; ?>
								</button> -->

								<a href="banner_group.php" target="_self">
									<button type="button" class="btn btn-info  btn-ml ">
										<i class="fas fa-undo-alt"></i>&nbsp;<?php echo $txt_ewt_back; ?>
									</button>
								</a>
							</div>

							<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs">
								<div class="btn-group ">
									<button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span></button>
									<ul class="dropdown-menu dropdown-menu-right">
										<li><a onClick="boxPopup('<?php echo linkboxPopup(); ?>pop_add_banner_group.php?ban_cid=<?php echo $ban_cid; ?>');"><i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_banner_add_cate; ?></a></li>
										<li><a onClick="boxPopup('<?php echo linkboxPopup(); ?>pop_add_banner.php?ban_cid=<?php echo $ban_cid; ?>');"><i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_banner_add; ?></a></li>
										<li><a onClick="boxPopup('<?php echo linkboxPopup(); ?>pop_search_banner.php');"><i class="fas fa-search"></i>&nbsp;<?php echo $txt_banner_search; ?></a></li>
										<li><a href="banner_group.php" target="_self"><i class="fas fa-undo-alt"></i>&nbsp;<?php echo $txt_ewt_back; ?></a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--END card-header -->

				<!--start card-body -->
				<div class="card-body">
					<div class="row ">
						<div class="col-md-12 col-sm-12 col-xs-12" id="table-view">
							<?php /* ?>
							<div class="table-responsive">			
							<form name="frm1" action="banner_process.php" method="post">		
							<table width="100%" class="table table-bordered" id="table-1" align="center">
							<thead>
							<tr class="nodrop nodrag success">
								<th  width="10%" ></th>  
								<th  width="40%" class="text-center"><?php echo $text_genbanner_column1;?></th>
								<th  width="30%" class="text-center"><?php echo $text_genbanner_column2;?></th> 
								<th  width="10%" class="text-center"><?php echo 'Popup Intro';?></th>  
								<th  width="10%" class="text-center"><?php echo $text_genbanner_formsort;?></th>
							</tr>
							</thead>
							<tbody>						
							<?php
							if($a_rows > 0){
							$i = 1;
							while($a_banner = $db->db_fetch_array($s_banner)){
							?>						
							<tr id="<?php echo $i;?>">
							<td class="text-center" >
							<!--<a href="#" title="แก้ไข" target="_self" onClick="location.href='banner_edit.php?flag=edit&banner_id=<?php echo $rs_banner['banner_id']?>&banner_gid=<?php echo $_GET["banner_gid"];?>';" >
							<span class="glyphicon glyphicon-cog text-warning" style="font-size:16px;"></span>
							</a>
							<a href="#" title="ลบ" target="_self" onClick="if(confirm('<?php echo $text_genbanner_confirm_del;?>'))location.href = 'banner_process.php?flag=del&banner_id=<?php echo $rs_banner[banner_id]?>&banner_gid=<?php echo $_GET["banner_gid"];?>'; ">
							<span class="glyphicon glyphicon-trash text-danger" style="font-size:16px;"></span>
							</a>-->
							<nobr>
							<a onClick="boxPopup('<?php echo linkboxPopup();?>pop_edit_banner.php?proc=edit&bid=<?php echo $a_banner['banner_id']?>&gid=<?php echo $gid;?>');" data-toggle="tooltip" data-placement="right" title="<?php echo $text_genbanner_altedit;?>" > 
							<button type="button" class="btn btn-warning  btn-circle  btn-xs " >
							<i class="fa fa-edit" aria-hidden="true"></i>
							</button>
							</a>
							<a onClick="boxPopup('<?php echo linkboxPopup();?>pop_edit_banner.php?proc=edit&bid=<?php echo $a_banner['banner_id']?>&gid=<?php echo $gid;?>');" data-toggle="tooltip" data-placement="right" title="<?php echo $text_genbanner_altdel;?>" > 
							<button type="button" class="btn btn-danger  btn-circle  btn-xs " >
							<i class="far fa-trash-alt" aria-hidden="true"></i>
							</button>
							</a>
							<a onClick="boxPopup('<?php echo linkboxPopup();?>pop_view_banner.php?bid=<?php echo $a_banner['banner_id']?>');" data-toggle="tooltip" data-placement="right" title="<?php echo "ดูรูปภาพ";?>">
							<button type="button" class="btn btn-success  btn-circle  btn-xs " >
							<i class="fas fa-search" aria-hidden="true"></i>
							</button>
							</a> 
							<!--<img src="../theme/main_theme/g_edit.gif" height="16" width="16" align="absmiddle" alt="<?php echo $text_genbanner_altedit;?>" style="cursor:hand" onClick="location.href='banner_edit.php?flag=edit&banner_id=<?php echo $rs_banner[banner_id]?>&banner_gid=<?php echo $_GET["banner_gid"];?>';">&nbsp;
							<img src="../theme/main_theme/g_garbage.png" height="16" width="16" align="absmiddle" alt="<?php echo $text_genbanner_altdel;?>" style="cursor:hand" onClick="if(confirm('<?php echo $text_genbanner_confirm_del;?>'))location.href = 'banner_process.php?flag=del&banner_id=<?php echo $rs_banner[banner_id]?>&banner_gid=<?php echo $_GET["banner_gid"];?>'; "> 
							<a href="#" onClick="txt_data('<?php//=$rs_banner[banner_id]?>','<?php//=$_GET[banner_gid]?>')"><img id="lang<?php//=$rs_banner[banner_id]?>" src="../images/b_fonts.gif" alt="สร้างภาษาอื่น" width="16" height="16" align="absmiddle" border="0"></a>->
							</nobr>
							</td>
							<td >
							&nbsp;&nbsp;
							<?php 
							if(file_exists($Globals_Dir.$a_banner['banner_pic']) AND $a_banner['banner_pic']!=''){
							$filetypename = explode('.',$Globals_Dir.$a_banner['banner_pic']);																
									if($filetypename[3] == 'swf'){
									$wi = '150';$hi = '50';
										echo '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="'.$wi.'" height="'.$hi.'">
										  <param name="flash_component" value="ImageViewer.swc" />
										  <param name="movie" value="'.$Globals_Dir.$a_banner['banner_pic'].'" />
										  <param name="quality" value="high" />
										  <param name="FlashVars" value="flashlet={imageLinkTarget:\'_blank\',captionFont:\'Verdana\',titleFont:\'Verdana\',showControls:true,frameShow:false,slideDelay:5,captionSize:10,captionColor:#333333,titleSize:10,transitionsType:\'Random\',titleColor:#333333,slideAutoPlay:false,imageURLs:[\'img1.jpg\',\'img2.jpg\',\'img3.jpg\'],slideLoop:false,frameThickness:2,imageLinks:[\'http://macromedia.com/\',\'http://macromedia.com/\',\'http://macromedia.com/\'],frameColor:#333333,bgColor:#FFFFFF,imageCaptions:[]}" />
										  <embed src="'.$Globals_Dir.$a_banner['banner_pic'].'"  quality="high" flashvars="flashlet={imageLinkTarget:\'_blank\',captionFont:\'Verdana\',titleFont:\'Verdana\',showControls:true,frameShow:false,slideDelay:5,captionSize:10,captionColor:#333333,titleSize:10,transitionsType:\'Random\',titleColor:#333333,slideAutoPlay:false,imageURLs:[\'img1.jpg\',\'img2.jpg\',\'img3.jpg\'],slideLoop:false,frameThickness:2,imageLinks:[\'http://macromedia.com/\',\'http://macromedia.com/\',\'http://macromedia.com/\'],frameColor:#333333,bgColor:#FFFFFF,imageCaptions:[]}" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="'.$wi.'" height="'.$hi.'"> </embed>
										</object><br><br>';
									}else{
									?>
									<img src="../FileMgt/phpThumb.php?src=<?php echo $Globals_Dir?><?php echo $a_banner['banner_pic']; ?>&h=50&w=150" border="1">
									<?php
									}
								 }else{  echo "No image.";   }?>
								</td>
								<td  width="10%" class="text-left"><?php echo $a_banner['banner_name']?></td>
								<td  width="10%" class="text-center" >
								<?php 
								if($a_banner['banner_intro']=='Y'){
									echo '<i class="far fa-check-circle text-medium color-ewt" onclick="JQSetIntro('.$a_banner['banner_id'].',\'UnSetIntro\',);"></i>';
									}else{
									?>						
								<input type="radio" name="intro" id="intro<?php echo $a_banner['banner_id']?>" value="<?php echo $a_banner['banner_id']?>" onclick="JQSetIntro(<?php echo $a_banner['banner_id'];?>,'SetIntro');" >
								<?php } ?>
								</td>  			
								<td width="10%" class="text-center">
								<input class="form-control"  type="text" name="ban_pos[]" id="ban_pos" size="5" value="<?php echo $a_banner['banner_position']?>" onKeyUp="chkformatnum(this)" >
								<input type="hidden" name="ban_id[]" id="ban_id"  value="<?php echo $a_banner['banner_id']?>">
								</td>
								</tr>
								<?php  
									$i++;
										}
								?>
								<tr  class="nodrop nodrag">
									<td colspan="4"  class="text-center" >&nbsp;</td>
									<td class="text-center" >
									<input type="hidden" name="flag" value="tool"> 
									<input type="hidden" name="banner_gid" value="<?php echo $gid;?>">
									<input class="btn btn-success" type="Button" name="Submit" value="<?php echo $text_genbanner_formupdate;?>" onClick="document.frm1.submit();">
									</td>
								</tr>
								<?php } else { ?>
								<tr >
									<th  colspan="5" scope="col"><div align="center" style="color:#FF0000"><?php echo $text_genbanner_notfound?></div></th>
								</tr>
								<?php 
									}
								?>
									</tbody>
									</table>	
									</form>
								</div>
								<? */ ?>

							<div id="sortableLv1" class="col-md-12 d-flex flex-center flex-wrap">
								<?php
								if ($a_rows > 0) {
									$i = 1;
									while ($a_data = $db->db_fetch_array($_sql)) {
										$video = end(explode(".", trim($a_data['banner_pic']))); ?>
										<div class="col-md-2 col-sm-2 col-xs-6 m-b-sm move">
											<div class="card m-b-sm DivCategoryLevel1" id="<?php echo $a_data['banner_id']; ?>" style="width:100%;height:240px;max-height:240px;">
												<div class="card-body">
													<?php if ($video == "mp4" || $video == "wmv") { ?>
														<video autoplay="" muted="" loop="" id="bg-video" style="width:100%;height:auto;max-height:160px;" class="m-b-sm" controls>
															<source type="video/mp4" src="<?php echo $Globals_Dir; ?><?php echo trim($a_data['banner_pic']); ?>">
														</video>
													<?php } else { ?>
														<img src="../ewt/<?php echo $_SESSION["EWT_SUSER"] .'/'.$a_data['banner_pic']; ?>" style="width:100%;height:auto;max-height:160px;" class="m-b-sm">
													<?php } ?>
													<input class="input-inline-sm text-center" name="banner_order[]" id="banner_order<?php echo $a_data['banner_position']; ?>" type="text" value="<?php echo $a_data['banner_position']; ?>" readonly />

													<nobr>
														<a onClick="boxPopup('<?php echo linkboxPopup(); ?>pop_edit_banner.php?ban_id=<?php echo $a_data['banner_id'] ?>&ban_cid=<?php echo $ban_cid; ?>');" data-toggle="tooltip" data-placement="right" title="<?php echo $text_genbanner_altedit; ?>">
															<button type="button" class="btn btn-warning  btn-circle  btn-xs ">
																<i class="fa fa-edit" aria-hidden="true"></i>
															</button>
														</a>
														<a onClick="JQDel_Banner('<?php echo $a_data['banner_id'] ?>');" data-toggle="tooltip" data-placement="right" title="<?php echo $text_genbanner_altdel; ?>">
															<button type="button" class="btn btn-danger  btn-circle  btn-xs ">
																<i class="far fa-trash-alt" aria-hidden="true"></i>
															</button>
														</a>
														<a onClick="boxPopup('<?php echo linkboxPopup(); ?>pop_view_banner.php?ban_id=<?php echo $a_data['banner_id'] ?>');" data-toggle="tooltip" data-placement="right" title="<?php echo "ดูรูปภาพ"; ?>">
															<button type="button" class="btn btn-success  btn-circle  btn-xs ">
																<i class="fas fa-search" aria-hidden="true"></i>
															</button>
														</a>
													</nobr>

												</div>
											</div>
										</div>
										<?php $i++; ?>
									<?php } ?>
								<?php } ?>
								<?php echo pagination_ewt($statement, $perpage, $page, '?ban_cid=' . $ban_cid . $search_pagin.'&'); ?>
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
<script>
	$(function() {
		$("#sortableLv1").sortable({
			placeholder: 'col-md-2 col-sm-2 col-xs-6 m-b-sm drop-placeholder-banner',
			update: function(event, ui) {
				var page_id_array = new Array();
				$('.DivCategoryLevel1').each(function() {
					page_id_array.push($(this).attr("id"));

				});
				console.log(page_id_array);
				$.ajax({
					type: 'POST',
					url: 'func_sortable_banner_list.php',
					data: {
						proc: 'Sortable_Edit',
						page_id_array: page_id_array
					},
					success: function(data) {
						console.log(data);
						location.reload(true);
						//$("#frm_edit_s").load(location.href + " #frm_load");												
						//alert("Data Save: " + data);												
						//self.location.href="article_list.php?cid="+data;											
						//$('#box_popup').fadeOut();
						//document.location.reload();
					}
				});
			}
		});
	});

	function JQDel_Banner(id) {
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
							url: 'func_delete_banner.php',
							data: {
								'id': id,
								'proc': 'DelBanner'
							},
							success: function(data) {
								$.alert({
									title: '',
									content: 'ลบข้อมูลเรียบร้อย',
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

	function JQSetIntro(id, proc) {
		if (proc == 'SetIntro') {
			var con = 'คุณต้องการตั้งค่ารายการนี้หรือไม่?';
		} else if (proc == 'UnSetIntro') {
			var con = 'คุณต้องยกเลิกการตั้งค่ารายการนี้หรือไม่?';
		}

		$.confirm({
			title: 'ตั้งค่า Popup Intro',
			content: con,
			//content: 'url:form.html',
			boxWidth: '30%',
			icon: 'glyphicon glyphicon-question-sign',
			theme: 'modern',
			buttons: {
				confirm: {
					text: 'ยืนยันการตั้งค่า',
					btnClass: 'btn-blue',
					action: function() {
						$.ajax({
							type: 'GET',
							url: 'func_set_intro.php',
							data: {
								'id': id,
								'proc': proc
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
			type: 'blue'
		});
		// });
	}
</script>
<script>
	function clearText(text) {
		$('#' + text).val('');
	}

	function bannerSearch() {
		window.location.href = 'banner_list.php?keyword=' + $('#keyword').val() + '&ban_cid=' + '<?php echo $ban_cid; ?>';
	}
</script>