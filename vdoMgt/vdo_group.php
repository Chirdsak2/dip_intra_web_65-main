<?php
include("../EWT_ADMIN/comtop.php");
?>

<!-- START CONTAINER  -->
<div class="container-fluid">
	<?php
	include("menu-top.php");

	$perpage = 12;
	$page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);
	if ($page <= 0) $page = 1;
	$start = ($page * $perpage) - $perpage;

	$_sql = $db->query("SELECT * FROM vdo_group ORDER BY vdog_id DESC LIMIT {$start} , {$perpage} ");

	$statement = "SELECT count(vdog_id) AS b
			  FROM vdo_group {$wh} ";

	$a_rows = $db->db_num_rows($_sql);
	$s_count = $db->query($statement);
	$a_count = $db->db_fetch_array($s_count);
	$total_record = $a_count['b'];
	$total_page = (int)ceil($total_record / $perpage);
	?>


	<link rel="stylesheet" type="text/css" href="../js/FolderPreviewIdeas-master/css/demo.css" />
	<script>
		document.documentElement.className = 'js';
		var supportsCssVars = function() {
			var s = document.createElement('style'),
				support;

			s.innerHTML = "root: { --tmp-var: bold; }";
			document.head.appendChild(s);
			support = !!(window.CSS && window.CSS.supports && window.CSS.supports('font-weight', 'var(--tmp-var)'));
			s.parentNode.removeChild(s);
			return support;
		}
		if (!supportsCssVars()) alert('Please view this demo in a modern browser that supports CSS Variables.')
	</script>

	<script src="../js/FolderPreviewIdeas-master/js/anime.min.js"></script>
	<script src="../js/FolderPreviewIdeas-master/js/charming.min.js"></script>
	<script src="../js/FolderPreviewIdeas-master/js/main.js"></script>
	<style type="text/css">
		/*
.border_dashed { 
   argin-top: 10px;
   margin-right: 0px;
   margin-bottom: 5px;
   margin-left: 0px;
   padding:0px 10px 10px 10px;
   _border-top: 2px dashed #cbcccc;
   border-top: 3px dashed #cbcccc;
   border-bottom: 3px dashed #cbcccc;
   border-right: 3px dashed #cbcccc;
   border-left: 3px dashed #cbcccc;
   text-align:center;
}
.border_dashed:hover { 
   border-top: 3px dashed #cbcccc;
   border-bottom: 3px dashed #cbcccc;
   border-right: 3px dashed #cbcccc;
   border-left: 3px dashed #cbcccc;
   background-color:#f9f9f9;
   
}
.jFiler-input-icon {
    font-size: 48px;
    margin-top: -10px;
    -webkit-transition: all 0.3s ease;
    -moz-transition: all 0.3s ease;
    transition: all 0.3s ease;
}

*/
	</style>
	<div class="row m-b-sm">
		<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">
			<!--start card -->
			<div class="card">
				<!--start card-header -->
				<div class="card-header">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">

							<h4><?= $txt_vdo_cate; ?></h4>
							<p></p>

						</div>

						<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<ol class="breadcrumb">
									<li><a href="vdo_group.php"><?= $txt_vdo_cate; ?></a></li>
									<li class=""></li>
								</ol>
							</div>

							<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs">
								<a onClick="boxPopup('<?= linkboxPopup(); ?>pop_add_vdo_group.php');" title="<?= $txt_vdo_add_cate; ?>" target="_self">
									<button type="button" class="btn btn-info  btn-ml">
										<i class="fas fa-plus-circle"></i>&nbsp;<?= $txt_vdo_add_cate; ?>
									</button>
								</a>
								<a onClick="boxPopup('<?= linkboxPopup(); ?>pop_add_vdo.php?vdo_cid=<?= $vdo_cid; ?>');" title="<?= $txt_vdo_add_vdo; ?>" target="_self">
									<button type="button" class="btn btn-info  btn-ml">
										<i class="fas fa-plus-circle"></i>&nbsp;<?= $txt_vdo_add_vdo; ?>
									</button>
								</a>
								<!--<a  target="_self" onclick="boxPopup('<?= linkboxPopup(); ?>pop_search_vdo.php');"title="<?= $txt_vdo_search_vdo; ?>">
<button type="button" class="btn btn-info  btn-ml " >
<i class="fas fa-search"></i>&nbsp;<?= $txt_vdo_search_vdo; ?>
</button>
</a>-->
							</div>

							<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs">
								<div class="btn-group ">
									<button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span></button>
									<ul class="dropdown-menu dropdown-menu-right">
										<li><a onClick="boxPopup('<?= linkboxPopup(); ?>pop_add_vdo_group.php');"><i class="fas fa-plus-circle"></i>&nbsp;<?= $txt_vdo_add_cate; ?></a></li>
										<li><a onClick="boxPopup('<?= linkboxPopup(); ?>pop_add_vdo.php?vdo_cid=<?= $vdo_cid; ?>');"><i class="fas fa-plus-circle"></i>&nbsp;<?= $txt_vdo_add_vdo; ?></a></li>

									</ul>
								</div>
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

									<div class="col-md-12 col-sm-12 col-xs-12 border_dashed">
										<div class="row codrops-header">
											<?php
											//echo $MAXIMUM_FILESIZE = sizeMB2byte(EwtMaxfile('img')); 
											//  Valid file extensions (images, word, excel, powerpoint) 
											//echo $rEFileTypes = "/^\.(".ValidfileType('img')."){1}$/i"; 				  
											if ($a_rows > 0) {
												$i = 0;
												while ($a_data = $db->db_fetch_array($_sql)) {
											?>
													<div class="col-md-3 col-sm-12 col-xs-12">
														<a href="vdo_list.php?vdo_cid=<?= $a_data['vdog_id']; ?>">
															<section class="content content--ravi" id="ravi--<?= $i; ?>">
																<div class="grid">


																	<div class="grid__item">
																		<div class="folder folder--ravi">
																			<div class="folder__icon folder__icon--perspective">
																				<div class="folder__feedback">
																				</div>
																				<div class="folder__icon-img folder__icon-img--back">
																					<svg class="folder__icon-svg">
																						<use xlink:href="#icon-folderback"></use>
																					</svg>


																				</div>
																				<div class="folder__icon-deco">

																				</div>
																				<div class="folder__preview folder__preview--thumbs">

																					<?php
																					$s_vdo = $db->query("SELECT * 
FROM vdo_list
INNER JOIN vdo_group ON vdo_group.vdog_id = vdo_list.vdo_group 
WHERE vdo_group = '{$a_data['vdog_id']}'
ORDER BY vdo_id DESC LIMIT 0,3");
																					$a_row = $db->db_num_rows($s_vdo);

																					if (!empty($a_data['vdog_image'])) {
																						echo "<img src=\"../ewt/" . $_SESSION["EWT_SUSER"] . "/download/file_vdo/" . $a_data['vdog_image'] . "\" alt=\"" . $a_video['vdo_filename'] . "\"  class=\"folder__thumb\"/>";
																					} else {
																						if ($a_row) {
																							while ($a_video = $db->db_fetch_array($s_vdo)) {

																								$vdo_fileyoutube = str_replace('https://www.youtube.com/watch?v=', '', $a_video['vdo_fileyoutube']);
																								$vdo_image = "../images/pic_preview.gif";
																								if ($a_video['vdo_filename'] != "") {
																									echo "<img src=\"" . $vdo_image . "\" alt=\"" . $a_video['vdo_filename'] . "\"  class=\"folder__thumb\"/>";
																								} else {
																									echo "<img src=\"https://i.ytimg.com/vi/" . $vdo_fileyoutube . "/sddefault.jpg\" class=\"folder__thumb\" />";
																								}
																							}
																						} else {

																							//echo "<img class=\"folder__thumb\" src=\"../js/FolderPreviewIdeas-master/img/photo13.png\" />";
																							//echo "<img class=\"folder__thumb\" src=\"../js/FolderPreviewIdeas-master/img/photo15.png\" />";
																							//echo "<img class=\"folder__thumb\" src=\"../js/FolderPreviewIdeas-master/img/photo14.png\ />";	

																						}
																					}
																					?>
																				</div>
																				<div class="folder__icon-img folder__icon-img--cover">
																					<svg class="folder__icon-svg">
																						<use xlink:href="#icon-foldercover"></use>
																					</svg>
																					<svg class="folder__icon-svg folder__icon-svg--deco">
																						<use xlink:href="#icon-cloud"></use>
																					</svg>

																				</div>
																			</div>
																			<h3 class="folder__caption"><?= $a_data['vdog_name']; ?>
																			</h3>
																			<br>
																			<a onClick="txt_data('<?= $a_data['vdog_id']; ?>','')">
																				<button type="button" class="btn btn-info  btn-circle  btn-xs " id="lang<?= $a_data['vdog_id']; ?>" data-toggle="tooltip" data-placement="top" title="<?= $txt_ewt_create_multilang; ?>">
																					<i class="fa fa-language" aria-hidden="true"></i>
																				</button>
																			</a>
																			<a onClick="boxPopup('<?= linkboxPopup(); ?>pop_edit_vdo_group.php?vdog_id=<?= $a_data['vdog_id']; ?>');">
																				<!--<button type="button" class="btn btn-default btn-circle btn-sm "  data-toggle="tooltip" data-placement="top" title="<?= "แก้ไขหมวดวีดีโอ"; ?>" >-->
																				<button type="button" class="btn btn-default btn-circle  btn-xs" data-toggle="tooltip" data-placement="top" title="<?= "แก้ไขหมวดวีดีโอ"; ?>">
																					<i class="far fa-edit" aria-hidden="true"></i>
																				</button>
																			</a>
																			<?php if (empty($a_row)) { ?>
																				<a onClick="JQDelete_Vdo_Group(<?= $a_data['vdog_id'] ?>);">
																					<button type="button" class="btn btn-danger  btn-circle  btn-xs " data-toggle="tooltip" data-placement="top" title="<?= "ลบหมวดวีดีโอ"; ?>">
																						<i class="far fa-trash-alt" aria-hidden="true"></i>
																					</button>
																				</a>
																			<?php } else { ?>
																				<button type="button" disabled class="btn btn-default  btn-circle  btn-xs " data-toggle="tooltip" data-placement="top" title="<?= "ลบหมวดวีดีโอ"; ?>">
																					<i class="far fa-trash-alt" aria-hidden="true"></i>
																				</button>
																			<?php } ?>
																			<br>
																			<!-- <div>
																				<br>
																				<span class="label label-primary "><?= $txt_ewt_multilang; ?></span>
																				<?php if (show_icon_lang($a_data['vdog_id'], 'vdo_group')) { ?>
																					<?= show_icon_lang($a_data['vdog_id'], 'vdo_group'); ?>
																				<?php } ?>
																			</div> -->

																		</div>

																	</div>


																</div><!-- /grid-->
															</section>

														</a>
													</div>
													<script>
														(function() {
															new RaviFx(document.querySelector('#ravi--<?= $i; ?>'));
														})();
													</script>
											<?php
													$i++;
												}
											} else {

												echo "ไม่พบข้อมูล";
											}
											?>

										</div>
									</div>
								</div>
							</div>

							<?= pagination_ewt($statement, $perpage, $page, $url = '?'); ?>
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
include("../EWT_ADMIN/combottom.php");
?>
<script>
	function JQDelete_Vdo_Group(id) {
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
							url: 'func_delete_vdo_group.php',
							data: {
								'id': id,
								'proc': 'DelGroup'
							},
							success: function(data) {
								$.alert({
									title: '',
									theme: 'modern',
									content: 'ลบข้อมูลเรียบร้อย',
									boxWidth: '30%',
									onAction: function() {
										//self.location.href="vdo_group.php";	
										location.reload(true);
										$('#box_popup').fadeOut();
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

	function txt_data(w, g) {
		$.ajax({
			type: 'GET',
			url: 'pop_set_lang_vdo_group.php?gid=' + g + '&id=' + w,
			beforeSend: function() {
				$('#box_popup').html('');
			},
			success: function(data) {
				$('#box_popup').html(data);
			}

		});

		$('#box_popup').fadeIn();
	}

	function txt_data1(w, g, lang) {
		$.ajax({
			type: 'GET',
			url: 'pop_vdo_group_multilang.php?langid=' + g + '&lang=' + lang + '&id=' + w,
			beforeSend: function() {
				$('#box_popup').html('');
			},
			success: function(data) {
				$('#box_popup').html(data);
			}

		});
		$('#box_popup').fadeIn();
	}
</script>

<svg class="hidden">
	<symbol id="icon-arrow" viewBox="0 0 24 24">
		<title>arrow</title>
		<polygon points="6.3,12.8 20.9,12.8 20.9,11.2 6.3,11.2 10.2,7.2 9,6 3.1,12 9,18 10.2,16.8 " />
	</symbol>
	<symbol id="icon-drop" viewBox="0 0 24 24">
		<title>drop</title>
		<path d="M12,21c-3.6,0-6.6-3-6.6-6.6C5.4,11,10.8,4,11.4,3.2C11.6,3.1,11.8,3,12,3s0.4,0.1,0.6,0.3c0.6,0.8,6.1,7.8,6.1,11.2C18.6,18.1,15.6,21,12,21zM12,4.8c-1.8,2.4-5.2,7.4-5.2,9.6c0,2.9,2.3,5.2,5.2,5.2s5.2-2.3,5.2-5.2C17.2,12.2,13.8,7.3,12,4.8z" />
		<path d="M12,18.2c-0.4,0-0.7-0.3-0.7-0.7s0.3-0.7,0.7-0.7c1.3,0,2.4-1.1,2.4-2.4c0-0.4,0.3-0.7,0.7-0.7c0.4,0,0.7,0.3,0.7,0.7C15.8,16.5,14.1,18.2,12,18.2z" />
	</symbol>
	<symbol id="icon-folderback" viewBox="0 0 20 16">
		<title></title>
		<path d="M7.5,0C7.4,0,2,0,2,0C0.9,0,0,0.9,0,2l0,12c0,1.1,0.9,2,2,2h16c1.1,0,2-0.9,2-2V4c0-1.1-0.9-2-2-2c0,0-7.5,0-8,0C9,2,9.9,0,7.5,0z" />
	</symbol>
	<symbol id="icon-foldercover" viewBox="0 0 20 16">
		<title></title>
		<path d="M2,2h16c1.1,0,2,0.9,2,2v10c0,1.1-0.9,2-2,2H2c-1.1,0-2-0.9-2-2V4C0,2.9,0.9,2,2,2z" />
	</symbol>
	<symbol id="icon-folderdummy" viewBox="0 0 20 16">
		<title>folder-dummy</title>
		<path d="M7.5,0C7.4,0,2,0,2,0C0.9,0,0,0.9,0,2l0,12c0,1.1,0.9,2,2,2h16c1.1,0,2-0.9,2-2V4c0-1.1-0.9-2-2-2c0,0-7.5,0-8,0C9,2,9.9,0,7.5,0z" />
		<path d="M2,2h16c1.1,0,2,0.9,2,2v10c0,1.1-0.9,2-2,2H2c-1.1,0-2-0.9-2-2V4C0,2.9,0.9,2,2,2z" />
	</symbol>
	<symbol id="icon-users" viewBox="0 0 24 24">
		<title>users</title>
		<path style="opacity:0.3;" d="M22.2,17.7l-4-2c-0.5-0.3-0.8-0.8-0.8-1.3v-1.6c0.1-0.1,0.2-0.3,0.4-0.5c0.5-0.8,0.9-1.6,1.2-2.5
				c0.5-0.2,0.9-0.6,0.9-1.2V7c0-0.4-0.2-0.7-0.4-0.9V3.7c0,0,0.5-3.7-4.6-3.7c-5,0-4.6,3.7-4.6,3.7v2.4C10.1,6.3,9.9,6.7,9.9,7v1.7
				c0,0.4,0.2,0.8,0.6,1c0.4,1.8,1.5,3.1,1.5,3.1v1.5c0,0.6-0.3,1.1-0.8,1.3l-3.7,2c-1.1,0.6-1.7,1.7-1.7,2.9v1.3H24v-1.3
				C24,19.4,23.3,18.3,22.2,17.7z" />
		<path style="opacity:0.5;" d="M7.5,17.7l2.5-1.3c0,0,0,0,0,0l1.2-0.7c0.5-0.3,0.8-0.8,0.8-1.3v-1.5c0,0-0.4-0.5-0.9-1.4l0,0c0,0,0,0,0,0
				c-0.1-0.1-0.1-0.2-0.2-0.3c0,0,0,0,0-0.1c-0.1-0.1-0.1-0.3-0.2-0.4c0,0,0,0,0,0c0-0.1-0.1-0.2-0.1-0.4c0,0,0-0.1,0-0.1
				c0-0.1-0.1-0.3-0.1-0.4c-0.3-0.2-0.6-0.6-0.6-1V7c0-0.4,0.2-0.7,0.4-0.9V3.8C9.8,3.3,8.9,2.9,7.4,2.9c-4,0-4.1,3.3-4.1,3.3v2.1
				C3.1,8.5,2.9,8.8,2.9,9.1v1.4c0,0.4,0.2,0.7,0.5,0.9c0.4,1.6,1.6,2.7,1.6,2.7v1.3c0,0.5-0.3,0.9-0.7,1.1l-2.8,1.7
				C0.6,18.8,0,19.7,0,20.8v1.2h5.8v-1.3C5.8,19.4,6.5,18.3,7.5,17.7z" />
	</symbol>
	<symbol id="icon-file" viewBox="0 0 20 26.8">
		<title>file</title>
		<path d="M2.3,0C1,0,0,1,0,2.3v22.2c0,1.2,1,2.3,2.3,2.3h15.4c1.2,0,2.3-1,2.3-2.3V6l-6-6H2.3z" />
		<path style="opacity:0.1;fill:#000;" d="M13.9,3.7V0l6,6h-3.7C14.9,6,13.9,5,13.9,3.7z" />
	</symbol>
	<symbol id="icon-padlock" viewBox="0 0 24 33.6">
		<title>padlock</title>
		<path d="M23,13.5h-1.7V9.4C21.4,4.2,17.2,0,12,0C6.8,0,2.6,4.2,2.6,9.4v4.1H1c-0.5,0-1,0.4-1,1v18.2c0,0.5,0.4,1,1,1H23c0.5,0,1-0.4,1-1V14.4C24,13.9,23.6,13.5,23,13.5z M13.5,24.5v3.9c0,0.3-0.3,0.6-0.6,0.6h-1.8c-0.3,0-0.6-0.3-0.6-0.6v-3.9c-0.7-0.5-1.1-1.3-1.1-2.1c0-1.4,1.2-2.6,2.6-2.6c1.4,0,2.6,1.2,2.6,2.6C14.6,23.3,14.2,24.1,13.5,24.5z M16.9,13.5H7.1V9.4c0-2.7,2.2-4.9,4.9-4.9c2.7,0,4.9,2.2,4.9,4.9V13.5z" />
	</symbol>
	<symbol id="icon-cloud" viewBox="0 0 24 22.2">
		<title></title>
		<path d="M19.5,5.8c-0.3-1.5-1-2.9-2.2-4c-1.3-1.2-3-1.8-4.7-1.8C11.3,0,10,0.4,8.9,1.1C8,1.7,7.2,2.5,6.6,3.5c-0.2,0-0.5-0.1-0.7-0.1c-2.1,0-3.8,1.7-3.8,3.8c0,0.3,0,0.5,0.1,0.8C0.8,9,0,10.6,0,12.3C0,13.6,0.5,15,1.4,16c1,1.1,2.2,1.7,3.6,1.8c0,0,0,0,0,0h4.2c0.4,0,0.7-0.3,0.7-0.7s-0.3-0.7-0.7-0.7H5c-2-0.1-3.7-2-3.7-4.2c0-1.4,0.8-2.7,2-3.4c0.3-0.2,0.4-0.5,0.3-0.8C3.5,7.8,3.4,7.5,3.4,7.2c0-1.4,1.1-2.5,2.5-2.5c0.3,0,0.6,0,0.8,0.1c0.3,0.1,0.7,0,0.8-0.3c0.9-2,2.9-3.2,5.1-3.2c2.9,0,5.3,2.2,5.6,5.1c0,0.3,0.3,0.5,0.6,0.6c2.2,0.4,3.9,2.4,3.9,4.7c0,2.5-1.9,4.6-4.3,4.8h-3.6c-0.4,0-0.7,0.3-0.7,0.7s0.3,0.7,0.7,0.7h3.7c0,0,0,0,0,0c1.5-0.1,2.9-0.8,4-2c1-1.1,1.6-2.6,1.6-4.1C24,8.9,22.1,6.5,19.5,5.8z M16,12.9c0.3-0.3,0.3-0.7,0-0.9l-3.5-3.5c-0.1-0.1-0.3-0.2-0.5-0.2c-0.2,0-0.3,0.1-0.5,0.2L8,12c-0.3,0.3-0.3,0.7,0,0.9c0.1,0.1,0.3,0.2,0.5,0.2c0.2,0,0.3-0.1,0.5-0.2l2.4-2.4v11c0,0.4,0.3,0.7,0.7,0.7s0.7-0.3,0.7-0.7v-11l2.4,2.4C15.3,13.2,15.7,13.2,16,12.9z" />
	</symbol>
	<symbol id="icon-globe" viewBox="0 0 24 24">
		<title>globe</title>
		<path d="M12,0C5.4,0,0,5.4,0,12s5.4,12,12,12c6.6,0,12-5.4,12-12C24,5.4,18.6,0,12,0z M9.7,4.3l0.6,0.2V3.7l0.2-0.2L10.7,4l0.4,0.5L11,4.8l-0.7,0.2V4.5L9.7,4.9L9.5,4.7L9.7,4.3z M1,11.7c0.1-2.3,0.8-4.5,2.1-6.2c0,0,0.1,0,0.1,0c0,0.2-0.2,0.2,0,0.6c0.3,0.5,0,0.8,0,0.8S2.6,7.4,2.5,7.5C2.3,7.6,2,8.1,2.2,7.9C2.4,7.8,2.7,7.7,2.5,8C2.3,8.3,1.9,8.9,1.8,9.1c-0.1,0.2-0.5,0.7-0.5,1s-0.2,0.7-0.1,1C1.2,11.1,1.1,11.6,1,11.7z M5.3,18.6l-0.2,0.6l0.2,0.5c0,0-0.2,0.2-0.4,0.2c-0.2,0-0.2,0.1-0.4,0.1c-1.6-1.5-2.7-3.4-3.2-5.6c0.1,0,0.1,0.1,0.2,0.1c0.2,0.1,0.2,0.2,0.5,0.3c0.2,0.1,0.3,0.2,0.5,0.3s0.2,0,0.5,0.4C3.4,16,3.3,16,3.4,16.2c0.1,0.2,0.2,0.4,0.3,0.5C3.8,16.9,4,16.9,4.2,17c0.1,0.1,0.3,0.2,0.5,0.2c0.1,0,0.5,0.4,0.7,0.4c0.2,0,0.2,0.5,0.2,0.5L5.3,18.6z M7,2.7C6.4,3.3,6.6,3.1,6.4,3.3C6.3,3.4,6.3,3.5,6.1,3.7C5.8,3.9,5.6,4.1,5.6,4.1L5.2,4.3L4.8,4.1c0,0-0.3,0.1-0.3,0c0,0,0-0.1,0-0.1c1-0.9,2.2-1.7,3.5-2.2C8,1.9,7.8,2.1,7.8,2.1S7.5,2.1,7,2.7z M19.6,17.5c0,0.2-0.1,0.5-0.2,0.6c0,0.2-0.2,0.5-0.4,0.6c-0.1,0.1-0.3,0.3-0.5,0.4c-0.1,0-0.2-0.3-0.2-0.5c0-0.2,0.2-0.6,0.2-0.6s0-0.2,0.1-0.4c0-0.2,0.5-0.4,0.5-0.4l0.3-0.6c0,0,0,0.2,0,0.3C19.7,17,19.6,17.4,19.6,17.5z M19.7,13.6c-0.1,0.1-0.3,0.5-0.5,0.6c-0.1,0.2-0.3,0.4-0.5,0.6c-0.2,0.2-0.2,0.4-0.4,0.6C18.2,15.6,18,16,18,16s0.1,0.8,0.1,1c0,0.2-0.3,0.6-0.3,0.6L17.5,18L17,18.6l0,0.6c0,0-0.4,0.3-0.6,0.5c-0.2,0.2-0.2,0.3-0.3,0.5c-0.2,0.2-0.6,0.5-0.8,0.5c-0.2,0-0.9,0.2-0.9,0.2v-0.4L14.3,20c0,0-0.2-0.5-0.4-0.7c-0.1-0.2-0.1-0.4-0.3-0.6c-0.2-0.2-0.3-0.4-0.3-0.5c0-0.1,0-0.5,0-0.5s0.2-0.5,0.2-0.6c0.1-0.2,0-0.4-0.1-0.6c-0.1-0.2-0.1-0.6-0.1-0.7c0-0.1-0.3-0.3-0.5-0.5c-0.1-0.1-0.1-0.3-0.1-0.5c0-0.2-0.1-0.5-0.1-0.8c0-0.3-0.4-0.1-0.6,0c-0.2,0.1-0.4-0.1-0.4-0.3c0-0.2-0.5,0-0.7,0.1c-0.3,0.2-0.6,0.2-1,0.3c-0.3,0.1-0.5-0.1-0.5-0.1S9.2,13.8,9,13.7c-0.2-0.1-0.4-0.4-0.6-0.6c-0.2-0.2-0.6-0.8-0.6-1.1c0-0.2,0-0.4,0-0.7c0-0.3,0-0.5,0-0.7c0-0.2,0.2-0.5,0.3-0.7c0.1-0.2,0.6-0.5,0.7-0.5C8.9,9.4,9.2,9.2,9.2,9c0-0.2,0.2-0.2,0.2-0.4C9.5,8.4,9.8,8,10.2,8.2c0,0,0.3,0,0.5-0.1c0.1,0,0.5-0.2,0.6-0.2c0.2-0.1,0.6-0.1,0.6-0.1s0.3,0.1,0.4,0.1c0.1,0,0.5-0.1,0.5-0.1S13,8.4,13,8.5c0,0.1,0.1,0.2,0.3,0.3c0.2,0.1,1.2,0.3,1.6,0c0.1-0.1,0.4,0.1,0.4,0.1s1,0.2,1.2,0.3c0.2,0.1,0.5,0.2,0.5,0.3c0.1,0.1,0.4,0.5,0.4,0.6c0,0.1,0.2,0.6,0.3,0.7c0,0.2,0.2,0.6,0.3,0.8c0.1,0.2,0.8,1.1,1.1,1.5l0.7-0.1C19.9,13.1,19.8,13.5,19.7,13.6z M22.7,12.1c0-0.2-0.3-0.7-0.3-0.7S22.2,11,22,10.9c-0.2-0.1-0.3-0.3-0.6-0.5c-0.3-0.2-0.4-0.2-0.7-0.2c-0.2,0-0.5-0.3-0.8-0.5c-0.3-0.2-0.3-0.1-0.3-0.1s0.3,0.5,0.3,0.6s0.4,0.3,0.7,0.2c0,0,0.2,0.5,0.4,0.6s0,0.2-0.3,0.4c-0.2,0.2-0.2,0.1-0.3,0.2c-0.1,0.1-0.5,0.3-0.7,0.4c-0.1,0.1-0.6,0.3-0.9,0.1c-0.1-0.1-0.1-0.4-0.2-0.5c-0.1-0.2-0.9-1.4-1.4-2c-0.1-0.1-0.2-0.4-0.4-0.5c-0.1-0.1,0.3-0.1,0.3-0.1s0-0.3,0-0.5c0-0.2,0-0.5,0-0.5s-0.4,0.2-0.5,0.3c-0.1,0.1-0.2-0.2-0.4-0.4c-0.2-0.2-0.3-0.5-0.4-0.7c0-0.2,0.2-0.3,0.2-0.3l0.4-0.2c0,0,0.5-0.1,0.7,0c0.3,0,0.7,0.1,0.7,0.1s0.1-0.3,0-0.4c-0.2-0.1-0.5-0.3-0.7-0.3c-0.2,0,0.1-0.2,0.3-0.4l-0.5-0.1c0,0-0.4,0.2-0.5,0.2c-0.1,0-0.3,0.1-0.5,0.3C16,6.6,16.2,6.9,16,6.9c-0.2,0.1-0.3,0.1-0.4,0.2c-0.1,0-0.5,0-0.5,0c-0.4,0-0.2,0.4,0,0.5l-0.3-0.4l-0.2-0.6c0,0-0.4-0.2-0.5-0.3c-0.2-0.1-0.7-0.4-0.7-0.4l0,0.4l0.5,0.5l0,0l0.3,0.3l-0.5,0V6.9c-0.8-0.1-0.4-0.3-0.5-0.3c-0.1-0.1-0.4-0.3-0.4-0.3s-0.5,0.1-0.6,0.1c-0.1,0-0.2,0.2-0.4,0.2c-0.2,0.1-0.4,0.2-0.4,0.3s-0.4,0.5-0.5,0.7c-0.2,0.2-0.5,0.1-0.6,0.1c-0.1,0-0.7-0.2-0.7-0.2V6.9c0,0,0.1-0.4,0-0.5l0.4-0.1l0.6-0.1l0.2-0.1l0.3-0.3c0,0-0.3-0.2-0.1-0.5c0.1-0.1,0.5-0.2,0.6-0.3c0.2-0.1,0.4-0.2,0.4-0.2s0.3-0.2,0.6-0.5c0,0,0.2-0.1,0.5-0.2c0,0,0.7,0.6,0.8,0.6s0.6-0.3,0.6-0.3s0.1-0.4,0.1-0.5c0-0.1-0.2-0.5-0.2-0.5S14,3.5,13.8,3.7C13.7,3.8,13.6,4,13.6,4S13,4,13,3.9c0-0.1-0.1-0.3-0.2-0.5c0-0.1-0.4-0.1-0.6,0c-0.2,0.1,0-0.4,0-0.4s0.2-0.3,0.4-0.3c0.2,0,0.5-0.2,0.7-0.3C13.5,2.3,14,2,14.2,2c0.2,0,0.5,0,0.6,0c0.1,0,0.6,0,0.6,0L16.3,2c0,0,0.7,0.3,0.5,0.5c0,0,0.3,0.2,0.4,0.3c0.1,0.1,0.4-0.1,0.6-0.2C20.9,4.6,23,8.1,23,12c0,0.2,0,0.4,0,0.6C22.9,12.4,22.7,12.2,22.7,12.1z M9.9,4.5L9.9,4.5L9.9,4.5L9.9,4.5z" />
	</symbol>
</svg>