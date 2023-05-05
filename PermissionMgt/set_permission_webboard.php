<?php
$s_data = array();
$_sql = $db->query("SELECT * FROM permission 
WHERE pu_id = '{$pu_id}' 
AND p_type = '{$p_type}' 
AND s_type = 'Wb'
AND UID = '{$UID}' 
AND s_permission = '{$s_permission}' 
AND s_id != '0' 
AND s_name = '' 
ORDER BY p_id ASC ");

$a_rows = $db->db_num_rows($_sql);
while ($a_data = $db->db_fetch_array($_sql)) {
	array_push($s_data, $a_data['s_id']);
}

$_sql_sup = $db->query("SELECT * FROM permission 
WHERE pu_id = '{$pu_id}' 
AND p_type = '{$p_type}' 
AND s_type = 'Wb'  
AND UID = '{$UID}' 
AND s_permission = '{$s_permission}' 
AND s_id = '0' 
AND s_name = ''");

$a_rows_sup = $db->db_num_rows($_sql_sup);
if ($a_rows_sup > 0) {
	$supcheck = 'checked="checked"';
}

//print_r($s_data);
$db->query("USE " . $EWT_DB_NAME);

function cateList($s_id)
{
	global $db, $s_data, $a_rows_sup;
	$s_sql = $db->query("SELECT c_id,c_name FROM article_group WHERE c_parent = '{$s_id}' ");
	$a_rows = $db->db_num_rows($s_sql);
	echo '<ul>';

	if ($a_rows) {

		while ($_item = $db->db_fetch_array($s_sql)) {
			if ($a_rows_sup == 0) {
				$s_chk = (in_array($_item['c_id'], $s_data)) ? ' checked="checked"' : '';
				//unset($s_data[$_item['c_id']]);
			} else {
				$s_chk = 'checked="checked"';
			}

			echo '<li>';
			echo '<div class="checkbox">&nbsp;&nbsp;';
			echo '<label>';
			echo '<input type="checkbox" ' . $s_chk . ' id="c_cate' . $_item['c_id'] . '" name="c_cate[' . $_item['c_id'] . ']"  value="' . $_item['c_id'] . '" />';
			echo '<span class="cr1"><i class="cr-icon fas fa-check color-ewt"></i></span>&nbsp;<b>&nbsp;' . $_item['c_name'] . '</b>';
			echo '</label>';
			echo '</div>';
			cateList($_item['c_id']);
			echo '</li>';
		}
	}
	echo '</ul>';
}
$db->query("USE " . $EWT_DB_NAME);
?>

<input type="hidden" name="proc" id="proc" value="Add_Admission_Webboard">
<input type="hidden" name="p_type" id="p_type" value="<?php echo $p_type; ?>">
<input type="hidden" name="p_code" id="p_code" value="<?php echo $s_type; ?>">
<input type="hidden" name="code" id="code" value="Wb">
<input type="hidden" name="s_permission" id="s_permission" value="<?php echo $s_permission; ?>">

<div class="card">
	<div class="card-header">
		<div class="form-inline text-danger ">คำชี้แจง : เลือก
			<div class="checkbox">
				<label>
					<input name="1" id="1" type="checkbox" value="0" checked disabled>
					<span class="cr1"><i class="cr-icon fas fa-check color-ewt"></i></span>
				</label>
			</div>หมวดข่าวที่ท่านต้องการที่จะให้สิทธิ์การเข้าถึงแก่ผู้ใช้งานระบบ
		</div>
	</div>
	<div class="scrollbar scrollbar-near-moon thin">
		<div class="card-body">
			<table width="100%" border="0" cellpadding="3" cellspacing="0" bgcolor="#CCCCCC">
				<tr bgcolor="#FFFFFF">
					<td><strong>ตั้งค่า</strong></td>
				</tr>
				<!--<tr bgcolor="#FFFFFF" > 
				<?php
				/*$sql_sadmin = $db->query_db("SELECT * FROM permission WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = '".$ptype."' AND s_permission = 's'  AND myFlag = '$myFlag' AND s_id = ' ' ",$EWT_DB_USER);
				if($db->db_num_rows($sql_sadmin) > 0)
				{
						$decho = "disabled";
						$check = "checked";
					}else{
						$decho = "";
						$check = "";
					}*/
				?>
				<td >&nbsp;<input type="checkbox" name="chk2" id="chk2" value="0"  <?php echo $check; ?> onClick="updates(this,'s',' ');">  บริหารผู้เชี่ยวชาญ </td>
				</tr>		
				<tr bgcolor="#FFFFFF" > 
				<?php
				/*$sql_sadmin = $db->query_db("SELECT * FROM permission WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = '".$ptype."' AND s_permission = 'c'  AND myFlag = '$myFlag' AND s_id = ' ' ",$EWT_DB_USER);
				if($db->db_num_rows($sql_sadmin) > 0)
				{
					$decho = "disabled";
					$check = "checked";
				}
				else
				{
					$decho = "";
					$check = "";
				}*/
				?>
				<td>&nbsp;
				<input type="checkbox" name="chk4" id="chk4" value="0"  <?php echo $check;  ?> onClick="updates(this,'c',' ');">  การตั้งค่าเว็บบอร์ด   
				</td>
				</tr>
					
				<tr bgcolor="#FFFFFF" > 
				<?php
				/*$sql_sadmin = $db->query_db("SELECT * FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = '".$ptype."' AND s_permission = 'e'  AND myFlag = '$myFlag' AND s_id = ' ' ",$EWT_DB_USER);
					if($db->db_num_rows($sql_sadmin) > 0){
						$decho = "disabled";
						$check = "checked";
					}else{
						$decho = "";
						$check = "";
					}*/
				?>
					<td >&nbsp; <input type="checkbox" name="chk5" id="chk5" value="0"  <?php echo $check;  ?> onClick="updates(this,'e',' ');">  บริหารรูปภาพแสดงอารมณ์   </td>
					</tr>	
					<tr bgcolor="#FFFFFF" > 
				<?php
				/*$sql_sadmin = $db->query_db("SELECT * FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = '".$ptype."' AND s_permission = 'p'  AND myFlag = '$myFlag' AND s_id = ' ' ",$EWT_DB_USER);
					if($db->db_num_rows($sql_sadmin) > 0){
						$decho = "disabled";
						$check = "checked";
					}else{
						$decho = "";
						$check = "";
					}*/
				?>
					<td >&nbsp; <input type="checkbox" name="chk6" id="chk6" value="0"  <?php echo $check;  ?> onClick="updates(this,'p',' ');"> บริหารชื่อห้ามใช้  </td>
					</tr>-->
				<tr>
					<td>
						<hr>
						<?php
						$sql = $db->query("SELECT * FROM w_cate ORDER BY c_id ASC ");
						$count_len = $db->db_num_rows($sql);
						?>
						<table width="100%" class="table table-bordered">
							<tr align="center">
								<td width="10%" nowrap>บริหารหมวด</td>
								<!--<td width="10%">อนุมัติกระทู้</td>
								<td width="10%" nowrap>บริหารผู้ดูแลกระทู้</td>-->
								<td width="70%">หมวดกระทู้</td>
							</tr>
							<!--<tr align="center"> 
									<td>
									<?php
										/*  $sql_sadmin = $db->query_db("SELECT * FROM permission WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = '".$ptype."' AND s_permission = 'g'  AND myFlag = '$myFlag' AND s_id = '0'  ",$EWT_DB_USER);
										if($db->db_num_rows($sql_sadmin) > 0){
											$g_decho = "disabled";
											$check = "checked";
										}else{
											$g_decho = "";
											$check = "";
										}*/
										?>
							<input type="checkbox" name="chk_g0" id="chk_g0" value="0"  <?php echo $check;  ?> onClick="chkdis(this,'g','0','g',<?php echo $count_len ?>); ">
							</td>
							<!--<td>
							<?php
							/*  $sql_sadmin = $db->query_db("SELECT * FROM permission WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = '".$ptype."' AND s_permission = 'a'  AND myFlag = '$myFlag' AND s_id = '0'  ",$EWT_DB_USER);
											if($db->db_num_rows($sql_sadmin) > 0){
												$a_decho = "disabled";
												$check = "checked";
											}else{
												$a_decho = "";
												$check = "";
											}*/
							?>
								<input type="checkbox" name="chk_a0" id="chk_a0" value="0"  <?php echo $check;  ?> onClick="chkdis(this,'a','0','a',<?php echo $count_len ?>); ">
								</td>->
								<td>
							<?php
							/*  $sql_sadmin = $db->query_db("SELECT * FROM permission WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = '".$ptype."' AND s_permission = 'm'  AND myFlag = '$myFlag' AND s_id = '0' ",$EWT_DB_USER);
											if($db->db_num_rows($sql_sadmin) > 0){
												$m_decho = "disabled";
												$check = "checked";
											}else{
												$m_decho = "";
												$check = "";
											}*/
							?> 
							<input type="checkbox" name="chk_m0" id="chk_m0" value="0"  <?php echo $check;  ?> onClick="chkdis(this,'m','0','m',<?php echo $count_len ?>); ">
							</td>
							<td align="left">ทั้งหมด</td>
							</tr>-->
							<?php
							$i = 1;
							while ($U = $db->db_fetch_array($sql)) {
								if ($a_rows_sup == 0) {
									$s_chk = (in_array($U['c_id'], $s_data)) ? 'checked="checked"' : '';
								} else {
									$s_chk = 'checked="checked"';
								} 
							?>
								<tr align="center" bgcolor="#FFFFFF">
									<td>
										<div class="checkbox">
											<label>
												<input type="checkbox" <?php echo $s_chk; ?> id="c_cate<?php echo $U['c_id']; ?>" name="c_cate[<?php echo $U['c_id']; ?>]" value="<?php echo $U['c_id']; ?>" />
												<span class="cr1"><i class="cr-icon fas fa-check color-ewt"></i></span>
											</label>
										</div>
										<!--<input type="checkbox" name="chk_g<?php echo $i; ?>" id="chk_g<?php echo $i; ?>" value="<?php echo $U['c_id']; ?>"  <?php echo $check;  ?> onClick="updates(this,'g','<?php echo $U[c_id]; ?>');" <?php echo $g_decho; ?>>-->
									</td>
									<!--<td>
									<div class="checkbox"> 
									<label>
									<input type="checkbox" <?php echo $check; ?>  id="chk_a<?php echo $_item['c_id']; ?>" name="chk_a[<?php echo $_item['c_id']; ?>]"  value="<?php echo $_item['c_id']; ?>" />
									<span class="cr1"><i class="cr-icon fas fa-check color-ewt"></i></span>
									</label>
									</div>-->
									<!--<input type="checkbox" name="chk_a<?php echo $i; ?>" id="chk_a<?php echo $i; ?>" value="<?php echo $U[c_id]; ?>"  <?php echo $check;  ?> onClick="updates(this,'a','<?php echo $U[c_id]; ?>');" <?php echo $a_decho; ?>>-->
									<!--</td>
									<td>
									<input type="checkbox" name="chk_m<?php echo $i; ?>" id="chk_m<?php echo $i; ?>" value="<?php echo $U[c_id]; ?>"  <?php echo $check;  ?> onClick="updates(this,'m','<?php echo $U[c_id]; ?>');" <?php echo $m_decho; ?>>
									</td>-->
									<td align="left"><?php echo $U[c_name] ?></td>
								</tr>
							<?php
								$i++;
							}
							?>
						</table>
					</td>
				</tr>
			</table>

		</div>
	</div>
</div>

<script src="../js/Tree-Generator-jQuery-Bonsai/jquery.qubit.js"></script>
<link href="../js/Tree-Generator-jQuery-Bonsai/jquery.bonsai.css" rel="stylesheet">
<script src="../js/Tree-Generator-jQuery-Bonsai/jquery.bonsai.js"></script>
<!--<script type='text/javascript' src='../js/jquery-ui-1.10.3.custom/js/jquery-1.9.1.js'></script>
<script type='text/javascript' src='../js/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.min.js'></script>
<link rel="stylesheet" type="text/css" href="../js/jquery-ui-1.10.3.custom/development-bundle/themes/base/jquery-ui.css" media="all" />-->
<script>
	//$('#ditp_tree').bonsai();
	$('#ditp_tree').bonsai({
		expandAll: true,
		checkboxes: true // depends on jquery.qubit plugin
		//createInputs: 'checkbox' // takes values from data-name and data-value, and data-name is inherited
	});
	$(document).ready(function() {
		$('#chk0').change(function() {
			var name = $(this).attr('name');
			$('input:checkbox[name=' + name + ']').prop('checked', $(this).prop('checked'));

			if ($(this).is(':checked') == true) {
				$('input:checkbox[name=' + name + ']:checked').attr("disabled", true);
				$('#chk0').attr("disabled", false);
			} else if ($(this).is(':checked') == false) {
				$('input:checkbox[name=' + name + ']').attr("disabled", false);
			}
			//console.log(v);
		});

		/*jQuery("#ditp_tree ul").hide();	
		$("#ditp_tree li").each(function() {
		        var handleSpan = jQuery("<span></span>").addClass("handle").prependTo(this);

		        if(jQuery("ul", this).size() > 0) {
		            handleSpan.addClass("collapsed").click(function() {
		                jQuery(this).toggleClass("expanded").siblings("ul").toggle();
		            });
		        }
		    });*/
	});
</script>
<style>
</style>