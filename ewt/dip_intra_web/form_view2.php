<?php include('comtop.php'); ?>
<?php include('header.php'); ?>
<style>
	.layer-modal {
		z-index: 1000;
		display: none;
		padding-top: 10px;
		position: fixed;
		left: 0;
		right: 0;
		top: 0;
		width: 100%;
		height: 100vh;
		overflow: auto;
		background-color: rgb(0, 0, 0);
		background-color: rgba(255, 255, 255, 0.9);
	}

	.layer-modal::-webkit-scrollbar {
		width: 2px;
		height: 2px;
		background-color: #F5F5F5;
	}

	.layer-modal::-webkit-scrollbar-thumb {
		width: 2px;
		border-radius: 1px;
		-webkit-box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.1);
		background-image: -webkit-gradient(linear, left bottom, left top, from(#FFC153), to(#FFC153));
		background-image: -webkit-linear-gradient(bottom, #FFC153 0%, #FFC153 100%);
		background-image: linear-gradient(to top, #FFC153 0%, #FFC153 100%);
	}

	.panel {
		margin-bottom: 0px;
		background-color: #fff;
		border: 1px solid transparent;
		border-radius: 4px;
		-webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
		box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
	}

	.panel-body {
		padding: 10px;
	}

	.loader {
		display: none;
		position: fixed;
		top: 0px;
		left: 0px;
		background: #ccc;
		width: 100%;
		height: 100vh;
		opacity: .85;
		filter: alpha(opacity=85);
		-moz-opacity: .85;
		z-index: 9999;
		background: #fff url(assets/img/preview.gif
) 50% 50% no-repeat;
	}

	.modal-content {
		background-color: #fff;
		background-clip: padding-box;
		border: 1px solid rgba(255, 255, 255, 0.1);
		border-radius: 0.6rem;
		outline: 0;
		box-shadow: 0 12px 28px 0 rgb(0 0 0 / 25%), 0 2px 4px 0 rgb(0 0 0 / 15%), inset 0 0 0 1px rgb(0 0 0 / 15%);
	}

	.icon-post {
		display: block;
		background-color: #FFFFFF;
		background-repeat: no-repeat;
		background-size: 18px 18px;
		background-position: center;
		height: 4.5rem;
		width: 4.5rem;
		line-height: 6rem;
		border-radius: 50%;
	}

	.icon-post:hover {
		display: block;
		background-color: #F5F5F5;
		background-repeat: no-repeat;
		background-size: 18px 18px;
		background-position: center;
		height: 4.5rem;
		width: 4.5rem;
		line-height: 6rem;
		padding: 0;
		margin: 0;
		border-radius: 50%;
		box-shadow: 0 2px 3px rgb(0 0 0 / 35%);
	}

	textarea.comment-ff {
		min-height: 10rem;
	}

	span.elipsis {
		display: none;
	}
</style>
<?php

$id = $_GET['sid'];

// $current_date_TH = date("Y-m-d");
// $current_date_TH = explode("-", $current_date_TH);
// $current_date_TH = $current_date_TH[0] . "-" . $current_date_TH[1] . "-" . $current_date_TH[2];

$surv = survey::getSurvey($id);

// $form_start = explode("-", $surv["s_start"]);
// $form_start = ($form_start[0] + 543) . "-" . $form_start[1] . "-" . $form_start[2];
// $form_end   = explode("-", $surv["s_end"]);
// $form_end   = ($form_end[0] + 543) . "-" . $form_end[1] . "-" . $form_end[2];
// if (strtotime($current_date_TH) < strtotime($form_start)) {
//   // echo "<script>alert('ขอบคุณสำหรับการตอบแบบฟอร์มค่ะ')</script>";
// } else if (strtotime($current_date_TH) > strtotime($form_end)) {
//   echo "<script>alert('หมดเวลาทำแบบทดสอบ')</script>";
//   echo "<script>";
//   echo "window.location='more_form.php'";
//   echo "</script>";
// }
$k = 0;


$SQL1 = "SELECT * FROM " . E_DB_NAME . ".p_survey WHERE s_id = '{$id}'";
$a_row	= db::getRowCount($SQL1);
$PR = db::getFetch($SQL1, PDO::FETCH_ASSOC);

$SQL = "SELECT DISTINCT(p_cate.c_id),p_cate.c_d,p_cate.c_name,p_cate.c_title,p_cate.c_gp,p_cate.option1
,p_cate.option2 
FROM " . E_DB_NAME . ".p_cate," . E_DB_NAME . ".p_question 
WHERE p_cate.s_id = '{$id}' AND p_cate.c_id = p_question.c_id
ORDER BY p_cate.c_d ASC";

$s_title = strip_tags($PR['s_title']);
$file_page  = "form_view.php?sid=" . $id;
$page_title = $s_title;
?>


<style>
	* {
		font-family: 'prompt-Reg';

	}

	ul#sub_menu li {
		display: inline;
		color: #82288C;
		font-weight: bold;
	}

	/*navbar-toggle x icon end....*/
	.icons-section i {
		color: #2571b3;
	}


	hr.style-eight {
		width: 250px;
		border: 0;
		height: 2px;
		position: relative;
		background: -moz-linear-gradient(left, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0) 10%, rgb(37, 113, 179) 50%, rgba(0, 0, 0, 0) 90%, rgba(0, 0, 0, 0) 100%);
		/* FF3.6+ */
		background: -webkit-linear-gradient(left, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0) 10%, rgb(37, 113, 179) 50%, rgba(0, 0, 0, 0) 90%, rgba(0, 0, 0, 0) 100%);
		/* Chrome10+,Safari5.1+ */
		background: -o-linear-gradient(left, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0) 10%, rgb(37, 113, 179) 50%, rgba(0, 0, 0, 0) 90%, rgba(0, 0, 0, 0) 100%);
		/* Opera 11.10+ */
		background: -ms-linear-gradient(left, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0) 10%, rgb(37, 113, 179) 50%, rgba(0, 0, 0, 0) 90%, rgba(0, 0, 0, 0) 100%);
		/* IE10+ */
		background: linear-gradient(left, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0) 10%, rgb(37, 113, 179) 50%, rgba(0, 0, 0, 0) 90%, rgba(0, 0, 0, 0) 100%);
		/* W3C */

	}

	hr.style-eight:before {
		content: "";
		display: block;
		border-top: solid 1px #f9f9f9;
		width: 100%;
		height: 1px;
		position: absolute;
		top: 50%;
		z-index: 1;
	}

	.welcome-section h5 {
		color: #2571b3;
	}

	.footer-section {
		background: #2571b3;
		color: #FFF;
	}

	.stepwizard-step p {
		margin-top: 35px;
		padding-left: 15px;
	}

	.stepwizard-row {
		display: table-row;
	}

	.stepwizard {
		display: table;
		width: 100%;
		position: relative;
	}

	.stepwizard-step button[disabled] {
		opacity: 1 !important;
		filter: alpha(opacity=100) !important;
	}

	.stepwizard-row:before {
		top: -86px;
		bottom: 0;
		position: absolute;
		content: " ";
		width: 79%;
		left: 0px;
		right: -40px;
		margin: auto;
		height: 4px;
		background-color: #82288C;
	}

	.stepwizard-step {
		display: table-cell;
		text-align: center;
		position: relative;
	}

	.btn-circle {
		width: 30px;
		height: 30px;
		text-align: center;
		padding: 6px 0;
		font-size: 12px;
		line-height: 1.428571429;
		border-radius: 15px;
	}

	.stepwizard-step a {
		background: #82288C;
		color: #fff;
		position: absolute;
		top: 0;
		margin-left: -10px;
	}

	.stepwizard-step a.btn-primary {
		background: #82288C;
		border-color: #82288C;
		color: #FFF;
		box-shadow: 0 0 0px 5px #82288C;
	}

	.studentform-section span {
		color: red;
	}

	.studentform-section ul.list-unstyled b {
		color: #2571b3;
	}

	#step-3 {
		overflow-x: hidden;
	}

	.has-error input {
		border: 1px solid red;
	}

	.studentform-section input:focus {
		box-shadow: none;
	}

	.stepwizard-row .btn-default[disabled] {
		background-color: #E978F5;
		border-color: #ccc;
	}

	.stepwizard-row .btn[disabled] {
		pointer-events: none;
		cursor: not-allowed;
		filter: alpha(opacity=65);
		-webkit-box-shadow: none;
		box-shadow: none;
		opacity: 1;
	}

	.custom-checkbox .custom-control-input:checked~.custom-control-label::before {
		background-color: #2571b3;
	}

	.studentform-section .btn-primary {
		background: #2571b3;
		border-color: #2571b3;
	}

	.ui-state-highlight,
	.ui-widget-content .ui-state-highlight,
	.ui-widget-header .ui-state-highlight {
		border: 1px solid #2571b3 !important;
		background: #2571b3 !important;
		color: #FFF !important;
	}

	/* @media(max-width:504px){
    .stepwizard-step p {
    margin-top:35px;
    padding-left: 15px;
font-size: 12px;
} 
  .stepwizard-row::before {
    top: -50px;
    }
    
} */

	@media (min-width: 576px) {
		.stepwizard-step p {
			margin-top: 40px;
			padding-left: 15px;
			font-size: 12px;
		}
	}

	@media (min-width: 768px) {
		.dropdown:hover>.dropdown-menu {
			display: block;
		}

		.stepwizard-step p {
			margin-top: 35px;
			padding-left: 15px;
			font-size: 1rem;
		}
	}

	@media (min-width: 992px) {}

	@media (min-width: 1200px) {}

	.box {
		width: 100%;
		height: 130px;
		background-color: #82288C;
	}

	@media (min-width: 992px) and (max-width: 1199.98px) {
		.stepwizard-row:before {
			top: -107px;
			bottom: 0;
			position: absolute;
			content: " ";
			width: 79%;
			left: 0px;
			right: -27px;
			margin: auto;
			height: 4px;
			background-color: #82288C;
		}
	}

	@media (min-width: 768px) and (max-width: 991.98px) {
		.stepwizard-row:before {
			top: -152px;
			bottom: 0;
			position: absolute;
			content: " ";
			width: 79%;
			left: 0px;
			right: -27px;
			margin: auto;
			height: 4px;
			background-color: #82288C;
		}
	}

	@media (max-width: 575.98px) {
		.stepwizard-row:before {
			top: -152px;
			bottom: 0;
			position: absolute;
			content: " ";
			width: 79%;
			left: 0px;
			right: -27px;
			margin: auto;
			height: 4px;
			background-color: #82288C;
		}

		.stepwizard-step p {
			/* margin-top: 35px; */
			/* padding-left: 15px; */
			font-size: 12px;
		}

		.stepwizard-step p {
			margin-top: 35px;
			padding-left: 0px;
		}
	}
</style>

<div class="container-fluid mar-spacehead" style="background-color: #82288c">
	<div class="container ">
		<form id="contact-form" action="#" method="post" role="form" novalidate="novalidate">
			<div class="error-container"></div>
			<div class="row">
				<h1 class="col-12 text-center text-white font-h-search  pt-4 pb-4">
					แบบสอบถาม
				</h1>
			</div>
		</form>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-xl-12">
			<h1 class="h2-color pt-4"><?php echo $surv["s_title"]; ?></h1>
		</div>
	</div>
	<div class="row">
		<div class="col-xl-12">
			<ul id="sub_menu">
				<li>
					<a href="index.php">หน้าแรก</a>
				</li>
				<li>
					&gt;
				</li>
				<li>
					<a href="#"> แบบสอบถาม</a>
				</li>
			</ul>
		</div>
		<hr class="hr_news mt-3">
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<h3 hidden>head</h3>
			<form name="frmMain" id="frmMain" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="sid" value="<?php echo "$id";?>">
				<fieldset>
					<!--div><h4 class="disbox-floatleft">แบบฟอร์มที่ 1</h4></div-->
					<?php
					$k = 0;
					$a_row		= 	db::getRowCount($SQL);
					$a_pCate 	= 	db::getFetchAll($SQL, PDO::FETCH_ASSOC);
					$a_countItem = count($a_pCate);
					if ($a_pCate) {
						foreach ((array)$a_pCate as $R) {

					?>
							<div class="form--topic">ส่วนที่ <?php echo $PartName1 . $R['c_d'] . " : "; ?><?php if ($R['c_name'] != "") {
																												echo  strip_tags($R['c_name']);
																											}  ?></div>
							<?php
							if ($R['c_title'] != "") {
								echo ' <div class="form--description-text">รายละเอียด : ' . strip_tags($R['c_title']) . '</div>' . PHP_EOL;
							}

							$SSS = "SELECT * FROM " . E_DB_NAME . ".p_question WHERE c_id = '{$R['c_id']}' ORDER BY q_pos ASC";
							if ($R['c_gp'] == "Y") {
							?>
								<table class="table table-bordered" style="border-color:#B5B5B5;">
									<tr class="info center">
										<td rowspan="2" style="padding-top:25px;text-align:center;">
											ลำดับ
										</td>
										<td rowspan="2" style="padding-top:25px;text-align:center;">
											คำถาม
										</td>
										<td colspan="5" style="padding-top:25px;text-align:center;">
											คำตอบ
										</td>
									</tr>

									<?php
									echo '<tr class="info center">';

									$SQL2 = "SELECT DISTINCT(p_ans.a_name) FROM " . E_DB_NAME . ".p_ans," . E_DB_NAME . ".p_question WHERE p_question.c_id = '{$R['c_id']}' AND p_question.q_id = p_ans.q_id ORDER BY p_ans.option3";
									$a_pAns = db::getFetchAll($SQL2, PDO::FETCH_ASSOC);
									if ($a_pAns) {
										foreach ((array)$a_pAns as $Q) {
											echo '<td align="center">' . $Q['a_name'] . '</td>';
										}
									}
									echo '</tr>';

									$a_pQuestion = db::getFetchAll($SSS, PDO::FETCH_ASSOC);
									if ($a_pQuestion) {
										foreach ((array)$a_pQuestion as $X) {
											$just = explode('#zz#', $X['q_req']);
											$req = "";

											echo '<tr>';
											echo '<td class="center" style="vertical-align:top;text-align:center;">' . strip_tags($X['q_name']) . '</td>' . PHP_EOL;
											echo '<td class="text-left">' . strip_tags($X['q_des']);

											if ($just[0] == "Y") {
												echo ' <span class="text-danger">*</span>' . PHP_EOL;
												//$req = $R[c_d].'.'.$X[q_name];
												$req = $X['q_name'] . ".";
											}
											echo '</td>' . PHP_EOL;

											//echo '<input type="hidden" id="hit" value="'.$k.' '.strip_tags($X[q_des]).'">';

											echo '<input type="hidden" id="req" value="' . $req . '">' . PHP_EOL;
											echo '<input type="hidden" id="reqname" value="' . strip_tags($X['q_des']) . '">' . PHP_EOL;
											echo '<input type="hidden" id="reqfig" value="' . $just[1] . '">' . PHP_EOL;
											echo '<input type="hidden" id="hit" value="' . $R['c_d'] . '.' . $X['q_name'] . ') ' . ' ' . strip_tags($X['q_des']) . $required . '">' . PHP_EOL;

											$SQL2 = "SELECT DISTINCT(p_ans.a_name) 
														FROM " . E_DB_NAME . ".p_ans," . E_DB_NAME . ".p_question 
														WHERE p_question.c_id = '{$R['c_id']}' 
														AND p_question.q_id = p_ans.q_id 
														ORDER BY p_ans.option3";
											$a = 0;
											$a_pAns = db::getFetchAll($SQL2, PDO::FETCH_ASSOC);
											if ($a_pAns) {
												foreach ((array)$a_pAns as $Q) {
													if ($R['option1'] == "A") {
														echo '<td class="" style="text-align:center;" >' . PHP_EOL;
														echo '<input id="ck' . $k . '" name="ans' . $X['q_id'] . '" value="' . $a . '##' . $Q['a_name'] . '" type="radio">' . PHP_EOL;
														//echo '<span class="custom-control-indicator"></span><span class="custom-control-description">'.$Q[a_name].'</span>';
														echo '<input type="hidden" id="ckc' . $k . '" value="">' . PHP_EOL;
														echo '</td>' . PHP_EOL;
													} else {
														echo '<td class="" style="text-align:center;">' . PHP_EOL;
														echo '<input id="ck' . $k . '" name="ans' . $X['q_id'] . '_' . $a . '" value="' . $a . '##' . $Q['a_name'] . '" type="checkbox">' . PHP_EOL;
														//echo '<span class="custom-control-indicator"></span><span class="custom-control-description">'.$Q[a_name].'</span>';
														echo '<input type="hidden" id="ckk' . $k . '" value="">' . PHP_EOL;
														echo '</td>' . PHP_EOL;
													}
													$a++;
												}
											}
											echo '</tr>' . PHP_EOL;
											$k++;
										}
									}
									echo '</table>' . PHP_EOL;
								} else {
									$a_pQuestion = db::getFetchAll($SSS, PDO::FETCH_ASSOC);
									if ($a_pQuestion) {
										foreach ((array)$a_pQuestion as $X) {

											$just = explode('#zz#', $X['q_req']);
											$req = "";
											echo '<div class="headq mt-3">' . strip_tags($X['q_name']) . '. ';
											if ($just[0] == "Y") {
												//$required= "#zz#";
												echo '<span class="text-danger">*</span> ' . PHP_EOL;
												//$req = $R[c_d].'.'.$X[q_name];
												$req = $X['q_name'] . ".";
											}
											echo strip_tags($X['q_des']), '<br>' . '</div>' . PHP_EOL;
											echo '<input type="hidden" id="req" value="' . $req . '">' . PHP_EOL;
											echo '<input type="hidden" id="reqname" value="' . strip_tags($X['q_des']) . '">' . PHP_EOL;
											echo '<input type="hidden" id="reqfig" value="' . $just[1] . '">' . PHP_EOL;
											echo '<input type="hidden" id="hit" value="' . $R['c_d'] . '.' . $X['q_name'] . ') ' . ' ' . strip_tags($X['q_des']) . '">' . PHP_EOL;
											echo '<div class="marginbottom15">' . PHP_EOL;

											$SSS1 = "SELECT * FROM " . E_DB_NAME . ".p_ans WHERE q_id = '{$X['q_id']}' ORDER BY option3 ASC";

											////////////////Start Q->D////////////////////
											if ($X['q_anstype'] == "D") {
												$Z = db::getFetch($SSS1, PDO::FETCH_ASSOC);
												if ($Z) {
													if ($just[1] == "N") {
														$txt = "ข้อมูลรูปแบบตัวเลข";
													} elseif ($just[1] == "Y" || $just[1] == "E") {
														$txt = "ข้อมูลรูปแบบอีเมล์";
													} else {
														$txt = strip_tags($X['q_des']);
													}

													if ($Z['a_other'] == "S") {
														echo '<input type="hidden" value="" id="ck' . $k . '" >' . PHP_EOL;
														echo '<input type="text" name="ans' . $X['q_id'] . '" value="" id="ck' . $k . '" placeholder="' . $txt . '" class="_6lux margintop10">' . PHP_EOL;
													} else {

														echo '<input type="hidden" value="" id="ck' . $k . '" >' . PHP_EOL;
														//echo '<input type="hidden" value="" name="aaa" id="ck'.$k.'" value="area"/>';
														echo '<textarea name="ans' . $X['q_id'] . '" id="ck' . $k . '" class="_6lux margintop10" placeholder="' . $txt . '" type="area"';
														if ($Z['option4'] != "") {
															echo 'cols="' . $Z['option4'] . '"';
														} else {
															echo 'cols="6"';
														}
														if ($Z['option3'] != "") {
															echo 'rows="' . $Z['option3'] . '"';
														} else {
															echo 'rows="6"';
														}
														echo 'wrap="VIRTUAL" ></textarea>' . PHP_EOL;
													}
												}
												echo '<div class="clearfix">&nbsp;</div>' . PHP_EOL;
												////////////////End Q->D////////////////////		
											} else if ($X['q_anstype'] == "E") ////////////////Start Q->E////////////////////
											{
												$Z = db::getFetch($SSS1, PDO::FETCH_ASSOC);
												if ($Z) {
													echo '<div class=" txtq margintop10">ไฟล์แนบ ' . $Z['a_name'] . '</div>' . PHP_EOL;
													echo '<input type="hidden" value="" id="ck' . $k . '"/>' . PHP_EOL;
													echo '<input type="hidden" value="' . $Z['a_name'] . '" id="tfile"/>' . PHP_EOL;
													echo '<input type="hidden" value="' . $Z['a_other'] . '" id="sfile"/>' . PHP_EOL;
													echo '<input type="file" name="file1"  class="margintop10 _6lux" id="ck' . $k . '">' . PHP_EOL;
													echo '<div class="txtq marginbottom15 margintop10"> ท่านสามารถใส่ไฟล์แนบได้ไม่เกิน <strong>' . number_format($Z['a_other'], 0) . ' KB. </div>' . PHP_EOL;
													echo '<small id="fileHelp2" class="form-text ml-3 mb-2 text-danger mb-2">' . PHP_EOL;
													echo 'Attached file not match: doc,docx,xls,xlsx,jpg,png,pdf | Attachments more than ' . number_format($Z['a_other'], 0) . ' KB.';
													echo '</small>' . PHP_EOL;
												}
												echo '<div class="clearfix">&nbsp;</div>' . PHP_EOL;
												////////////////End Q->D////////////////////		
											} else if ($X['q_anstype'] == "F") ////////////////Start Q->F////////////////////
											{
												echo '<div class="container mb-2">' . PHP_EOL;
												echo '<input type="hidden" value="" id="ck' . $k . '" >' . PHP_EOL;
												echo '<input id="ck' . $k . '" name="date' . $X['q_id'] . '"  type="date" class="margintop10 _6lux" _style="width:200px;" value="">' . PHP_EOL;
												echo '</div>' . PHP_EOL;
												echo '<div class="clearfix">&nbsp;</div>' . PHP_EOL;
											} ////////////////End Q->F////////////////////	
											else if ($X['q_anstype'] == "G") ////////////////Start Q->G////////////////////
											{
												echo '<input type="hidden" value="" id="ck' . $k . '"  >';
												echo '<input type="hidden" id="ck' . $k . '" value="select">' . PHP_EOL;
									?>
												<div class=" marginbottom15">
													<input type="text" name="addr_no<?php echo $X['q_id']; ?>" id="addr_no<?php echo $X['q_id']; ?>" placeholder="ที่อยู่" class="_6lux s4<?php echo $k ?>">
												</div>
												<div class="clearfix">&nbsp;</div>
												<div class=" marginbottom15">
													<select name="addr_prov<?php echo $X['q_id']; ?>" id="addr_prov<?php echo $X['q_id']; ?>" class="_6lux s1<?php echo $k ?>" onchange="getAmp(this,'<?php echo $X['q_id']; ?>')">
														<!--onChange="selectChange(this, document.getElementById('addr_amp<?php echo $X['q_id']; ?>'),arrItemsTxt1,arrItemsValue1,arrItemsGrp1,'');">-->
														<option value="" selected>- เลือกจังหวัด - </option>
														<?php
														//$db->query("USE ".$EWT_DB_USER); 
														$s_province = "select * from " . E_DB_USER . ".province ORDER BY p_name ASC";
														$a_Zdata = db::getFetchAll($s_province, PDO::FETCH_ASSOC);
														if ($a_Zdata) {
															foreach ((array)$a_Zdata as $rec_province) {
																//$query_province = $db->query($sql_province);
																//while($rec_province = $db->db_fetch_array($query_province)){
														?>
																<option value="<?php echo $rec_province['p_code']; ?>"><?php echo $rec_province['p_name']; ?></option>
														<?php
															}
														}

														?>
													</select>
												</div>

												<div class="clearfix">&nbsp;</div>
												<div class=" marginbottom15">
													<select name="addr_amp<?php echo $X['q_id']; ?>" id="addr_amp<?php echo $X['q_id']; ?>" class="margintop10 _6lux s2<?php echo $k ?>" onClick="getAmp_null('<?php echo $X['q_id']; ?>');" onchange="getTam(this,'<?php echo $X['q_id']; ?>')">
														<option value="">- เลือกอำเภอ -</option>
													</select>
												</div>

												<div class="clearfix">&nbsp;</div>
												<div class="marginbottom15">
													<select name="addr_tamb<?php echo $X['q_id']; ?>" id="addr_tamb<?php echo $X['q_id']; ?>" class="margintop10 _6lux s3<?php echo $k ?>" onClick="getTam_null('<?php echo $X['q_id']; ?>');">
														<option value="">- เลือกตำบล - </option>
													</select>
												</div>

												<div class="clearfix">&nbsp;</div>
												<div class=" marginbottom15">
													<input type="text" name="addr_postcode<?php echo $X['q_id']; ?>" id="addr_postcode<?php echo $X['q_id']; ?>" maxlength="5" placeholder="รหัสไปรษณีย์" class="_6lux numberint s5<?php echo $k ?>" style="width:150px;">
												</div>
												<div class="clearfix">&nbsp;</div>

						<?php
											} ////////////////End Q->G////////////////////	
											else if ($X['q_anstype'] == "A") ////////////////Start Q->A////////////////////
											{
												$p = 0;
												$a_Zdata = db::getFetchAll($SSS1, PDO::FETCH_ASSOC);
												if ($a_Zdata) {
													echo '<div class="containe4r mb-2">' . PHP_EOL;
													foreach ((array)$a_Zdata as $Z) {
														$answer_ex = explode("#@form#img@#", $Z['a_name']);
														echo '<div class="radio pb-1" style="text-align:left;"><label hidden></label>' . PHP_EOL;
														echo '<input id="ck' . $k . '" name="ans' . $X['q_id'] . '" class="" type="radio" value="' . $p . "##" . $answer_ex[0] . '"';
														if ($Z['option4'] == "Y") {
															echo "checked";
														}
														echo '>&nbsp;' . $answer_ex[0];
														if($answer_ex[1]){
															if(file_exists($answer_ex[1])){
																echo '<img src='. $answer_ex[1].'>';
															}
														}

														if ($Z['a_other'] == "Y") {
															echo ' <input name="oth' . $X['q_id'] . '_' . $p . '" class="_6lux" type="text" id="ckc' . $k . '"> ' . PHP_EOL;
														} else {
															echo ' <input type="hidden" id="ckc' . $k . '" name="oth' . $X['q_id'] . '_' . $p . '">' . PHP_EOL;
														}
														echo '</div>' . PHP_EOL;
														$p++;
													}
													echo '</div>' . PHP_EOL;
												}
												echo '<div class="clearfix">&nbsp;</div>' . PHP_EOL;
											} ////////////////End Q->A////////////////////
											else if ($X['q_anstype'] == "B") ////////////////Start Q->B////////////////////
											{
												$p = 0;
												$a_Zdata = db::getFetchAll($SSS1, PDO::FETCH_ASSOC);
												if ($a_Zdata) {
													echo '<div class="container mb-2">' . PHP_EOL;
													foreach ((array)$a_Zdata as $Z) {
														$answer_ex = explode("#@form#img@#", $Z['a_name']);
														echo '<div class="checkbox"><label hidden></label>' . PHP_EOL;
															echo '<input id="ck' . $k . '" name="ans' . $X['q_id'] . '_' . $p . '" type="checkbox" value="' . $p . "##" . $answer_ex[0] . '"';
															if ($Z['option4'] == "Y") {
																echo "checked";
															}
															echo '>&nbsp;' . $answer_ex[0];
															if($answer_ex[1]){
																if(file_exists($answer_ex[1])){
																	echo '<img src='.$answer_ex[1].'>';
																}
															}

														if ($Z['a_other'] == "Y") {
															echo '<input name="oth' . $X['q_id'] . '_' . $p . '" class="_6lux" type="text" id="ckk' . $k . '"> ' . PHP_EOL;
														} else {
															echo '<input type="hidden" id="ckk' . $k . '" name="oth' . $X['q_id'] . '_' . $p . '">' . PHP_EOL;
														}
														echo '</div>' . PHP_EOL;

														$p++;
													}
													echo '</div>' . PHP_EOL;
												}
												echo '<div class="clearfix">&nbsp;</div>' . PHP_EOL;
											} else if ($X['q_anstype'] == "C") {

												//echo '<input type="hidden" id="ck'.$k.'" value="select-one">'.PHP_EOL;
												echo '<select name="ans' . $X['q_id'] . '" class="_6lux" id="ck' . $k . '"/>' . PHP_EOL;
												echo '<option  value=""> กรุณาเลือก </option>' . PHP_EOL;
												$a_Zdata = db::getFetchAll($SSS1, PDO::FETCH_ASSOC);
												if ($a_Zdata) {
													foreach ((array)$a_Zdata as $Z) {
														$answer_ex = explode("#@form#img@#", $Z['a_name']);
														echo '<option value="' . $answer_ex[0] . '"';
														if($answer_ex[1]){
															if(file_exists($answer_ex[1])){
																echo '<img src='. $answer_ex[1].'>';
															}
														}
														if ($Z['option4'] == "Y") {
															echo "selected";
														}
														echo '>' . $answer_ex[0] . '</option>' . PHP_EOL;
													}
												}
												echo '</select>' . PHP_EOL;

												echo '<div class="clearfix">&nbsp;</div>' . PHP_EOL;
											}
											echo '</div>' . PHP_EOL;

											$k++;
										}
									}
								}
							}
						}
						?>

						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 text-center mt-3">
								<a class=" btn--register" href="#!" role="button" onclick="show_pre();">บันทึกแบบฟอร์ม</a>
							</div>
						</div>
						<!-- Modal ปุ่มตอบแบบฟอร์ม --> 

						<div class="margintop15 mb-2"></div>

						<div class="clearfix">&nbsp;</div>
						<h3>
							<?php echo $s_detail; ?>
						</h3>
				</fieldset>
			</form>
		</div>
		<!-- end Show Form -->

	</div>
</div>


</div>
</div>
<div id="box_popup" class="layer-modal"></div>
<div id="box_popup1" class="layer-modal"></div>

<?php include('footer.php'); ?>
<?php //include('combottom.php'); ?>
<script type="text/javascript">
	$('.numberint').keypress(function(event) {
		return isNumberInt(event, this)
	});

	function isNumberInt(evt, element) {
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (
			//(charCode != 45 || $(element).val().indexOf('-') != -1) &&      // “-” CHECK MINUS, AND ONLY ONE.
			//(charCode != 46 || $(element).val().indexOf('.') != -1) &&      // “.” CHECK DOT, AND ONLY ONE.
			(charCode < 48 || charCode > 57))
			return false;
		return true;
	}

	function show_pre() {

		var answer_s = "";
		var answer = "";
		var answer2 = "";
		//alert(form1.length);  
		var data_arr = [];
		var chcekbox_count = [];
		var data_checkbox = [];

		var checked = false;
		var radio = "";

		$('#frmMain').find('select, textarea, input').each(function() {
			if (!$(this).prop('required')) {
				if ($(this).is("select")) { //select  
					var name = $(this).attr('name');
					var id = $(this).attr('id');
					//var label = $("[for="+name+"]");
					//var	text = $(label).text(); 
					if ($(this).val() != '') {
						checked = true;
						//answer = $(this).val();
						answer = id + '|check|' + $(this).val();
						data_arr.push(id + '|check|' + $(this).val());
					} else {
						if (data_arr.includes(id + '|uncheck|ไม่กรอกข้อมูล') == false) {
							checked = false;
							data_arr.push(id + '|uncheck|ไม่กรอกข้อมูล');
						}
					}
				} else if ($(this).is("[type=text]")) { //type=text	 	

					var name = $(this).attr('name');
					var id = $(this).attr('id');
					//var label = $("[for="+id+"]");
					//var	text = $(label).text();				
					var file = $(this).val();

					if ($(this).val() != '') {
						checked = true;
						//answer = $(this).val();
						answer = id + '|check|' + $(this).val();
						data_arr.push(id + '|check|' + $(this).val());
					} else {
						if (data_arr.includes(id + '|uncheck|ไม่กรอกข้อมูล') == false) {
							checked = false;
							data_arr.push(id + '|uncheck|ไม่กรอกข้อมูล');
						}
					}

				} else if ($(this).is("textarea")) { //type=textarea	 

					var name = $(this).attr('name');
					var id = $(this).attr('id');
					//var label = $("[for="+id+"]");
					//var	text = $(label).text();				

					if ($(this).val() != '') {
						checked = true;
						//answer = $(this).val();
						answer = id + '|check|' + $(this).val();
						data_arr.push(id + '|check|' + $(this).val());
					} else {
						if (data_arr.includes(id + '|uncheck|ไม่กรอกข้อมูล') == false) {
							checked = false;
							data_arr.push(id + '|uncheck|ไม่กรอกข้อมูล');
						}
					}

				} else if ($(this).is("[type=date]")) { //type=date	

					var name = $(this).attr('name');
					var id = $(this).attr('id');
					//var label = $("[for="+id+"]");
					//var	text = $(label).text();				
					var date = $(this).val();

					if ($(this).val() != '') {
						checked = true;
						var cdate = date.split("-");
						newdate = cdate[2] + "/" + cdate[1] + "/" + (parseInt(cdate[0]) + 543);
						data_arr.push(id + '|check|' + newdate);
					} else {
						if (data_arr.includes(id + '|uncheck|ไม่กรอกข้อมูล') == false) {
							checked = false;
							data_arr.push(id + '|uncheck|ไม่กรอกข้อมูล');
						}
					}

				} else if ($(this).is("[type=file]")) { //type=file	 	

					var name = $(this).attr('name');
					var id = $(this).attr('id');
					//var label = $("[for="+id+"]");
					//var	text = $(label).text();				
					var file = $(this).val();

					if ($(this).val() != '') {
						checked = true;
						//answer = $(this).val();
						answer = id + '|check|' + $(this).val();
						data_arr.push(id + '|check|' + $(this).val());
					} else {
						if (data_arr.includes(id + '|uncheck|ไม่กรอกข้อมูล') == false) {
							checked = false;
							data_arr.push(id + '|uncheck|ไม่กรอกข้อมูล');
						}
					}
				} else if ($(this).is("[type=radio]")) { //type=radio	


					var name = $(this).attr('name');
					var id = $(this).attr('id');

					if ($("input:radio[name=" + name + "]").is(':checked') == true) {

						//alert($("input:radio[name="+name+"]:checked").val());   
						var label = $("[for=" + name + "]");
						var text = $(label).text();
						var inputs = document.querySelectorAll('input[name="' + name + '"]:checked');
						var txt = "";
						var i;
						for (i = 0; i < inputs.length; i++) {
							if (inputs[i].checked) {

								txt = inputs[i].value.split('##');
								if (data_arr.includes(id + '|check|' + txt[1]) == false) {
									checked = true;
									answer = id + '|' + txt[1];
									data_arr.push(id + '|check|' + txt[1]);
								}
							}
						}
					} else {
						if (data_arr.includes(id + '|uncheck|ไม่กรอกข้อมูล') == false) {
							checked = false;
							data_arr.push(id + '|uncheck|ไม่กรอกข้อมูล');
						}
					}

				} else if ($(this).is("[type=checkbox]")) { //type=checkbox	
					var name = $(this).attr('name');
					var id = $(this).attr('id');

					if ($("input:checkbox[name=" + name + "]").is(':checked') == true) {
						chcekbox_count.push(name);
						//alert($("input:radio[name="+name+"]:checked").val());   
						var label = $("[for=" + name + "]");
						var text = $(label).text();
						var inputs = document.querySelectorAll('input[name="' + name + '"]:checked');
						var txt = "";
						var i;
						var texts = [];

						if (data_arr.includes(id + '|check|') == false) {
							answer2 = id + '|check|';
							data_checkbox.push(answer2 += document.getElementsByName(name)[0].value.split('##')[1]);
							for (i = 0; i < inputs.length; i++) {
								if (inputs[i].checked) {
									checked = true;
									txt = inputs[i].value.split('##');
									answer2 += '' + txt[1];
									texts.push(answer2);
								}
							}
							//data_arr.push(answer2);		
						}
					} else {
						if (chcekbox_count.length == 0) {
							if (data_arr.includes(id + '|uncheck|ไม่กรอกข้อมูล') == false) {
								checked = false;
								data_arr.push(id + '|uncheck|ไม่กรอกข้อมูล');
							}
						}
					}
					data_arr.push(data_checkbox);
					//console.log(data_checkbox);	 
				}
			}
		});
		/*if(checked == true)
			{
				if(answer2 != "" && answer2 != 'undefined')
				{
					data_arr.push('check|'+answer2);
					//answer2 = ""; 
				}
				else
				{
					if(answer != "" && answer != 'undefined')   
					{
						if(data_arr.includes('check|'+answer) == false )  
						{	
							data_arr.push('check|'+answer); 
							//answer = "";
						}
					}
				}
				if(answer_s != "" && answer != 'undefined')
				{
					data_arr.push('check|'+answer_s); 
					//answer_s = ""; 
				}
									
			}
			else
			{
				data_arr.push('uncheck|ไม่กรอกข้อมูล');   
				//answer2 = "";
			}*/

		//alert(answer_s);       
		//}		
		//}

		// alert(data_arr); 
		// console.log(data_arr);

		$.ajax({
			type: 'POST',
			url: 'formgenerator_pre.php',
			data: {
				id: data_arr,
				cid: "<?php echo $id; ?>"
			},
			beforeSend: function() {
				$('#box_popup').html('');

			},
			success: function(data) {
				console.log(data);
				$('#box_popup').html(data);
			}
		});
		$('#box_popup').fadeIn();

	}

	function show_per1() {

		var form1 = $("[id=hit]");
		var req = $("[id=req]");
		var reqname = $("[id=reqname]");
		var reqfig = $("[id=reqfig]");

		//var form1 = document.frmMain.elements['hit'];
		//var req = document.frmMain.elements['req'];
		//var reqname = document.frmMain.elements['reqname'];
		//var reqfig = document.frmMain.elements['reqfig'];

		var answer = "";
		var answer2 = "";
		alert(form1.length);
		var data_arr = [];
		for (var j = 0; j < form1.length; j++) {
			var form = document.frmMain.elements['ck' + j];
			var ckc = document.frmMain.elements['ckc' + j];
			var ckk = document.frmMain.elements['ckk' + j];
			var checked = false;
			var radio = "";

			for (var i = 0; i < form.length; i++) {

				//alert(form[i].type); 	 
				//if(form[i].type=="button") continue;
				//if(form[i].type=="hidden") continue;
				//จำเป็นต้องกรอกข้อมูล
				if (req[j].value != "") {
					if (form[i].type == "radio") {
						if (form[i].checked == true) {
							checked = true;
							var ot = form[i].value.split('##');
							var aa = ot[0];
							if (ckc[aa].value != "") {
								answer = ckc[aa].value;
							} else {
								answer = ot[1];
							}
						} else {
							radio = form[i];
						}
					} else if (form[i].type == "checkbox") {
						if (form[i].checked == true) {
							checked = true;
							//answer = form[i].value;
							var ot = form[i].value.split('##');
							var aa = ot[0];
							if (ckk[aa].value != "") {
								answer2 += ckk[aa].value + "##";
							} else {
								answer2 += ot[1] + "##";
							}
						} else {
							radio = form[i];
						}
					} else if (form[i].type == "text") {
						if (form[i].value != "") {
							if (reqfig[j].value == "N") {
								if (isNaN(form[i].value)) {
									//checked = "n";
									alert('กรุณากรอกตัวเลขเท่านั้น');
									form[i].focus();
									return false;
								} else {
									checked = true;
									answer = form[i].value;
								}
							} else if (reqfig[j].value == "Y") {
								var goodEmail1 =
									form[i].value.match(/\b(^(\S+@).+((\.com)|(\.net)|(\.edu)|(\.mil)|(\.gov)|(\.org)|(\.co.th)|(\.go.th)|(\.localnet)|(\..{2,2}))$)\b/gi);
								if (!goodEmail1) {
									alert('กรุณากรอกอีเมล์ให้ถูกรูปแบบ');
									form[i].focus();
									return false;
								} else {
									checked = true;
									answer = form[i].value;
								}
							} else if (form[i].value != '') {
								checked = true;
								answer = form[i].value;
							} else {
								var Data = 'ข้อที่ ' + req[j].value + reqname[j].value;
								form[i].focus();
								$.alert({
									title: 'กรุณากรอกข้อมูล',
									content: Data,
									icon: 'fas fa-exclamation-circle',
									theme: 'material',
									type: 'orange',
									animation: 'scale',
									closeAnimation: 'scale',
									buttons: {
										close: {
											text: 'ปิด',
											btnClass: 'btn-orange',
										}
									},
									boxWidth: '30%',
									useBootstrap: false,
									closeIcon: true,
									closeIconClass: 'fa fa-close',
								});
								return false;
							}
						} else {
							var Data = 'ข้อที่ ' + req[j].value + reqname[j].value;
							form[i].focus();
							$.alert({
								title: 'กรุณากรอกข้อมูล',
								content: Data,
								icon: 'fas fa-exclamation-circle',
								theme: 'material',
								type: 'orange',
								animation: 'scale',
								closeAnimation: 'scale',
								buttons: {
									close: {
										text: 'ปิด',
										btnClass: 'btn-orange',
									}
								},
								boxWidth: '30%',
								useBootstrap: false,
								closeIcon: true,
								closeIconClass: 'fa fa-close',
							});
							return false;
							//alert('กรุณาตอบคำถามในข้อ '+req[j].value+reqname[j].value);
							//form[i].focus();
							//return false;										
						}
					} else if (form[i].type == "textarea") {
						if (form[i].value != "") {
							checked = true;
							answer = form[i].value;
						} else {
							var Data = 'ข้อที่ ' + req[j].value + reqname[j].value;
							form[i].focus();
							$.alert({
								title: 'กรุณากรอกข้อมูล',
								content: Data,
								icon: 'fas fa-exclamation-circle',
								theme: 'material',
								type: 'orange',
								animation: 'scale',
								closeAnimation: 'scale',
								buttons: {
									close: {
										text: 'ปิด',
										btnClass: 'btn-orange',
									}
								},
								boxWidth: '30%',
								useBootstrap: false,
								closeIcon: true,
								closeIconClass: 'fa fa-close',
							});

							return false;

						}
					} else if (form[i].type == "date") {
						if (form[i].value != "") {
							checked = true;
							var cdate = form[i].value.split("-");
							answer = cdate[2] + "/" + cdate[1] + "/" + (parseInt(cdate[0]) + 543);
						} else {
							var Data = 'ข้อที่ ' + req[j].value + reqname[j].value;
							form[i].focus();
							$.alert({
								title: 'กรุณาเลือกวันที่',
								content: Data,
								icon: 'fas fa-exclamation-circle',
								theme: 'material',
								type: 'orange',
								animation: 'scale',
								closeAnimation: 'scale',
								buttons: {
									close: {
										text: 'ปิด',
										btnClass: 'btn-orange',
									}
								},
								boxWidth: '30%',
								useBootstrap: false,
								closeIcon: true,
								closeIconClass: 'fa fa-close',
							});

							return false;
							//alert('กรุณาเลือกวันที่ในข้อ '+req[j].value+reqname[j].value);
							//form[i].focus();
							//return false;
						}
					} else if (form[i].value == "select-one") {

					} else if (form[i].value == "select") {

						if ($(".s3" + j).val() != "" || $(".s2" + j).val() != '' || $(".s1" + j).val() != '' || $(".s4" + j).val() != '' || $(".s5" + j).val() != '') {
							checked = true;
							answer = "ตำบล/เขต:" + $(".s3" + j).val() + "&&" + $(".s2" + j).val() + "&&" + $(".s1" + j).val() + "&&" + $(".s4" + j).val() + "&&" + $(".s5" + j).val();
						} else {
							checked = false;
							alert('กรุณาเลือก จังหวัด/อำเภอ/ตำบล ในข้อ ' + req[j].value + reqname[j].value);
							$(".s1" + j).focus();
							return false;
						}
					} else if (form[i].type == "file") {
						if (form[i].value != "") {
							var extall = $("#tfile").val();
							var sizefig = $("#sfile").val();
							var file = form[i].value;
							var size = form[i].files[0].size;
							size = Math.floor(size / 1024);
							var ext = file.split('.').pop().toLowerCase();
							if (parseInt(extall.indexOf(ext)) < 0) {
								//alert('กรุณาเลือกชนิดไฟล์ '+extall);
								form[i].focus();
								$.alert({
									title: 'กรุณาเลือกชนิดไฟล์ ' + extall + '',
									content: '',
									icon: 'fas fa-exclamation-circle',
									theme: 'material',
									type: 'orange',
									animation: 'scale',
									closeAnimation: 'scale',
									buttons: {
										close: {
											text: 'ปิด',
											btnClass: 'btn-orange',
										}
									},
									boxWidth: '30%',
									useBootstrap: false,
									closeIcon: true,
									closeIconClass: 'fa fa-close',
								});

								return false;
							}
							if (size > sizefig) {
								//alert("ขนาดไฟล์ต้องไม่เกิน "+sizefig+" KB.");
								//var Data = 'ข้อที่ '+req[j].value+reqname[j].value;						
								form[i].focus();
								$.alert({
									title: 'ขนาดไฟล์ต้องไม่เกิน ' + sizefig + ' KB.',
									content: '',
									icon: 'fas fa-exclamation-circle',
									theme: 'material',
									type: 'orange',
									animation: 'scale',
									closeAnimation: 'scale',
									buttons: {
										close: {
											text: 'ปิด',
											btnClass: 'btn-orange',
										}
									},
									boxWidth: '30%',
									useBootstrap: false,
									closeIcon: true,
									closeIconClass: 'fa fa-close',
								});

								return false;
							}
						} else {
							var Data = 'ข้อที่ ' + req[j].value + reqname[j].value;
							//alert('กรุณาเลือกไฟล์ในข้อ '+req[j].value+reqname[j].value);
							form[i].focus();
							$.alert({
								title: 'กรุณาเลือกไฟล์',
								content: Data,
								icon: 'fas fa-exclamation-circle',
								theme: 'material',
								type: 'orange',
								animation: 'scale',
								closeAnimation: 'scale',
								buttons: {
									close: {
										text: 'ปิด',
										btnClass: 'btn-orange',
									}
								},
								boxWidth: '30%',
								useBootstrap: false,
								closeIcon: true,
								closeIconClass: 'fa fa-close',
							});
							return false;
						}
						checked = true;
						answer = form[i].value;
					} else {

						if (form[i].type != "hidden") {
							if (form[i].value != "") {
								checked = true;
								answer = form[i].value;
							} else {
								//alert('กรุณาตอบคำถามในข้อ '+req[j].value+reqname[j].value);

								var Data = 'ข้อที่ ' + req[j].value + reqname[j].value;
								form[i].focus();
								$.alert({
									title: 'กรุณากรอกข้อมูล',
									content: Data,
									icon: 'fas fa-exclamation-circle',
									theme: 'material',
									type: 'orange',
									animation: 'scale',
									closeAnimation: 'scale',
									buttons: {
										close: {
											text: 'ปิด',
											btnClass: 'btn-orange',
										}
									},
									boxWidth: '30%',
									useBootstrap: false,
									closeIcon: true,
									closeIconClass: 'fa fa-close',
								});

								return false;

							}
						} else {

						}
					}



					//ไม่จำเป็นต้องกรอก
				} else {
					//alert(form[i].type+' && '+form[i].value);
					if (form[i].type == "radio") {
						//alert(form[i].name);  
						if (document.querySelector('input[name="' + form[i].name + '"]:checked')) {
							//document.querySelector("input[name=main-categories]:checked").value	
							var inputs = document.querySelectorAll('input[name="' + form[i].name + '"]:checked');
							var txt = "";
							var i;
							for (i = 0; i < inputs.length; i++) {
								if (inputs[i].checked) {
									checked = true;
									txt = inputs[i].value.split('##');
									answer = txt[1];
								}
							}
							//var ot = form[i].value.split('##');  
							//var aa = ot[0];
							//if(ckc[aa].value!="")
							//{
							//answer = ckc[aa].value; 
							//}
							//else
							//{
							//answer = txt;
							//}						
						}
					} else if (form[i].type == "checkbox") {
						/*if(form[i].checked==true)
						{
							checked = true;
							  //answer = form[i].value;
							var ot = form[i].value.split('##');
							var aa = ot[0];
							if(ckk[aa].value!="")
							{
								answer2 += ckk[aa].value+"##";
							}
							else
							{
								answer2 += ot[1]+"##";
							}  
						}
						else
						{
							answer2 += ""+"##";
						}*/
					} else if (form[i].type == "text") {
						if (reqfig[j].value == "N") {
							if (isNaN(form[i].value)) {
								//checked = "n";
								alert('กรุณากรอกตัวเลขเท่านั้น');
								form[i].focus();
								return false;
							} else {
								if (form[i].value != "") {
									checked = true;
									answer = form[i].value;
								}
							}
						} else if (reqfig[j].value == "Y" && form[i].value != "") {
							var goodEmail1 =
								form[i].value.match(/\b(^(\S+@).+((\.com)|(\.net)|(\.edu)|(\.mil)|(\.gov)|(\.org)|(\.co.th)|(\.go.th)|(\.localnet)|(\..{2,2}))$)\b/gi);
							if (!goodEmail1) {
								//alert('กรุณากรอกอีเมล์ให้ถูกรูปแบบ');
								//form[i].focus();
								//var Data = 'ข้อที่ '+req[j].value+reqname[j].value;								
								form[i].focus();
								$.alert({
									title: 'กรุณากรอกข้อมูล',
									content: 'รูปแบบอีเมล์ไม่ถูกต้อง',
									icon: 'fas fa-exclamation-circle',
									theme: 'material',
									type: 'orange',
									animation: 'scale',
									closeAnimation: 'scale',
									buttons: {
										close: {
											text: 'ปิด',
											btnClass: 'btn-orange',
										}
									},
									boxWidth: '30%',
									useBootstrap: false,
									closeIcon: true,
									closeIconClass: 'fa fa-close',
								});
								return false;
							} else {
								checked = true;
								answer = form[i].value;
							}
						} else if (form[i].value != "") {
							checked = true;
							answer = form[i].value;
						}
					} else if (form[i].type == "date") {
						if (form[i].value != "") {
							checked = true;
							var cdate = form[i].value.split("-");
							answer = cdate[2] + "/" + cdate[1] + "/" + (parseInt(cdate[0]) + 543);
						}
					} else if (form[i].type == "file") {
						if (form[i].value != "") {
							var extall = $("#tfile").val();
							var sizefig = $("#sfile").val();
							var file = form[i].value;
							var size = form[i].files[0].size;
							size = Math.floor(size / 1024);
							var ext = file.split('.').pop().toLowerCase();
							if (parseInt(extall.indexOf(ext)) < 0) {
								alert('กรุณาเลือกชนิดไฟล์ ' + extall);
								return false;
							}

							if (size > sizefig) {
								alert("ขนาดไฟล์ต้องไม่เกิน " + sizefig + " KB.");
								return false;
							}

							checked = true;
							answer = form[i].files[0].name;
						} else {
							checked = false;
							answer = "";
						}
						/*else{
							alert('กรุณาเลือกไฟล์ในข้อ '+req[j].value);
						 	form[i].focus();
						 	return false;
						}*/
					} else if (form[i].type == 'select') {
						/*if(form[i].selected != "") 
						{
							checked = true;
							answer = form[i].selected;
						}
						else
						{
							checked = false;
							answer = "";
						}*/

					} else if (form[i].value == "select") {
						var answer_s = '';

						checked = true;

						if ($(".s4" + j).val() != '') {
							answer_s += $(".s4" + j).val() + '=s4##';
						} else {
							answer_s += '=s4##';
						}
						if ($(".s1" + j).val() != '') {
							answer_s += $(".s1" + j).val() + '=s1##';
						} else {
							answer_s += '=s1##';
						}
						if ($(".s2" + j).val() != '') {
							answer_s += $(".s2" + j).val() + '=s2##';
						} else {
							answer_s += '=s2##';
						}

						if ($(".s3" + j).val() != '') {
							answer_s += $(".s3" + j).val() + '=s3##';
						} else {
							answer_s += '=s3##';
						}

						if ($(".s5" + j).val() != '') {
							answer_s += $(".s5" + j).val() + '=s5##';
						} else {
							answer_s += '=s5##';
						}


						/*if($(".s3"+j).val() != "" || $(".s2"+j).val() != '' || $(".s1"+j).val() != '' || $(".s4"+j).val() != '' || $(".s5"+j).val() != '')
						{
							checked = true;
							//answer = form[i].value;
							answer = "ตำบล/เขต:"+$(".s3"+j).val()+"&&"+$(".s2"+j).val()+"&&"+$(".s1"+j).val()+"&&"+$(".s4"+j).val()+"&&"+$(".s5"+j).val();;
						}
						else
						{
							checked = false; 
							answer = "";
						}*/
					} else {
						/*if(form[i].value!="")
						{
							if(form[i].value=="select")
							{
								//var x1 = document.getElementsByClassName("s2");
								if($(".s3"+j).val() != "" || $(".s2"+j).val() != '' || $(".s1"+j).val() != '' || $(".s4"+j).val() != '' || $(".s5"+j).val() != '')
								{
									checked = true;
									//answer = form[i].value;
									answer = "ตำบล/เขต:"+$(".s3"+j).val()+"&&"+$(".s2"+j).val()+"&&"+$(".s1"+j).val()+"&&"+$(".s4"+j).val()+"&&"+$(".s5"+j).val();;
								}
								else
								{
									checked = false;
									answer = "";
								}
							}
							else
							{
							  checked = true;
							  answer = form[i].value;
							}
						}*/
					}
				}
			}
			if (checked == false && req[j].value != "") {
				var Data = 'ข้อที่ ' + req[j].value + reqname[j].value;
				//radio.focus();
				$.alert({
					title: 'กรุณากรอกข้อมูล',
					content: Data,
					icon: 'fas fa-exclamation-circle',
					theme: 'material',
					type: 'orange',
					animation: 'scale',
					closeAnimation: 'scale',
					buttons: {
						close: {
							text: 'ปิด',
							btnClass: 'btn-orange',
						}
					},
					boxWidth: '30%',
					useBootstrap: false,
					closeIcon: true,
					closeIconClass: 'fa fa-close',
				});
				//alert('กรุณาเลือกคำตอบข้อ '+req[j].value+reqname[j].value);			
				return false;
			}

			/*if (checked == true){
				//a.push("yes&&"+form1[j].value+" ("+answer+")");
				data_arr.push("yes&&"+form1[j].value);
			} else {
				data_arr.push("no&&"+form1[j].value);
			}*/
			//if (checked == true){
			/*if(answer2!=""){
				data_arr.push("&&"+form1[j].value+" ("+answer2+")");
				answer2 = "";
			}else{
				data_arr.push("&&"+form1[j].value+" ("+answer+")");
				answer = "";
			}*/
			//alert(answer);
			if (checked == true) {
				if (answer2 != "" && answer2 != 'undefined') {
					data_arr.push('check|' + answer2);
					answer2 = "";
				} else {
					if (answer != "" && answer != 'undefined') {
						data_arr.push('check|' + answer);
						answer = "";
					}
				}
				if (answer_s != "" && answer != 'undefined') {
					data_arr.push('check|' + answer_s);
					answer_s = "";
				}

			} else {
				data_arr.push('uncheck|ไม่กรอกข้อมูล');
				answer2 = "";
			}
			//alert(answer_s);       
			//}		
		}
		// alert(data_arr);   

		// $.ajax({
		//     type: 'POST',
		//     url: 'formgenerator_pre.php',					
		// 	data: {id:data_arr,cid:"<?php echo $id; ?>"}, 
		//     beforeSend: function(){
		//         $('#box_popup').html('');

		//     },
		//     success: function (data){
		// 		console.log(answer);
		//         $('#box_popup').html(data);
		//     }
		//   });
		// $('#box_popup').fadeIn();									

	}


	function JQDelete(Con) {

		$.alert({
			title: 'กรุณาเลือกคำตอบ',
			content: Con,
			icon: 'fa fa-warning',
			theme: 'material',
			type: 'orange',
			closeIcon: true,
			buttons: {
				close: function() {
					//radio.focus();	 
				}
			},
		});
	}

	function showform_edit() {
		//$("#frm2").html('');
		//document.getElementById("frm1").style.display = "";
		//document.getElementById("frm2").style.display = "none"; 

	}

	function getAmp(code, amp) {
		$.get("list_amphur2.php", {
			p: code.value
		}, function(data) { // คืนค่ากลับมา

			$('#addr_amp' + amp).html(data);
			$('#addr_tamb' + amp).html('<option value="">- เลือกตำบล - </option>');
			$('#addr_tamb' + amp).val('');
			//$(id_amp).html('<option value="">- ssss -</option>');  
			//alert(id_amp);
		});
	}

	function getTam(id_prov, amp) {
		$.get("list_tumbon2.php", {
			am: id_prov.value,
			p: $("#addr_prov" + amp).val()
		}, function(data) { // คืนค่ากลับมา

			$('#addr_tamb' + amp).html(data);
			//$('#addr_tamb'+amp).html('<option value="">- ssss -</option>');  
			//alert(id_prov.value);
		});
	}

	function getAmp_null(amp) {
		if ($('#addr_prov' + amp).val() == "") {
			//alert("กรุณาเลือกจังหวัด");
			//$('#addr_prov'+amp).focus();
			//return false;
			var Data = '';

			$('#addr_prov' + amp).focus();
			$.alert({
				title: 'กรุณาเลือกจังหวัด',
				content: Data,
				icon: 'fa fa-warning',
				theme: 'material',
				type: 'orange',
				closeIcon: true,
				buttons: {
					close: function() {

					}
				},
			});

			return false;
		}
	}

	function getTam_null(amp) {
		if ($('#addr_amp' + amp).val() == "") {
			//alert("กรุณาเลือกอำเภอ");
			//$('#addr_amp'+amp).focus();
			//return false;
			var Data = '';

			$('#addr_amp' + amp).focus();
			$.alert({
				title: 'กรุณาเลือกอำเภอ',
				content: Data,
				icon: 'fa fa-warning',
				theme: 'material',
				type: 'orange',
				closeIcon: true,
				buttons: {
					close: function() {

					}
				},
			});

			return false;
		}
	}


	function submit_frm() {
		// $('#frmMain').submit(function(event) {
		// 	event.preventDefault(); // ป้องกันการโหลดหน้าใหม่เมื่อส่งฟอร์ม
		// 	var formData = $(this).serialize(); // รับข้อมูลฟอร์มและแปลงเป็นสตริง
		// 	$.ajax({
		// 		type: 'POST', // การส่งข้อมูลโดยใช้ HTTP POST method
		// 		url: 'formgenerator_process.php', // URL ของไฟล์ PHP ที่จะดำเนินการ
		// 		data: {
		// 			form: formData,
		// 			sid:"<?php //echo $id; ?>"
		// 		}, // ข้อมูลที่จะส่งไปยังเว็บเซิร์ฟเวอร์
		// 		success: function(data) { // การจัดการกับการตอบกลับจากเว็บเซิร์ฟเวอร์
		// 			// console.log(data); // แสดงข้อมูลการตอบกลับที่ได้รับ
		// 			// ดำเนินการอื่น ๆ ที่ต้องการ
		// 			alert('');
		// 		},
		// 		error: function(data) { // การจัดการเมื่อเกิดข้อผิดพลาด
		// 			console.log(data); // แสดงข้อผิดพลาดที่เกิดขึ้น
		// 		}
		// 	});
	// });
	$("#frmMain").attr("action", "formgenerator_process.php");
	document.getElementById("frmMain").submit();
	//$("#frmMain").attr("action", "formgenerator_process.php").submit();
	}


	function convertpdf() {
		$("#frmMain").attr("action", "formgenerator_covert.php").submit();
	}
</script>
<?php //include('script_footer.php'); ?>

