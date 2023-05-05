<?php
include("../EWT_ADMIN/comtop_pop.php");


$id = (int)(!isset($_GET['s_id']) ? 0 : $_GET['s_id']);

$s_survey = $db->query("SELECT * FROM p_survey WHERE s_id = '{$id}'");
$a_row = $db->db_num_rows($s_survey);
$PR = $db->db_fetch_array($s_survey);

$Path_true = "../ewt/" . $_SESSION["EWT_SUSER"] . "/file_attach";
$fp1 = @fopen($Path_true . "/form_topic_" . $s_id . ".html", "r");
//if(!$fp1){ die("Cannot write form_topic_".$s_id.".html"); }
while ($html1 = @fgets($fp1, 1024)) {
	$topic .= $html1;
}
@fclose($fp1);

if ($a_row) {
	$s_cate = $db->query("SELECT 
				  DISTINCT(p_cate.c_id),
				  p_cate.c_d,
				  p_cate.c_name,
				  p_cate.c_title,
				  p_cate.c_gp,
				  p_cate.option1,
				  p_cate.option2 
				  FROM p_cate,p_question 
				  WHERE p_cate.s_id = '{$id}' AND p_cate.c_id = p_question.c_id
				  ORDER BY p_cate.c_d ASC");
?>

	<div class="container">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">

				<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6">
					<button type="button" class="close" onclick="$('#box_popup').fadeOut();"><i class="far fa-times-circle fa-1x  color-white"></i></button>
					<h4 class="modal-title color-white"> <i class="fas fa-search"></i> <?php echo 'แบบสอบถาม'; ?></h4>
				</div>

				<div class="modal-body">
					<div class="scrollbar_view scrollbar-near-moon thin">
						<div class="panel panel-default">
							<div class="panel-heading form-inline">
								<div class="row">
									<div class="col-md-12 col-sm-12 col-xs-12 text-left">
										<h4><?php echo $PR['s_title']; ?></h4>
									</div>
								</div>
							</div>

							<div class="panel-body">
								<div class="row">
									<input type="hidden" id="hit" />
									<input type="hidden" id="req" />
									<input type="hidden" id="reqfig" />
									<input type="hidden" id="reqname" />
									<input type="hidden" name="sid" value="<?php echo $id ?>" />

									<?php
									$k = 1;
									while ($R = $db->db_fetch_array($s_cate)) {
									?>
										<div class="col-md-12 col-sm-12 col-xs-12 text-left">
											<h4>ส่วนที่ <?php echo $PartName1 . $R['c_d'] . " : "; ?>
												<?php if ($R['c_name'] != "") {
													echo  strip_tags($R['c_name']);
												}  ?>
											</h4>

											<?php
											if ($R['c_title'] != "") {
												echo " <h5>รายละเอียด : " . strip_tags($R[c_title]) . "</h5>";
											}
											echo '</div><hr><div class="clearfix">&nbsp;</div>';

											$SSS = $db->query("SELECT * FROM p_question WHERE c_id = '{$R['c_id']}' ORDER BY q_pos ASC");
											if ($R['c_gp'] == "Y") {
											?>
												<div class="col-md-12 col-sm-12 col-xs-12 ">
													<div class="table-responsive">
														<table class="table table-bordered">
															<thead>
																<tr class="info">
																	<th rowspan="2" class="text-center">ลำดับ</th>
																	<th rowspan="2" class="text-center">คำถาม</th>
																	<th colspan="5" class="text-center">คำตอบ</th>
																</tr>

																<tr class="info">
																	<?php
																	$SQL2 = $db->query("SELECT DISTINCT(p_ans.a_name) FROM p_ans,p_question 
																	WHERE p_question.c_id = '{$R['c_id']}' AND p_question.q_id = p_ans.q_id 
																	ORDER BY p_ans.option3");

																	while ($Q = $db->db_fetch_array($SQL2)) {
																	?>
																		<th class="text-center">
																			<?php echo $Q['a_name']; ?>
																		</th>
																	<?php } ?>
																</tr>
															</thead>

															<?php
															while ($X = $db->db_fetch_array($SSS)) {

																$just = explode('#zz#', $X['q_req']);
																$req = "";

																echo '<tr>';
																echo '<td class="center" style="vertical-align:top;text-align:center;">' . strip_tags($X['q_name']) . '</td>';
																echo '<td>' . strip_tags($X['q_des']);

																if ($just[0] == "Y") {
																	echo ' <span class="text-danger">*</span>';
																	//$req = $R[c_d].'.'.$X[q_name];
																	$req = $X['q_name'] . ".";
																}
																echo '</td>';

																//echo '<input type="hidden" id="hit" value="'.$k.' '.strip_tags($X[q_des]).'">';

																echo '<input type="hidden" id="req" value="' . $req . '">';
																echo '<input type="hidden" id="reqname" value="' . strip_tags($X['q_des']) . '">';
																echo '<input type="hidden" id="reqfig" value="' . $just[1] . '">';
																echo '<input type="hidden" id="hit" value="' . $R['c_d'] . '.' . $X['q_name'] . ') ' . ' ' . strip_tags($X['q_des']) . $required . '">';

																$SQL2 = $db->query("SELECT DISTINCT(p_ans.a_name) FROM p_ans,p_question WHERE p_question.c_id = '{$R['c_id']}' AND p_question.q_id = p_ans.q_id ORDER BY p_ans.option3");

																$a = 0;
																while ($Q = $db->db_fetch_array($SQL2)) {
																	if ($R['option1'] == "A") {
																		echo '<td class="" style="text-align:center;" >';
																		echo '<input id="ck' . $k . '" name="ans' . $X['q_id'] . '" value="' . $a . '##' . $Q['a_name'] . '" type="radio">';
																		//echo '<span class="custom-control-indicator"></span><span class="custom-control-description">'.$Q[a_name].'</span>';
																		echo '<input type="hidden" id="ckc' . $k . '" value="">';
																		echo '</td>';
																	} else {
																		echo '<td class="" style="text-align:center;">';
																		echo '<input id="ck' . $k . '" name="ans' . $X['q_id'] . '_' . $a . '" value="' . $a . '##' . $Q['a_name'] . '" type="checkbox">';
																		//echo '<span class="custom-control-indicator"></span><span class="custom-control-description">'.$Q[a_name].'</span>';
																		echo '<input type="hidden" id="ckk' . $k . '" value="">';
																		echo '</td>';
																	}
																	$a++;
																}
																echo '</tr>';
																$k++;
															}
															echo '</table></div></div>';
														} else {
															echo '<div class="col-md-12 col-sm-12 col-xs-12" > ';
															while ($X = $db->db_fetch_array($SSS)) {
																$just = explode('#zz#', $X['q_req']);
																$req = "";
																$txt = "";
																echo ' <div class="headq">' . strip_tags($X['q_name']) . '. ';
																if ($just[0] == "Y") {
																	//$required= "#zz#";
																	echo '<span class="text-danger">*</span> ';
																	//$req = $R[c_d].'.'.$X[q_name];
																	$req = $X['q_name'] . ".";
																}
																echo strip_tags($X['q_des'], '<br>') . '</div>';
																echo '<input type="hidden" id="req" value="' . $req . '">';
																echo '<input type="hidden" id="reqname" value="' . strip_tags($X['q_des']) . '">';
																echo '<input type="hidden" id="reqfig" value="' . $just[1] . '">';
																echo '<input type="hidden" id="hit" value="' . $R['c_d'] . '.' . $X['q_name'] . ' ' . ' ' . strip_tags($X['q_des']) . '">';

																echo '<div class=" marginbottom15">';
																$SSS1 = $db->query("SELECT * FROM p_ans WHERE q_id = '{$X['q_id']}' ORDER BY option3 ASC");

																if ($X['q_anstype'] == "D") {
																	if ($RrRows = $db->db_num_rows($SSS1)) {
																		$Z = $db->db_fetch_array($SSS1);
																		if ($just[1] == "N") {
																			$txt = "ข้อมูลรูปแบบตัวเลข";
																		} elseif ($just[1] == "Y" || $just[1] == "E") {
																			$txt = "ข้อมูลรูปแบบอีเมล์";
																		}
																		if ($Z['a_other'] == "S") {
																			echo '<input type="hidden" value="" id="ck' . $k . '" />';
																			echo '<input type="text" name="ans' . $X['q_id'] . '" value="" id="ck' . $k . '" placeholder="' . $txt . '" class="form-control margintop10"/>';
																		} else {

																			echo '<input type="hidden" value="" id="ck' . $k . '"/>';
																			echo '<input type="hidden" value="" name="aaa" id="ck' . $k . '" value="area"/>';
																			echo '<textarea name="ans' . $X['q_id'] . '" id="ck' . $k . '" class="form-control margintop10" placeholder="' . $txt . '" ';
																			if ($Z['option4'] != "") {
																				echo " cols=\"$Z[option4]\" ";
																			} else {
																				echo " cols=\"6\" ";
																			}
																			if ($Z['option3'] != "") {
																				echo " rows=\"$Z[option3]\" ";
																			} else {
																				echo " rows=\"6\" ";
																			}
																			echo 'wrap="VIRTUAL" ></textarea>';
																		}
																	}
																} else if ($X['q_anstype'] == "E") {
																	if ($RrRows = $db->db_num_rows($SSS1)) {
																		$Z = $db->db_fetch_array($SSS1);
																		echo '<div class=" txtq margintop10">ไฟล์แนบ ' . $Z['a_name'] . '</div>';
																		echo '<input type="hidden" value="" id="ck' . $k . '"/>';
																		echo '<input type="hidden" value="' . $Z['a_name'] . '" id="tfile"/>';
																		echo '<input type="hidden" value="' . $Z['a_other'] . '" id="sfile"/>';
																		echo '<input type="file" name="file1"  class="margintop10 form-control" id="ck' . $k . '">';
																		echo '<div class=" txtq marginbottom15 margintop10"> ท่านสามารถใส่ไฟล์แนบได้ไม่เกิน <strong>' . number_format($Z['a_other'], 0) . ' KB. </div>';
																	}
																} else if ($X['q_anstype'] == "F") {
																	echo '<input type="hidden" value="" id="ck' . $k . '"/>';
																	echo '<input id="ck' . $k . '" name="start_date" type="date" class="margintop10 form-control" style="width:200px;" value="">';
																} else if ($X['q_anstype'] == "G") {
																	echo '<input type="hidden" value="" id="ck' . $k . '" value="1"/>';
																	echo '<input type="hidden" id="ck' . $k . '" value="select">'; ?>

																	<div class=" marginbottom15">
																		<input type="text" name="addr_no" id="addr_no" placeholder="ที่อยู่" class="form-control">
																	</div>

																	<div class=" marginbottom15">
																		<select name="addr_prov<?php echo $X[q_id]; ?>" id="addr_prov<?php echo $X[q_id]; ?>" class="margintop10 form-control s1<?php echo $k ?>" onchange="getAmp(this,'<?php echo $X[q_id]; ?>')">
																			<!--onChange="selectChange(this, document.getElementById('addr_amp<?php echo $X[q_id]; ?>'),arrItemsTxt1,arrItemsValue1,arrItemsGrp1,'');">-->
																			<option value="" selected>- เลือกจังหวัด - </option>
																			<?php
																			$db->query("USE " . $EWT_DB_USER);
																			$sql_province = "select * from province ORDER BY p_name ASC";
																			$query_province = $db->query($sql_province);
																			while ($rec_province = $db->db_fetch_array($query_province)) {
																			?>
																				<option value="<?php echo $rec_province[p_code]; ?>"><?php echo $rec_province[p_name]; ?></option>
																			<?php
																			}
																			$db->query("USE " . $EWT_DB_NAME);
																			?>
																		</select>
																	</div>

																	<div class=" marginbottom15">
																		<select name="addr_amp<?php echo $X[q_id]; ?>" id="addr_amp<?php echo $X[q_id]; ?>" class="margintop10 form-control s2<?php echo $k ?>" onClick="getAmp_null('<?php echo $X[q_id]; ?>');" onchange="getTam(this,'<?php echo $X[q_id]; ?>')">
																			<option value="">- เลือกอำเภอ -</option>
																		</select>
																	</div>

																	<div class=" marginbottom15">
																		<select name="addr_tamb<?php echo $X[q_id]; ?>" id="addr_tamb<?php echo $X[q_id]; ?>" class="margintop10 form-control s3<?php echo $k ?>" onClick="getTam_null('<?php echo $X[q_id]; ?>');">
																			<option value="">- เลือกตำบล - </option>
																		</select>
																		<!--script src="../js/jquery.min.js"></script-->
																	</div>

																	<div class=" marginbottom15">
																		<input type="text" name="addr_postcode" id="addr_postcode" maxlength="5" placeholder="รหัสไปรษณีย์" class="form-control numberint" style="width:150px;">
																	</div>

																<?php } else if ($X[q_anstype] == "A") {
																	$p = 0;
																	while ($Z = $db->db_fetch_array($SSS1)) {
																		$answer_ex = explode("#@form#img@#", $Z['a_name']);
																		echo '<input id="ck' . $k . '" name="ans' . $X['q_id'] . '" class="custom-control-input" type="radio" value="' . $p . "##" . $answer_ex[0] . '"';
																		if ($Z['option4'] == "Y") {
																			echo "checked";
																		}
																		echo '> ' . $answer_ex[0];
																		if ($Z['a_other'] == "Y") {
																			echo ' <input name="oth' . $X['q_id'] . '_' . $p . '" type="text" id="ckc' . $k . '"> ';
																		} else {
																			echo ' <input type="hidden" id="ckc' . $k . '" name="oth' . $X['q_id'] . '_' . $p . '">';
																		}
																		echo '<br>';
																		$p++;
																	}
																} else if ($X[q_anstype] == "B") {
																	$p = 0;
																	while ($Z = $db->db_fetch_array($SSS1)) {
																		$answer_ex = explode("#@form#img@#", $Z['a_name']);
																		echo '<div class="checkbox">
																		<label>
																		<input type="checkbox"  name="ans' . $X['q_id'] . '_' . $p . '"  id="ck' . $k . '"  value="' . $p . '##' . $answer_ex[0] . '" ';

																		if ($Z['option4'] == "Y") {
																			echo "checked";
																		}
																		echo '/>
																		<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>' . $answer_ex[0] . '
																		</label>
																		</div>';

																		if ($Z[a_other] == "Y") {
																			echo ' <input name="oth' . $X['q_id'] . '_' . $p . '" type="text" id="ckk' . $k . '"> ';
																		} else {
																			echo ' <input type="hidden" id="ckk' . $k . '" name="oth' . $X['q_id'] . '_' . $p . '">';
																		}
																		//echo '</label></div>';

																		$p++;
																	}
																} else if ($X['q_anstype'] == "C") {
																	echo '<input type="hidden" id="ck' . $k . '" value="select">';
																	echo '<select name="ans' . $X['q_id'] . '" class="margintop10 form-control" id="ck' . $k . '">';
																	while ($Z = $db->db_fetch_array($SSS1)) {
																		$answer_ex = explode("#@form#img@#", $Z['a_name']);
																		echo '<option value="' . $answer_ex[0] . '"';
																		if ($Z['option4'] == "Y") {
																			echo "selected";
																		}
																		echo '>' . $answer_ex[0] . '</option>';
																	}
																	echo '</select>';
																}
																echo '</div>';

																$k++;
															}
															echo '</div>';
														}

														echo '<div class="clearfix">&nbsp;</div>';
													}
													?>

													</div>
												</div>

												<div class="panel-footer text-center">
												</div>
										</div>
								</div>
							</div>

						</div>
					</div>
				</div>

				<script>
					$('.numberint').keypress(function(event) {
						return isNumberInt(event, this)
					});
				</script>
			</div>
		</div>
	</div>
<?php } ?>