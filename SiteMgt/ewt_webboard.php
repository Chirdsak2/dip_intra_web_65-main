<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
$mid = $_GET["mid"];
$mtype  = $_GET["mtype"];
$UID = $_SESSION["EWT_SUID"];
$ptype = "webboard";
$myFlag = $_GET["myFlag"];

?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script src="../js/AjaxRequest.js"></script>
<script src="../js/excute.js"></script>
<script language="JavaScript" >
function updates(c,ppms,psid){
	if(c.checked == true){
	var	url='ewt_upd_ajax.php?UID=<?php echo $UID; ?>&mid=<?php echo $mid; ?>&mtype=<?php echo $mtype; ?>&myFlag=<?php echo $myFlag; ?>&accept=Y&ptype=<?php echo $ptype; ?>&psid=' + psid + '&ppms=' + ppms;
	}else{
	var	url='ewt_upd_ajax.php?UID=<?php echo $UID; ?>&mid=<?php echo $mid; ?>&mtype=<?php echo $mtype; ?>&myFlag=<?php echo $myFlag; ?>&accept=N&ptype=<?php echo $ptype; ?>&psid=' + psid + '&ppms=' + ppms ;
	}

	AjaxRequest.get(
		{
			'url':url
			,'onLoading':function() { }
			,'onLoaded':function() { }
			,'onInteractive':function() { }
			,'onComplete':function() { }
			,'onSuccess':function(req) { 
					document.all.divhtml.innerHTML = req.responseText; 
			}
		}
	);
	//advto(g);
}

function chkdis(c,ppms,psid,start,len){
var num = len;
var st = 1;
	for(i=st;i<=num;i++){
		if(c.checked == true){
			document.getElementById('chk_'+start+i).disabled = true;
			if(document.getElementById('chk_'+start+i).checked == true){
			document.getElementById('chk_'+start+i).checked =  false;
			updates(document.getElementById('chk_'+start+i),start,document.getElementById('chk_'+start+i).value);
			}
		}else{
			document.getElementById('chk_'+start+i).disabled = false;
		}
	}
	updates(c,ppms,psid);
}
</script>
</head>
<body>
<span id="divhtml" style="display:none"></span>
  
<table width="100%" border="0" cellpadding="3" cellspacing="0" bgcolor="#CCCCCC">
  <form name="form1" method="post" action="">
    <tr bgcolor="#FFFFFF" > 
      <td ><strong>ตั้งค่า</strong></td>
    </tr>
    <tr bgcolor="#FFFFFF" > 
      <?php
	  $sql_sadmin = $db->query_db("SELECT * FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = '".$ptype."' AND s_permission = 's'  AND myFlag = '$myFlag' AND s_id = ' ' ",$EWT_DB_USER);
	if($db->db_num_rows($sql_sadmin) > 0){
		$decho = "disabled";
		$check = "checked";
	}else{
		$decho = "";
		$check = "";
	}
	?>
      <td >&nbsp; <input type="checkbox" name="chk2" id="chk2" value="0"  <?php echo $check;  ?> onClick="updates(this,'s',' ');">  บริหารผู้เชี่ยวชาญ </td>
    </tr>
		
    <tr bgcolor="#FFFFFF" > 
      <?php
	  $sql_sadmin = $db->query_db("SELECT * FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = '".$ptype."' AND s_permission = 'c'  AND myFlag = '$myFlag' AND s_id = ' ' ",$EWT_DB_USER);
	if($db->db_num_rows($sql_sadmin) > 0){
		$decho = "disabled";
		$check = "checked";
	}else{
		$decho = "";
		$check = "";
	}
	?>
      <td >&nbsp; <input type="checkbox" name="chk4" id="chk4" value="0"  <?php echo $check;  ?> onClick="updates(this,'c',' ');">  การตั้งค่าเว็บบอร์ด   </td>
    </tr>
		
	
    <tr bgcolor="#FFFFFF" > 
      <?php
	  $sql_sadmin = $db->query_db("SELECT * FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = '".$ptype."' AND s_permission = 'e'  AND myFlag = '$myFlag' AND s_id = ' ' ",$EWT_DB_USER);
	if($db->db_num_rows($sql_sadmin) > 0){
		$decho = "disabled";
		$check = "checked";
	}else{
		$decho = "";
		$check = "";
	}
	?>
      <td >&nbsp; <input type="checkbox" name="chk5" id="chk5" value="0"  <?php echo $check;  ?> onClick="updates(this,'e',' ');">  บริหารรูปภาพแสดงอารมณ์   </td>
    </tr>
		
	
    <tr bgcolor="#FFFFFF" > 
      <?php
	  $sql_sadmin = $db->query_db("SELECT * FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = '".$ptype."' AND s_permission = 'p'  AND myFlag = '$myFlag' AND s_id = ' ' ",$EWT_DB_USER);
	if($db->db_num_rows($sql_sadmin) > 0){
		$decho = "disabled";
		$check = "checked";
	}else{
		$decho = "";
		$check = "";
	}
	?>
      <td >&nbsp; <input type="checkbox" name="chk6" id="chk6" value="0"  <?php echo $check;  ?> onClick="updates(this,'p',' ');"> บริหารชื่อห้ามใช้  </td>
    </tr>
	<tr bgcolor="#FFFFFF">
		<td>
		<hr>	<?php
			 $sql = $db->query_db("SELECT * FROM w_cate   ORDER BY c_id ASC",$_SESSION["EWT_SDB"]);
			 $count_len=$db->db_num_rows($sql);
			 ?>
		<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
		  <tr align="center"> 
		     <td width="10%" nowrap>บริหารหมวด</td>
		     <td width="10%">อนุมัติ</td>
		     <td width="10%" nowrap>บริหารผู้ดูแลกระทู้</td>
		     <td width="70%">หมวด</td>
	     </tr>
		  <tr align="center"  bgcolor="#FFFFFF"> 
		     <td>
			  <?php
				  $sql_sadmin = $db->query_db("SELECT * FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = '".$ptype."' AND s_permission = 'g'  AND myFlag = '$myFlag' AND s_id = '0'  ",$EWT_DB_USER);
				if($db->db_num_rows($sql_sadmin) > 0){
					$g_decho = "disabled";
					$check = "checked";
				}else{
					$g_decho = "";
					$check = "";
				}
				?><input type="checkbox" name="chk_g0" id="chk_g0" value="0"  <?php echo $check;  ?> onClick="chkdis(this,'g','0','g',<?php echo $count_len?>); ">
			 </td>
		     <td>
			 <?php
				  $sql_sadmin = $db->query_db("SELECT * FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = '".$ptype."' AND s_permission = 'a'  AND myFlag = '$myFlag' AND s_id = '0'  ",$EWT_DB_USER);
				if($db->db_num_rows($sql_sadmin) > 0){
					$a_decho = "disabled";
					$check = "checked";
				}else{
					$a_decho = "";
					$check = "";
				}
				?><input type="checkbox" name="chk_a0" id="chk_a0" value="0"  <?php echo $check;  ?> onClick="chkdis(this,'a','0','a',<?php echo $count_len?>); ">
			 </td>
		     <td>
			  <?php
				  $sql_sadmin = $db->query_db("SELECT * FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = '".$ptype."' AND s_permission = 'm'  AND myFlag = '$myFlag' AND s_id = '0' ",$EWT_DB_USER);
				if($db->db_num_rows($sql_sadmin) > 0){
					$m_decho = "disabled";
					$check = "checked";
				}else{
					$m_decho = "";
					$check = "";
				}
				?> <input type="checkbox" name="chk_m0" id="chk_m0" value="0"  <?php echo $check;  ?> onClick="chkdis(this,'m','0','m',<?php echo $count_len?>); ">
			 </td>
		     <td align="left">ทั้งหมด</td>
	     </tr>
		 
		 
		 
		 <?php

		 $i=1;
		  while($U = $db->db_fetch_array($sql)){
		 ?>
		 
		 <tr align="center"  bgcolor="#FFFFFF"> 
		     <td>
			  <?php
				  $sql_sadmin = $db->query_db("SELECT * FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = '".$ptype."' AND s_permission = 'g'  AND myFlag = '$myFlag' AND s_id = '".$U[c_id]."'  ",$EWT_DB_USER);
				if($db->db_num_rows($sql_sadmin) > 0){
					$check = "checked";
				}else{
					$check = "";
				}
				?><input type="checkbox" name="chk_g<?php echo $i;?>" id="chk_g<?php echo $i;?>" value="<?php echo $U[c_id]; ?>"  <?php echo $check;  ?> onClick="updates(this,'g','<?php echo $U[c_id]; ?>');" <?php echo $g_decho;?>>
			 </td>
		     <td>
			 <?php
				  $sql_sadmin = $db->query_db("SELECT * FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = '".$ptype."' AND s_permission = 'a'  AND myFlag = '$myFlag' AND s_id = '".$U[c_id]."'  ",$EWT_DB_USER);
				if($db->db_num_rows($sql_sadmin) > 0){
					$check = "checked";
				}else{
					$check = "";
				}
				?><input type="checkbox" name="chk_a<?php echo $i;?>" id="chk_a<?php echo $i;?>" value="<?php echo $U[c_id]; ?>"  <?php echo $check;  ?> onClick="updates(this,'a','<?php echo $U[c_id]; ?>');" <?php echo $a_decho;?>>
			 </td>
		     <td>
			  <?php
				  $sql_sadmin = $db->query_db("SELECT * FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = '".$ptype."' AND s_permission = 'm'  AND myFlag = '$myFlag' AND s_id = '".$U[c_id]."' ",$EWT_DB_USER);
				if($db->db_num_rows($sql_sadmin) > 0){
					$check = "checked";
				}else{
					$check = "";
				}
				?> <input type="checkbox" name="chk_m<?php echo $i;?>" id="chk_m<?php echo $i;?>" value="<?php echo $U[c_id]; ?>"  <?php echo $check;  ?> onClick="updates(this,'m','<?php echo $U[c_id]; ?>');" <?php echo $m_decho;?>>
			 </td>
		     <td align="left"><?php echo $U[c_name] ?></td>
	     </tr>
		 <?php 
		 $i++;
		 } ?>
		 
		 
		 
		</table>
		</td>
	</tr>
	
		

	
  </form>
</table>
</body>
</html>
<?php
$db->db_close();
?>
