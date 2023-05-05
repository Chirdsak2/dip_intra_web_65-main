<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
function GenLen($data,$op){
$s = explode($op,$data);
return count($s);
}
function GenPic($data){
$s = explode("_",$data);
	for($i=1;$i<count($s);$i++){
		echo "<img src=\"../images/o.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\">";
	}
}

if($_POST["Flag"] == "Move" AND $_POST["newpos"] != ""){
	$sql_chk  = $db->query("SELECT parent_org_id FROM org_name WHERE org_id = '".$_POST["org_id"]."' ");
	$M = $db->db_fetch_row($sql_chk);
	$sql_child = $db->query("SELECT org_id,parent_org_id FROM org_name WHERE parent_org_id != '".$M[0]."' AND parent_org_id LIKE '".$M[0]."%' ORDER BY parent_org_id ASC");
  	$org = array();
	$orgp = array();
	$len = strlen($M[0]);
	while($C = $db->db_fetch_row($sql_child)){
	$pos = substr($C[1], $len);
	array_push ($org,$C[0]);
	array_push ($orgp,$pos);
	$db->query("UPDATE org_name SET parent_org_id = '' WHERE org_id = '".$C[0]."' ");
	}
  $db->query("UPDATE org_name SET parent_org_id = ''  WHERE org_id = '".$_POST["org_id"]."' ");
  $len = GenLen($M[0],"_");
$len--;
$numr = strlen($M[0]);
$rest = substr($M[0], 0, -4);

	if($EWT_DB_TYPE == "MYSQL"){
		$sql = $db->query("SELECT * FROM org_name WHERE parent_org_id LIKE '$rest%' AND parent_org_id > '".$M[0]."'  AND length(parent_org_id) >= '$numr' ORDER BY parent_org_id ASC");
	}elseif($EWT_DB_TYPE == "MSSQL"){
		$sql = $db->query("SELECT * FROM org_name WHERE parent_org_id LIKE '$rest%' AND parent_org_id > '".$M[0]."'  AND len(parent_org_id) >= '$numr' ORDER BY parent_org_id ASC");
	}

while($R = $db->db_fetch_array($sql)){
$data = explode("_",$R[parent_org_id]);
$num_array = count($data);
$field_change = $data[$len]-1;
$field_change = sprintf("%04d",$field_change);
$total = "";
for($i=0;$i<$num_array;$i++){
if($i == $len ){
$total .= $field_change."_";
}else{
$total .= $data[$i]."_";
}
 }
 $total = substr($total, 0, -1);
$sel = "UPDATE org_name SET parent_org_id = '$total' WHERE org_id = '$R[org_id]' ";
$db->query($sel);
}
  
  // แทรก
  
$len = GenLen($_POST["newpos"],"_");
$len--;
$numr = strlen($_POST["newpos"]);
$rest = substr($_POST["newpos"], 0, -4);

	if($EWT_DB_TYPE == "MYSQL"){
		$sql = $db->query("SELECT * FROM org_name WHERE parent_org_id LIKE '$rest%' AND parent_org_id > '".$_POST["newpos"]."' AND length(parent_org_id) >= '$numr' ORDER BY parent_org_id DESC");
	}elseif($EWT_DB_TYPE == "MSSQL"){
		$sql = $db->query("SELECT * FROM org_name WHERE parent_org_id LIKE '$rest%' AND parent_org_id > '".$_POST["newpos"]."' AND len(parent_org_id) >= '$numr' ORDER BY parent_org_id DESC");
	}

	while($R = $db->db_fetch_array($sql)){
		$sqlR = $db->query("SELECT parent_org_id FROM org_name WHERE parent_org_id LIKE '".$_POST["newpos"]."%' AND parent_org_id = '$R[parent_org_id]' ");
			if(!$tttt = $db->db_num_rows($sqlR)){
				$data = explode("_",$R[parent_org_id]);
				$num_array = count($data);
				$field_change = $data[$len]+1;
				$field_change = sprintf("%04d",$field_change);
				$total = "";
						for($i=0;$i<$num_array;$i++){
							if($i == $len ){
								$total .= $field_change."_";
							}else{
								$total .= $data[$i]."_";
							}
						 }
				$total = substr($total, 0, -1);
			$sel = "UPDATE org_name SET parent_org_id = '$total' WHERE org_id = '$R[org_id]'  ";
			$db->query($sel);
		}
	}

$m = explode($rest,$_POST["newpos"]);
$Nmenu = $m[1]+1;
$gen_menu = $rest.sprintf("%04d",$Nmenu);

  $db->query("UPDATE org_name SET parent_org_id = '$gen_menu'  WHERE org_id = '".$_POST["org_id"]."' ");
  $n = count($org);
  for($i=0;$i<$n;$i++){
  $oid = $org[$i];
  $pid = $gen_menu.$orgp[$i];
  $db->query("UPDATE org_name SET parent_org_id = '$pid'  WHERE org_id = '$oid' ");
  }
  ?>
  <script language="JavaScript" type="text/javascript">
  window.opener.location.reload();
  window.close();
  </script>
  <?php
  exit;
  
  }else{


$sql_group = $db->query("SELECT * FROM org_name ORDER BY parent_org_id ASC");
$sql_check = $db->query("SELECT name_org,parent_org_id FROM org_name WHERE org_id = '".$_GET["org_id"]."' ");
$M = $db->db_fetch_row($sql_check);



include("../lib/config_path.php");
include("../header.php");
	?>
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<?php include('link.php'); ?>
<style type="text/css">
<!--
.head_table { 
	border-bottom:"buttonshadow solid 1px";
	border-left:"buttonhighlight solid 1px";
	border-right:"buttonshadow solid 1px";
	border-top:"buttonhighlight solid 1px";
	}
-->
</style>
<script >
function divshow(c,d){
	if(c.style.display == ""){
	c.style.display = 'none';
	d.src = "../images/plus.gif";
	}else{
		c.style.display = '';
	d.src = "../images/minus.gif";
	}
}
function divshow1(c){
	if(c.style.display == ""){
	c.style.display = 'none';
	}else{
		c.style.display = '';
	}
}
	function choose(c){
		document.form1.inc.value = c;
		form1.submit();
		top.close();
	}
	function Moveto(c){
	if(confirm("คุณต้องการย้ายหน่วยงานหรือไม่?")){
		document.form1.newpos.value = c;
		form1.submit();
		}
	}
</script>
</head>
<body leftmargin="0" topmargin="0">
<form name="form1" method="post" action="move_list.php">&nbsp;&nbsp;<span class="ewthead">ย้ายหน่วยงาน <?php echo $M[0]; ?> ไปยัง </span>

<input name="Flag" type="hidden" id="Flag" value="Move"><input name="org_id" type="hidden" id="org_id" value="<?php echo $_GET["org_id"]; ?>"><input name="newpos" type="hidden" id="newpos" value="">

<hr size="1">
</form>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr> 
                        <td valign="top"> 
                          <?php
  $i = 0;
  $k = 0;
  $LenChk =0;
  	while($R = $db->db_fetch_array($sql_group)){
	$sql_sub = $db->query("SELECT COUNT(org_id) FROM org_name WHERE parent_org_id LIKE '".$R["parent_org_id"]."_%'");
	$count_sub = $db->db_fetch_row($sql_sub);
	
	
				$len = GenLen($R["parent_org_id"],"_");
		
			if($LenChk > $len ){
				for($y=$len;$y<$LenChk;$y++){
					echo "</div>";
			}
		}
		  $LenChk = $len;
  ?>
                          
      <div> 
        <?php
		  		GenPic($R["parent_org_id"]);
		   if($count_sub[0] > 0){ ?>
        <img src="../images/plus.gif" border="0" align="absmiddle" onClick="divshow(document.all.dv<?php echo $i; ?>,this)"> 
        <?php }else{ ?>
        <img src="../images/o.gif" width="20" height="20" border="0" align="absmiddle"> 
        <?php } ?>
		<?php
		$sql_move = $db->query("SELECT org_id FROM org_name WHERE org_id = '".$R[org_id]."' AND parent_org_id LIKE '".$M[1]."%' ");
		$MC = $db->db_num_rows($sql_move);
		?>
        <?php if($k!=0 AND $MC ==0){ ?><a href="#move" onClick="Moveto('<?php echo $R["parent_org_id"]; ?>')" onMouseOver="document.all.showsp<?php echo $k; ?>.style.display='';" onMouseOut="document.all.showsp<?php echo $k; ?>.style.display='none';"><?php } ?><img src="../images/user_group.gif" width="20" height="20" border="0" align="absmiddle">&nbsp;<?php echo $R["name_org"]; ?>
        <?php if($k!=0 AND $MC ==0){ ?></a><br><span id="showsp<?php echo $k; ?>" style="display:none"> 
        <?php GenPic($R["parent_org_id"]); ?>
        <img src="../images/o.gif" width="20" height="20" border="0" align="absmiddle"> 
        <img src="../images/user_group_insert.gif" width="40" height="20" border="0" align="absmiddle"> 
        <font color="#999999">ย้ายมาต่อจาก<?php echo $R["name_org"]; ?></font></span> <?php } ?>
      </div>
                          <?php
	   $k++;
		   ?>
                          <?php  if($count_sub[0] > 0){ echo "<div id=\"dv".$i."\"  style=\"display:none\">"; }  ?>
                          <?php 
	
   $i++; } ?>
                        </td>
                      </tr>
                      <input name="alli" type="hidden" value="<?php echo $k; ?>">
                    </table>
</body>
</html>
<?php
}
 $db->db_close(); ?>
