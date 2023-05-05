<?php
session_start();
header ("Content-Type:text/plain;charset=UTF-8");
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
function countparent($c,$ppms){
global $db,$y;

$sql = $db->query_db("SELECT c_parent FROM article_group WHERE c_id = '$c'   ",$_SESSION["EWT_SDB"]);
  while($U = $db->db_fetch_array($sql)){
	$c = countparent($U["c_parent"],$ppms);
	$y += $c;
	$sql2 = $db->query_db("SELECT s_id FROM permission WHERE p_type = 'U' AND pu_id = '".$_SESSION["EWT_SMID"]."' AND UID = '".$_SESSION["EWT_SUID"]."' 
	AND (
	   (s_type = 'Ag' AND s_permission = '".$ppms."'  AND s_id = '".$U["c_parent"]."' ) 
	  ) ",$EWT_DB_USER);
	if($db->db_num_rows($sql2) > 0){
	$y++;
	}
  }
  $db->query("use ".$_SESSION["EWT_SDB"]);
  return $y;
}
 $pass_a='';
  $y = 0; //  y  เป็นตัวแปร global มีการใช้งานแล้วต้องเคลียร์ค่าทิ้งก่อน
  if($db->check_permission("Ag","a","0") or $db->check_permission("Ag","a",$_GET["cid"])){
     $pass_a='Y';
 }else{
   if(countparent($_GET[cid],"a")>0){
   		$pass_a='Y';
   }
 }
 if($pass_a == 'Y'){ 
	
?>
<script type="text/javascript" language="JavaScript">
alert('rrrr');
		if(confirm('Are you sure to approve selected article?')){
		document.all.form1.approve_user.value = 'Y';
		}else{
		document.all.form1.approve_user.value = '';
		}
</script>
<?php
}
?>
<?php $db->db_close(); ?>