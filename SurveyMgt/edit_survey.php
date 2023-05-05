<?php
include("../EWT_ADMIN/comtop.php");
?>

<!-- START CONTAINER  -->
<div class="container-fluid">
	<?php
	include("menu-top.php");
	include("lang_config.php");

	$s_id = get('s_id', 0);
	$create = get('create', 0);

	$s_psurvey = $db->query("SELECT * FROM p_survey WHERE s_id = '{$s_id}'");
	$PR = $db->db_fetch_array($s_psurvey);

	$Path_true = "../ewt/" . $_SESSION["EWT_SUSER"] . "/file_attach";
	$fp1 = @fopen($Path_true . "/form_topic_" . $s_id . ".html", "r");
	//if(!$fp1){ die("Cannot write form_topic_".$s_id.".html"); }
	while ($html1 = @fgets($fp1, 1024)) {
		$topic .= $html1;
	}
	@fclose($fp1);

	if ($PR['s_approve'] == "Y") {
	?>
		<script>
			//alert("แบบสอบถามนี้ทำการ Approve แล้ว ไม่สามารถแก้ไขได้");
			window.location.href = "edit_asurvey.php?s_id=<?php echo url_encode($s_id); ?>";
		</script>
	<?php
	}

	$SQL2 = $db->query("SELECT * FROM p_cate WHERE s_id = '{$s_id}' ORDER BY c_d");

	?>
	<div class="row m-b-sm">
		<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">
			<!--start card -->
			<div class="card">
				<!--start card-header -->
				<div class="card-header">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">
							<h4><?php echo $txt_form_edit; ?></h4>
							<p></p>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<ol class="breadcrumb">
									<li><a href="main_survey.php"><?php echo $txt_form_menu_main; ?></a></li>
									<li class=""><?php echo $txt_form_edit; ?></li>
								</ol>
							</div>

							<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs">
								<a href="main_survey.php" target="_self">
									<button type="button" class="btn btn-info  btn-sm ">
										<i class="fas fa-undo-alt" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo $txt_ewt_back; ?>
									</button>
								</a>
							</div>

							<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs">
								<div class="btn-group ">
									<button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span></button>
									<ul class="dropdown-menu dropdown-menu-right">
										<li><a href="main_survey.php" target="_self"><i class="fas fa-undo-alt"></i>&nbsp;<?php echo $txt_ewt_back; ?></a></li>
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
							<form name="form1" method="post" action="edit_function.php" onSubmit="return checkvalid(this);">
								<input name="Flag" type="hidden" id="Flag" value="3">
								<div id="frm_edit_s">
									<div class="panel panel-default">
										<div class="panel-heading form-inline">
											<div class="row">
												<div class="col-md-8 col-sm-8 col-xs-12 text-left">
													<h4><?php echo $topic; ?></h4>
												</div>
												<div class="col-md-4 col-sm-4 col-xs-12 text-right">

													<!---//edit_s.php แก้ไขหัวข้อ // -->
													<button type="button" class="btn btn-warning btn-sm pointer" onclick="boxPopup('<?php echo linkboxPopup(); ?>pop_edit_s.php?s_id=<?php echo $s_id; ?>');">
														<i class="far fa-edit"></i> <?php echo $lang_survey_edit_topic; ?>
													</button>

												</div>
											</div>
										</div>

										<div class="panel-body">
											<div class="row m-b-sm">
												<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm text-left">
													<!---//add.php เพิ่มส่วน// -->
													<a onclick="boxPopup('<?php echo linkboxPopup(); ?>pop_add.php?s_id=<?php echo $s_id; ?>');">
														<button type="button" class="btn btn-info btn-sm">
															<i class="fas fa-plus-circle"></i> <?php echo $lang_survey_add_topic2; ?>
														</button>
													</a>
												</div>
											</div>

											<ul id="sortableLv" class="sortableLv1 " style="width: 100%;">
												<?php
												$s_cate = $db->query("SELECT * FROM p_cate WHERE s_id = '{$s_id}' ORDER BY c_d");
												$i = 0;
												while ($_cate = $db->db_fetch_array($s_cate)) {
													$s_question = $db->query("SELECT * FROM p_question WHERE c_id = '{$_cate['c_id']}' ORDER BY q_pos ASC");
													$row  = $db->db_num_rows($s_question);
												?>
													<li class="productCategoryLevel1 bg-primary " id="<?php echo $_cate['c_d']; ?>_<?php echo $_cate['c_id']; ?>" style="padding-bottom:25px;">
														&nbsp;
														<input type="hidden" name="hiddencategory_id[]" id="hiddencategory_id<?php echo $_cate['c_d']; ?>" value="<?php echo $_cate['c_d']; ?>">

														<span style="top:10px;" class="text-white">
															<i class="fas fa-folder text-medium text-white"></i>
															<b style="word-break: break-all;" class="text-white"><?php echo $lang_add3_part; ?> <?php echo $_cate['c_d']; ?> : <?php echo $_cate['c_name']; ?></b>
														</span>
														<span class="iconAction ">
															<!--//add_question.php เพิ่มคำถาม  //-->
															<!-- <a onclick="boxPopup('<?php echo linkboxPopup(); ?>pop_add_question.php?post=<?php echo $_cate['c_d']; ?>&path=<?php echo $_cate['c_id']; ?>&type=<?php echo $_cate['c_gp']; ?>&pos=<?php echo $row + 1; ?>');">
																<button type="button" class="btn btn-success btn-circle  btn-sm" data-toggle="tooltip" data-placement="top" title="<?php echo $lang_add3_additem; ?>">
																	<i class="fas fa-plus-circle" aria-hidden="true"></i>
																</button>
															</a> -->

															<a onClick="window.open('add_question.php?post=<?php echo $_cate[c_d]; ?>&path=<?php echo $_cate[c_id]; ?>&type=<?php echo $_cate[c_gp]; ?>&pos=<?php echo $row + 1; ?>','question','width=750,height=650,resizable=1,status=0,scrollbars=1,location=0,top=20,left=200');">
																<button type="button" class="btn btn-success  btn-circle  btn-sm" data-toggle="tooltip" data-placement="top" title="<?php echo $lang_add3_additem; ?>">
																	<i class="fas fa-plus-square" aria-hidden="true"></i>
																</button>
															</a>
															<?php
															if (($_cate[c_gp] == "Y") and ($row > 0)) {
															?>
																<!--//แก้ไขคำตอบ.php  //-->
																<a onClick="window.open('edit_ans1.php?post=<?php echo $_cate[c_d]; ?>&path=<?php echo $_cate[c_id]; ?>&type=<?php echo $_cate[c_gp]; ?>','ans1','width=750,height=650,resizable=1,status=0,scrollbars=1,location=0,top=20,left=200');">
																	<button type="button" class="btn btn-info btn-circle btn-sm " data-toggle="tooltip" data-placement="top" title="แก้ไขคำตอบ&nbsp;<?php echo $_cate['c_d']; ?>">
																		<i class="fas fa-edit" aria-hidden="true"></i>
																	</button>
																</a>
															<?php } else {
																echo "";
															} ?>
															<!--<input name="Cutt<?php echo $i; ?>" type="button" value="<?php echo $lang_add3_edititemquestion; ?>" class="txt9" onClick="window.open('edit_ans1.php?post=<?php echo $R[c_d]; ?>&path=<?php echo $R[c_id]; ?>&type=<?php echo $R[c_gp]; ?>','ans1','width=750,height=650,resizable=1,status=0,scrollbars=1,location=0,top=20,left=200');">-->
															<!--//edit.php ปุ่มแก้ไขส่วนที่  //-->
															<a onclick="boxPopup('<?php echo linkboxPopup(); ?>pop_edit.php?post=<?php echo $_cate['c_d']; ?>&path=<?php echo $_cate['c_id']; ?>');">
																<button type="button" class="btn btn-warning btn-circle  btn-sm " data-toggle="tooltip" data-placement="top" title="<?php echo $lang_add3_edititem; ?>&nbsp;<?php echo $_cate['c_d']; ?>">
																	<i class="fas fa-edit" aria-hidden="true"></i>
																</button>
															</a>
															<!--// ปุ่มลบส่วน //-->
															<a onClick="JQDel_Cate('<?php echo $_cate['c_id']; ?>');">
																<button type="button" class="btn btn-danger btn-circle  btn-sm" data-toggle="tooltip" data-placement="top" title="<?php echo "ลบส่วนที่"; ?> <?php echo $_cate['c_d']; ?>">
																	<i class="fas fa-trash-alt" aria-hidden="true"></i>
																</button>
															</a>
														</span>
													</li>

													<?php
													if ($row > 0) {
														$t = 0;
													?>
														<ul id="sortableLv<?php echo $i; ?>" class="sortableLv1 " style="width: 100%;">
															<?php
															while ($a_question = $db->db_fetch_array($s_question)) {
															?>
																<li class="productCategoryLevel1 move" id="<?php echo $a_question['q_id']; ?>">
																	&nbsp;
																	<span class="">
																		<!--<i class="fa fa-ellipsis-v text-medium text-dark"></i>
																		<i class="far fa-question-circle text-medium text-dark"></i>-->
																	</span>

																	<input class="input-inline-sm text-center" name="category_order[]" id="category_order<?php echo $a_question['q_pos']; ?>" type="text" value="<?php echo $a_question['q_pos']; ?>" readonly />
																	<input type="hidden" name="hiddencategory_id[]" id="hiddencategory_id<?php echo $a_question['q_id']; ?>" value="<?php echo $a_question['q_id']; ?>">
																	<i class="far fa-question-circle text-medium text-dark"></i>
																	<b style="word-break: break-all;"><?php echo $a_question['q_name']; ?>&nbsp;<?php echo $a_question['q_des']; ?>
																	</b>
																	<!--//edit_ans.php ปุ่มแก้ไขคำถาม //-->
																	<a onclick="boxPopup('<?php echo linkboxPopup(); ?>pop_edit_question.php?post=<?php echo $_cate['c_d']; ?>&path=<?php echo $_cate['c_id']; ?>&type=<?php echo $_cate['c_gp']; ?>&qid=<?php echo $a_question['q_id']; ?>');">
																		<button type="button" class="btn btn-warning btn-circle  btn-sm" data-toggle="tooltip" data-placement="top" title="<?php echo $lang_survey_edit_question; ?>&nbsp;<?php echo $a_question['q_name']; ?>">
																			<i class="far fa-edit" aria-hidden="true"></i></button>
																	</a>
																	<!--//edit_ans.php ปุ่มแก้ไขคำตอบ //-->
																	<?php if ($_cate['c_gp'] == "N") { ?>
																		<!--<input name="Cut<?php echo $i; ?>" type="button" value="<?php echo $lang_survey_edit_answer; ?> <?php echo $RR['q_name']; ?>" class="btn btn-warning  btn-sm" onClick="window.open('edit_ans.php?qname=<?php echo $RR['q_name']; ?>&qid=<?php echo $RR['q_id']; ?>','ans','width=750,height=650,resizable=1,status=0,scrollbars=1,location=0,top=20,left=200');">-->
																		<button type="button" class="btn btn-default btn-circle  btn-sm" data-toggle="tooltip" data-placement="top" title="<?php echo $lang_survey_edit_answer; ?> <?php echo $a_question['q_name']; ?>" onClick="window.open('edit_ans.php?qname=<?php echo $a_question['q_name']; ?>&qid=<?php echo $a_question['q_id']; ?>','ans','width=750,height=650,resizable=1,status=0,scrollbars=1,location=0,top=20,left=200');">
																			<i class="fas fa-comment-dots" aria-hidden="true"></i>
																		</button>
																	<?php } else {
																		echo "";
																	}
																	?>
																	<!--ปุ่มลบคำถาม  //-->
																	<a onClick="JQDel_Question('<?php echo $a_question['q_id']; ?>');">
																		<button type="button" class="btn btn-danger btn-circle  btn-sm" data-toggle="tooltip" data-placement="top" title="<?php echo "ลบคำถาม"; ?> <?php echo $a_question['q_pos']; ?>"><i class="fas fa-trash-alt"></i></button>
																	</a>
																</li>
															<?php } ?>
														</ul>
													<?php } else { ?>
														<ul>
															<li class="productCategoryLevel1 no-drop" disabled style="">
																<p class="text-danger text-center">
																	<b>
																		<?php echo $txt_ewt_data_not_found; ?>
																	</b>
																</p>
															</li>
														</ul>
													<?php } ?>
													<ul>
														<li class="productCategoryLevel1 no-drop text-right" disabled style="">
															<p class="badge  text-right text-white">
																<?php echo $lang_add3_howmanyitems1; ?><?php echo $txt_ewt_space; ?><?php echo $i + 1; ?><?php echo $txt_ewt_space; ?><?php echo $lang_add3_howmanyitems2; ?><?php echo $txt_ewt_space; ?><?php echo $row; ?><?php echo $txt_ewt_space; ?><?php echo $lang_add3_howmanyitems3; ?>
																<input name="ppp<?php echo $i; ?>" type="hidden" id="ppp<?php echo $i; ?>" value="<?php echo $row; ?>">
															</p>
														</li>
													</ul>
												<?php
													$i++;
												}
												?>
											</ul>

										</div>
										<div class="panel-footer text-center">

											<!--<input name="SubmitT" type="button" class="btn btn-info  btn-lm" id="SubmitT" value="<?php //echo $lang_survey_previewpage; 
																																		?>" onClick="window.open('survey_p.php?s_id=<?php //echo $s_id; 
																																													?>','preview','width=500,height=500,resizable=1,status=0,scrollbars=1,location=0,top=40,left=200');">-->
											<a onclick="boxPopup('<?php echo linkboxPopup(); ?>pop_survey.php?s_id=<?php echo $s_id; ?>');">
												<button type="button" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="<?php echo $txt_form_preview; ?>">
													<span class="glyphicon glyphicon-search"></span> <?php echo $txt_form_preview; ?>
												</button>
											</a>

											<input name="s_id" type="hidden" id="s_id" value="<?php echo $s_id; ?>">

											<!--<input name="SubmitX" type="submit" class="btn btn-warning  btn-lm" id="Submit1" value="<?php //echo $lang_survey_update; 
																																		?>">
											<button type="submit" class="btn btn-warning btn-lm" data-toggle="tooltip" data-placement="top" title="<?php echo $lang_survey_update; ?>"  >
											<span class="glyphicon glyphicon-pencil"></span>&nbsp;<?php echo $lang_survey_update; ?>
											</button>-->

											<input name="aal" type="hidden" id="aal2" value="<?php echo $i; ?>">

											<!--<input type="submit" name="SubmitY" value="<?php //echo $lang_survey_save; 
																							?>" class="btn btn-success  btn-lm" >-->
											<button type="submit" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="<?php echo $lang_survey_save; ?>">
												<span class="glyphicon glyphicon-floppy-saved"></span>&nbsp;<?php echo $lang_survey_save; ?>
											</button>

										</div>
									</div>
								</div>
							</form>
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
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui-touch-punch.min.js"></script>

<!-- <style>
	.drop-placeholder {
		background-color: rgba(240, 243, 244, 1.0);
		height: 4.0em;
		border: 4px dotted #cccccc !important;
		border-radius: 3px;
		margin-top: 5px !important;
		box-shadow: 0px 4px 30px rgba(22, 33, 74, 0.07);
		-webkit-box-shadow: 0px 4px 30px rgba(22, 33, 74, 0.07);
		-moz-box-shadow: 0px 4px 30px rgba(22, 33, 74, 0.07);
	}
</style> -->

<script>
	$(function() {
		var m;
		var num = <?php echo $i; ?>;
		for (m = 0; m < num; m++) {

			var name = "sortableLv" + m;
			//console.log(name);	
			$("#sortableLv" + m).sortable({
				placeholder: 'drop-placeholder',
				update: function(event, ui) {
					//var page_id_array = new Array();
					//$("#"+name+" li").each(function(){
					//page_id_array.push($(this).attr("id"));
					//});		
					//console.log(page_id_array);	
					//var changedList = this.id;

					var page_id_array = $(this).sortable('toArray');
					var positions = page_id_array.join(',');
					//console.log(page_id_array);	

					//console.log(changedList);	

					//if(changedList == name){

					/*console.log({
					  id: changedList,
					  positions: positions
					});*/
					$.ajax({
						type: 'POST',
						url: 'func_sortable_question.php',
						data: {
							proc: 'Sortable_Edit',
							page_id_array: page_id_array
						},
						success: function(data) {
							console.log(data);
							location.reload(location.href + "#" + name);
							//alert(location.href + "#"+name);												
							//$("#frm_edit_s").load(location.href + " #frm_edit_s");												
							//alert("Data Save: " + data);												
							//self.location.href="article_list.php?cid="+data;											
							//$('#box_popup').fadeOut();
							//document.location.reload();
						}
					});

					//}	
				}
			});
		}

	});

	function JQDel_Cate(id) {

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
							type: 'GET',
							url: 'func_Del_Cate.php',
							data: {
								'id': id,
								'proc': 'Del_Cate'
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

	function JQDel_Question(id) {

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
							type: 'GET',
							url: 'func_Del_Question.php',
							data: {
								'id': id,
								'proc': 'Del_Question'
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


	$(document).ready(function() {
		var today = new Date();
		$('.datepicker')
			.datepicker({
				format: 'dd/mm/yyyy',
				language: 'th-th',
				thaiyear: true,
				changeYear: true,
			})
			.datepicker("setDate", new Date(today.getFullYear(), today.getMonth(), today.getDate()));

		$('.numberint').keypress(function(event) {
			return isNumberInt(event, this)
		});

	});
</script>

<script>
	function data(c) {
		if (document.form1.elements["s_id" + c].value == "xxx") {
			document.form1.elements["sel" + c].disabled = true;
			document.form1.elements["num" + c].disabled = true;
		}
		<?php
		$query1 = $db->query("SELECT * FROM p_cate WHERE s_id = '{$s_id}' AND  c_gp = 'Y' ");
		while ($W = $db->db_fetch_array($query1)) {
		?>
			else if (document.form1.elements["s_id" + c].value == "<?php echo $W[c_id]; ?>") {
				document.form1.elements["sel" + c].disabled = true;
				document.form1.elements["num" + c].disabled = true;
			} else {
				document.form1.elements["sel" + c].disabled = false;
				document.form1.elements["num" + c].disabled = false;
			}
		<?php
		}
		?>

	}
</script>

<script>
	function checkvalid(t) {
		if (form1.mail_data.value != '' && !validEMail(form1.mail_data.value.toLowerCase())) {
			alert('กรุณาระบุ e-mail ให้ถูกต้อง!');
			return false;
		}

		return true;
	}

	function validLength(item, min, max) {
		return (item.length >= min) && (item.length <= max)
	}

	function validEMail(mo) {
		if (validLength(mo, 1, 50)) {
			if (mo.search("^.+@.+\(\.com)|(\.net)|(\.edu)|(\.mil)|(\.gov)|(\.org)|(\.co.th)|(\.go.th)|(\.localnet)$") != -1)
				return true;
			else return false;
		}
		return true;
	}
</script>

<script>
	/*function GoNext(){
for(c=1;c<document.form1.allT.value;c++){
if(document.form1.elements["name"+c].value ==""){
alert("<?php echo $lang_add3_pleasequestion; ?>");
document.form1.elements["name"+c].focus();
return false;
}
if(document.form1.elements["s_id"+c].value ==""){
alert("<?php echo $lang_add3_pleasepart; ?>");
document.form1.elements["s_id"+c].focus();
return false;
}
}
}

function ChangeBox(c){
if(document.form1.elements["sel"+c].value =="D"){
document.form1.elements["num"+c].disabled = true;
document.form1.elements["just"+c].disabled = false;
}else if(document.form1.elements["sel"+c].value =="B"){
document.form1.elements["just"+c].disabled = true;
document.form1.elements["num"+c].disabled = false;
}else{
document.form1.elements["just"+c].disabled = false;
document.form1.elements["num"+c].disabled = false;
}
}*/
</script>