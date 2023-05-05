<?php
DEFINE('path', 'assets/');
include(path . 'config/config.inc.php');
$a_data = array_merge($_POST, $_FILES);
// echo "<pre>"; print_r($a_data);echo "</pre>";

$icon_chk = "fas fa-check-circle text-success margintop10";
$icon_unchk = "fas fa-times-circle text-danger margintop10";

function genCheck($str)
{
	$val = explode('|', $str);
	if ($val[1] == 'check') {
		$a_icon = '<em class="fas fa-check-circle text-success"></em> ' . $val[2];
	} else if ($val[1] == 'uncheck') {
		$a_icon = '<em class="fas fa-times-circle text-danger"></em> ' . $val[2];
	} else {
		$a_icon = '';
	}

	return $a_icon;
}



$SQL1   = "SELECT * FROM ". E_DB_NAME . ".p_survey WHERE s_id = '{$a_data['cid']}'";
$a_row	= db::getRowCount($SQL1);
$PR     = db::getFetch($SQL1, PDO::FETCH_ASSOC);

$SQL 	= "	SELECT DISTINCT(p_cate.c_id),p_cate.c_d,p_cate.c_name,p_cate.c_title,p_cate.c_gp,p_cate.option1,p_cate.option2 
				FROM ". E_DB_NAME . ".p_cate,". E_DB_NAME . ".p_question 
				WHERE p_cate.s_id = '{$a_data['cid']}' AND p_cate.c_id = p_question.c_id 
				ORDER BY p_cate.c_d ASC";

$id = $a_data['id'];

// echo "<pre>";
// print_r($a_data['id']);
// echo "</pre>";
?>
<div class="container">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-body">


				<div class="row narrow ">
					<div class="col-full s-content__header  mt-5">
						<h3><?php echo strip_tags($PR['s_title']) ?></h3>
					</div>
				</div>

				<!-- Close แสดงส่วนของแบบฟอร์ม -->
				<div class="row ">
					<!-- Open รูปแบบ List รายการ -->
					<div class="form--block">

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
									echo '<div class="form--description-text">รายละเอียด : ' . strip_tags($R['c_title']) . '</div>';
								}

								$SSS = "SELECT * FROM ". E_DB_NAME . ".p_question WHERE c_id = '{$R['c_id']}' ORDER BY q_pos ASC";

								if ($R['c_gp'] == "Y") {

									echo '<table class="table table-bordered" style="border-color:#B5B5B5;">';
									echo '<tr class="info center">';
									echo '<td rowspan="2" style="padding-top:25px;text-align:center;">ลำดับ</td>';
									echo '<td rowspan="2" style="padding-top:25px;text-align:center;">คำถาม</td>';
									echo '<td colspan="5" style="padding-top:25px;text-align:center;">คำตอบ</td>';
									echo '</tr>';
									echo '<tr class="info center">';

									$SQL2 = "SELECT DISTINCT(p_ans.a_name) FROM ". E_DB_NAME . ".p_ans,". E_DB_NAME . ".p_question WHERE p_question.c_id = '{$R['c_id']}' AND p_question.q_id = p_ans.q_id ORDER BY p_ans.option3";
									$a_pAns = db::getFetchAll($SQL2, PDO::FETCH_ASSOC);
									
									if ($a_pAns) {
										foreach ((array)$a_pAns as $Q) {
											echo '<td align="center">' .($Q['a_name']) . '</td>';
										}
									}
									echo '</tr>';
									$a_pQuestion = db::getFetchAll($SSS, PDO::FETCH_ASSOC);
								
									if ($a_pQuestion) {
										foreach ((array)$a_pQuestion as $X) {
											$just = explode('#zz#',($X['q_req']));
											$req  = "";
											echo '<tr>';
											echo '<td class="center" style="vertical-align:top;text-align:center;">' . strip_tags($X['q_name']) . '</td>';
											echo '<td class="text-left">' . strip_tags($X['q_des']);
											if ($just[0] == 'Y') {
												echo ' <span class="text-danger">*</span>';
												//$req = $R[c_d].'.'.$X[q_name];
												$req =($X['q_name']) . ".";
											}
											echo ' </td>';

											$SQL2 = "SELECT DISTINCT(p_ans.a_name) FROM ". E_DB_NAME . ".p_ans,". E_DB_NAME . ".p_question WHERE p_question.c_id = '{$R['c_id']}' AND p_question.q_id = p_ans.q_id ORDER BY p_ans.option3";
											$a = 0;
											$a_pAns = db::getFetchAll($SQL2, PDO::FETCH_ASSOC);
											
											if ($a_pAns) {
												foreach ((array)$a_pAns as $Q) {
													echo '<td class="center" style="text-align:center;">';
													//echo '<li class="fa fa-check-circle-o text-success"></li>';
													$ssub = explode('|', $id[$k]);

													//echo "<pre>";
													//print_r($ssub); 
													//echo "</pre>";

													if ($R['option1'] == "A") {
														if ($ssub[2] ==($Q['a_name'])) {
															echo genCheck($ssub[1]);
														}

														if ($ssub[1] == 'uncheck') {
															echo '<li class="' . $icon_unchk . '"></li>';
														} else {
															//echo '<li class="'.$icon_unchk.'"></li>';  
															//echo genCheck($ssub[0]);
														}
													} else {
														$ssub2 = explode('##', $ssub[1]);
														if ($ssub2[$a] ==($Q['a_name'])) {
															//echo $ssub2[$a];
															echo $ssub[0];
														}
													}
													echo '</td>';
													$a++;
												}
											}
											echo '</tr>';
											$k++;
										}
									}
									echo '</table>';
								} else {
									$a_pQuestion = db::getFetchAll($SSS, PDO::FETCH_ASSOC);
									if ($a_pQuestion) {
										foreach ((array)$a_pQuestion as $X) {
											$just = explode('#zz#',($X['q_req']));

											$req = "";

											// echo '<div class="headq mt-3">' . strip_tags($X['q_name']) . '. ' . $X['q_id'];
											echo '<div class="headq mt-3">' . strip_tags($X['q_name']) . '. ' ;

											if ($just[0] == "Y") {
												//$required= "#zz#";
												echo '<span class="text-danger">*</span> ';
												//$req = $R[c_d].'.'.$X[q_name];
												$req =($X['q_name']) . ".";
											}
											echo ($X['q_des']) . '</div>';

											$ssub = explode('|', $id[$k]);
											$_dataadd  = explode('##', $ssub[2]);

											//echo "<pre>";
											//print_r($ssub);  
											//echo "</pre>";  

											/*$nameamp = "";
											foreach($_dataadd as $_item)     
											{ 	
											
											$_area  = explode('=',$_item);
											if($_area[1]=="s1") 
											{	
												if($_area[0]!="") 
												{
													$_pcode = $_area[0];	
												}
											}
											if($_area[1]=="s2")
											{	
												if($_area[0]!="") 
												{
													$_acode = $_area[0];	
												}
											} 
											if($_area[1]=="s4") 
											{
												if($_area[0]!="") 
												{
													$nameamp .= "<br><li class='".$icon_chk."'></li> ที่อยู่ : ".$_area[0]; 
												}
												else
												{
													$nameamp .= "<br><li class='".$icon_unchk."'></li> ที่อยู่ : ";
												}
											}				
											if($_area[1]=="s3")
											{	
												if($_area[0]!="") 
												{			
													$s_tumpon = "SELECT * FROM ".E_DB_USER.".tumpon WHERE t_code = '{$_area[0]}' AND p_code = '{$_pcode}' AND a_code = '{$_acode}'";  
													$a_tumpon = db::getFetchAll($s_tumpon,PDO::FETCH_ASSOC); 
													if($a_tumpon) 
													{	
														foreach((array)$a_tumpon as $rec_tumpon) 
														{	
															$nameamp .= " <br><li class='".$icon_chk."'></li> ตำบล : ".$rec_tumpon['t_name']; 
														}
													}							
												}
												else
												{
													$nameamp .= " <br><li class='".$icon_unchk."'></li> ตำบล : "; 
												}					
											} 
											if($_area[1]=="s2")
											{
												if($_area[0]!="") 
												{	
													$s_amphur = "SELECT * FROM ".E_DB_USER.".amphur WHERE a_code = '{$_area[0]}' AND p_code = '{$_pcode}' ";    
													$a_amphur = db::getFetchAll($s_amphur,PDO::FETCH_ASSOC); 
													if($a_amphur) 
													{	
														foreach((array)$a_amphur as $rec_amphur)
														{	
															$nameamp .= " <br><li class='".$icon_chk."'></li> อำเภอ : ".$rec_amphur['a_name'];  
														}
													}							
												}
												else
												{				
													$nameamp .= " <br><li class='".$icon_unchk."'></li> อำเภอ : "; 
												}						
											}
											if($_area[1]=="s1")
											{	
												if($_area[0]!="") 
												{					
													$s_province = "SELECT * FROM ".E_DB_USER.".province WHERE p_code = '".$_area[0]."' ";
													$a_Zdata = db::getFetchAll($s_province,PDO::FETCH_ASSOC);
													if($a_Zdata) 
													{	
														foreach((array)$a_Zdata as $rec_province)
														{
															$nameamp .= " <br><li class='".$icon_chk."'></li> จังหวัด : ".$rec_province['p_name'];   
														}
													}
												}
												else
												{
													$nameamp .= " <br><li class='".$icon_unchk."'></li> จังหวัด : ";
												}					
											}				
											if($_area[1]=="s5")
											{	
												if($_area[0]!="") 
												{
													$nameamp .= " <br><li class='".$icon_chk."'></li> รหัสไปรษณีย์ : ".$_area[0];				
												}
												else
												{
													$nameamp .= " <br><li class='".$icon_unchk."'></li> รหัสไปรณีย์ : ";
												}
											}
											
											} */
											if ($ssub[0] == 'addr_no' . $X['q_des']) {
												if ($ssub[1] == "check") {
													$nameamp .= "<br><li class='" . $icon_chk . "'></li> ที่อยู่ : " . $ssub[2];
												} else {
													$nameamp .= "<br><li class='" . $icon_unchk . "'></li> ที่อยู่ : ";
												}
											}

											if ($X['q_anstype'] == "B") {
												echo '<div class="mb-5">';
												$ssub2 = explode('##', $ssub[1]);
												
												// foreach ($ssub2 as $value) {
												// 	if ($value != "") {
												// 		echo '<div class="checkbox"><label>' . genCheck($ssub[0]) . ' ' . $value . '</label></div>';
												// 	}
												// }
												echo '</div>';

												// echo "<pre>";
												// print_r($id[$k]);
												// echo "</pre>";
											} else {
												//echo '<div class="container mb-5">';
												//echo $ssub[0].' '.$ssub[1].$nameamp;
												//echo '</div>'; 
												if ($X['q_anstype'] == 'G') {
													//echo '<div class="mb-5">';
													//echo '<div class="checkbox"><label>'.$ssub[2].' '.$ssub[3].$nameamp.'</label></div>';    
													//echo '</div>';
													echo '<div class="mb-5">';
													echo '<div class="checkbox"><label>' . $nameamp . '</label></div>';
													echo '</div>';
												} else {
													echo '<div class="mb-5">';
													echo '<div class="checkbox"><label>' . genCheck($id[$k]) . '</label></div>';
													echo '</div>';
												}
											}

											$k++;
										}
									}
								}
							}
						}
						?>
					</div>
				</div>

				<div class="mb-5 mt-5" align="center">
					<!--<a href="#" data-toggle="modal" data-target="#myModalformAlerts">
					<button type="submit" class="btn btn-success" onclick="submit_frm()"> <li class="far fa-check-circle"></li> ยืนยันการบันทึกแบบฟอร์ม</button>
					</a>-->
						<a class="btn--register" href="#!" role="button" onclick="submit_frm();" type="submit" value="Submit">
							<li class="fas fa-check-circle"></li> ยืนยันการบันทึกแบบฟอร์ม
						</a>
					
					<a class="btn--register" href="#!" role="button" onclick="$('#box_popup').fadeOut();"><i class="fas fa-reply"></i> กลับไปแก้ไขข้อมูล</a>
				</div>
			</div>
		</div>
	</div>
</div>

