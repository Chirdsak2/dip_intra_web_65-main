<?php
include("../EWT_ADMIN/comtop.php");
$cid = (int)(!isset($_GET['cid']) ? '' : $_GET['cid']);
$nid = (int)(!isset($_GET['nid']) ? '' : $_GET['nid']);

function article_group_parent($id)
{
	global $db;

	$s_parent = $db->query("SELECT * FROM article_group WHERE c_id = '{$id}' ");
	if ($db->db_num_rows($s_parent)) {
		$a_parent = $db->db_fetch_array($s_parent);
		$txt = "<li ><a href =\"article_group.php?cid=" . $a_parent['c_id'] . "\">" . $a_parent['c_name'] . "</a></li>";
		if ($a_parent['c_parent'] != "0" and $a_parent['c_parent'] != "") {
			$txt = article_group_parent($a_parent['c_parent']) . $txt;
		}
	}
	return $txt;
}

$time_H = array('00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23');
$time_s = array('00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45', '46', '47', '48', '49', '50', '51', '52', '53', '54', '55', '56', '57', '58', '59');

$sql_edit = $db->query("SELECT * FROM article_list WHERE n_id = '" . $_GET["nid"] . "' ");
$R = $db->db_fetch_array($sql_edit);
$date = explode("-", $R["n_date"]);
$date1 = explode("-", $R["expire"]);
if ($R["n_date_start"] != '' && $R["n_date_end"] != '') {
	$date_start = explode(" ", $R["n_date_start"]);
	$time = explode(':', $date_start[1]);
	$time_Hn_start = $time[0];
	$time_sn_start = $time[1];
	$date_start = explode("-", $date_start[0]);

	$date_end = explode(" ", $R["n_date_end"]);
	$time_end = explode(':', $date_end[1]);
	$time_Hn_end = $time_end[0];
	$time_sn_end = $time_end[1];

	$date_end = explode("-", $date_end[0]);
	$date_start = $date_start[2] . "/" . $date_start[1] . "/" . $date_start[0];
	$date_end = $date_end[2] . "/" . $date_end[1] . "/" . $date_end[0];
} else {

	$date_start  = '';
	$date_end = '';
	$time_Hn_start = '';
	$time_sn_start = '';
	$time_Hn_end = '';
	$time_sn_end = '';
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
			$txt = "article_list.php?cid={$cid}";
		}
	} else {
		$txt = "article_group.php";
	}
	return $txt;
}

$sql_group = $db->query("SELECT * FROM article_group WHERE c_id = '{$R['c_id']}' ");
$G = $db->db_fetch_array($sql_group);
?>
<!-- START CONTAINER  -->
<div class="container-fluid">
	<?php
	include("menu-top.php");
	?>
	<style type="text/css">
		.head_table {
			border-bottom: "buttonshadow solid 1px";
			border-left: "buttonhighlight solid 1px";
			border-right: "buttonshadow solid 1px";
			border-top: "buttonhighlight solid 1px";
		}

		.style1 {
			color: #FF0000
		}

		.bootstrap-tagsinput{
			width: 100%;
		}
	</style>

	<div id="nav" style="position:absolute;width:262px; height:280px; z-index:1;display:none"></div>
	<div class="row m-b-sm">
		<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">
			<!--start card -->
			<div class="card">
				<!--start card-header -->
				<div class="card-header">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">
							<h4><?php echo $txt_article_edit; ?></h4>
							<p></p>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<ol class="breadcrumb">
									<li><a href="article_group.php"><?php echo $txt_article_group; ?></a></li>
									<?php echo article_group_parent($cid); ?>
								</ol>
							</div>

							<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs">
								<a href="<?php echo article_backto($cid); ?>" target="_self">
									<button type="button" class="btn btn-info  btn-ml ">
										<i class="fas fa-undo-alt"></i>&nbsp;<?php echo $txt_ewt_back; ?>
									</button>
								</a>
							</div>

							<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs">
								<div class="btn-group ">
									<button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span></button>
									<ul class="dropdown-menu dropdown-menu-right">
										<li><a href="<?php echo article_backto($cid); ?>"><i class="fas fa-undo-alt"></i>&nbsp;<?php echo $txt_ewt_back; ?></a>
										</li>
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
									<form action="article_function.php" method="post" enctype="multipart/form-data" name="form1" onSubmit="return chk();">

										<div class="form-group row">
											<div class="col-md-12 col-sm-12 col-xs-12">
												<label for="topic"><b><?php echo "หัวข้อข่าว"; ?>&nbsp;<span class="text-danger"><code>*</code></span> : </b></label>
												<textarea name="topic" cols="60" rows="5" id="topic" class="form-control"><?php echo $R['n_topic']; ?></textarea>
											</div>
										</div>

										<div class="form-group row">
											<div class="col-md-12 col-sm-12 col-xs-12">
												<label for="c_name"><b><?php echo "กลุ่มข่าว"; ?>&nbsp;<span class="text-danger"><code>*</code></span> : </b></label>
												<div class="form-inline">
													<span id="txtshow"><?php echo $G['c_name']; ?></span>
													<a href="#browse" onClick="boxPopup('<?php echo linkboxPopup(); ?>pop_article_select.php?cid=<?php echo $cid; ?>');">
														<button type="button" class="btn btn-info  btn-sm ">
															<i class="fas fa-folder-open"></i>&nbsp;เลือกกลุ่มข่าว
														</button>
													</a>
													<input name="cid" type="hidden" id="cid" value="<?php echo $_GET['cid']; ?>">
												</div>
											</div>
										</div>

										<div class="form-group row">
											<div class="col-md-12 col-sm-12 col-xs-12">
												<label for="description"><b><?php echo "รายละเอียดหัวข้อข่าว"; ?> :
													</b></label>
												<textarea name="description" cols="60" rows="5" id="description" class="form-control"><?php echo $R['n_des']; ?></textarea>
											</div>
										</div>

										<div class="form-group row">
											<div class="col-md-4 col-sm-4 col-xs-12">
												<label for="date_n"><b><?php echo "วันที่ข่าว"; ?>&nbsp;<span class="text-danger"><code>*</code></span> : </b></label>
												<div class='input-group date datepicker' id='datetimepicker'>
													<input name="date_n" id="date_n" type="text" class="form-control form-control-sm " value="<?php echo $date[2] . "/" . $date[1] . "/" . $date[0]; ?>" readonly="readonly" required />
													<span class="input-group-addon">
														<a href="#date" onClick="return show_calendar('form1.date_n');">
															<span class="glyphicon glyphicon-calendar"></span>
														</a>
													</span>
												</div>
											</div>
											<div class="col-md-2 col-sm-2 col-xs-12">
												<label for="time_n"><b><?php echo "เวลาข่าว"; ?> : </b></label>
												<div class="form-inline">
													<div class="checkbox">
														<label>
															<input name="checkbox" type="checkbox" value="Y" onClick="chktime(this);" <?php echo ($R['n_time'] != "") ? "checked" : null; ?> />
															<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>&nbsp;แสดงเวลา
														</label>
													</div>
													<input name="time_n" type="text" id="time_n" style="display:none;width:50%;" class="form-control" value="<?php echo $R['n_time']; ?>" />
												</div>
											</div>
										</div>

										<div class="form-group row">
											<div class="col-md-6 col-sm-6 col-xs-12">
												<label for="file"><b><?php echo "รูปประกอบข่าวในหน้าแรก"; ?> : </b></label>
												<input type="file" name="file" id="file" onchange="JSCheck_Img(this.id,this.value);" class="form-control" />
												<?php
												$sql_Imsize = "SELECT site_info_max_img,site_type_img_file FROM site_info";
												$query_Imsize = $db->query($sql_Imsize);
												$rec_Imsize = $db->db_fetch_array($query_Imsize);
												?>
												<span class="text-danger"><code>
														<?php echo $rec_Imsize['site_type_img_file']; ?></code></span>
												<br>
												<span class="text-danger">
													<code>
														ขนาดไฟล์ไม่เกิน <?php echo $rec_Imsize['site_info_max_img']; ?> MB.
													</code>
												</span>
											</div>
											<div class="col-md-6 col-sm-6 col-xs-12">
												<?php if ($R['picture'] != "") { ?>
													<img src="<?php echo "../ewt/" . $_SESSION["EWT_SUSER"] . "/images/article/news" . $_GET["nid"] . "/" . $R["picture"]; ?>" height="120" width="120" border="0" align="absmiddle" class="img-thumbnail">
													<input name="pict" type="hidden" id="pict" value="<?php echo $R['picture']; ?>">
													<div class="radio">
														<label><input type="checkbox" name="cpic" value="Y">ลบรูปภาพ</label>
													</div>
												<?php } ?>
											</div>

											<div class="col-md-12 col-sm-12 col-xs-12">
												<label for="article_tag">
													<b> Tags : <br>
														<span style="color:red">ใช้เครื่องหมาย , เพื่อแยก tag
															หรือคลิกนอกช่องใส่ tag</span>
													</b>
												</label>

												<?php
												$article_tag = "";
												$tag_data = $db->query("SELECT tag_name FROM article_taglist WHERE n_id = '$nid' AND lang_id = '1' ORDER BY taglist_id");
												while ($tag_info = $db->db_fetch_array($tag_data)) {
													$article_tag .= $tag_info["tag_name"] . ",";
												}

												$article_tag = rtrim($article_tag, ",");
												?>
												<input type="text" name="article_tag" id="article_tag" class="form-control" data-role="tagsinput" value="<?php echo $article_tag; ?>">
											</div>
										</div>

										<?php
										if ($R['news_use'] == "2" || $R['news_use'] == "3") {
											$a_link = "article_detail.php";
										?>
											<div class="form-group row">
												<div class="col-md-4 col-sm-4 col-xs-12">
													<label for=""><b><?php echo "รายละเอียด"; ?> : </b></label>
													<div class="form-inline">
														<a onclick="self.location.href='<?php echo $a_link; ?>?nid=<?php echo $R['n_id']; ?>';" title="แก้บไขรายละเอียด">
															<button type="button" class="btn btn-warning btn-sm">
																<i class="fas fa-edit"></i>&nbsp;แก้ไขรายละเอียด
															</button>
														</a>
													</div>
												</div>

												<div class="col-md-4 col-sm-4 col-xs-12">
													<label for=""><b><?php echo "เอกสารแนบ"; ?> : </b></label>
													<div class="form-inline">
														<a onclick="self.location.href='article_upload_file.php?nid=<?php echo $R['n_id']; ?>&cid=<?php echo $R['c_id'] ?>';" title="แก้ไขเอกสารแนบ">
															<button type="button" class="btn btn-warning btn-sm">
																<i class="fas fa-edit"></i>&nbsp;แก้ไขเอกสารแนบ
															</button>
														</a>
													</div>
												</div>
											</div>
										<?php } else { ?>
											<div class="form-group row">
												<div class="col-md-12 col-sm-12 col-xs-12">
													<label for=""><b><?php echo "เลือก  URL ของเว็บหรือไฟล์ "; ?> : <b></label>
													<div class="form-inline">
														<input type="text" class="form-control" name="link" id="link" value="<?php echo ($R['link_html']==1) ? $R['link_html'] : null; ?>" style="width:94%" />
														<input type="hidden" name="hdd_file" value="<?php echo $R['link_html']; ?>">
														<a href="#browse" onClick="win2 = window.open('../FileMgt/article_main.php?stype=link&Flag=Link&o_value=window.opener.document.form1.link.value','WebsiteLink','top=100,left=100,width=800,height=500,resizable=1,status=0');document.form1.browsefile[0].checked=true;win2.focus();">
															<button type="button" class="btn btn-info btn-sm">
																<i class="fas fa-folder-open"></i>&nbsp;เลือกไฟล์
															</button>
														</a>
													</div>
												</div>
											</div>
											<div class="form-group row">
												<div class="col-md-12 col-sm-12 col-xs-12">
													<label for="filebrowse"><?php echo "เลือกไฟล์จากเครื่อง "; ?> : </label>
													<input type="file" name="filebrowse" id="filebrowse" value="<?php echo ($R['link_html']!=1) ? $R['link_html'] : null; ?>" onchange="JSCheck_file(this.id,this.value);" onClick="document.form1.browsefile[1].checked=true" class="form-control" />
													<a target="_blank" href="<?php echo ($R['link_html']!=1) ? "../ewt/" . $_SESSION["EWT_SUSER"] . "/".$R['link_html'] : null; ?>"><?php echo ($R['link_html']!=1) ? $R['link_html'] : null; ?></a>
												</div>
												<div class="col-md-12 col-sm-12 col-xs-12">
													<label for=""><?php echo ""; ?></label>
													<div class="checkbox">
														<label>
															<input name="chk_show_count_level1" type="checkbox" id="chk_show_count_level1" value="3" <?php echo ($R['show_count'] == 3) ? "checked" : null; ?> />
															<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>&nbsp;แสดงจำนวนการดาวน์โหลด
															[ ครั้ง ]
														</label>
													</div>
												</div>
											</div>

											<div class="form-group row">
												
											</div>

										<?php } ?>
										<div class="form-group row">
											<div class="col-md-4 col-sm-4 col-xs-12">
												<label for="target"><b><?php echo "ลักษณะการเชื่อมต่อ"; ?>&nbsp;<span class="text-danger"><code>*</code></span> : </b></label>
												<select name="target" id="select" class="form-control">
													<option value="_blank" <?php echo ($R['target'] == "_blank") ? "selected" : null; ?>>เปิดหน้าต่างใหม่</option>
													<option value="_self" <?php echo ($R['target'] == "_self") ? "selected" : null; ?>>เปิดหน้าต่างเดิม</option>
												</select>
											</div>
											<div class="col-md-1 col-sm-1 col-xs-12">
												&nbsp;
											</div>
											<?php
											$dateshowl = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d") + 5, date("Y")));
											$date = explode("-", $dateshowl);
											?>
										</div>

										<div class="form-group row">
											<div class="col-md-4 col-sm-4 col-xs-12">
												<label for="date_start"><b><?php echo "วันที่เริ่มต้นแสดงข่าว"; ?> : </b></label>
												<div class='input-group date datepicker' id='datetimepicker2'>
													<input name="date_start" id="date_start" type="text" class="form-control form-control-sm " value="<?php echo $date_start; ?>" />
													<span class="input-group-addon">
														<a href="#date" onClick="return show_calendar('form1.date_start');">
															<i class="far fa-calendar-alt"></i>
														</a>
													</span>
												</div>
											</div>
											<div class="col-md-2 col-sm-2 col-xs-12">
												<label for="target"><b><?php echo "เวลาเริ่มต้นแสดงข่าว"; ?> : </b></label>
												<div class="form-inline">
													<select name="time_H_start" class="form-control">
														<option value=""></option>
														<?php for ($i = 0; $i < count($time_H); $i++) { ?>
															<option value="<?php echo $time_H[$i]; ?>" <?php echo ($time_Hn_start == $time_H[$i]) ? 'selected' : null; ?>><?php echo $time_H[$i]; ?></option>
														<?php } ?>
													</select>
													:
													<select name="time_s_start" class="form-control">
														<option value=""></option>
														<?php for ($i = 0; $i < count($time_s); $i++) { ?>
															<option value="<?php echo $time_s[$i]; ?>" <?php echo ($time_sn_start == $time_s[$i]) ? 'selected' : null; ?>><?php echo $time_s[$i]; ?></option>
														<?php } ?>
													</select> น.

												</div>
											</div>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<label for="date_end"><b><?php echo "วันที่สิ้นสุดแสดงข่าว"; ?> : </b></label>
												<div class='input-group date datepicker' id='datetimepicker3'>
													<input name="date_end" id="date_end" type="text" class="form-control form-control-sm " value="<?php echo $date_end; ?>" />
													<span class="input-group-addon">
														<a href="#date">
															<i class="far fa-calendar-alt"></i>
														</a>
													</span>
												</div>
											</div>
											<div class="col-md-2 col-sm-2 col-xs-12">
												<label for="target"><b><?php echo "เวลาสิ้นสุดแสดงข่าว"; ?> : </b></label>
												<div class="form-inline">
													<select name="time_H_end" class="form-control">
														<option value=""></option>
														<?php for ($i = 0; $i < count($time_H); $i++) { ?>
															<option value="<?php echo $time_H[$i]; ?>" <?php echo ($time_Hn_end == $time_H[$i]) ? 'selected' : null; ?>><?php echo $time_H[$i]; ?></option>
														<?php } ?>
													</select>
													:
													<select name="time_s_end" class="form-control">
														<option value=""></option>
														<?php for ($i = 0; $i < count($time_s); $i++) { ?>
															<option value="<?php echo $time_s[$i]; ?>" <?php echo ($time_sn_end == $time_s[$i]) ? 'selected' : null; ?>><?php echo $time_s[$i]; ?></option>
														<?php } ?>
													</select> น.
												</div>
											</div>

											<div class="clearfix">&nbsp;</div>
											<div class="form-group row ">
												<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center;top:50px;">

													<button type="submit" class="btn btn-success  btn-ml ">
														<span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;<?php echo "บันทึก"; ?>
													</button>

													<input name="Flag" type="hidden" id="Flag" value="EditArticle" />
													<input name="nid" type="hidden" id="nid" value="<?php echo $_GET['nid']; ?>" />
													<input name="nuse" type="hidden" id="nuse" value="<?php echo $R['news_use']; ?>" />

													<button type="reset" class="btn btn-warning  btn-ml ">
														<span class="glyphicon glyphicon-repeat"></span>&nbsp;<?php echo "ยกเลิก"; ?>
													</button>

													<input type="hidden" id="temp_num" name="temp_num" value="1" />
													<input type="hidden" id="temp_num2" name="temp_num2" value="1" />
													<input type="hidden" id="temp_num3" name="temp_num3" value="1" />
												</div>
											</div>
											<div class="clearfix">&nbsp;</div>
											<div class="clearfix">&nbsp;</div>
										</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>

			<!--END card-->
		</div>
	</div>

</div>
<!-- END CONTAINER  -->
<?php
include("../EWT_ADMIN/combottom.php");
?>
<script>
	$(document).ready(function() {
		var today = new Date();
		$('.datepicker')
			.datepicker({
				format: 'dd/mm/yyyy',
				language: 'th-th',
				leftArrow: '<i class="fas fa-angle-double-left"></i>',
				rightArrow: '<i class="fas fa-angle-double-right"></i>',
			})
	});

	function show() {
		var b = document.getElementById("showvdo").value;
		var bc = document.getElementById("showvdo1").value;
		if (document.getElementById("showvdo").checked == true) {
			document.getElementById("vdomore2").style.display = '';
			document.getElementById("vdomore3").style.display = 'none';
		}
		if (document.getElementById("showvdo1").checked == true) {
			document.getElementById("vdomore2").style.display = 'none';
			document.getElementById("vdomore3").style.display = '';
		}
	}


	function tab(id) {

		if (id == '2') {
			document.getElementById("vdomore").style.display = '';
			document.getElementById("experiences").style.display = '';
			document.getElementById("trb01").style.display = 'none';
			document.getElementById("trb02").style.display = '';
			document.getElementById("trb04").style.display = 'none';
			document.getElementById("trb05").style.display = 'none';

		} else {
			document.getElementById("vdomore").style.display = 'none';
			document.getElementById("experiences").style.display = 'none';
			document.getElementById("vdomore2").style.display = 'none';
			document.getElementById("vdomore3").style.display = 'none';
			document.getElementById("trb01").style.display = '';
			document.getElementById("trb02").style.display = 'none';
			document.getElementById("trb04").style.display = 'none';
			document.getElementById("trb05").style.display = 'none';

		}
	}

	function del_row(id) {
		if (confirm('คุณต้องการลบรายการ?')) {
			$('#tr_' + id).remove();
			$('#filevdo' + id).val('del');

		}
	}

	function del_row3(id) {
		if (confirm('คุณต้องการลบรายการ?')) {
			$('#vdomore1_' + id).remove();
			$('#address1' + id).val('del');
			$('#address2' + id).val('del');

		}
	}

	function del_row2(id) {
		if (confirm('คุณต้องการลบรายการ?')) {
			$('#tr2_' + id).remove();
			$('#vdo_youtube' + id).val('del');

		}
	}


	function fncaddRow() {
		var run = parseInt($('#temp_num').val()) + parseInt(1);
		var html = '';
		html += '<tr valign="top" bgcolor="#FFFFFF" id="tr_' + run + '" >';
		html += '<td width="100%" class="form-inline">';
		html += '<input name="filevdo[]"  id="filevdo' + run +
			'" type="file"  class="form-control" style="width:50%;"  />';
		html += '&nbsp;&nbsp;<span style="cursor:pointer" onclick="del_row(' + run + ')">';
		html += '<button type="button" class="btn btn-danger" >';
		html += '<span class="glyphicon glyphicon-remove-sign"></span>&nbsp;&nbsp;ลบ';
		html += '</button>';
		html += '</span>';
		html += '</td>';
		html += '</tr>';
		$("#vdo").append(html);
		$('#temp_num').val(run);

	}

	function fncaddRow2() {
		var run = parseInt($('#temp_num2').val()) + parseInt(1);
		var html = '';
		html += '<tr valign="top" bgcolor="#FFFFFF" id="tr2_' + run + '" >';
		html += '<td width="100%" class="form-inline">';
		html += '<input name="vdo_youtube[]" id="vdo_youtube' + run +
			'" type="text"  class="form-control" style="width:50%;" />';
		html += '&nbsp;&nbsp;<span style="cursor:pointer" onclick="del_row2(' + run + ')">';
		html += '<button type="button" class="btn btn-danger" >';
		html += '<span class="glyphicon glyphicon-remove-sign"></span>&nbsp;&nbsp;ลบ';
		html += '</button>';
		html += '</span>';
		html += '</td>';
		html += '</tr>';
		$("#vdo2").append(html);
		$('#temp_num2').val(run);

	}

	function fncaddRow3() {
		var run = parseInt($('#temp_num3').val()) + parseInt(1);
		var html = '';
		html += '<div class="form-group row" id="vdomore1_' + run + '" >';
		html += '<div class="col-md-6 col-sm-6 col-xs-12">';
		html += '<label for="address1">แหล่งที่มาไฟล์วิดีโอ  : </label>';
		html += '<input name="address1[]" id="address1' + run + '" type="text" value=""  class="form-control"  />';
		html += '</div>';
		html += '<div class="col-md-5 col-sm-5 col-xs-12">';
		html += '<label for="address2">Url : </label> ';
		html += '<input name="address2[]" id="address2' + run + '" type="text" value=""  class="form-control"  />';
		html += '</div>';
		html += '<div class="col-md-1 col-sm-1 col-xs-12">';
		html += '<label for=""></label>';
		html += '<a href="#experiences"  onclick="del_row3(' + run + ')"  >';
		html += '<button type="button" class="btn btn-danger" >';
		html += '<span class="glyphicon glyphicon-remove-sign"></span>&nbsp;&nbsp;ลบ';
		html += '</button>';
		html += '</a>	';
		html += '</div>';
		html += '</div>';
		$("#experiences").append(html);
		$("#experiences").focus;
		$('#temp_num3').val(run);

	}

	function chktime(c) {
		current_local_time = new Date();
		var nhours = current_local_time.getHours();
		var nmin = current_local_time.getMinutes();
		var nsec = current_local_time.getSeconds();
		if (nhours < 10) {
			nhours = "0" + nhours;
		}
		if (nmin < 10) {
			nmin = "0" + nmin;
		}
		if (nsec < 10) {
			nsec = "0" + nsec;
		}
		var ntime = nhours + ":" + nmin + ":" + nsec;
		if (c.checked == true) {
			document.form1.time_n.style.display = '';
			document.form1.time_n.value = ntime;
		} else {
			document.form1.time_n.style.display = 'none';
			document.form1.time_n.value = "";
		}
	}

	function chk() {
		if (document.form1.topic.value == "") {
			alert("Please insert topic!!");
			document.form1.topic.focus();
			return false;
		}
		if (document.form1.cid.value == "") {
			alert("Please choose group!");
			win2 = window.open('article_select.php?cid=<?php echo $_GET["cid"]; ?>', 'WebsiteLink',
				'top=100,left=100,width=800,height=600,resizable=1,status=0,scrollbars=1');
			win2.focus();
			return false;
		}
		if (document.form1.detail_use[0].checked == true) {
			if (document.form1.browsefile[0].checked == true) {
				if (document.form1.link.value == "") {
					alert("Please insert link!!");
					document.form1.link.focus();
					return false;
				}
			}
			if (document.form1.date_start.value != "" && document.form1.date_end.value == '') {
				alert("โปรดใส่วันที่สิ้นสุด!!");
				document.form1.date_end.focus();
				return false;
			}

			if (document.form1.date_start.value == "" && document.form1.date_end.value != '') {
				alert("โปรดใส่วันที่เริ่มต้น!!");
				document.form1.date_start.focus();
				return false;
			}
			if (document.form1.browsefile[1].checked == true) {
				if (document.form1.filebrowse.value == "") {
					alert("Please insert file!!");
					document.form1.filebrowse.focus();
					return false;
				}
			}
		}

		if (document.form1.detail_use[3].checked == true) {
			if (document.form1.filedl.value == "") {
				alert("Please insert file!!");
				document.form1.filedl.focus();
				return false;
			}
		}
		article_chkp.location.href = "article_check_p.php?cid=" + document.form1.cid.value;
		return false;
	}

	function findPosX(obj) {
		var curleft = 0;
		if (document.getElementById || document.all) {
			while (obj.offsetParent) {
				curleft += obj.offsetLeft
				obj = obj.offsetParent;
			}
		} else if (document.layers)
			curleft += obj.x;
		return curleft;
	}

	function findPosY(obj) {
		var curtop = 0;
		if (document.getElementById || document.all) {
			while (obj.offsetParent) {
				curtop += obj.offsetTop
				obj = obj.offsetParent;
			}
		} else if (document.layers)
			curtop += obj.y;
		return curtop;
	}

	function txt_data(w) {
		var mytop = findPosY(document.form1.source) + document.form1.source.offsetHeight;
		var myleft = findPosX(document.form1.source);
		var objDiv = document.getElementById("nav");
		objDiv.style.top = mytop;
		objDiv.style.left = myleft;
		objDiv.style.display = '';
		url = 'plan_list.php?d=' + w;
		AjaxRequest.get({
			'url': url,
			'onLoading': function() {},
			'onLoaded': function() {},
			'onInteractive': function() {},
			'onComplete': function() {},
			'onSuccess': function(req) {
				objDiv.innerHTML = req.responseText;
			}
		});

	}
</script>
<?php
$db->db_close();
?>
<script src="../js/bootstrap-tagsinput.js"></script>