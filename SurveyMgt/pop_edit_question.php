<?php
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");
include("../language.php");
include("../language/language_TH.php");
include("../lib/config_path.php");
include("lang_config.php");

$qid = $_GET['qid'];
$post = $_GET['post'];

$s_pcate = $db->query("SELECT * FROM p_question WHERE q_id = '{$qid}' ");
$PR = $db->db_fetch_array($s_pcate);
?>
<div class="dContainer">
	<div class="modal-dialog modal-lg">

		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" onclick="$('#box_popup').fadeOut();"><i class="far fa-times-circle fa-1x"></i></button>
				<h4 class="modal-title"><?= $lang_add3_howmanyitems1; ?> <?= $post; ?></h4>
			</div>

			<form name="form1" method="post">
				<div class="modal-body">
					<div class="scrollbar scrollbar-near-moon thin">

						<div class="form-group row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<label><?= $lang_add3_howmanyitems1; ?> <?= $post; ?></label>
							</div>
						</div>

						<div class="form-group row">
							<div class="col-md-2 col-sm-2 col-xs-12">
								<label for="des"><?= $lang_add_question_questionnumber; ?><span class="text-danger">*</span> : </label>
								<input class="form-control numberint" name="ch" type="text" id="ch" value="<?= $PR['q_name']; ?>" size="5">
							</div>
						</div>

						<div class="form-group row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<label for="name"><?= $lang_add_question_question; ?><span class="text-danger">*</span> : </label>
								<textarea class="form-control" name="name" id="name" cols="40" rows="5"><?= $PR['q_des']; ?></textarea>
							</div>
						</div>

						<div class="form-group row">
							<div class="col-md-2 col-sm-2 col-xs-12">
								<label for="name"><?= $lang_add_question_rank; ?><span class="text-danger">*</span> : </label>
								<input class="form-control numberint" name="pos" type="text" id="pos" value="<?= $PR['q_pos']; ?>" size="5">
							</div>
						</div>
						<?php
						$just = explode('#zz#', $PR['q_req']);
						?>
						<div class="form-group row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<label for="just"><?= $lang_add_question_require; ?> : </label>
								<input name="just" type="checkbox" id="just" value="Y" <?php if ($just[0] == "Y" || $just[0] == "E") {
																							echo "checked";
																						} ?>>
							</div>
						</div>

						<div class="form-group row" id="email_tr" <?php if ($PR['q_anstype'] != "D") {
																		echo "style=display:none";
																	} ?>>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<label for="email_data"><?= "รูปแบบข้อมูล"; ?> : </label>
								<input name="email_data" type="radio" id="email_data1" value="" <?php if ($just[1] == "" or $just[1] == "E") {
																									echo "checked";
																								} ?>> ข้อมูลตัวอักษรทั่วไป
								<input name="email_data" type="radio" id="email_data2" value="Y" <?php if ($just[1] == "Y") {
																										echo "checked";
																									} ?>> ข้อมูลรูปแบบ email
								<input name="email_data" type="radio" id="email_data3" value="N" <?php if ($just[1] == "N") {
																										echo "checked";
																									} ?>> ข้อมูลรูปแบบตัวเลข

							</div>
						</div>

						<div class="form-group row" id="email_tr1" <?php if ($PR['q_anstype'] != "D") {
																		echo "style=display:none";
																	} ?>>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<label for="no_replate"><?= 'ไม่ต้องการให้ข้อมูลซ้ำ'; ?> : </label>
								<input type="checkbox" name="no_replate" id="no_replate" value="QNR" <?php if ($just[2] == "QNR") {
																											echo "checked";
																										} ?>>
							</div>
						</div>

						<input name="proc" type="hidden" id="proc" value="Q">
						<input name="qid" type="hidden" id="qid" value="<?= $qid; ?>">

					</div>
				</div>
			</form>

			<div class="modal-footer">
				<div class="form-group row">
					<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center">
						<button onclick="JQEdit_Question();" class="btn btn-success btn-lm" data-toggle="tooltip" data-placement="top" title="<?= $lang_survey_save; ?>">
							<span class="glyphicon glyphicon-floppy-saved"></span>&nbsp;<?= $lang_survey_save; ?>
						</button>
						<!--<input type="submit" name="Submit" value="บันทึก" class="btn btn-success btn-ml">
						<input name="reset" type="reset" value="ยกเลิก" class="btn btn-warning"  onClick="$('#box_popup').fadeOut();">
						<button class="btn btn-warning btn-lm" onClick="$('#box_popup').fadeOut();" data-toggle="tooltip" data-placement="top" title="<?= $lang_survey_update; ?>" >
						<span class="glyphicon glyphicon-remove"></span>&nbsp;<?= "ยกเลิก"; ?>-->
						</button>
					</div>
				</div>
			</div>


		</div>
	</div>
</div>
<script>
	$(document).ready(function() {

		$('.numberint').keypress(function(event) {
			return isNumberInt(event, this)
		});

	});

	function JQEdit_Question() {

		var qid = $("#qid").val();
		var pos = $("#pos").val();
		var name = $("#name").val();
		var proc = $("#proc").val();
		var ch = $("#ch").val();
		var no_replate = $("input:checkbox[name=no_replate]:checked").val();
		var just = $("input:checkbox[name=just]:checked").val();
		var email_data = $("input:radio[name=email_data]:checked").val();
		//var email_data = $("#email_data").val();

		$.confirm({
			title: '<?= $lang_survey_edit_question; ?>' + ' ' + pos,
			content: 'คุณต้องการบันทึกการแก้ไขนี้หรือไม่',
			//content: 'url:form.html',
			boxWidth: '30%',
			icon: '	glyphicon glyphicon-question-sign',
			theme: 'modern',
			buttons: {
				confirm: {
					text: 'ยืนยันการแก้ไข',
					btnClass: 'btn-blue',
					action: function() {
						$.ajax({
							type: 'POST',
							url: 'func_edit_question.php',
							data: {
								'qid': qid,
								'pos': pos,
								'name': name,
								'ch': ch,
								'just': just,
								'no_replate': no_replate,
								'email_data': email_data,
								'proc': proc
							},
							success: function(data) {
								$('#box_popup').fadeOut();
								location.reload(location.href + "#frm_edit_s");
								//location.reload();	
								//$("#frm_edit_s").load();
								//$("#frm_edit_s").load(location.href + " #frm_edit_s");
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