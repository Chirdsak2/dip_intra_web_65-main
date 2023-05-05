<?php
include("../EWT_ADMIN/comtop.php");
include("../language/banner_language.php");
?>

<!-- START CONTAINER  -->
<div class="container-fluid">
	<?php
	include("menu-top.php");
	include("lang_config.php");

	function datetime($str)
	{
		$y = substr($str, 0, 4);
		if ($y) $y = ($y * 1) + 543;
		$m = substr($str, 4, 2);
		$d = substr($str, 6, 2);
		$h = substr($str, 8, 2);
		$i = substr($str, 10, 2);
		$s = substr($str, 12, 2);

		$str = "$d/$m/$y [$h:$i:$s]";
		if (trim($str) == "// [::]") {
			return '-';
		} else {
			return  $str;
		}
	}

	function CountAnswer($s_id, $type)
	{
		global $db;
		$query = $db->query("SELECT * FROM p_survey WHERE s_id = '$s_id' ");
		$res = $db->db_fetch_array($query);
		$table = $res[s_table];
		if ($type == 'Member') {
			$query = $db->query("SELECT count(survey_id) as ans FROM $table  WHERE person_answer > '0' ");
			$res = $db->db_fetch_array($query);
			$data = $res[ans];
		} else if ($type == 'User') {
			$query = $db->query("SELECT count(survey_id) as ans FROM $table  WHERE person_answer = '0' ");
			$res = $db->db_fetch_array($query);
			$data = $res[ans];
		} else {
			$query = $db->query("SELECT count(survey_id) as ans FROM $table");
			$res = $db->db_fetch_array($query);
			$data = $res[ans];
		}
		return $data;
	}

	$Yn = date("Y") + 543;
	$dn = date("m-d");
	$dn = $Yn . "-" . $dn;

	$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
	if ($page <= 0) $page = 1;

	$per_page = 10;

	$startpoint = ($page * $per_page) - $per_page;


	if ($_SESSION["EWT_SMTYPE"] == "Y") {

		$statement = "p_survey  WHERE s_pos <> '' ";
	} else {

		$statement = "p_survey WHERE s_uid = '{$_SESSION['EWT_SMID']}' ";
	}

	if ($do == "2") {
		$statement .= " AND s_approve = 'Y' AND ( '{$dn}' BETWEEN s_start AND s_end )";
	} elseif ($do == "3") {
		$statement .= " AND s_approve = 'Y' ";
	} elseif ($do == "4") {
		$statement .= " AND s_approve = 'N' ";
	}

	$statement .= "AND s_approve <>''  ORDER BY s_pos ASC";
	$s_survey = "SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}";
	$r_survey = $db->query($s_survey);
	?>

	<div class="row m-b-sm">
		<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">
			<!--start card -->
			<div class="card">
				<!--start card-header -->
				<div class="card-header">
					<div class="row">

						<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">
							<h4><?php echo $txt_form_menu_main; ?></h4>
							<p></p>
						</div>

						<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<ol class="breadcrumb">
									<li><a href="main_survey.php"><?php echo $txt_form_menu_main; ?></a></li>
									<li class=""></li>
								</ol>
							</div>

							<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs">
								<a href="add_survey1.php" target="_self">
									<button type="button" class="btn btn-info  btn-ml">
										<i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_form_add; ?>
									</button>
								</a>
							</div>

							<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs">
								<div class="btn-group ">
									<button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span></button>
									<ul class="dropdown-menu dropdown-menu-right">
										<li><a href="add_survey1.php" target="_self"><i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_ewt_back; ?></a></li>
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

							<div class="table-responsive">
								<form name="form1" method="post" action="add_function.php">
									<table width="100%" border="0" align="center" class="table table-bordered">
										<thead>
											<tr class="success">
												<th width="5%"> </th>
												<th width="20%" class="text-center"><?php echo $lang_add_subject; ?></th>
												<th width="5%" class="text-center"><?php echo $lang_survey_mystatus; ?></th>
												<th width="10%" class="text-center"><?php echo $lang_add_start2; ?></th>
												<th width="10%" class="text-center"><?php echo $lang_add_end2; ?></th>
												<th width="5%" class="text-center"><?php echo $text_genpoll_Vote_User; ?></th>
												<th width="10%" class="text-center"><?php echo $text_genpoll_Vote_Count; ?></th>
												<!--<th width="5%"  class="text-center" ><?//=$lang_survey_delete;?></th>-->
												<th width="15%"></th>
											</tr>
										</thead>

										<tbody>
											<?php
											$Path_true = "../ewt/" . $_SESSION["EWT_SUSER"] . "/file_attach";
											if ($a_rows = $db->db_num_rows($r_survey)) {
												$i = 1 + $startpoint;
												while ($a_survey = $db->db_fetch_array($r_survey)) {
													$topic = '';
													$fp1 = @fopen($Path_true . "/form_topic_" . $a_survey['s_id'] . ".html", "r");
													//if(!$fp1){ die("Cannot write form_topic_".$a_survey['s_id'].".html"); }
													while ($html1 = @fgets($fp1, 1024)) {
														$topic .= $html1;
													}
													@fclose($fp1); ?>

													<tr>
														<td class="text-center"><?php echo $i; ?></td>

														<td>
															<a onclick="boxPopup('<?php echo linkboxPopup(); ?>pop_survey.php?s_id=<?php echo $a_survey['s_id']; ?>');" data-toggle="tooltip" data-placement="right" title="ดูแบบสอบถาม"><?php echo strip_tags($a_survey['s_title']); ?></a>
														</td>

														<td class="text-center">
															<?php
															if ($a_survey['s_approve'] == "N") {
															?>
																<a href="#app" onClick="JQApprove_Survey('<?php echo $a_survey['s_id']; ?>');" data-toggle="tooltip" data-placement="right" title="<?php echo $lang_survey_approve2; ?>">
																	<h5><span class="label label-info"><i class="fa fa-cogs" aria-hidden="true"></i> <span><?php echo $lang_survey_approve2; ?></span></span></h5>
																</a>
															<?php
															} else {
															?>
																<h5><a data-toggle="tooltip" data-placement="right" title="<?php echo $lang_survey_approve1; ?>"> <span class="label label-success"><i class="fa fa-check-circle" aria-hidden="true"></i> <span><?php echo $lang_survey_approve1; ?></span></span></a></h5>
															<?php
															}
															?>
														</td>

														<td class="text-center">
															<h5 class="">
																<?php
																$st = explode("-", $a_survey['s_start']);
																echo $st[2] . "-" . $st[1] . "-" . $st[0]; ?>
															</h5>
														</td>

														<td class="text-center">
															<h5 class="">
																<?php
																$en = explode("-", $a_survey['s_end']);
																echo $en[2] . "-" . $en[1] . "-" . $en[0]; ?>
															</h5>
														</td>

														<td class="text-center">
															<h5 class="text-warning">
																<?php echo !empty($a_survey['s_creater']) ? $a_survey['s_creater'] : "admin"; ?></h5>
															<?php //echo $a_survey['s_id'];?>
														</td>

														<td class="text-center">
															<?php if ($a_survey['s_approve'] != "N") { ?>
																<a href="#view" _onClick="window.open('view_survey_stat.php?s_id=<?php echo $a_survey['s_id']; ?>&type=m','newwin','scrollbars=yes,resizable=yes,width=650,height=500');">
																	<span class="label label-primary"><?php echo CountAnswer($a_survey['s_id'], 'Member');  ?></span></a> /
																<a href="#view" _onClick="window.open('view_survey_stat.php?s_id=<?php echo  $a_survey['s_id']; ?>','newwin','scrollbars=yes,resizable=yes,width=650,height=500');">
																	<span class="label label-success"><?php echo CountAnswer($a_survey['s_id'], 'ALL');  ?></span> </a>
															<?php } ?>
														</td>
														<!--<td class="text-center">
														<?php
														/*$allow_del=''; 
														$db->query("USE ".$EWT_DB_NAME);

														$allow_del_sql = "SELECT * FROM block 
														inner join block_function on block.BID = block_function.BID 
														WHERE block_type ='survey' AND block_link = '{$a_survey[s_id]}'" ;
																		
															if($db->db_num_rows($db->query($allow_del_sql)) > 0){
																
																$allow_del='disabled title="แบบสอบถามนี้ถูกใช้อยู่ ไม่สามารถลบได้"';
																
															}	*/
															$s_alldel = "SELECT * FROM p_survey WHERE s_approve = 'Y' AND ( '{$dn}' BETWEEN s_start AND s_end ) AND s_id = '{$a_survey['s_id']}'";
															$q_alldel = $db->query($s_alldel);
															$a_rows = $db->db_num_rows($q_alldel);

														?>
														<input name="del<?php echo $i; ?>" type="checkbox" id="del<?php echo $i; ?>" value="<?php echo $a_survey['s_id']; ?>" <?php echo ($a_rows > 0) ? "disabled" : ""; ?> />
														<input name="dbn<?php echo $i; ?>" type="hidden" id="dbn<?php echo $i; ?>" value="<?php echo $a_survey['s_table']; ?>" />
														</td>-->

														<td class="text-left">
															<nobr>
																<a href="save_survey.php?s_id=<?php echo url_encode($a_survey['s_id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $lang_survey_app; ?>">
																	<button type="button" class="btn btn-info btn-circle  btn-xs ">
																		<i class="fas fa-clone" aria-hidden="true"></i>
																	</button>
																</a>

																<a href="edit_survey.php?s_id=<?php echo url_encode($a_survey['s_id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $lang_survey_edit; ?>">
																	<button type="button" class="btn btn-warning  btn-circle  btn-xs ">
																		<i class="fas fa-edit" aria-hidden="true"></i>
																	</button>
																</a>

																<?php if ($a_survey['s_approve'] == "Y") { ?>
																	<a onclick="boxPopup('<?php echo linkboxPopup(); ?>pop_view_survey.php?s_id=<?php echo $a_survey['s_id']; ?>');" _onClick="window.open('view_survey.php?s_id=<?php echo $a_survey['s_id']; ?>','newwin','scrollbars=yes,resizable=yes,width=650,height=500');" data-toggle="tooltip" data-placement="top" title="<?php echo $lang_survey_result1; ?>">
																		<button type="button" class="btn btn-success btn-circle  btn-xs ">
																			<i class="fas fa-search" aria-hidden="true"></i>
																		</button>

																	</a>
																<?php } ?>

																<?php if ($a_survey['s_approve'] == "N") { ?>
																	<a href="#app" onClick="JQApprove_Survey('<?php echo $a_survey['s_id']; ?>');" data-toggle="tooltip" data-placement="top" title="<?php echo $lang_survey_approve2; ?>">
																		<button type="button" class="btn btn-info btn-circle  btn-xs ">
																			<i class="fas fa-cogs" aria-hidden="true"></i>
																		</button>
																	</a>
																<?php } ?>

																<a href="#app" data-toggle="tooltip" data-placement="right" title="<?php echo $lang_survey_group; ?>" onClick="win3=window.open('site_s_member.php?ug=<?php echo $a_survey['s_id']; ?>','users','width=600,height=400,scrollbars=1,resizable=1');win3.focus();">
																	<button type="button" class="btn btn-default btn-circle btn-xs">
																		<i class="fa fa-user-cog" aria-hidden="true"></i>
																	</button>
																</a>

																<?php if ($a_survey['s_approve'] != "N") { ?>
																	<a href="survey_question.php?s_id=<?php echo $a_survey['s_id']; ?>&su_id=0" target="_blank" data-toggle="tooltip" data-placement="top" title="<?php echo "Export PDF"; ?>">
																		<button type="button" class="btn btn-danger btn-circle   btn-xs ">
																			<i class="fa fa-file-pdf fa-1x" aria-hidden="true"></i>
																		</button>
																	</a>
																<?php } ?>

																<a href="#delete" onClick="JQDelete_Survey('<?php echo $a_survey['s_id']; ?>');" data-toggle="tooltip" data-placement="right" title="<?php echo "ลบ"; ?>">
																	<button type="button" class="btn btn-danger btn-circle  btn-xs ">
																		<i class="fas fa-trash-alt fa-1x" aria-hidden="true"></i>
																	</button>
																</a>
															</nobr>
														</td>
													</tr>
												<?php
													$i++;
												}
												?>
												<!--<tr bgcolor="#FFFFFF"> 
												<td colspan="9">&nbsp;</td>
												<td>
												<input name="Flag" type="hidden" id="Flag2" value="DROP">
												<input name="all" type="hidden" id="all2" value="<?php echo $i; ?>">
												<a href="#app" onClick=" JQDelete_Survey('<?php echo $a_survey['s_id']; ?>');" data-toggle="tooltip" data-placement="right" title="<?php echo $lang_survey_approve2; ?>" >
												<button type="button" class="btn btn-danger  btn-ml " _onClick="if(confirm('Are you sure to delete selected form generator?')){ form1.submit(); }" >
												<i class="fa fa-trash-alt" aria-hidden="true"></i>&nbsp;<?php echo $lang_survey_delete; ?>
												</button> 
												</a>
												</td>
												</tr>-->
											<?php } else { ?>
												<tr bgcolor="#FFFFFF">
													<td colspan="11">
														<p class="text-center text-danger"><?php echo $lang_survey_nodata; ?></p>
													</td>
												</tr>
											<?php } ?>
										<tbody>
									</table>
								</form>
							</div>
						
							<?php echo pagination($statement, $per_page, $page, $url = '?'); ?>
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

<script>
	function JQDelete_Survey(id) {
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
							url: 'func_delete_survey.php',
							data: {
								'id': id,
								'proc': 'DelSurvey'
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

	function JQApprove_Survey(id) {
		$.confirm({
			title: 'อนุมัติแบบสอบถาม',
			content: 'คุณต้องการอนุมัติแบบสอบถามนี้หรือไม่ ',
			//content: 'url:form.html',
			boxWidth: '30%',
			icon: 'far fa-question-circle',
			theme: 'modern',
			buttons: {
				confirm: {
					text: 'ยืนยันการอนุมัติ',
					btnClass: 'btn-blue',
					action: function() {
						$.ajax({
							type: 'POST',
							url: 'func_approve_survey.php',
							data: {
								'id': id,
								'proc': 'ApproveSurvey'
							},
							success: function(data) {
								//alert(data);
								//exit;
								$.alert({
									title: '',
									content: 'url:text_approve.html',
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