<?php
	include("../lib/permission1.php");
	include("../lib/include.php");
	include("../lib/function.php");
	include("../lib/user_config.php");
	include("../lib/connect.php");
	$db->query("USE ".$EWT_DB_USER);
	if($flag == 'save') {
		for($i =0; $i<count($user_id); $i++) {
			if(${'under_id'.$user_id[$i]} == 0) {
				$sql_delete = "delete from gen_user_order where gen_user_id = '".$user_id[$i]."'";
				$query_delete = $db->query($sql_delete);
			} else {
				$sql_select = "select * from gen_user_order where gen_user_id = '".$user_id[$i]."'";
				$query_select = $db->query($sql_select);
				if($db->db_num_rows($query_select) > 0) {
					$result_selects = $db->db_fetch_array($query_select);
					$sql_update = "update gen_user_order set order_no = '".${'order'.$user_id[$i]}."', up_user_id = '".${'under_id'.$user_id[$i]}."' where order_id = '".$result_selects['order_id']."'";
					$query_update = $db->query($sql_update);
				} else {
					$sql_insert = "insert into gen_user_order(gen_user_id, up_user_id, order_no) values('".$user_id[$i]."', '".${'under_id'.$user_id[$i]}."', '".${'order'.$user_id[$i]}."')";
					$query_insert = $db->query($sql_insert);
				}
			}
			echo "<script language=\"javascript\">";
			echo "alert('บันทึกข้อมูลเรียบร้อยแล้ว');";
			echo "document.location.href='ManageOrgPreson.php?position_id=".$position_id."';" ;
			echo "</script>";	
		}
	} else {
		if(!isset($position_id)) {
			$sql_position_id = "select min(pos_level), pos_id from position_name group by pos_id";
			$query_position_id = $db->query($sql_position_id);
			$result_position_id = $db->db_fetch_array($query_position_id);
			$position_level = $result_position_id[0];
			$position_id= $result_position_id[1];
		}
		$sql_current_pos = "select * from position_name where pos_id = '".$position_id."'";
		$query_current_pos = $db->query($sql_current_pos);
		$result_current_pos = $db->db_fetch_array($query_current_pos);
		$position_level = $result_current_pos['pos_level'];
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<style>
	h1 { font-size:18px; margin:0 0 20px; }
	a { color:#FFF; }
	.clear { clear:both; font-size:1px; line-height:1px; }
	.ui-sortable { background-color:#FFF; border:1px solid #555; color:#222; margin:0 15px 15px 0; padding:0 10px 10px; width:175px; }
	.ui-sortable h2 { background-color:#E7E7E7; border-bottom:1px solid #666; color:#000; font-size:11px; margin:0 -10px 10px; line-height:2; padding:0 10px; }
	dl.sort { color:#222; margin:10px 0; border:1px solid #555; }
	dl.sort2 { color:#222; margin:10px 0; border:1px solid #555; }
	#uidemo dl.first { margin-top:0; }
	#uidemo dl.last { margin-bottom:0; }
	dl.sort dt { background-color:#666; color:#FFF; cursor:move; height:2em; line-height:2; padding:0 6px; position:relative; }
	dl.sort dd { background-color:#FFF; margin:0; padding:3px 6px; }
	dl.sort2 dt { background-color:#666; color:#FFF; height:2em; line-height:2; padding:0 6px; position:relative; }
	dl.sort2 dd { background-color:#FFF; margin:0; padding:3px 6px; }
	.ui-sortable-helper { width:175px; }
	.placeholder { border:1px dashed #AAA; }
	span.options { cursor:default; font-size:1px; line-height:1px; position:absolute; }
	span.options a { background-color:#FFF; cursor:pointer; display:block; float:left; text-indent:-9000px; }
	.ui-sortable h2 span.options { right:10px; top:8px; width:30px; }
	.ui-sortable h2 span.options a { height:12px; width:30px; }
	dl.sort dt span.options { right:5px; top:5px; width:27px; }
	dl.sort dt span.options a { height:12px; width:12px; }
	dl.sort dt span.options a.up { margin-right:3px; }
	dl.sort dt span.options a.disabled { background-color:#555; cursor:default; }
	#container { float:center; }
	#header { width:100%; }
	#trashcan { float:left; width:90%; }
	#trashcan p { margin:0; }
</style>
<script type="text/javascript" src="js/jquery/jquery-1.2.4b.js"></script>
<script type="text/javascript" src="js/jquery/jquery.livequery.js"></script>
<script type="text/javascript" src="js/jquery/jquery.blockUI.js"></script>
<script type="text/javascript" src="js/jquery/jquery.corner.js"></script>

<script type="text/javascript" src="js/jquery/ui.core.js"></script>
<script type="text/javascript" src="js/jquery/ui.draggable.js"></script>
<script type="text/javascript" src="js/jquery/ui.droppable.js"></script>
<script type="text/javascript" src="js/jquery/ui.sortable.js"></script>
<body leftmargin="0" topmargin="0">
<?php include("../FavoritesMgt/favorites_include.php");?>
<form action="" name="frm_order" id="frm_order" method="post" enctype="multipart/form-data">
<input type="hidden" name="flag" value="save">
<input type="hidden" name="posttion_id" value="<?php echo $position_id?>">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
	<tr><td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"><span class="ewtfunction">บริหารแผนผังบุคลากร</span></td></tr>
</table>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
	    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode("บริหารแผนผังบุคลากร");?>&module=org&url=<?php echo urlencode("ManageOrgPreson.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;
			<input name="submit" type="button" value="แสดงรายละเอียด" id="showDetail" onClick="$('.tblDetail').show(); $(this).hide(); $('#hideDetail').show();">
			<input name="submit" type="button" value="ซ่อนรายละเอียด" id="hideDetail" onClick="$('.tblDetail').hide(); $(this).hide(); $('#showDetail').show();">
			&nbsp;
	        <input name="submit" type="submit" value="บันทึก"></td></tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
	<tr><td align="right"><hr></td></tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
	<tr>
		<td align="center" width="300" valign="top">
			<table width="95%" border="0" cellspacing="1" cellpadding="5" bgcolor="#555555">
				<tr align="center"><td height="20" class="tdLeft" bgcolor="#E7E7E7"><strong>ตำแหน่ง</strong></td></tr>
				<?php 
					$sql_pos = "SELECT * FROM position_name ORDER BY pos_level,pos_name ASC";
					$query_pos = $db->query($sql_pos);
					$num_pos = $db->db_num_rows($query_pos);
					if($num_pos >0){
						for($i_pos = 0 ;$i_pos <$num_pos ;$i_pos++){
							$result_pos = $db->db_fetch_array($query_pos);
				?>
				<tr><td height="20" class="tdLeft" bgcolor="#FFFFFF"><a href="?position_id=<?php echo $result_pos['pos_id']; ?>"><?php echo $result_pos[pos_name];?></a></td></tr>
				<?php 			
						}// end for
					}//end if
				?>
			</table>
		</td>
		<td align="center">
			<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="50%" valign="top" align="center">
						<div id="container" style="height:450px; overflow:auto;">
							<div id="header" class="ui-sortable">
								<h2 align="left">บุคลากรในตำแหน่ง<?php echo $result_current_pos['pos_name']; ?></h2>
								<?php
									$sql_staff = "select * from gen_user LEFT OUTER JOIN `org_name` ON (`gen_user`.`org_id` = `org_name`.`org_id`) where gen_user.posittion = '".$position_id."' ";
									$query_staff = $db->query($sql_staff);
									$i =1;
									while($result_staff = $db->db_fetch_array($query_staff)) {
										$sql_order = "select * from gen_user_order where gen_user_id = '".$result_staff['gen_user_id']."'";
										$query_order = $db->query($sql_order);
										if($db->db_num_rows($query_order) == 0) {
											$sql_title = "select * from title where title_id = '".$result_staff['title_thai']."'";
											$query_title = $db->query($sql_title);
											$result_title = $db->db_fetch_array($query_title);
											$sql_position_staff = "select * from position_name where pos_id = '".$result_staff['posittion']."'";
											$query_position_staff = $db->query($sql_position_staff);
											$result_position_staff = $db->db_fetch_array($query_position_staff);
											if($result_staff[path_image] != ""){
												$path_image = "../ewt/pic_upload/".$result_staff[path_image];
												//if (file_exists($path_image)) {
												   //$path_image = $path_image;
											   //}else{
												   //$path_image = "../images/ImageFile.gif";
											  // }
											}
											//echo $path_image;
								?>
								<dl class="sort" user_id="<?php echo $result_staff['gen_user_id']; ?>">
									<dt>
										<div align="left" style="font-weight:bold">
											<?php echo $result_title['title_thai']; ?><?php echo $result_staff['name_thai']; ?>&nbsp;<?php echo $result_staff['surname_thai']; ?>&nbsp;(<?php echo $result_position_staff['pos_name']?>)
											<input type="hidden" name="user_id[]" id="user_id" value="<?php echo $result_staff['gen_user_id']; ?>">
											<input type="hidden" name="position<?php echo $result_staff['gen_user_id']; ?>" id="position<?php echo $result_staff['gen_user_id']; ?>" value="<?php echo $result_staff['posittion'];?>">
											<input type="hidden" name="under_id<?php echo $result_staff['gen_user_id']; ?>" id="under_id<?php echo $result_staff['gen_user_id']; ?>" value="0">
											<input type="hidden" name="order<?php echo $result_staff['gen_user_id']; ?>" id="order<?php echo $result_staff['gen_user_id']; ?>" value="<?php echo $i;?>">
										</div>
									</dt>
									<dd class="tblDetail">
										<div align="left">
											<table width="90%" border="0" cellspacing="0" cellpadding="0">
												<tr>
													<td width="70" align="center" valign="top">
														<img src="img.php?p=<?php echo base64_encode($path_image); ?>" name="previewField" width="50" height="50" id="previewField" style="border:1px solid #555;" />
													</td>
													<td align="left" valign="top">
														<table width="100%" border="0" cellspacing="1" cellpadding="0">
															<tr>
																<td width="120px" bgcolor="#E7E7E7" style="padding:3px;" align="left" valign="top"><strong>หน่วยงาน&nbsp;:</strong></td>
																<td style="padding:3px;" align="left" valign="top"><?php echo $result_staff['name_org']; ?></td>
															</tr>
															<tr>
																<td bgcolor="#E7E7E7" style="padding:3px;" align="left" valign="top"><strong>ตำแหน่งทางวิชาการ&nbsp;:</strong></td>
																<td style="padding:3px;" align="left" valign="top"><?php echo $result_staff['position_person']; ?></td>
															</tr>
															<tr>
																<td bgcolor="#E7E7E7" style="padding:3px;" align="left" valign="top"><strong>ระดับ&nbsp;(ซี)&nbsp;:</strong></td>
																<td style="padding:3px;" align="left" valign="top"><?php echo $result_staff['org_type_id']; ?></td>
															</tr>
															</table>
													</td>
												</tr>
											</table>
										</div>
									</dd>
								</dl>
								<?php
											$i++;
										}
									}
								?>
							</div>
							<div class="clear"></div>
						</div>
					</td>
					<td align="center" valign="top">
						<div style="height:450px; overflow:auto;">
						<?php
							$sql_up_level = "select * from position_name where pos_level < '".$position_level."' order by pos_level desc limit 0,1";
							$query_up_level = $db->query($sql_up_level);
							if($db->db_num_rows($query_up_level) > 0) {
								$result_up_level = $db->db_fetch_array($query_up_level);
								$position_up_level = $result_up_level['pos_level'];
								$sql_up_position = "select * from position_name where pos_level = '".$position_up_level."'";
								$query_up_position = $db->query($sql_up_position);
								while($result_up_position = $db->db_fetch_array($query_up_position)) {
									$sql_up_staff = "select * from gen_user where gen_user.posittion = '".$result_up_position['pos_id']."'";
									$query_up_staff = $db->query($sql_up_staff);
									while($result_up_staff = $db->db_fetch_array($query_up_staff)) {
										$sql_up_title = "select * from title where title_id = '".$result_up_staff['title_thai']."'";
										$query_up_title = $db->query($sql_up_title);
										$result_up_title = $db->db_fetch_array($query_up_title);
										$sql_position = "select * from position_name where pos_id = '".$result_up_staff['posittion']."'";
										$query_position = $db->query($sql_position);
										$result_position = $db->db_fetch_array($query_position);
						?>
						<div id="upstaff<?php echo $result_up_staff['gen_user_id']; ?>" class="ui-sortable" style="float:center; width:90%;" user_id="<?php echo $result_up_staff['gen_user_id']; ?>" block="trashcan">
							<h2 align="left">บุคลากรที่อยู่ภายใต้&nbsp;<?php echo $result_up_title['title_thai']; ?><?php echo $result_up_staff['name_thai']; ?>&nbsp;<?php echo $result_up_staff['surname_thai']; ?>&nbsp;(<?php echo $result_position['pos_name']?>)</h2>
							<?php
										$sql_order = "select * from gen_user_order where up_user_id = '".$result_up_staff['gen_user_id']."' order by order_no asc";
										$query_order = $db->query($sql_order);
										while($result_order = $db->db_fetch_array($query_order)) {
											$sql_staff = "select * from gen_user  LEFT OUTER JOIN `org_name` ON (`gen_user`.`org_id` = `org_name`.`org_id`) where gen_user_id = '".$result_order['gen_user_id']."'";
											$query_staff = $db->query($sql_staff);
											if($db->db_num_rows($query_staff)==0){
											$db->query("delete from gen_user_order where up_user_id = '".$result_up_staff['gen_user_id']."' ");
											}else{
											$result_staff = $db->db_fetch_array($query_staff);
											$sql_title = "select * from title where title_id = '".$result_staff['title_thai']."'";
											$query_title = $db->query($sql_title);
											$result_title = $db->db_fetch_array($query_title);
											$sql_position_staff = "select * from position_name where pos_id = '".$result_staff['posittion']."'";
											$query_position_staff = $db->query($sql_position_staff);
											$result_position_staff = $db->db_fetch_array($query_position_staff);
											if($result_staff[path_image] != ""){
												$path_image = "../ewt/pic_upload/".$result_staff[path_image];
												if (file_exists($path_image)) {
												   $path_image = $path_image;
											   }else{
												   $path_image = "../images/ImageFile.gif";
											   }
											}
							?>
								<dl <?php /*if($result_staff['posittion'] == $position_id) {*/ echo "class='sort'"; /*} else { echo "class='sort2'"; }*/?> user_id="<?php echo $result_staff['gen_user_id']; ?>">
									<dt>
										<div align="left" style="font-weight:bold">
											<?php echo $result_title['title_thai']; ?><?php echo $result_staff['name_thai']; ?>&nbsp;<?php echo $result_staff['surname_thai']; ?>&nbsp;(<?php echo $result_position_staff['pos_name']?>)
											<input type="hidden" name="user_id[]" id="user_id" value="<?php echo $result_staff['gen_user_id']; ?>">
											<input type="hidden" name="position<?php echo $result_staff['gen_user_id']; ?>" id="position<?php echo $result_staff['gen_user_id']; ?>" value="<?php echo $result_staff['posittion'];?>">
											<input type="hidden" name="under_id<?php echo $result_staff['gen_user_id']; ?>" id="under_id<?php echo $result_staff['gen_user_id']; ?>" value="<?php echo $result_order['up_user_id'];?>">
											<input type="hidden" name="order<?php echo $result_staff['gen_user_id']; ?>" id="order<?php echo $result_staff['gen_user_id']; ?>" value="<?php echo $result_order['order_no'];?>">
										</div>
									</dt>
									<dd class="tblDetail">
										<div align="left">
											<table width="90%" border="0" cellspacing="0" cellpadding="0">
												<tr>
													<td width="70" align="center" valign="top">
														<img src="img.php?p=<?php echo base64_encode($path_image); ?>" name="previewField" width="50" height="50" id="previewField" style="border:1px solid #555;" />
													</td>
													<td align="left" valign="top">
														<table width="100%" border="0" cellspacing="1" cellpadding="0">
															<tr>
																<td width="120px" bgcolor="#E7E7E7" style="padding:3px;" align="left" valign="top"><strong>หน่วยงาน&nbsp;:</strong></td>
																<td style="padding:3px;" align="left" valign="top"><?php echo $result_staff['name_org']; ?></td>
															</tr>
															<tr>
																<td bgcolor="#E7E7E7" style="padding:3px;" align="left" valign="top"><strong>ตำแหน่งทางวิชาการ&nbsp;:</strong></td>
																<td style="padding:3px;" align="left" valign="top"><?php echo $result_staff['position_person']; ?></td>
															</tr>
															<tr>
																<td bgcolor="#E7E7E7" style="padding:3px;" align="left" valign="top"><strong>ระดับ&nbsp;(ซี)&nbsp;:</strong></td>
																<td style="padding:3px;" align="left" valign="top"><?php echo $result_staff['org_type_id']; ?></td>
															</tr>
															</table>
													</td>
												</tr>
											</table>
										</div>
									</dd>
								</dl>
							<?php
											}//End if num rows
										}
							?>
						</div>
						<?php
									}
								}
							}
						?>
						<div class="clear"></div>
						</div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</form>
</body>
</html>
<script language="javascript">
(function($){
	var updateUpDown = function(sortable){
		$('dl:not(.ui-sortable-helper)', sortable)
			.removeClass('first').removeClass('last')
			.find('.up, .down').removeClass('disabled').end()
			.filter(':first').addClass('first').find('.up').addClass('disabled').end().end()
			.filter(':last').addClass('last').find('.down').addClass('disabled').end().end();
	};
	
	var moveUpDown = function(){
		var link = $(this),
			dl = link.parents('dl'),
			prev = dl.prev('dl'),
			next = dl.next('dl');
	
		if(link.is('.up') && prev.length > 0)
			dl.insertBefore(prev);
	
		if(link.is('.down') && next.length > 0)
			dl.insertAfter(next);
	
		updateUpDown(dl.parent());
	};
	
	var addItem = function(){
		var sortable = $(this).parents('.ui-sortable');
		var options = '<span class="options"><a class="up">up</a><a class="down">down</a></span>';
		var tpl = '<dl class="sort"><dt>{name}' + options + '</dt><dd>{desc}</dd></dl>';
		var html = tpl.replace(/{name}/g, 'Dynamic name :D').replace(/{desc}/g, 'Description');
	
		sortable.append(html).sortable('refresh').find('a.up, a.down').bind('click', moveUpDown);
		updateUpDown(sortable);
	};
	
	var emptyTrashCan = function(user){
		alert(user.parents('div'));
	};
	
	var sortableChange = function(e, ui){
		if(ui.sender){
			var w = ui.element.width();
			ui.placeholder.width(w);
			ui.helper.css("width",ui.element.children().width());
		}
	};
	
	var sortableUpdate = function(e, ui){
			if(ui.element[0].id == 'header')  {
				var up_user_id = '0';
			} else {
				var up_user_id = ui.element[0].user_id;
			}
			var i =1;
			$("#"+ui.element[0].id+" > dl").each(function() {
				var dt = $(this).find('dt')
				var hidden_user_id = dt.find('#user_id');
				var user_id = hidden_user_id.val();
				$('#under_id'+user_id).val(up_user_id);
				$('#order'+user_id).val(i);
				if(ui.element[0].id == 'header')  {
					if($('#position'+user_id).val() != '<?php echo $position_id?>') {
						$(this).remove();
					}
				}
				i++;
			});
	};
	
	$(document).ready(function(){
		<?php
			$sql_up_level = "select * from position_name where pos_level < '".$position_level."' order by pos_level desc limit 0,1";
			$query_up_level = $db->query($sql_up_level);
			$array_trashcan = array("'#header'");
			if($db->db_num_rows($query_up_level) > 0) {
				$result_up_level = $db->db_fetch_array($query_up_level);
				$position_up_level = $result_up_level['pos_level'];
				$sql_up_position = "select * from position_name where pos_level = '".$position_up_level."'";
				$query_up_position = $db->query($sql_up_position);
				while($result_up_position = $db->db_fetch_array($query_up_position)) {
					$sql_up_staff = "select * from gen_user where gen_user.posittion = '".$result_up_position['pos_id']."'";
					$query_up_staff = $db->query($sql_up_staff);
					while($result_up_staff = $db->db_fetch_array($query_up_staff)) {
						array_push($array_trashcan, "'#upstaff".$result_up_staff['gen_user_id']."'");
					}
				}
			}
		?>
		var els = [<?php echo implode(', ', $array_trashcan); ?>];
		var $els = $(els.toString());
		
		//$('h2', $els.slice(0,-1)).append('<span class="options"><a class="add">add</a></span>');
		//$('dt', $els).append('<span class="options"><a class="up">up</a><a class="down">down</a></span>');
		
		//$('a.add').bind('click', addItem);
		//$('a.up, a.down').bind('click', moveUpDown);
		
		$els.each(function(){
			updateUpDown(this);
		});
		
		$els.sortable({
			items: '> dl.sort',
			handle: 'dt div',
			cursor: 'move',
			//cursorAt: { top: 2, left: 2 },
			opacity: 0.5,
			helper: 'clone',
			appendTo: 'body',
			placeholder: 'clone',
			placeholder: 'placeholder',
			connectWith: els,
			start: function(e,ui) {
				ui.helper.css("width", ui.item.width());
			},
			change: sortableChange,
			update: sortableUpdate
		});
		$('#hideDetail').hide();
		$('.tblDetail').hide();
		$("#header").corner("5px top");
	});
	
	$(window).bind('load',function(){
		setTimeout(function(){
			$('#overlay').fadeOut(function(){
				$('body').css('overflow', 'auto');
			});
		}, 750);
	});
})(jQuery);
</script>
<?php
	}
?>
<?php $db->db_close(); ?>